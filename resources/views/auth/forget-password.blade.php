@extends('auth.layout.app')
@section('title') Forget Password Page @endsection
@section('content')
<section class="welcome-screen">
    <div class="credentials-content">
    @include('auth.layout.header')
        <div class="content-inner">
            <div class="center-text">
                <h2 class="section-title">Forgot password?</h2>
                <div class="para-14">
                    <p>No worry we will send you reset instructions.</p>
                </div>
            </div>
            <form id="forgetpasswordform" class="input-form" action="{{route('web.forget.password.post')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="email">EMAIL ADDRESS <span class="mandatory-field">*</span></label>
                    <input type="text" id="email" class="form-controal" name="email" value="" placeholder="Enter email address" >
                    @if ($errors->has('email'))
                        <span class="error-mgs">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="button-row">
                    <button class="btn-primary" id="submitforgetpwdform" type="submit" title="send">SEND<picture>
                        <img  src="{{ asset('assets/images/button-arrow.svg') }}" alt="button-arrow" width="24" height="24">
                        </picture>
                    </button>
                </div>
                <div class="back-to">
                    <a href="{{ route('web.login')}}" class="beck-link" title="Back to Login">
                    <picture>
                        <img  src="{{ asset('assets/images/back-arrow.svg') }}" alt="back-arrow" width="6" height="10">
                    </picture>Back to <span>Login</span></a>
                </div>
            </form>
        </div>
    </div>
    <div class="wel-img">
        <picture>
            <img  src="{{ asset('assets/images/wel-img.svg') }}" alt="welcome img" width="712" height="597">
        </picture>
    </div>
</section>
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $("#forgetpasswordform").validate({
            rules:{
                email:{
                    required:true,
                    email:true,
                }
            },
            messages:{
                email:{
                    required:"Please enter email address.",
                }
            },
            errorElement:"span",
            errorPlacement: function(error, element) {
                error.addClass('error-mgs');
                error.insertAfter(element);
            },
            submitHandler: function(form) {
                form.submit();
                $("#submitforgetpwdform").prop('disabled',true);
            }
        });
    });
</script>
@endsection
