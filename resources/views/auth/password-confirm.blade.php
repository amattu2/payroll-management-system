<!DOCTYPE html>
<html lang="EN">

<head>
  <title>{{ config('app.name') }} - Password Check</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
  <div class="bg-white container container-fluid mt-lg-5 p-lg-5 p-3 rounded shadow-sm">
    @include('partials.errors')

    <p class="h1">Verify your password</p>
    <p class="lead">To access this page, please verify your password below.</p>

    <form method="POST" action="{{ Route('confirm.check') }}">
      @csrf
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password">
      </div>
      <button type="submit" class="btn btn-primary">Verify</button>
    </form>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
</body>

</html>
