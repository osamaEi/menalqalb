@extends('app.index')

@section('content')
<div class="app white messagebox">
  
    <h1 class="text-[24px] text-[#242424] font-[900] z-50 relative text-right px-4">تأكيد الحذف</h1>
    <p class="text-[16px] leading-[29px] text-right px-4 mx-auto font-[400] text-[#4B4B4B] z-50 mt-4 relative">
        تحذير قبل حذف حسابك، يرجى التأكد من أنك قد قمت بحفظ أي بيانات أو معلومات هامة مرتبطة بحسابك. قد يتم
        فقدان جميع البيانات
        المتعلقة بحسابك ولن تتمكن من استردادها بمجرد حذف الحساب. كما أن عملية حذف الحساب لا يمكن التراجع عنها،
        لذا يرجى التفكير
        بعناية قبل القيام بالإجراء.
    </p>
    
    <div class="row justify-content-center overflow-y-auto h-[100%]">
        <div class="col-12 col-lg-4 flex gap-2">
            <form id="delete-form" method="POST" action="{{ route('app.profile.delete') }}" class="w-[50%]">
                @csrf
                @method('DELETE')
                <button type="submit" class="border-0 flex !font-[400] !text-white h-[48px] w-full text-center text-center items-center justify-center !rounded-[31px] !bg-[#000]">
                    حذف
                </button>
            </form>
            
            <a href="{{ route('app.profile.edit') }}" class="border-0 flex !font-[400] !text-white h-[48px] w-[50%] text-center text-center items-center justify-center !rounded-[31px] !bg-[#B62326]">
                لا
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