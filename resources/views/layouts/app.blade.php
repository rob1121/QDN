<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.header')
    {{-- CSS SECTION --}}
    {{-- @include('layouts.cssVendor') --}}
    <link rel="stylesheet" href="{{ $server }}/css/all.css">
    @yield('external-style')
    <script data-pace-options='{ "ajax": false }' src="{{ $server }}/vendor/js/pace.js"></script>
    @yield('style')
    @stack('style')
    <style>
        [v-cloak] {
            display: none;
        }
    </style>
</head>
<body  v-cloak>
{{--@include('partial.nav')--}}
<header id="nav">
    <navigationbar
        :user="{{ collect(Auth::User()->load('Employee'))->toJson() }}"
        home="{{ route('home') }}"
        issue_qdn="{{ route('issue_qdn') }}"
        current-url="{{ Request::url() }}"
        dashboard="{{ route('dashboard') }}"
        profile="{{ route('profile',['id' => $currentUser->employee->user_id]) }}"
    ></navigationbar>
</header>
<div id="wrap">
    {{-- HEADER SECTION --}}
    {{-- WE CAN PASS SECOND PARAMETER AS AN VARIABLE FOR NAV IN ARRAY FORMAT "['uri' => $uri]" --}}
    {{-- CONTENT SECTION --}}
    @yield('content')
</div>
{{-- FOOTER SECTION --}}
@include('partial.footer')
{{-- SCRIPT LOCATION --}}
{{-- @include('layouts.scriptVendor') --}}
<script src="{{ $server }}/js/all.js"></script>
<script src="{{ $server }}/js/vue-navigationbar.js"></script>
@yield('script')
@stack('scripts')
</body>
</html>