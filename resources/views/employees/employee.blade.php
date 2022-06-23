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
          <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-3">
            <ol class="breadcrumb mb-0">
              <li class="breadcrumb-item"><a href="{{Route("index")}}">Overview</a></li>
              <li class="breadcrumb-item"><a href="{{Route("employees")}}">Employees</a></li>
              <li class="breadcrumb-item active" aria-current="page">#{{str_pad($employee->id, 4, "0", STR_PAD_LEFT)}}</li>
            </ol>
          </nav>

          <div class="col-xl-3 mb-3">
            <!-- Employee Details -->
            <div class="card shadow-sm mb-3">
              <div class="card-body p-4">
                <div class="d-flex text-black">
                  <div class="flex-shrink-0">
                    <img src="https://bootstrapious.com/i/snippets/sn-team/teacher-4.jpg" alt="Profile Picture" class="img-fluid" style="width: 62px; border-radius: 10px;">
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <h5 class="mb-1">{{$employee->firstname}} {{$employee->lastname}}</h5>
                    <p class="mb-2 pb-1">{{$employee->title}}</p>
                    <div class="d-flex justify-content-center text-center bg-body rounded-3 p-2">
                      <div>
                        <p class="small text-muted mb-1">Hired</p>
                        <p class="mb-0" title="{{$employee->hired_at}}">{{(new DateTime($employee->hired_at))->format("m/Y")}}</p>
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
                </div>
              </div>
            </div>

            <!-- Employement Controls -->
            <div class="card shadow-sm mb-3">
              <div class="card-header">
                Employement Controls
              </div>
              <div class="card-body">
                @if (in_array($employee->employement_status, ["active", "suspended"]))
                  <p class="card-text">Is this employee no longer employed? Mark them as terminated below.</p>
                  <a href="#" class="btn btn-danger me-2">Terminate</a>
                  @if ($employee->employement_status === "suspended")
                    <a href="#" class="btn btn-primary">Unsuspend</a>
                  @else
                    <a href="#" class="btn btn-warning">Suspend</a>
                  @endif
                @else
                  <p class="card-text">Reactivate this employee below.</p>
                  <a href="#" class="btn btn-primary">Activate</a>
                @endif
              </div>
            </div>
          </div>
          <div class="col-xl-9 mb-3" id="card-panels">
            <div class="card shadow-sm">
              <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                  <li class="nav-item">
                    <a class="nav-link active" href="#card-overview">Overview</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Payroll</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">PTO</a>
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
                <div class="row p-3">
                  <div class="row">
                    <div class="col-sm-3">
                      <p class="mb-0">Full Name</p>
                    </div>
                    <div class="col-sm-9">
                      <p class="text-muted mb-0">{{$employee->firstname}} {{$employee->middlename}} {{$employee->lastname}}</p>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <p class="mb-0">Email</p>
                    </div>
                    <div class="col-sm-9">
                      <p class="text-muted mb-0">{{$employee->email}}</p>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <p class="mb-0">Phone</p>
                    </div>
                    <div class="col-sm-9">
                      <p class="text-muted mb-0">{{$employee->telephone}}</p>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <p class="mb-0">Address</p>
                    </div>
                    <div class="col-sm-9">
                      <p class="text-muted mb-0">{{$employee->street1}}, {{$employee->city}} {{$employee->state}}, {{$employee->zip}}</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body d-none" id="card-statistics">
                <canvas id="bar-chart" width="800" height="450"></canvas>
                <hr class="my-3" />
                <canvas id="line-chart" width="800" height="450"></canvas>
                <hr class="my-3" />
                <canvas id="pie-chart" width="800" height="450"></canvas>
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
    <script src="{{asset('js/app.js')}}"></script>
    <script>
      if (document.querySelector("[href='"+window.location.hash+"']")) {
        // Remove active styling
        document.querySelectorAll(".card-header a").forEach(e => e.classList.remove("active"));
        document.querySelectorAll("#card-panels .card-body").forEach(e => e.classList.add("d-none"));

        // Add active styling to hash target
        document.querySelector("[href='"+window.location.hash+"']").classList.add("active");
        document.querySelector(window.location.hash).classList.remove("d-none");
      }

      document.querySelectorAll(".card-header a").forEach((e) => {
        e.onclick = (evt) => {
          document.querySelectorAll("#card-panels .card-body").forEach(element => element.classList.add("d-none"));
          document.querySelectorAll(".card-header a").forEach(element => element.classList.remove("active"));
          document.querySelector(evt.target.hash).classList.remove("d-none");
          evt.target.classList.add("active");
        };
      });

      new Chart(document.getElementById("bar-chart"), {
        type: 'bar',
        data: {
          labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
          datasets: [
            {
              label: "Population (millions)",
              backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
              data: [2478,5267,734,784,433]
            }
          ]
        },
        options: {
          legend: { display: false },
          title: {
            display: true,
            text: 'Predicted world population (millions) in 2050'
          }
        }
      });

      new Chart(document.getElementById("line-chart"), {
        type: 'line',
        data: {
          labels: [1500,1600,1700,1750,1800,1850,1900,1950,1999,2050],
          datasets: [{
              data: [86,114,106,106,107,111,133,221,783,2478],
              label: "Africa",
              borderColor: "#3e95cd",
              fill: false
            }, {
              data: [282,350,411,502,635,809,947,1402,3700,5267],
              label: "Asia",
              borderColor: "#8e5ea2",
              fill: false
            }, {
              data: [168,170,178,190,203,276,408,547,675,734],
              label: "Europe",
              borderColor: "#3cba9f",
              fill: false
            }, {
              data: [40,20,10,16,24,38,74,167,508,784],
              label: "Latin America",
              borderColor: "#e8c3b9",
              fill: false
            }, {
              data: [6,3,2,2,7,26,82,172,312,433],
              label: "North America",
              borderColor: "#c45850",
              fill: false
            }
          ]
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
              backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
              data: [2478,5267,734,784,433]
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
