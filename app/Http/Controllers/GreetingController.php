<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GreetingController extends Controller

{
    /**
     * Display a listing of the user's messages.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $messages = Message::where('user_id', $user->id)
                ->with(['mainCategory', 'subCategory', 'card'])
                ->latest()
                ->paginate(10);
        
        return view('app.greetings.index', compact('messages'));
    }
    
    /**
     * Display the specified message details.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $user = Auth::user();
        $message = Message::where('user_id', $user->id)
                ->with(['mainCategory', 'subCategory', 'card'])
                ->findOrFail($id);
        
        return view('app.greetings.show', compact('message'));
    }
    
    /**
     * Display the card preview for the specified message.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function showCard($id)
    {
        $user = Auth::user();
        $message = Message::where('user_id', $user->id)
                ->with(['card'])
                ->findOrFail($id);
        
        return view('app.greetings.show_card', compact('message'));
    }
    
    /**
     * Display the response for the specified message.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function showResponse($id)
    {
        $user = Auth::user();
        $message = Message::where('user_id', $user->id)
                ->findOrFail($id);
        
        return view('app.greetings.show_response', compact('message'));
    }
    
    /**
     * Display the private message details.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function showPrivateMessage($id)
    {
        $user = Auth::user();
        $message = Message::where('user_id', $user->id)
                ->findOrFail($id);
        
        return view('app.greetings.private_message', compact('message'));
    }
    
    /**
     * Display the scheduled time details.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function showScheduledTime($id)
    {
        $user = Auth::user();
        $message = Message::where('user_id', $user->id)
                ->findOrFail($id);
        
        return view('app.greetings.scheduled_time', compact('message'));
    }
    
    /**
     * Send the message manually.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendMessage($id)
    {
        $user = Auth::user();
        $message = Message::where('user_id', $user->id)
                ->findOrFail($id);
        
        // Update the message status to sent
        $message->update([
            'status' => 'sent',
            'manually_sent' => true,
        ]);
        
        return redirect()->route('app.greetings.show', $message->id)
            ->with('success', 'تم إرسال التهنئة بنجاح!');
    }
    
    /**
     * Show the form for editing the message.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $user = Auth::user();
        $message = Message::where('user_id', $user->id)
                ->with(['mainCategory', 'subCategory', 'card'])
                ->findOrFail($id);
        
        return view('app.greetings.edit', compact('message'));
    }
}