<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-156424730-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-156424730-1');
</script>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name') }}</title>
  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <script src="https://kit.fontawesome.com/bff0966233.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merriweather|Roboto:400">
  <link rel="stylesheet" href="https://unpkg.com/ionicons@4.2.2/dist/css/ionicons.min.css">

  <!-- Styles -->
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css" media="screen">
</head>
<body>
  <div id="ownerApp"></div>
  <!-- Scripts -->
  <script type=text/javascript src="{{ asset(mix('js/app.js')) }}" defer></script>
</body>
</html>
