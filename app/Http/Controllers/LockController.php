<?php

namespace App\Http\Controllers;

use App\Models\Locks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LockController extends Controller
{
    /**
     * Display a listing of the locks with dashboard statistics.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get statistics for dashboard
        $totalLocks = Locks::count();
        $activeLocks = Locks::active()->count();
        $inactiveLocks = Locks::inactive()->count();
        $inStockLocks = Locks::inStock()->count();
        
        // Start with base query
        $query = Locks::query();
        
        // Apply filters
        if ($request->filled('status')) {
            if ($request->status == 'active') {
                $query->active();
            } elseif ($request->status == 'inactive') {
                $query->inactive();
            }
        }
        
        if ($request->filled('stock')) {
            if ($request->stock == 'in') {
                $query->inStock();
            } elseif ($request->stock == 'out') {
                $query->outOfStock();
            }
        }
        
        if ($request->filled('supplier')) {
            $query->where('supplier', $request->supplier);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('supplier', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%");
            });
        }
        
        // Prepare filter description
        $filter = null;
        if ($request->filled('status')) {
            $filter = __($request->status == 'active' ? 'Active Locks' : 'Inactive Locks');
        } elseif ($request->filled('stock')) {
            $filter = __($request->stock == 'in' ? 'In Stock Locks' : 'Out of Stock Locks');
        } elseif ($request->filled('supplier')) {
            $filter = __('Locks from supplier') . ': ' . $request->supplier;
        } elseif ($request->filled('search')) {
            $filter = __('Search results for') . ': ' . $request->search;
        }
        
        // Get paginated results
        $locks = $query->paginate(10)->withQueryString();
        
        // Get unique suppliers for filter dropdown
        $suppliers = Locks::select('supplier')->distinct()->pluck('supplier');
        
        return view('locks.index', compact(
            'locks',
            'totalLocks',
            'activeLocks',
            'inactiveLocks',
            'inStockLocks',
            'suppliers',
            'filter'
        ));
    }

    /**
     * Show the form for creating a new lock.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('locks.create');
    }

    /**
     * Store a newly created lock in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'notes' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'invoice_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'boolean',
        ]);
        
        // Set default values
        $validated['is_active'] = $request->boolean('is_active', true);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('locks', 'public');
            $validated['image'] = $path;
        }
        
        // Handle invoice image upload
        if ($request->hasFile('invoice_image')) {
            $path = $request->file('invoice_image')->store('lock_invoices', 'public');
            $validated['invoice_image'] = $path;
        }
        
        $lock = Locks::create($validated);
        
        return redirect()->route('locks.index')
            ->with('success', __('Lock created successfully.'));
    }

    /**
     * Display the specified lock.
     *
     * @param  \App\Models\Locks  $lock
     * @return \Illuminate\Http\Response
     */
    public function show(Locks $lock)
    {
        return view('locks.show', compact('lock'));
    }

    /**
     * Show the form for editing the specified lock.
     *
     * @param  \App\Models\Locks  $lock
     * @return \Illuminate\Http\Response
     */
    public function edit(Locks $lock)
    {
        return view('locks.edit', compact('lock'));
    }

    /**
     * Update the specified lock in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Locks  $lock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Locks $lock)
    {
        $validated = $request->validate([
            'supplier' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'notes' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'invoice_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'boolean',
        ]);
        
        // Set default values
        $validated['is_active'] = $request->boolean('is_active', true);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($lock->image) {
                Storage::disk('public')->delete($lock->image);
            }
            
            $path = $request->file('image')->store('locks', 'public');
            $validated['image'] = $path;
        }
        
        // Handle invoice image upload
        if ($request->hasFile('invoice_image')) {
            // Delete old invoice image if exists
            if ($lock->invoice_image) {
                Storage::disk('public')->delete($lock->invoice_image);
            }
            
            $path = $request->file('invoice_image')->store('lock_invoices', 'public');
            $validated['invoice_image'] = $path;
        }
        
        $lock->update($validated);
        
        return redirect()->route('locks.index')
            ->with('success', __('Lock updated successfully.'));
    }

    /**
     * Remove the specified lock from storage.
     *
     * @param  \App\Models\Locks  $lock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Locks $lock)
    {
        // Check if lock has invoice items
        if ($lock->invoiceItems()->count() > 0) {
            return redirect()->route('locks.index')
                ->with('error', __('Cannot delete lock with associated invoice items.'));
        }
        
        // Delete images if they exist
        if ($lock->image) {
            Storage::disk('public')->delete($lock->image);
        }
        
        if ($lock->invoice_image) {
            Storage::disk('public')->delete($lock->invoice_image);
        }
        
        $lock->delete();
        
        return redirect()->route('locks.index')
            ->with('success', __('Lock deleted successfully.'));
    }
    
    /**
     * Toggle lock active status.
     *
     * @param  \App\Models\Locks  $lock
     * @return \Illuminate\Http\Response
     */
    public function toggleStatus(Locks $lock)
    {
        $lock->update(['is_active' => !$lock->is_active]);
        
        $message = $lock->is_active ? 
            __('Lock has been activated.') : 
            __('Lock has been deactivated.');
        
        return redirect()->back()->with('success', $message);
    }
    
    /**
     * Filter locks by stock status.
     *
     * @param  string  $status
     * @return \Illuminate\Http\Response
     */
    public function filterByStock($status)
    {
        if (!in_array($status, ['in', 'out'])) {
            return redirect()->route('locks.index')
                ->with('error', __('Invalid stock status specified.'));
        }
        
        // Get statistics for dashboard
        $totalLocks = Locks::count();
        $activeLocks = Locks::active()->count();
        $inactiveLocks = Locks::inactive()->count();
        $inStockLocks = Locks::inStock()->count();
        
        // Get unique suppliers for filter dropdown
        $suppliers = Locks::select('supplier')->distinct()->pluck('supplier');
        
        if ($status === 'in') {
            $locks = Locks::inStock()->paginate(10);
            $filterLabel = __('Showing only in-stock locks');
        } else {
            $locks = Locks::outOfStock()->paginate(10);
            $filterLabel = __('Showing only out-of-stock locks');
        }
        
        return view('locks.index', compact(
            'locks',
            'totalLocks',
            'activeLocks',
            'inactiveLocks',
            'inStockLocks',
            'suppliers'
        ))->with('filter', $filterLabel);
    }
    
    /**
     * Filter locks by status.
     *
     * @param  string  $status
     * @return \Illuminate\Http\Response
     */
    public function filterByStatus($status)
    {
        if (!in_array($status, ['active', 'inactive'])) {
            return redirect()->route('locks.index')
                ->with('error', __('Invalid status specified.'));
        }
        
        // Get statistics for dashboard
        $totalLocks = Locks::count();
        $activeLocks = Locks::active()->count();
        $inactiveLocks = Locks::inactive()->count();
        $inStockLocks = Locks::inStock()->count();
        
        // Get unique suppliers for filter dropdown
        $suppliers = Locks::select('supplier')->distinct()->pluck('supplier');
        
        if ($status === 'active') {
            $locks = Locks::active()->paginate(10);
            $filterLabel = __('Showing only active locks');
        } else {
            $locks = Locks::inactive()->paginate(10);
            $filterLabel = __('Showing only inactive locks');
        }
        
        return view('locks.index', compact(
            'locks',
            'totalLocks',
            'activeLocks',
            'inactiveLocks',
            'inStockLocks',
            'suppliers'
        ))->with('filter', $filterLabel);
    }
    
    /**
     * Filter locks by supplier.
     *
     * @param  string  $supplier
     * @return \Illuminate\Http\Response
     */
    public function filterBySupplier($supplier)
    {
        // Get statistics for dashboard
        $totalLocks = Locks::count();
        $activeLocks = Locks::active()->count();
        $inactiveLocks = Locks::inactive()->count();
        $inStockLocks = Locks::inStock()->count();
        
        // Get unique suppliers for filter dropdown
        $suppliers = Locks::select('supplier')->distinct()->pluck('supplier');
        
        // Check if the supplier exists
        if (!$suppliers->contains($supplier)) {
            return redirect()->route('locks.index')
                ->with('error', __('Invalid supplier specified.'));
        }
        
        $locks = Locks::where('supplier', $supplier)->paginate(10);
        
        return view('locks.index', compact(
            'locks',
            'totalLocks',
            'activeLocks',
            'inactiveLocks',
            'inStockLocks',
            'suppliers'
        ))->with('filter', __('Showing locks from supplier: :supplier', ['supplier' => $supplier]));
    }
    
    /**
     * Adjust lock quantity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Locks  $lock
     * @return \Illuminate\Http\Response
     */
    public function adjustQuantity(Request $request, Locks $lock)
    {
        $request->validate([
            'adjustment' => 'required|integer|not_in:0',
            'notes' => 'nullable|string'
        ]);
        
        $adjustment = $request->input('adjustment');
        
        // Prevent negative quantity
        if ($adjustment < 0 && abs($adjustment) > $lock->quantity) {
            return redirect()->back()
                ->with('error', __('Cannot reduce quantity below zero.'));
        }
        
        if ($adjustment > 0) {
            $lock->incrementQuantity($adjustment);
            $message = __('Added :count locks to inventory.', ['count' => $adjustment]);
        } else {
            $lock->decrementQuantity(abs($adjustment));
            $message = __('Removed :count locks from inventory.', ['count' => abs($adjustment)]);
        }
        
        // Add adjustment notes if provided
        if ($request->filled('notes')) {
            // In a real application, you might want to log this in a separate table
            // For now, we'll just append to the existing notes
            $noteUpdate = ($lock->notes ? $lock->notes . "\n\n" : '') . 
                          date('Y-m-d H:i') . ' - ' . 
                          __('Quantity adjusted by :count', ['count' => $adjustment]) . 
                          ($request->notes ? ': ' . $request->notes : '');
            
            $lock->update(['notes' => $noteUpdate]);
        }
        
        return redirect()->back()->with('success', $message);
    }
}