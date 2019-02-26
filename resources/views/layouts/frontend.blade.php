<!DOCTYPE html>
<html lang="en">
   <head>
      <title>{{ config('app.name', 'CoimbatoreInfo') }} @yield('title') </title>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="description" content="Travello template project">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      @foreach(config('cinfoConstants.desgins.frontend.mainCss') as $cssFileComment => $cssFileUrl)
      <!-- {{$cssFileComment}} -->
      {{Html::style($cssFileUrl)}}
      @endforeach
      @stack('styles')
   </head>
   <body>
      <div class="super_container">
         @include('layouts.partialsfront.menus')
         <!-- Home -->
         @include('layouts.partialsfront.frontendhead')
         @include('layouts.partialsfront.searchfrom')
         <!-- Intro -->
         @yield('content')
         @include('layouts.partialsfront.footer')
      </div>
      @foreach(config('cinfoConstants.desgins.frontend.mainJs') as $jsFileComment => $jsFileUrl)
      <!-- {{$jsFileComment}} -->
      {{Html::script($jsFileUrl)}}
      @endforeach  
   </body>
</html>