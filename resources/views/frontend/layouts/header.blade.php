<header class="dashboard-header">

    <div class="header-top">
        <div class="header-left">
            @if (
                !in_array(Route::currentRouteName(), [
                    'dashboard.index',
                    'dashboard.scope1',
                    'dashboard.scope2',
                    'dashboard.scope3',
                ]))
                <h2 class="main-title"> @yield('title')</h2>
            @endif
            @php
            $userDetails = Auth::guard('web')->user();
            $staffRoleId = \App\Models\UserRole::whereNot('role','Company Admin')->where('type','Frontend')->pluck('id')->toArray();
            if (in_array($userDetails->user_role_id, $staffRoleId)) {
                $companyStaffData = \App\Models\StaffCompany::select('id', 'user_id', 'company_id')->where('user_id', $userDetails->id)->first();
                $userDetailsCompany = \App\Models\Company::where('id',$companyStaffData->company_id)->first();
                $userCount = \App\Models\Datasheet::where('user_id',$userDetailsCompany->user_id)->where('status','3')->count();
            }else{
                $userCount = \App\Models\Datasheet::where('user_id',$userDetails->id)->where('status','3')->count();
            }
            @endphp
            @if (in_array(Route::currentRouteName(), [
                    'dashboard.index',
                    'dashboard.scope1',
                    'dashboard.scope2',
                    'dashboard.scope3',
                ]))
                @php
                    $queryParams = request()->query();
                    $datasheetArray = isset($queryParams['datasheet']) ? ['datasheet' => $queryParams['datasheet']] : [];
                @endphp
                {{-- @if($userCount > 0) --}}
                <ul class="dashbord-steps">
                    <li><a href="{{ route('dashboard.index',$datasheetArray) }}"
                            class="export-button step-link main-dashboard-over {{ Route::currentRouteName() == 'dashboard.index' ? 'active' : '' }}">
                            Overview
                        </a></li>
                    <li><a href="{{ route('dashboard.scope1', $datasheetArray) }}"
                            class="export-button step-link scope1-dashboard {{ Route::currentRouteName() == 'dashboard.scope1' ? 'active' : '' }}">
                            Scope 1
                        </a></li>
                    <li><a href="{{ route('dashboard.scope2', $datasheetArray) }}"
                            class="export-button step-link {{ Route::currentRouteName() == 'dashboard.scope2' ? 'active' : '' }}">
                            Scope 2
                        </a></li>
                    <li><a href="{{ route('dashboard.scope3', $datasheetArray) }}"
                            class="export-button step-link {{ Route::currentRouteName() == 'dashboard.scope3' ? 'active' : '' }}">
                            Scope 3
                        </a></li>
                </ul>
                {{-- @else
            @endif --}}
            @endif
        </div>


        <div class="header-right">
            <div class="user-side">
                <div class="dropdown user-details">
                    <div class="user-name dropdown-toggle" type="button" data-bs-toggle="dropdown"
                         >
                        @php
                            $user = Auth::guard('web')->user();
                            $string = $user->name;
                            $words = preg_split('/[\s,]+/', $string, -1, PREG_SPLIT_NO_EMPTY); // Split the string into words
                            $acronym = '';
                            foreach ($words as $word) {
                                $acronym .= strtoupper(substr($word, 0, 1)); // Get the first letter of each word and convert to uppercase
                            }
                        @endphp
                        <span>{{ $acronym }}</span>

                        {{ ucwords($string) }}
                        <picture>
                            <img src="{{ asset('assets/images/arrow-down.svg') }}" alt="back-arrow" width="6"
                                height="10" />
                        </picture>
                    </div>
                    <ul class="dropdown-menu">
                        <li
                            style="display:{{ frontendPermissionCheck('profile.index') === false ? 'none' : 'block' }}">
                            <a class="dropdown-item" href="{{ route('profile.index') }}">Profile</a>
                        </li>
                        <li
                            style="display:{{ frontendPermissionCheck('change-password.edit') === false ? 'none' : 'block' }}">
                            <a class="dropdown-item change_password_btn" class="" data-bs-toggle="modal"
                                data-bs-target="#cp_popup" href="#">Change Password</a>
                        </li>
                        <li>
                            <a class="dropdown-item logout" href="{{ route('web.logout') }}">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
