<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Request;
use App\Models\LocksWReadyCard;
use Illuminate\Http\Request as HttpRequest;

class RequestController extends Controller
{
    public function index(HttpRequest $request)
    {
        $query = Request::with(['locksWReadyCard', 'user']); // Add user relationship

        // Apply filters
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('item_id') && $request->item_id != '') {
            $query->where('locks_w_ready_card_id', $request->item_id);
        }

        if ($request->has('user_id') && $request->user_id != '') {
            $query->where('user_id', $request->user_id);
        }

        $requests = $query->recent()->paginate(15);

        // Statistics
        $totalRequests = Request::count();
        $pendingRequests = Request::pending()->count();
        $approvedRequests = Request::approved()->count();
        $completedRequests = Request::completed()->count();

        return view('admin.requests.index', compact(
            'requests',
            'totalRequests',
            'pendingRequests',
            'approvedRequests',
            'completedRequests'
        ));
    }

  

    // Update the existing create method to redirect to a selection page
public function create()
{
    return view('admin.requests.select-type');
}
    
    public function createLock()
    {
        $locks = LocksWReadyCard::where('type', 'lock')->active()->get();
        $users = User::all(); // Get all users
        
        return view('admin.requests.create-lock', compact('locks', 'users'));
    }
    
    public function createReadyCard()
    {
        $readyCards = LocksWReadyCard::where('type', 'read_card')->active()->get();
        $users = User::all(); // Get all users
        
        return view('admin.requests.create-ready-card', compact('readyCards', 'users'));
    }
    
    public function store(HttpRequest $request)
    {
        $validated = $request->validate([
            'locks_w_ready_card_id' => 'required|exists:locks_w_ready_cards,id',
            'user_id' => 'required|exists:users,id', // Add user validation
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'quantity' => 'required|integer|min:1'
        ]);
    
        $requestModel = Request::create($validated);
    
        return redirect()->route('requests.index')
            ->with('success', 'Request created successfully');
    }

    public function show(Request $request)
    {
        $request->load('locksWReadyCard');
        return view('admin.requests.show', compact('request'));
    }

    public function edit(Request $request)
    {
        $items = LocksWReadyCard::active()->get();
        return view('admin.requests.edit', compact('request', 'items'));
    }

    public function update(HttpRequest $httpRequest, Request $request)
    {
        $validated = $httpRequest->validate([
            'locks_w_ready_card_id' => 'required|exists:locks_w_ready_cards,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:pending,processing,approved,rejected,completed'
        ]);

        $request->update($validated);

        return redirect()->route('requests.index')
            ->with('success', 'Request updated successfully');
    }

    public function destroy(Request $request)
    {
        $request->delete();

        return redirect()->route('requests.index')
            ->with('success', 'Request deleted successfully');
    }

    // Status update methods
    public function updateStatus(Request $request, $status)
    {
        if (!in_array($status, ['pending', 'processing', 'approved', 'rejected', 'completed'])) {
            return response()->json([
                'success' => false,
                'message' => __('Invalid status')
            ], 400);
        }
    
        try {
            $request->update(['status' => $status]);
            
            // Get status labels in the current language
            $statusLabels = [
                'pending' => __('Pending'),
                'processing' => __('Processing'),
                'approved' => __('Approved'),
                'rejected' => __('Rejected'),
                'completed' => __('Completed')
            ];
            
            // Get updated statistics
            $statistics = [
                'totalRequests' => \App\Models\Request::count(),
                'pendingRequests' => \App\Models\Request::pending()->count(),
                'approvedRequests' => \App\Models\Request::approved()->count(),
                'completedRequests' => \App\Models\Request::completed()->count(),
            ];
            
            return response()->json([
                'success' => true,
                'message' => __('Status changed to :status successfully', ['status' => $statusLabels[$status]]),
                'status' => $status,
                'statusLabel' => $statusLabels[$status],
                'statistics' => $statistics
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to update status. Please try again.')
            ], 500);
        }
    }
    public function approve(Request $request)
    {
        $request->approve();
        return redirect()->back()->with('success', 'Request approved successfully');
    }

    public function reject(Request $request)
    {
        $request->reject();
        return redirect()->back()->with('success', 'Request rejected successfully');
    }

    public function markAsCompleted(Request $request)
    {
        $request->markAsCompleted();
        return redirect()->back()->with('success', 'Request marked as completed');
    }
}