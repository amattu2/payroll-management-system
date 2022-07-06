<!DOCTYPE html>
<html lang="EN">

<head>
  <title>{{ config('app.name') }} - Sign In</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
  <div class="bg-white container container-fluid mt-lg-5 p-lg-5 p-3 rounded shadow-sm">
    @include('partials.errors')

    <p class="h1">{{ __('messages.welcome.to.app', ['name' => config('app.name')]) }}</p>
    <p class="lead">To resume your payroll management journey, please sign in below.</p>

    <form method="POST" action="{{ Route('auth.check') }}">
      @csrf
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" name="email">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password">
      </div>
      <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="remember" name="remember">
        <label class="form-check-label" for="remember">Remember Me</label>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
</body>

</html>
