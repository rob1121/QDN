<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layouts.header')
        {{-- CSS SECTION --}}
        {{-- @include('layouts.cssVendor') --}}
        <link rel="stylesheet" href="/css/all.css">
        @yield('external-style')
        <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
        <script  data-pace-options='{ "ajax": false }' src="/vendor/js/pace.js"></script>
        {{-- <script src="/js/vendor/pace.js"></script> --}}
        @yield('style')
    </head>
    <body hidden>
        <div id="wrap">
            {{-- HEADER SECTION --}}
            @include('partial.nav')
            {{-- WE CAN PASS SECOND PARAMETER AS AN VARIABLE FOR NAV IN ARRAY FORMAT "['uri' => $uri]" --}}
            {{-- CONTENT SECTION --}}
            @yield('content')
        </div>
        {{-- FOOTER SECTION --}}
        @include('partial.footer')
        {{-- SCRIPT LOCATION --}}
        {{-- @include('layouts.scriptVendor') --}}
        <script src="/js/all.js"></script>
        <script src="/js/app.js"></script>
        <script>
        $(function() {
            $('body').show();
        });
        </script>
        @yield('script')
    </body>
</html>
