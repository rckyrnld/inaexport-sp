<!DOCTYPE html>
<html lang="en">
<head>

<!-- google analytics tag -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-172016689-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-172016689-1');
</script>

  <meta charset="utf-8" />
{{--  <title>{{$pageTitle}}</title>--}}
{{--  <meta name="description" content="Responsive, Bootstrap, BS4" />--}}
    <meta name="title" content="InaExport">
    <meta name="description" content="InaExport as a media product digital promotion superior export products from Indonesian business people, so they can more easily reach out to foreign buyers.">
    <meta name="keywords" content="inaexport, exporter, importer, buying request, inquiry, kemendag, trade, promotion, products, business, indonesia">
    <meta name="robots" content="index, follow">
{{--    <meta name="viewport" content="width=device-width, initial-scale=1">--}}
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
  

  <!-- corousel -->
  <link rel="stylesheet" href="{{url('/')}}/css/w3.css">
  <style>
    .mySlides {display:none;}
    table,th,tr,td{
      text-align: center;
    }
  </style>
  <!-- style -->
  <!--
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>
<script src="custom_tags_input.js"></script>

-->

  <!-- <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/dist/css/AdminLTE.min.css" type="text/css" /> -->
  <link rel="stylesheet" href="{{url('assets')}}/libs/font-awesome/css/font-awesome.min.css" type="text/css" />

  <!-- build:css ../assets/css/app.min.css -->
  <link rel="stylesheet" href="{{url('assets')}}/libs/bootstrap/dist/css/bootstrap.min.css" type="text/css" />
  <link rel="stylesheet" href="{{url('assets')}}/assets/css/app.css" type="text/css" />
  <link rel="stylesheet" href="{{url('assets')}}/assets/css/style.css" type="text/css" />
  <!-- endbuild -->
<link rel="stylesheet" href="{{url('assets')}}/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" type="text/css" />

<!-- build:js scripts/app.min.js -->
<!-- Highchart -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<!-- jQuery -->
  <script src="{{url('assets')}}/libs/jquery/dist/jquery.min.js"></script>
<!-- Select2 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<!-- InputMask -->
  <script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<!-- Bootstrap -->
  <script src="{{url('assets')}}/libs/popper.js/dist/umd/popper.min.js"></script>
  <script src="{{url('assets')}}/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- core -->
<?php if(Request::segment(2) != "chatting" && Request::segment(1) != "br_pw_chat" && Request::segment(1) != "br_chat" ){ ?>
  <script src="{{url('assets')}}/libs/pace-progress/pace.min.js"></script>
<?php } ?>
  <script src="{{url('assets')}}/libs/pjax/pjax.js"></script>

   <script src="{{url('assets')}}/libs/datatables/media/js/jquery.dataTables.min.js"></script>

  <script src="{{url('assets')}}/html/scripts/lazyload.config.js"></script>
  <script src="{{url('assets')}}/html/scripts/lazyload.js"></script>
  <script src="{{url('assets')}}/html/scripts/plugin.js"></script>
  <script src="{{url('assets')}}/html/scripts/nav.js"></script>
  <script src="{{url('assets')}}/html/scripts/scrollto.js"></script>
  <script src="{{url('assets')}}/html/scripts/toggleclass.js"></script>
  <script src="{{url('assets')}}/html/scripts/theme.js"></script>
  <script src="{{url('assets')}}/html/scripts/ajax.js"></script>
  <script src="{{url('assets')}}/html/scripts/app.js"></script>

  
<script src="{{url('assets')}}/libs/datatables/media/js/jquery.dataTables.min.js" ></script>
<script src="{{url('assets')}}/libs/datatables.net-bs4/js/dataTables.bootstrap4.js" ></script>

<script src="{{url('assets')}}/html/scripts/plugins/datatable.js" ></script>

<script src="{{ url('/') }}/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>

<script type="text/javascript">
  $(function () {
   $('#example1').DataTable({
     "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    });
	
	$('#example2').DataTable({
     "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    });
	
	$('#yahoo').DataTable({
     
    });

  $('.select2').select2();
 });
 </script>


</head>
<body style="background-color: #fff !important; ">
<?php date_default_timezone_set('Asia/Jakarta'); ?>

<div class="app" id="app">

<!-- ############ LAYOUT START-->

    <!-- ############ Aside START-->
    <div id="aside" class="app-aside fade box-shadow-x nav-expand white" aria-hidden="true">
        <div class="sidenav modal-dialog dk">
          <!-- sidenav top -->
          
   <div class="navbar lt" style="background-color:  #ddeffd ; color: #ffffff">

       @if(auth::check())

	        @if( Auth::guard('eksmp')->check())
	           <a href="{{url('/')}}" class="navbar-brand">
	               {{--                <img height="25px" src="http://localhost:88/kemendag/public/front/assets/img/logo/logo.png" alt=".">--}}
	               <img height="25px" src="{{url('assets')}}/assets/images/logonew.png" alt="." >
	               {{--                <span class="hidden-folded d-inline"><font size="3px">Ministry Of Trade </font></span>--}}
	           </a>
            @else
               <img height="25px" src="{{url('assets')}}/assets/images/logonew.png" alt="." >
            @endif
        @else
            <!-- brand -->
            <a href="{{url('/')}}" class="navbar-brand">
{{--                <img height="25px" src="http://localhost:88/kemendag/public/front/assets/img/logo/logo.png" alt=".">--}}
{{--                <img height="25px" src="{{url('assets')}}/assets/images/icon product-22.png" alt="." >--}}
                <img height="25px" src="{{url('assets')}}/assets/images/logonew.png" alt="." >
{{--                <span class="hidden-folded d-inline"><font size="3px">Ministry Of Trade </font></span>--}}
            </a>
       @endif
            <!-- / brand -->
          </div>


           @include('menu')

          <!-- sidenav bottom -->
          <div class="no-shrink lt" style="background-color:  #2791a6  ; color: #ffffff">
            <div class="nav-fold">
              
                <div class="dropdown-menu  w pt-0 mt-2 animate fadeIn">
                  <div class="row no-gutters b-b mb-2">
                    <div class="col-4 b-r">
                      <a href="app.user.html" class="py-2 pt-3 d-block text-center">
                        <i class="fa text-md fa-phone-square text-muted"></i>
                        <small class="d-block">Call</small>
                      </a>
                    </div>
                    <div class="col-4 b-r">
                      <a href="app.message.html" class="py-2 pt-3 d-block text-center">
                        <i class="fa text-md fa-comment text-muted"></i>
                        <small class="d-block">Chat</small>
                      </a>
                    </div>
                    <div class="col-4">
                      <a href="app.inbox.html" class="py-2 pt-3 d-block text-center">
                        <i class="fa text-md fa-envelope text-muted"></i>
                        <small class="d-block">Email</small>
                      </a>
                    </div>
                  </div>
                  <a class="dropdown-item" href="profile.html">
                    <span>Profile</span>
                  </a>
                  <a class="dropdown-item" href="setting.html">
                    <span>Settings</span>
                  </a>
                  <a class="dropdown-item" href="app.inbox.html">
                    <span class="float-right"><span class="badge info">6</span></span>
                    <span>Inbox</span>
                  </a>
                  <a class="dropdown-item" href="app.message.html">
                    <span>Message</span>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="docs.html">
                    Need help?
                  </a>
                  <a class="dropdown-item" href="signin.html">Sign out</a>
                </div>
              
            </div>
          </div>
        </div>
    </div>

     <!-- ############ Aside END-->

    <!-- ############ Content START-->
    <div id="content" class="app-content box-shadow-0" role="main" style="width: 100%;">



    @include('main')