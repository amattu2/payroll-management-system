<!DOCTYPE html>
<html lang="EN">
  <head>
    <title>{{ config('app.name') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  </head>
  <body>
    @include('partials.navbar')

    <div class="container-fluid">
      @include('partials.sidebar')

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3">
        @include('partials.errors')

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
          <h1 class="h2">Reports</h1>
        </div>
      </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
  </body>
</html>
