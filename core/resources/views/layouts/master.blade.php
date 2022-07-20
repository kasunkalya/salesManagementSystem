
<!--
##############################################################
#     Admin Panel - Laravel 5.1                              #
#                                                            #
#     Author - Kasun kalya <kasun.kalya@gmail.com>    #
#     Version 1.0                                            #
#     Copyright Sammy 2015                                   #
##############################################################
-->

<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title>Admin Panel | @yield('title')</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" href="/favicon.ico">

  <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

  <!-- page level plugin styles -->
  <link rel="stylesheet" href="{{asset('assets/support/vendor/chosen_v1.4.0/chosen.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/support/vendor/checkbo/src/0.1.4/css/checkBo.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/support/vendor/sweetalert/lib/sweet-alert.css')}}">
  <link rel="stylesheet" href="{{asset('assets/support/vendor/datatables/media/css/jquery.dataTables.css')}}">
  <!-- /page level plugin styles -->

  <!-- build:css({.tmp,app}) styles/app.min.css -->
  <link rel="stylesheet" href="{{asset('assets/support/vendor/bootstrap/dist/css/bootstrap.css')}}">
  <link rel="stylesheet" href="{{asset('assets/support/vendor/perfect-scrollbar/css/perfect-scrollbar.css')}}">
  <link rel="stylesheet" href="{{asset('assets/support/styles/roboto.css')}}">
  <link rel="stylesheet" href="{{asset('assets/support/styles/font-awesome.css')}}">
  <link rel="stylesheet" href="{{asset('assets/support/styles/panel.css')}}">
  <link rel="stylesheet" href="{{asset('assets/support/styles/feather.css')}}">
  <link rel="stylesheet" href="{{asset('assets/support/styles/animate.css')}}">
  <link rel="stylesheet" href="{{asset('assets/support/styles/urban.css')}}">
  <link rel="stylesheet" href="{{asset('assets/support/styles/urban.skins.css')}}">
  <link rel="stylesheet" href="{{asset('assets/support/vendor/jquery.multiselect/css/multi-select.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
  <link rel="stylesheet" type="text/css" media="screen" href="http://cdnjs.cloudflare.com/ajax/libs/fancybox/1.3.4/jquery.fancybox-1.3.4.css"/>
  <!-- endbuild -->
  <style type="text/css">
    .vertical-align-middle{
      vertical-align:middle !important;
    }

    .datatable a{
      font-size: 16px;
    }

    .datatable a:hover{
      font-size: 16px;
      color: #3B3B3B;
      transition: all .3s;
      -webkit-transition: all .3s;
      -moz-transition: all .3s;
    }

    .datatable a.blue{
      color: #1E88E5;
    }

    .datatable a.blue:hover{
      color: #0D47A1;
    }

    .datatable a.red{
      color: #E53935;
    }

    .datatable a.red:hover{
      color: #B71C1C;
    }

    .datatable a.green{
      color: #00C853;
    }

    .datatable a.green:hover{
      color: #2E7D32;
    }

    .datatable a.disabled{
      color: #565656;
    }

    .table.table-condensed > thead > tr > th,
    .table.table-condensed > tbody > tr > th,
    .table.table-condensed > tfoot > tr > th,
    .table.table-condensed > thead > tr > td,
    .table.table-condensed > tbody > tr > td,
    .table.table-condensed > tfoot > tr > td {
      padding: 6px 10px;
    }

    .sweet-alert{
      border-radius: 0;
    }

    .sweet-alert button{
      border-radius: 0;
    }

    .sweet-alert button.cancel{
      background-color: #E05A5A;
      transition: all .4s;
      -webkit-transition: all .4s;
      -moz-transition: all .4s;
    }

    .sweet-alert button.cancel:hover{
      background-color: #CC4D4D;
    }

    .sidebar-panel {
      background-color: #B1B1B1;
    }

    .sidebar-panel > .brand {
      background-color: #B1B1B1;
    }

    .body{
      font-size: 16px;
    }

    .main-panel > .header {
      background-color: #B1B1B1;
    }

    .main-panel > .header .navbar-text {
      color: #FFFFFF;
    }

    .main-panel > .header .nav > li > a {
      color: #FFFFFF;
    }

    .border-danger {
      border-color: #D96557;
    }

    .bg-danger {
      color: white;
      background-color: #D96557;
    }

    .breadcrumb > li{
      display: inline-block;
      color: #292929;
    }

    .breadcrumb > li:hover{
      color: #D96557;
    }

    .main-panel > .header .navbar-nav .dropdown-menu {
      margin-top: 2px;
      padding: 0;
      border-color: rgba(0, 0, 0, 0.1);
      border-top: 0;
      background-color: white;
      -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
      -moz-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
      -webkit-border-radius: 0;
      -moz-border-radius: 0;
      border-radius: 0;
      width: 100%;
    }

    b, strong {
      font-weight: normal;
    }

    .breadcrumb > li + li:before{
      color: #4A4A4A;
    }

    .bootstrap-tagsinput{
      display: block;
      width: 100%;
      padding: 6px 12px;
      line-height: 1.42857143;
      color: #555;
      background-color: #fff;
      background-image: none;
      border: 1px solid #ccc;
      border-color: #e4e4e4;
      font-weight: 400;
      font-size: 13px;
      -webkit-font-smoothing: antialiased;
      -webkit-border-radius: 2px;
      -moz-border-radius: 2px;
      border-radius: 2px;
      -webkit-transition: border 300ms linear;
      -moz-transition: border 300ms linear;
      -o-transition: border 300ms linear;
      transition: border 300ms linear;
      -webkit-box-shadow: none;
      -moz-box-shadow: none;
      box-shadow: none;
    }

    .bootstrap-tagsinput .tag{
      padding: 3px 6px 4px;
      font-size: 14px;
      font-weight: 100;
      line-height: 2.2;
      border-radius: 2px;
    }

    .sidebar-panel > nav li ul li a{
   		padding: 10px 25px 10px 50px;
    }

    .sidebar-panel > nav > ul > li a{
    	padding: 13px 20px;
    }

    .sidebar-panel > nav ul > li > a .fa{
    	width: 25px;
    }
  </style>

  @yield('css')

</head>

<body>

  <div class="app layout-fixed-header">

    <!-- sidebar panel -->
    <div class="sidebar-panel offscreen-left">

      <div class="brand">

        <!-- logo -->
        <div class="brand-logo" style="margin-top: 0px;font-size: 35px;color: #fff;font-family: 'Source Sans Pro', sans-serif;
    margin-left: 0%;">
          <img src="{{asset('assets/support/images/logo-dark1.png')}}" style="width: 55%;
    height: 1%; margin: 5px;" />
        </div>
        <!-- /logo -->

        <!-- toggle small sidebar menu -->
        {{--<a href="javascript:;" class="toggle-sidebar hidden-xs hamburger-icon v3" data-toggle="layout-small-menu">--}}
          {{--<span></span>--}}
          {{--<span></span>--}}
          {{--<span></span>--}}
          {{--<span></span>--}}
        {{--</a>--}}
        <!-- /toggle small sidebar menu -->

      </div>

      <!-- main navigation -->
      <nav role="navigation">
        @include('includes.menu')
      </nav>
      <!-- /main navigation -->

    </div>
    <!-- /sidebar panel -->

    <!-- content panel -->
    <div class="main-panel">

      <!-- top header -->
      <header class="header navbar">

        <div class="brand visible-xs">
          <!-- toggle offscreen menu -->
          <div class="toggle-offscreen">
            <a href="#" class="hamburger-icon visible-xs" data-toggle="offscreen" data-move="ltr">
              <span></span>
              <span></span>
              <span></span>
            </a>
          </div>
          <!-- /toggle offscreen menu -->

          <!-- logo -->
          <div class="brand-logo">
            <img src="{{asset('assets/support/images/logo-dark1.png')}}" height="15" alt="" style="width: 100%;height:50%;margin-top: -5%;">
          </div>
          <!-- /logo -->
        </div>

        <ul class="nav navbar-nav hidden-xs">
          <li>
            <p class="navbar-text">
              @yield('current_title')
            </p>
          </li>
        </ul>

        <ul class="nav navbar-nav navbar-right hidden-xs">
           @include('includes.user')
        </ul>
      </header>
      <!-- /top header -->

      <!-- main area -->
      <div class="main-content">
        @yield('content')
      </div>
      <!-- /main area -->
    </div>
    <!-- /content panel -->

    <!-- bottom footer -->
    <footer class="content-footer">

      <nav class="footer-right">
        <ul class="nav">
          <li>
            <a href="javascript:;" class="scroll-up">
              <i class="fa fa-angle-up"></i>
            </a>
          </li>
        </ul>
      </nav>

      <nav class="footer-left">
        <ul class="nav">
          <li>
            <p class="text-muted">© 2012-<?php echo date('Y'); ?>  | Design by Kasun Kalya | All Rights Reserved. </p>
          </li>
          <li>
            <a href="javascript:;">
                Privacy Policy
            </a>
          </li>
        </ul>
      </nav>

    </footer>
    <!-- /bottom footer -->
  </div>

  <script src="{{asset('assets/support/scripts/extentions/modernizr.js')}}"></script>
  <script src="{{asset('assets/support/vendor/jquery/dist/jquery-2.0.1.js')}}"></script>
  <script src="{{asset('assets/support/vendor/bootstrap/dist/js/bootstrap.js')}}"></script>
  <script src="{{asset('assets/support/vendor/jquery.easing/jquery.easing.js')}}"></script>
  <script src="{{asset('assets/support/vendor/fastclick/lib/fastclick.js')}}"></script>
  <script src="{{asset('assets/support/vendor/onScreen/jquery.onscreen.js')}}"></script>
  <script src="{{asset('assets/support/vendor/jquery-countTo/jquery.countTo.js')}}"></script>
  <script src="{{asset('assets/support/vendor/perfect-scrollbar/js/perfect-scrollbar.jquery.js')}}"></script>
  <script src="{{asset('assets/support/scripts/ui/accordion.js')}}"></script>
  <script src="{{asset('assets/support/scripts/ui/animate.js')}}"></script>
  <script src="{{asset('assets/support/scripts/ui/link-transition.js')}}"></script>
  <script src="{{asset('assets/support/scripts/ui/panel-controls.js')}}"></script>
  <script src="{{asset('assets/support/scripts/ui/preloader.js')}}"></script>
  <script src="{{asset('assets/support/scripts/ui/toggle.js')}}"></script>
  <script src="{{asset('assets/support/scripts/urban-constants.js')}}"></script>
  <script src="{{asset('assets/support/scripts/extentions/lib.js')}}"></script>
  <script src="{{asset('assets/support/vendor/jquery.multiselect/js/jquery.multi-select.js')}}"></script>
  <!-- endbuild -->
  <script src="{{asset('assets/support/vendor/chosen_v1.4.0/chosen.jquery.min.js')}}"></script>
  <script src="{{asset('assets/support/vendor/checkbo/src/0.1.4/js/checkBo.min.js')}}"></script>
  <script src="{{asset('assets/support/vendor/sweetalert/lib/sweet-alert.min.js')}}"></script>
  <script src="{{asset('assets/support/vendor/datatables/media/js/jquery.dataTables.js')}}"></script>
  <script src="{{asset('assets/support/scripts/extentions/bootstrap-datatables.js')}}"></script>
  <script src="{{asset('assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.min.js')}}"></script>
  <script src="{{asset('assets/support/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
  <script src="{{asset('assets/vendor/typehead/typehead.js')}}"></script>
  <script src="{{asset('assets/angular/vendor/angular/angular.min.js')}}"></script>
  <script src="{{asset('assets/angular/vendor/api-check-7.5.5/api-check.min.js')}}"></script>
  <script src="{{asset('assets/angular/vendor/angular-formly-7.3.3/formly.min.js')}}"></script>
  <script src="{{asset('assets/angular/vendor/angular-bootstrap/ui-bootstrap-0.14.3.min.js')}}"></script>
  <!-- Custom DataTable Generator -->
  <script src="{{asset('assets/support/scripts/custom/custom_functions.js')}}"></script>

  <script type="text/javascript">
    $(document).ready(function(){
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $('form').checkBo();
      $('.chosen').chosen();
      @if(session('success'))
        sweetAlert('{{session('success.title')}}', '{{session('success.message')}}',0);
      @elseif(session('error'))
        sweetAlert('{{session('error.title')}}','{{session('error.message')}}',2);
      @elseif(session('warning'))
        sweetAlert('{{session('warning.title')}}','{{session('warning.message')}}',3);
      @elseif(session('info'))
        sweetAlert('{{session('info.title')}}','{{session('info.message')}}',1);
      @endif
    });
  </script>

  @yield('js')
</body>

</html>

