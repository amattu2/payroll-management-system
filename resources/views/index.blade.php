<!DOCTYPE html>
<html lang="EN">

<head>
  <title>{{ config('app.name') }}</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
  @include('partials.navbar')

  <div class="container-fluid">
    @include('partials.sidebar')

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3">
      @include('partials.errors')

      @if (!isset($employees) || count($employees) == 0)
        <div class="h-100 p-5 text-white bg-dark rounded-3">
          <h2>{{ trans('messages.welcome.to.app', ['name' => config('app.name')]) }}</h2>
          <p>{{ __('messages.no.employees') }}</p>
          <a href="{{ Route('employees.employee', 'create') }}">
            <button class="btn btn-outline-light" type="button">Create Employee</button>
          </a>
        </div>
      @else
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
          @if (1 == 1)
            <!-- Closure Notice -->
            <div class="p-4 text-white bg-danger rounded-3 mb-3 shadow-sm">
              <h3>Upcoming Closure</h3>
              <p>Effective starting <b>{{ (new DateTime('tomorrow'))->format('M jS') }}</b> thru
                <b>{{ (new DateTime('tomorrow'))->add(new DateInterval('P14D'))->format('M jS') }}</b>, a company-wide
                closure is in effect.
              </p>
            </div>
          @endif

          <div class="col-xl-8">
            <!-- Statistic Cards -->
            <div class="row" style="margin-left: -1.5rem; margin-right: -1.5rem;">
              @for ($i = 0; $i < 4; $i++)
                <div class="col-xl-3 col-lg-6 mb-3">
                  <div class="card p-3 shadow-sm">
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
                      <div class="progress-bar" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"
                        style="width: 25%;"></div>
                    </div>
                  </div>
                </div>
              @endfor
            </div>

            <!-- Graph -->
            <div class="row">
              <div class="card p-3 mb-3 shadow-sm">
                <h6 class="border-bottom pb-2 mb-0">Employee Activity</h6>
                <canvas class="w-100" id="overviewChart" width="900" height="380"></canvas>
              </div>
            </div>

            <!-- Employees -->
            @can('employees.view.all')
              <div class="row">
                <div class="card p-3 mb-3 shadow-sm">
                  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h6>Employees</h6>
                    @canany(['employees.create', 'employees.update', 'employees.delete'])
                      <div class="btn-toolbar mb-2 mb-md-0">
                        <a class="btn btn-sm btn-outline-secondary me-2" href="{{ Route('employees') }}">Manage</a>
                        <a class="btn btn-sm btn-outline-secondary" href="{{ Route('employees.employee', 'create') }}">Create</a>
                      </div>
                    @endcanany
                  </div>

                  @include('partials.employeeTable', ['employment_status' => 'active'])
                </div>
              </div>
            @endcan
          </div>

          <!-- Sidebar Content -->
          <div class="col-xl-4">
            <!-- Pending Requests -->
            @if ($openLeaves->count() > 0)
              @foreach ($openLeaves as $leave)
                <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
                  <b>{{ $leave->employee->firstname }} {{ $leave->employee->lastname }}</b> has a pending time-off
                  request from {{ $leave->created_at->format('m/d') }}
                  <a href="{{ Route('leaves.leave', ['id' => $leave->employee->id, 'leaveId' => $leave->id]) }}" class="ms-1">View</a>
                  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
              @endforeach
            @endif

            <!-- Time Off -->
            @if ($upcomingLeaves->count() > 0)
              <div class="card p-3 mb-3 shadow-sm">
                <h6 class="border-bottom pb-2 mb-0">Upcoming Time-Off</h6>
                @foreach ($upcomingLeaves as $leave)
                  <div class="d-flex text-muted pt-3">
                    @include('partials.avatar', ["classes" => "me-2", "e" => $leave->employee])
                    <div class="mb-0 small lh-sm w-100 {{ $i < 0 ? 'pb-3 border-bottom' : '' }}">
                      <div class="d-flex justify-content-between">
                        <strong class="text-gray-dark">{{ $leave->employee->firstname }}
                          {{ $leave->employee->lastname }} </strong>
                        <a href="{{ Route('leaves.leave', ['id' => $leave->employee->id, 'leaveId' => $leave->id]) }}">View</a>
                      </div>
                      <span class="d-flex align-items-center">
                        {{ $leave->start_date->format('M jS') }} &ndash; {{ $leave->end_date->format('M jS') }}
                        <div class="badge bg-primary ms-1">
                          {{ $leave->start_date->diff($leave->end_date)->format('%a') }} days</div>
                      </span>
                    </div>
                  </div>
                @endforeach
              </div>
            @endif

            <!-- Overdue Time Sheets -->
            <div class="card p-3 mb-3 shadow-sm">
              <h6 class="border-bottom pb-2 mb-0">Overdue Timesheets</h6>
              @for ($i = 0; $i < 4; $i++)
                <div class="d-flex text-muted pt-3">
                  @include('partials.avatar', ['classes' => 'me-2', 'e' => $employees[$i]])
                  <div class="mb-0 small lh-sm w-100 {{ $i < 3 ? 'pb-3 border-bottom' : '' }}">
                    <div class="d-flex justify-content-between">
                      <strong class="text-gray-dark">{employee name}</strong>
                      <a href="#">Timesheet</a>
                    </div>
                    <span class="d-block">Overdue for 2 days</span>
                  </div>
                </div>
              @endfor
            </div>
          </div>
        </div>
      @endif
    </main>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}"></script>
  <script>
    new Chart(document.getElementById('overviewChart'), {
      type: 'bar',
      data: {
        labels: [
          'Sunday',
          'Monday',
          'Tuesday',
          'Wednesday',
          'Thursday',
          'Friday',
          'Saturday'
        ],
        datasets: [{
            label: "John Doe",
            data: [
              3,
              4,
              8,
              4,
              11,
              9,
              12
            ],
            lineTension: 0,
            backgroundColor: '#0d6efd'
          },
          {
            label: "Bob Smith",
            data: [
              8,
              9,
              6,
              0,
              9,
              8,
              5
            ],
            lineTension: 0,
            backgroundColor: '#6610f2'
          }
        ],
        options: {
          scales: {
            x: {
              stacked: true
            },
            y: {
              stacked: true
            }
          }
        }
      }
    });
  </script>
</body>

</html>
