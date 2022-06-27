<!DOCTYPE html>
<html class="h-100" lang="EN">

<head>
  <title>{{ config('app.name') }}</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="h-100 w-100">
  @include('partials.navbar')

  <div class="container-fluid">
    @include('partials.sidebar')

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3">
      @include('partials.errors')

      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ Route('index') }}">Overview</a></li>
            <li class="breadcrumb-item"><a href="{{ Route('employees') }}">Employees</a></li>
            <li class="breadcrumb-item"><a
                href="{{ Route('employees.employee', $employee->id) }}">{{ $employee->firstname }}
                {{ $employee->lastname }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $timesheet->period->format('F Y') }} Timesheet
            </li>
          </ol>
        </nav>
        <div class="btn-toolbar">
          <select class="form-control" id="employee-selector">
            @foreach ($employees as $e)
              <option data-href="{{ Route('employees.employee.timesheet', $e->id) }}"
                {{ $e->id === $employee->id ? 'selected' : '' }}>
                {{ $e->firstname }} {{ $e->lastname }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block bg-body">
          <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mb-1 text-uppercase">
            <span>Timesheet History</span>
          </h6>
          <ul class="nav flex-column mb-2">
            @foreach ($employee->timesheets as $ts)
              <li class="nav-item">
                @if ($ts->period != $timesheet->period)
                  <a class="nav-link"
                    href="{{ Route('employees.employee.timesheet', $employee->id) }}/{{ $ts->period->format('Y') }}/{{ $ts->period->format('m') }}">
                    <i class="far {{ $ts->completed_at ? 'fa-calendar-check' : 'fa-calendar' }} me-1"></i>
                    {{ $ts->period->format('F, Y') }}
                  </a>
                @else
                  <a class="nav-link active">
                    <i class="far {{ $ts->completed_at ? 'fa-calendar-check' : 'fa-calendar' }} me-1"></i>
                    {{ $ts->period->format('F, Y') }}
                  </a>
                @endif
              </li>
            @endforeach
          </ul>

          <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-3 mb-1 text-uppercase">
            <span>This Pay Period</span>
          </h6>
          <ul class="nav flex-column mb-2">
            @foreach ($timesheet->weeks as $week)
              <li class="nav-item">
                <a class="nav-link text-muted" href="#week{{ $week['index'] }}">
                  <i class="far fa-dot-circle"></i>
                  {{ $week['start']->format('M jS') }} &ndash; {{ $week['end']->format('M jS') }}
                </a>
              </li>
            @endforeach
          </ul>
        </nav>
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          @if (!$timesheet->id)
            <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
              <h4 class="alert-heading">Timesheet Does Not Exist</h4>
              <p>The timesheet for the {{ $timesheet->period->format('F, Y') }} pay period does not exist yet. Press
                create <a href="#timesheetControls">below</a> to create it.</p>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          <div class="btn-toolbar justify-content-between">
            <div class="btn-group" role="group">
              @php
                $prevMonth = (clone $timesheet->period)->sub(new DateInterval('P1M'));
                $nextMonth = (clone $timesheet->period)->add(new DateInterval('P1M'));
              @endphp
              <a role="button" class="btn btn-outline-secondary"
                href="{{ Route('employees.employee.timesheet', $employee->id) }}/{{ $prevMonth->format('Y') }}/{{ $prevMonth->format('m') }}">Back</a>
              <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  {{ $timesheet->period->format('F, Y') }}
                </button>
                @if (count($employee->timesheets) > 0)
                  <ul class="dropdown-menu">
                    @foreach ($employee->timesheets as $ts)
                      @if ($ts->id === $timesheet->id)
                        @continue
                      @endif
                      <li>
                        <a class="dropdown-item"
                          href="{{ Route('employees.employee.timesheet', $employee->id) }}/{{ $ts->period->format('Y') }}/{{ $ts->period->format('m') }}">
                          {{ $ts->period->format('F, Y') }}
                        </a>
                      </li>
                    @endforeach
                  </ul>
                @endif
              </div>
              <a role="button" class="btn btn-outline-secondary"
                href="{{ Route('employees.employee.timesheet', $employee->id) }}/{{ $nextMonth->format('Y') }}/{{ $nextMonth->format('m') }}">Next</a>
            </div>
            @if ($timesheet->period->format('mY') !== date('mY'))
              <a role="button" class="btn btn-outline-primary ms-2"
                href="{{ Route('employees.employee.timesheet', $employee->id) }}/{{ date('Y') }}/{{ date('m') }}">Current</a>
            @endif
            <div class="d-flex ms-auto">
              @if ($timesheet->id)
                <button class="btn btn-primary me-2" type="button">Export</button>
                <button class="btn btn-primary" type="button">Period Settings</button>
              @endif
            </div>
          </div>

          @foreach ($timesheet->weeks as $week)
            <div class="card shadow-sm mt-3" id="week{{ $week['index'] }}">
              <div class="card-header">
                Week #{{ $week['index'] + 1 }}
                ({{ $week['start']->format('M jS') }} &ndash; {{ $week['end']->format('M jS') }})
              </div>
              <div class="card-body">
                <div class="row text-center fw-bold">
                  <div class="col-1">Day</div>
                  <div class="col-4">Work Description</div>
                  <div class="col-2">Time In</div>
                  <div class="col-2">Time Out</div>
                  <div class="col-2">Adjustment (minutes)</div>
                  <div class="col-1">Total</div>
                </div>
                @foreach ($week['days'] as $i => $day)
                  <div class="row py-3 text-center {{ $i % 2 !== 0 ? 'bg-body' : '' }}"
                    data-units="{{ $timesheet->pay_type === 'hourly' ? 'hours' : 'days' }}">
                    <div class="col-1">
                      {{ $day->format('jS (D)') }}
                    </div>
                    <div class="col-4">
                      <div class="input-group">
                        <button type="button" class="btn btn-outline-secondary dropdown-toggle"
                          data-bs-toggle="dropdown">
                          <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" role="button" onclick="addWorkDescription(this);">Sick</a></li>
                          <li><a class="dropdown-item" role="button" onclick="addWorkDescription(this);">Called
                              Out</a></li>
                          <li><a class="dropdown-item" role="button" onclick="addWorkDescription(this);">Approved
                              Time-Off</a></li>
                        </ul>
                        <textarea class="form-control" rows="1"></textarea>
                      </div>
                    </div>
                    <div class="col-2">
                      <input type="time" name="start_time" class="form-control" value="07:00"
                        onblur="calculateDayUnits(this);" />
                    </div>
                    <div class="col-2">
                      <input type="time" name="end_time" class="form-control" value="17:00"
                        onblur="calculateDayUnits(this);" />
                    </div>
                    <div class="col-2">
                      <div class="input-group">
                        <span class="input-group-text">
                          <i class="fas fa-clock"></i>
                        </span>
                        <input type="number" name="adjustment" class="form-control" value="0" step="15"
                          min="-1440" max="1440" onblur="calculateDayUnits(this.parentElement);"
                          @disabled($timesheet->pay_type !== 'hourly') />
                      </div>
                    </div>
                    <div class="col-1">
                      <span data-day-sum>N/A</span>
                    </div>
                  </div>
                @endforeach
                <div class="row text-center border-top fw-bold pt-3">
                  <div class="col-1">Totals</div>
                  <div class="col-10"></div>
                  <div class="col-1" data-period-sum>N/A</div>
                </div>
              </div>
            </div>
          @endforeach

          <div class="button-group my-3 d-flex" id="timesheetControls">
            <button class="btn btn-primary me-auto" type="button"
              @disabled($employee->employment_status !== 'active')>{{ !$timesheet->id ? 'Create' : 'Save' }}</button>
            <a class="text-danger" role="button">Cancel</button>
          </div>
        </div>
      </div>
    </main>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}"></script>
  <script>
    document.querySelector("#employee-selector").onchange = (e) => {
      window.location.href = e.target.querySelector("option:checked").dataset.href;
    };
  </script>
</body>

</html>
