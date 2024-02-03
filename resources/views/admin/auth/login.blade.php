@extends('admin.auth.layout.app')
@section('title') Login Page @endsection
@section('content')
<section class="welcome-screen">
    <div class="credentials-content">
        @include('auth.layout.header')
        <div class="content-inner">
            <div class="center-text">
                <h2 class="section-title">Welcome to CO2MENA!</h2>
                <div class="para-14">
                    <p>Please enter your details</p>
                </div>
            </div>
            <form class="input-form" action="{{ route('admin.loginpost') }}" method="POST" enctype="multipart/from-data">
                @csrf
                <div class="form-group">
                    <label for="">EMAIL OR USERNAME <span class="mandatory-field">*</span></label>
                    <input type="text" class="form-controal" name="email" value="" placeholder="Enter email or username">
                    @if ($errors->has('email'))
                        <span class="error-mgs">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="">PASSWORD <span class="mandatory-field">*</span></label>
                    <div class="password-hide-show">
                        <input type="password" id="password" class="form-controal" name="password" value="" placeholder="********">
                        <a class="hide-show-icon toggle-password" id="">
                            <picture>
                                <img id="eye-open" class="eye-close-ps" src="{{asset('assets/images/eye-show.svg')}}" alt="eye-show" title="eye-show" width="16" height="13">
                                <img id="eye-close" src="{{asset('assets/images/eye-hide.svg')}}" alt="eye-hide" title="eye-hide" width="16" height="13">
                            </picture>                
                        </a>
                    </div>
                    @if ($errors->has('password'))
                        <span class="error-mgs">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="remember-group">
                    <div class="custome-checkbox">
                        <label class="checkbox">
                            <input type="checkbox" name="remember">Remember me <span class="checkmark"></span>
                        </label>
                    </div>
                    <a href="{{ route('admin.forgotpassword') }}" class="forger-link">Forgot password?</a>
                </div>
                <div class="button-row">
                    <button type="submit" class="btn-primary" title="log in">log in<picture>
                        <img src="{{asset('assets/images/button-arrow.svg')}}" alt="button-arrow" width="24" height="24" title="button-arrow">
                        </picture>
                    </button>                    
                </div>
            </form>
        </div>
    </div>
    <div class="wel-img">
        <picture>
            <img  src="{{asset('assets/images/wel-img.svg')}}" alt="welcome img" title="welcome img" width="712" height="597">
        </picture>
    </div>
</section>
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
