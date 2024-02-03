<header class="dashboard-header">
    <h2 class="main-title"> 
        <?php
            $route = Route::currentRouteNamed(['freighting-goodsgvh.*']);
            $route2 = Route::currentRouteNamed(['freighting-goodsfr.*']);
        ?>
        <?php echo $__env->yieldContent('title'); ?>
        <?php if($route == true): ?>
        <br><span>Vans And Hgvs</span>
        <?php elseif($route2 == true): ?>
        <br><span>Flight, Rail, Sea Tenker And Cargo Ship</span>
        <?php endif; ?>
    </h2>
    <div class="user-side">
        
        <div class="dropdown user-details">
            <div class="user-name dropdown-toggle" type="button" data-bs-toggle="dropdown"  >
            <?php
                $fullName =  Auth::guard('admin')->user()->name;
                $parts = explode(' ', $fullName);
                $initials = '';
                foreach ($parts as $part) {
                    $initials .= strtoupper(substr($part, 0, 1));
                }
                $initials = strtoupper($initials);
            ?>
            <span><?php echo e($initials); ?></span>
            <?php echo e($fullName); ?>

            <picture>
                <img src="<?php echo e(asset('assets/images/arrow-down.svg')); ?>" alt="back-arrow" width="6" height="10" />
            </picture>
            </div>
            <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?php echo e(route('profile.edit')); ?>">Profile</a></li>
            <li><a class="dropdown-item change_password_btn" class="" data-bs-toggle="modal" data-bs-target="#cp_popup" href="#">Change Password</a></li>
            <li>
                <a class="dropdown-item logout" href="<?php echo e(route('admin.logout')); ?>">Logout</a>
            </li>
            </ul>
        </div>
    </div>
</header><?php /**PATH D:\M7md Jamal\Projects\0-milestones\1-CO2MENA\CO2MENA - SaaS Based Web Application\Source Code\co2mena\Source-Code\resources\views/admin/layouts/header.blade.php ENDPATH**/ ?>