<!DOCTYPE html>
<html lang="EN">
  <head>
    <title>{{config('app.name')}}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
 </head>

  <body>
    @include("partials.navbar")
    @include("partials.errors")

    <div class="container-fluid">
      @include("partials.sidebar")

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3 bg-light">
        @if (!isset($employees) || count($employees) == 0)
          <div class="h-100 p-5 text-white bg-dark rounded-3">
            <h2>{{trans('messages.welcome.to.app', ['name' => config('app.name')])}}</h2>
            <p>{{__("messages.no.employees")}}</p>
            <a href="{{route("employees.employee", "create")}}">
              <button class="btn btn-outline-light" type="button">Create Employee</button>
            </a>
          </div>
        @else
          @include("partials.overview", ["employees" => $employees])
        @endif
      </main>
    </div>

    <!-- Scripts -->
    <script src="{{asset('js/app.js')}}" defer></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://unpkg.com/chart.js"></script>
    <script>
      feather.replace({'aria-hidden': 'true'})

      // Graphs
      const ctx = document.getElementById('myChart');
      const myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: [
            'Sunday',
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday'
          ],
          datasets: [{
            data: [
              15339,
              21345,
              18483,
              24003,
              23489,
              24092,
              12034
            ],
            lineTension: 0,
            backgroundColor: 'transparent',
            borderColor: '#007bff',
            borderWidth: 4,
            pointBackgroundColor: '#007bff'
          }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: false
              }
            }]
          },
          legend: {
            display: false
          }
        }
      });
    </script>
  </body>
</html>
