<!doctype html>
<html lang="en">
  	<head>
  	  	<meta charset="utf-8" />
  	  	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
  	  	<meta name="viewport" content="width=device-width, initial-scale=1" />
        <title><?php echo e(config('app.name')); ?> - <?php echo $__env->yieldContent('title', config('app.name')); ?></title>
  	  	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/bootstrap-select.css')); ?>">
  	  	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/style.css')); ?>">
		<script type="text/javascript" src="<?php echo e(asset('assets/js/jquery.min.js')); ?>" type="text/javascript"></script>
		<script type="text/javascript" src="<?php echo e(asset('assets/js/jquery.validate.min.js')); ?>" type="text/javascript"></script>
		<link rel="shortcut icon" href="<?php echo e(asset('assets/images/favicon.ico')); ?>" type="image/x-icon" />
</head>
<body>
<div class="page-wrapper login-page">
    <!-- <?php echo $__env->make('auth.layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> -->
    <?php echo $__env->yieldContent('content'); ?>
	<?php echo $__env->make('auth.layout.flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('auth.layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->yieldContent('scripts'); ?>
</div>
</body>
</html>
<?php /**PATH D:\M7md Jamal\Projects\0-milestones\1-CO2MENA\CO2MENA - SaaS Based Web Application\Source Code\co2mena\Source-Code\resources\views/auth/layout/app.blade.php ENDPATH**/ ?>