<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>
  <link rel="stylesheet" href="{{ asset('/css/index.css')}}">
</head>
<body>
  <h2>@yield('page-title')</h2>
  @yield('sort')
  <div class="wrapper">
  @yield('content')
  </div>
</body>
</html>