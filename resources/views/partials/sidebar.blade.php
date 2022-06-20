<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
  <div class="position-sticky pt-3">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link {{Route::is('index') ? 'active' : ''}}" aria-current="page" href="{{Route("index")}}">
          <span data-feather="index" class="align-text-bottom"></span>
          Overview
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{Route::is('employees', 'employees.employee') ? 'active' : ''}}" href="{{Route("employees")}}">
          <span data-feather="users" class="align-text-bottom"></span>
          Employees
        </a>
      </li>
      @if (isset($employees) && count($employees) > 0)
      <li class="nav-item">
        <a class="nav-link {{Route::is('reports') ? 'active' : ''}}" href="{{Route("reports")}}">
          <span data-feather="bar-chart-2" class="align-text-bottom"></span>
          Reports
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{Route::is('integrations') ? 'active' : ''}}" href="{{Route("integrations")}}">
          <span data-feather="layers" class="align-text-bottom"></span>
          Integrations
        </a>
      </li>
      @endif
      <li class="nav-item">
        <a class="nav-link {{Route::is('settings') ? 'active' : ''}}" href="{{Route("settings")}}">
          <span data-feather="settings" class="align-text-bottom"></span>
          Settings
        </a>
      </li>
    </ul>

    @if (isset($employees) && count($employees) > 0)
    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
      <span>Recent Reports</span>
      <a class="link-secondary" href="#" aria-label="Add a new report">
        <span data-feather="plus-circle" class="align-text-bottom"></span>
      </a>
    </h6>
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link" href="#">
          <span data-feather="file-text" class="align-text-bottom"></span>
          Current month
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <span data-feather="file-text" class="align-text-bottom"></span>
          Last quarter
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <span data-feather="file-text" class="align-text-bottom"></span>
          Year-end sale
        </a>
      </li>
    </ul>
    @endif
  </div>
</nav>
