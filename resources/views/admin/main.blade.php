<!DOCTYPE html>
<html>
    <head>
        @include('admin.header')
        @stack('styles')
        <style type="text/css">
        .content-wrapper {
            padding-right:8px;
        }

        table {
            background-color: #fff;
        }
        </style>
    </head>
    <body class="hold-transition skin-blue sidebar-mini" hidden style="padding-bottom:0px">
        <div class="wrapper">
            @include('admin.nav')
            @include('admin.sidebar')
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>
                    QDN
                    <small>Dashboard</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>
                <section class="content">
                    @yield('content')
                </section>
            </div>
            @include('admin.footer')
            <script src="/js/adminAll.js"></script>
            @stack('scripts')
            <script>
            $(function() {
            $('body').show();
            });
            </script>
        </body>
    </html>