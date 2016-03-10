<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>QDN</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="/css/adminAll.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        @stack('styles')
    </head>
    <body class="hold-transition skin-blue sidebar-mini" hidden>
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="index2.html" class="logo">
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>QDN</b></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <span class="fa-stack fa-lg" style="padding: 0px;margin-top:-12px;margin-bottom:-12px">
                                        <i class="fa fa-circle fa-stack-2x"></i>
                                        <i class="fa fa-user fa-stack-1x fa-inverse"></i>
                                    </span>
                                    <span class="hidden-xs">{{ $currentUser->employee->name }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <span class="fa-stack fa-4x">
                                            <i class="fa fa-circle fa-stack-2x" ></i>
                                            <i class="fa fa-user fa-stack-1x fa-inverse"></i>
                                        </span>
                                        <p>
                                            {{ $currentUser->employee->name }}
                                            <small>{{ $currentUser->employee->position }}</small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="{{ route('profile',['id'=>$currentUser->employee_id]) }}" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="/logout" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!-- Control Sidebar Toggle Button -->
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left">
                            <i class="fa fa-user fa-2x fa-inverse" style="margin-left: 7px"></i>
                        </div>
                        <div class="pull-left info">
                            <p>{{ $currentUser->employee->name }}</p>
                        </div>
                        <br>
                        <br>
                    </div>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="header">MAIN NAVIGATION</li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-bar-chart"></i> <span>Charts</span> <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{ route('QdnMetrics') }}"><i class="fa fa-circle-o"></i> QDN Metrics</a></li>
                                <li><a href="{{ route('ParetoOfDiscrepancy') }}"><i class="fa fa-circle-o"></i> Per Discrepancy</a></li>
                                <li class="active"><a href="{{ route('ParetoPerFailureMode') }}"><i class="fa fa-circle-o"></i> Per Failure Mode</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-list"></i> <span>Options</span> <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="active"><a href="{{ route('MachineOptions') }}"><i class="fa fa-circle-o"></i> Machines</a></li>
                                <li><a href="{{ route('FailureModeOptions') }}"><i class="fa fa-circle-o"></i> Failure Mode</a></li>
                                <li><a href="{{ route('DiscrepancyCategoryOptions') }}"><i class="fa fa-circle-o"></i> Discrepancy</a></li>
                                <li><a href="{{ route('CustomerOptions') }}"><i class="fa fa-circle-o"></i> Customers</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="pages/widgets.html">
                                <i class="fa fa-users"></i> <span>Employees</span>
                            </a>
                        </li>
                        <li>
                            <a href="pages/widgets.html">
                                <i class="fa fa-clock-o"></i> <span>Logs</span>
                            </a>
                        </li>
                        <li><a href="documentation/index.html"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
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
                <!-- Main content -->
                <section class="content">
                    @yield('content')
                    </section><!-- /.content -->
                    </div><!-- /.content-wrapper -->
                    <footer class="main-footer">
                        <div class="pull-right hidden-xs">
                        </div>
                        <strong>Copyright &copy; {{ date('Y') }} Telford Svc. Phils., Inc.</strong> All rights reserved.
                    </footer>
                    <script src="/js/adminAll.js"></script>
                    @stack('scripts')
                    <script>
                    $(function() {
                    $('body').fadeIn();
                    });
                    </script>
                </body>
            </html>