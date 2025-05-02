@extends('admin.index')

@section('styles')
<style>
.card-image {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.image-modal {
    max-width: 90%;
    max-height: 90vh;
}

.info-label {
    font-weight: 500;
    color: #566a7f;
}

.status-badge {
    font-size: 0.85rem;
    padding: 0.35rem 0.5rem;
}

.card-item {
    padding: 15px;
    border-bottom: 1px solid #f0f0f0;
}

.card-item:last-child {
    border-bottom: none;
}

.card-details-card {
    height: 100%;
}

.cards-list {
    height: 100%;
    max-height: 400px;
    overflow-y: auto;
}

.customer-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: white;
}
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold py-3 mb-0">{{ __('Ready Card Details') }}</h4>
                    <div>
                        <a href="{{ route('ready-cards.edit', $readyCard->id) }}" class="btn btn-primary me-2">
                            <i class="ri-pencil-line me-1"></i> {{ __('Edit') }}
                        </a>
                        <a href="{{ route('ready-cards.index') }}" class="btn btn-secondary">
                            <i class="ri-arrow-left-line me-1"></i> {{ __('Back to Ready Cards') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <div class="row">
            <!-- Ready Card Image -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('Card Image') }}</h5>
                    </div>
                    <div class="card-body text-center">
                        @if($readyCard->received_card_image)
                            <div class="mb-4">
                                <img 
                                    src="{{ asset('storage/' . $readyCard->received_card_image) }}" 
                                    alt="{{ __('Ready Card Image') }}" 
                                    class="card-image cursor-pointer mb-2" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#imageModal"
                                    style="max-height: 300px;">
                            </div>
                        @else
                            <div class="alert alert-light border text-center mb-0 h-100 d-flex align-items-center justify-content-center">
                                <div>
                                    <i class="ri-image-line ri-3x mb-2"></i>
                                    <p>{{ __('No card image available') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Ready Card Details -->
            <div class="col-md-4 mb-4">
                <div class="card card-details-card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('Ready Card Information') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <span class="info-label d-block mb-1">{{ __('ID') }}:</span>
                            <span class="badge bg-label-primary">#{{ $readyCard->id }}</span>
                        </div>
                        
                        <div class="mb-3">
                            <span class="info-label d-block mb-1">{{ __('Customer') }}:</span>
                            <div class="d-flex align-items-center">
                                <div class="customer-avatar bg-primary me-2">
                                    {{ strtoupper(substr($readyCard->customer->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h5 class="mb-0">{{ $readyCard->customer->name }}</h5>
                                    <small>{{ $readyCard->customer->email }}</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <span class="info-label d-block mb-1">{{ __('Card Count') }}:</span>
                            <h5 class="mb-0">{{ $readyCard->card_count }}</h5>
                        </div>
                        
                        <div class="mb-3">
                            <span class="info-label d-block mb-1">{{ __('Cost') }}:</span>
                            <h5 class="mb-0">{{ number_format($readyCard->cost, 2) }}</h5>
                        </div>
                        
                        <div class="mb-3">
                            <span class="info-label d-block mb-1">{{ __('Created At') }}:</span>
                            <span>{{ $readyCard->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        
                        <div>
                            <span class="info-label d-block mb-1">{{ __('Last Updated') }}:</span>
                            <span>{{ $readyCard->updated_at->format('M d, Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Ready Card Cards List -->
            <div class="col-md-4 mb-4">
                <div class="card card-details-card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('Included Cards') }}</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="cards-list">
                            @forelse($readyCard->items as $item)
                                <div class="card-item">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="fw-medium">Card #{{ $item->card->id }}</span>
                                        @if(isset($item->card->card_type))
                                            <span class="badge bg-label-info">{{ $item->card->card_type->name_en ?? 'N/A' }}</span>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center">
                                        @if(isset($item->card->image) && $item->card->image)
                                            <div class="avatar me-2">
                                                <img src="{{ asset('storage/' . $item->card->image) }}" alt="Card" class="rounded">
                                            </div>
                                        @else
                                            <div class="avatar me-2">
                                                <span class="avatar-initial rounded bg-label-primary">
                                                    <i class="ri-credit-card-line"></i>
                                                </span>
                                            </div>
                                        @endif
                                        <div>
                                            <span class="d-block">{{ isset($item->card->serial) ? $item->card->serial : 'N/A' }}</span>
                                            <small class="text-muted">
                                                {{ isset($item->card->code) ? $item->card->code : 'N/A' }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 text-center">
                                    <p class="mb-0">{{ __('No cards associated with this ready card.') }}</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12 text-end">
                <form action="{{ route('ready-cards.destroy', $readyCard->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('Are you sure you want to delete this ready card?') }}')">
                        <i class="ri-delete-bin-line me-1"></i> {{ __('Delete Ready Card') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">{{ __('Ready Card Image') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                @if($readyCard->received_card_image)
                    <img src="{{ asset('storage/' . $readyCard->received_card_image) }}" class="image-modal" alt="Ready Card Image">
                @else
                    <div class="alert alert-light border">
                        <i class="ri-image-line ri-3x mb-2"></i>
                        <p>{{ __('No image available') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
$(function() {
    // Auto-hide alert messages after 5 seconds
    setTimeout(function() {
        $('.alert-dismissible').alert('close');
    }, 5000);
});
</script>
@endsection