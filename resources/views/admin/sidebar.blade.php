<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left">
        <i class="fa fa-user fa-2x fa-inverse" style="padding-left:7px"></i>
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
          <li><a href="/dashboard#qdnMetrics"><i class="fa fa-circle-o"></i> QDN Metrics</a></li>
          <li><a href="/dashboard#podGraph"><i class="fa fa-circle-o"></i> Pareto of Discrepancy</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-list"></i> <span>Options</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ route('CustomerOptions') }}"><i class="fa fa-circle-o"></i> Customers</a></li>
          <li><a href="{{ route('discrepancy') }}"><i class="fa fa-circle-o"></i> Discrepancy Categories</a></li>
          <li><a href="{{ route('MachineOptions') }}"><i class="fa fa-circle-o"></i> Machines</a></li>
          <li><a href="{{ route('StationOptions') }}"><i class="fa fa-circle-o"></i> Stations</a></li>
        </ul>
      </li>
      <li>
        <a href="{{ route('EmployeesOptions') }}">
          <i class="fa fa-users"></i> <span>Employees</span>
        </a>
      </li>
      <li>
        <a href="#">
          <i class="fa fa-clock-o"></i> <span>Logs</span>
        </a>
      </li>
      <li><a href="#"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
      <li><a href="/"><i class="fa fa-home"></i> <span>Got back to home</span></a></li>
    </section>
    <!-- /.sidebar -->
  </aside>