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
            <li class="breadcrumb-item active" aria-current="page">Timesheet</li>
          </ol>
        </nav>
        <div class="btn-toolbar">
          <select class="form-control" id="employee-selector">
            @foreach ($employees as $e)
              <option data-href="{{ Route('employees.timesheet', $e->id) }}"
                {{ $e->id === $employee->id ? 'selected' : '' }}>
                {{ $e->firstname }} {{ $e->lastname }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block bg-body">
          <h6
            class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
            <span>Timesheet History</span>
          </h6>
          <ul class="nav flex-column mb-2">
            <li class="nav-item">
              @php
                $nextMonth = (clone $date)->add(new DateInterval('P1M'));
              @endphp
              <a class="nav-link text-muted"
                href="{{ Route('employees.timesheet', $employee->id) }}/{{ $nextMonth->format('Y') }}/{{ $nextMonth->format('m') }}">
                {{ $nextMonth->format('F, Y') }}
              </a>
            </li>
            @foreach ($employee->timesheets as $timesheet)
              @php
                $tsDate = new DateTime($timesheet->period);
                $isCurrent = $date == $tsDate;
              @endphp
              <li class="nav-item">
                <a class="nav-link {{ $isCurrent ? 'active' : '' }}"
                  href="{{ Route('employees.timesheet', $employee->id) }}/{{ $tsDate->format('Y') }}/{{ $tsDate->format('m') }}">
                  {{ $tsDate->format('F, Y') }}
                </a>
              </li>
            @endforeach
          </ul>
        </nav>
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <div class="btn-toolbar justify-content-between">
            <div class="btn-group" role="group">
              @php
                $prevMonth = (clone $date)->sub(new DateInterval('P1M'));
                $nextMonth = (clone $date)->add(new DateInterval('P1M'));
              @endphp
              <a role="button" class="btn btn-outline-secondary"
                href="{{ Route('employees.timesheet', $employee->id) }}/{{ $prevMonth->format('Y') }}/{{ $prevMonth->format('m') }}">Back</a>
              <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  {{ $date->format('F, Y') }}
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#">Dropdown link</a></li>
                  <li><a class="dropdown-item" href="#">Dropdown link</a></li>
                </ul>
              </div>
              <a role="button" class="btn btn-outline-secondary"
                href="{{ Route('employees.timesheet', $employee->id) }}/{{ $nextMonth->format('Y') }}/{{ $nextMonth->format('m') }}">Next</a>
            </div>
            <div class="d-flex ms-auto">
              <button class="btn btn-primary me-2" type="button">Export</button>
              <button class="btn btn-primary" type="button">Period Settings</button>
            </div>
          </div>

          @foreach ($weeks as $week)
            <div class="card shadow-sm mt-3">
              <div class="card-header">
                Week #{{ $week['index'] + 1 }}
                ({{ $week['start']->format('M jS') }} &ndash; {{ $week['end']->format('M jS') }})
              </div>
              <div class="card-body">
                <div class="row text-center fw-bold">
                  <div class="col-1">Day</div>
                  <div class="col-3">Work Description</div>
                  <div class="col-2">Time In</div>
                  <div class="col-2">Time Out</div>
                  <div class="col-1">Adjustment</div>
                  <div class="col-2"></div>
                  <div class="col-1">Total</div>
                </div>
                @foreach ($week['days'] as $i => $day)
                  <div class="row py-3 text-center {{ $i % 2 !== 0 ? 'bg-body' : '' }}">
                    <div class="col-1">
                      {{ $day->format('jS (D)') }}
                    </div>
                    <div class="col-3">
                      <textarea class="form-control" rows="1"></textarea>
                    </div>
                    <div class="col-2">
                      <input type="time" class="form-control" value="" />
                    </div>
                    <div class="col-2">
                      <input type="time" class="form-control" value="" />
                    </div>
                    <div class="col-1">
                      <input type="number" class="form-control" value="0" min="-24" max="24" />
                    </div>
                    <div class="col-2"></div>
                    <div class="col-1">
                      {{ $employee->pay_type === 'hourly' ? '4 hours' : '1 day' }}
                    </div>
                  </div>
                @endforeach
                <div class="row text-center border-top fw-bold pt-3">
                  <div class="col-1">Totals</div>
                  <div class="col-10"></div>
                  <div class="col-1">6 days</div>
                </div>
              </div>
            </div>
          @endforeach

          <div class="button-group my-3 d-flex">
            <button class="btn btn-primary me-auto" type="button"
              {{ $employee->employment_status !== 'active' ? 'disabled' : '' }}>Save</button>
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
