<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title inertia>{{ config('app.name') }}</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.png') }}" />
  @viteReactRefresh
  @vite('resources/js/app.jsx')
  @routes
  @inertiaHead
</head>

<body class="font-sans antialiased bg-slate-900 overscroll-none">
  @inertia
</body>

</html>
