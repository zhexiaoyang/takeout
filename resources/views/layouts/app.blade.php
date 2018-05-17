<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Laravel') - 外卖平台</title>

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style-responsive.css') }}" rel="stylesheet">
    @yield('styles')
</head>

<body>
    <section id="container" class="{{ route_class() }}-page">

        @include('layouts._header')

        @include('layouts._menu')

        <section id="main-content">
            <section class="wrapper">

                @yield('content')

            </section>
        </section>

        @include('layouts._footer')

    </section>
    <audio id="waitPrintMusic" src="{{ asset('img/waitPrintMusic.mp3') }}"></audio>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-1.8.3.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/common-scripts.js') }}"></script>
    @yield('scripts')
    <script>
        window.onload = function(){
            var waitPrintMusic = document.getElementById("waitPrintMusic");
            waitPrintMusic.pause();
            @if(count($print_orders) > 0)
            openMusic();
            @endif
        }
        function openMusic() {
            var opMusic = document.getElementById('waitPrintMusic');
            opMusic.autoplay = "autopaly";
            if(opMusic.ended){
                opMusic.loop = "loop";
            }
            opMusic.play();
            opMusic.removeAttribute("loop");
        }

    </script>
</body>
</html>
