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

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-2 pt-3">
      <div class="container-fluid p-5 bg-white">
        <h1 class="display-5 fw-bold">404.</h1>
        <p class="col-md-8 fs-4">{{ __('messages.404', ['slug' => $slug]) }}</p>
        <a class="btn btn-primary btn-lg" role="button" href="{{ Route('index') }}">Go Home</a>
      </div>
    </main>
  </div>
</body>

</html>
