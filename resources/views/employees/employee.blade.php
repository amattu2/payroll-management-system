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
          </div>
          <div class="col-xl-9 mb-3">
            <div class="card shadow-sm">
              <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                  <li class="nav-item">
                    <a class="nav-link active" href="#card-overview">Overview</a>
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
                <div class="row">
                  <div class="col-4">
                    <div class="card p-3 shadow-sm">
                      <div class="d-flex align-items-center justify-content-center text-muted mb-3">
                        <i class="fas fa-xl fa-user-clock me-auto"></i>
                        <h4 class="card-title me-auto">Tenure</h4>
                      </div>
                      <h2 class="text-center">{{((new DateTime($employee->hired_at))->diff(new DateTime()))->d}} days</h2>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="card p-3 shadow-sm">
                      <div class="d-flex align-items-center justify-content-center text-muted mb-3">
                        <i class="fas fa-xl fa-money-bill me-auto"></i>
                        <h4 class="card-title me-auto">Salary</h4>
                      </div>
                      <h2 class="text-center">${{number_format($employee->pay_rate)}}</h2>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="card p-3 shadow-sm">
                      <div class="d-flex align-items-center justify-content-center text-muted mb-3">
                        <i class="fas fa-xl fa-calendar-check me-auto"></i>
                        <h4 class="card-title me-auto">Pay Units</h4>
                      </div>
                      <h2 class="text-center">
                        0
                        {{$employee->pay_type === "hourly" ? "hours" : "days"}}
                      </h2>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body d-none" id="card-statistics">
                <em>No content</em>
              </div>
              <div class="card-body d-none" id="card-edit">
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
    <script>
      if (document.querySelector("[href='"+window.location.hash+"']")) {
        // Remove active styling
        document.querySelectorAll(".card-header a").forEach(e => e.classList.remove("active"));
        document.querySelectorAll(".card-body").forEach(e => e.classList.add("d-none"));

        // Add active styling to hash target
        document.querySelector("[href='"+window.location.hash+"']").classList.add("active");
        document.querySelector(window.location.hash).classList.remove("d-none");
      }

      document.querySelectorAll(".card-header a").forEach((e) => {
        e.onclick = (evt) => {
          document.querySelectorAll(".card-body").forEach(element => element.classList.add("d-none"));
          document.querySelectorAll(".card-header a").forEach(element => element.classList.remove("active"));
          document.querySelector(evt.target.hash).classList.remove("d-none");
          evt.target.classList.add("active");
        };
      });
    </script>
  </body>
</html>
