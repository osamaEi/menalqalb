<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\User;
use App\Models\ReadyCard;
use App\Models\ReadyCardItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ReadyCardController extends Controller
{
    /**
     * Display a listing of the ready cards with dashboard statistics.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get statistics for dashboard
        $totalReadyCards = ReadyCard::count();
        $totalCardCount = ReadyCard::sum('card_count');
        $totalCost = ReadyCard::sum('cost');
        $uniqueCustomers = ReadyCard::distinct('customer_id')->count('customer_id');
        
        // Start with base query
        $query = ReadyCard::with(['customer']);
        
        // Apply filters
        if ($request->filled('customer_id')) {
            $query->byCustomer($request->customer_id);
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('customer', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        // Prepare filter description
        $filter = null;
        if ($request->filled('customer_id')) {
            $customer = User::find($request->customer_id);
            if ($customer) {
                $filter = __('Ready Cards for customer') . ': ' . $customer->name;
            }
        } elseif ($request->filled('date_from') || $request->filled('date_to')) {
            $filter = __('Ready Cards from') . ': ';
            if ($request->filled('date_from')) {
                $filter .= $request->date_from;
            }
            if ($request->filled('date_to')) {
                $filter .= ' ' . __('to') . ' ' . $request->date_to;
            }
        } elseif ($request->filled('search')) {
            $filter = __('Search results for') . ': ' . $request->search;
        }
        
        // Apply sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'newest':
                    $query->newest();
                    break;
                case 'oldest':
                    $query->oldest();
                    break;
                case 'cost_high':
                    $query->orderBy('cost', 'desc');
                    break;
                case 'cost_low':
                    $query->orderBy('cost', 'asc');
                    break;
                case 'card_count_high':
                    $query->orderBy('card_count', 'desc');
                    break;
                case 'card_count_low':
                    $query->orderBy('card_count', 'asc');
                    break;
                default:
                    $query->newest();
            }
        } else {
            $query->newest();
        }
        
        // Get paginated results
        $readyCards = $query->paginate(10)->withQueryString();
        
        // Get customers for filter dropdown
        $customers = User::whereHas('readyCards')->select('id', 'name')->get();
        
        return view('ready_cards.index', compact(
            'readyCards',
            'totalReadyCards',
            'totalCardCount',
            'totalCost',
            'uniqueCustomers',
            'customers',
            'filter'
        ));
    }

    /**
     * Show the form for creating a new ready card.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = User::orderBy('name')->get();
        $cards = Card::orderBy('id')->get();
        
        return view('ready_cards.create', compact('customers', 'cards'));
    }

    /**
     * Store a newly created ready card in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:users,id',
            'card_count' => 'required|integer|min:1',
            'cost' => 'required|numeric|min:0',
            'received_card_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        // Handle image upload
        if ($request->hasFile('received_card_image')) {
            $path = $request->file('received_card_image')->store('ready_cards', 'public');
            $validated['received_card_image'] = $path;
        }
        
        DB::beginTransaction();
        
        try {
            // Create the ready card
            $readyCard = ReadyCard::create([
                'customer_id' => $validated['customer_id'],
                'card_count' => $validated['card_count'],
                'cost' => $validated['cost'],
                'received_card_image' => $validated['received_card_image'] ?? null,
            ]);
            
            // Create the individual card items based on card count
            for ($i = 1; $i <= $validated['card_count']; $i++) {
                // Generate a 4-digit identity number (with leading zeros if needed)
                $identityNumber = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
                
                // Generate QR code content (can be customized as needed)
                $qrCodeContent = 'RC-' . $readyCard->id . '-' . $identityNumber . '-' . $i;
                
                // Create the ready card item
                ReadyCardItem::create([
                    'ready_card_id' => $readyCard->id,
                    'identity_number' => $identityNumber,
                    'qr_code' => $qrCodeContent,
                    'sequence_number' => $i,
                    'status' => 'closed' // Default status
                ]);
            }
            
            DB::commit();
            
            return redirect()->route('ready-cards.index')
                ->with('success', __('Ready card created successfully.'));
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()->withInput()
                ->with('error', __('Failed to create ready card.') . ' ' . $e->getMessage());
        }
    }

    /**
     * Display the specified ready card.
     *
     * @param  \App\Models\ReadyCard  $readyCard
     * @return \Illuminate\Http\Response
     */
    public function show(ReadyCard $readyCard)
    {
        $readyCard->load(['customer', 'items.card']);
        
        return view('ready_cards.show', compact('readyCard'));
    }

    /**
     * Show the form for editing the specified ready card.
     *
     * @param  \App\Models\ReadyCard  $readyCard
     * @return \Illuminate\Http\Response
     */
    public function edit(ReadyCard $readyCard)
    {
        $readyCard->load(['items.card']);
        $customers = User::orderBy('name')->get();
        $cards = Card::orderBy('id')->get();
        $selectedCards = $readyCard->items->pluck('card_id')->toArray();
        
        return view('ready_cards.edit', compact('readyCard', 'customers', 'cards', 'selectedCards'));
    }

    /**
     * Update the specified ready card in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReadyCard  $readyCard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReadyCard $readyCard)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:users,id',
            'card_count' => 'required|integer|min:1',
            'cost' => 'required|numeric|min:0',
            'received_card_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        // Handle image upload
        if ($request->hasFile('received_card_image')) {
            // Delete old image if exists
            if ($readyCard->received_card_image) {
                Storage::disk('public')->delete($readyCard->received_card_image);
            }
            
            $path = $request->file('received_card_image')->store('ready_cards', 'public');
            $validated['received_card_image'] = $path;
        }
        
        DB::beginTransaction();
        
        try {
            // Update the ready card
            $readyCard->update([
                'customer_id' => $validated['customer_id'],
                'card_count' => $validated['card_count'],
                'cost' => $validated['cost'],
                'received_card_image' => $validated['received_card_image'] ?? $readyCard->received_card_image,
            ]);
            
            // Delete existing items
            $readyCard->items()->delete();
            
            // Create new items based on updated card count
            for ($i = 1; $i <= $validated['card_count']; $i++) {
                // Generate a 4-digit identity number
                $identityNumber = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
                
                // Generate QR code content
                $qrCodeContent = 'RC-' . $readyCard->id . '-' . $identityNumber . '-' . $i;
                
                // Create the ready card item
                ReadyCardItem::create([
                    'ready_card_id' => $readyCard->id,
                    'identity_number' => $identityNumber,
                    'qr_code' => $qrCodeContent,
                    'sequence_number' => $i,
                    'status' => 'open' // Default status
                ]);
            }
            
            DB::commit();
            
            return redirect()->route('ready-cards.index')
                ->with('success', __('Ready card updated successfully.'));
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()->withInput()
                ->with('error', __('Failed to update ready card.') . ' ' . $e->getMessage());
        }
    }
    /**
     * Remove the specified ready card from storage.
     *
     * @param  \App\Models\ReadyCard  $readyCard
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReadyCard $readyCard)
    {
        // Delete image if exists
        if ($readyCard->received_card_image) {
            Storage::disk('public')->delete($readyCard->received_card_image);
        }
        
        // Delete the ready card (items will be deleted via cascade)
        $readyCard->delete();
        
        return redirect()->route('ready-cards.index')
            ->with('success', __('Ready card deleted successfully.'));
    }
    
    /**
     * Filter ready cards by customer.
     *
     * @param  int  $customerId
     * @return \Illuminate\Http\Response
     */
    public function filterByCustomer($customerId)
    {
        $customer = User::findOrFail($customerId);
        
        // Get statistics for dashboard
        $totalReadyCards = ReadyCard::count();
        $totalCardCount = ReadyCard::sum('card_count');
        $totalCost = ReadyCard::sum('cost');
        $uniqueCustomers = ReadyCard::distinct('customer_id')->count('customer_id');
        
        // Get filtered ready cards
        $readyCards = ReadyCard::with(['customer'])
            ->byCustomer($customerId)
            ->newest()
            ->paginate(10);
        
        // Get customers for filter dropdown
        $customers = User::whereHas('readyCards')->select('id', 'name')->get();
        
        return view('ready_cards.index', compact(
            'readyCards',
            'totalReadyCards',
            'totalCardCount',
            'totalCost',
            'uniqueCustomers',
            'customers'
        ))->with('filter', __('Ready Cards for customer') . ': ' . $customer->name);
    }
    
    /**
     * Filter ready cards by date.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filterByDate(Request $request)
    {
        $validated = $request->validate([
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
        ]);
        
        return redirect()->route('ready_cards.index', [
            'date_from' => $validated['date_from'],
            'date_to' => $validated['date_to'],
        ]);
    }

    /**
 * Get items for a ready card.
 *
 * @param  \App\Models\ReadyCard  $readyCard
 * @return \Illuminate\Http\Response
 */
public function getItems(ReadyCard $readyCard)
{
    $items = $readyCard->items()->orderBy('sequence_number')->get();
    
    return response()->json([
        'success' => true,
        'items' => $items
    ]);
}

/**
 * Print all cards for a ready card.
 *
 * @param  \App\Models\ReadyCard  $readyCard
 * @return \Illuminate\Http\Response
 */
public function printAllCards(ReadyCard $readyCard)
{
    $items = $readyCard->items()->orderBy('sequence_number')->get();
    
    return view('ready_cards.print_all', compact('readyCard', 'items'));
}
}