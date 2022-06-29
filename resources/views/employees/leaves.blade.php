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
            <li class="breadcrumb-item active" aria-current="page">Leaves</li>
          </ol>
        </nav>
        <div class="btn-toolbar">
          <select class="form-control" id="employee-selector">
            @foreach ($employees as $e)
              <option data-href="{{ Route('employees.employee.leaves', $e->id) }}"
                {{ $e->id === $employee->id ? 'selected' : '' }}>
                {{ $e->firstname }} {{ $e->lastname }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block bg-body">
          <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mb-1 text-uppercase">
            <span>Request History</span>
          </h6>
          <ul class="nav flex-column mb-2">
            @forelse ($employee->leaves as $l)
              <li class="nav-item">
                <a class="nav-link text-muted" href="#leave{{ $l['id'] }}">
                  @if ($l->approved)
                    <i class="fas fa-check me-1"></i>
                  @elseif ($l->declined)
                    <i class="fas fa-times me-1"></i>
                  @else
                    <i class="fas fa-user-clock me-1"></i>
                  @endif
                  {{ $l->start_date->format('m/Y') }}
                  ({{ $l->duration->format('%ad') }})
                </a>
              </li>
            @empty
              <li class="nav-item">
                <a class="nav-link text-muted" href="#">
                  None
                </a>
              </li>
            @endforelse
          </ul>
        </nav>
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <div class="btn-toolbar justify-content-between">
            <div class="d-flex me-auto">
              <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                data-bs-target="#createLeaveModal">Create</button>
            </div>
          </div>

          <div class="row">
            @forelse ($employee->leaves as $l)
              <div class="col-xl-6">
                <div class="card shadow-sm mt-3" id="leave{{ $l->id }}">
                  <div class="card-header">
                    Request #{{ $l->id }}
                  </div>
                  <div class="card-body">
                    <div class="row p-3">
                      <div class="row">
                        <div class="col-sm-3">
                          <p class="mb-0">Duration</p>
                        </div>
                        <div class="col-sm-9">
                          <p class="text-muted mb-0">
                            {{ $l->start_date->format('m/d/Y') }} &ndash;
                            {{ $l->end_date->format('m/d/Y') }}
                            ({{ $l->duration->format('%a') }} days)
                          </p>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-sm-3">
                          <p class="mb-0">Status</p>
                        </div>
                        <div class="col-sm-9">
                          <p class="text-muted mb-0">
                            @if ($l->approved)
                              <i class="fas fa-check me-1"></i>
                              Approved on {{ $l->approved->format('m/d/Y g:i A') }}
                            @elseif ($l->declined)
                              <i class="fas fa-times me-1"></i>
                              Declined on {{ $l->declined->format('m/d/Y g:i A') }}
                            @else
                              <i class="fas fa-user-clock me-1"></i>
                              Pending
                            @endif
                          </p>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-sm-3">
                          <p class="mb-0">Pay Period</p>
                        </div>
                        <div class="col-sm-9">
                          <p class="text-muted mb-0">
                            @if ($l->timesheet)
                              <a role="button"
                                href="{{ Route('employees.employee.timesheet', ['id' => $employee->id, 'year' => $l->timesheet->period->format('Y'), 'month' => $l->timesheet->period->format('m')]) }}">
                                {{ $l->timesheet->period->format('F, Y') }}
                                <i class="fas fa-external-link-alt"></i>
                              </a>
                            @else
                              N/A
                            @endif
                          </p>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-sm-3">
                          <p class="mb-0">Comments</p>
                        </div>
                        <div class="col-sm-9">
                          <p class="text-muted mb-0">{{ $l->comments ?? 'N/A' }}</p>
                        </div>
                      </div>
                    </div>
                    <a class="btn btn-primary" href="{{ Route('leaves.leave', [$employee->id, $l->id]) }}">
                      Edit
                    </a>
                  </div>
                </div>
              </div>
            @empty
              <span class="text-muted text-center">Nothing to see here</span>
            @endforelse
          </div>
        </div>
      </div>
    </main>
  </div>

  @include('partials.leaveCreateModal')

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}"></script>
  <script>
    document.querySelector("#employee-selector").onchange = (e) => {
      window.location.href = e.target.querySelector("option:checked").dataset.href;
    };
  </script>
</body>

</html>
