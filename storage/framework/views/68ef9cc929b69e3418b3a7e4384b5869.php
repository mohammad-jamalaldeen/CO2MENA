<div class="left-sidebar">
    <a href="#" class="sidebar-toggle-inner" title="Toggle Sidebar">
        <span></span>
        <span></span>
        <span></span>
    </a>
    <div>
        <div class="logo">
            <picture>
                <img src="<?php echo e(asset('assets/images/logo.svg')); ?>" alt="logo" width="169" height="40" class="logo-full" />
                <img src="<?php echo e(asset('assets/images/logo-icon.svg')); ?>" alt="logo" width="38" height="40" class="logo-icon" />
            </picture>
        </div>
        
        <div class="menu-wrap bac-menu">
            <ul class="navbar-nav">
                <li class="nav-item <?php echo e(adminPermissionCheck('dashboard.index') === false ? 'd-none' : 'd-block'); ?>" >
                    <a class="nav-link <?php echo e(Route::currentRouteNamed('dashboard.*') ? 'active' : ''); ?>"
                        href="<?php echo e(url('admin/dashboard')); ?>">
                        <picture>
                            <img src="<?php echo e(asset('assets/images/dashboard.svg')); ?>" alt="dashboard" width="16"
                                height="16" />
                        </picture>
                        <p>DASHBOARD</p>
                    </a>
                </li>
                <li class="nav-item <?php echo e(adminPermissionCheck('datasheet.index') === false ? 'd-none' : 'd-block'); ?>">
                    <a class="nav-link <?php echo e(Route::currentRouteNamed(['datasheet.*']) ? 'active' : ''); ?>"
                        href="<?php echo e(route('datasheet.index')); ?>">
                        <picture>
                            <img src="<?php echo e(asset('assets/images/datasheet.svg')); ?>" alt="datasheet" width="16"
                                height="16" />
                        </picture>
                        <p>Activity Sheets</p>
                    </a>
                </li>
                <li class="nav-item <?php echo e(adminPermissionCheck('backup-report.index') === false ? 'd-none' : 'd-block'); ?>">
                    <a class="nav-link <?php echo e(Route::currentRouteNamed(['backup-report.*']) ? 'active' : ''); ?>"
                        href="<?php echo e(route('backup-report.index')); ?>">
                        <picture>
                            <img src="<?php echo e(asset('assets/images/datasheet.svg')); ?>" alt="backup-report." width="16"
                                height="16" />
                        </picture>
                        <p>BACKUP REPORTS</p>
                    </a>
                </li>
                <li class="nav-item <?php echo e(adminPermissionCheck('contactus.index') === false ? 'd-none' : 'd-block'); ?>">
                    <a class="nav-link <?php echo e(Route::currentRouteNamed(['contactus.*']) ? 'active' : ''); ?>"
                        href="<?php echo e(route('contactus.index')); ?>">
                        <picture>
                            <img src="<?php echo e(asset('assets/images/support.svg')); ?>" alt="contactus" width="16"
                                height="16" />
                        </picture>
                        <p>CONTACT REQUEST DATA MANAGEMENT</p>
                    </a>
                </li>
                <li class="nav-item <?php echo e(adminPermissionCheck('customer.index') === false ? 'd-none' : 'd-block'); ?>">
                    <a class="nav-link <?php echo e(Route::currentRouteNamed(['customer.*', 'companystaff.*']) ? 'active' : ''); ?>"
                        href="<?php echo e(route('customer.index')); ?>">
                        <picture>
                            <img src="<?php echo e(asset('assets/images/staff-member.svg')); ?>" alt="customer" width="16"
                                height="16" />
                        </picture>
                        <p>Customer Management</p>
                    </a>
                </li>
                <?php
                    $action = Route::getCurrentRoute()->getPrefix();
                    $activeclassArr = ['admin/fuels', 'admin/refrigerants', 'admin/vehicles', 'admin/electricity-heat-cooling', 'admin/welltotankfuels', 'admin/transmission-and-distribution', 'admin/water-supply-treatment', 'admin/bussinesstravel', 'admin/employees-commuting', 'admin/material-use', 'admin/waste-disposal', 'admin/foodcosumption', 'admin/material-use', 'admin/freighting-goodsgvh', 'admin/freighting-goodsfr', 'admin/flight'];
                    $isActivities = in_array($action, $activeclassArr) ? 'active' : '';
                    $openClass = $isActivities ? 'click open' : '';
                    $liClass = $isActivities ? 'menu-drop-open' : '';
                    $firstUlLiStyle = $isActivities ? 'd-block;' : 'd-none;';
                    $secondOpenclass = $action == 'admin/freighting-goodsgvh' || $action == 'admin/freighting-goodsfr' ? 'click open' : '';
                    $secondliClass = $secondOpenclass ? 'menu-drop-open' : '';
                    $secondUlListyle = $secondOpenclass ? 'display:block;' : 'display:none;';
                    $thirdOpenClass = $action == 'admin/flight' ? 'click open' : '';
                    $thirdliClass = $thirdOpenClass ? 'menu-drop-open' : '';
                    $thirdUlListyle = $thirdOpenClass ? 'display:block;' : 'display:none;';

                    $permissionArr = [
                        adminPermissionCheck('fuels.index'),
                        adminPermissionCheck('refrigerants.index'),
                        adminPermissionCheck('vehicles.index'),
                        adminPermissionCheck('electricity-heat-cooling.index'),
                        adminPermissionCheck('welltotankfuels.index'),
                        adminPermissionCheck('transmission-and-distribution.index'),
                        adminPermissionCheck('water-supply-treatment.index'),
                        adminPermissionCheck('bussinesstravel.index'),
                        adminPermissionCheck('employees-commuting.index'),
                        adminPermissionCheck('material-use.index'),
                        adminPermissionCheck('waste-disposal.index'),
                        adminPermissionCheck('foodcosumption.index'),
                        adminPermissionCheck('freighting-goodsgvh.index'),
                        adminPermissionCheck('freighting-goodsfr.index'),
                    ];
                    $displayactivitydropdown = in_array(true,$permissionArr) ? 'd-block':'d-none';
                ?>
                <li class="nav-item dropdown <?php echo e($liClass); ?> <?php echo e($displayactivitydropdown); ?>" id="dropdownMenu" >
                    <a class="nav-link <?php echo e($isActivities); ?> <?php echo e($openClass); ?>">
                        <picture>
                            <img src="<?php echo e(asset('assets/images/dashboard.svg')); ?>" alt="activities" width="16"
                                height="16" />
                        </picture>
                        <p>Activities</p>
                    </a>
                    
                    <ul class="dropdown-menu <?php echo e($firstUlLiStyle); ?>" id="dropdownMenuContent">
                        
                        <li class="nav-item <?php echo e(adminPermissionCheck('fuels.index') === false ? 'd-none' : 'd-block'); ?>" >
                            <a class="nav-link <?php echo e(Route::currentRouteNamed(['fuels.*']) ? 'active' : ''); ?>"
                                href="<?php echo e(route('fuels.index')); ?>">
                                <picture>
                                    <img src="<?php echo e(asset('assets/images/staff-member.svg')); ?>" alt="fuels"
                                        width="16" height="16" />
                                </picture>
                                <p>Fuels</p>
                            </a>
                        </li>
                        
                        
                        <li class="nav-item <?php echo e(adminPermissionCheck('refrigerants.index') === false ? 'd-none' : 'd-block'); ?>">
                            <a class="nav-link <?php echo e(Route::currentRouteNamed(['refrigerants.*']) ? 'active' : ''); ?>"
                                href="<?php echo e(route('refrigerants.index')); ?>">
                                <picture>
                                    <img src="<?php echo e(asset('assets/images/staff-member.svg')); ?>" alt="refrigerants"
                                        width="16" height="16" />
                                </picture>
                                <p>Refrigerants</p>
                            </a>
                        </li>
                        
                        
                        <li class="nav-item <?php echo e(adminPermissionCheck('vehicles.index') === false ? 'd-none' : 'd-block'); ?>">
                            <a class="nav-link <?php echo e(Route::currentRouteNamed(['vehicles.*']) ? 'active' : ''); ?>"
                                href="<?php echo e(route('vehicles.index')); ?>">
                                <picture>
                                    <img src="<?php echo e(asset('assets/images/staff-member.svg')); ?>" alt="vehicles"
                                        width="16" height="16" />
                                </picture>
                                <p>vehicles</p>
                            </a>
                        </li>
                        
                        
                        <li class="nav-item <?php echo e(adminPermissionCheck('electricity-heat-cooling.index') === false ? 'd-none' : 'd-block'); ?>" >
                            <a class="nav-link <?php echo e(Route::currentRouteNamed(['electricity-heat-cooling.*']) ? 'active' : ''); ?>"
                                href="<?php echo e(route('electricity-heat-cooling.index')); ?>">
                                <picture>
                                    <img src="<?php echo e(asset('assets/images/staff-member.svg')); ?>" alt="electricity-heat-cooling"
                                        width="16" height="16" />
                                </picture>
                                <p>Electricity, Heat, Cooling</p>
                            </a>
                        </li>
                        
                        <li class="nav-item <?php echo e(adminPermissionCheck('welltotankfuels.index') === false ? 'd-none' : 'd-block'); ?>">
                            <a class="nav-link <?php echo e(Route::currentRouteNamed(['welltotankfuels.*']) ? 'active' : ''); ?>"
                                href="<?php echo e(route('welltotankfuels.index')); ?>">
                                <picture>
                                    <img src="<?php echo e(asset('assets/images/staff-member.svg')); ?>" alt="welltotankfuels"
                                        width="16" height="16" />
                                </picture>
                                <p>Well TO Tank Fuels</p>
                            </a>
                        </li>
                        
                        <li class="nav-item <?php echo e(adminPermissionCheck('transmission-and-distribution.index') === false ? 'd-none' : 'd-block'); ?>">
                            <a class="nav-link <?php echo e(Route::currentRouteNamed(['transmission-and-distribution.*']) ? 'active' : ''); ?>"
                                href="<?php echo e(route('transmission-and-distribution.index')); ?>">
                                <picture>
                                    <img src="<?php echo e(asset('assets/images/staff-member.svg')); ?>" alt="transmission-and-distribution"
                                        width="16" height="16" />
                                </picture>
                                <p>Transmission And Distributions</p>
                            </a>
                        </li>
                        
                        
                        <li class="nav-item <?php echo e(adminPermissionCheck('water-supply-treatment.index') == false ?'d-none':'d-block'); ?>">
                            <a class="nav-link <?php echo e(Route::currentRouteNamed(['water-supply-treatment.*']) ? 'active' : ''); ?>"
                                href="<?php echo e(route('water-supply-treatment.index')); ?>">
                                <picture>
                                    <img src="<?php echo e(asset('assets/images/staff-member.svg')); ?>" alt="water-supply-treatment"
                                        width="16" height="16" />
                                </picture>
                                <p>Water supply treatment</p>
                            </a>
                        </li>
                        

                        <li class="nav-item <?php echo e(adminPermissionCheck('bussinesstravel.index') == false ?'d-none':'d-block'); ?>">
                            <a class="nav-link <?php echo e(Route::currentRouteNamed(['bussinesstravel.*']) ? 'active' : ''); ?>"
                                href="<?php echo e(route('bussinesstravel.index')); ?>">
                                <picture>
                                    <img src="<?php echo e(asset('assets/images/staff-member.svg')); ?>" alt="bussinesstravel"
                                        width="16" height="16" />
                                </picture>
                                <p>Business Travel</p>
                            </a>
                        </li>
                        <li class="nav-item <?php echo e(adminPermissionCheck('employees-commuting.index') == false ?'d-none':'d-block'); ?>">
                            <a class="nav-link <?php echo e(Route::currentRouteNamed(['employees-commuting.*']) ? 'active' : ''); ?>"
                                href="<?php echo e(route('employees-commuting.index')); ?>">
                                <picture>
                                    <img src="<?php echo e(asset('assets/images/staff-member.svg')); ?>" alt="employees-commuting"
                                        width="16" height="16" />
                                </picture>
                                <p>Employees Commuting</p>
                            </a>
                        </li>
                        
                        <li class="nav-item <?php echo e(adminPermissionCheck('material-use.index') == false ?'d-none':'d-block'); ?>">
                            <a class="nav-link <?php echo e(Route::currentRouteNamed(['material-use.*']) ? 'active' : ''); ?>"
                                href="<?php echo e(route('material-use.index')); ?>">
                                <picture>
                                    <img src="<?php echo e(asset('assets/images/staff-member.svg')); ?>" alt="material-use"
                                        width="16" height="16" />
                                </picture>
                                <p>Material Uses</p>
                            </a>
                        </li>
                        
                        
                        <li class="nav-item <?php echo e(adminPermissionCheck('waste-disposal.index') == false ?'d-none':'d-block'); ?>">
                            <a class="nav-link <?php echo e(Route::currentRouteNamed(['waste-disposal.*']) ? 'active' : ''); ?>"
                                href="<?php echo e(route('waste-disposal.index')); ?>">
                                <picture>
                                    <img src="<?php echo e(asset('assets/images/staff-member.svg')); ?>" alt="waste-disposal"
                                        width="16" height="16" />
                                </picture>
                                <p>Waste disposal</p>
                            </a>
                        </li>
                        
                        
                        <li class="nav-item <?php echo e(adminPermissionCheck('foodcosumption.index') == false ?'d-none':'d-block'); ?>">
                            <a class="nav-link <?php echo e(Route::currentRouteNamed(['foodcosumption.*']) ? 'active' : ''); ?>"
                                href="<?php echo e(route('foodcosumption.index')); ?>">
                                <picture>
                                    <img src="<?php echo e(asset('assets/images/staff-member.svg')); ?>" alt="foodcosumption"
                                        width="16" height="16" />
                                </picture>
                                <p>Food</p>
                            </a>
                        </li>
                        
                        
                        <?php if(adminPermissionCheck('freighting-goodsgvh.index')  || adminPermissionCheck('freighting-goodsfr.index')): ?>
                            <li class="nav-item dropdown <?php echo e($secondliClass); ?>">
                                <a href="#"
                                    class="nav-link <?php echo e(Route::currentRouteNamed(['freighting-goodsgvh.*', 'freighting-goodsfr.*']) ? 'active' : ''); ?> <?php echo e($secondOpenclass); ?>"
                                    id="menu2">
                                    <picture>
                                        <img src="<?php echo e(asset('assets/images/staff-member.svg')); ?>" alt="freighting-goodsgvh"
                                            width="16" height="16" />
                                    </picture>
                                    <p>Freighting Good</p>
                                </a>
                                <ul class="dropdown-menu" style="<?php echo e($secondUlListyle); ?>">
                                    <li class="nav-item <?php echo e(adminPermissionCheck('freighting-goodsgvh.index') == false ?'d-none':'d-block'); ?>">
                                        <a class="nav-link <?php echo e(Route::currentRouteNamed(['freighting-goodsgvh.*']) ? 'active' : ''); ?>"
                                            href="<?php echo e(route('freighting-goodsgvh.index')); ?>">
                                            <picture>
                                                <img src="<?php echo e(asset('assets/images/staff-member.svg')); ?>" alt="freighting-goodsgvh"
                                                    width="16" height="16" />
                                            </picture>
                                            <p>Vans And Hgvs</p>
                                        </a>
                                    </li>                                   
                                    <li class="nav-item <?php echo e(adminPermissionCheck('freighting-goodsfr.index') == false ?'d-none':'d-block'); ?>">
                                        <a class="nav-link <?php echo e(Route::currentRouteNamed(['freighting-goodsfr.*']) ? 'active' : ''); ?>"
                                            href="<?php echo e(route('freighting-goodsfr.index')); ?>">
                                            <picture>
                                                <img src="<?php echo e(asset('assets/images/staff-member.svg')); ?>" alt="freighting-goodsfr"
                                                    width="16" height="16" />
                                            </picture>
                                            <p>Flight Rail Sea Tenker And Cargo Ship</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <li class="nav-item <?php echo e(adminPermissionCheck('sub-admin.index') === false ? 'd-none' : 'd-block'); ?>">
                    <a class="nav-link <?php echo e(Route::currentRouteNamed('sub-admin.*') ? 'active' : ''); ?>"
                        href="<?php echo e(route('sub-admin.index')); ?>">
                        <picture>
                            <img src="<?php echo e(asset('assets/images/staff-member.svg')); ?>" alt="sub-admin"
                                width="16" height="16" />
                        </picture>
                        <p>Sub-admin Management</p>
                    </a>
                </li>
                <li class="nav-item <?php echo e(adminPermissionCheck('cms.index') === false ? 'd-none' : 'd-block'); ?>">
                    <a class="nav-link <?php echo e(Route::currentRouteNamed(['cms.*']) ? 'active' : ''); ?>"
                        href="<?php echo e(route('cms.index')); ?>">
                        <picture>
                            <img src="<?php echo e(asset('assets/images/cms.svg')); ?>" alt="cms" width="16"
                                height="16" />
                        </picture>
                        <p>CMS Management</p>
                    </a>
                </li>
                <?php if(App\Models\User::isSuperAdmin() == true): ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
<div class="modal fade common-modal datasheet-modal cd-modal change_password_btn change-password-modal" id="cp_popup">
    <div class="modal-dialog modal-dialog-centered cp-dialog-modal">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" title="close"></button>
            <div class="content-inner">
                <h2 class="section-title">Change Password</h2>

                <form class="input-form" method="POST" id="change_password_form"
                    action="<?php echo e(route('profile.change_password')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <div class="password-hide-show errorCurrentPasswordCls">
                                    <input type="password" class="form-controal field-clear-cp"
                                        id="current_password" name="current_password" value=""
                                        placeholder="Current password" autocomplete="current-password">
                                    <a class="hide-show-icon toggle-password" data-id="1">
                                        <picture>
                                            <img id="eye-open" class="eye-opn-cp-reset eye-close-ps"
                                                src="<?php echo e(asset('assets/images/eye-show.svg')); ?>" alt="eye-show"
                                                width="16" height="13">
                                            <img id="eye-close" class="eye-cp-reset"
                                                src="<?php echo e(asset('assets/images/eye-hide.svg')); ?>" alt="eye-hide"
                                                width="16" height="13">
                                        </picture>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="password">New Password</label>
                                <div class="password-hide-show errorPasswordCls">
                                    <input type="password" id="password" class="form-controal field-clear-cp"
                                        name="password" value="" placeholder="New password" autocomplete="new-password">
                                    <a class="hide-show-icon toggle-password" data-id="2">
                                        <picture>
                                            <img id="eye-open-second" class="eye-opn-cp-reset eye-close-ps"
                                                src="<?php echo e(asset('assets/images/eye-show.svg')); ?>" alt="eye-show"
                                                width="16" height="13">
                                            <img id="eye-close-second" class="eye-cp-reset"
                                                src="<?php echo e(asset('assets/images/eye-hide.svg')); ?>" alt="eye-hide"
                                                width="16" height="13">
                                        </picture>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <div class="password-hide-show errorConPasswordCls">
                                    <input type="password" id="password_confirmation"
                                        class="form-controal field-clear-cp" name="password_confirmation"
                                        value="" placeholder="Confirm password" autocomplete="new-password">
                                    <a class="hide-show-icon toggle-password" data-id="3">
                                        <picture>
                                            <img id="eye-open-third" class="eye-opn-cp-reset eye-close-ps"
                                                src="<?php echo e(asset('assets/images/eye-show.svg')); ?>" alt="eye-show"
                                                width="16" height="13">
                                            <img id="eye-close-third" class="eye-cp-reset"
                                                src="<?php echo e(asset('assets/images/eye-hide.svg')); ?>" alt="eye-hide"
                                                width="16" height="13">
                                        </picture>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span class="error-mgs" id="errorMessages"></span>
                    <div class="row">
                        <div class="col-12">
                            <div class="btn-wrap">
                                <a href="#" class="back-btn" data-bs-dismiss="modal" aria-label="CANCEL" title="cancel">CANCEL</a>
                                <button class="btn-primary" id="changePasswordButton" type="submit" title="update">
                                    UPDATE
                                    <picture>
                                        <img src="<?php echo e(asset('assets/images/button-arrow.svg')); ?>" alt="button-arrow" width="24" height="24" />
                                    </picture>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade common-modal" id="successfull-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" title="close"></button>
            <div class="content-inner">
                <picture>
                    <img src="<?php echo e(asset('assets/images/succeseefull.png')); ?>" alt="succeseefull" width=""
                        height="">
                </picture>
                <h2 class="section-title">All done!</h2>
                <div class="pare-14">
                    <p>Your password has been reset.</p>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* .modal-dialog.modal-dialog-centered.cp-dialog-modal {
        max-width: 50% !important;
        width: 50% !important;
    } */

    .eye-close-ps {
        display: none;
    }
</style>
<?php /**PATH D:\M7md Jamal\Projects\0-milestones\1-CO2MENA\CO2MENA - SaaS Based Web Application\Source Code\co2mena\Source-Code\resources\views/admin/layouts/leftsidebar.blade.php ENDPATH**/ ?>