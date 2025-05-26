<?php
// app/Http/Controllers/LockerController.php
namespace App\Http\Controllers;

use App\Models\Locker;
use App\Models\LockerItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LockerController extends Controller
{
    public function index()
    {
        $lockers = Locker::with('user')->latest()->get();
        return view('admin.lockers.index', compact('lockers'));
    }

    public function create()
    {
        $requests= \App\Models\Request::where('type','lock')->where('status','pending')->get();
        return view('admin.lockers.create',compact('requests'));
    }

 // app/Http/Controllers/LockerController.php
public function store(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'quantity' => 'required|integer|min:1',
        'price' => 'required|numeric|min:0',
        'photo' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('photo')) {
        $validated['photo'] = $request->file('photo')->store('lockers', 'public');
    }

    $locker = Locker::create($validated);

    // Create locker items with default 'open' status
    for ($i = 1; $i <= $locker->quantity; $i++) {
        LockerItem::create([
            'locker_id' => $locker->id,
            'number_locker' => $i,
            'status' => LockerItem::STATUS_OPEN,
        ]);
    }

    return redirect()->route('admin.lockers.index')->with('success', 'Locker created successfully!');
}

    public function show(Locker $locker)
    {
        $locker->load('items', 'user');
        return view('admin.lockers.show', compact('locker'));
    }

    public function edit(Locker $locker)
    {

        $requests= \App\Models\Request::where('type','lock')->where('status','pending')->get();

        return view('admin.lockers.edit', compact('locker','requests'));
    }

    public function update(Request $request, Locker $locker)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($locker->photo) {
                Storage::disk('public')->delete($locker->photo);
            }
            $validated['photo'] = $request->file('photo')->store('lockers', 'public');
        }

        // Handle quantity changes
        $oldQuantity = $locker->quantity;
        $newQuantity = $validated['quantity'];

        $locker->update($validated);

        if ($newQuantity > $oldQuantity) {
            // Add new locker items
            for ($i = $oldQuantity + 1; $i <= $newQuantity; $i++) {
                LockerItem::create([
                    'locker_id' => $locker->id,
                    'number_locker' => $i,
                ]);
            }
        } elseif ($newQuantity < $oldQuantity) {
            // Remove excess locker items
            LockerItem::where('locker_id', $locker->id)
                ->where('number_locker', '>', $newQuantity)
                ->delete();
        }

        return redirect()->route('admin.lockers.index')->with('success', 'Locker updated successfully!');
    }

    public function destroy(Locker $locker)
    {
        if ($locker->photo) {
            Storage::disk('public')->delete($locker->photo);
        }
        $locker->delete();
        return redirect()->route('admin.lockers.index')->with('success', 'Locker deleted successfully!');
    }
}