<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-select.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <!-- custome CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery-ui.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.timepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/mcustomscrollbar.min.css') }}" />
    <!--  jQuery first -->
    <script  type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script  type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <link type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">
    <script  type="text/javascript" src="{{asset('assets/js/tinymce.min.js')}}"></script>
    
    <script  type="text/javascript" src="{{ asset('assets/js/jquery-ui.js') }}"></script>
    <script  type="text/javascript" src="{{ asset('assets/js/jquery.timepicker.min.js') }}"></script>

    @yield('header_scripts')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="dashboard-page">
        <div class="dashboard-inner">

            @include('admin.layouts.leftsidebar')
            <div class="right-wrapper">
                @include('admin.layouts.header')
                @include('auth.layout.flash-message')
                @yield('content')
            </div>

        </div>
    </div>
</div>
<!-- <div id="myModal" class="modal imagemodal">
    <div class="img-inner-wrapper">
        <div class="img-inner">
            <span class="close">&times;</span>
            <img class="modal-content-image" id="img01" alt="image">
            <div id="caption"></div>
        </div>
    </div>
</div> -->

<div class="modal img-modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" title="close"></button>
            <div class="content-inner">
                <img class="modal-content-image" id="img01" alt="image">
            </div>
        </div>
    </div>
</div>
@yield('footer_scripts')
 <!--  Bootstrap JS  -->
    <script  type="text/javascript" src="{{asset('assets/js/popper.min.js')}}"></script>
    <script  type="text/javascript" src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
    <script  type="text/javascript" src="{{asset('assets/js/bootstrap-select-beta2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/lazysizes.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/mcustomscrollbar.min.js') }}"></script>  
    <script type="text/javascript" src="{{ asset('assets/js/custom.js') }}"></script>
    <script type="text/javascript">
        var modal = document.getElementById("myModal");
        $(document).on("click",".imagepop",function(){
                
            var modalImg = document.getElementById("img01");
            modal.style.display = "block";
            modalImg.src = this.src;
            $("#myModal").modal("show");
        });
        $(document).on("click",".close",function(){
            modal.style.display = "none";
        });
    </script>
</body>

</html>
