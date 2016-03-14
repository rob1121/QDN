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
            <span class="fa-stack fa-lg" style="margin: -12px 0px -12px 0px">
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