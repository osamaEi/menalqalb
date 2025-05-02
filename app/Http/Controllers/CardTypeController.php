<?php

namespace App\Http\Controllers;

use App\Models\CardType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CardTypeController extends Controller
{
    /**
     * Display a listing of the card types with dashboard statistics.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get statistics for dashboard
        $totalCardTypes = CardType::count();
        $activeCardTypes = CardType::active()->count();
        $inactiveCardTypes = CardType::inactive()->count();
        
        // Get different types count for chart
        $typeStats = [];
        foreach (CardType::getTypeOptions() as $key => $label) {
            $typeStats[$key] = CardType::ofType($key)->count();
        }
        
        // Start with base query
        $query = CardType::query();
        
        // Apply filters
        if ($request->filled('type')) {
            $query->ofType($request->type);
        }
        
        if ($request->filled('status')) {
            if ($request->status == 'active') {
                $query->active();
            } elseif ($request->status == 'inactive') {
                $query->inactive();
            }
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name_en', 'like', "%{$search}%")
                  ->orWhere('name_ar', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%");
            });
        }
        
        // Prepare filter description
        $filter = null;
        if ($request->filled('type')) {
            $typeLabel = CardType::getTypeOptions()[$request->type] ?? $request->type;
            $filter = __('Card Types of type') . ': ' . __($typeLabel);
        } elseif ($request->filled('status')) {
            $filter = __($request->status == 'active' ? 'Active Card Types' : 'Inactive Card Types');
        } elseif ($request->filled('search')) {
            $filter = __('Search results for') . ': ' . $request->search;
        }
        
        // Get paginated results
        $cardTypes = $query->paginate(10)->withQueryString();
        $typeOptions = CardType::getTypeOptions();
        $iconOptions = CardType::getIconOptions();
        
        return view('card_types.index', compact(
            'cardTypes',
            'totalCardTypes',
            'activeCardTypes',
            'inactiveCardTypes',
            'typeOptions',
            'iconOptions',
            'typeStats',
            'filter'
        ));
    }
    /**
     * Show the form for creating a new card type.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $typeOptions = CardType::getTypeOptions();
        $iconOptions = CardType::getIconOptions();
        
        return view('card_types.create', compact('typeOptions', 'iconOptions'));
    }

    /**
     * Store a newly created card type in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'icon' => 'required|string|max:50',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'boolean',
        ]);
        
        // Set default values
        $validated['is_active'] = $request->boolean('is_active', true);
        
        // Handle photo upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('card_types', 'public');
            $validated['photo'] = $path;
        }
        
        $cardType = CardType::create($validated);
        
        return redirect()->route('card_types.index')
            ->with('success', __('Card type created successfully.'));
    }

    /**
     * Display the specified card type.
     *
     * @param  \App\Models\CardType  $cardType
     * @return \Illuminate\Http\Response
     */
    public function show(CardType $cardType)
    {
        $typeOptions = CardType::getTypeOptions();
        $iconOptions = CardType::getIconOptions();
        
        return view('card_types.show', compact('cardType', 'typeOptions', 'iconOptions'));
    }

    /**
     * Show the form for editing the specified card type.
     *
     * @param  \App\Models\CardType  $cardType
     * @return \Illuminate\Http\Response
     */
    public function edit(CardType $cardType)
    {
        $typeOptions = CardType::getTypeOptions();
        $iconOptions = CardType::getIconOptions();
        
        return view('card_types.edit', compact('cardType', 'typeOptions', 'iconOptions'));
    }

    /**
     * Update the specified card type in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CardType  $cardType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CardType $cardType)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'icon' => 'required|string|max:50',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'boolean',
        ]);
        
        // Set default values
        $validated['is_active'] = $request->boolean('is_active', true);
        
        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($cardType->photo) {
                Storage::disk('public')->delete($cardType->photo);
            }
            
            $path = $request->file('photo')->store('card_types', 'public');
            $validated['photo'] = $path;
        }
        
        $cardType->update($validated);
        
        return redirect()->route('card_types.index')
            ->with('success', __('Card type updated successfully.'));
    }

    /**
     * Remove the specified card type from storage.
     *
     * @param  \App\Models\CardType  $cardType
     * @return \Illuminate\Http\Response
     */
    public function destroy(CardType $cardType)
    {
        // Check if card type has cards
        if ($cardType->cards()->count() > 0) {
            return redirect()->route('card_types.index')
                ->with('error', __('Cannot delete card type with associated cards.'));
        }
        
        // Delete photo if exists
        if ($cardType->photo) {
            Storage::disk('public')->delete($cardType->photo);
        }
        
        $cardType->delete();
        
        return redirect()->route('card_types.index')
            ->with('success', __('Card type deleted successfully.'));
    }
    
    /**
     * Toggle card type active status.
     *
     * @param  \App\Models\CardType  $cardType
     * @return \Illuminate\Http\Response
     */
    public function toggleStatus(CardType $cardType)
    {
        $cardType->update(['is_active' => !$cardType->is_active]);
        
        $message = $cardType->is_active ? 
            __('Card type has been activated.') : 
            __('Card type has been deactivated.');
        
        return redirect()->back()->with('success', $message);
    }
    
    /**
     * Filter card types by type.
     *
     * @param  string  $type
     * @return \Illuminate\Http\Response
     */
    public function filterByType($type)
    {
        $typeOptions = CardType::getTypeOptions();
        
        if (!array_key_exists($type, $typeOptions)) {
            return redirect()->route('card_types.index')
                ->with('error', __('Invalid card type specified.'));
        }
        
        // Get statistics for dashboard
        $totalCardTypes = CardType::count();
        $activeCardTypes = CardType::active()->count();
        $inactiveCardTypes = CardType::inactive()->count();
        
        // Get different types count for chart
        $typeStats = [];
        foreach (CardType::getTypeOptions() as $key => $label) {
            $typeStats[$key] = CardType::ofType($key)->count();
        }
        
        $cardTypes = CardType::ofType($type)->paginate(10);
        $iconOptions = CardType::getIconOptions();
        
        return view('card_types.index', compact(
            'cardTypes', 
            'totalCardTypes', 
            'activeCardTypes', 
            'inactiveCardTypes',
            'typeOptions',
            'iconOptions',
            'typeStats'
        ))->with('filter', __("Showing only :type card types", ['type' => $typeOptions[$type]]));
    }
    
    /**
     * Filter card types by status.
     *
     * @param  string  $status
     * @return \Illuminate\Http\Response
     */
    public function filterByStatus($status)
    {
        if (!in_array($status, ['active', 'inactive'])) {
            return redirect()->route('card_types.index')
                ->with('error', __('Invalid status specified.'));
        }
        
        // Get statistics for dashboard
        $totalCardTypes = CardType::count();
        $activeCardTypes = CardType::active()->count();
        $inactiveCardTypes = CardType::inactive()->count();
        
        // Get different types count for chart
        $typeStats = [];
        foreach (CardType::getTypeOptions() as $key => $label) {
            $typeStats[$key] = CardType::ofType($key)->count();
        }
        
        if ($status === 'active') {
            $cardTypes = CardType::active()->paginate(10);
            $filterLabel = __('Showing only active card types');
        } else {
            $cardTypes = CardType::inactive()->paginate(10);
            $filterLabel = __('Showing only inactive card types');
        }
        
        $typeOptions = CardType::getTypeOptions();
        $iconOptions = CardType::getIconOptions();
        
        return view('card_types.index', compact(
            'cardTypes', 
            'totalCardTypes', 
            'activeCardTypes', 
            'inactiveCardTypes',
            'typeOptions',
            'iconOptions',
            'typeStats'
        ))->with('filter', $filterLabel);
    }
}