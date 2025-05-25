@extends('app.index')

@section('content')
<div class="app white messagebox pb-[25px] !overflow-auto">
    <div class="header !mb-0">
        <a href="{{ route('app.greetings.show', $message->id) }}" class="z-50 !p-2 !absolute left-0 !mt-2 icondoor">
            <i class="fas fa-arrow-alt-circle-left text-white text-[19px] pl-3 w-[65px]"></i>
        </a>
    </div>
    <p class="text-center text-[16px] mb-2 leading-[29px] max-w-[327px] mx-auto font-[400] text-[#4B4B4B] z-50 mt-0 relative">
        {{ __('Greeting send time') }}
    </p>
    
    <div class="flex flex-col items-center justify-center !bg-transparent p-5 text-center mt-5 rounded-[13px] mx-2 relative">
        <div class="bg-white rounded-lg p-6 shadow-md w-full">
            <h2 class="text-xl font-bold text-[#B62326] mb-4">{{ __('Scheduled send time') }}</h2>
            
            <div class="flex justify-center items-center my-8">
                <div class="text-center">
                    <div class="bg-gray-100 rounded-full w-28 h-28 flex items-center justify-center mb-4 mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#B62326" class="w-16 h-16">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-2xl font-bold mb-1">{{ $message->scheduled_at ? $message->scheduled_at->format('h:i A') : '--:-- --' }}</p>
                    <p class="text-lg">{{ $message->scheduled_at ? $message->scheduled_at->format('d/m/Y') : '--/--/----' }}</p>
                </div>
            </div>
            
            <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                <p class="text-gray-700">
                    @if($message->scheduled_at)
                        @if($message->scheduled_at->isPast())
                            <span class="text-green-600 font-bold">{{ __('The send time has arrived.') }}</span>
                            @if($message->status == 'sent')
                                {{ __('The greeting was sent at the specified time.') }}
                            @else
                                {{ __('You can send the greeting manually now.') }}
                            @endif
                        @else
                            <span class="text-blue-600 font-bold">{{ __('The greeting is scheduled for sending.') }}</span>
                            {{ __('The greeting will be sent automatically at the specified time.') }}
                        @endif
                    @else
                        {{ __('No send time has been specified. Please edit the card to set a send time.') }}
                    @endif
                </p>
            </div>
        </div>
    </div>
    
    <div class="flex items-center justify-center !bg-transparent p-3 text-center rounded-[13px] mx-2 mt-4">
        <a href="{{ route('app.greetings.show', $message->id) }}" class="h-[48px] w-[50%] bg-[#B62326] text-[#FFF] p-2 text-[14px] text-center flex items-center justify-center gap-1"
            style="border-top-right-radius: 13px; border-bottom-left-radius: 13px;">
            {{ __('Return to card details') }}
        </a>
    </div>
</div>
@endsection