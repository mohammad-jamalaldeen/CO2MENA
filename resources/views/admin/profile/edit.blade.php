@extends('admin.layouts.app')
@section('title')
    Edit Profile
@endsection
@section('content')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Edit Profile</li>
    </ul>
    <div class="customer-support">
        <form class="input-form" id="bussiness-edit" method="POST" enctype="multipart/form-data"
            action="{{ route('profile.update', $userDetails->id) }}">
            @csrf
            <div class="row">
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label>Name<span class="mandatory-field">*</span></label>
                        <input type="text" name="name" value="{{ $userDetails->name ?? old('name') }}"
                            placeholder="Name" class="form-controal" minlength="3">
                        @error('name')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label >Username</label>
                        <input type="text" name="username" value="{{ $userDetails->username ?? old('username') }}"
                            placeholder="Username" class="form-controal" minlength="5">
                        @error('username')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label >Email Address<span class="mandatory-field">*</span></label>
                        <input type="text" name="email" value="{{ $userDetails->email ?? old('email') }}"
                            placeholder="Email Address" class="form-controal" minlength="10">
                        @error('email')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label >CONTACT NUMBER<span class="mandatory-field">*</span></label>
                        <input type="text" name="contact_number"
                            value="{{ $userDetails->contact_number ?? old('contact_number') }}" id="contact_number" placeholder="Contact number"
                            class="form-controal">
                        @error('contact_number')
                            <span class="error-mgs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label >Profile</label>
                        <div class="input-group">
                            @php
                                $logoUrl = $userDetails['profile_picture'];
                                $explodeurl = explode('/sub_admin_images/', $logoUrl);
                                if (!empty($explodeurl[1])) {
                                    $logoName = $explodeurl[1];
                                } else {
                                    $logoName = '';
                                }
                            @endphp
                            <input type="text" id="profile_picture" name="profile_picture" class="form-controal"
                                placeholder="Select Image" aria-label="Recipient's username" title="Select Image"
                                aria-describedby="basic-addon2" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">
                                    <div class="in-file">
                                        <input type="file" id="company_logo" name="profile_picture" />
                                        <input type="hidden" id="hidden_profile_picture"  name="hidden_profile_picture" value="{{$logoName}}"
                                            name="profile_picture" />
                                        <label for="company_logo">+ ADD FILE</label>
                                    </div>
                                </span>
                            </div>
                            
                        </div>
                        <span class="error-note">supported file types: jpeg, webp, png, jpg</span>
                        @error('profile_picture')
                                <span class="error-mgs">{{ $message }}</span>
                            @enderror
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label >DISPLAY ATTACHMENTS</label>
                        <ul class="attachment company-logo-attachment">
                            <li>
                                @if (!empty($userDetails))
                                    <picture>
                                        <img class="imagepop" src="{{ $userDetails['profile_picture'] }}" alt="file icon">
                                    </picture>
                                @else
                                    <picture>
                                        <img src="{{ asset('assets/images/file-img.png') }}" alt="file icon">
                                    </picture>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-12">
                    <div class="towbutton-row">
                        <a href="{{ route('profile.edit')}}" class="back-btn" title="cancel">Cancel</a>
                        <button type="submit" class="btn-primary" title="submit">Submit</button>
                    </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('footer_scripts')
    <script type="text/javascript">
        function readURL(input) {
            const file = input.files[0];
            const allowedTypes = ['image/png', 'image/jpg', 'image/jpeg', 'image/webp'];
            const maxFileSize = 5 * 1024 * 1024; // 5MB in bytes
            const fileSize = file.size;
            const fileurl = "{{ asset('assets/images/file-img.png') }}";
            if (fileSize > maxFileSize) {
                $("#profile_picture").val("");
                $('.company-logo-attachment img').attr('src', fileurl);
                setReturnMsg("danger", 'File size exceeds 5MB. Please choose a smaller file.');
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
                    $("#profile_picture").val(fileName);
                    $('.company-logo-attachment img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#company_logo").change(function() {
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
