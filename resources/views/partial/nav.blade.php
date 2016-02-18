<nav class="navbar" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="padder container">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="fa fa-bars"></span>
        </button>
        <a class="navbar-brand" href="/">
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
                    <li><a href="/">Home</a></li>
                    <li><a href="{{ route('issue_qdn') }}">Issue QDN</a></li>
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
                        @if ($currentUser->access_level == 'Admin')
                            <li><a href="/admin" style="border-bottom:1px solid #f5f5f5">Login as admin</a></li>
                        @endif
                        <li><a href="/logout"
                            onclick="return confirm('Are you sure you want to logout?')"

                        >Logout</a></li>
                    </ul>
                </li>
            @else
                {{-- MENU IF USER IS NOT LOGGED IN --}}
                <!-- <li><a href="#login" data-toggle="modal" ><i class="fa fa-sign-in"></i> Login</a></li> -->
            @endif
        </ul>
        </div>
    </div><!-- /.navbar-collapse -->
</nav>