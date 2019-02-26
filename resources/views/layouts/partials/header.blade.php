<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.name', 'CoimbatoreInfo') }} @yield('title') </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  @foreach(config('cinfoConstants.desgins.backend.mainCss') as $cssFileComment => $cssFileUrl)
<!-- {{$cssFileComment}} -->
  {{Html::style($cssFileUrl)}}
  @endforeach
  @stack('styles')
