@extends('admin.index')
@section('content')

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="h5">{{ __('bill_information') }}</h2>
                        <p><strong>{{ __('bill_number') }}:</strong> {{ $bill->id }}</p>
                        <p><strong>{{ __('date') }}:</strong> {{ $date }}</p>
                        <p><strong>{{ __('subject') }}:</strong> {{ $subject }}</p>
                        <p><strong>{{ __('amount') }}:</strong> {{ number_format($bill->amount, 2) }} {{ $bill->currency }}</p>
                        <p><strong>{{ __('status') }}:</strong> {{ $status }}</p>
                    </div>
                    <div class="col-md-6">
                        <h2 class="h5">{{ __('user_information') }}</h2>
                        <p><strong>{{ __('name') }}:</strong> {{ $bill->user ? $bill->user->name : __('unknown') }}</p>
                        <p><strong>{{ __('email') }}:</strong> {{ $bill->user ? $bill->user->email : __('not_available') }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.bills.pdf', $bill->id) }}" class="btn btn-success">{{ __('download_pdf') }}</a>
                    <a href="{{ route('admin.bills.index') }}" class="btn btn-secondary">{{ __('back') }}</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
@endsection