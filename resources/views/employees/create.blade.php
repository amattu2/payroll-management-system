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
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-3">
        @include("partials.errors")

        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Create Employee</h5>
            <p class="card-text">Create a new employee below to begin tracking payroll, disembursements, & more!</p>
            <form method="POST" action="{{route("employees.create")}}">
              @include("partials.employeeForm")
              <button type="submit" class="btn btn-primary">Create</button>
              <a class="btn text-danger" href="{{route("employees")}}">Cancel</a>
            </form>
          </div>
        </div>
      </main>
    </div>

    <!-- Scripts -->
    <script src="{{asset('js/app.js')}}" defer></script>
  </body>
</html>
