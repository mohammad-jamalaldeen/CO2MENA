<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <!-- Required meta tags -->
    {{-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> --}}
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--  Preload Img  -->
    {{-- <link rel="preload" as="image" href=""> --}}

    <!--  Title Name  -->
    <title>{{ config('app.name') }} - Company Details</title>

    <!--  Favicon Icon  -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/mcustomscrollbar.min.css') }}" />

    <!-- custome CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">

    <!--  jQuery first -->
    <script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
    @yield('header_scripts')
</head>
<body>
    @php
        $LoginUserInfo = Auth::guard('web')->user();
    @endphp
    @if ($LoginUserInfo->status == 0)
        <script type="text/javascript">
            window.location = "{{ route('web.logout') }}";
        </script>
    @endif
    <div class="company-details-wrap @if (activeClass(['frontend/{slug}'], Route::getCurrentRoute()->uri())) cms_page @endif">
        @include('frontend.layouts.on-boarding-header') 
        @yield('content')
    </div>
    <!--  Bootstrap JS  -->
    <script type="text/javascript" src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap-select-beta2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/lazysizes.min.js') }}"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/mcustomscrollbar.min.js') }}"></script>

    <!--  Custome JS  -->
    <script type="text/javascript" src="{{ asset('assets/js/custom.js') }}"></script>
    @include('auth.layout.flash-message')
    @yield('footer_scripts')
</body>
