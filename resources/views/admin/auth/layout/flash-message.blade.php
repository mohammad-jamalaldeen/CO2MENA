<link rel="stylesheet" type="text/css" href="{{ asset('assets/notify/animate.min.css') }}">
<script type="text/javascript" src="{{ asset('assets/notify/bootstrap-notify.min.js') }}"></script>
<script type="text/javascript">
    @if (Session::has('success'))
        $.notify({
            // options
            title: '<strong>Success</strong>',
            message: "<br>{{ Session::get('success') }}",
        }, {
            element: 'body',
            position: null,
            type: "success",
            //allow_dismiss: true,
            //newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 999999,
            delay: 2000,
            timer: 1000,
            mouse_over: null,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutRight'
            },
            onShow: null,
            onShown: null,
            onClose: null,
            onClosed: null,
            icon_type: 'class',
        });
        @php
            Session::forget('success');
        @endphp
    @endif
    @if (Session::has('linksuccess'))
        $.notify({
            // options
            title: '<strong>Success</strong>',
            message: "<br>{{ Session::get('linksuccess') }}",
        }, {
            element: 'body',
            position: null,
            type: "success",
            //allow_dismiss: true,
            //newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 999999,
            delay: 2000,
            timer: 5000,
            mouse_over: null,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutRight'
            },
            onShow: null,
            onShown: null,
            onClose: null,
            onClosed: null,
            icon_type: 'class',
        });
        @php
            Session::forget('linksuccess');
        @endphp
    @endif
    @if (Session::has('success-login'))
        $.notify({
            // options
            title: '<strong>Success</strong>',
            message: "<br>{{ Session::get('success-login') }}",
        }, {
            element: 'body',
            position: null,
            type: "success",
            //allow_dismiss: true,
            //newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 999999,
            delay: 2000,
            timer: 1000,
            mouse_over: null,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutRight'
            },
            onShow: null,
            onShown: null,
            onClose: null,
            onClosed: null,
            icon_type: 'class',
        });
        @php
            Session::forget('success-login');
        @endphp
    @endif
    @if (Session::has('info'))
        $.notify({
            // options
            title: '<strong>Info</strong>',
            message: "<br>{{ Session::get('info') }}",
        }, {
            // settings
            element: 'body',
            position: null,
            type: "info",
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 999999,
            delay: 2000,
            timer: 1000,
            mouse_over: null,
            animate: {
                enter: 'animated bounceInDown',
                exit: 'animated bounceOutUp'
            },
            onShow: null,
            onShown: null,
            onClose: null,
            onClosed: null,
            icon_type: 'class',
        });
        @php
            Session::forget('info');
        @endphp
    @endif

    @if (Session::has('warning'))
        $.notify({
            // options
            title: '<strong>Warning</strong>',
            message: "<br>{{ Session::get('warning') }}",
        }, {
            // settings
            element: 'body',
            position: null,
            type: "warning",
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 999999,
            delay: 2000,
            timer: 1000,
            mouse_over: null,
            animate: {
                enter: 'animated bounceIn',
                exit: 'animated bounceOut'
            },
            onShow: null,
            onShown: null,
            onClose: null,
            onClosed: null,
            icon_type: 'class',
        });
        @php
            Session::forget('warning');
        @endphp
    @endif

    @if (Session::has('danger'))
        $.notify({
            // options
            title: '<strong>Error</strong>',
            message: "<br>{{ Session::get('danger') }}",
        }, {
            // settings
            element: 'body',
            position: null,
            type: "danger",
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 999999,
            delay: 2000,
            timer: 1000,
            mouse_over: null,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutRight'
            },
            onShow: null,
            onShown: null,
            onClose: null,
            onClosed: null,
            icon_type: 'class',
        });
        @php
            Session::forget('danger');
        @endphp
    @endif
    @if (Session::has('error'))
        $.notify({
            // options
            title: '<strong>Error</strong>',
            message: "<br>{{ Session::get('error') }}",
        }, {
            // settings
            element: 'body',
            position: null,
            type: "danger",
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 999999,
            delay: 2000,
            timer: 1000,
            mouse_over: null,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutRight'
            },
            onShow: null,
            onShown: null,
            onClose: null,
            onClosed: null,
            icon_type: 'class',
        });
        @php
            Session::forget('error');
        @endphp
    @endif

    @if (Session::has('primary'))
        $.notify({
            // options
            title: '<strong>Primary</strong>',
            message: "<br>{{ Session::get('primary') }}",
        }, {
            // settings
            element: 'body',
            position: null,
            type: "success",
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 999999,
            delay: 3300,
            timer: 1000,
            mouse_over: null,
            animate: {
                enter: 'animated lightSpeedIn',
                exit: 'animated lightSpeedOut'
            },
            onShow: null,
            onShown: null,
            onClose: null,
            onClosed: null,
            icon_type: 'class',
        });
        @php
            Session::forget('primary');
        @endphp
    @endif

    @if (Session::has('default'))
        $.notify({
            // options
            title: '<strong>Default</strong>',
            message: "<br>{{ Session::get('default') }}",
        }, {
            // settings
            element: 'body',
            position: null,
            type: "warning",
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 999999,
            delay: 3300,
            timer: 1000,
            mouse_over: null,
            animate: {
                enter: 'animated rollIn',
                exit: 'animated rollOut'
            },
            onShow: null,
            onShown: null,
            onClose: null,
            onClosed: null,
            icon_type: 'class',
        });
        @php
            Session::forget('default');
        @endphp
    @endif

    @if (Session::has('link'))
        $.notify({
            // options
            title: '<strong>Link</strong>',
            message: "<br>{{ Session::get('link') }}",
        }, {
            // settings
            element: 'body',
            position: null,
            type: "danger",
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 999999,
            delay: 3300,
            timer: 1000,
            mouse_over: null,
            animate: {
                enter: 'animated zoomInDown',
                exit: 'animated zoomOutUp'
            },
            onShow: null,
            onShown: null,
            onClose: null,
            onClosed: null,
            icon_type: 'class',
        });
        @php
            Session::forget('link');
        @endphp
    @endif
</script>
