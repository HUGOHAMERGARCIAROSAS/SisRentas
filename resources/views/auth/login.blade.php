<!DOCTYPE html>
<html>
<head>
    <title>SISTEMA</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="description" content="SISTEMA DE RENTAS">
    <meta name="author" content="SOFTHARDS">

    {{-- <link rel="icon" href="{{asset('logo.jpg')}}" type="image/x-icon"> --}}
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{asset('inicio_session/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('inicio_session/css/font-awesome.min.css')}}">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{asset('inicio_session/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('inicio_session/css/color_skins.css')}}">
</head>
<body class="theme-cyan">
    <div id="wrapper">
        <div class="vertical-align-wrap">
            <div class="vertical-align-middle auth-main">
                <div class="auth-box">
                    <div class="top">
                        {{-- <img src="{{asset('logos.jpeg')}}" alt=""> --}}
                    </div>
                    <div id="app">
                        <iniciar-session-component></iniciar-session-component>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>


