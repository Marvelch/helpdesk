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
    <link rel="stylesheet" href="{{asset('./css/all.min.css')}}">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{asset('./assets/css/soft-ui-dashboard.css?v=1.0.7')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('./css/style.css')}}">
    <!-- Jquery -->
    <script src="{{asset('./js/jquery-3.7.0.js')}}"></script>
    <!-- Tinymce -->
    <x-head.tinymce-config />
    <!-- Select2 -->
    <link href="{{asset('./css/select2.min.css')}}" rel="stylesheet" />
    <script src="{{asset('./js/select2.min.js')}}"></script>
</head>
