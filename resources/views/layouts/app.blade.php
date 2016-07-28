<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.header')
    {{-- CSS SECTION --}}
    {{-- @include('layouts.cssVendor') --}}
    <link rel="stylesheet" href="/css/all.css">
    @yield('external-style')
    <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
    <script data-pace-options='{ "ajax": false }' src="/vendor/js/pace.js"></script>
    @yield('style')
    @stack('style')
    <style>
        @media only screen and (min-width: 768px) {
            /* Make Navigation Toggle on Desktop Hover */
            .dropdown:hover .dropdown-menu {
                display: block;
            }
        }


        .reveal-top {
            position: relative;
            animation-name: slideUpAndFadeIn;
            animation-duration: .7s;
        }

        #wrap {
            margin-top: 10%;
            height: 100vh;
        }

        @keyframes slideUpAndFadeIn {
            from {
                opacity:0;
                top: 100px;
            }

            to {
                opacity:1;
                top: 0px;
            }

        }

        html, body {
            background-image: url('/img/background-imager/Elegant_Background-7.jpg');
        }
    </style>
</head>
<body>
{{--@include('partial.nav')--}}
<header id="nav">
    <navigationbar
        :user="{{ collect(Auth::User()->load('Employee'))->toJson() }}"
        home="{{ route('home') }}"
        issue_qdn="{{ route('issue_qdn') }}"
        current-url="{{ Request::url() }}"
    ></navigationbar>
</header>
<div id="wrap" hidden>
    {{-- HEADER SECTION --}}
    {{-- WE CAN PASS SECOND PARAMETER AS AN VARIABLE FOR NAV IN ARRAY FORMAT "['uri' => $uri]" --}}
    {{-- CONTENT SECTION --}}
    @yield('content')
</div>
{{-- FOOTER SECTION --}}
@include('partial.footer')
{{-- SCRIPT LOCATION --}}
{{-- @include('layouts.scriptVendor') --}}
<script src="/js/all.js"></script>
<script src="/vendor/js/wow.js"></script>
<script src="/js/app.js"></script>
<script src="/js/vue-navigationbar.js"></script>
@yield('script')
@stack('scripts')
<script>
    $(function () {
        $('#wrap').fadeIn();
        $('#footer').fadeIn();
        var wow = new WOW(
                {
                    boxClass:     'wow-reveal',      // default
                    animateClass: 'reveal-top', // default
                    offset:       200,          // default
                    mobile:       true,       // default
                    live:         true        // default
                }
        );
        wow.init();


    });
</script>
</body>
</html>