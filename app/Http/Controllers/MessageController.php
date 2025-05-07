<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Message;
use App\Models\CardType;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\DedicationType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    /**
     * Display a listing of the messages.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for creating a new message.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Store a newly created message in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
/**
 * Store a newly created message in the database.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
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
    
    // Add recipient phone validation for locked cards
    $rules['recipient_phone'] = 'required_if:lock_type,lock_without_heart,lock_with_heart|nullable|string|max:20';
    
    $validator = Validator::make($request->all(), $rules);
    
    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }
    
    // Validate card number against ReadyCardItems
    $cardNumber = $request->card_number;
    $userId = $user->id;
    
    // Get paid ready cards for this user
    $paidReadyCards = \App\Models\ReadyCard::where('customer_id', $userId)
        ->where('is_paid', true)
        ->pluck('id');
    
    if ($paidReadyCards->isEmpty()) {
        return redirect()->back()
            ->withErrors(['card_number' => __('You do not have any paid card packs. Please purchase a card pack first.')])
            ->withInput();
    }
    
    // Check if card exists and is available
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
        
        // Handle lock type
        if ($request->lock_type !== 'no_lock') {
            $message->recipient_phone = $request->recipient_phone;
            $message->unlock_code = $message->generateUnlockCode();
        }
        
        // Set status
        $message->status = $request->has('manually_sent') || $request->scheduled_at ? 'pending' : 'sent';
        
        $message->save();
        
        // Mark the card as used
        $cardItem->status = 'closed';
        $cardItem->save();
        
        // Handle WhatsApp sending logic here if needed
        // if ($message->status === 'sent') {
        //     // Send WhatsApp message
        // }
        
        // Commit transaction
        DB::commit();
        
        return redirect()->route('messages.index')
            ->with('success', __('Message created successfully'));
    } catch (\Exception $e) {
        // Something went wrong, rollback transaction
        DB::rollBack();
        
        // Log the error
        \Log::error('Message creation error: ' . $e->getMessage());
        
        return redirect()->back()
            ->withErrors(['error' => __('An error occurred while creating the message. Please try again.')])
            ->withInput();
    }
}

    /**
     * Display the specified message.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        $message->load(['mainCategory', 'subCategory', 'dedicationType', 'card']);
        return view('messages.show', compact('message'));
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

    /**
     * Update the specified message in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        if ($message->status !== 'pending') {
            return redirect()->route('messages.show', $message)
                ->with('error', __('Cannot update a message that has already been sent'));
        }
        
        $user = Auth::user();
        $isSalesOutlet = $user->hasRole('sales_outlet');
        
        // Validate request data - same validation as store
        $rules = [
            'recipient_language' => 'required|in:ar,en',
            'main_category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:categories,id',
            'dedication_type_id' => 'required',
            'card_number' => 'required|string',
            'card_id' => 'required|exists:cards,id',
            'message_content' => 'required|string',
            'recipient_name' => 'required|string|max:255',
            'lock_type' => 'required|in:no_lock,lock_without_heart,lock_with_heart',
            'scheduled_at' => 'nullable|date',
            'manually_sent' => 'boolean',
        ];
        
        if ($isSalesOutlet) {
            $rules['sender_name'] = 'required|string|max:255';
            $rules['sender_phone'] = 'required|string|max:20';
        }
        
        $rules['recipient_phone'] = 'required_if:lock_type,lock_without_heart,lock_with_heart|nullable|string|max:20';
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Update the message
        $message->recipient_language = $request->recipient_language;
        $message->main_category_id = $request->main_category_id;
        $message->sub_category_id = $request->sub_category_id;
        $message->dedication_type_id = $request->dedication_type_id;
        $message->card_number = $request->card_number;
        $message->card_id = $request->card_id;
        $message->message_content = $request->message_content;
        $message->recipient_name = $request->recipient_name;
        $message->scheduled_at = $request->scheduled_at;
        $message->manually_sent = $request->has('manually_sent');
        
        // Update sender info for sales outlet
        if ($isSalesOutlet) {
            $message->sender_name = $request->sender_name;
            $message->sender_phone = $request->sender_phone;
        }
        
        // Handle lock type changes
        if ($message->lock_type !== $request->lock_type) {
            $message->lock_type = $request->lock_type;
            
            if ($request->lock_type === 'no_lock') {
                $message->recipient_phone = null;
                $message->unlock_code = null;
            } else {
                $message->recipient_phone = $request->recipient_phone;
                if (!$message->unlock_code) {
                    $message->unlock_code = $message->generateUnlockCode();
                }
            }
        } elseif ($request->lock_type !== 'no_lock') {
            $message->recipient_phone = $request->recipient_phone;
        }
        
        // Update status
        $message->status = $request->has('manually_sent') || $request->scheduled_at ? 'pending' : 'sent';
        
        $message->save();
        
        // Handle WhatsApp sending logic here if needed
        // if ($message->status === 'sent') {
        //     // Send WhatsApp message
        // }
        
        return redirect()->route('messages.show', $message)
            ->with('success', __('Message updated successfully'));
    }

    /**
     * Remove the specified message from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
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