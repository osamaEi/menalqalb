@extends('app.index')

@section('content')
<div class="app white messagebox">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-4">
            <h3 class="text-center text-[24px] font-[900] text-[#242424] mb-3">{{ __('Complete the lock') }}</h3>
            <p class="text-center">{{ __('Here you can complete the lock setup or view details.') }}</p>
        </div>
    </div>
</div>
@endsection