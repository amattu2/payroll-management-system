<!DOCTYPE html>
<html class="h-100" lang="EN">

<head>
  <title>{{ config('app.name') }}</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="h-100 w-100">
  @include('partials.navbar')

  <div class="container-fluid">
    @include('partials.sidebar')

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3">
      @include('partials.errors')
      @include('partials.status')

      <div class="row">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
              <li class="breadcrumb-item"><a href="{{ Route('index') }}">Overview</a></li>
              <li class="breadcrumb-item"><a href="{{ Route('employees') }}">Employees</a></li>
              <li class="breadcrumb-item active" aria-current="page">{{ $employee->firstname }}
                {{ $employee->lastname }}</li>
            </ol>
          </nav>
          <div class="btn-toolbar">
            <select class="form-control" id="employee-selector">
              @foreach ($employees as $e)
                <option data-href="{{ Route('employees.employee', $e->id) }}" {{ $e->id === $employee->id ? 'selected' : '' }}>
                  {{ $e->firstname }} {{ $e->lastname }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="col-xl-3 mb-3">
          <!-- Employee Details -->
          <div class="card shadow-sm mb-3">
            <div class="card-body p-4">
              <div class="text-black">
                <div class="d-flex mb-3">
                  @include('partials.avatar', ['size' => 62, 'classes' => 'me-2 fs-4', 'e' => $employee])
                  <div class="ms-2 flex-shrink-0">
                    <h5 class="mb-1">{{ $employee->firstname }} {{ $employee->lastname }}</h5>
                    <p class="mb-0">{{ $employee->title }}</p>
                  </div>
                </div>
                <div class="d-flex justify-content-center text-center bg-body rounded-3 p-2">
                  <div>
                    <p class="small text-muted mb-1">Hired</p>
                    <p class="mb-0" title="{{ $employee->hired_at }}">
                      {{ (new DateTime($employee->hired_at))->format('m/Y') }}</p>
                  </div>
                  <div class="px-3">
                    <p class="small text-muted mb-1">Seniority</p>
                    <p class="mb-0">#2</p>
                  </div>
                  <div>
                    <p class="small text-muted mb-1">Department</p>
                    <p class="mb-0">Management</p>
                  </div>
                </div>
              </div>
              <div class="btn-toolbar mt-3 justify-content-end" role="toolbar">
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#sendEmailModal">Send Email</button>
              </div>
            </div>
          </div>

          <!-- Linked Employee -->
          @if ($employee->user)
            <div class="card shadow-sm mb-3">
              <div class="card-body">
                This employee is linked to the user account
                <span class="badge rounded-pill bg-dark"><a class="text-light" href="#" role="button">#{{ $employee->user->id }}</a></span>
              </div>
            </div>
          @endif

          <!-- Employee Notes -->
          @if ($employee->comments)
            <div class="card shadow-sm mb-3">
              <div class="card-header">Comments</div>
              <div class="card-body">
                <textarea class="form-control" disabled>{{ $employee->comments }}</textarea>
              </div>
            </div>
          @endif

          <!-- Employement Controls -->
          <div class="card shadow-sm mb-3">
            <div class="card-header">
              Employement Controls
            </div>
            <div class="card-body">
              <form method="POST" action="{{ Route('employees.update.employment_status', $employee->id) }}">
                @csrf
                @if (in_array($employee->employment_status, ['active', 'suspended']))
                  <p class="card-text">{{ __('messages.employment.terminate') }}</p>
                  <button class="btn btn-danger me-2" type="submit" name="employment_status" value="terminated">Terminate</button>
                  @if ($employee->employment_status === 'suspended')
                    <button class="btn btn-primary" type="submit" name="employment_status" value="active">Reactivate</button>
                  @else
                    <button class="btn btn-warning" type="submit" name="employment_status" value="suspended">Suspend</button>
                  @endif
                @else
                  <p class="card-text">{{ __('messages.employment.activate') }}</p>
                  <button class="btn btn-primary" type="submit" name="employment_status" value="active">Reactivate</button>
                @endif
              </form>
            </div>
          </div>
        </div>
        <div class="col-xl-9 mb-3" id="card-panels">
          @if ($employee->pendingLeaves->count() > 0)
            @foreach ($employee->pendingLeaves as $leave)
              <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
                <b>{{ $employee->firstname }} {{ $employee->lastname }}</b> has a pending time-off request from
                {{ $leave->created_at->format('n/j/Y') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endforeach
          @endif

          <!-- Quick Access -->
          <div class="row mb-3">
            <div class="col">
              <a class="d-flex align-items-center p-3 bg-dark text-white rounded shadow-sm text-decoration-none" role="button"
                href="{{ Route('employee.timesheet', $employee->id) }}">
                <img class="me-3" src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo-white.svg" alt="" width="48" height="38">
                <div class="lh-1">
                  <h1 class="h6 mb-0 text-white lh-1">Timesheets</h1>
                  <small>Manage monthly timesheets</small>
                </div>
              </a>
            </div>
            <div class="col">
              <a class="d-flex align-items-center p-3 bg-dark text-white rounded shadow-sm text-decoration-none" role="button"
                href="{{ Route('employee.leaves', $employee->id) }}">
                <img class="me-3" src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo-white.svg" alt="" width="48"
                  height="38">
                <div class="lh-1">
                  <h1 class="h6 mb-0 text-white lh-1">Time Off</h1>
                  <small>Approve, create, view time off</small>
                </div>
              </a>
            </div>
            {{-- <div class="col">
              <a class="d-flex align-items-center p-3 bg-dark text-white rounded shadow-sm text-decoration-none"
                role="button" href="{{ Route('employee.timesheet', $employee->id) }}">
                <img class="me-3" src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo-white.svg"
                  alt="" width="48" height="38">
                <div class="lh-1">
                  <h1 class="h6 mb-0 text-white lh-1">Disbursements</h1>
                  <small>Track and approve expenses</small>
                </div>
              </a>
            </div> --}}
          </div>

          <div class="card shadow-sm">
            <div class="card-header">
              <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                  <a class="nav-link active" href="#card-overview">Overview</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#card-payroll">Payroll</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#card-leaves">Time-Off</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#card-statistics">Statistics</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#card-edit">Edit</a>
                </li>
              </ul>
            </div>
            <div class="card-body" id="card-overview">
              <div class="row mb-3">
                <div class="col-4">
                  <div class="card p-3">
                    <div class="d-flex align-items-center justify-content-center text-muted mb-3">
                      <i class="fas fa-xl fa-user-clock me-auto"></i>
                      <h4 class="card-title me-auto">Tenure</h4>
                    </div>
                    <h2 class="text-center">
                      {{ (new DateTime($employee->hired_at))->diff(new DateTime())->format('%a') }} days
                    </h2>
                  </div>
                </div>
                <div class="col-4">
                  <div class="card p-3">
                    <div class="d-flex align-items-center justify-content-center text-muted mb-3">
                      <i class="fas fa-xl fa-money-bill me-auto"></i>
                      <h4 class="card-title me-auto">Pay</h4>
                    </div>
                    <h2 class="text-center">${{ number_format($employee->pay_rate) }} / {{ $employee->pay_type === 'hourly' ? ' hour' : ' day' }}</h2>
                  </div>
                </div>
                <div class="col-4">
                  <div class="card p-3">
                    <div class="d-flex align-items-center justify-content-center text-muted mb-3">
                      <i class="fas fa-xl fa-calendar-check me-auto"></i>
                      <h4 class="card-title me-auto">Period Pay Units</h4>
                    </div>
                    <h2 class="text-center">
                      {{ $employee->currentTimesheet?->days->sum('total_units') ?? 0 }}
                      {{ ($employee->currentTimesheet->pay_type ?? $employee->pay_type) === 'hourly' ? 'hours' : 'days' }}
                    </h2>
                  </div>
                </div>
              </div>
              <div class="px-1">
                <div class="row">
                  <div class="col-sm-3">Full Name</div>
                  <div class="col-sm-9">{{ $employee->firstname }} {{ $employee->middlename }} {{ $employee->lastname }}</div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-3">Email</div>
                  <div class="col-sm-9">{{ $employee->email }}</div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-3">Phone</div>
                  <div class="col-sm-9">{{ $employee->telephone }}</div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-3">Address</div>
                  <div class="col-sm-9">{{ $employee->street1 }}, {{ $employee->city }} {{ $employee->state }}, {{ $employee->zip }}</div>
                </div>
              </div>
            </div>
            <div class="card-body d-none" id="card-payroll">
              @if (count($employee->timesheets) > 0)
                <div class="accordion" id="payrollYearAccordion">
                  @foreach ($employee->TimesheetsByYear as $year => $timesheets)
                    <div class="accordion-item bg-white">
                      <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                          data-bs-target="#payrollYearCollapse{{ $year }}">
                          Year {{ $year }} {{ $year == date('Y') ? '*' : '' }}
                        </button>
                      </h2>
                      <div id="payrollYearCollapse{{ $year }}" class="accordion-collapse collapse" data-bs-parent="#payrollYearAccordion">
                        <div class="accordion-body">
                          <div class="accordion" id="payrollMonthAccordion{{ $year }}">
                            @foreach ($timesheets as $x => $ts)
                              <div class="accordion-item bg-white">
                                <h2 class="accordion-header">
                                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#payrollMonthCollapse{{ $year }}{{ $x }}">
                                    {{ $ts->period->format('F') }}
                                    {{ $ts->period->format('Y-m') == date('Y-m') ? '*' : '' }}
                                  </button>
                                </h2>
                                <div id="payrollMonthCollapse{{ $year }}{{ $x }}" class="accordion-collapse collapse"
                                  data-bs-parent="#payrollMonthAccordion{{ $year }}">
                                  <div class="accordion-body border m-3">
                                    <div class="row">
                                      <div class="col-sm-3">Pay Period</div>
                                      <div class="col-sm-9">
                                        <a role="button"
                                          href="{{ Route('employee.timesheet', ['id' => $employee->id, 'year' => $ts->period->format('Y'), 'month' => $ts->period->format('m')]) }}">
                                          {{ $ts->period->format('F, Y') }}
                                          <i class="fas fa-external-link-alt ms-1"></i>
                                        </a>
                                      </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                      <div class="col-sm-3">Pay Units</div>
                                      <div class="col-sm-9">
                                        {{ number_format($ts->days->sum('total_units') ?? 0, 2) }}
                                        {{ $ts->pay_type === 'hourly' ? 'Hours' : 'Days' }}
                                      </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                      <div class="col-sm-3">Leave Requests</div>
                                      <div class="col-sm-9">
                                        @forelse($ts->leaves as $i => $leave)
                                          <a role="button" href="{{ Route('leaves.leave', ['id' => $employee->id, 'leaveId' => $leave->id]) }}">
                                            #{{ $leave->id }}
                                          </a>
                                          {{ $i < $ts->leaves->count() - 1 ? ', ' : '' }}
                                        @empty
                                          N/A
                                        @endforelse
                                      </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                      <div class="col-sm-3">Finalized</div>
                                      <div class="col-sm-9">{{ $ts->completed_at?->format('m/d/Y g:ia') ?? 'N/A' }}</div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                      <div class="col-sm-3">Updated</div>
                                      <div class="col-sm-9">{{ $ts->updated_at?->format('m/d/Y g:ia') ?? 'N/A' }}</div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            @endforeach
                          </div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              @else
                <div class="alert alert-warning mb-0" role="alert">No payroll data found.</div>
              @endif
            </div>
            <div class="card-body d-none" id="card-statistics">
              <canvas id="bar-chart" width="800" height="450"></canvas>
              <hr class="my-3" />
              <canvas id="line-chart" width="800" height="450"></canvas>
              <hr class="my-3" />
              <canvas id="pie-chart" width="800" height="450"></canvas>
            </div>
            <div class="card-body d-none" id="card-leaves">
              <table class="table table-striped table-bordered mb-0">
                <thead>
                  <tr>
                    <th>Status</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Type</th>
                    <th>Comments</th>
                    <th class="text-center">Manage</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($employee->leaves as $leave)
                    <tr>
                      <td>
                        @if ($leave->status === 'approved')
                          Approved at {{ $leave->approved_at->format('n/j/Y g:ia') }}
                        @elseif ($leave->status === 'declined')
                          Declined at {{ $leave->declined_at->format('n/j/Y g:ia') }}
                        @else
                          Pending
                        @endif
                      </td>
                      <td>{{ $leave->start_date->format('n/j/Y g:ia') }}</td>
                      <td>{{ $leave->end_date->format('n/j/Y g:ia') }}</td>
                      <td>{{ ucfirst($leave->type) }}</td>
                      <td>{{ $leave->comments ?? 'N/A' }}</td>
                      <td class="text-center">
                        <a href="{{ Route('leaves.leave', ['id' => $employee->id, 'leaveId' => $leave->id]) }}">View</a>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6">No leaves found.</td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div>
            <div class="card-body d-none" id="card-edit">
              <form method="POST" action="{{ Route('employees.update.profile', $employee->id) }}">
                @include('partials.employeeForm')
                <button type="submit" class="btn btn-primary">Save</button>
                <a class="btn text-danger" href="{{ Route('employees') }}">Cancel</a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  @include('partials.sendEmailModal')

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}"></script>
  <script>
    document.querySelector("#employee-selector").onchange = (e) => {
      window.location.href = e.target.querySelector("option:checked").dataset.href;
    };

    if (document.querySelector("[href='" + window.location.hash + "']")) {
      // Remove active styling
      document.querySelectorAll(".card-header a[href]").forEach(e => e.classList.remove("active"));
      document.querySelectorAll(".card-body[id]").forEach(e => e.classList.add("d-none"));

      // Add active styling to hash target
      document.querySelector("[href='" + window.location.hash + "']").classList.add("active");
      document.querySelector(window.location.hash).classList.remove("d-none");
    }

    document.querySelectorAll(".card-header a[href]").forEach((e) => {
      e.onclick = (evt) => {
        document.querySelectorAll(".card-body[id]").forEach(element => element.classList.add("d-none"));
        document.querySelectorAll(".card-header a[href]").forEach(element => element.classList.remove("active"));
        document.querySelector(evt.target.hash).classList.remove("d-none");
        evt.target.classList.add("active");
      };
    });

    new Chart(document.getElementById("bar-chart"), {
      type: 'bar',
      data: {
        labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
        datasets: [{
          label: "Population (millions)",
          backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"],
          data: [2478, 5267, 734, 784, 433]
        }]
      },
      options: {
        legend: {
          display: false
        },
        title: {
          display: true,
          text: 'Predicted world population (millions) in 2050'
        }
      }
    });

    new Chart(document.getElementById("line-chart"), {
      type: 'line',
      data: {
        labels: [1500, 1600, 1700, 1750, 1800, 1850, 1900, 1950, 1999, 2050],
        datasets: [{
          data: [86, 114, 106, 106, 107, 111, 133, 221, 783, 2478],
          label: "Africa",
          borderColor: "#3e95cd",
          fill: false
        }, {
          data: [282, 350, 411, 502, 635, 809, 947, 1402, 3700, 5267],
          label: "Asia",
          borderColor: "#8e5ea2",
          fill: false
        }, {
          data: [168, 170, 178, 190, 203, 276, 408, 547, 675, 734],
          label: "Europe",
          borderColor: "#3cba9f",
          fill: false
        }, {
          data: [40, 20, 10, 16, 24, 38, 74, 167, 508, 784],
          label: "Latin America",
          borderColor: "#e8c3b9",
          fill: false
        }, {
          data: [6, 3, 2, 2, 7, 26, 82, 172, 312, 433],
          label: "North America",
          borderColor: "#c45850",
          fill: false
        }]
      },
      options: {
        title: {
          display: true,
          text: 'World population per region (in millions)'
        }
      }
    });

    new Chart(document.getElementById("pie-chart"), {
      type: 'pie',
      data: {
        labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
        datasets: [{
          label: "Population (millions)",
          backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"],
          data: [2478, 5267, 734, 784, 433]
        }]
      },
      options: {
        title: {
          display: true,
          text: 'Predicted world population (millions) in 2050'
        }
      }
    });
  </script>
</body>

</html>
