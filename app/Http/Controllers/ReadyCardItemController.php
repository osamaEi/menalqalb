<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReadyCardItem;

class ReadyCardItemController extends Controller
{
    public function toggleStatus(Request $request, ReadyCardItem $item)
    {
        $validated = $request->validate([
            'status' => 'required|in:open,closed',
        ]);
        
        $item->update([
            'status' => $validated['status']
        ]);
        
        return response()->json([
            'success' => true,
            'message' => __('Card status updated successfully'),
            'item' => $item
        ]);
    }
    
    /**
     * Print a single card.
     *
     * @param  \App\Models\ReadyCardItem  $item
     * @return \Illuminate\Http\Response
     */
    public function printCard(ReadyCardItem $item)
    {
        return view('ready_cards.print_card', compact('item'));
    }
}
