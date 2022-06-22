<!DOCTYPE html>
<html class="h-100" lang="EN">
  <head>
    <title>{{config('app.name')}}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
  </head>

  <body class="h-100 w-100">
    @include("partials.navbar")

    <div class="container-fluid">
      @include("partials.sidebar")

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3">
        @include("partials.errors")

        @if (!isset($employees) || count($employees) == 0)
          <div class="h-100 p-5 text-white bg-dark rounded-3">
            <h2>{{trans('messages.welcome.to.app', ['name' => config('app.name')])}}</h2>
            <p>{{__("messages.no.employees")}}</p>
            <a href="{{route("employees.employee", "create")}}">
              <button class="btn btn-outline-light" type="button">Create Employee</button>
            </a>
          </div>
        @else
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Employees</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <a class="btn btn-sm btn-outline-secondary me-2" href="{{Route("employees.employee", "create")}}">Create</a>
              <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
            </div>
          </div>
          <div class="row text-center mb-3">
            @for ($i = 0; $i < 4; $i++)
            <div class="col-3">
              <div class="bg-white rounded shadow-sm p-3" role="button" onclick="window.location.href = '{{route("employees.employee", $i)}}';">
                <img src="https://bootstrapious.com/i/snippets/sn-team/teacher-4.jpg" alt="" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                <h5 class="mb-0">{First Last}</h5>
                <span class="small text-uppercase text-muted">{Employee Role}</span>
              </div>
            </div>
            @endfor
          </div>

          <div class="card p-3 mb-3 shadow-sm">
            @include("partials.employeeTable", ["employees" => $employees])
          </div>
        @endif
      </main>
    </div>

    <!-- Scripts -->
    <script src="{{asset('js/app.js')}}" defer></script>
  </body>
</html>
