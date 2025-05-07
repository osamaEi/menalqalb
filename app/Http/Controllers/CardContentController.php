<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Message;
use App\Models\CardType;
use Illuminate\Http\Request;
use App\Models\ReadyCardItem;

class CardContentController extends Controller
{
    public function showCardContent($uniqueIdentifier)
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
        $contentType = CardType::whereIn('type',['image','video','animated_image'])->get();
        $filePath = null;
        
        
        
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
}