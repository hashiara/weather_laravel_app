<html>
    <body class="bg-info-subtle">
        <video id="video" poster="{{ asset('/images/bgimg.jpg') }}" webkit-playsinline playsinline muted autoplay loop>
            <source src="{{ asset('/movie/bgmovie.mp4') }}" type="video/mp4">
        </video>
        
        @include('layouts.main.header')
        @yield('content')
    </body>
</html>