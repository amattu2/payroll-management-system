<!DOCTYPE html>
<html lang="{{str_replace('_', '-', app()->getLocale())}}">
  <head>
    <title>{{config('app.name')}}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  </head>
  <body>
    <h1>Register</h1>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
  </body>
</html>
