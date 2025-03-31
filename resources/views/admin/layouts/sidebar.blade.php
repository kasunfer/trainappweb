  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="{{route('admin.dashboard')}}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->
  @if(Gate::any(['view-trains', 'view-stations', 'view-route-fee', 'view-trains-schedules', 'view-booking', 'view-ticket-verifying']))
      <li class="nav-item">
        <a class="nav-link {{ Request::is('admin/train') || Request::is('admin/train/create') || Request::is('admin/station') || Request::is('admin/station/create') 
        || Request::is('admin/route-fee') || Request::is('admin/route-fee/create') || Request::is('admin/train-schedules') || 
        Request::is('admin/train-schedules/create') || Request::is('admin/bookings/create') || Request::is('admin/bookings/create') ? 'collapsed' : '' }}" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Schedule & Settings</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse {{ Request::is('admin/train') || Request::is('admin/train/create') || Request::is('admin/station') || Request::is('admin/station/create') 
        || Request::is('admin/route-fee') || Request::is('admin/route-fee/create') || Request::is('admin/train-schedules') || 
        Request::is('admin/train-schedules/create') || Request::is('admin/bookings') || Request::is('admin/bookings/create') || 
        Request::is('admin/ticket-verify') || Request::is('admin/ticket-verify/create') ? ' show' : '' }}" data-bs-parent="#sidebar-nav">
        @can('view-trains')
        <li class="{{ Request::is('admin/train') ? 'active' : '' }}">
            <a href="{{route('train.index')}}">
              <i class="bi bi-circle"></i><span>Train List</span>
            </a>
          </li>
        @endcan
        @can('create-trains')
        <li class="{{ Request::is('admin/train/create') ? 'active' : '' }}">
            <a href="{{route('train.create')}}">
              <i class="bi bi-circle"></i><span>Add Train</span>
            </a>
          </li>
        @endcan
        @can('view-stations')
          <li class="{{ Request::is('admin/station') ? 'active' : '' }}">
            <a href="{{route('station.index')}}">
              <i class="bi bi-circle"></i><span>Station List</span>
            </a>
          </li>
        @endcan
        @can('create-stations')
          <li class="{{ Request::is('admin/station/create') ? 'active' : '' }}">
            <a href="{{route('station.create')}}">
              <i class="bi bi-circle"></i><span>Add Station</span>
            </a>
          </li>
        @endcan
        @can('view-route-fee')
          <li class="{{ Request::is('admin/route-fee') ? 'active' : '' }}">
            <a href="{{route('route-fee.index')}}">
              <i class="bi bi-circle"></i><span>Route Fee List</span>
            </a>
          </li>
        @endcan
        @can('create-route-fee')
          <li class="{{ Request::is('admin/route-fee/create') ? 'active' : '' }}">
            <a href="{{route('route-fee.create')}}">
              <i class="bi bi-circle"></i><span>Add Route Fee</span>
            </a>
          </li>
        @endcan
        @can('view-trains-schedules')
          <li class="{{ Request::is('admin/train-schedules') ? 'active' : '' }}">
            <a href="{{route('train-schedules.index')}}">
              <i class="bi bi-circle"></i><span>Train Schedules</span>
            </a>
          </li>
        @endcan
        @can('create-trains-schedules')
          <li class="{{ Request::is('admin/train-schedules/create') ? 'active' : '' }}">
            <a href="{{route('train-schedules.create')}}">
              <i class="bi bi-circle"></i><span>Add Train Schedules</span>
            </a>
          </li>
        @endcan
        @can('view-booking')
          <li class="{{ Request::is('admin/bookings') ? 'active' : '' }}">
            <a href="{{route('bookings.index')}}">
              <i class="bi bi-circle"></i><span>Bookings</span>
            </a>
          </li>
        @endcan
        @can('create-booking')
          <li class="{{ Request::is('admin/bookings/create') ? 'active' : '' }}">
            <a href="{{route('bookings.create')}}">
              <i class="bi bi-circle"></i><span>Add Bookings</span>
            </a>
          </li>
        @endcan
        @can('view-ticket-verifying')
          <li class="{{ Request::is('admin/ticket-verify') ? 'active' : '' }}">
            <a href="{{route('ticket-verify.index')}}">
              <i class="bi bi-circle"></i><span>Verify Tickets</span>
            </a>
          </li>
        @endcan
        </ul>
      </li><!-- End Components Nav -->
@endif
@if(Gate::any(['view-roles', 'create-roles']))
      <li class="nav-item">
        <a class="nav-link {{ Request::is('admin/roles') || Request::is('admin/roles/create') || Request::is('admin/roles*') ? 'collapsed' : '' }}" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Roles And Permissions</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse {{ Request::is('admin/roles') || Request::is('admin/roles/create') || Request::is('admin/roles*') ? ' show' : '' }}" data-bs-parent="#sidebar-nav">
          @can('view-roles')
        <li class="{{ Request::is('admin/roles') ? 'active' : '' }}">
            <a href="{{route('roles.index')}}">
              <i class="bi bi-circle"></i><span>Roles And Permissions</span>
            </a>
          </li>
          @endcan
          @can('create-roles')
          <li class="{{ Request::is('admin/roles/create') ? 'active' : '' }}">
            <a href="{{route('roles.create')}}">
              <i class="bi bi-circle"></i><span>Roles Create</span>
            </a>
          </li>
          @endcan
        </ul>
      </li><!-- End Forms Nav -->
@endif
@if(Gate::any(['view-user', 'create-user']))
      <li class="nav-item">
        <a class="nav-link {{ Request::is('admin/users') || Request::is('admin/users/create') ? 'collapsed' : '' }}" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Users</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse {{ Request::is('admin/users') || Request::is('admin/users/create') ? ' show' : '' }}" data-bs-parent="#sidebar-nav">
        @can('view-user')
          <li class="{{ Request::is('admin/users') ? 'active' : '' }}">
            <a href="{{route('users.index')}}">
              <i class="bi bi-circle"></i><span>Users List</span>
            </a>
          </li>
          @endcan
          @can('create-user')
          <li class="{{ Request::is('admin/users/create') ? 'active' : '' }}">
            <a href="{{route('users.create')}}">
              <i class="bi bi-circle"></i><span>User Create</span>
            </a>
          </li>
          @endcan
        </ul>
      </li><!-- End Tables Nav -->
@endif
      {{--<li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bar-chart"></i><span>Charts</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="charts-chartjs.html">
              <i class="bi bi-circle"></i><span>Chart.js</span>
            </a>
          </li>
          <li>
            <a href="charts-apexcharts.html">
              <i class="bi bi-circle"></i><span>ApexCharts</span>
            </a>
          </li>
          <li>
            <a href="charts-echarts.html">
              <i class="bi bi-circle"></i><span>ECharts</span>
            </a>
          </li>
        </ul>
      </li><!-- End Charts Nav -->--}}
      @if(Gate::any(['view-reports', 'export-reports']))
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gem"></i><span>Reports</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="icons-bootstrap.html">
              <i class="bi bi-circle"></i><span>Bootstrap Icons</span>
            </a>
          </li>
          <li>
            <a href="icons-remix.html">
              <i class="bi bi-circle"></i><span>Remix Icons</span>
            </a>
          </li>
          <li>
            <a href="icons-boxicons.html">
              <i class="bi bi-circle"></i><span>Boxicons</span>
            </a>
          </li>
        </ul>
      </li><!-- End Icons Nav -->
      @endif
{{--  <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="users-profile.html">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-faq.html">
          <i class="bi bi-question-circle"></i>
          <span>F.A.Q</span>
        </a>
      </li><!-- End F.A.Q Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-contact.html">
          <i class="bi bi-envelope"></i>
          <span>Contact</span>
        </a>
      </li><!-- End Contact Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-register.html">
          <i class="bi bi-card-list"></i>
          <span>Register</span>
        </a>
      </li><!-- End Register Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-login.html">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Login</span>
        </a>
      </li><!-- End Login Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-error-404.html">
          <i class="bi bi-dash-circle"></i>
          <span>Error 404</span>
        </a>
      </li><!-- End Error 404 Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-blank.html">
          <i class="bi bi-file-earmark"></i>
          <span>Blank</span>
        </a>
      </li>End Blank Page Nav
--}}
    </ul>

  </aside><!-- End Sidebar-->
