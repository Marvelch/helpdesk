<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('./assets/img/apple-icon.png')}}">
    <link rel="icon" type="image/png" href="{{asset('./assets/img/favicon.png')}}">
    <title>
        {{ config('app.name', 'Laravel') }}
    </title>
    <!-- Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{asset('./assets/css/nucleo-icons.css')}}" rel="stylesheet" />
    <link href="{{asset('./assets/css/nucleo-svg.css')}}" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital@1&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{asset('./css/all.css')}}">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{asset('./assets/css/soft-ui-dashboard.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('./css/style.css')}}">
    <!-- Jquery -->
    <script src="{{asset('./js/jquery-3.7.0.js')}}"></script>
    <!-- Tinymce -->
    <x-head.tinymce-config />
    <!-- Select2 -->
    <link href="{{asset('./css/select2.min.css')}}" rel="stylesheet" />
    <script src="{{asset('./js/select2.min.js')}}"></script>
    <!-- Datatables -->
    <link rel="stylesheet" href="{{asset('./css/dataTables.css')}}" />
    <script src="{{asset('js/dataTables.js')}}"></script>
    <!-- Pusher -->
    @if(Auth::check())
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('c16ba877d6981d017714', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('private.{{Auth::user()->id}}');
        channel.bind('my-event', function (data) {
            // alert(JSON.stringify(data));
            $('.pusher-append').append("<li class='mb-2'><a class='dropdown-item border-radius-md' href='javascript:;'><div class='d-flex py-1'><div class='my-auto'><img src='../assets/img/team-2.jpg' class='avatar avatar-sm  me-3 '></div><div class='d-flex flex-column justify-content-center'><h6 class='text-sm font-weight-normal mb-1'><span class='font-weight-bold'>New message</span> from Laur</h6><p class='text-xs text-secondary mb-0 '><i class='fa fa-clock me-1'></i>13 minutes ago</p></div></div></a></li>");
        });

    </script>
    @endif
</head>
