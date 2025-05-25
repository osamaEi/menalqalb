@extends('app.index')

@section('content')
<div class="app white messagebox">


    <h1 class="text-[24px] text-[#242424] font-[900] z-50 relative page-title text-center mt-4">طلب جديد</h1>

    <div class="row justify-content-center overflow-y-auto h-[100%]">
        <div class="col-12 col-lg-4">
            <div class="All_Button lang Devices">
                <div class="rounded-lg px-0 pb-8 w-full">
                    <form action="{{ route('min-alqalb.lockers.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <!-- Name Field -->
                        <div class="!mt-1">
                            <label for="name" class="block text-lg font-medium text-[#4B4B4B] text-center">{{__('Sender Name')}}</label>
                        </div>
                        <div class="bg-[#F9F9F9] max-h-[59px] relative rounded-[35px] mt-0 border !border-black">
                            <div class="flex items-center">
                                <input type="text" id="name" value="{{ $user->name ?? 'Tarek Bn Kalban' }}" disabled class="relative right-[-20px] w-[100px] bg-transparent h-[57px] flex-grow text-lg focus:outline-none text-center" placeholder="{{__('Name')}}" />
                                <div class="px-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M12.1596 11.62C12.1296 11.62 12.1096 11.62 12.0796 11.62C12.0296 11.61 11.9596 11.61 11.8996 11.62C8.99957 11.53 6.80957 9.25 6.80957 6.44C6.80957 3.58 9.13957 1.25 11.9996 1.25C14.8596 1.25 17.1896 3.58 17.1896 6.44C17.1796 9.25 14.9796 11.53 12.1896 11.62C12.1796 11.62 12.1696 11.62 12.1596 11.62ZM11.9996 2.75C9.96957 2.75 8.30957 4.41 8.30957 6.44C8.30957 8.44 9.86957 10.05 11.8596 10.12C11.9096 10.11 12.0496 10.11 12.1796 10.12C14.1396 10.03 15.6796 8.42 15.6896 6.44C15.6896 4.41 14.0296 2.75 11.9996 2.75Z" fill="#4B4B4B" />
                                        <path d="M12.1696 22.55C10.2096 22.55 8.23961 22.05 6.74961 21.05C5.35961 20.13 4.59961 18.87 4.59961 17.5C4.59961 16.13 5.35961 14.86 6.74961 13.93C9.74961 11.94 14.6096 11.94 17.5896 13.93C18.9696 14.85 19.7396 16.11 19.7396 17.48C19.7396 18.85 18.9796 20.12 17.5896 21.05C16.0896 22.05 14.1296 22.55 12.1696 22.55ZM7.57961 15.19C6.61961 15.83 6.09961 16.65 6.09961 17.51C6.09961 18.36 6.62961 19.18 7.57961 19.81C10.0696 21.48 14.2696 21.48 16.7596 19.81C17.7196 19.17 18.2396 18.35 18.2396 17.49C18.2396 16.64 17.7096 15.82 16.7596 15.19C14.2696 13.53 10.0696 13.53 7.57961 15.19Z" fill="#4B4B4B" />
                                    </svg>
                                </div>
                            </div>
                        </div>
    
                        <!-- Locker Selection -->
                        <input type="hidden" name="locker_id" id="selected_locker" value="">
                        <ul class="allDevice">
                            @foreach($lockers as $locker)
                                <li class="relative bg-white rounded-lg overflow-hidden cursor-pointer transition-all duration-300"
                                    onclick="selectLocker(this, {{ $locker->id }})">
                                    <div class="absolute top-2 left-2 w-6 h-6 border-2 border-gray-400 rounded-full flex items-center justify-center checkbox"
                                        id="checkbox-{{ $locker->id }}"></div>
                                    <div class="w-[50px] text-[15px] h-[50px] flex items-center justify-center p-3 absolute right-[-5px] top-[-4px] bg-[#B62326] text-white rounded-full">
                                        <span>{{ number_format($locker->price) }}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M8 7V17H12C14.8 17 17 14.8 17 12C17 9.2 14.8 7 12 7H8Z" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M6.5 11H18.5" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M6.5 13H12.5H18.5" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <div class="flex flex-row-reverse">
                                        <div>
                                            <div class="w-[337px] h-[180px] bg-gray-200 flex items-center justify-center">
                                                <img src="{{ asset('storage/'.$locker->photo) }}" class="!w-[100%]" alt="{{ $locker->name_ar }}">
                                            </div>
                                            <div class="w-[337px] bg-black z-10 relative p-0.5" style="border-bottom-right-radius: 15px;">
                                                <p class="!text-white flex items-center justify-center pr-2 gap-2">
                                                    {{ $locker->name_ar }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
    
                        <!-- Quantity -->
                        <div class="relative !mt-3">
                            <label for="quantity" class="block text-lg font-medium text-[#4B4B4B] bg-transparent text-center">{{__('Number of desired cards')}}</label>
                            <input type="number" name="quantity" id="quantity" min="1" required
                                class="text-[#4B4B4B] bg-transparent text-center block w-[99%] border !border-[#4B4B4B] rounded-full py-3 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="{{__('Enter quantity')}}">
                        </div>
    
                        <!-- Submit Button -->
                        <div class="h-[57px] newMessage bg-black rounded-full flex items-center justify-center text-center mt-2">
                            <button type="submit" class="text-white border-0 w-full h-full">{{__('Next')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="notification fixed bottom-0 left-0 right-0 bg-red-500 text-white p-4 text-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ $errors->first() }}
        </div>
    @endif

    <style>
        .item-selected {
            border: 3px solid #B62326 !important;
            box-shadow: 0 0 10px rgba(182, 35, 38, 0.5) !important;
            border-radius: 15px !important;
        }
        .All_Button.lang.Devices .allDevice li {
            border-radius: 15px !important;
        }
        .checkbox-selected {
            background-color: #B62326 !important;
        }
        .header-logo {
            transition: transform 0.3s ease;
        }
        .header-logo:hover {
            transform: scale(1.05);
        }
        .page-title {
            position: relative;
        }
        .page-title::after {
            content: "";
            position: absolute;
            bottom: -8px;
            right: 0;
            width: 60px;
            height: 4px;
            background-color: #B62326;
            border-radius: 2px;
        }
    </style>

    <script>
        let selectedLockerId = null;

        function selectLocker(element, lockerId) {
            document.querySelectorAll('.allDevice li').forEach(item => {
                item.classList.remove('item-selected');
                item.querySelector('.checkbox').classList.remove('checkbox-selected');
                item.querySelector('.checkbox').innerHTML = '';
            });

            if (selectedLockerId === lockerId) {
                selectedLockerId = null;
                document.getElementById('selected_locker').value = '';
            } else {
                element.classList.add('item-selected');
                const checkbox = document.getElementById(`checkbox-${lockerId}`);
                checkbox.classList.add('checkbox-selected');
                checkbox.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>`;
                selectedLockerId = lockerId;
                document.getElementById('selected_locker').value = lockerId;
            }
        }

        document.querySelector('form').addEventListener('submit', function (e) {
            if (!selectedLockerId) {
                e.preventDefault();
                showAlert('الرجاء اختيار قفل');
            }
        });

        function showAlert(message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'fixed bottom-0 left-0 right-0 bg-yellow-500 text-white p-4 text-center';
            alertDiv.innerHTML = `<i class="fas fa-exclamation-triangle mr-2"></i>${message}`;
            document.body.appendChild(alertDiv);
            setTimeout(() => alertDiv.remove(), 3000);
        }

        setTimeout(() => {
            document.querySelectorAll('.notification').forEach(notification => notification.remove());
        }, 5000);
    </script>
</div>
@endsection