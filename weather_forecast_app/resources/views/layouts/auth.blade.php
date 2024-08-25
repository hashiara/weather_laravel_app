<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <body class="bg-info-subtle">
        <div class="text-center my-4">
            <img src="{{ asset('/images/logo.png') }}" class="logo">
        </div>

        @yield('form')
    </body>
</html>