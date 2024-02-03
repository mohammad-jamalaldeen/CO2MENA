@extends('auth.layout.app')
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
            <form id="loginform" class="input-form" action="{{ route('web.login.post') }}" method="POST" enctype="multipart/from-data">
                @csrf
                <div class="form-group">
                    <label for="email">EMAIL OR USERNAME <span class="mandatory-field">*</span></label>
                    <input type="email" class="form-controal" name="email" id="email" placeholder="Enter email or username" autocomplete="email">
                    <span id="emailError">
                        @if ($errors->has('email'))
                            <span class="error-mgs">{{ $errors->first('email') }}</span>
                        @endif
                    </span>                    
                </div>
                <div class="form-group">
                    <label for="password">PASSWORD <span class="mandatory-field">*</span></label>
                    <div class="password-hide-show">
                        <input type="password" id="password" class="form-controal" name="password" placeholder="Enter password" autocomplete="current-password">
                        <a class="hide-show-icon" id="toggle_password" title="password">
                            <picture>
                                <img  src="{{asset('assets/images/eye-hide.svg')}}" alt="eye-hide" id="hideshowpassword" class="hidepwd" width="16" height="13">
                            </picture>                
                        </a>
                    </div>
                    <span id="passwordError">
                        @if ($errors->has('password'))
                            <span class="error-mgs">{{ $errors->first('password') }}</span>
                        @endif
                    </span>                    
                </div>
                <div class="remember-group">
                    <div class="custome-checkbox">
                        <label class="checkbox">
                            <input type="checkbox" name="remember">Remember me <span class="checkmark"></span>
                        </label>
                    </div>
                    <a href="{{ route('web.forget.password') }}" class="forger-link">Forgot password?</a>
                </div>
                @if ($errors->has('remember'))
                    <span class="error-mgs">{{ $errors->first('remember') }}</span>
                @endif
                <div class="button-row">
                    <button type="submit" class="btn-primary" title="login">log in<picture>
                        <img src="{{asset('assets/images/button-arrow.svg')}}" alt="button-arrow" width="24" height="24">
                        </picture>
                    </button>                    
                </div>
            </form>
        </div>
    </div>
    <div class="wel-img">
        <picture>
            <img  src="{{asset('assets/images/wel-img.svg')}}" alt="welcome img" width="712" height="597">
        </picture>
    </div>
</section>
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $('#hideshowpassword').click(function(){
            if($(this).hasClass("hidepwd")){
                $(this).attr("src","{{asset('assets/images/eye-show.svg')}}");
                $(this).removeClass('hidepwd');
                $(this).addClass('showpwd');
                $("#password").attr('type','text');
            } else {
                $(this).attr("src","{{asset('assets/images/eye-hide.svg')}}");
                $(this).addClass('hidepwd');
                $(this).removeClass('showpwd');
                $("#password").attr('type','password');
            }
        });
    });
</script>
@endsection
