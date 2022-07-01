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
            <li class="breadcrumb-item"><a
                href="{{ Route('employees.employee', $employee->id) }}">{{ $employee->firstname }}
                {{ $employee->lastname }}</a></li>
            <li class="breadcrumb-item"><a href="{{ Route('employee.leaves', $employee->id) }}">Leaves</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">#{{ $leave->id }}</li>
          </ol>
        </nav>
        <div class="btn-toolbar">
          <select class="form-control" id="employee-selector">
            @foreach ($employees as $e)
              <option data-href="{{ Route('employee.leaves', $e->id) }}"
                {{ $e->id === $employee->id ? 'selected' : '' }}>
                {{ $e->firstname }} {{ $e->lastname }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="row">
        <div class="mx-auto col-12 col-xxl-8">
          <div class="card shadow-sm">
            <h5 class="card-header">Leave Request #{{ $leave->id }}</h5>
            <div class="card-body">
              <form class="row g-3" id="leaveRequestForm"
                action="{{ Route('leave.update', ['id' => $employee->id, 'leaveId' => $leave->id]) }}"
                method="POST">
                @include('partials.leaveForm')
              </form>
            </div>
          </div>
          <div class="button-group my-3 d-flex">
            <button class="btn btn-primary me-3" type="submit" form="leaveRequestForm">Save</button>
            <a class="text-danger ms-auto" role="button"
              href="{{ Route('employee.leaves', $employee->id) }}">Cancel</a>
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
