<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layouts.header')
        {{-- CSS SECTION --}}
        @include('layouts.cssVendor')
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
