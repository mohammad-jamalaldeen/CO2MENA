@extends('admin.auth.layout.app')
@section('title')
Forgot Password 
@endsection
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
            <form class="input-form" method="POST" id="myForm" action="{{ route('admin.otp_emailsend') }}">
                @csrf
                <div class="form-group">
                    <label for="">EMAIL <span class="mandatory-field">*</span></label>
                    <input type="email" class="form-controal" name="email" value="" placeholder="Enter email" >
                    @if ($errors->has('email'))
                        <span class="error-mgs">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                @if(session('error'))
                    <span class="error-mgs"> {{ session('error') }} </span>
                @endif
                <div class="button-row">
                    <button class="btn-primary" title="send" id="sendEmail" type="submit">SEND<picture>
                        <img  src="{{ asset('assets/images/button-arrow.svg') }}" alt="button-arrow" title="button-arrow" width="24" height="24">
                        </picture>
                    </button>
                </div>
                <div class="back-to">
                    <a href="{{ url('admin/login')}}" class="beck-link">
                    <picture>
                        <img  src="{{ asset('assets/images/back-arrow.svg') }}" alt="back-arrow" title="back-arrow" width="6" height="10">
                    </picture>Back to <span>Login</span></a>
                </div>
            </form>
        </div>
    </div>
    <div class="wel-img">
        <picture>
            <img  src="{{ asset('assets/images/wel-img.svg') }}" alt="welcome img" title="welcome img" width="712" height="597">
        </picture>
    </div>
</section>
<script type="text/javascript">
     $(document).ready(function() {
        $('#sendEmail').click(function() {
            var button = $(this);
            button.prop('disabled', true);
            button.html('Processing...');
            $('#myForm').submit();
        });
    });
</script>
@endsection