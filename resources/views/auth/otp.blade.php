@extends('auth.layout.app')
@section('title')
    OTP Verification 
@endsection
@section('content')
<section class="welcome-screen">
    <div class="credentials-content">
        @include('auth.layout.header')
        <div class="content-inner">
            <div class="center-text">
                <h2 class="section-title">OTP verification</h2>
                <div class="para-14">
                    <p>We've sent you an OTP via email.</p>
                </div>
            </div>
            <form id="otp-form"class="input-form" action="{{route('web.forgetpassword.otp.check',$slug)}}" method="POST">  
                @csrf
                    <div class="otp-input pin">
                        <input type="text" class="form-controal" name="otp1" value="" placeholder="*" maxlength="1" required>
                        <input type="text" class="form-controal" name="otp2" value="" placeholder="*" maxlength="1" required>
                        <input type="text" class="form-controal" name="otp3" value="" placeholder="*" maxlength="1" required>
                        <input type="text" class="form-controal" name="otp4" value="" placeholder="*" maxlength="1" required>
                        <input type="text" class="form-controal" name="otp5" value="" placeholder="*" maxlength="1" required>
                        <input type="text" class="form-controal" name="otp6" value="" placeholder="*" maxlength="1" required>
                    </div>
                    <div id="otpvalidation"></div>
                <div class="button-row">
                    <button class="btn-primary" id="verifybtnotpform" title="verify-time"><span class="verify-time">0:45s</span>VERIFY
                        <picture>
                        <img  src="{{ asset('assets/images/button-arrow.svg') }}" alt="button-arrow" width="24" height="24">
                        </picture>
                    </button>
                </div>
                <div class="resend-row" >
                    Didn't receive the email? 
                    <a href="javascript:void(0);" id="resendOTP" title="Resend code">Resend code</a>
                </div>
                <div class="back-to">
                    <a href="{{ route('web.login')}}" class="beck-link" title="Back to login">
                    <picture>
                        <img  src="{{ asset('assets/images/back-arrow.svg') }}" alt="back-arrow" width="6" height="10">
                    </picture>Back to <span>Login</span></a>
                </div>
            </form>
        </div>
    </div>
    <div class="wel-img">
        <picture>
            <img  src="{{ asset('assets/images/wel-img.svg')}}" alt="welcome img" width="712" height="597">
        </picture>
    </div>
</section>
@endsection
@section('scripts')
<script type="text/javascript">
    const els = (sel, par) => (par || document).querySelectorAll(sel);
    els(".pin").forEach((elGroup) => {

        const elsInput = [...elGroup.children];
        const len = elsInput.length;
        
        const handlePaste = (ev) => {
            const clip = ev.clipboardData.getData('text');    
            const pin = clip.replace(/\s/g, "");               
            const ch = [...pin];                               
            elsInput.forEach((el, i) => el.value = ch[i]??""); 
            elsInput[pin.length - 1].focus();                 
        };

        const handleInput = (ev) => {
            const elInp = ev.currentTarget;
            const i = elsInput.indexOf(elInp);
            if (elInp.value && (i+1) % len) elsInput[i + 1].focus();  
        };
        
        const handleKeyDn = (ev) => {
            const elInp = ev.currentTarget
            const i = elsInput.indexOf(elInp);
            if (!elInp.value && ev.key === "Backspace" && i) elsInput[i - 1].focus(); 
        };
        
        elsInput.forEach(elInp => {
            //elInp.addEventListener("paste", handlePaste);  
            elInp.addEventListener("input", handleInput);   
            elInp.addEventListener("keydown", handleKeyDn); 
        });

    });
    $(document).ready(function() {
        var countdownInterval;
        var countdownTime = 45;
        function updateCountdown(coutTime = '') {
            countdownTime = (coutTime != '') ? coutTime : countdownTime;
            if (countdownTime >= 0) {
                var minutes = Math.floor(countdownTime / 60);
                var seconds = countdownTime % 60;

                $('.verify-time').text(minutes + ':' + (seconds < 10 ? '0' : '') + seconds);
                $("#resendOTP").css("pointer-events","none");
                $("#resendOTP").removeClass('active');
                countdownTime--;
            } else {
                $('.verify-time').text('');//Time\'s up!
                $("#resendOTP").css("pointer-events","unset");
                $("#resendOTP").addClass('active');
                clearInterval(countdownInterval);
            }
        }
        function setTimeOutFunction()
        {
            setTimeout(function() {
                updateCountdown();
                var countdownInterval = setInterval(updateCountdown, 1000); // Update every second
            }, 1000);      
        }

        setTimeOutFunction();

            $('#resendOTP').click(function() {
            $("#resendOTP").css("pointer-events","none");
            $("#resendOTP").removeClass('active');
            $.ajax({
                url: "{{ route('web.resend.otp',$slug) }}",
                type: 'GET',
                success: function(response) {                    
                    if(response.status == 'true'){
                        $('.verify-time').text('');      
                        // $('#verifybtnotpform').prop('disabled', false);
                        $("#resendOTP").css("pointer-events","none");
                        $("#resendOTP").removeClass('active');
                        $('.verify-time').text('0.45s');        
                        setReturnMsg("Success", response.message)
                        updateCountdown(45);
                    }else{
                        setReturnMsg("danger", response.message);
                    }
                },
                error: function(error) {
                    $("#resendOTP").css("pointer-events","unset");
                    $("#resendOTP").addClass('active');
                    if (error.status === 429) {
                        setReturnMsg("danger", 'Your OTP resend limit reached, please try tomorrow.');
                    }
                    if (error.status === 302 || error.status === 419 || error.status === 401 ) {
                        location.reload();
                        // Redirect to the new location
                        // window.location.href = xhr.getResponseHeader('Location');
                    } 
                }
            });
        });
        function setReturnMsg(title, message){
            var title = title;
            var lowercaseString = title.toLowerCase();
            if(lowercaseString== "danger")
            {
                title = 'Error';
            }
            $.notify({
                title: '<strong>'+title+'</strong>',
                message: "<br>"+message+"",
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