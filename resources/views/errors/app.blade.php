<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layouts.header')
        {{-- CSS SECTION --}}
        <link rel="stylesheet" href="/css/all.css">
        <style>
            body {
                overflow-y:hidden;
            }
        </style>
        @yield('style')
    </head>
    <body>
            @yield('content')
    </body>
</html>
