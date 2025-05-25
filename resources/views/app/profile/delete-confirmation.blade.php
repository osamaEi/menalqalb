@extends('app.index')

@section('content')
<div class="app white messagebox">
  
    <h1 class="text-[24px] text-[#242424] font-[900] z-50 relative text-right px-4">
        {{ __('delete_confirmation') }}
    </h1>
    
    <p class="text-[16px] leading-[29px] text-right px-4 mx-auto font-[400] text-[#4B4B4B] z-50 mt-4 relative">
        {{ __('delete_warning') }}
    </p>
    
    <div class="row justify-content-center overflow-y-auto h-[100%]">
        <div class="col-12 col-lg-4 flex gap-2">
            <form id="delete-form" method="POST" action="{{ route('app.profile.delete') }}" class="w-[50%]">
                @csrf
                @method('DELETE')
                <button type="submit" class="border-0 flex !font-[400] !text-white h-[48px] w-full text-center items-center justify-center !rounded-[31px] !bg-[#000]">
                    {{ __('delete') }}
                </button>
            </form>
    
            <a href="{{ route('app.profile.edit') }}" class="border-0 flex !font-[400] !text-white h-[48px] w-[50%] text-center items-center justify-center !rounded-[31px] !bg-[#B62326]">
                {{ __('no') }}
            </a>
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForm = document.getElementById('delete-form');
        
        deleteForm.addEventListener('submit', function(event) {
            // Double confirm with browser dialog
            if (!confirm('هل أنت متأكد من رغبتك في حذف حسابك نهائيًا؟ لا يمكن التراجع عن هذا الإجراء.')) {
                event.preventDefault();
            }
        });
    });
</script>
@endsection