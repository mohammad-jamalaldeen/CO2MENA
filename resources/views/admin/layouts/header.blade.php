<header class="dashboard-header">
    <h2 class="main-title"> 
        @php
            $route = Route::currentRouteNamed(['freighting-goodsgvh.*']);
            $route2 = Route::currentRouteNamed(['freighting-goodsfr.*']);
        @endphp
        @yield('title')
        @if($route == true)
        <br><span>Vans And Hgvs</span>
        @elseif ($route2 == true)
        <br><span>Flight, Rail, Sea Tenker And Cargo Ship</span>
        @endif
    </h2>
    <div class="user-side">
        {{-- <div class="notification">
            <picture>
            <img src="{{asset('assets/images/notification-icon.svg')}}" alt="notification-icon" width="" height="" />
            </picture>
            <div class="notification-count">2</div>
            <div class="notification-list">
            <div class="notification-header">
                <h3 class="notifi-title">Notification</h3>
                <a href="javascript:void(0);" class="all-notifi">View All</a>
            </div>
            <ul>
                <li>
                <div class="member-noti">
                    <span class="member-notiimg"></span>
                    <div class="member-content">
                    <h3 class="notification-name">
                        Evelyn J. Wilkins
                    </h3>
                    <div class="noti-para">
                        Lorem ipsum dolor sit amet
                    </div>
                    </div>
                </div>
                <div class="notification-time">2 min ago</div>
                </li>
                <li>
                <div class="member-noti">
                    <span class="member-notiimg"></span>
                    <div class="member-content">
                    <h3 class="notification-name">
                        Evelyn J. Wilkins
                    </h3>
                    <div class="noti-para">
                        Lorem ipsum dolor sit amet
                    </div>
                    </div>
                </div>
                <div class="notification-time">Feb 10, 5:15 pm</div>
                </li>
                <li>
                <div class="member-noti">
                    <span class="member-notiimg"></span>
                    <div class="member-content">
                    <h3 class="notification-name">
                        Evelyn J. Wilkins
                    </h3>
                    <div class="noti-para">
                        Lorem ipsum dolor sit amet
                    </div>
                    </div>
                </div>
                <div class="notification-time">Feb 08, 11:30 am</div>
                </li>
                <li>
                <div class="member-noti">
                    <span class="member-notiimg"></span>
                    <div class="member-content">
                    <h3 class="notification-name">
                        Evelyn J. Wilkins
                    </h3>
                    <div class="noti-para">
                        Lorem ipsum dolor sit amet
                    </div>
                    </div>
                </div>
                <div class="notification-time">Feb 08, 11:30 am</div>
                </li>
                <li>
                <div class="member-noti">
                    <span class="member-notiimg"></span>
                    <div class="member-content">
                    <h3 class="notification-name">
                        Evelyn J. Wilkins
                    </h3>
                    <div class="noti-para">
                        Lorem ipsum dolor sit amet
                    </div>
                    </div>
                </div>
                <div class="notification-time">Feb 08, 11:30 am</div>
                </li>
            </ul>
            </div>
        </div> --}}
        <div class="dropdown user-details">
            <div class="user-name dropdown-toggle" type="button" data-bs-toggle="dropdown"  >
            @php
                $fullName =  Auth::guard('admin')->user()->name;
                $parts = explode(' ', $fullName);
                $initials = '';
                foreach ($parts as $part) {
                    $initials .= strtoupper(substr($part, 0, 1));
                }
                $initials = strtoupper($initials);
            @endphp
            <span>{{$initials}}</span>
            {{$fullName}}
            <picture>
                <img src="{{asset('assets/images/arrow-down.svg')}}" alt="back-arrow" width="6" height="10" />
            </picture>
            </div>
            <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
            <li><a class="dropdown-item change_password_btn" class="" data-bs-toggle="modal" data-bs-target="#cp_popup" href="#">Change Password</a></li>
            <li>
                <a class="dropdown-item logout" href="{{ route('admin.logout')}}">Logout</a>
            </li>
            </ul>
        </div>
    </div>
</header>