<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8" />
  <title>ITDP Kementerian Perdagangan</title>
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


<div class="d-flex flex-column flex" style="background-color:  #c5e1f8  ; color: #ffffff">
	<div class="light bg pos-rlt box-shadow" style="padding-left:10px; padding-right:10px; padding-top:10px; padding-bottom:10px;    background-color: #2791a6 ; color: #ffffff">
    <div class="mx-auto">
	<table border="0" width="100%" style="font-size: 10px!important;">
	<tr>
	<td width="30%" style="font-size:13px;padding-left:10px"><!-- <img height="30px" src="{{url('assets')}}/assets/images/logo.jpg" alt="." ><b>&nbsp;&nbsp;&nbsp; Ministry Of Trade</b> --></td>
	<td width="60%"><!-- <center><span class="hidden-folded d-inline"><H5>Form Registrasi Pembeli Baru</H5></span></center> --></td>
	<td width="10%" align="right" style="padding-right:10px;">
	<!-- <a href="{{url('registrasi_pembeli')}}"><font color="white"><i class="fa fa-user"></i> @lang("login.lbl2")</font></a> &nbsp;&nbsp;&nbsp;<a href="{{url('registrasi_penjual')}}"><font color="white"><i class="fa fa-user"></i> @lang("login.lbl1")</font></a> &nbsp;&nbsp;&nbsp;
	<a href="{{ url('locale/en') }}"><img width="20px" height="15px" src="{{asset('negara/en.png')}}"></a>&nbsp;
	<a href="{{ url('locale/in') }}"><img width="20px" height="15px" src="{{asset('negara/in.png')}}"></a>&nbsp;
	<a href="{{ url('locale/ch') }}"><img width="20px" height="15px" src="{{asset('negara/ch.png')}}"></a>&nbsp;&nbsp;&nbsp;
	<a href="{{url('login')}}"><font color="white"><i class="fa fa-sign-in"></i> @lang("login.lbl3")</font></a> -->
	<style>
								.custom-select, .custom-file-control, .custom-file-control:before, select.form-control:not([size]):not([multiple]):not(.form-control-lg):not(.form-control-sm) {
    height: calc(1.28rem + 0.75rem + 12px);
}
								</style>
	<select id="lang" class="form-control" style="
   border: 0;
   color: #EEE;
   background: transparent;
   font-size: 12px;
   font-weight: bold;
   padding: 0px 11px;
   width: 86px;
   *
   width: 350px;
   *
   background: #58B14C;
   -webkit-appearance: none;
   " onchange="ce()">
	<option <?php if(app()->getLocale() == "en"){ echo "selected"; }?> value="en">English</option>
	<option <?php if(app()->getLocale() == "in"){ echo "selected"; }?> value="in">Indonesia</option>
	<option <?php if(app()->getLocale() == "ch"){ echo "selected"; }?> value="ch">China</option>
	</select>
	
	</td>
	</tr>
	</table>
	
      
       
     
    </div>
  </div>