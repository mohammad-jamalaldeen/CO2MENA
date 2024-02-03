<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
  
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--  Preload Img  -->
    <!-- <link rel="preload" as="image" href="{{ asset('admin_assets/images/favicon.png') }}"/> -->
    <!--  Title Name  -->
    <title>{{ config('app.name') }} - @yield('title')</title>
    <!--  Favicon Icon  -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-select.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <!-- custome CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/mcustomscrollbar.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}" />

    <!--  jQuery first -->
    <script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>

    @yield('header_scripts')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div id="loader">
        <div class="loader-inner">
            <img src="{{ asset('assets/loader.gif') }}" alt="loader" />
        </div>
    </div>
    @php
		$userDetails = Auth::guard('web')->user();
	@endphp
	@if(!empty($userDetails) && $userDetails->status != '1' )
	<script type="text/javascript">
		window.location = "{{ route('web.logout') }}";
	</script>
	@endif
    <div class="dashboard-page">
        <div class="dashboard-inner">
            @include('frontend.layouts.leftsidebar')
            <div class="right-wrapper">
                @include('frontend.layouts.header')
                @include('auth.layout.flash-message')
                @yield('content')
            </div>
        </div>
    </div>
{{-- </div> --}}
 <!--  Bootstrap JS  -->
    <script type="text/javascript" src="{{asset('assets/js/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/bootstrap-select-beta2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/lazysizes.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/mcustomscrollbar.min.js') }}"></script>  
    <script type="text/javascript" src="{{ asset('assets/js/custom.js') }}"></script>
    @yield('footer_scripts')
</body>

</html>
