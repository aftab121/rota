<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Mosaddek">
        <!--favicon icon-->
        <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
        <title>Sotaris - @yield('title')</title>
        <link href='http://fonts.googleapis.com/css?family=Abel|Source+Sans+Pro:400,300,300italic,400italic,600,600italic,700,700italic,900,900italic,200italic,200' rel='stylesheet' type='text/css'>
        <!-- inject:css -->
        <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('vendor/animate/animate.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('vendor/elasic-slider/elastic.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('vendor/iconmoon/linea-icon.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('vendor/magnific-popup/magnific-popup.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('vendor/owl-carousel/owl.carousel.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('vendor/owl-carousel/owl.theme.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('css/shortcodes.css')}}" type="text/css">
        <link rel="stylesheet" href="{{ asset('css/style.css')}}" type="text/css">
        <link rel="stylesheet" href="{{ asset('css/default-theme.css') }}" type="text/css">
        <!-- endinject -->
        <!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->
        <link rel="stylesheet" type="text/css" href="{{asset('vendor/slider-revolution/css/extralayers.css')}}" media="screen">
        <link rel="stylesheet" type="text/css" href="{{asset('vendor/slider-revolution/css/settings.css')}}" media="screen">
    </head>
    <body>
       
        @yield('content')
    </body>
</html>