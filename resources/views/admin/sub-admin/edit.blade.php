@extends('admin.layouts.app')

@section('title')
Edit Sub Admin
@endsection
@section('content')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{route('sub-admin.index')}}">Sub Admin</a></li>
    <li class="breadcrumb-item active">Edit</li>
</ul>
    <div class="customer-support">
      <form class="input-form" id="sub-admin-edit" method="POST"   action="{{ route('sub-admin.update', $user->id) }}" enctype="multipart/form-data" >
        @csrf
        <input type="hidden" name="is_profile_image_remove" id="is_profile_image_remove"
                                       value="">
        <div class="row">
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="name">NAME <span class="mandatory-field">*</span></label>
                    <input type="text" name="name" value="{{ $user->name ?? old('name') }}" minlength="3" placeholder="Enter name" 
                    class="form-controal">
                    @error('name')
                    <span class="error-mgs">
                        <strong> {{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="email">EMAIL ADDRESS <span class="mandatory-field">*</span></label>
                    <input type="email" name="email" id="email" value="{{ $user->email ?? old('email') }}"  placeholder="Enter email address"
                        class="form-controal">
                    @error('email')
                    <span class="error-mgs">
                        <strong> {{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" minlength="3"  value="{{ $user->username ?? old('username') }}" value="{{ old('username') }}" placeholder="Enter username"
                        class="form-controal">
                    @error('username')
                    <span class="error-mgs">
                        <strong> {{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="role">ROLE</label>
                    <select name="role" placeholder="Select Role" id="role">
                        <option value="" disabled>Select Role</option>
                        @if ($adminRole)
                        @foreach($adminRole as $role)
                        <option value="{{$role['id']}}" {{  $user->user_role_id == $role['id'] ? "selected" :""}}>{{$role['role']}}</option>
                        @endforeach
                        @endif
                    </select>
                    @error('role')
                        <span class="error-mgs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="contact_number">CONTACT NUMBER <span class="mandatory-field">*</span></label>
                    <input type="text" name="contact_number" id="contact_number" value="{{ $user->contact_number ?? old('contact_number') }}" placeholder="Enter phone number" class="form-controal" maxlength='14'>
                     @error('contact_number')
                        <span class="error-mgs">
                            <strong> {{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                 <label for="status">Status</label>
                <select name="status" id="status" >
                    <option value="1" {{$user->status == "1"? 'selected':""}}>Active</option>
                    <option value="0" {{$user->status == "0"? 'selected':""}}>Inactive</option>
                </select>
                </div>
            </div>
           
            <div class="col-md-8 col-sm-6 col-12">
                <div class="form-group">
                    <label for="logo_name">Profile</label>
                    <div class="input-group">
                        @php
                            $logoUrl = $user->profile_picture;
                            $explodeurl = explode('/sub_admin_images/',$logoUrl);
                            if(!empty($explodeurl[1])){
                                $logoName = $explodeurl[1];
                            }else{
                                $logoName = "";
                            } 
                            
                        @endphp
                        <input type="text" class="form-controal" id="logo_name" placeholder="Select profile"
                            aria-label="Recipient's username" aria-describedby="basic-addon2" value="{{$logoName}}">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">
                                <div class="in-file">
                                    <input type="file" id="file" name="profile_picture" />
                                    <input type="hidden" id="hidden_profile_picture" name="hidden_profile_picture" value="{{$logoName}}"/>
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
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label >DISPLAY ATTACHMENTS</label>
                    <ul class="attachment preview-customer-profile-container @if($user instanceof \App\Models\User && !empty($user->profile_picture)) d-block @else d-none @endif">
                        <li>
                            @if($user instanceof \App\Models\User && !empty($user->profile_picture))
                            <span class="remove-user-image custom-confirmation-popup" data-title="Confirm Image Delete" data-text="Are you sure you want to delete this image?" data-delete-btn-class="remove_image" data-id="{{$user->id}}"><i class="far fa-times-circle"></i></span>
                            <img src="{{$user->profile_picture}}" class="imagepop preview-customer-profile" alt="profile-icon">
                            @else
                            <img src="{{asset('/admin_assets/images') . '/profile.png'}}" class="preview-customer-profile" alt="profile-icon">
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="col-12">
                <div class="towbutton-row">
                    <a href="{{route('sub-admin.index')}}" class="back-btn" title="cancel">Cancel</a>
                    <button type="submit" class="btn-primary" title="submit">Submit</button>
                </div>
            </div>
        </div>
    </form>
    </div>
@endsection
@section('footer_scripts')
<script type="text/javascript">
$(document).on('change', '#file', function () {
    readURL(this);
    $('#is_profile_image_remove').val('yes');
});
function readURL(input) {
    const file = input.files[0];
    const allowedTypes = ['image/png', 'image/jpg', 'image/jpeg', 'image/webp'];
    const maxFileSize = 15 * 1024 * 1024; // 5MB in bytes
    const fileSize = file.size;
    const fileurl = "{{ asset('assets/images/file-img.png') }}";
    if (fileSize > maxFileSize) {
        $("#logo_name").val("");
        $('.preview-customer-profile').attr('src', fileurl);
        setReturnMsg("danger", 'File size exceeds 15MB. Please choose a smaller file.');
        return;
    }
    const fileType = input.files[0].type;
            if (!allowedTypes.includes(fileType)) {
                setReturnMsg("danger", 'Only upload jpeg, jpg, png, webp files.');
                return;
            }
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var fileName = input.files[0].name;
            $("#logo_name").val(fileName);
            $('.preview-customer-profile').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$(document).on('click', '.remove_image', function () {
    $('#profile_picture').val('');
    $('#is_profile_image_remove').val('yes');
    $('.preview-customer-profile-container').addClass('d-none');
    $('.preview-customer-profile-container').removeClass('d-block');
    $('#customConfirmationModal').modal('hide');
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
<script type="text/javascript" src="{{ asset('assets/js/char-length-validation.js') }}"></script>
@endsection
