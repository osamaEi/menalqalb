<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Message;
use App\Models\CardType;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\DedicationType;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        
        if ($user->role == 'sales_point') {
            $messages = Message::where('user_id', $user->id)
                ->with(['mainCategory', 'subCategory',  'card'])
                ->latest()
                ->paginate(10);
        } else {
            $messages = Message::where('user_id', $user->id)
                ->with(['mainCategory', 'subCategory', 'card'])
                ->latest()
                ->paginate(10);
        }
        
        return view('messages.index', compact('messages'));
    }


    public function create()
    {
        $mainCategories = Category::whereNull('parent_id')->where('is_active', true)->get();
        $dedicationTypes = CardType::all();
        $languages = ['ar' => 'العربية', 'en' => 'English'];
        $lockTypes = [
            'no_lock' => 'لا',
            'lock_without_heart' =>'نعم بدون قفل قلب',
            'lock_with_heart' => 'نعم مع قفل قلب'
        ];
        
        $user = Auth::user();
        $isSalesOutlet = $user->role ='sales_point';
        
        return view('messages.create', compact(
            'mainCategories', 
            'dedicationTypes', 
            'languages', 
            'lockTypes',
            'user',
            'isSalesOutlet'
        ));
    }

public function store(Request $request)
{
    $user = Auth::user();
    $isSalesOutlet = $user->role == 'sales_point';
    
    // Validate request data
    $rules = [
        'recipient_language' => 'required|in:ar,en',
        'main_category_id' => 'required|exists:categories,id',
        'sub_category_id' => 'required|exists:categories,id',
        'dedication_type_id' => 'required|exists:card_types,id',
        'card_number' => 'required|string|size:4|regex:/^\d{4}$/',
        'card_id' => 'required|exists:cards,id',
        'message_content' => 'required|string',
        'recipient_name' => 'required|string|max:255',
        'lock_type' => 'required|in:no_lock,lock_without_heart,lock_with_heart',
        'scheduled_at' => 'nullable|date',
        'manually_sent' => 'boolean',
    ];
    
    
    $rules['recipient_phone'] = 'required_if:lock_type,lock_without_heart,lock_with_heart|nullable|string|max:20';
    
    $validator = Validator::make($request->all(), $rules);
    
    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }
    
    
    $cardNumber = $request->card_number;
    $userId = $user->id;
    
    $paidReadyCards = \App\Models\ReadyCard::where('customer_id', $userId)
        ->where('is_paid', true)
        ->pluck('id');
    
    if ($paidReadyCards->isEmpty()) {
        return redirect()->back()
            ->withErrors(['card_number' => __('You do not have any paid card packs. Please purchase a card pack first.')])
            ->withInput();
    }
    
    $cardItem = \App\Models\ReadyCardItem::whereIn('ready_card_id', $paidReadyCards)
        ->where('identity_number', $cardNumber)
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
        $message->recipient_language = $request->recipient_language;
        $message->main_category_id = $request->main_category_id;
        $message->sub_category_id = $request->sub_category_id;
        $message->dedication_type_id = $request->dedication_type_id;
        $message->card_number = $request->card_number;
        $message->card_id = $request->card_id;
        $message->message_content = $request->message_content;
        $message->recipient_name = $request->recipient_name;
        $message->lock_type = $request->lock_type;
        $message->scheduled_at = $request->scheduled_at;
        $message->manually_sent = $request->has('manually_sent');
        $message->sender_name = $user->name;
        $message->sender_phone = $user->phone ? $user->phone : 4546456;
        $message->user_id = $user->id;
        $message->ready_card_item_id = $cardItem->id; // Store reference to the card item
        
        // Generate 4-digit message_lock code for opening the message
        $message->message_lock = sprintf('%04d', mt_rand(1000, 9999));
        
        // Generate 3-digit lock_number for either lock type
        $message->lock_number = sprintf('%03d', mt_rand(100, 999));
        
        // Handle lock type
        if ($request->lock_type !== 'no_lock') {
            $message->recipient_phone = $request->recipient_phone;
         
        }





        $message->status = $request->has('manually_sent') ? 'pending' : 'sent';
        
        $message->save();
        
        // Mark the card as used
        $cardItem->status = 'closed';
        $cardItem->save();
      
            // Format recipient phone for WhatsApp
            $recipientPhone = $message->recipient_phone;
            
            // Initialize WhatsApp service
            $whatsAppService = new WhatsAppService();
            
            // Get card image URL
            $card = Card::find($message->card_id);
            $imageUrl =  'https://minalqalb.ae/message.png';
            
        // Format the scheduled time
$formattedScheduledTime = '';
if ($message->scheduled_at) {
// Add the backslash to indicate it's in the global namespace
$dateTime = new \DateTime($message->scheduled_at);
$formattedScheduledTime = $dateTime->format('m/d/Y h:i a');
}

if($message->status == 'sent'){

if($message->scheduled_at >now()){
$result = $whatsAppService->sendMinalqalnnewqTemplateHistory(
    $recipientPhone,
    $imageUrl,
    $message->recipient_name,
    $user->name,
    $message->message_lock,
    $formattedScheduledTime
);
}
else {
$result = $whatsAppService->sendMinalqalnnewqTemplate(
    $recipientPhone,
    $imageUrl,
    $message->recipient_name,
    $user->name,
    $message->message_lock
);
    
}
}
           
            
            // Store WhatsApp response data with message
            if (isset($result['response']['id'])) {
                $message->whatsapp_message_id = $result['response']['id'];
                $message->whatsapp_status = $result['response']['status'] ?? 'unknown';
                $message->save();
            }
        
        
        DB::commit();
        
        return redirect()->route('messages.index')
            ->with('success', __('Message created successfully'));
    } catch (\Exception $e) {
        // Something went wrong, rollback transaction
        DB::rollBack();
        
        // Log the error
        
        return redirect()->back()
            ->withErrors(['error' => __('An error occurred while creating the message. Please try again.')])
            ->withInput();
    }
}
public function resendMessage(Message $message)
{
    // Check if the message has a recipient phone
    if (!$message->recipient_phone) {
        return redirect()->route('messages.index')
            ->with('error', __('Cannot resend message - no recipient phone number.'));
    }
    
   
        // Log the resend attempt
      
        // Format recipient phone for WhatsApp if needed
        $recipientPhone = $message->recipient_phone;
        
        // Initialize WhatsApp service
        $whatsAppService = new WhatsAppService();
        
        // Get card image URL
        $imageUrl = 'https://minalqalb.ae/message.png';
        
        // Format the scheduled time if needed
        $formattedScheduledTime = '';
        if ($message->scheduled_at) {
            $dateTime = new \DateTime($message->scheduled_at);
            $formattedScheduledTime = $dateTime->format('m/d/Y h:i a');
        }
        
        // Determine which template to use
        if ($message->scheduled_at && $message->scheduled_at > now()) {
            // Future scheduled message
            $result = $whatsAppService->sendMinalqalnnewqTemplateHistory(
                $recipientPhone,
                $imageUrl,
                $message->recipient_name,
                $message->sender_name,
                $message->message_lock,
                $formattedScheduledTime
            );
        } else {
            // Regular message or past scheduled time
            $result = $whatsAppService->sendMinalqalnnewqTemplate(
                $recipientPhone,
                $imageUrl,
                $message->recipient_name,
                $message->sender_name,
                $message->message_lock
            );
        }
        
        // Store WhatsApp response data with message
        if (isset($result['response']['id'])) {
            $message->whatsapp_message_id = $result['response']['id'];
            $message->whatsapp_status = $result['response']['status'] ?? 'unknown';
            $message->save();
        }
            
        
          
            return redirect()->route('messages.index')
                ->with('success', __('Message resent successfully'));
       
            
   
   
}
    /**
     * Display the specified message.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show($identifer)
    {
     // Find the ready card item by unique identifier
     $cardItem = ReadyCardItem::where('unique_identifier', $uniqueIdentifier)
     ->first();
     
 if (!$cardItem) {
     abort(404, __('Card not found'));
 }
 
 // Get associated message
 $message = Message::where('ready_card_item_id', $cardItem->id)->first();
 
 if (!$message) {
     abort(404, __('Message not found'));
 }
 
 // Get card content (image, video, animated image)
 $card = Card::find($message->card_id);
 
 if (!$card) {
     abort(404, __('Card content not found'));
 }
 
 // Determine content type and file path
 $contentType = null;
 $filePath = null;
 
 if ($card->image) {
     $contentType = 'image';
     $filePath = $card->image;
 } elseif ($card->video) {
     $contentType = 'video';
     $filePath = $card->video;
 } elseif ($card->animated_image) {
     $contentType = 'animated_image';
     $filePath = $card->animated_image;
 }
 
 // Update card item status to 'viewed' if it's 'open'
 if ($cardItem->status === 'open') {
     $cardItem->status = 'viewed';
     $cardItem->save();
 }
 
 // Return view with data
 return view('front.greetings.show', [
     'cardItem' => $cardItem,
     'message' => $message,
     'card' => $card,
     'contentType' => $contentType,
     'filePath' => $filePath
 ]);
}
    

    /**
     * Show the form for editing the specified message.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        if ($message->status !== 'pending') {
            return redirect()->route('messages.show', $message)
                ->with('error', __('Cannot edit a message that has already been sent'));
        }
        
        $mainCategories = Category::whereNull('parent_id')->where('is_active', true)->orderBy('order')->get();
        $subCategories = Category::where('parent_id', $message->main_category_id)->where('is_active', true)->orderBy('order')->get();
        $dedicationTypes = DedicationType::where('is_active', true)->orderBy('order')->get();
        $cards = Card::where('category_id', $message->sub_category_id)->where('is_active', true)->orderBy('order')->get();
        
        $languages = ['ar' => 'العربية', 'en' => 'English'];
        $lockTypes = [
            'no_lock' => __('No'),
            'lock_without_heart' => __('Yes without heart lock'),
            'lock_with_heart' => __('Yes with heart lock')
        ];
        
        $user = Auth::user();
        $isSalesOutlet = $user->hasRole('sales_outlet');
        
        return view('messages.edit', compact(
            'message',
            'mainCategories',
            'subCategories',
            'dedicationTypes',
            'cards',
            'languages',
            'lockTypes',
            'user',
            'isSalesOutlet'
        ));
    }


    public function destroy(Message $message)
    {
        if ($message->status !== 'pending') {
            return redirect()->route('messages.index')
                ->with('error', __('Cannot delete a message that has already been sent'));
        }
        
        $message->delete();
        
        return redirect()->route('messages.index')
            ->with('success', __('Message deleted successfully'));
    }

    /**
     * Get subcategories for a main category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  // In your MessageController.php
  public function getSubCategories(Request $request)
  {
      $mainCategoryId = $request->input('main_category_id');
      
      if (!$mainCategoryId) {
          return response()->json([], 400);
      }
      
      // Make sure you're using the correct model here
      $subCategories = \App\Models\Category::where('parent_id', $mainCategoryId)
          ->orderBy('name_en')
          ->get(['id', 'name_ar', 'name_en']);
      
      return response()->json($subCategories);
  }

    /**
     * Get cards for a sub category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
/**
 * Get cards for a sub category and dedication type.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
public function getCards(Request $request)
{
    $subCategoryId = $request->input('sub_category_id');
    $dedicationTypeId = $request->input('dedication_type_id');
    
    // Validate both parameters are present
    if (!$subCategoryId || !$dedicationTypeId) {
        return response()->json([
            'error' => 'Both sub_category_id and dedication_type_id are required'
        ], 400);
    }
    
    $query = Card::where('sub_category_id', $subCategoryId)
        ->where('is_active', true);
    
    // Filter by dedication_type_id (card_type_id in the database)
    $query->where('card_type_id', $dedicationTypeId);
    
    $cards = $query->get(['id', 'title', 'file_path']);
       
    foreach ($cards as $card) {
        // Set the full URL for file_path
        $card->file_path = asset('storage/' . $card->file_path);
    }
   
    return response()->json($cards);
}
    /**
     * Send a manually queued message.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function sendManual(Message $message)
    {
        if ($message->status !== 'pending') {
            return redirect()->route('messages.show', $message)
                ->with('error', __('This message has already been sent'));
        }
        
        // Handle WhatsApp sending logic here
        // Send WhatsApp message
        
        $message->status = 'sent';
        $message->manually_sent = false;
        $message->save();
        
        return redirect()->route('messages.show', $message)
            ->with('success', __('Message sent successfully'));
    }

    /**
 * Verify if a card number is valid and available.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\JsonResponse
 */
public function verifyCardNumber(Request $request)
{
    // Validate request
    $request->validate([
        'card_number' => 'required|string|size:4|regex:/^\d{4}$/'
    ]);
    
    $cardNumber = $request->card_number;
    $userId = auth()->id();
    
    try {
        // First check if the user has any paid ready cards
        $paidReadyCards = \App\Models\ReadyCard::where('customer_id', $userId)
            ->where('is_paid', true)
            ->pluck('id');
        
        if ($paidReadyCards->isEmpty()) {
            return response()->json([
                'valid' => false,
                'message' => __('You do not have any paid card packs. Please purchase a card pack first.')
            ]);
        }
        
        // Check if the card with this identity number exists and is available
        $cardItem = \App\Models\ReadyCardItem::whereIn('ready_card_id', $paidReadyCards)
            ->where('identity_number', $cardNumber)
            ->first();
        
        if (!$cardItem) {
            return response()->json([
                'valid' => false,
                'message' => __('Card number not found in your purchased card packs.')
            ]);
        }
        
        // Check if the card is available (status = open)
        if ($cardItem->status !== 'open') {
            return response()->json([
                'valid' => false,
                'message' => __('This card has already been used. Please use another card.')
            ]);
        }
        
        // Card is valid and available
        return response()->json([
            'valid' => true,
            'message' => __('Card verified successfully! You can use this card.'),
            'cardInfo' => [
                'ready_card_id' => $cardItem->ready_card_id,
                'sequence_number' => $cardItem->sequence_number,
                'status' => $cardItem->status
            ]
        ]);
    } catch (\Exception $e) {
        // Log the error
        \Log::error('Card verification error: ' . $e->getMessage());
        
        return response()->json([
            'valid' => false,
            'message' => __('An error occurred while verifying the card. Please try again.')
        ], 500);
    }
}

}