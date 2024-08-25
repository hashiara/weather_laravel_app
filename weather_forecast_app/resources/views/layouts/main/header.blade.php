<header class="row text-center bg-white opacity-75 align-items-center position-relative z-2">
    <div class="col header-logo">
        <a href="{{ route('main.index', ['title' => 'weather']) }}">
            <img src="{{ asset('/images/logo.png') }}">
        </a>
    </div>

    @yield('headerTitle')

    <button id="hamburger" class="btn col" type="button"
        data-toggle="collapse"
        data-target=".hamburger-content"
        aria-expanded="false"
        aria-controls="hamburger1 hamburger2 hamburger3 hamburger4">
        <img id="hamburgerIcon" src="{{ asset('/images/hamburger.png') }}" />
        <img id="hamburgerIcon2" src="{{ asset('/images/hamburger2.png') }}" hidden />
    </button>
    
    @if($title === 'weather')
        @include('layouts.main.weatherModal')
    @elseif($title === 'horoscope')
        @include('layouts.main.horoscopeModal')
    @elseif($title === 'trainStatus')
        @include('layouts.main.trainStatusModal')
    @else
        @include('layouts.main.weatherModal')
    @endif
</header>