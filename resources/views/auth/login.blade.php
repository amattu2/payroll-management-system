<!DOCTYPE html>
<html lang="{{str_replace('_', '-', app()->getLocale())}}">
  <head>
    <title>{{config('app.name')}} - Sign In</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  </head>
  <body>
    @include("partials.errors")

    <h1>Sign In</h1>

    <!-- Login Form -->
    <form class="p-3" method="POST" action="{{route("auth.check")}}">
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
      <button type="submit" class="btn btn-primary">Sign In</button>
    </form>

    <!-- Scripts -->
    <script src="{{asset('js/app.js')}}" defer></script>
  </body>
</html>
