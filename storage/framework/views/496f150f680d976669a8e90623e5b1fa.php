<header class="dashboard-header">

    <div class="header-top">
        <div class="header-left">
            <?php if(
                !in_array(Route::currentRouteName(), [
                    'dashboard.index',
                    'dashboard.scope1',
                    'dashboard.scope2',
                    'dashboard.scope3',
                ])): ?>
                <h2 class="main-title"> <?php echo $__env->yieldContent('title'); ?></h2>
            <?php endif; ?>
            <?php
            $userDetails = Auth::guard('web')->user();
            $staffRoleId = \App\Models\UserRole::whereNot('role','Company Admin')->where('type','Frontend')->pluck('id')->toArray();
            if (in_array($userDetails->user_role_id, $staffRoleId)) {
                $companyStaffData = \App\Models\StaffCompany::select('id', 'user_id', 'company_id')->where('user_id', $userDetails->id)->first();
                $userDetailsCompany = \App\Models\Company::where('id',$companyStaffData->company_id)->first();
                $userCount = \App\Models\Datasheet::where('user_id',$userDetailsCompany->user_id)->where('status','3')->count();
            }else{
                $userCount = \App\Models\Datasheet::where('user_id',$userDetails->id)->where('status','3')->count();
            }
            ?>
            <?php if(in_array(Route::currentRouteName(), [
                    'dashboard.index',
                    'dashboard.scope1',
                    'dashboard.scope2',
                    'dashboard.scope3',
                ])): ?>
                <?php
                    $queryParams = request()->query();
                    $datasheetArray = isset($queryParams['datasheet']) ? ['datasheet' => $queryParams['datasheet']] : [];
                ?>
                
                <ul class="dashbord-steps">
                    <li><a href="<?php echo e(route('dashboard.index',$datasheetArray)); ?>"
                            class="export-button step-link main-dashboard-over <?php echo e(Route::currentRouteName() == 'dashboard.index' ? 'active' : ''); ?>">
                            Overview
                        </a></li>
                    <li><a href="<?php echo e(route('dashboard.scope1', $datasheetArray)); ?>"
                            class="export-button step-link scope1-dashboard <?php echo e(Route::currentRouteName() == 'dashboard.scope1' ? 'active' : ''); ?>">
                            Scope 1
                        </a></li>
                    <li><a href="<?php echo e(route('dashboard.scope2', $datasheetArray)); ?>"
                            class="export-button step-link <?php echo e(Route::currentRouteName() == 'dashboard.scope2' ? 'active' : ''); ?>">
                            Scope 2
                        </a></li>
                    <li><a href="<?php echo e(route('dashboard.scope3', $datasheetArray)); ?>"
                            class="export-button step-link <?php echo e(Route::currentRouteName() == 'dashboard.scope3' ? 'active' : ''); ?>">
                            Scope 3
                        </a></li>
                </ul>
                
            <?php endif; ?>
        </div>


        <div class="header-right">
            <div class="user-side">
                <div class="dropdown user-details">
                    <div class="user-name dropdown-toggle" type="button" data-bs-toggle="dropdown"
                         >
                        <?php
                            $user = Auth::guard('web')->user();
                            $string = $user->name;
                            $words = preg_split('/[\s,]+/', $string, -1, PREG_SPLIT_NO_EMPTY); // Split the string into words
                            $acronym = '';
                            foreach ($words as $word) {
                                $acronym .= strtoupper(substr($word, 0, 1)); // Get the first letter of each word and convert to uppercase
                            }
                        ?>
                        <span><?php echo e($acronym); ?></span>

                        <?php echo e(ucwords($string)); ?>

                        <picture>
                            <img src="<?php echo e(asset('assets/images/arrow-down.svg')); ?>" alt="back-arrow" width="6"
                                height="10" />
                        </picture>
                    </div>
                    <ul class="dropdown-menu">
                        <li
                            style="display:<?php echo e(frontendPermissionCheck('profile.index') === false ? 'none' : 'block'); ?>">
                            <a class="dropdown-item" href="<?php echo e(route('profile.index')); ?>">Profile</a>
                        </li>
                        <li
                            style="display:<?php echo e(frontendPermissionCheck('change-password.edit') === false ? 'none' : 'block'); ?>">
                            <a class="dropdown-item change_password_btn" class="" data-bs-toggle="modal"
                                data-bs-target="#cp_popup" href="#">Change Password</a>
                        </li>
                        <li>
                            <a class="dropdown-item logout" href="<?php echo e(route('web.logout')); ?>">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<?php /**PATH D:\M7md Jamal\Projects\0-milestones\1-CO2MENA\CO2MENA - SaaS Based Web Application\Source Code\co2mena\Source-Code\resources\views/frontend/layouts/header.blade.php ENDPATH**/ ?>