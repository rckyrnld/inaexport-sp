<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8" />
  <title>Forget Password</title>
  <meta name="description" content="Responsive, Bootstrap, BS4" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- for ios 7 style, multi-resolution icon of 152x152 -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-barstyle" content="black-translucent">
  <link rel="apple-touch-icon" href="../assets/images/logo.svg">
  <meta name="apple-mobile-web-app-title" content="Flatkit">
  <!-- for Chrome on Android, multi-resolution icon of 196x196 -->
  <meta name="mobile-web-app-capable" content="yes">
  <link rel="shortcut icon" sizes="196x196" href="../assets/images/logo.svg">
  
  <!-- style -->

  <link rel="stylesheet" href="{{url('assets')}}/libs/font-awesome/css/font-awesome.min.css" type="text/css" />

  <!-- build:css ../assets/css/app.min.css -->
  <link rel="stylesheet" href="{{url('assets')}}/libs/bootstrap/dist/css/bootstrap.min.css" type="text/css" />
  <link rel="stylesheet" href="{{url('assets')}}/assets/css/app.css" type="text/css" />
  <link rel="stylesheet" href="{{url('assets')}}/assets/css/style.css" type="text/css" />
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<style>
.nav-tabs {
    border-bottom: 2px solid #ddd;
}
.nav-tabs>li {
    float: left;
    margin-bottom: -1px;
}
.nav>li {
    position: relative;
    display: block;
}
.nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover {
    background-color: #5cb85c;
    color: white;
    background-image: linear-gradient(to bottom right, #51d0a8,#065784);
    
}
.nav-tabs>li>a {
    margin-right: 2px;
    line-height: 1.42857143;
    border: 1px solid transparent;
    border-radius: 4px 4px 0 0;
}
.nav>li>a {
    position: relative;
    display: block;
    padding: 10px 15px;
}  
.nav>li>a:focus, .nav>li>a:hover {
    text-decoration: none;
    background-color: transparent!important;
}
</style>
  <!-- endbuild -->
</head>
<body>


<div class="d-flex flex-column flex" style="background-color:  #2e899e  ; color: #ffffff">
	<div class="light bg pos-rlt box-shadow" style="padding-left:10px; padding-right:10px; padding-top:10px; padding-bottom:10px;    background-color: #2791a6 ; color: #ffffff">
    <div class="mx-auto">
	<table border="0" width="100%">
	<tr>
	<td width="30%" style="font-size:13px;padding-left:10px"><img height="30px" src="{{url('assets')}}/assets/images/logo.jpg" alt="." ><b>&nbsp;&nbsp;&nbsp; Ministry Of Trade</b></td>
	<td width="30%"><!-- <center><span class="hidden-folded d-inline"><H5>Form Registrasi Pembeli Baru</H5></span></center> --></td>
	<td width="40%" align="right" style="padding-right:10px;">
	<a href="{{url('registrasi_pembeli')}}"><font color="white"><i class="fa fa-user"></i> @lang("login.lbl2")</font></a> &nbsp;&nbsp;&nbsp;<a href="{{url('registrasi_penjual')}}"><font color="white"><i class="fa fa-user"></i> @lang("login.lbl1")</font></a> &nbsp;&nbsp;&nbsp;
	<a href="{{ url('locale/en') }}"><img width="20px" height="15px" src="{{asset('negara/en.png')}}"></a>&nbsp;
	<a href="{{ url('locale/in') }}"><img width="20px" height="15px" src="{{asset('negara/in.png')}}"></a>&nbsp;
	<a href="{{ url('locale/ch') }}"><img width="20px" height="15px" src="{{asset('negara/ch.png')}}"></a>&nbsp;&nbsp;&nbsp;
	<a href="{{url('login')}}"><font color="white"><i class="fa fa-sign-in"></i> @lang("login.lbl3")</font></a>
	
	
	</td>
	</tr>
	</table>
	
      
       
     
    </div>
  </div>
  <div id="content-body" style="background-color: #2e899e ; color: #ffffff" >
    <div class="py-5 text-center w-100">
	<!--<img height="70px" src="{{url('assets')}}/assets/images/logo.jpg" alt="." ><br><br>--><br>
	<h4><b>@lang("login.title2")</b></h4><br>
      <div class="mx-auto" style="width:450px;background: rgba(15, 12, 12, 0.3); border-radius: 10px;">
	  <br>
	  <!-- <h5>LOGIN</h5> -->
	  <div class="wrap-login100" style="padding-left : 30px; padding-right : 30px;">
	  @if (isset($errors) && count($errors))
     
            There were {{count($errors->all())}} Error(s)
                        <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }} </li>
                    @endforeach
                </ul>
                
        @endif
       
	   <b>FORM FORGET PASSWORD</b>
	   <style>
	   .custom-select, .custom-file-control, .custom-file-control:before, select.form-control:not([size]):not([multiple]):not(.form-control-lg):not(.form-control-sm) {
    height: calc(1.28rem + 1.75rem + 2px)!important;
}
	   </style>
         <form class="form-horizontal" method="POST" action="{{ url('resetpass') }}">
           {{ csrf_field() }}
		   <br>
		
		 <div class="form-group">
            <select class="form-control" id="id_role" name="id_role" style="color:black;" >
				<option value="1">Exporter/Importer</option>
				<option value="2">Perwakilan</option>
			</select>
        </div>
		
		<div class="form-group">
               <input id="email" type="email" placeholder="Email" class="form-control" name="email" style="color: #000000" value="" required="" autofocus="">

        </div>
		
		<center><button type="submit" class="btn primary">Process</button></center>
		   </form>
		<br>
       
      </div>
	  
	  <br>
	  
        <div class="px-3">
         {{--  <div>
            <a href="#" class="btn btn-block indigo text-white mb-2">
              <i class="fa fa-facebook float-left"></i>
              Sign in with Facebook
            </a>
            <a href="#" class="btn btn-block red text-white">
              <i class="fa fa-google-plus float-left"></i>
              Sign in with Google+
            </a>
          </div> --}}
          {{-- <div class="my-3 text-sm">
            OR
          </div> --}}
         
		  
          <div class="my-4">
           <!-- <a href="{{ route('password.request') }}" class="text-primary _600">Forgot password?</a> -->
          </div>
          <div>
           <!-- Do not have an account? 
            <a href="{{url('register')}}" class="text-primary _600">Sign up</a> -->
          </div>
        </div>
		
      </div>
    </div>
  </div>
</div>


<!-- ############ SWITHCHER START-->
<div id="setting">
  <div class="setting dark-white rounded-bottom" id="theme">
    <a href="#" data-toggle-class="active" data-target="#theme" class="dark-white toggle">
      <i class="fa fa-gear text-primary fa-spin"></i>
    </a>
    <div class="box-header">
      <a href="https://themeforest.net/item/apply-web-application-admin-template/21072584?ref=flatfull" class="btn btn-xs rounded danger float-right">BUY</a>
      <strong>Theme Switcher</strong>
    </div>
    <div class="box-divider"></div>
    <div class="box-body">
      <p id="settingLayout">
        <label class="md-check my-1 d-block">
          <input type="checkbox" name="fixedAside">
          <i></i>
          <span>Fixed Aside</span>
        </label>
        <label class="md-check my-1 d-block">
          <input type="checkbox" name="fixedContent">
          <i></i>
          <span>Fixed Content</span>
        </label>
        <label class="md-check my-1 d-block">
          <input type="checkbox" name="folded">
          <i></i>
          <span>Folded Aside</span>
        </label>
        <label class="md-check my-1 d-block">
          <input type="checkbox" name="container">
          <i></i>
          <span>Boxed Layout</span>
        </label>
        <label class="md-check my-1 d-block">
          <input type="checkbox" name="ajax">
          <i></i>
          <span>Ajax load page</span>
        </label>
        <label class="pointer my-1 d-block" data-toggle="fullscreen" data-plugin="screenfull" data-target="fullscreen">
          <span class="ml-1 mr-2 auto">
            <i class="fa fa-expand d-inline"></i>
            <i class="fa fa-compress d-none"></i>
          </span>
          <span>Fullscreen mode</span>
        </label>
      </p>
      <p>Colors:</p>
      <p>
        <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
          <input type="radio" name="theme" value="primary">
          <i class="primary"></i>
        </label>
        <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
          <input type="radio" name="theme" value="accent">
          <i class="accent"></i>
        </label>
        <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
          <input type="radio" name="theme" value="warn">
          <i class="warn"></i>
        </label>
        <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
          <input type="radio" name="theme" value="info">
          <i class="info"></i>
        </label>
        <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
          <input type="radio" name="theme" value="success">
          <i class="success"></i>
        </label>
        <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
          <input type="radio" name="theme" value="warning">
          <i class="warning"></i>
        </label>
        <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
          <input type="radio" name="theme" value="danger">
          <i class="danger"></i>
        </label>
      </p>
      <div class="row no-gutters">
        <div class="col">
          <p>Brand</p>
          <p>
            <label class="radio radio-inline m-0 mr-1 ui-check">
              <input type="radio" name="brand" value="dark-white">
              <i class="light"></i>
            </label>
            <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
              <input type="radio" name="brand" value="dark">
              <i class="dark"></i>
            </label>
          </p>
        </div>
        <div class="col mx-2">
          <p>Aside</p>
          <p>
            <label class="radio radio-inline m-0 mr-1 ui-check">
              <input type="radio" name="aside" value="white">
              <i class="light"></i>
            </label>
            <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
              <input type="radio" name="aside" value="dark">
              <i class="dark"></i>
            </label>
          </p>
        </div>
        <div class="col">
          <p>Themes</p>
          <div class="clearfix">
            <label class="radio radio-inline ui-check">
              <input type="radio" name="bg" value="">
              <i class="light"></i>
            </label>
            <label class="radio radio-inline ui-check ui-check-color">
              <input type="radio" name="bg" value="dark">
              <i class="dark"></i>
            </label>
          </div>
        </div>
      </div>
      <p>Demos</p>
      <div class="text-md">
        <a href="dashboard.html?folded=false&amp;bg=&amp;aside=dark&amp;brand=dark" class="no-ajax badge light">0</a>
        <a href="dashboard.1.html?folded=false&amp;bg=&amp;aside=dark&amp;brand=dark-white" class="no-ajax badge light">1</a>
        <a href="dashboard.2.html?folded=false&amp;bg=&amp;aside=dark&amp;brand=white" class="no-ajax badge light">2</a>
        <a href="dashboard.3.html?folded=false&amp;bg=&amp;aside=white&amp;brand=white" class="no-ajax badge light">3</a>
        <a href="dashboard.4.html?folded=true&amp;bg=&amp;aside=dark" class="no-ajax badge light">4</a>
        <a href="dashboard.5.html?folded=true&amp;bg=&amp;aside=dark&amp;brand=dark" class="no-ajax badge light">5</a>
        <a href="dashboard.6.html?folded=false&amp;bg=&amp;aside=white&amp;brand=white" class="no-ajax badge light">6</a>
        <a href="dashboard.7.html?folded=false&amp;bg=&amp;aside=dark&amp;brand=dark" class="no-ajax badge light">7</a>
        <a href="dashboard.8.html?folded=false&amp;bg=&amp;aside=white&amp;brand=white" class="no-ajax badge light">8</a>
        <a href="rtl.html?folded&amp;bg=" class="no-ajax badge light">RTL</a>
      </div>
    </div>
  </div>
</div>
<!-- ############ SWITHCHER END-->

<!-- build:js scripts/app.min.js -->
<!-- jQuery -->
  <script src="{{url('assets')}}/libs/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
  <script src="{{url('assets')}}/libs/popper.js/dist/umd/popper.min.js"></script>
  <script src="{{url('assets')}}/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- core -->
  <script src="{{url('assets')}}/libs/pace-progress/pace.min.js"></script>
  <script src="{{url('assets')}}/libs/pjax/pjax.js"></script>

  <script src="{{url('assets')}}/html/scripts/lazyload.config.js"></script>
  <script src="{{url('assets')}}/html/scripts/lazyload.js"></script>
  <script src="{{url('assets')}}/html/scripts/plugin.js"></script>
  <script src="{{url('assets')}}/html/scripts/nav.js"></script>
  <script src="{{url('assets')}}/html/scripts/scrollto.js"></script>
  <script src="{{url('assets')}}/html/scripts/toggleclass.js"></script>
  <script src="{{url('assets')}}/html/scripts/theme.js"></script>
  <script src="{{url('assets')}}/html/scripts/ajax.js"></script>
  <script src="{{url('assets')}}/html/scripts/app.js"></script>
  <script>
  
  </script>
<!-- endbuild -->
</body>
</html>
