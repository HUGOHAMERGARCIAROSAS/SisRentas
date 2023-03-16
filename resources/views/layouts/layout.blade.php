<!doctype html>
<html lang="en">
<head>
    <title>SISTEMA DE RENTAS</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="description" content="">
    <meta name="author" content="">

    {{-- <link rel="icon" href="favicon.ico" type="image/x-icon"> --}}

    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{asset('css/bootstrap-progressbar-3.3.4.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/chartist.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/chartist-plugin-tooltip.css')}}">
    <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}">

    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <link rel="stylesheet" href="{{asset('css/color_skins.css')}}">

    {{-- Para pasar el usuario al app.js --}}
    @if (Auth::check())
        <script>
             window.user = {!! json_encode(auth()->user()) !!};
        </script>
    @endif


</head>

<body class="theme-cyan">

    <div id="wrapper">

       @include('layouts.header')

       @include('layouts.menu')

        <div id="main-content">
           @yield('main')
        </div>


    </div>

    <script src="{{asset('js/libscripts.bundle.js')}}"></script>
    <script src="{{asset('js/vendorscripts.bundle.js')}}"></script>

    <script src="{{asset('js/chartist.bundle.js')}}"></script>
    <script src="{{asset('js/knob.bundle.js')}}"></script>

    <script src="{{asset('js/mainscripts.bundle.js')}}"></script>
    <script src="{{asset('js/index.js')}}"></script>

    <script src="{{ asset('js/app.js') }}" defer></script>


</body>

</html>
