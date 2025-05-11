<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\CardType;
use App\Models\Category;
use App\Models\Message;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class MessageAppController extends Controller
{
    /**
     * Show the form for creating a new message - Step 1
     */
    public function createStep1()
    {
        $mainCategories = Category::whereNull('parent_id')->where('is_active', true)->get();
        $dedicationTypes = CardType::all();
        $languages = ['ar' => 'العربية', 'en' => 'English'];
        
        // Get any existing session data for this step
        $sessionData = Session::get('message_step1', []);
        
        return view('app.messages.create_step1', compact(
            'mainCategories', 
            'dedicationTypes', 
            'languages',
            'sessionData'
        ));
    }
    
    /**
     * Process Step 1 data and move to Step 2
     */
    public function postStep1(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'recipient_language' => 'required|in:ar,en',
            'main_category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:categories,id',
            'dedication_type_id' => 'required|exists:card_types,id',
            'card_number' => 'required|string|size:4|regex:/^\d{4}$/',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Store in session
        Session::put('message_step1', $request->all());
        
        // Redirect to step 2
        return redirect()->route('app.messages.create.step2');
    }
    
    /**
     * Show the form for creating a new message - Step 2
     */
    public function createStep2()
    {
        // Check if step 1 was completed
        if (!Session::has('message_step1')) {
            return redirect()->route('app.messages.create.step1')
                ->with('error', 'يرجى إكمال الخطوة الأولى أولا');
        }
        
        // Get step 1 data
        $step1Data = Session::get('message_step1');
        $sessionData = Session::get('message_step2', []);
        
        // Get cards based on step 1 selections
        $cards = Card::where('sub_category_id', $step1Data['sub_category_id'])
            ->where('card_type_id', $step1Data['dedication_type_id'])
            ->where('is_active', true)
            ->get();
        
        return view('app.messages.create_step2', compact('cards', 'step1Data', 'sessionData'));
    }
    
    /**
     * Process Step 2 data and move to Step 3
     */
    public function postStep2(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'card_id' => 'required|exists:cards,id',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Store in session
        Session::put('message_step2', $request->all());
        
        // Redirect to step 3
        return redirect()->route('app.messages.create.step3');
    }
    
    /**
     * Show the form for creating a new message - Step 3
     */
    public function createStep3()
    {
        // Check if previous steps were completed
        if (!Session::has('message_step1') || !Session::has('message_step2')) {
            return redirect()->route('app.messages.create.step1')
                ->with('error', 'يرجى إكمال الخطوات السابقة أولا');
        }
        
        // Get session data
        $sessionData = Session::get('message_step3', []);
        
        // Lock types for the form
        $lockTypes = [
            'no_lock' => 'لا',
            'lock_without_heart' => 'نعم بدون قفل قلب',
            'lock_with_heart' => 'نعم مع قفل قلب'
        ];
        
        return view('app.messages.create_step3', compact('lockTypes', 'sessionData'));
    }
    
    /**
     * Process Step 3 data and move to Step 4
     */
    public function postStep3(Request $request)
    {
        // Validation rules
        $rules = [
            'lock_type' => 'required|in:no_lock,lock_without_heart,lock_with_heart',
            'message_content' => 'required|string|max:500',
            'recipient_name' => 'required|string|max:255',
        ];
       
        // Add recipient fields validation if lock type is not 'no_lock'
        if ($request->lock_type !== 'no_lock') {
            $rules['recipient_phone'] = [
                'required',
                'string',
                'max:20',
                function ($attribute, $value, $fail) use ($request) {
                    // Combine country code and phone number
                    $fullNumber = $request->recipient_country_code . $value;
                   
                    // Basic phone number validation (adjust as needed)
                    if (!preg_match('/^\+?[0-9]{8,15}$/', $fullNumber)) {
                        $fail('رقم الهاتف غير صالح. يجب أن يتكون من أرقام فقط وبطول مناسب.');
                    }
                }
            ];
            $rules['recipient_country_code'] = 'required|string|max:10';
            $rules['scheduled_at'] = 'nullable|date';
        }
       
        // Validate the input
        $validator = Validator::make($request->all(), $rules);
       
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
       
        // Get all data from the request
        $data = $request->all();
       
        // Combine country code and phone number for recipient if not 'no_lock'
        if ($request->lock_type !== 'no_lock') {
            // Create combined phone field for database in format "9715012345678"
            $data['recipient_phone'] = $request->recipient_country_code . $request->recipient_phone;
           
            // We can remove the country code from the data since it's now part of the phone number
            // But keeping it for backwards compatibility if needed elsewhere
        }
       
        // Store in session
        Session::put('message_step3', $data);
       
        // Redirect to step 4 (review)
        return redirect()->route('app.messages.create.step4');
    }
    /**
     * Show the form for creating a new message - Step 4 (Review)
     */
    public function createStep4()
    {
        // Check if all previous steps were completed
        if (!Session::has('message_step1') || !Session::has('message_step2') || !Session::has('message_step3')) {
            return redirect()->route('app.messages.create.step1')
                ->with('error', 'يرجى إكمال الخطوات السابقة أولا');
        }
        
        // Get all session data
        $step1Data = Session::get('message_step1');
        $step2Data = Session::get('message_step2');
        $step3Data = Session::get('message_step3');
        
        // Get additional information for display
        $mainCategory = Category::find($step1Data['main_category_id']);
        $subCategory = Category::find($step1Data['sub_category_id']);
        $dedicationType = CardType::find($step1Data['dedication_type_id']);
        $card = Card::find($step2Data['card_id']);
        
        // Lock types for display
        $lockTypes = [
            'no_lock' => 'لا',
            'lock_without_heart' => 'نعم بدون قفل قلب',
            'lock_with_heart' => 'نعم مع قفل قلب'
        ];
        
        // Languages for display
        $languages = ['ar' => 'العربية', 'en' => 'English'];
        
        return view('app.messages.create_step4', compact(
            'step1Data', 
            'step2Data', 
            'step3Data',
            'mainCategory',
            'subCategory',
            'dedicationType',
            'card',
            'lockTypes',
            'languages'
        ));
    }
    
    /**
     * Process the final submission and store the message
     */
    public function store(Request $request)
    {
        // Check if all steps were completed
        if (!Session::has('message_step1') || !Session::has('message_step2') || !Session::has('message_step3')) {
            return redirect()->route('app.messages.create.step1')
                ->with('error', 'يرجى إكمال جميع الخطوات أولا');
        }
        
        // Get all session data
        $step1Data = Session::get('message_step1');
        $step2Data = Session::get('message_step2');
        $step3Data = Session::get('message_step3');
        
        // Get current user
        $user = Auth::user();
        
        // Verify card number exists and is available
        $cardNumber = $step1Data['card_number'];
        $userId = $user->id;
        
        $paidReadyCards = \App\Models\ReadyCard::where('is_paid', true)
            ->pluck('id');
        
        $cardItem = \App\Models\ReadyCardItem::where('identity_number', $cardNumber)
            ->first();
        
        if (!$cardItem) {
            return redirect()->back()
                ->withErrors(['card_number' => __('Card number not found in your purchased card packs.')])
                ->withInput();
        }
        
        if ($cardItem->status !== 'open') {
            return redirect()->back()
                ->withErrors(['card_number' => __('This card has already been used. Please use another card.')])
                ->withInput();
        }
        
        // Begin database transaction
        DB::beginTransaction();
        
        try {
            // Create message
            $message = new Message();
            $message->recipient_language = $step1Data['recipient_language'];
            $message->main_category_id = $step1Data['main_category_id'];
            $message->sub_category_id = $step1Data['sub_category_id'];
            $message->dedication_type_id = $step1Data['dedication_type_id'];
            $message->card_number = $step1Data['card_number'];
            $message->card_id = $step2Data['card_id'];
            $message->message_content = $step3Data['message_content'];
            $message->recipient_name = $step3Data['recipient_name'];
            $message->lock_type = $step3Data['lock_type'];
            $message->scheduled_at = $step3Data['scheduled_at'] ?? null;
            $message->manually_sent = 1;
            $message->sender_name = auth()->user()->name ? auth()->user()->name : 'Sender';
            $message->sender_phone = auth()->user()->whatsapp ? auth()->user()->whatsapp : '1212121';
            $message->user_id = $user->id;
            $message->ready_card_item_id = $cardItem->id;
            
            // Generate 4-digit message_lock code for opening the message
            $message->message_lock = sprintf('%04d', mt_rand(1000, 9999));
            
            // Generate 3-digit lock_number for either lock type
            $message->lock_number = sprintf('%03d', mt_rand(100, 999));
            
            // Set recipient phone if lock type requires it
            if ($step3Data['lock_type'] !== 'no_lock') {
                $message->recipient_phone = $step3Data['recipient_phone'];
            }
            
            $message->status = 'sent';
            
            $message->save();
            
            // Mark the card as used
            $cardItem->status = 'closed';
            $cardItem->save();
            
            // Send WhatsApp message if there's a recipient phone
            if ($message->lock_type !== 'no_lock' && $message->recipient_phone) {
                // Format recipient phone for WhatsApp
                $recipientPhone = $message->recipient_phone;
                
                // Initialize WhatsApp service
                $whatsAppService = new WhatsAppService();
                
                // Get card image URL
                $card = Card::find($message->card_id);
                $imageUrl = 'https://minalqalb.ae/message.png'; // Default image URL
                
                // Format the scheduled time
                $formattedScheduledTime = '';
                if ($message->scheduled_at) {
                    $dateTime = new \DateTime($message->scheduled_at);
                    $formattedScheduledTime = $dateTime->format('m/d/Y h:i a');
                }
                
                try {
                    if ($message->scheduled_at && strtotime($message->scheduled_at) > time()) {
                        $result = $whatsAppService->sendMinalqalnnewqTemplateHistory(
                            $recipientPhone,
                            $imageUrl,
                            $message->recipient_name,
                            $user->name,
                            $message->message_lock,
                            $formattedScheduledTime
                        );
                    } else {
                        $result = $whatsAppService->sendMinalqalnnewqTemplate(
                            $recipientPhone,
                            $imageUrl,
                            $message->recipient_name,
                            $user->name,
                            $message->message_lock
                        );
                    }
                    
                    // Store WhatsApp response data with message
                    if (isset($result['response']['id'])) {
                        $message->whatsapp_message_id = $result['response']['id'];
                        $message->whatsapp_status = $result['response']['status'] ?? 'unknown';
                        $message->save();
                    }
                } catch (\Exception $whatsappException) {
                    // Continue execution even if WhatsApp fails
                }
            }
            
            // Clear session data
            Session::forget(['message_step1', 'message_step2', 'message_step3']);
            
            DB::commit();
            
            // Redirect to success page
            return redirect()->route('app.messages.create.step5', ['message_id' => $message->id]);
            
        } catch (\Exception $e) {
            // Something went wrong, rollback transaction
            DB::rollBack();
            
            return redirect()->back()
                ->withErrors(['error' => __('An error occurred while creating the message. Please try again.')])
                ->withInput();
        }
    }
    
    /**
     * Show success page - Step 5
     */
    public function createStep5($message_id)
    {
        $message = Message::findOrFail($message_id);
        
        // Calculate points used
        $pointsUsed = 200; // Example amount, adjust as needed
        
        return view('app.messages.create_step5', compact('message', 'pointsUsed'));
    }
    
    /**
     * Get subcategories for a main category via AJAX
     */
    public function getSubcategories($mainCategoryId)
    {
        $subcategories = Category::where('parent_id', $mainCategoryId)
            ->where('is_active', true)
            ->get();
            
        return response()->json($subcategories);
    }
    
    /**
     * Get cards for a subcategory and dedication type via AJAX
     */
    public function getCards(Request $request)
    {
        $subCategoryId = $request->input('sub_category_id');
        $dedicationTypeId = $request->input('dedication_type_id');
        
        $cards = Card::where('category_id', $subCategoryId)
            ->where('card_type_id', $dedicationTypeId)
            ->where('is_active', true)
            ->get();
            
        return response()->json($cards);
    }
}