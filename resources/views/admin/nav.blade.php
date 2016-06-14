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
            <img src="/uploads/avatar/{{ user()->avatar }}" alt="profile" style="border-radius:50%;width:30px;height:30px;float:left;margin-right:10px">
            <span class="hidden-xs">{{ user()->employee->name }}</span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <img src="/uploads/avatar/{{ user()->avatar }}" alt="profile" style="border-radius:50%;width:100px;height:100px">
              <p>
                {{ user()->employee->name }}
                <small>{{ user()->employee->position }}</small>
              </p>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="{{ route('profile',['id'=>user()->employee_id]) }}" class="btn btn-default btn-flat">Profile</a>
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