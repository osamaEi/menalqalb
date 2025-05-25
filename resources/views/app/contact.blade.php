@extends('app.index')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-4 overflow-scroll media-375">
        <div class="All_Button lang contact mt-0 pt-0">
            <h3 class="localized">تواصل معنا</h3>
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('app.contact.store') }}" method="POST" id="contactForm">
                @csrf
                <div class="!mt-1">
                    <label for="name" class="localized text-center flex items-center justify-center">{{__('sender_name')}}</label>
                </div>
                <div class="bg-[#F9F9F9] max-h-[59px] relative rounded-[35px] mt-0 border !border-black">
                    <div class="flex items-center">
                        <input type="text" name="name" id="name" value="{{ old('name', '') }}"
                            class="relative right-[-20px] w-[100px] bg-transparent h-[57px] flex-grow text-lg focus:outline-none text-center"
                            placeholder="الاسم" required />
                        <div class="px-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M12.1596 11.62C12.1296 11.62 12.1096 11.62 12.0796 11.62C12.0296 11.61 11.9596 11.61 11.8996 11.62C8.99957 11.53 6.80957 9.25 6.80957 6.44C6.80957 3.58 9.13957 1.25 11.9996 1.25C14.8596 1.25 17.1896 3.58 17.1896 6.44C17.1796 9.25 14.9796 11.53 12.1896 11.62C12.1796 11.62 12.1696 11.62 12.1596 11.62ZM11.9996 2.75C9.96957 2.75 8.30957 4.41 8.30957 6.44C8.30957 8.44 9.86957 10.05 11.8596 10.12C11.9096 10.11 12.0496 10.11 12.1796 10.12C14.1396 10.03 15.6796 8.42 15.6896 6.44C15.6896 4.41 14.0296 2.75 11.9996 2.75Z" fill="#4B4B4B" />
                                <path d="M12.1696 22.55C10.2096 22.55 8.23961 22.05 6.74961 21.05C5.35961 20.13 4.59961 18.87 4.59961 17.5C4.59961 16.13 5.35961 14.86 6.74961 13.93C9.74961 11.94 14.6096 11.94 17.5896 13.93C18.9696 14.85 19.7396 16.11 19.7396 17.48C19.7396 18.85 18.9796 20.12 17.5896 21.05C16.0896 22.05 14.1296 22.55 12.1696 22.55ZM7.57961 15.19C6.61961 15.83 6.09961 16.65 6.09961 17.51C6.09961 18.36 6.62961 19.18 7.57961 19.81C10.0696 21.48 14.2696 21.48 16.7596 19.81C17.7196 19.17 18.2396 18.35 18.2396 17.49C18.2396 16.64 17.7096 15.82 16.7596 15.19C14.2696 13.53 10.0696 13.53 7.57961 15.19Z" fill="#4B4B4B" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="!mt-3">
                    <label for="email" class="localized flex items-center justify-center">{{__('email')}}</label>
                </div>
                <div class="bg-[#F9F9F9] max-h-[59px] relative rounded-[35px] mt-0 border !border-black">
                    <div class="flex items-center">
                        <input type="email" name="email" id="email" value="{{ old('email', '') }}"
                            class="relative right-[-20px] w-[100px] bg-transparent h-[57px] flex-grow text-lg focus:outline-none text-center"
                            placeholder="name@domain.com" required />
                    </div>
                </div>

                <div class="!mt-3">
                    <label for="phone" class="localized flex items-center justify-center">{{__('phone')}} </label>
                </div>
                <div class="bg-[#F9F9F9] max-h-[59px] relative rounded-[35px] mt-0 border !border-black">
                    <div class="flex items-center">
                        <input type="tel" name="phone" id="phone" value="{{ old('phone', '') }}"
                            class="relative right-[-20px] w-[100px] bg-transparent h-[57px] flex-grow text-lg focus:outline-none text-center"
                            placeholder="966 555 55 555" />
                    </div>
                </div>

                <div class="form-group textarea">
                    <label for="message" class="localized flex items-center justify-center mt-2 !pb-0">{{__('message')}}</label>
                    <textarea name="message" class="!w-full relative !rounded-full !border mt-0 !border-black w-[100px] bg-transparent h-[57px] flex-grow text-lg focus:outline-none text-center"
                        placeholder="أرسل الرسالة">{{ old('message') }}</textarea>
                </div>

                <div class="btnsMessage">
                    <button type="submit" id="sendButton"
                        class="!bg-[#B62326] !text-[#FFF] p-2 rounded-[13px] w-[141px] mx-auto mt-0">
                        <p class="localized">{{__('send')}}</p>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Confirmation Popup -->
<div class="popup-overlay" id="confirmationPopup" style="display: none;">
    <div class="popup-content">
        <span class="popup-close" onclick="closePopup()">×</span>
        <div class="popup-icon">✓</div>
        <div class="popup-title">تم الإرسال بنجاح</div>
        <div class="popup-message">شكراً للتواصل معنا، سيتم الرد عليك في أقرب وقت</div>
        <button class="popup-button" onclick="closePopup()">حسناً</button>
    </div>
</div>

<style>
    .popup-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0,0,0,0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        display: none;
    }
    
    .popup-content {
        background: white;
        padding: 30px;
        border-radius: 10px;
        max-width: 400px;
        width: 90%;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }
    
    .popup-close {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 24px;
        cursor: pointer;
    }
    
    .popup-icon {
        color: #4CAF50;
        font-size: 48px;
        margin-bottom: 15px;
    }
    
    .popup-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 10px;
    }
    
    .popup-message {
        margin-bottom: 20px;
        font-size: 16px;
    }
    
    .popup-button {
        background: #B62326;
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }
</style>

<script src="{{ asset('sass/components/js/jquery-3.3.1.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // Check for success message on page load
        @if(session('success'))
            showPopup();
        @endif

        // Handle form submission
        $('#contactForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    showPopup();
                    $('#contactForm')[0].reset();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        // Handle validation errors
                        var errors = xhr.responseJSON.errors;
                        var errorHtml = '<div class="alert alert-danger"><ul>';
                        
                        $.each(errors, function(key, value) {
                            errorHtml += '<li>' + value[0] + '</li>';
                        });
                        
                        errorHtml += '</ul></div>';
                        
                        $('.All_Button').prepend(errorHtml);
                    }
                }
            });
        });
    });

    function showPopup() {
        $('#confirmationPopup').fadeIn();
    }

    function closePopup() {
        $('#confirmationPopup').fadeOut();
    }
</script>
@endsection