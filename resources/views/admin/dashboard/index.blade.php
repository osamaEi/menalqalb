@extends('admin.index')

@section('styles')
<style>
.dashboard-card {
    transition: all 0.3s;
}

.dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.dashboard-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    font-size: 24px;
}

.recent-item {
    padding: 10px;
    border-bottom: 1px solid #eee;
    transition: background-color 0.2s;
}

.recent-item:last-child {
    border-bottom: none;
}

.recent-item:hover {
    background-color: rgba(105, 108, 255, 0.05);
}

.chart-container {
    height: 250px;
}
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12 mb-4">
                <h4 class="fw-bold py-3 mb-0">{{ __('Dashboard') }}</h4>
            </div>
        </div>
        
        <!-- Cards & Locks Overview -->
        <div class="row mb-4">
            <div class="col-12">
                <h5 class="fw-semibold mb-3">{{ __('Cards & Locks Overview') }}</h5>
            </div>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="card-title mb-0">{{ __('Cards') }}</h5>
                                <small class="text-muted">{{ __('Total Cards') }}</small>
                            </div>
                            <div class="dashboard-icon bg-label-primary">
                                <i class="ri-bank-card-line"></i>
                            </div>
                        </div>
                        <h2 class="mb-1">{{ $counts['cards'] }}</h2>
                        <div class="d-flex align-items-center gap-1 mt-2">
                            <a href="{{ route('cards.index') }}" class="btn btn-sm btn-primary">{{ __('View All') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="card-title mb-0">{{ __('Card Types') }}</h5>
                                <small class="text-muted">{{ __('Active/Total') }}</small>
                            </div>
                            <div class="dashboard-icon bg-label-success">
                                <i class="ri-stack-line"></i>
                            </div>
                        </div>
                        <h2 class="mb-1">{{ $counts['active_card_types'] }}/{{ $counts['card_types'] }}</h2>
                        <div class="d-flex align-items-center gap-1 mt-2">
                            <a href="{{ route('card_types.index') }}" class="btn btn-sm btn-primary">{{ __('View All') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="card-title mb-0">{{ __('Ready Cards') }}</h5>
                                <small class="text-muted">{{ __('Sets/Total Cards') }}</small>
                            </div>
                            <div class="dashboard-icon bg-label-info">
                                <i class="ri-archive-line"></i>
                            </div>
                        </div>
                        <h2 class="mb-1">{{ $counts['ready_cards'] }}/{{ $counts['total_card_count'] }}</h2>
                        <div class="d-flex align-items-center gap-1 mt-2">
                            <a href="{{ route('ready-cards.index') }}" class="btn btn-sm btn-primary">{{ __('View All') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="card-title mb-0">{{ __('Locks') }}</h5>
                                <small class="text-muted">{{ __('In Stock/Total') }}</small>
                            </div>
                            <div class="dashboard-icon bg-label-warning">
                                <i class="ri-lock-line"></i>
                            </div>
                        </div>
                        <h2 class="mb-1">{{ $counts['in_stock_locks'] }}/{{ $counts['locks'] }}</h2>
                        <div class="d-flex align-items-center gap-1 mt-2">
                            <a href="{{ route('locks.index') }}" class="btn btn-sm btn-primary">{{ __('View All') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Financial Overview -->
        <div class="row mb-4">
            <div class="col-12">
                <h5 class="fw-semibold mb-3">{{ __('Financial Overview') }}</h5>
            </div>
            <div class="col-sm-6 col-lg-4 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="card-title mb-0">{{ __('Lock Inventory Value') }}</h5>
                                <small class="text-muted">{{ __('Total Cost') }}</small>
                            </div>
                            <div class="dashboard-icon bg-label-primary">
                                <i class="ri-money-dollar-circle-line"></i>
                            </div>
                        </div>
                        <h2 class="mb-1">{{ number_format($counts['total_lock_cost'], 2) }}</h2>
                        <div class="d-flex align-items-center mt-3 text-success">
                            <span>{{ $counts['in_stock_locks'] }} {{ __('locks in stock') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="card-title mb-0">{{ __('Ready Cards Value') }}</h5>
                                <small class="text-muted">{{ __('Total Cost') }}</small>
                            </div>
                            <div class="dashboard-icon bg-label-success">
                                <i class="ri-wallet-line"></i>
                            </div>
                        </div>
                        <h2 class="mb-1">{{ number_format($counts['total_ready_card_cost'], 2) }}</h2>
                        <div class="d-flex align-items-center mt-3 text-success">
                            <span>{{ $counts['total_card_count'] }} {{ __('cards issued') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="card-title mb-0">{{ __('Users') }}</h5>
                                <small class="text-muted">{{ __('Total Registered') }}</small>
                            </div>
                            <div class="dashboard-icon bg-label-info">
                                <i class="ri-user-line"></i>
                            </div>
                        </div>
                        <h2 class="mb-1">{{ $counts['users'] }}</h2>
                        <div class="d-flex align-items-center mt-3">
                            <a href="#" class="btn btn-sm btn-primary">{{ __('Manage Users') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Charts & Recent Activity -->
        <div class="row">
            <!-- Card Type Distribution Chart -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('Card Type Distribution') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="cardTypeChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Activity Tabs -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('Recent Activity') }}</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="nav nav-tabs nav-fill" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-cards" role="tab">{{ __('Cards') }}</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-ready-cards" role="tab">{{ __('Ready Cards') }}</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-locks" role="tab">{{ __('Locks') }}</button>
                            </li>
                        </ul>
                        <div class="tab-content p-0">
                            <!-- Recent Cards -->
                            <div class="tab-pane fade show active" id="tab-cards" role="tabpanel">
                                <div class="list-group list-group-flush">
                                    @forelse($recentCards as $card)
                                        <div class="recent-item">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="fw-medium">Card #{{ $card->id }}</span>
                                                <small class="text-muted">{{ $card->created_at->diffForHumans() }}</small>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                @if(isset($card->image) && $card->image)
                                                    <div class="avatar me-2">
                                                        <img src="{{ asset('storage/' . $card->image) }}" alt="Card" class="rounded">
                                                    </div>
                                                @else
                                                    <div class="avatar me-2">
                                                        <span class="avatar-initial rounded bg-label-primary">
                                                            <i class="ri-bank-card-line"></i>
                                                        </span>
                                                    </div>
                                                @endif
                                                <div>
                                                    <span class="d-block">{{ isset($card->serial) ? $card->serial : 'N/A' }}</span>
                                                    <small class="text-muted">
                                                        {{ isset($card->card_type) ? $card->card_type->name_en : 'N/A' }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="p-4 text-center">
                                            <p class="mb-0">{{ __('No recent cards available.') }}</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            
                            <!-- Recent Ready Cards -->
                            <div class="tab-pane fade" id="tab-ready-cards" role="tabpanel">
                                <div class="list-group list-group-flush">
                                    @forelse($recentReadyCards as $readyCard)
                                        <div class="recent-item">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="fw-medium">Ready Card #{{ $readyCard->id }}</span>
                                                <small class="text-muted">{{ $readyCard->created_at->diffForHumans() }}</small>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar me-2">
                                                    <span class="avatar-initial rounded bg-primary">
                                                        {{ strtoupper(substr($readyCard->customer->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="d-block">{{ $readyCard->customer->name }}</span>
                                                    <small class="text-muted">
                                                        {{ __('Cards') }}: {{ $readyCard->card_count }} | 
                                                        {{ __('Cost') }}: {{ number_format($readyCard->cost, 2) }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="p-4 text-center">
                                            <p class="mb-0">{{ __('No recent ready cards available.') }}</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            
                            <!-- Recent Locks -->
                            <div class="tab-pane fade" id="tab-locks" role="tabpanel">
                                <div class="list-group list-group-flush">
                                    @forelse($recentLocks as $lock)
                                        <div class="recent-item">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="fw-medium">Lock #{{ $lock->id }}</span>
                                                <small class="text-muted">{{ $lock->created_at->diffForHumans() }}</small>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                @if($lock->image)
                                                    <div class="avatar me-2">
                                                        <img src="{{ asset('storage/' . $lock->image) }}" alt="Lock" class="rounded">
                                                    </div>
                                                @else
                                                    <div class="avatar me-2">
                                                        <span class="avatar-initial rounded bg-label-warning">
                                                            <i class="ri-lock-line"></i>
                                                        </span>
                                                    </div>
                                                @endif
                                                <div>
                                                    <span class="d-block">{{ $lock->supplier }}</span>
                                                    <small class="text-muted">
                                                        {{ __('Quantity') }}: {{ $lock->quantity }} | 
                                                        {{ __('Cost') }}: {{ number_format($lock->cost, 2) }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="p-4 text-center">
                                            <p class="mb-0">{{ __('No recent locks available.') }}</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(function() {
    // Card Type Distribution Chart
    const cardTypeLabels = @json($cardTypeDistribution->pluck('name_en'));
    const cardTypeData = @json($cardTypeDistribution->pluck('cards_count'));
    const cardTypeColors = [
        '#696cff', '#03c3ec', '#71dd37', '#ffab00', '#ff3e1d',
        '#8592a3', '#03c9d7', '#7367f0', '#fd7e14', '#6610f2'
    ];
    
    const cardTypeChart = new Chart(
        document.getElementById('cardTypeChart'),
        {
            type: 'pie',
            data: {
                labels: cardTypeLabels,
                datasets: [{
                    data: cardTypeData,
                    backgroundColor: cardTypeColors.slice(0, cardTypeLabels.length),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        }
    );
});
</script>
@endsection