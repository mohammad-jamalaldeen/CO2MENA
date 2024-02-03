@extends('auth.layout.app')
@section('title') Reset Password @endsection
@section('content')
<section class="welcome-screen">
    <div class="credentials-content">
        @include('auth.layout.header')
        <div class="content-inner">
            <div class="center-text">
                <h2 class="section-title">Set new password</h2>
                <div class="para-14">
                    <p>The password must be at least 8 characters, It's contains Capital, small aplhabate, one number, one special character.</p>
                </div>
            </div>
            <form id="resetpasswordForm" class="input-form" method="POST" action="">
                @csrf
                <div class="form-group">
                    <label for="password">PASSWORD <span class="mandatory-field">*</span></label>
                    <div class="password-hide-show">
                        <input type="password" class="form-controal" id="password" name="password" value="" placeholder="Enter new password">
                        <a class="hide-show-icon toggle-password" title="password">
                            <picture>
                                <img id="eye-open" class="eye-close-ps" src="{{asset('assets/images/eye-show.svg')}}" alt="eye-show" width="16" height="13">
                                <img id="eye-close" src="{{ asset('assets/images/eye-hide.svg') }}" alt="eye-hide" width="16" height="13">
                            </picture>                
                        </a>
                    </div>
                    <span id="passwordError">
                        @if ($errors->has('password'))
                            <span class="error-mgs">{{ $errors->first('password') }}</span>
                        @endif
                    </span>
                </div>
                <div class="form-group">
                    <label for="">CONFIRM PASSWORD <span class="mandatory-field">*</span></label>
                    <div class="password-hide-show">
                        <input type="password" class="form-controal" id="confirm_passwod" name="confirm_passwod" value="" placeholder="Enter confirm password">
                        <a class="hide-show-icon toggle-password-c" title="confirm password">
                            <picture>
                                <img id="eye-open-c" class="eye-close-ps" src="{{asset('assets/images/eye-show.svg')}}" alt="eye-show" width="16" height="9">
                                <img id="eye-close-c" src="{{ asset('assets/images/eye-hide.svg') }}" alt="eye-hide" width="16" height="9">
                            </picture>                
                        </a>
                    </div>
                    <span id="confirm_passwodError">
                        @if ($errors->has('confirm_passwod'))
                            <span class="error-mgs">{{ $errors->first('confirm_passwod') }}</span>
                        @endif
                    </span>
                </div>
                <div class="button-row">
                    <button class="btn-primary" id="btnverify" type="submit" title="veirfy">VERIFY
                        <picture>
                            <img  src="{{ asset('assets/images/button-arrow.svg') }}" alt="button-arrow" width="24" height="24">
                        </picture>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="wel-img">
        <picture>
            <img  src="{{ asset('assets/images/wel-img.svg') }}" alt="wel img" width="712" height="597">
        </picture>
    </div>
</section>
<div class="modal fade common-modal" id="successfull-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" title="close"></button>
        <div class="content-inner">
            <picture>
                <img  src="{{ asset('assets/images/succeseefull.png') }}" alt="succeseefull" width="" height="">
            </picture>
            <h2 class="section-title">All done!</h2>
            <div class="pare-14">
                <p>Your password has been reset.</p>
            </div>
            <a class="btn-primary" href="{{route('web.login')}}" title="continue">CONTINUE
                <picture>
                <img src="{{ asset('assets/images/button-arrow.svg') }}" alt="continue-icon" width="" height="">
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
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $.validator.addMethod("format",function(value,element){
            return this.optional(element) || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[^a-zA-Z0-9]).{8,16}$/m.test(value);
        },"The password must be at least 8 characters, It's contains Capital, small aplhabate, one number, one special character.");
        $("#resetpasswordForm").validate({
            rules:{
                password:{
                    required:true,
                    minlength:8,
                    format:true,
                },
                confirm_passwod:{
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
                confirm_passwod:{
                    required:"Please enter confirm password.",
                    equalTo: 'Passwords do not match'
                }
            },
            errorElement:"span",
            errorPlacement: function(error, element) {
                error.addClass('error-mgs');// Add a class for styling purposes
                // error.insertAfter(element); // Place the error message after the element

                var errorSpanId = element.attr("id") + "Error";
                error.appendTo("#" + errorSpanId);
            },
            submitHandler: function(form) {
                $.ajax({
                    type: "POST",
                    url: "{{route('web.reset.password.post',$token)}}", // URL to submit form data
                    data: $(form).serialize(), // Serialize form data
                    success: function(response) {
                        if(response.success == true){
                            $("#btnverify").prop('disabled',true);
                            $("#successfull-modal").modal('show');
                        }else{
                            window.location.href="{{route('web.forget.password')}}";
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Handle the HTTP status code here
                        if (xhr.status === 302 || xhr.status === 419 || xhr.status === 401 ) {
                            location.reload();
                            // Redirect to the new location
                            // window.location.href = xhr.getResponseHeader('Location');
                        } 
                    },
                });
            }
        });

        $(".toggle-password-c").click(function () {
            var passwordField = $("#confirm_passwod");
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
    });
</script>
@endsection