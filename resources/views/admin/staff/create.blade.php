@extends('admin.layouts.app')

@section('title')
Create Staff Member
@endsection
<style>
.input-form .invalid-feedback {
    display: block;
}
</style>
@section('content')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('customer.index') }}">Customer Management</a></li>
    <li class="breadcrumb-item"><a href="{{ route('companystaff.index', Request()->id) }}">Staff Member</a></li>
    <li class="breadcrumb-item active">Staff Member Detail</li>
</ul>
    <div class="customer-support">
      <form class="input-form" id="sub-admin-create" method="POST" action="{{ route('companystaff.store',Request()->id) }}"  enctype="multipart/form-data" >
        @csrf
        <div class="row">
            <div class="col-md-4 col-12">
                <div class="form-group">
                    <label >NAME<span class="mandatory-field">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" minlength="3" placeholder="Enter name" 
                    class="form-controal">
                    @error('name')
                    <span class="error-mgs">
                        <strong> {{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            
            </div>
            <div class="col-md-4 col-12">
                <div class="form-group">
                    <label >EMAIL ADDRESS<span class="mandatory-field">*</span></label>
                    <input type="text" name="email" value="{{ old('email') }}" minlength="10" placeholder="Enter email address"
                        class="form-controal">
                    @error('email')
                    <span class="error-mgs">
                        <strong> {{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                
            </div>
            <div class="col-md-4 col-12">
                <div class="form-group">
                    <label >CONTACT NUMBER</label>
                    <input type="text" name="contact_number" id="contact_number" value="{{ old('contact_number') }}" placeholder="Enter contact number" class="form-controal" maxlength="14">
                     @error('contact_number')
                        <span class="error-mgs">
                            <strong> {{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="form-group">
                    <label for="role">ROLE<span class="mandatory-field">*</span></label>
                    <select name="role" id="role" placeholder="Select Role">
                        <option value="" disabled>Select Role</option>
                        @if ($staffrole)
                        @foreach($staffrole as $role)
                        <option value="{{$role['id']}}" {{ old('role') == $role['id'] ? "selected" :""}}>{{$role['role']}}</option>
                        @endforeach
                        @endif
                    </select>
                    @error('role')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="form-group">
                 <label >Status</label>
                <select name="status" id="status" >
                    <option value="1" {{ old('status') == "1" ? "selected" :""}}>Active</option>
                    <option value="0" {{ old('status') == "0" ? "selected" :""}}>Inactive</option>
                </select>
                </div>
            </div>
            <div class="col-md-8 col-12">
                <div class="form-group">
                    <label >Profile</label>
                    <div class="input-group">
                        <input type="text" id="staff_profile" class="form-controal" placeholder="Select profile"
                            aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">
                                <div class="in-file">
                                    <input type="file" id="file" name="profile_picture"/>
                                    <label for="file">+ ADD FILE</label>
                                </div>
                            </span>
                        </div>
                    </div>
                    <span class="error-note">Accepted File Types: jpeg, jpg, png and webp file.</span>
                    @error('profile_picture')
                        <span class="error-mgs">
                            <strong> {{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="form-group">
                    <label >DISPLAY ATTACHMENTS</label>
                    <ul class="attachment company-staff-attachment">
                        <li>
                            <picture>
                                <img src="{{asset('assets/images/file-img.png')}}" alt="file icon">
                            </picture>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-12">
                <div class="towbutton-row">
                    <a href="{{route('companystaff.index',Request()->id)}}" class="back-btn" title="cancel">Cancel</a>
                    <button type="submit" class="btn-primary" title="submit">Submit</button>
                </div>
            </div>
        </div>
    </form>
    </div>
@endsection
@section('footer_scripts')
{{-- <script type="text/javascript" src="{{ asset('assets/js/contact-number-validation.js') }}"></script> --}}
<script type="text/javascript" src="{{ asset('assets/js/char-length-validation.js') }}"></script>
<script type="text/javascript">
    function readURL(input) {
        const file = input.files[0];
        const fileType = file?.type;
        const allowedTypes = ['image/png', 'image/jpg', 'image/jpeg', 'image/webp'];
        const maxFileSize = 15 * 1024 * 1024; // 5MB in bytes
        const fileSize = file.size;
        const fileurl = "{{ asset('assets/images/file-img.png') }}";
        if (fileSize > maxFileSize) {
            $("#staff_profile").val("");
            $('.company-staff-attachment img').attr('src', fileurl);
            setReturnMsg("danger", 'File size exceeds 15MB. Please choose a smaller file.');
            return;
        }
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var fileName = input.files[0].name;
                $("#staff_profile").val(fileName);
                $('.company-staff-attachment img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#file").change(function() {
        readURL(this);
    });
    function setReturnMsg(title, message) {
        var title = title;
        var lowercaseString = title.toLowerCase();
        if (lowercaseString == "danger") {
            title = 'Error';
        }
        $.notify({
            title: '<strong>' + title + '</strong>',
            message: "<br>" + message + "",
        }, {
            element: 'body',
            position: null,
            type: lowercaseString,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 999999,
            delay: 2000,
            timer: 1000,
            mouse_over: null,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutRight'
            },
            onShow: null,
            onShown: null,
            onClose: null,
            onClosed: null,
            icon_type: 'class',
        });
    }
</script>
{{-- <script type="text/javascript" src="{{ asset('assets/js/contact-number-validation.js') }}"></script> --}}
@endsection
