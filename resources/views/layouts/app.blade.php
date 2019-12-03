<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-textdirection="ltr" class="loading">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Nujeks cargo management application.">
    <meta name="keywords" content="cargo, package, delivery, truck">
    <meta name="author" content="ArfianAgus">
    @if (trim($__env->yieldContent('pagetitle')))
    <h1>@yield('pagetitle')</h1>
    @else
    <title>{{ config('app.name', 'Laravel') }}</title>
    @endif
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('/') }}app-assets/img/ico/apple-icon-60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('/') }}app-assets/img/ico/apple-icon-76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('/') }}app-assets/img/ico/apple-icon-120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('/') }}app-assets/img/ico/apple-icon-152.png">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <!-- <link rel="shortcut icon" type="image/png" href="app-assets/img/ico/favicon-32.png"> -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900|Montserrat:300,400,500,600,700,800,900" rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <!-- font icons-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}app-assets/fonts/feather/style.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}app-assets/fonts/simple-line-icons/style.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}app-assets/fonts/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}app-assets/vendors/css/perfect-scrollbar.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}app-assets/vendors/css/prism.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}app-assets/vendors/css/chartist.min.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN APEX CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}app-assets/css/app.css">
    <!-- END APEX CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}css/style.css">
    <!-- END Custom CSS-->
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('pagecss')
</head>
<body data-col="2-columns" class=" 2-columns ">
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="wrapper">

      <!-- main menu-->
      <!--.main-menu(class="#{menuColor} #{menuOpenType}", class=(menuShadow == true ? 'menu-shadow' : ''))-->
      <div data-active-color="white" data-background-color="man-of-steel" data-image="{{ asset('/') }}app-assets/img/sidebar-bg/05.jpg" class="app-sidebar">
        <!-- main menu header-->
        <!-- Sidebar Header starts-->
        <div class="sidebar-header">
          <div class="logo clearfix"><a href="{{ url('/') }}" class="logo-text float-left">
              <div class="logo-img"><img src="{{ asset('images/logo-nujeks-white32.png') }}" width="40px" /></div><span class="text align-middle">CARGO</span></a><a id="sidebarToggle" href="javascript:;" class="nav-toggle d-none d-sm-none d-md-none d-lg-block"><i data-toggle="expanded" class="toggle-icon ft-toggle-right"></i></a><a id="sidebarClose" href="javascript:;" class="nav-close d-block d-md-block d-lg-none d-xl-none"><i class="ft-x"></i></a></div>
        </div>
        <!-- Sidebar Header Ends-->
        <!-- / main menu header-->
        <!-- main menu content-->
        <div class="sidebar-content">
          <div class="nav-container">
            <ul id="main-menu-navigation" data-menu="menu-navigation" data-scroll-to-active="true" class="navigation navigation-main">
                  @if(session('privilege')[1]["browse"] ?? 0)
              <li class=" home-nav nav-item"><a href="{{ url('/') }}"><i class="ft-home"></i><span data-i18n="" class="menu-title">Dashboard</span></a>               
              </li>
                  @endif
                  @if(session('privilege')[2]["browse"] ?? 0)
              <li class=" nav-item"><a href="{{ url('/spb') }}"><i class="ft-map"></i><span data-i18n="" class="menu-title">SPB</span></a>
              </li>
                  @endif
                  @if(session('privilege')[3]["browse"] ?? 0)
              <li class=" nav-item"><a href="{{ url('/manifest') }}"><i class="ft-layers"></i><span data-i18n="" class="menu-title">Manifest</span></a>
              </li>
                  @endif
              <li class="has-sub nav-item" id="masterdata"><a href="#"><i class="ft-aperture"></i><span data-i18n="" class="menu-title">Master Data</span></a>
                <ul class="menu-content">
                  @if(session('privilege')[4]["browse"] ?? 0)
                  <li><a href="{{ url('/vehicle') }}" class="menu-item"><i class="ft-shopping-cart"></i>Armada</a>
                  </li>
                  @endif
                  @if(session('privilege')[5]["browse"] ?? 0)
                  <li><a href="{{ url('/branch') }}" class="menu-item"><i class="ft-share-2"></i>Cabang</a>
                  </li>
                  @endif
                  @if(session('privilege')[6]["browse"] ?? 0)
                  <li><a href="{{ url('/customer') }}" class="menu-item"><i class="ft-briefcase"></i>Pelanggan</a>
                  </li>
                  @endif
                </ul>
              </li>
              <li class="has-sub nav-item" id="usermgt"><a href="#"><i class="ft-user-check"></i><span data-i18n="" class="menu-title">User Management</span></a>
                <ul class="menu-content">
                  @if(session('privilege')[7]["browse"] ?? 0)
                  <li><a href="{{ url('/user') }}" class="menu-item"><i class="ft-user"></i>User</a>
                  </li>
                  @endif
                  @if(session('privilege')[8]["browse"] ?? 0)
                  <li><a href="{{ url('/role') }}" class="menu-item"><i class="ft-users"></i>Role</a>
                  </li>
                  @endif
                </ul>
              </li>
            </ul>
          </div>
        </div>
        <!-- main menu content-->
        <div class="sidebar-background"></div>
        <!-- main menu footer-->
        <!-- include includes/menu-footer-->
        <!-- main menu footer-->
      </div>
      <!-- / main menu-->


      <!-- Navbar (Header) Starts-->
      <nav class="navbar navbar-expand-lg navbar-light bg-faded header-navbar">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" data-toggle="collapse" class="navbar-toggle d-lg-none float-left"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><span class="d-lg-none navbar-right navbar-collapse-toggle"><a aria-controls="navbarSupportedContent" href="javascript:;" class="open-navbar-container black"><i class="ft-more-vertical"></i></a></span>
          </div>
          <div class="navbar-container">
            <div id="navbarSupportedContent" class="collapse navbar-collapse">
              <ul class="navbar-nav">
                <li class="nav-item mr-2 d-none d-lg-block"><a id="navbar-fullscreen" href="javascript:;" class="nav-link apptogglefullscreen"><i class="ft-maximize font-medium-3 blue-grey darken-4"></i>
                    <p class="d-none">fullscreen</p></a></li>
                <li class="dropdown nav-item"><a id="dropdownBasic2" href="#" data-toggle="dropdown" class="nav-link position-relative dropdown-toggle"><i class="ft-bell font-medium-3 blue-grey darken-4"></i><span class="notification badge badge-pill badge-danger">4</span>
                    <p class="d-none">Notifications</p></a>
                  <div class="notification-dropdown dropdown-menu dropdown-menu-right">
                    <div class="noti-list"><a class="dropdown-item noti-container py-3 border-bottom border-bottom-blue-grey border-bottom-lighten-4"><i class="ft-bell info float-left d-block font-large-1 mt-1 mr-2"></i><span class="noti-wrapper"><span class="noti-title line-height-1 d-block text-bold-400 info">New Order Received</span><span class="noti-text">Lorem ipsum dolor sit ametitaque in, et!</span></span></a><a class="dropdown-item noti-container py-3 border-bottom border-bottom-blue-grey border-bottom-lighten-4"><i class="ft-bell warning float-left d-block font-large-1 mt-1 mr-2"></i><span class="noti-wrapper"><span class="noti-title line-height-1 d-block text-bold-400 warning">New User Registered</span><span class="noti-text">Lorem ipsum dolor sit ametitaque in </span></span></a><a class="dropdown-item noti-container py-3 border-bottom border-bottom-blue-grey border-bottom-lighten-4"><i class="ft-bell danger float-left d-block font-large-1 mt-1 mr-2"></i><span class="noti-wrapper"><span class="noti-title line-height-1 d-block text-bold-400 danger">New Order Received</span><span class="noti-text">Lorem ipsum dolor sit ametest?</span></span></a><a class="dropdown-item noti-container py-3"><i class="ft-bell success float-left d-block font-large-1 mt-1 mr-2"></i><span class="noti-wrapper"><span class="noti-title line-height-1 d-block text-bold-400 success">New User Registered</span><span class="noti-text">Lorem ipsum dolor sit ametnatus aut.</span></span></a></div><a class="noti-footer primary text-center d-block border-top border-top-blue-grey border-top-lighten-4 text-bold-400 py-1">Read All Notifications</a>
                  </div>
                </li>
                <li class="dropdown nav-item"><a id="dropdownBasic3" href="#" data-toggle="dropdown" class="nav-link position-relative dropdown-toggle"><i class="ft-user font-medium-3 blue-grey darken-4"></i>
                    <p class="d-none">User Settings</p></a>
                  <div ngbdropdownmenu="" aria-labelledby="dropdownBasic3" class="dropdown-menu text-left dropdown-menu-right">
                  @if (Auth::check()) 
                  <a href="#" class="dropdown-item py-1">Hi, <span>{{ Auth::user()->name }}</span></a>
                  @endif
                  <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        <i class="ft-power mr-2"></i>{{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>
      <!-- Navbar (Header) Ends-->

      <div class="main-panel">
        <!-- BEGIN : Main Content-->
        @yield('content')
        <!-- END : End Main Content-->

        <!-- BEGIN : Footer-->
        <footer class="footer footer-static footer-light">
          <p class="pull-left clearfix text-muted text-sm-center px-2"><span>Copyright  &copy; 2019 PT Nusantara Jaya Ekspress, All rights reserved. </span></p>
          <small class="pull-right clearfix text-muted text-sm-center px-2"><span>Powered by <a href="http://arfianagus.com/" target="_blank">arfianagus.com</a></span></small>
        </footer>
        <!-- End : Footer-->

      </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <!-- BEGIN VENDOR JS-->
    <script src="{{ asset('/') }}app-assets/vendors/js/core/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="{{ asset('/') }}app-assets/vendors/js/core/popper.min.js" type="text/javascript"></script>
    <script src="{{ asset('/') }}app-assets/vendors/js/core/bootstrap.min.js" type="text/javascript"></script>
    <script src="{{ asset('/') }}app-assets/vendors/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
    <script src="{{ asset('/') }}app-assets/vendors/js/prism.min.js" type="text/javascript"></script>
    <script src="{{ asset('/') }}app-assets/vendors/js/jquery.matchHeight-min.js" type="text/javascript"></script>
    <script src="{{ asset('/') }}app-assets/vendors/js/screenfull.min.js" type="text/javascript"></script>
    <script src="{{ asset('/') }}app-assets/vendors/js/pace/pace.min.js" type="text/javascript"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN APEX JS-->
    <script src="{{ asset('/') }}app-assets/js/app-sidebar.js" type="text/javascript"></script>
    <script src="{{ asset('/') }}app-assets/js/notification-sidebar.js" type="text/javascript"></script>
    <script src="{{ asset('/') }}app-assets/js/customizer.js" type="text/javascript"></script>
    <!-- END APEX JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <script>
      $(document).ready(function(){
          var current = location.pathname;
          if(current!=='/'){
            $('#main-menu-navigation li a').each(function(){
                var $this = $(this);
                if($this.attr('href') !== '{{ url('/') }}'){
                  if(current.indexOf($this.attr('href').replace('{{ url('/') }}','')) !== -1){
                    $this.parent('li').parent('ul').parent('li.has-sub').addClass('open');
                    $this.parent('li').addClass('active');
                  }
                }
            })
          }else{
            $('.home-nav').addClass('active');
          }
      })
    </script>
    <script>
      $(document).ready(function(){
        if(!$("#masterdata>ul").children().length){
          $("#masterdata").hide();
        }
        if(!$("#usermgt>ul").children().length){
          $("#usermgt").hide();
        }
      });
    </script>
    @yield('pagejs')
    <!-- END PAGE LEVEL JS-->
    @yield('modal')
  </body>
</html>
