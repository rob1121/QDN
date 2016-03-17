<?php
$url = Request::url();
?>
<nav class="navbar" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="padder container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="fa fa-bars"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}">
                <span class="logo">
                    Q D N
                    <p class="subtitle">Quality Deviation Notice</p>
                </span>
            </a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            @if ($currentUser)
            <ul class="nav navbar-nav navbar-left">
                {{-- MENU IF USER IS LOGGED IN --}}
                <li
                    @if ($url == route('home') || $url == route('pareto'))
                    class="active"
                    @<?php endif ?>><a href="{{ route('home') }}">Home</a>
                </li>
                <li
                    @if ($url === route('issue_qdn'))
                    class="active"
                    @endif
                    ><a href="{{ route('issue_qdn') }}">Issue QDN</a>
                </li>
                <li
                    @if ($url === route('issue_qdn'))
                    class="active"
                    @endif
                    ><a href="{{ route('issue_qdn') }}">Documentation</a>
                </li>
            </ul>
            @endif
            <ul class="nav navbar-nav navbar-right">
                @if ($currentUser)
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" onclick="return false">
                        <span class="fa-stack fa-lg" style="float:left;bottom:8px">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-user fa-stack-1x fa-inverse"></i>
                        </span> {{ $currentUser->employee->name }} <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            @if ($currentUser->access_level == 'admin')
                            <li><a href="{{ route('dashboard') }}" style="border-bottom:1px solid #f5f5f5"><i class="fa fa-dashboard"></i> dashboard</a></li>
                            @endif
                            <li>
                                <a data-toggle="modal" href='{{ route('profile',['id' => $currentUser->employee->user_id]) }}'>
                                    <i class="fa fa-user"></i> Profile
                                </a>
                            </li>
                            <li><a data-toggle="modal" href='#sig-out'><i class="fa fa-sign-out"></i> Logout</a></li>
                        </ul>
                    </li>
                    @else
                    <li class="text-center footer-logo h1">TELFORD</li>
                    {{-- MENU IF USER IS NOT LOGGED IN --}}
                    <!-- <li><a href="#login" data-toggle="modal" ><i class="fa fa-sign-in"></i> Login</a></li> -->
                    @endif
                </ul>
            </div>
            </div><!-- /.navbar-collapse -->
        </nav>
        <div class="modal" id="sig-out">
            <div class="modal-dialog">
                <div class="modal-content text-center" style="padding:32px 0px 32px 0px;">
                    <div class="col-md-12" style="margin-bottom:24px"><em class="lead">Are you sure you want to sign out?</em></div>
                    <a type="button" class="btn btn-default" data-dismiss="modal">No</a>
                    <a class="btn btn-primary" href="/logout">Yes</a>
                </div>
            </div>
        </div>