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
  </body>
</html>
