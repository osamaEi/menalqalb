@extends('app.index')

@section('content')
<div class="app white messagebox">
  
    <div class="row justify-content-center">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold mb-4">{{ $title }}</h1>
            <div class="prose max-w-none">
                {!! $description !!}
            </div>
        </div>
    </div>
</div>
@endsection