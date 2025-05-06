<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Message;
use App\Models\CardType;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\DedicationType;
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
            'no_lock' => __('No'),
            'lock_without_heart' => __('Yes without heart lock'),
            'lock_with_heart' => __('Yes with heart lock')
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
            'card_number' => 'required|string',
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
        
        // Handle sender info based on user type
        if ($isSalesOutlet) {
            $message->sender_name = $request->sender_name;
            $message->sender_phone = $request->sender_phone;
            $message->sales_outlet_id = $user->sales_outlet_id;
        } else {
            $message->sender_name = $user->name;
            $message->sender_phone = $user->phone;
            $message->user_id = $user->id;
        }
        
        // Handle lock type
        if ($request->lock_type !== 'no_lock') {
            $message->recipient_phone = $request->recipient_phone;
            $message->unlock_code = $message->generateUnlockCode();
        }
        
        // Set status
        $message->status = $request->has('manually_sent') || $request->scheduled_at ? 'pending' : 'sent';
        $message->sender_phone = 23423232;
        $message->sender_name = auth()->user()->name;
        
        $message->save();
        
        // Handle WhatsApp sending logic here if needed
        // if ($message->status === 'sent') {
        //     // Send WhatsApp message
        // }
        
        return redirect()->route('messages.index')
            ->with('success', __('Message created successfully'));
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
    public function getCards(Request $request)
    {
        $subCategoryId = $request->input('sub_category_id');
        $cards = Card::where('sub_category_id', $subCategoryId)
            ->where('is_active', true)
            ->get(['id', 'title', 'file_path']);
            
        foreach ($cards as $card) {
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
}