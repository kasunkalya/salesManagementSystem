<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title>Admin Panel - User Login</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width">
  <link rel="shortcut icon" href="/favicon.ico">

  <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

  <!-- page level plugin styles -->
  <!-- /page level plugin styles -->

  <!-- build:css({.tmp,app}) styles/app.min.css -->
  <link rel="stylesheet" href="{{asset('assets/support/vendor/bootstrap/dist/css/bootstrap.css')}}">
  <link rel="stylesheet" href="{{asset('assets/support/vendor/perfect-scrollbar/css/perfect-scrollbar.css')}}">
  <link rel="stylesheet" href="{{asset('assets/support/vendor/checkbo/src/0.1.4/css/checkBo.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/support/styles/roboto.css')}}">
  <link rel="stylesheet" href="{{asset('assets/support/styles/font-awesome.css')}}">
  <link rel="stylesheet" href="{{asset('assets/support/styles/panel.css')}}">
  <link rel="stylesheet" href="{{asset('assets/support/styles/feather.css')}}">
  <link rel="stylesheet" href="{{asset('assets/support/styles/animate.css')}}">
  <link rel="stylesheet" href="{{asset('assets/support/styles/urban.css')}}">
  <link rel="stylesheet" href="{{asset('assets/support/styles/urban.skins.css')}}">

<style type="text/css">
  
  .form-layout {
      margin: 0 auto;
      padding: 15px;
      border: 1px solid rgb(99, 98, 98);
      background: rgba(0, 0, 0, 0.39);
  }

  p {
    color: rgba(255, 255, 255, 0.5);
    font-family:'Raleway' sans-serif;
    font-size: 14px;
}

.bg-white {
    color: #fff;
    font-family:'Raleway'sans-serif;
    font-size: 14px;
    
}

.center-wrapper {
  display: table;
  width: 100%;
  height: 100%;
  position: relative;
/*  background:url(http://localhost/himablog/core/resources/assets/back.jpg)  no-repeat center center fixed;*/
}

</style>
</head>

<body>

  <div class="app layout-fixed-header bg-white usersession">
    <div class="full-height">
      <div class="center-wrapper">
        <div class="center-content">
          <div class="row no-margin">
            <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
              <form role="form" action="{{URL::to('user/login')}}" class="form-layout checkbo" method="post">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="text-center mb15">
                  <img src="{{asset('assets/support/images/logo-dark1.png')}}" style="width: 54%;
    height: 50%;" />
                </div>
                <p class="text-center mb30">Welcome to Customer Management System. <br>Please sign in to your account</p>
                @if($errors->has('login'))
                  <div class="alert alert-danger">
                    Oh snap! {{$errors->first('login')}}
                  </div>
                @endif
                <div class="form-inputs">
                  <input type="text" name="username" class="form-control input-lg" placeholder="Username" autocomplete="off" value="{{{Input::old('username')}}}" @if(empty(Input::old('username'))) autofocus @endif>
                  <input type="password" name="password" class="form-control input-lg" placeholder="Password" @if(!empty(Input::old('username'))) autofocus @endif>
                </div>
                <label class="cb-checkbox">
                  <input type="checkbox" name="remember" value="{{Input::old('remember')}}" />Keep me signed in
                </label>
                <button class="btn btn-success btn-block btn-lg mb15" type="submit">
                  <span>SIGN IN</span>
                </button>
                {{--<p>--}}
                  {{--<a href="#" >Forgot your password?</a>--}}
                {{--</p>--}}
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- build:js({.tmp,app}) scripts/app.min.js -->
  <script src="{{asset('assets/support/scripts/extentions/modernizr.js')}}"></script>
  <script src="{{asset('assets/support/vendor/jquery/dist/jquery.js')}}"></script>
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

  <script src="{{asset('assets/support/vendor/chosen_v1.4.0/chosen.jquery.min.js')}}"></script>
  <script src="{{asset('assets/support/vendor/checkbo/src/0.1.4/js/checkBo.min.js')}}"></script>

  <script type="text/javascript">
    $(document).ready(function(){
      $('.checkbo').checkBo();
    });
  </script>
  <!-- endbuild -->
</body>

</html>
