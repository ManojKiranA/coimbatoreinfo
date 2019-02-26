<!DOCTYPE html>
<html>
<head>

  @include('layouts.partials.header')

</head>
<body class="hold-transition {{config('cinfoConstants.desgins.themeColor')}} sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="{{route('home')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>CBE</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Coimbatore</b>INFO</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              {{Html::image('adminlteassets/dist/img/user2-160x160.jpg','User Image',['class'=>'user-image','alt'=>'User Image'])}}
              <span class="hidden-xs">{{auth()->user()->name}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                {{Html::image('adminlteassets/dist/img/user2-160x160.jpg','User Image',['class'=>'img-circle','alt'=>'User Image'])}}
                <p>
                  {{auth()->user()->name}} - Admin
                  <small>{{ApplicationHelper::convertToFormattedDate( auth()->user()->created_at,1 )}}</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Change Password</a>
                </div>

                <div class="pull-right">
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                  </form>

                    <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                </div>


              </li>
            </ul>
          </li>
          
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  @include('layouts.partials.leftsidebar')

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <section class="content-header">
      <!-- Content Header (Page header) -->
      @yield('pageHeader')
      <!-- Content Header (Page header) -->
    </section>
    @include('flash-message')
    @yield('content')
  </div>
  <!-- /.content-wrapper -->

@include('layouts.partials.footer')

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
@foreach(config('cinfoConstants.desgins.backend.mainJs') as $jsFileComment => $jsFileUrl)
<!-- {{$jsFileComment}} -->
{{Html::script($jsFileUrl)}}
@endforeach  
<!-- Scripts -->
  <script>

      window.Laravel = {!! json_encode([
          'csrfToken' => csrf_token(),
      ]) !!};

  </script>
  <script>

    $(document).ready(function () {
      $('.sidebar-menu').tree()
    })
  </script>

  {{BladeHelper::toolTipScript()}}
  @stack('scripts')

</body>
</html>
