<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Message;
use App\Models\CardType;
use Illuminate\Http\Request;
use App\Models\ReadyCardItem;
use App\Services\WhatsAppService;

class CardContentController extends Controller
{
    public function showCardContent($uniqueIdentifier)
{

    
    // Find the ready card item by unique identifier
    $cardItem = ReadyCardItem::where('unique_identifier', $uniqueIdentifier)->first();
    
    if (!$cardItem) {
        return response()->view('errors.404', [], 404);
    }
    
    // Get associated message
    $message = Message::where('ready_card_item_id', $cardItem->id)->first();
    
    if (!$message) {
        return response()->view('errors.404', [], 404);
    }
    
    // Get card content (image, video, animated image)
    $card = Card::find($message->card_id);
    
    if (!$card) {
        return response()->view('errors.404', [], 404);
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
    ]);
}

    // In your routes file

// In your CardContentController
public function unlockMessageCode(Request $request, $id)
{
    $message = Message::findOrFail($id);
    $submittedCode = implode('', $request->input('code'));
    
    // Compare with the message_lock field
    if ($submittedCode == $message->message_lock) {
        // Store in session that this message is unlocked
        session(['unlocked_' . $id => true]);
        return redirect()->back();
    }
    
    // If incorrect code
    return back()->with('error', 'الرمز غير صحيح. يرجى المحاولة مرة أخرى.');
}


public function showResponseForm($uniqueIdentifier)
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
    
    // Get card content
    $card = Card::find($message->card_id);
    
    if (!$card) {
        abort(404, __('Card content not found'));
    }
    
    return view('front.greetings.respond', [
        'cardItem' => $cardItem,
        'message' => $message,
        'card' => $card,
    ]);
}
public function showMessageDetails($uniqueIdentifier)
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
    
    // Get card content
    $card = Card::find($message->card_id);
    
    if (!$card) {
        abort(404, __('Card content not found'));
    }
    
    return view('front.greetings.message_details', [
        'cardItem' => $cardItem,
        'message' => $message,
        'card' => $card,
    ]);
}
public function storeResponse(Request $request, $uniqueIdentifier)
{
    // Validate request
    $request->validate([
        'response' => 'required|string|max:1000',
    ]);
    
    $cardItem = ReadyCardItem::where('unique_identifier', $uniqueIdentifier)->firstOrFail();
    


    $message = Message::where('ready_card_item_id', $cardItem->id)->firstOrFail();
    
   



    $message->response = $request->response;
    
    $message->response_at = now();

    $message->save();

    $whatsAppService = new WhatsAppService();
    $imageUrl =  'https://minalqalb.ae/message.png';

    $result = $whatsAppService->sendFeelingsTemplate(

        $message->sender_phone,

        $imageUrl,

        $request->response,
     
    );
    
    return redirect()->route('message.respond.form', $uniqueIdentifier)
        ->with('success', 'تم إرسال ردك بنجاح');
}



}