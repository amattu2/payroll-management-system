<!DOCTYPE html>
<html lang="EN">

<head>
  <title>{{ config('app.name') }} - Register</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>

  <div class="bg-white container container-fluid mt-lg-5 p-lg-5 p-3 rounded shadow-sm">
    @include('partials.errors')

    <p class="h1">{{ __('messages.welcome.to.app', ['name' => config('app.name')]) }}</p>
    <p class="lead">To begin your payroll management journey, please create a account below.</p>

    <form method="POST" action="{{ Route('auth.create') }}">
      @csrf
      <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" class="form-control" id="name" name="name">
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" name="email">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password">
      </div>
      <div class="mb-3">
        <label for="password_confirmation" class="form-label">Verify Password</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
</body>

</html>
