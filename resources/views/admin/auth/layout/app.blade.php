<!doctype html>
<html lang="en">
  	<head>
        <meta charset="utf-8" />
  	  	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
  	  	<meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>{{ config('app.name') }} - @yield('title', config('app.name'))</title>
		<link rel="icon" type=“image/x-icon” href="{{ asset('assets/images/favicon.ico') }}">
  	  	<link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap-select.css')}}">
  	  	<link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
		<script type="text/javascript" src="{{asset('assets/js/jquery.min.js')}}"></script>
		<script type="text/javascript" src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
		<link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon" />
</head>
<body>
<div class="page-wrapper login-page">
    <!-- @include('admin.auth.layout.header') -->
    @yield('content')
	@include('admin.auth.layout.flash-message')
    @include('admin.auth.layout.footer')

</div>
</body>
</html>
