<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
  
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!--  Preload Img  -->
    <!-- <link rel="preload" as="image" href="<?php echo e(asset('admin_assets/images/favicon.png')); ?>"/> -->
    <!--  Title Name  -->
    <title><?php echo e(config('app.name')); ?> - <?php echo $__env->yieldContent('title'); ?></title>
    <!--  Favicon Icon  -->
    <link rel="shortcut icon" href="<?php echo e(asset('assets/images/favicon.ico')); ?>" type="image/x-icon" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/bootstrap-select.min.css')); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/jquery.dataTables.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <!-- custome CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/mcustomscrollbar.min.css')); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/style.css')); ?>" />

    <!--  jQuery first -->
    <script type="text/javascript" src="<?php echo e(asset('assets/js/jquery.min.js')); ?>"></script>

    <?php echo $__env->yieldContent('header_scripts'); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div id="loader">
        <div class="loader-inner">
            <img src="<?php echo e(asset('assets/loader.gif')); ?>" alt="loader" />
        </div>
    </div>
    <?php
		$userDetails = Auth::guard('web')->user();
	?>
	<?php if(!empty($userDetails) && $userDetails->status != '1' ): ?>
	<script type="text/javascript">
		window.location = "<?php echo e(route('web.logout')); ?>";
	</script>
	<?php endif; ?>
    <div class="dashboard-page">
        <div class="dashboard-inner">
            <?php echo $__env->make('frontend.layouts.leftsidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="right-wrapper">
                <?php echo $__env->make('frontend.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo $__env->make('auth.layout.flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </div>

 <!--  Bootstrap JS  -->
    <script type="text/javascript" src="<?php echo e(asset('assets/js/popper.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/bootstrap.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/bootstrap-select-beta2.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/lazysizes.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/jquery.dataTables.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/mcustomscrollbar.min.js')); ?>"></script>  
    <script type="text/javascript" src="<?php echo e(asset('assets/js/custom.js')); ?>"></script>
    <?php echo $__env->yieldContent('footer_scripts'); ?>
</body>

</html>
<?php /**PATH D:\M7md Jamal\Projects\0-milestones\1-CO2MENA\CO2MENA - SaaS Based Web Application\Source Code\co2mena\Source-Code\resources\views/frontend/layouts/main.blade.php ENDPATH**/ ?>