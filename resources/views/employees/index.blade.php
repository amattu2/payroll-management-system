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

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3 pb-3">
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
          <h1 class="h2">Employees</h1>
          @can(['create-employees', 'edit-employees', 'delete-employees'])
            <div class="btn-toolbar mb-2 mb-md-0">
              <a class="btn btn-sm btn-outline-secondary me-2" href="{{ Route('employees.employee', 'create') }}">Create</a>
              <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
            </div>
          @endcan
        </div>
        <div class="row text-center mb-3">
          @forelse ($top as $e)
            <div class="col-3">
              <div class="bg-white rounded shadow-sm p-3" role="button" onclick="window.location.href = '{{ Route('employees.employee', $e->id) }}';">
                @include('partials.avatar', [
                    'size' => 100,
                    'classes' => 'mb-3 shadow-sm mx-auto fs-2',
                    'name' => $e->firstname . ' ' . $e->lastname,
                ])
                <h5 class="mb-0">{{ $e->firstname }} {{ $e->lastname }}</h5>
                <span class="small text-uppercase text-muted">{{ $e->title }}</span>
              </div>
            </div>
          @empty
            <span class="text-muted">{{ __('messages.no.employees') }}</span>
          @endforelse
        </div>

        <div class="card p-3 shadow-sm">
          @include('partials.employeeTable')
        </div>
      @endif
    </main>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
