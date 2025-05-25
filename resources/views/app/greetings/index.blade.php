@extends('app.index')

@section('content')
<div class="app white messagebox">
    <h3 class="localized text-center text-[24px] text-[#242424] font-[900] z-50 relative" data-content="{{ __('Sent greetings') }}">
        {{ __('Sent greetings') }}
    </h3>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-4">
            <div class="All_Button lang Devices">
                <ul class="allDevice">
                    @forelse($messages as $message)
                    <li class="relative !mb-[50px]">
                        <div class="w-[50px] text-[12px] h-[50px] flex items-center justify-center p-3 absolute right-[-5px] top-[-4px] bg-[#B62326] text-white rounded-full">
                            20<br />{{ __('Point') }}
                        </div>
                        <img src="{{ asset('storage/'. $message->card->file_path) }}" alt="{{ __('Card image') }}" class="mx-auto mt-[-32px]">
                        <a class="border-0 w-100 p-0 m-0" href="{{ route('app.greetings.show', $message->id) }}">
                            <div class="mt-[-33px]">
                                <p class="name flex items-center justify-end pr-2 gap-2">
                                    {{ $message->recipient_name ?? __('Not specified') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M12.1596 11.62C12.1296 11.62 12.1096 11.62 12.0796 11.62C12.0296 11.61 11.9596 11.61 11.8996 11.62C8.99957 11.53 6.80957 9.25 6.80957 6.44C6.80957 3.58 9.13957 1.25 11.9996 1.25C14.8596 1.25 17.1896 3.58 17.1896 6.44C17.1796 9.25 14.9796 11.53 12.1896 11.62C12.1796 11.62 12.1696 11.62 12.1596 11.62ZM11.9996 2.75C9.96957 2.75 8.30957 4.41 8.30957 6.44C8.30957 8.44 9.86957 10.05 11.8596 10.12C11.9096 10.11 12.0496 10.11 12.1796 10.12C14.1396 10.03 15.6796 8.42 15.6896 6.44C15.6896 4.41 14.0296 2.75 11.9996 2.75Z" fill="#4B4B4B"></path>
                                        <path d="M12.1696 22.55C10.2096 22.55 8.23961 22.05 6.74961 21.05C5.35961 20.13 4.59961 18.87 4.59961 17.5C4.59961 16.13 5.35961 14.86 6.74961 13.93C9.74961 11.94 14.6096 11.94 17.5896 13.93C18.9696 14.85 19.7396 16.11 19.7396 17.48C19.7396 18.85 18.9796 20.12 17.5896 21.05C16.0896 22.05 14.1296 22.55 12.1696 22.55ZM7.57961 15.19C6.61961 15.83 6.09961 16.65 6.09961 17.51C6.09961 18.36 6.62961 19.18 7.57961 19.81C10.0696 21.48 14.2696 21.48 16.7596 19.81C17.7196 19.17 18.2396 18.35 18.2396 17.49C18.2396 16.64 17.7096 15.82 16.7596 15.19C14.2696 13.53 10.0696 13.53 7.57961 15.19Z" fill="#4B4B4B"></path>
                                    </svg>
                                </p>
                                <div class="flex justify-between items-center px-2">
                                    <p class="name flex items-center justify-center gap-2 w-[149px]">
                                        {{ $message->scheduled_at ? $message->scheduled_at->format('h:i A') : '-- : --' }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12 22C6.48 22 2 17.52 2 12C2 6.48 6.48 2 12 2C17.52 2 22 6.48 22 12C22 17.52 17.52 22 12 22ZM12 3.5C7.31 3.5 3.5 7.31 3.5 12C3.5 16.69 7.31 20.5 12 20.5C16.69 20.5 20.5 16.69 20.5 12C20.5 7.31 16.69 3.5 12 3.5Z" fill="#4B4B4B" />
                                            <path d="M12 13.5C11.59 13.5 11.25 13.16 11.25 12.75V7.25C11.25 6.84 11.59 6.5 12 6.5C12.41 6.5 12.75 6.84 12.75 7.25V12.75C12.75 13.16 12.41 13.5 12 13.5Z" fill="#4B4B4B" />
                                            <path d="M15.54 15.54C15.39 15.54 15.24 15.49 15.12 15.38L11.62 12.88C11.39 12.71 11.25 12.44 11.25 12.15C11.25 11.86 11.39 11.59 11.62 11.42C11.98 11.16 12.5 11.21 12.88 11.62L15.54 13.96C15.92 14.36 15.89 14.98 15.46 15.35C15.32 15.49 15.43 15.54 15.54 15.54Z" fill="#4B4B4B" />
                                        </svg>
                                    </p>
                                    <p class="name flex items-center justify-end gap-2 w-[149px]">
                                        {{ $message->scheduled_at ? $message->scheduled_at->format('d/m/Y') : '--/--/----' }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M8 5.75C7.59 5.75 7.25 5.41 7.25 5V2C7.25 1.59 7.59 1.25 8 1.25C8.41 1.25 8.75 1.59 8.75 2V5C8.75 5.41 8.41 5.75 8 5.75Z" fill="#4B4B4B" />
                                            <path d="M16 5.75C15.59 5.75 15.25 5.41 15.25 5V2C15.25 1.59 15.59 1.25 16 1.25C16.41 1.25 16.75 1.59 16.75 2V5C16.75 5.41 16.41 5.75 16 5.75Z" fill="#4B4B4B" />
                                            <path d="M20.5 9.83984H3.5C3.09 9.83984 2.75 9.49984 2.75 9.08984C2.75 8.67984 3.09 8.33984 3.5 8.33984H20.5C20.91 8.33984 21.25 8.67984 21.25 9.08984C21.25 9.49984 20.91 9.83984 20.5 9.83984Z" fill="#4B4B4B" />
                                            <path d="M16 22.75H8C4.35 22.75 2.25 20.65 2.25 17V8.5C2.25 4.85 4.35 2.75 8 2.75H16C19.65 2.75 21.75 4.85 21.75 8.5V17C21.75 20.65 19.65 22.75 16 22.75ZM8 4.25C5.14 4.25 3.75 5.64 3.75 8.5V17C3.75 19.86 5.14 21.25 8 21.25H16C18.86 21.25 20.25 19.86 20.25 17V8.5C20.25 5.64 18.86 4.25 16 4.25H8Z" fill="#4B4B4B" />
                                        </svg>
                                    </p>
                                </div>
                                <div class="flex justify-between items-center px-2">
                                    <p class="name flex items-center justify-center gap-2">
                                        {{ $message->mainCategory ? $message->mainCategory->name : __('Not specified') }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12.3701 8.87988H17.6201" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M6.37988 8.87988L7.12988 9.62988L9.37988 7.37988" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M12.3701 15.8799H17.6201" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M6.37988 15.8799L7.12988 16.6299L9.37988 14.3799" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </p>
                                    <p class="name flex items-center justify-center gap-2">
                                        {{ $message->subCategory ? $message->subCategory->name : __('Not specified') }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12.3701 8.87988H17.6201" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M6.37988 8.87988L7.12988 9.62988L9.37988 7.37988" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M12.3701 15.8799H17.6201" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M6.37988 15.8799L7.12988 16.6299L9.37988 14.3799" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </p>
                                </div>
                            </div>
                            
                            <div style="border-top-left-radius: 0px !important; border-top-right-radius: 0px !important;" 
                                class="flex justify-between items-center px-3 mb-[7px] h-[48px] rounded-[15px] relative bottom-[-0px] bg-[#000]">
                                <p class="text-white name flex items-center justify-center gap-2 w-[149px]">
                                    {{ $message->card && $message->card->type ? $message->card->type : __('Image') }}
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="white" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M9 10C10.1046 10 11 9.10457 11 8C11 6.89543 10.1046 6 9 6C7.89543 6 7 6.89543 7 8C7 9.10457 7.89543 10 9 10Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M2.66992 18.9496L7.59992 15.6396C8.38992 15.1096 9.52992 15.1696 10.2399 15.7796L10.5699 16.0696C11.3499 16.7396 12.6099 16.7396 13.3899 16.0696L17.5499 12.4996C18.3299 11.8296 19.5899 11.8296 20.3699 12.4996L21.9999 13.8996" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </p>
                                <p class="text-white name flex items-center justify-center gap-2 w-[169px]">
                                    @if($message->status == 'sent')
                                    {{ __('Sent') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 160 160" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M53.4778 15.9697C58.5112 6.47392 68.4948 0 80 0C91.5052 0 101.489 6.47391 106.522 15.9697C116.796 12.8143 128.433 15.296 136.569 23.4315C144.704 31.5669 147.186 43.2041 144.03 53.4778C153.526 58.5112 160 68.4948 160 80C160 91.5052 153.526 101.489 144.03 106.522C147.186 116.796 144.704 128.433 136.569 136.569C128.433 144.704 116.796 147.186 106.522 144.03C101.489 153.526 91.5052 160 80 160C68.4947 160 58.5112 153.526 53.4778 144.03C43.2041 147.186 31.5669 144.704 23.4314 136.569C15.2961 128.433 12.8144 116.796 15.9698 106.522C6.47392 101.489 0 91.5052 0 80C0 68.4948 6.47391 58.5112 15.9697 53.4778C12.8143 43.2041 15.296 31.5669 23.4314 23.4314C31.5669 15.296 43.2041 12.8143 53.4778 15.9697ZM118.1 59.9246C118.686 60.5104 118.686 61.4602 118.1 62.0459L70.7236 109.422C70.1378 110.008 69.1881 110.008 68.6023 109.422L42.4393 83.2591C41.8536 82.6734 41.8536 81.7236 42.4393 81.1378L50.9246 72.6525C51.5104 72.0668 52.4602 72.0668 53.0459 72.6525L68.6023 88.2089C69.1881 88.7947 70.1378 88.7947 70.7236 88.2089L107.493 51.4393C108.079 50.8536 109.029 50.8536 109.614 51.4393L118.1 59.9246Z" fill="#00B1BB" />
                                        <path d="M118.1 62.0459C118.686 61.4602 118.686 60.5104 118.1 59.9246L109.614 51.4393C109.029 50.8536 108.079 50.8536 107.493 51.4393L70.7236 88.2089C70.1378 88.7947 69.1881 88.7947 68.6023 88.2089L53.0459 72.6525C52.4602 72.0668 51.5104 72.0668 50.9246 72.6525L42.4393 81.1378C41.8536 81.7236 41.8536 82.6734 42.4393 83.2591L68.6023 109.422C69.1881 110.008 70.1378 110.008 70.7236 109.422L118.1 62.0459Z" fill="white" />
                                    </svg>
                                    @elseif($message->response)
                                    {{ __('Response received') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 160 160" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M53.4778 15.9697C58.5112 6.47392 68.4948 0 80 0C91.5052 0 101.489 6.47391 106.522 15.9697C116.796 12.8143 128.433 15.296 136.569 23.4315C144.704 31.5669 147.186 43.2041 144.03 53.4778C153.526 58.5112 160 68.4948 160 80C160 91.5052 153.526 101.489 144.03 106.522C147.186 116.796 144.704 128.433 136.569 136.569C128.433 144.704 116.796 147.186 106.522 144.03C101.489 153.526 91.5052 160 80 160C68.4947 160 58.5112 153.526 53.4778 144.03C43.2041 147.186 31.5669 144.704 23.4314 136.569C15.2961 128.433 12.8144 116.796 15.9698 106.522C6.47392 101.489 0 91.5052 0 80C0 68.4948 6.47391 58.5112 15.9697 53.4778C12.8143 43.2041 15.296 31.5669 23.4314 23.4314C31.5669 15.296 43.2041 12.8143 53.4778 15.9697ZM118.1 59.9246C118.686 60.5104 118.686 61.4602 118.1 62.0459L70.7236 109.422C70.1378 110.008 69.1881 110.008 68.6023 109.422L42.4393 83.2591C41.8536 82.6734 41.8536 81.7236 42.4393 81.1378L50.9246 72.6525C51.5104 72.0668 52.4602 72.0668 53.0459 72.6525L68.6023 88.2089C69.1881 88.7947 70.1378 88.7947 70.7236 88.2089L107.493 51.4393C108.079 50.8536 109.029 50.8536 109.614 51.4393L118.1 59.9246Z" fill="#DDAE00" />
                                        <path d="M118.1 62.0459C118.686 61.4602 118.686 60.5104 118.1 59.9246L109.614 51.4393C109.029 50.8536 108.079 50.8536 107.493 51.4393L70.7236 88.2089C70.1378 88.7947 69.1881 88.7947 68.6023 88.2089L53.0459 72.6525C52.4602 72.0668 51.5104 72.0668 50.9246 72.6525L42.4393 81.1378C41.8536 81.7236 41.8536 82.6734 42.4393 83.2591L68.6023 109.422C69.1881 110.008 70.1378 110.008 70.7236 109.422L118.1 62.0459Z" fill="white" />
                                    </svg>
                                    @elseif($message->status == 'cancelled')
                                    {{ __('Cancelled') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M14.9 2H9.10001C8.42001 2 7.46 2.4 6.98 2.88L2.88 6.98001C2.4 7.46001 2 8.42001 2 9.10001V14.9C2 15.58 2.4 16.54 2.88 17.02L6.98 21.12C7.46 21.6 8.42001 22 9.10001 22H14.9C15.58 22 16.54 21.6 17.02 21.12L21.12 17.02C21.6 16.54 22 15.58 22 14.9V9.10001C22 8.42001 21.6 7.46001 21.12 6.98001L17.02 2.88C16.54 2.4 15.58 2 14.9 2Z" fill="white" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M8.5 15.5L15.5 8.5" stroke="#FF0004" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M15.5 15.5L8.5 8.5" stroke="#FF0004" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    @elseif($message->scheduled_at && $message->scheduled_at->isFuture())
                                    {{ __('Awaiting send time') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="white">
                                        <path d="M11.9999 22.7599C10.9099 22.7599 9.82992 22.4399 8.97992 21.8099L4.6799 18.5999C3.5399 17.7499 2.6499 15.9699 2.6499 14.5599V7.11994C2.6499 5.57994 3.77992 3.93994 5.22992 3.39994L10.2199 1.52994C11.2099 1.15994 12.7699 1.15994 13.7599 1.52994L18.7499 3.39994C20.1999 3.93994 21.3299 5.57994 21.3299 7.11994V14.5499C21.3299 15.9699 20.4399 17.7399 19.2999 18.5899L14.9999 21.7999C14.1699 22.4399 13.0899 22.7599 11.9999 22.7599Z" fill="white" />
                                        <path d="M12 16.25C9.38 16.25 7.25 14.12 7.25 11.5C7.25 8.88 9.38 6.75 12 6.75C14.62 6.75 16.75 8.88 16.75 11.5C16.75 14.12 14.62 16.25 12 16.25ZM12 8.25C10.21 8.25 8.75 9.71 8.75 11.5C8.75 13.29 10.21 14.75 12 14.75C13.79 14.75 15.25 13.29 15.25 11.5C15.25 9.71 13.79 8.25 12 8.25Z" fill="white" />
                                        <path d="M10.9999 13.2498C10.7499 13.2498 10.4999 13.1198 10.3599 12.8898C10.1499 12.5298 10.2599 12.0698 10.6199 11.8598L11.3799 11.3998C11.4599 11.3498 11.4999 11.2698 11.4999 11.1898V10.2598C11.4999 9.84977 11.8399 9.50977 12.2499 9.50977C12.6599 9.50977 12.9999 9.83977 12.9999 10.2498V11.1798C12.9999 11.7898 12.6699 12.3698 12.1499 12.6798L11.3799 13.1398C11.2699 13.2198 11.1299 13.2498 10.9999 13.2498Z" fill="white" />
                                    </svg>
                                    @else
                                    {{ __('Not sent') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="white">
                                        <path d="M11.9999 22.7599C10.9099 22.7599 9.82992 22.4399 8.97992 21.8099L4.6799 18.5999C3.5399 17.7499 2.6499 15.9699 2.6499 14.5599V7.11994C2.6499 5.57994 3.77992 3.93994 5.22992 3.39994L10.2199 1.52994C11.2099 1.15994 12.7699 1.15994 13.7599 1.52994L18.7499 3.39994C20.1999 3.93994 21.3299 5.57994 21.3299 7.11994V14.5499C21.3299 15.9699 20.4399 17.7399 19.2999 18.5899L14.9999 21.7999C14.1699 22.4399 13.0899 22.7599 11.9999 22.7599Z" fill="white" />
                                    </svg>
                                    @endif
                                </p>
                            </div>
                        </a>
                    </li>
                    @empty
                    <li class="text-center py-5">
                        {{ __('No messages sent yet') }}
                    </li>
                    @endforelse
                </ul>
                
                <!-- Pagination -->
                <div class="pagination">
                    {{ $messages->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection