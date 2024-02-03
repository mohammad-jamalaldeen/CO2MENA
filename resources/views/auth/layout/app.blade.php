<!doctype html>
<html lang="en">
  	<head>
  	  	<meta charset="utf-8" />
  	  	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
  	  	<meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>{{ config('app.name') }} - @yield('title', config('app.name'))</title>
  	  	<link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap-select.css')}}">
  	  	<link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
		<script type="text/javascript" src="{{asset('assets/js/jquery.min.js')}}" type="text/javascript"></script>
		<script type="text/javascript" src="{{asset('assets/js/jquery.validate.min.js')}}" type="text/javascript"></script>
		<link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon" />
</head>
<body>
<div class="page-wrapper login-page">
    <!-- @include('auth.layout.header') -->
    @yield('content')
	@include('auth.layout.flash-message')
    @include('auth.layout.footer')
	@yield('scripts')
</div>
</body>
</html>
