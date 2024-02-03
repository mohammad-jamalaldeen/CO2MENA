<?php $__env->startSection('title'); ?> Login Page <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<section class="welcome-screen">
    <div class="credentials-content">
        <?php echo $__env->make('auth.layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="content-inner">
            <div class="center-text">
                <h2 class="section-title">Welcome to CO2MENA!</h2>
                <div class="para-14">
                    <p>Please enter your details</p>
                </div>
            </div>
            <form id="loginform" class="input-form" action="<?php echo e(route('web.login.post')); ?>" method="POST" enctype="multipart/from-data">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label for="email">EMAIL OR USERNAME <span class="mandatory-field">*</span></label>
                    <input type="email" class="form-controal" name="email" id="email" placeholder="Enter email or username" autocomplete="email">
                    <span id="emailError">
                        <?php if($errors->has('email')): ?>
                            <span class="error-mgs"><?php echo e($errors->first('email')); ?></span>
                        <?php endif; ?>
                    </span>                    
                </div>
                <div class="form-group">
                    <label for="password">PASSWORD <span class="mandatory-field">*</span></label>
                    <div class="password-hide-show">
                        <input type="password" id="password" class="form-controal" name="password" placeholder="Enter password" autocomplete="current-password">
                        <a class="hide-show-icon" id="toggle_password" title="password">
                            <picture>
                                <img  src="<?php echo e(asset('assets/images/eye-hide.svg')); ?>" alt="eye-hide" id="hideshowpassword" class="hidepwd" width="16" height="13">
                            </picture>                
                        </a>
                    </div>
                    <span id="passwordError">
                        <?php if($errors->has('password')): ?>
                            <span class="error-mgs"><?php echo e($errors->first('password')); ?></span>
                        <?php endif; ?>
                    </span>                    
                </div>
                <div class="remember-group">
                    <div class="custome-checkbox">
                        <label class="checkbox">
                            <input type="checkbox" name="remember">Remember me <span class="checkmark"></span>
                        </label>
                    </div>
                    <a href="<?php echo e(route('web.forget.password')); ?>" class="forger-link">Forgot password?</a>
                </div>
                <?php if($errors->has('remember')): ?>
                    <span class="error-mgs"><?php echo e($errors->first('remember')); ?></span>
                <?php endif; ?>
                <div class="button-row">
                    <button type="submit" class="btn-primary" title="login">log in<picture>
                        <img src="<?php echo e(asset('assets/images/button-arrow.svg')); ?>" alt="button-arrow" width="24" height="24">
                        </picture>
                    </button>                    
                </div>
            </form>
        </div>
    </div>
    <div class="wel-img">
        <picture>
            <img  src="<?php echo e(asset('assets/images/wel-img.svg')); ?>" alt="welcome img" width="712" height="597">
        </picture>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#hideshowpassword').click(function(){
            if($(this).hasClass("hidepwd")){
                $(this).attr("src","<?php echo e(asset('assets/images/eye-show.svg')); ?>");
                $(this).removeClass('hidepwd');
                $(this).addClass('showpwd');
                $("#password").attr('type','text');
            } else {
                $(this).attr("src","<?php echo e(asset('assets/images/eye-hide.svg')); ?>");
                $(this).addClass('hidepwd');
                $(this).removeClass('showpwd');
                $("#password").attr('type','password');
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\M7md Jamal\Projects\0-milestones\1-CO2MENA\CO2MENA - SaaS Based Web Application\Source Code\co2mena\Source-Code\resources\views/auth/login.blade.php ENDPATH**/ ?>