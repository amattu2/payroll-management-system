<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
  <h1 class="h2">Overview</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
    <button type="button" class="btn btn-sm btn-outline-secondary me-2 dropdown-toggle">
      <span data-feather="calendar" class="align-text-bottom"></span>
      This week
    </button>
    <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
  </div>
</div>

<div class="row">
  @for ($i = 0; $i < 4; $i++)
  <div class="col-xl-3 col-lg-6 mb-3">
    <div class="card p-3">
      <div class="card-icon card-icon-large">
        <i class="fas fa-shopping-cart"></i>
      </div>
      <div class="mb-4 mt-2">
          <h5 class="card-title mb-0">{statistic}</h5>
      </div>
      <div class="row align-items-center mb-2 d-flex">
          <div class="col-8">
              <h2 class="d-flex align-items-center mb-0">3,243</h2>
          </div>
          <div class="col-4 text-right">
            <span>12.5% <i class="fa fa-arrow-up"></i></span>
          </div>
      </div>
      <div class="progress mt-2" data-height="8" style="height: 8px;">
        <div class="progress-bar" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
      </div>
    </div>
  </div>
  @endfor
</div>

<div class="card p-3 mb-3">
  <canvas class="w-100" id="overviewChart" width="900" height="380"></canvas>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
  <h1 class="h2">Employees</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
    <a class="btn btn-sm btn-outline-secondary" href="{{Route("employees.employee", "create")}}">Create</a>
  </div>
</div>

@include("partials.employeeTable", ["employees" => $employees])
