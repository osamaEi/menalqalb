<?php

namespace App\Http\Controllers;

use App\Models\LocksWReadyCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LocksWReadyCardController extends Controller
{
    public function index(Request $request)
    {
        $query = LocksWReadyCard::query();

        // Apply filters
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('is_active', $request->status == 'active');
        }

        $items = $query->latest()->paginate(10);

        // Statistics
        $totalItems = LocksWReadyCard::count();
        $lockItems = LocksWReadyCard::where('type', 'lock')->count();
        $readCardItems = LocksWReadyCard::where('type', 'read_card')->count();
        $activeItems = LocksWReadyCard::where('is_active', true)->count();
        $inactiveItems = LocksWReadyCard::where('is_active', false)->count();

        return view('admin.locks_w_ready_cards.index', compact(
            'items',
            'totalItems',
            'lockItems',
            'readCardItems',
            'activeItems',
            'inactiveItems'
        ));
    }

    public function create()
    {
        return view('admin.locks_w_ready_cards.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'desc_ar' => 'nullable|string',
            'desc_en' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'points' => 'required|integer|min:0',
            'type' => 'required|in:lock,read_card',
            'photo' => 'nullable|image|max:2048',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('locks_w_ready_cards', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        LocksWReadyCard::create($validated);

        return redirect()->route('locks_w_ready_cards.index')
            ->with('success', __('Item created successfully'));
    }

    public function show(LocksWReadyCard $locksWReadyCard)
    {
        return view('admin.locks_w_ready_cards.show', compact('locksWReadyCard'));
    }

    public function edit(LocksWReadyCard $locksWReadyCard)
    {
        return view('admin.locks_w_ready_cards.edit', compact('locksWReadyCard'));
    }

    public function update(Request $request, LocksWReadyCard $locksWReadyCard)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'desc_ar' => 'nullable|string',
            'desc_en' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'points' => 'required|integer|min:0',
            'type' => 'required|in:lock,read_card',
            'photo' => 'nullable|image|max:2048',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($locksWReadyCard->photo) {
                Storage::disk('public')->delete($locksWReadyCard->photo);
            }
            $validated['photo'] = $request->file('photo')->store('locks_w_ready_cards', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $locksWReadyCard->update($validated);

        return redirect()->route('locks_w_ready_cards.index')
            ->with('success', __('Item updated successfully'));
    }

    public function destroy(LocksWReadyCard $locksWReadyCard)
    {
        if ($locksWReadyCard->photo) {
            Storage::disk('public')->delete($locksWReadyCard->photo);
        }
        
        $locksWReadyCard->delete();

        return redirect()->route('locks_w_ready_cards.index')
            ->with('success', __('Item deleted successfully'));
    }

    public function toggleStatus(LocksWReadyCard $locksWReadyCard)
    {
        $locksWReadyCard->update(['is_active' => !$locksWReadyCard->is_active]);

        return redirect()->route('locks_w_ready_cards.index')
            ->with('success', __('Status updated successfully'));
    }

    // Filter methods
    public function filterByType($type)
    {
        $items = LocksWReadyCard::where('type', $type)->latest()->paginate(10);
        
        // Statistics
        $totalItems = LocksWReadyCard::count();
        $lockItems = LocksWReadyCard::where('type', 'lock')->count();
        $readCardItems = LocksWReadyCard::where('type', 'read_card')->count();
        $activeItems = LocksWReadyCard::where('is_active', true)->count();
        $inactiveItems = LocksWReadyCard::where('is_active', false)->count();

        $filter = $type == 'lock' ? __('Locks') : __('Read Cards');

        return view('admin.locks_w_ready_cards.index', compact(
            'items',
            'totalItems',
            'lockItems',
            'readCardItems',
            'activeItems',
            'inactiveItems',
            'filter'
        ));
    }

    public function filterByStatus($status)
    {
        $isActive = $status == 'active';
        $items = LocksWReadyCard::where('is_active', $isActive)->latest()->paginate(10);
        
        // Statistics
        $totalItems = LocksWReadyCard::count();
        $lockItems = LocksWReadyCard::where('type', 'lock')->count();
        $readCardItems = LocksWReadyCard::where('type', 'read_card')->count();
        $activeItems = LocksWReadyCard::where('is_active', true)->count();
        $inactiveItems = LocksWReadyCard::where('is_active', false)->count();

        $filter = $status == 'active' ? __('Active Items') : __('Inactive Items');

        return view('admin.locks_w_ready_cards.index', compact(
            'items',
            'totalItems',
            'lockItems',
            'readCardItems',
            'activeItems',
            'inactiveItems',
            'filter'
        ));
    }
}