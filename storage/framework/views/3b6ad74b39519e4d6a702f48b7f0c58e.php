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
      <div class="menu-wrap">
        <ul class="navbar-nav">
          <?php
            $companyRole = \App\Models\UserRole::where('role','Company Admin')->first();
            if(Auth::guard('web')->user()->user_role_id == $companyRole->id){
              $action = route('dashboard.index');
            }else{
              $action = route('dashboard.index');
            }
          ?>
          <li class="nav-item <?php echo e((frontendPermissionCheck('dashboard.index') === false) ? 'd-none' : 'd-block'); ?>">
            <a class="nav-link <?php echo e(Route::currentRouteNamed('dashboard.*') ? 'active' : ''); ?>" href="<?php echo e(route('dashboard.index')); ?>">
                <picture>
                    <img src="<?php echo e(asset('assets/images/dashboard.svg')); ?>" alt="dashboard" width="16" height="16" />
                </picture>
              <p>DASHBOARD</p></a>
          </li>
          <!-------------------------------------->
          <!--------------------------------------> 
          <?php
            $action = Route::getCurrentRoute()->getPrefix();
            if ($action == '/front/datasheet') {
              $active_class = 'active';
            } else {
              $active_class = '';
            }
          ?>     
          <li class="nav-item <?php echo e((frontendPermissionCheck('frontend-datasheets.index') === false) ? 'd-none' : 'd-block'); ?>" >
            <a class="nav-link <?php echo e($active_class); ?>" href="<?php echo e(route('frontend-datasheets.index')); ?>">
                <picture>
                    <img src="<?php echo e(asset('assets/images/datasheet.svg')); ?>" alt="datasheet" width="16" height="16" />
                </picture>
              <p>Activity Sheets</p>
            </a>
          </li>
          <li class="nav-item <?php echo e((frontendPermissionCheck('frontend-datasheets.index') === false) ? 'd-none' : 'd-block'); ?>" >
            <a class="nav-link <?php echo e($active_class); ?>" href="<?php echo e(route('frontend-datasheets.index')); ?>">
                <picture>
                    <img src="<?php echo e(asset('assets/images/dashboard.svg')); ?>" alt="datasheet" width="16" height="16" />
                </picture>
              <p>Net Zero Target</p>
            </a>
          </li>
          <li class="nav-item <?php echo e((frontendPermissionCheck('frontend-datasheets.index') === false) ? 'd-none' : 'd-block'); ?>" >
            <a class="nav-link <?php echo e($active_class); ?>" href="<?php echo e(route('frontend-datasheets.index')); ?>">
                <picture>
                    <img src="<?php echo e(asset('assets/images/datasheet.svg')); ?>" alt="datasheet" width="16" height="16" />
                </picture>
              <p>Benchmark</p>
            </a>
          </li>
             
            <?php
              $action = Route::getCurrentRoute()->getPrefix();
              if ($action == '/staff') {
                $active_class = 'active';
              } else {
                $active_class = '';
              }
            ?>
            <li class="nav-item <?php echo e((frontendPermissionCheck('staff.index') === false) ? 'd-none' : 'd-block'); ?>" >
              <a class="nav-link <?php echo e($active_class); ?>" href="<?php echo e(route('staff.index')); ?>">
                  <picture>
                      <img src="<?php echo e(asset('assets/images/staff-member.svg')); ?>" alt="staff-member" width="16" height="16" />
                  </picture>
                <p>Staff Members</p></a>
            </li>
        
          <?php
            $action = Route::getCurrentRoute();
            if ($action->uri == 'profile') {
              $active_class = 'active';
            } else {
              $active_class = '';
            }
          ?>
              
          <li class="nav-item <?php echo e((frontendPermissionCheck('profile.index') === false) ? 'd-none' : 'd-block'); ?>" >
            <a class="nav-link <?php echo e($active_class); ?>" href="<?php echo e(route('profile.index')); ?>">
                <picture>
                    <img src="<?php echo e(asset('assets/images/user-icon.svg')); ?>" alt="user-icon" width="16" height="16" />
                </picture>
              <p>PROFILES</p></a>
          </li>  
          <li class="nav-item <?php echo e((frontendPermissionCheck('customer-support.index') === false) ? 'd-none' : 'd-block'); ?>">
            <a class="nav-link <?php echo e(activeClass(['customer-support'], Route::getCurrentRoute()->uri())); ?>" href="<?php echo e(route('customer-support.index')); ?>">
                <picture>
                    <img src="<?php echo e(asset('assets/images/support.svg')); ?>" alt="support" width="16" height="16" />
                </picture>
              <p>Customer Support</p></a>
          </li>
        </ul>
        <?php
          $companyRole = \App\Models\UserRole::where('role','Company Admin')->first();
        ?>
        <?php if(Auth::guard('web')->user()->user_role_id == $companyRole->id): ?>   
          <?php if(checkSubscriptions() == true && frontMultiplePermissionCheck() > 0): ?>    
            <div class="subsription-link">
              <a class="subscription-title">SUBSCRIPTION PLAN
                  
              </a>
              <p>Your Subscription plan will expire soon please upgrade!</p>
            </div>
          <?php endif; ?> 
        <?php endif; ?>
      </ul>
      <?php if(Auth::guard('web')->user()->user_type_id == 3): ?>   
        <?php if(checkSubscriptions() == true): ?>    
          <div class="subsription-link">
            <a class="subscription-title">SUBSCRIPTION PLAN
                
            </a>
            <p>Your Subscription plan will expire soon please upgrade!</p>
          </div>
        <?php endif; ?> 
      <?php endif; ?>
    </div>
  </div>
    
</div>
  <div class="modal fade common-modal datasheet-modal cd-modal change_password_btn change-password-modal" id="cp_popup">
    <div class="modal-dialog modal-dialog-centered cp-dialog-modal">
      <div class="modal-content">
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" title="close"></button>
        <div class="content-inner">
          <h2 class="section-title">Change Password</h2>
  
          <form class="input-form" method="POST" id="change_password_form" action="<?php echo e(route('change-password.edit')); ?>">
            <?php echo csrf_field(); ?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="current_password">Current Password<span class="mandatory-field">*</span></label>
                  <div class="password-hide-show errorCurrentPasswordCls">
                      <input type="password" class="form-controal field-clear-cp" id="current_password" name="current_password" value="" placeholder="Current password" autocomplete="current-password">
                      <a class="hide-show-icon toggle-password" data-id="1">
                          <picture>
                              <img id="eye-open" class="eye-opn-cp-reset eye-close-ps" src="<?php echo e(asset('assets/images/eye-show.svg')); ?>" alt="eye-show" width="16" height="13">
                              <img id="eye-close" class="eye-cp-reset" src="<?php echo e(asset('assets/images/eye-hide.svg')); ?>" alt="eye-hide" width="16" height="13">
                          </picture>                
                      </a>
                   </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="password">New Password<span class="mandatory-field">*</span></label>
                  <div class="password-hide-show errorPasswordCls">
                      <input type="password" id="password" class="form-controal field-clear-cp" name="password" value="" placeholder="New password" autocomplete="new-password">
                      <a class="hide-show-icon toggle-password" data-id="2">
                          <picture>
                              <img id="eye-open-second" class="eye-opn-cp-reset eye-close-ps" src="<?php echo e(asset('assets/images/eye-show.svg')); ?>" alt="eye-show" width="16" height="13">
                              <img id="eye-close-second" class="eye-cp-reset" src="<?php echo e(asset('assets/images/eye-hide.svg')); ?>" alt="eye-hide" width="16" height="13">
                          </picture>                
                      </a>
                    </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="password_confirmation">Confirm Password<span class="mandatory-field">*</span></label>
                  <div class="password-hide-show errorConPasswordCls">
                      <input type="password" id="password_confirmation" class="form-controal field-clear-cp" name="password_confirmation" value="" placeholder="Confirm password" autocomplete="new-password">
                      <a class="hide-show-icon toggle-password" data-id="3">
                          <picture>
                              <img id="eye-open-third" class="eye-opn-cp-reset eye-close-ps" src="<?php echo e(asset('assets/images/eye-show.svg')); ?>" alt="eye-show" width="16" height="13">
                              <img id="eye-close-third" class="eye-cp-reset" src="<?php echo e(asset('assets/images/eye-hide.svg')); ?>" alt="eye-hide" width="16" height="13">
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
                  <a href="#" class="back-btn" data-bs-dismiss="modal" aria-label="CANCEL">CANCEL</a>
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
                <img  src="<?php echo e(asset('assets/images/succeseefull.png')); ?>" alt="succeseefull" width="" height="">
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
    /* .modal-dialog.modal-dialog-centered.cp-dialog-modal{
      max-width: 50% !important;
      width: 50% !important;
    } */
    .eye-close-ps{
      display: none;
    }
  </style><?php /**PATH D:\M7md Jamal\Projects\0-milestones\1-CO2MENA\CO2MENA - SaaS Based Web Application\Source Code\co2mena\Source-Code\resources\views/frontend/layouts/leftsidebar.blade.php ENDPATH**/ ?>