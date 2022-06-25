<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
  <div class="position-sticky pt-3">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link {{Route::is('index') ? 'active' : ''}}" aria-current="page" href="{{Route("index")}}">
          <i class="fa fa-home me-1"></i>
          Overview
        </a>
      </li>
      @can("employees.view.all")
      <li class="nav-item">
        <a class="nav-link {{Route::is('employees', 'employees.employee') ? 'active' : ''}}" href="{{Route("employees")}}">
          <i class="fa fa-users me-1"></i>
          Employees
        </a>
      </li>
      @endcan
      <li class="nav-item">
        <a class="nav-link {{Route::is('reports') ? 'active' : ''}}" href="{{Route("reports")}}">
          <i class="fa fa-chart-bar me-1"></i>
          Reports
        </a>
      </li>
      @can('settings.view')
      <li class="nav-item">
        <a class="nav-link {{Route::is('settings') ? 'active' : ''}}" href="{{Route("settings")}}">
          <i class="fa fa-cogs me-1"></i>
          Settings
        </a>
      </li>
      @endcan
    </ul>

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
      <span>Recent Reports</span>
      <a class="link-secondary" href="#" aria-label="Add a new report">
        <i class="fa fa-plus-circle me-1"></i>
      </a>
    </h6>
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fa fa-file-alt me-1"></i>
          Current month
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fa fa-file-alt me-1"></i>
          Last quarter
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fa fa-file-alt me-1"></i>
          Year-end sale
        </a>
      </li>
    </ul>
  </div>
</nav>
