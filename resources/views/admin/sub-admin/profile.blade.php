@extends('layouts.app')
@section('title')
Profile
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admindashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <form id="profile-update-form" action="{{route('profileupdate')}}" enctype="multipart/form-data" method="post">
                            @csrf
                            <input type="hidden" name="is_profile_image_remove" id="is_profile_image_remove" value="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first_name">Name</label>
                                            <input type="text" name="name" minlength="3" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter name" value="{{ $userModel->name ?? old('name') }}" maxlength="50">
                                            @error('name')
                                            <span class="invalid-feedback error">
                                                <strong> {{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="profile_picture">Profile</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file"
                                                           class="custom-file-input @error('profile_picture') is-invalid
                                                            @enderror" id="profile_picture" name="profile_picture" title="Select Image" placeholder="Select Image">
                                                    <label class="custom-file-label" for="profile_picture">Choose
                                                        an image</label>
                                                </div>
                                                @error('profile_picture')
                                                <span class="invalid-feedback error">
                                                    <strong> {{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div
                                            class="form-group preview-super-admin-profile-container @if($userModel instanceof \App\Models\Admin && !empty($userModel->profile) && \Illuminate\Support\Facades\Storage::disk('admin_user_thumb')->exists($userModel->profile)) d-block @else d-none @endif">
                                            @if($userModel instanceof \App\Models\Admin && !empty($userModel->profile) && \Illuminate\Support\Facades\Storage::disk('admin_user_thumb')->exists($userModel->profile))
                                                <span
                                                    class="remove-user-image custom-confirmation-popup"
                                                    data-title="Confirm Image Delete"
                                                    data-text="Are you sure you want to delete this image?"
                                                    data-delete-btn-class="remove_image"
                                                    data-id="{{$userModel->id}}"><i
                                                        class="far fa-times-circle"></i></span>
                                                <img alt="profile-icon"
                                                    src="{{\Illuminate\Support\Facades\Storage::disk('admin_user_thumb')->url($userModel->profile)}}"
                                                    class="preview-super-admin-profile" width="120" height="100">
                                            @else
                                                <img src="{{asset('/assets/images') . '/dummy-user.png'}}"
                                                     class="preview-super-admin-profile" width="120" height="100" alt="profile-icon">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" class="form-control @error('email') is-invalid 
                                                @enderror" id="email"  placeholder="Enter email" autocomplete="off" value="{{ $userModel->email ?? old('email') }}" maxlength="255" readonly>
                                            @error('email')
                                            <span class="invalid-feedback error">
                                                <strong> {{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary mr-2" title="save">Save</button>
                                <a href="{{route('admindashboard')}}" class="btn btn-secondary" title="cancel">Cancel</a>
                            </div>
                        </form>
                        <!-- /.form -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection

@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#profile-update-form').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        validate_email: true,
                    },
                    profile_picture: {
                        extension: "jpg|jpeg|png"
                    }
                },
                messages: {
                    name: {
                        required: "Please enter name",
                    },
                    email: {
                        required: "Please enter email address",
                    },
                    profile_picture: {
                        extension: "Only formats are allowed: jpg, jpeg, png"
                    }
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

            // Preview profile picture
            $(document).on('change', '#profile_picture', function () {
                readURL(this, '.preview-super-admin-profile');
                $('#is_profile_image_remove').val('yes');
            });

            // Remove image
            $(document).on('click', '.remove_image', function () {
                $('#profile_picture').val('');
                $('#is_profile_image_remove').val('yes');
                $('.preview-super-admin-profile-container').addClass('d-none');
                $('.preview-super-admin-profile-container').removeClass('d-block');
                $('#customConfirmationModal').modal('hide');
            });
        });
    </script>
    <script type="text/javascript" src="{{ asset('assets/js/char-length-validation.js') }}"></script>
@endsection
