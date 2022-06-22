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

        <div class="row">
          <div class="col-xl-3 text-center mb-3">
            <div class="card p-3 shadow-sm">
              <img src="https://bootstrapious.com/i/snippets/sn-team/teacher-4.jpg" alt="" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm mx-auto">
              <h5 class="mb-0">{{$employee->firstname}} {{$employee->middlename}} {{$employee->lastname}}</h5>
              <span class="badge bg-primary mt-1">{{$employee->title}}</span>
              <span class="text-muted mt-1" title="{{$employee->hired_at}}">{{(new DateTime($employee->hired_at))->format("F jS, Y")}}</span>
            </div>

            <div class="card p-3 shadow-sm mt-3">
              <div class="d-flex align-items-center justify-content-center text-muted mb-3">
                <i class="fas fa-2xl fa-user-clock me-auto"></i>
                <h4 class="card-title me-auto">Tenure</h4>
              </div>
              <h2 class="text-center">{{((new DateTime($employee->hired_at))->diff(new DateTime()))->d}} days</h2>
            </div>

            <div class="card p-3 shadow-sm mt-3">
              <div class="d-flex align-items-center justify-content-center text-muted mb-3">
                <i class="fas fa-2xl fa-money-bill me-auto"></i>
                <h4 class="card-title me-auto">Salary</h4>
              </div>
              <h2 class="text-center">${{number_format($employee->pay_rate)}}</h2>
            </div>

            <div class="card p-3 shadow-sm mt-3">
              <div class="d-flex align-items-center justify-content-center text-muted mb-3">
                <i class="fas fa-2xl fa-calendar-check me-auto"></i>
                <h4 class="card-title me-auto">Period Pay Units</h4>
              </div>
              <h2 class="text-center">
                0
                {{$employee->pay_type === "hourly" ? "hours" : "days"}}
              </h2>
            </div>
          </div>
          <div class="col-xl-9 mb-3">
            <div class="card shadow-sm">
              <div class="card-body">
                <form method="POST" action="">
                  @include("partials.employeeForm")
                  <button type="submit" class="btn btn-primary">Save</button>
                  <a class="btn text-danger" href="{{route("employees")}}">Cancel</a>
                </form>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>

    <!-- Scripts -->
    <script src="{{asset('js/app.js')}}" defer></script>
  </body>
</html>
