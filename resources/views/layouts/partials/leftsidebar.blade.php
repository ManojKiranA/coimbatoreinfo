<!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          {{Html::image('adminlteassets/dist/img/user2-160x160.jpg','User Image',['class'=>'img-circle','alt'=>'User Image'])}}
        </div>
        <div class="pull-left info">
          <p>{{auth()->user()->name}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>

        <li class="{{Aktiv::isResourceActive('cbeInfoBusTimings')}}">
          <a href="{{route('cbeInfoBusTimings.index')}}">
            <i class="fa fa-clock-o"></i> <span>Time Management</span>
            
          </a>
        </li>


        <li>
          <a href="../calendar.html">
            <i class="fa fa-calendar"></i> <span>Calendar</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-red">3</small>
              <small class="label pull-right bg-blue">17</small>
            </span>
          </a>
        </li>
        <li>
          <a href="../mailbox/mailbox.html">
            <i class="fa fa-envelope"></i> <span>Mailbox</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-yellow">12</small>
              <small class="label pull-right bg-green">16</small>
              <small class="label pull-right bg-red">5</small>
            </span>
          </a>
        </li>


        <li class="treeview {{Aktiv::areResourcesActive(BladeHelper::getActiveMenuArray('LOCATIONMASTER'))}}">
          <a href="#">
            <i class="fa fa-map-marker"></i> <span>Location Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{Aktiv::isResourceActive('cbeInfoLocationFroms')}}">
              <a href="{{route('cbeInfoLocationFroms.index')}}"><i class="fa fa-circle-o"></i> Location From</a>
            </li>
            <li class="{{Aktiv::isResourceActive('cbeInfoLocationTos')}}">
              <a href="{{route('cbeInfoLocationTos.index')}}"><i class="fa fa-circle-o"></i> Location To</a>
            </li>
          </ul>
        </li>


        <li class="treeview {{Aktiv::areResourcesActive(BladeHelper::getActiveMenuArray('BUSMASTER'))}}">
          <a href="#">
            <i class="fa fa-bus"></i> <span>Bus Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{Aktiv::isResourceActive('cbeInfoBusTypes')}}">
              <a href="{{route('cbeInfoBusTypes.index')}}"><i class="fa fa-circle-o"></i> Bus Types</a>
            </li>
            <li class="{{Aktiv::isResourceActive('cbeInfoBusNames')}}">
              <a href="{{route('cbeInfoBusNames.index')}}"><i class="fa fa-circle-o"></i> Bus Names</a>
            </li>
            <li class="{{Aktiv::isResourceActive('cbeInfoBusVias')}}">
              <a href="{{route('cbeInfoBusVias.index')}}"><i class="fa fa-circle-o"></i> Bus Route Via</a>
            </li>

          </ul>
        </li>



        <li class="treeview">
          <a href="#">
            <i class="fa fa-folder"></i> <span>Examples</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
            <li><a href="profile.html"><i class="fa fa-circle-o"></i> Profile</a></li>
            <li><a href="login.html"><i class="fa fa-circle-o"></i> Login</a></li>
            <li><a href="register.html"><i class="fa fa-circle-o"></i> Register</a></li>
            <li><a href="lockscreen.html"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
            <li><a href="404.html"><i class="fa fa-circle-o"></i> 404 Error</a></li>
            <li><a href="500.html"><i class="fa fa-circle-o"></i> 500 Error</a></li>

            <li><a href="pace.html"><i class="fa fa-circle-o"></i> Pace Page</a></li>
          </ul>
        </li>


      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
