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
      @include('partials.status')

      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ Route('index') }}">Overview</a></li>
            <li class="breadcrumb-item"><a href="{{ Route('employees') }}">Employees</a></li>
            <li class="breadcrumb-item"><a href="{{ Route('employees.employee', $employee->id) }}">{{ $employee->firstname }}
                {{ $employee->lastname }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $timesheet->period->format('F Y') }} Timesheet
            </li>
          </ol>
        </nav>
        <div class="btn-toolbar">
          <select class="form-control" id="employee-selector">
            @foreach ($employees as $e)
              <option data-href="{{ Route('employee.timesheet', $e->id) }}" {{ $e->id === $employee->id ? 'selected' : '' }}>
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
                  <a class="nav-link" href="{{ Route('employee.timesheet', $employee->id) }}/{{ $ts->period->format('Y') }}/{{ $ts->period->format('m') }}">
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
              <h4 class="alert-heading">Unsaved Timesheet</h4>
              <p>
                {{ __('messages.timesheet.unsaved', ['period' => $timesheet->period->format('F, Y')]) }}
                Press create <a href="#timesheetControls">below</a> to create it.</p>
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
                href="{{ Route('employee.timesheet', $employee->id) }}/{{ $prevMonth->format('Y') }}/{{ $prevMonth->format('m') }}">Back</a>
              <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
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
                          href="{{ Route('employee.timesheet', $employee->id) }}/{{ $ts->period->format('Y') }}/{{ $ts->period->format('m') }}">
                          {{ $ts->period->format('F, Y') }}
                        </a>
                      </li>
                    @endforeach
                  </ul>
                @endif
              </div>
              <a role="button" class="btn btn-outline-secondary"
                href="{{ Route('employee.timesheet', $employee->id) }}/{{ $nextMonth->format('Y') }}/{{ $nextMonth->format('m') }}">Next</a>
            </div>
            @if ($timesheet->period->format('mY') !== date('mY'))
              <a role="button" class="btn btn-outline-primary ms-2"
                href="{{ Route('employee.timesheet', $employee->id) }}/{{ date('Y') }}/{{ date('m') }}">Current</a>
            @endif
            <div class="d-flex ms-auto">
              @if ($timesheet->id)
                <div class="btn-group" role="group">
                  <button type="button" class="btn btn-primary me-2 dropdown-toggle" data-bs-toggle="dropdown">Export</button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" target="_blank"
                        href="{{ Route('timesheet.export', ['id' => $employee->id, 'year' => $timesheet->year, 'month' => $timesheet->month]) }}">
                        PDF
                      </a></li>
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#emailTimesheetModal">Email</a></li>
                  </ul>
                </div>
                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#periodSettingsModal">Period Settings</button>
              @endif
            </div>
          </div>

          <form action="{{ Route('timesheet.update', ['id' => $employee->id, 'year' => $timesheet->year, 'month' => $timesheet->month]) }}" method="POST"
            id="timesheetUpdateForm">
            @csrf
            @foreach ($timesheet->weeks as $wi => $week)
              <div class="card shadow-sm mt-3" id="week{{ $week['index'] }}">
                <a class="card-header text-decoration-none bg-white" data-bs-toggle="collapse" href="#weekBody{{ $wi }}" role="button">
                  Week #{{ $week['index'] + 1 }}
                  ({{ $week['start']->format('M jS') }} &ndash; {{ $week['end']->format('M jS') }})
                </a>
                <div class="card-body collapse show" id="weekBody{{ $wi }}">
                  <div class="row text-center fw-bold">
                    <div class="col-1">Day</div>
                    <div class="col-4">Work Description</div>
                    <div class="col-2">Time In</div>
                    <div class="col-2">Time Out</div>
                    @if ($timesheet->pay_type === 'hourly')
                      <div class="col-2" data-bs-toggle="tooltip" title="{{ __('messages.timesheet.adjustment') }}">Adjustment (minutes)</div>
                    @else
                      <div class="col-2">Units (days)</div>
                    @endif
                    <div class="col-1">Total</div>
                  </div>
                  @foreach ($week['days'] as $wdi => $day)
                    <div class="row py-3 text-center {{ $wdi % 2 !== 0 ? 'bg-body' : '' }}" id="week{{ $wi }}day{{ $wdi }}">
                      <div class="col-1">
                        <input type="hidden" name="days[{{ $day['day']->date->format('Y-m-d') }}][id]" value="{{ $day['day']->id }}" />
                        {{ $day['day']->date->format('jS (D)') }}
                        @if ($day['leave'])
                          <a role="button" href="{{ Route('leaves.leave', ['id' => $employee->id, 'leaveId' => $day['leave']->id]) }}">
                            <span class="badge bg-info">{{ ucfirst($day['leave']->type) }}</span>
                          </a>
                        @elseif ($day['day']->date->format('Y-m-d') === date('Y-m-d'))
                          <span class="badge bg-primary">Today</span>
                        @endif
                      </div>
                      <div class="col-4">
                        <div class="input-group">
                          <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                          </button>
                          <ul class="dropdown-menu">
                            <li>
                              <a class="dropdown-item" role="button" onclick="addWorkDescription(this);">Sick</a>
                            </li>
                            <li>
                              <a class="dropdown-item" role="button" onclick="addWorkDescription(this);">
                                Called Out
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item" role="button" onclick="addWorkDescription(this);">
                                Approved Time-Off
                              </a>
                            </li>
                          </ul>
                          <textarea name="days[{{ $day['day']->date->format('Y-m-d') }}][description]" class="form-control" rows="1" @disabled($timesheet->completed_at !== null)>{{ $day['day']->description }}</textarea>
                        </div>
                      </div>
                      <div class="col-2">
                        <input type="time" name="days[{{ $day['day']->date->format('Y-m-d') }}][start_time]" class="form-control"
                          value="{{ $day['day']->id ? $day['day']->start_time?->format('H:i') : '' }}"
                          onchange="recalculateWeekHours('week{{ $week['index'] }}');" step="60" @disabled($timesheet->completed_at !== null) />
                      </div>
                      <div class="col-2">
                        <input type="time" name="days[{{ $day['day']->date->format('Y-m-d') }}][end_time]" class="form-control"
                          value="{{ $day['day']->id ? $day['day']->end_time?->format('H:i') : '' }}"
                          onchange="recalculateWeekHours('week{{ $week['index'] }}');" step="60" @disabled($timesheet->completed_at !== null) />
                      </div>
                      <div class="col-2">
                        <div class="input-group">
                          @if ($timesheet->pay_type === 'hourly')
                            <span class="input-group-text">
                              <i class="fas fa-clock"></i>
                            </span>
                            <input type="number" name="days[{{ $day['day']->date->format('Y-m-d') }}][adjustment]" class="form-control"
                              value="{{ $day['day']['adjustment'] }}" step="15" min="-1440" max="1440"
                              onchange="recalculateWeekHours('week{{ $week['index'] }}');" @disabled($timesheet->completed_at !== null || $timesheet->pay_type !== 'hourly') />
                            <input type="hidden" name="days[{{ $day['day']->date->format('Y-m-d') }}][total_units]"
                              value="{{ $day['day']['total_units'] ?: 0 }}" />
                          @else
                            <span class="input-group-text">
                              <i class="fas fa-user-clock"></i>
                            </span>
                            <input type="number" name="days[{{ $day['day']->date->format('Y-m-d') }}][total_units]" class="form-control"
                              value="{{ $day['day']->total_units ?: 0 }}" step="0.25" min="0" max="1"
                              onchange="recalculateWeekDays(this);" @disabled($timesheet->completed_at !== null) />
                          @endif
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
                    <div class="col-1" data-week-sum>N/A</div>
                  </div>
                </div>
              </div>
            @endforeach
          </form>

          <div class="button-group my-3 d-flex" id="timesheetControls">
            @if (!$timesheet->completed_at)
              <button name="submit" class="btn btn-primary me-3" type="submit" value="complete" form="timesheetUpdateForm" @disabled($employee->employment_status !== 'active')>
                {{ !$timesheet->id ? 'Create & Finalize' : 'Save & Finalize' }}
              </button>
              <button name="submit" class="btn btn-outline-primary me-3" type="submit" value="save" form="timesheetUpdateForm"
                @disabled($employee->employment_status !== 'active')>
                {{ !$timesheet->id ? 'Create' : 'Save' }}
              </button>
            @else
              <span class="fw-bold">
                <i class="fas fa-check-circle me-1"></i>
                Finalized {{ $timesheet->completed_at->format('m/d/Y g:i A') }}
              </span>
            @endif
            <a class="text-danger ms-auto" role="button" href="{{ Route('employees.employee', $employee->id) }}">Cancel</a>
          </div>
        </div>
      </div>
    </main>
  </div>

  @includeUnless(!$timesheet->id, 'partials.periodSettingsModal')
  @includeUnless(!$timesheet->id, 'partials.emailTimesheetModal')

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}"></script>
  <script>
    document.querySelector("#employee-selector").onchange = (e) => {
      window.location.href = e.target.querySelector("option:checked").dataset.href;
    };

    @if ($timesheet->pay_type === 'hourly')
      document.querySelectorAll(".card[id^='week']").forEach(week => recalculateWeekHours(week.id));
    @else
      document.querySelectorAll(".card[id^='week']").forEach(week => recalculateWeekDays(week.id));
    @endif
  </script>
</body>

</html>
