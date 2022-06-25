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

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
          <h1 class="h2">Time Sheets</h1>
          <div class="btn-toolbar mb-2 mb-md-0">
            <select class="form-control" id="employee-selector">
              @foreach($employees as $employee)
                <option value="{{$employee->id}}">{{$employee->firstname}} {{$employee->lastname}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="row">
          <nav class="col-md-3 col-lg-2 d-md-block bg-body">
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
              <span>Timesheet History</span>
            </h6>
            <ul class="nav flex-column mb-2">
              <li class="nav-item">
                <a class="nav-link active" href="#">
                  <i class="far fa-calendar me-1"></i>
                  {{(new DateTime())->format('F, Y')}}
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-muted" href="#">
                  <i class="far fa-calendar-check me-1"></i>
                  {{((new DateTime())->sub(new DateInterval("P1M")))->format('F, Y')}}
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-muted" href="#">
                  <i class="far fa-calendar-check me-1"></i>
                  {{((new DateTime())->sub(new DateInterval("P2M")))->format('F, Y')}}
                </a>
              </li>
            </ul>
          </nav>
          <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3">
            <!-- Weekly Sheets -->
            <div class="accordion">
              @for ($i = 0; $i < 4; $i++)
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#week{{$i}}">
                    {{(new DateTime())->sub(new DateInterval("P".$i."W"))->format('F j, Y')}}
                  </button>
                </h2>
                <div id="week{{$i}}" class="accordion-collapse collapse show">
                  <div class="accordion-body">
                    <div class="card shadow-sm">
                      <div class="card-body">
                        {form group containing inputs for each day of this week}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endfor
            </div>

            <div class="button-group mt-3">
              <button class="btn btn-primary me-2" type="button">Save</button>
              <a class="text-danger" role="button">Cancel</button>
          </main>
        </div>
      </main>
    </div>

    <!-- Scripts -->
    <script src="{{asset('js/app.js')}}"></script>
  </body>
</html>
