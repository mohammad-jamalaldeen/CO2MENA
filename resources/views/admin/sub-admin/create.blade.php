@extends('admin.layouts.app')

@section('title')
Create Sub Admin
@endsection
@section('content')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('sub-admin.index') }}">Sub Admin</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ul>
    <div class="customer-support">
        <form class="input-form" id="sub-admin-create" method="POST" action="{{ route('sub-admin.store') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="name">NAME <span class="mandatory-field">*</span></label>
                        <input type="text" name="name" minlength="3"
                            value="{{ old('name') }}" id="name" placeholder="Enter name" class="form-controal">
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
                        <input type="email" name="email" value="{{ old('email') }}" id="email"
                            placeholder="Enter email address" class="form-controal"  minlength="10">
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
                        <input type="text" name="username" minlength="3"
                            value="{{ old('username') }}" id="username" placeholder="Enter username" class="form-controal">
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
                                <option value="{{$role['id']}}" {{ old('role') == $role['id'] ? "selected" : ($role['id'] == 2 ? 'selected' : '') }}>{{$role['role']}}</option>
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
                        <input type="text" name="contact_number" id="contact_number" value="{{ old('contact_number') }}"
                            placeholder="Enter contact number" class="form-controal" maxlength='14'>
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
                        <select name="status" id="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-8 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="profile_name">Profile Picture</label>
                        <div class="input-group">
                            <input type="text" id="profile_name" class="form-controal" placeholder="Select profile"
                                aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">
                                    <div class="in-file">
                                        <input type="file" id="file" name="profile_picture"
                                            accept=".jpeg, .jpg, .png, .webp" />
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
                        <ul class="attachment profile-attachment">
                            <li>
                                <picture>
                                    <img  src="{{ asset('assets/images/file-img.png') }}" alt="file icon">
                                </picture>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="towbutton-row">
                        <a href="{{ route('sub-admin.index') }}" class="back-btn" title="cancel">Cancel</a>
                        <button type="submit" class="btn-primary" title="submit">Submit</button>
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
            const maxFileSize = 15 * 1024 * 1024; // 15MB in bytes
            const fileSize = file.size;
            const fileurl = "{{ asset('assets/images/file-img.png') }}";
            if (fileSize > maxFileSize) {
                $("#profile_name").val("");
                $('.profile-attachment img').attr('src', fileurl);
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
                    $("#profile_name").val(fileName);
                    $('.profile-attachment img').attr('src', e.target.result);
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
    <script type="text/javascript" src="{{ asset('assets/js/char-length-validation.js') }}"></script>
@endsection
