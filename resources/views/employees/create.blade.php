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
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-3">
      @include('partials.errors')

      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ Route('index') }}">Overview</a></li>
            <li class="breadcrumb-item"><a href="{{ Route('employees') }}">Employees</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
          </ol>
        </nav>
        <div class="btn-toolbar">
          <select class="form-control" id="employee-selector">
            @foreach ($employees as $e)
              <option data-href="{{ Route('employees.employee', $e->id) }}">{{ $e->firstname }}
                {{ $e->lastname }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Create Employee</h5>
          <p class="card-text">Create a new employee below to begin tracking payroll, disbursements, & more!</p>
          <form method="POST" action="{{ Route('employees.create') }}">
            @include('partials.employeeForm')
            <button type="submit" class="btn btn-primary">Create</button>
            <a class="btn text-danger" href="{{ Route('employees') }}">Cancel</a>
          </form>
        </div>
      </div>
    </main>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
  <script>
    document.querySelector("#employee-selector").onchange = (e) => {
      window.location.href = e.target.querySelector("option:checked").dataset.href;
    };
  </script>
</body>

</html>
