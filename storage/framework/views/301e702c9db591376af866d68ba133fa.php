<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/notify/animate.min.css')); ?>">
<script type="text/javascript" src="<?php echo e(asset('assets/notify/bootstrap-notify.min.js')); ?>"></script>
<script type="text/javascript">
 <?php if(Session::has('successSubscription')): ?>
        $.notify({
            // options
            message: "<br><?php echo e(Session::get('successSubscription')); ?>",
        }, {
            element: 'body',
            position: null,
            type: "success",
            //allow_dismiss: true,
            //newest_on_top: false,
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
        <?php
            Session::forget('success');
        ?>
    <?php endif; ?>

    <?php if(Session::has('success')): ?>
        $.notify({
            // options
            title: '<strong>Success</strong>',
            message: "<br><?php echo e(Session::get('success')); ?>",
        }, {
            element: 'body',
            position: null,
            type: "success",
            //allow_dismiss: true,
            //newest_on_top: false,
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
        <?php
            Session::forget('success');
        ?>
    <?php endif; ?>
    <?php if(Session::has('linksuccess')): ?>
        $.notify({
            // options
            title: '<strong>Success</strong>',
            message: "<br><?php echo e(Session::get('linksuccess')); ?>",
        }, {
            element: 'body',
            position: null,
            type: "success",
            //allow_dismiss: true,
            //newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 999999,
            delay: 2000,
            timer: 5000,
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
        <?php
            Session::forget('linksuccess');
        ?>
    <?php endif; ?>
    <?php if(Session::has('success-login')): ?>
        $.notify({
            // options
            title: '<strong>Success</strong>',
            message: "<br><?php echo e(Session::get('success-login')); ?>",
        }, {
            element: 'body',
            position: null,
            type: "success",
            //allow_dismiss: true,
            //newest_on_top: false,
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
        <?php
            Session::forget('success-login');
        ?>
    <?php endif; ?>
    <?php if(Session::has('info')): ?>
        $.notify({
            // options
            title: '<strong>Info</strong>',
            message: "<br><?php echo e(Session::get('info')); ?>",
        }, {
            // settings
            element: 'body',
            position: null,
            type: "info",
            allow_dismiss: true,
            newest_on_top: false,
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
                enter: 'animated bounceInDown',
                exit: 'animated bounceOutUp'
            },
            onShow: null,
            onShown: null,
            onClose: null,
            onClosed: null,
            icon_type: 'class',
        });
        <?php
            Session::forget('info');
        ?>
    <?php endif; ?>

    <?php if(Session::has('warning')): ?>
        $.notify({
            // options
            title: '<strong>Warning</strong>',
            message: "<br><?php echo e(Session::get('warning')); ?>",
        }, {
            // settings
            element: 'body',
            position: null,
            type: "warning",
            allow_dismiss: true,
            newest_on_top: false,
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
                enter: 'animated bounceIn',
                exit: 'animated bounceOut'
            },
            onShow: null,
            onShown: null,
            onClose: null,
            onClosed: null,
            icon_type: 'class',
        });
        <?php
            Session::forget('warning');
        ?>
    <?php endif; ?>

    <?php if(Session::has('danger')): ?>
        $.notify({
            // options
            title: '<strong>Error</strong>',
            message: "<br><?php echo e(Session::get('danger')); ?>",
        }, {
            // settings
            element: 'body',
            position: null,
            type: "danger",
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 999999,
            delay: 2000,
            timer: 2000,
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
        <?php
            Session::forget('danger');
        ?>
    <?php endif; ?>
  
    <?php if(Session::has('error')): ?>
  
        $.notify({
            // options
            title: '<strong>Error</strong>',
            message: "<br><?php echo e(Session::get('error')); ?>",
        }, {
            // settings
            element: 'body',
            position: null,
            type: "danger",
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 999999,
            delay: 2000,
            timer: 2000,
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
        <?php
            Session::forget('error');
        ?>
    <?php endif; ?>

    <?php if(Session::has('primary')): ?>
        $.notify({
            // options
            title: '<strong>Primary</strong>',
            message: "<br><?php echo e(Session::get('primary')); ?>",
        }, {
            // settings
            element: 'body',
            position: null,
            type: "success",
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 999999,
            delay: 3300,
            timer: 1000,
            mouse_over: null,
            animate: {
                enter: 'animated lightSpeedIn',
                exit: 'animated lightSpeedOut'
            },
            onShow: null,
            onShown: null,
            onClose: null,
            onClosed: null,
            icon_type: 'class',
        });
        <?php
            Session::forget('primary');
        ?>
    <?php endif; ?>

    <?php if(Session::has('default')): ?>
        $.notify({
            // options
            title: '<strong>Default</strong>',
            message: "<br><?php echo e(Session::get('default')); ?>",
        }, {
            // settings
            element: 'body',
            position: null,
            type: "warning",
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 999999,
            delay: 3300,
            timer: 1000,
            mouse_over: null,
            animate: {
                enter: 'animated rollIn',
                exit: 'animated rollOut'
            },
            onShow: null,
            onShown: null,
            onClose: null,
            onClosed: null,
            icon_type: 'class',
        });
        <?php
            Session::forget('default');
        ?>
    <?php endif; ?>

    <?php if(Session::has('link')): ?>
        $.notify({
            // options
            title: '<strong>Link</strong>',
            message: "<br><?php echo e(Session::get('link')); ?>",
        }, {
            // settings
            element: 'body',
            position: null,
            type: "danger",
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 999999,
            delay: 3300,
            timer: 1000,
            mouse_over: null,
            animate: {
                enter: 'animated zoomInDown',
                exit: 'animated zoomOutUp'
            },
            onShow: null,
            onShown: null,
            onClose: null,
            onClosed: null,
            icon_type: 'class',
        });
        <?php
            Session::forget('link');
        ?>
    <?php endif; ?>
</script>
<?php /**PATH D:\M7md Jamal\Projects\0-milestones\1-CO2MENA\CO2MENA - SaaS Based Web Application\Source Code\co2mena\Source-Code\resources\views/auth/layout/flash-message.blade.php ENDPATH**/ ?>