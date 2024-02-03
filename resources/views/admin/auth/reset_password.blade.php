@extends('admin.auth.layout.app')
@section('title')
Set new password
@endsection
@section('content')
<section class="welcome-screen">
    <div class="credentials-content">
    @include('auth.layout.header')
        <div class="content-inner">
            <div class="center-text">
                <h2 class="section-title">Set new password</h2>
                <div class="para-14">
                    <p>The password must be at least 8 characters, It's contains capital, small aplhabate, one number, one special character.</p>
                </div>
            </div>
            <form class="input-form" id="set_password_form" method="POST" action="{{ route('admin.set_password.post') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">
                <div class="form-group">
                    <label for="">PASSWORD <span class="mandatory-field">*</span></label>
                    <div class="password-hide-show">
                        <input type="password" id="password" class="form-controal" name="password" value="" placeholder="Enter password">
                        <a class="hide-show-icon toggle-password">
                            <picture>
                                <img id="eye-open" class="eye-close-ps" src="{{asset('assets/images/eye-show.svg')}}" alt="eye-show" title="password-show" width="16" height="13">
                                <img id="eye-close" src="{{ asset('assets/images/eye-hide.svg') }}" alt="eye-hide" title="password-hide" width="16" height="13">
                            </picture>                
                        </a>
                    </div>
                    <span id="passwordError">
                        <span class="error-mgs" id="errorPassword"></span>
                    </span>
                </div>
                <div class="form-group">
                    <label for="">CONFIRM PASSWORD <span class="mandatory-field">*</span></label>
                    <div class="password-hide-show">
                        <input type="password" id="password-c" class="form-controal" name="password_confirmation" value="" placeholder="Re-type password">
                        <a class="hide-show-icon toggle-password-c">
                            <picture>
                                <img id="eye-open-c" class="eye-close-ps" src="{{asset('assets/images/eye-show.svg')}}" alt="eye-show" title="password-show" width="16" height="9">
                                <img id="eye-close-c" src="{{ asset('assets/images/eye-hide.svg') }}" alt="eye-hide" title="password-hide" width="16" height="9">
                            </picture>                
                        </a>
                    </div>
                    <span id="password-cError">
                        <span class="error-mgs" id="errorConfirmPassword"></span>
                    </span>
                </div>
                {{-- <span id="errorMessages" class="error-mgs"></span> --}}
                <div class="button-row">
                    <button class="btn-primary" title="verify-btn" type="submit">VERIFY<picture>
                        <img  src="{{ asset('assets/images/button-arrow.svg') }}" alt="button-arrow" title="button-arrow" width="24" height="24">
                        </picture>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="wel-img">
        <picture>
            <img  src="{{ asset('assets/images/wel-img.svg') }}" alt="wel img" title="wel img" width="712" height="597">
        </picture>
    </div>
</section>
<div class="modal fade common-modal" id="successfull-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <button type="button" class="close" title="close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="content-inner">
            <picture>
                <img  src="{{ asset('assets/images/succeseefull.png') }}" alt="succeseefull" title="succeseefull" width="" height="">
            </picture>
            <h2 class="section-title">All done!</h2>
            <div class="pare-14">
                <p>Your password has been reset.</p>
            </div>
            <a class="btn-primary" href="{{ url('admin/login')}}">CONTINUE
                <picture>
                <img src="{{ asset('assets/images/button-arrow.svg') }}" alt="button-arrow" title="button-arrow" width="" height="">
                </picture>
            </a>
        </div>
        
        </div>
    </div>
</div>
<style>
    .eye-open-ps{
        display: inline-block;
    }
    .eye-close-ps{
        display: none;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        $(".toggle-password-c").click(function () {
            var passwordField = $("#password-c");
            var icon = $(this);

            if (passwordField.attr("type") === "password") {
                passwordField.attr("type", "text");
                $("#eye-open-c").removeClass('eye-close-ps');
                $("#eye-close-c").addClass('eye-close-ps');
            } else {
                passwordField.attr("type", "password");
                $("#eye-close-c").removeClass('eye-close-ps');
                $("#eye-open-c").addClass('eye-close-ps');
            }
        });
        $(".toggle-password").click(function () {
            var passwordField = $("#password");
            var icon = $(this);

            if (passwordField.attr("type") === "password") {
                passwordField.attr("type", "text");
                $("#eye-open").removeClass('eye-close-ps');
                $("#eye-close").addClass('eye-close-ps');
            } else {
                passwordField.attr("type", "password");
                $("#eye-close").removeClass('eye-close-ps');
                $("#eye-open").addClass('eye-close-ps');
            }
        });
        $.validator.addMethod("format",function(value,element){
            return this.optional(element) || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[^a-zA-Z0-9]).{8,16}$/m.test(value);
        },"The password must be at least 8 characters, It's contains capital, small aplhabate, one number, one special character.");
        $("#set_password_form").validate({
            rules:{
                password:{
                    required:true,
                    minlength:8,
                    format:true,
                },
                password_confirmation:{
                    required:true,
                    minlength:8,
                    equalTo: '#password',
                    format:true,
                }
            },
            messages:{
                password:{
                    required:"Please enter password."
                },
                password_confirmation:{
                    required:"Please enter confirm password.",
                    equalTo: 'Passwords do not match'
                }
            },
            errorElement:"span",
            errorPlacement: function(error, element) {
                error.addClass('error-mgs');

                var errorSpanId = element.attr("id") + "Error";
                error.appendTo("#" + errorSpanId);
            }
        });
        $("#set_password_form").on("submit", function(e) {
            e.preventDefault(); 
            if ($(this).valid()) {
                var formAction = $(this).attr('action');                
                $.ajax({
                    url: formAction,
                    type: 'POST', 
                    data: $(this).serialize(), 
                    success: function(response) {
                        if(response.errors) {
                            $(".error-mgs").html('');
                            if(response.errors.password){
                                $( '#errorPassword' ).html( response.errors.password[0] );
                            }
                            if(response.errors.password_confirmation){
                                $( '#errorConfirmPassword' ).html( response.errors.password_confirmation[0] );
                            }
                        }
                        if(response.success) {
                            $(".error-mgs").html('');
                            $('#successfull-modal').modal('show');
                        }
                        if(response.invalid){
                            $(".error-mgs").html('');
                            setReturnMsg("danger", response.invalid);
                        }
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 302 || xhr.status === 419 || xhr.status === 401 ) {
                            location.reload();
                            // Redirect to the new location
                            // window.location.href = xhr.getResponseHeader('Location');
                        } 
                    }
                });
            }
        });

        // $('#set_password_form').submit(function(e) {
        //     e.preventDefault(); 
        //     var formAction = $(this).attr('action');
        //     $.ajax({
        //         url: formAction,
        //         type: 'POST', 
        //         data: $(this).serialize(), 
        //         success: function(response) {
        //             if(response.errors) {
        //                 $(".error-mgs").html('');
        //                 if(response.errors.password){
        //                     $( '#errorPassword' ).html( response.errors.password[0] );
        //                 }
        //                 if(response.errors.password_confirmation){
        //                     $( '#errorConfirmPassword' ).html( response.errors.password_confirmation[0] );
        //                 }
        //             }
        //             if(response.success) {
        //                 $(".error-mgs").html('');
        //                 $('#successfull-modal').modal('show');
        //             }
        //             if(response.invalid){
        //                 $(".error-mgs").html('');
        //                 setReturnMsg("danger", response.invalid);
        //             }
        //         },
        //         error: function(xhr, status, error) {
        //         }
        //     });
        // });

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
    });
</script>
@endsection