<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Card;
use App\Models\CardType;
use App\Models\ReadyCard;
use App\Models\Locks;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display the dashboard page with counts of all models.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get counts for all models
        $counts = [
            'cards' => Card::count(),
            'card_types' => CardType::count(),
            'ready_cards' => ReadyCard::count(),
            'locks' => Locks::count(),
            'users' => User::count(),
            'active_locks' => Locks::active()->count(),
            'inactive_locks' => Locks::inactive()->count(),
            'in_stock_locks' => Locks::inStock()->count(),
            'out_of_stock_locks' => Locks::outOfStock()->count(),
            'active_card_types' => CardType::active()->count(),
            'inactive_card_types' => CardType::inactive()->count(),
            'total_card_count' => ReadyCard::sum('card_count'),
            'total_lock_cost' => Locks::sum('cost'),
            'total_ready_card_cost' => ReadyCard::sum('cost'),
        ];
        
        // Get recent items
        $recentCards = Card::latest()->take(5)->get();
        $recentReadyCards = ReadyCard::with('customer')->latest()->take(5)->get();
        $recentLocks = Locks::latest()->take(5)->get();
        
        // Get data for charts
        $cardTypeDistribution = CardType::withCount('cards')->get();
        
        return view('admin.dashboard.index', compact(
            'counts',
            'recentCards',
            'recentReadyCards',
            'recentLocks',
            'cardTypeDistribution'
        ));
    }
}