<!DOCTYPE html>
<html class="no-js" lang="{{ app()->getLocale() }}">


<!-- Mirrored from demo.hasthemes.com/autima-preview/autima/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 01 Nov 2019 07:13:46 GMT -->
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

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $pageTitle }}</title>
{{--    <meta name="description" content="">--}}
    <meta name="title" content="InaExport">
    <meta name="description" content="InaExport as a media product digital promotion superior export products from Indonesian business people, so they can more easily reach out to foreign buyers.">
    <meta name="keywords" content="inaexport, exporter, importer, buying request, inquiry, kemendag, trade, promotion, products, business, indonesia">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('front/assets/img/logo/kemendag.png')}}">

    <!-- CSS 
    ========================= -->
    <!-- Font Awesome -->
    <!--<link rel="stylesheet" href="{{url('assets')}}/libs/font-awesome/css/font-awesome.min.css" type="text/css" />-->
    <script src="https://kit.fontawesome.com/928bae4c26.js" crossorigin="anonymous"></script>

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{asset('front/assets/css/plugins.css')}}">

    <!-- build:css ../assets/css/app.min.css -->
    <link rel="stylesheet" href="{{url('assets')}}/libs/bootstrap/dist/css/bootstrap.min.css" type="text/css" />
    <!-- endbuild -->
    <link rel="stylesheet" href="{{url('assets')}}/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" type="text/css" />
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{asset('front/assets/css/style.css')}}">
    <?php $font1 = url('/')."/front/assets/fonts/MYRIADPRO-REGULAR.woff";?>
    <style type="text/css">
        html, body{
            min-height: 100% !important;
            height: 100% !important;
        }

        .a-custom:hover{
            text-decoration: none;
        }

        .a-custom span:hover{
            color: #2FB4C2 !important;
        }
        .img-profil-header{
            width: 50px;
            height: 50px;
            border-radius: 50%
        }
        .header-span{
            padding-left: 10px;
            color: #ff8d00; 
            font-size: 18px;
        }
        .nav-pills .nav-link:hover, .nav-pills .nav-link.active{
            font-weight: 500;
            color: #ff8d00;
        }
        .nav-pills .nav-link {
            font-weight: 500;
            color: #007bff;
        }
        @font-face {
                font-family: 'Myriad-pro';
                src: url('{{$font1}}') format("truetype");
                font-weight: normal;
                font-style: normal;
            }

            .nav-link.active {
                color: #000;
                font-weight: bold;
                border-bottom: 1px solid #000;
            }
    </style>

    <!-- build:js scripts/app.min.js -->
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
    <script src="{{url('assets')}}/libs/pace-progress/pace.min.js"></script>
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

    <!-- <script src="{{url('assets')}}/libs/datatables/media/js/jquery.dataTables.min.js" ></script> -->
    <script src="{{url('assets')}}/libs/datatables.net-bs4/js/dataTables.bootstrap4.js" ></script>

    <script src="{{url('assets')}}/html/scripts/plugins/datatable.js" ></script>

<script src="{{ url('/') }}/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    <?php
        if(isset($jenisnya)){
        $loc = app()->getLocale(); 
    ?>
        $(document).ready(function () {
            var jenis = "{{$jenisnya}}";
            if(jenis == "eksportir"){
                $('#products').removeClass('active');
                $('#set_products').removeClass('active');
                $('#eksportir').addClass('active');
                $('#set_eksportir').addClass('active');
            }else{
                $('#eksportir').removeClass('active');
                $('#set_eksportir').removeClass('active');
                $('#products').addClass('active');
                $('#set_products').addClass('active');
            }
        });
    <?php
        }
    ?>
</script>
<style> 
.main-header .navbar .nav>li>a>.label {
    position: absolute;
    top: 9px;
    right: 7px;
    text-align: center;
    font-size: 9px;
    padding: 2px 3px;
    line-height: .9;
}

.bg-yellow, .callout.callout-warning, .alert-warning, .label-warning, .modal-warning .modal-body {
    background-color: #f39c12 !important;
}
.list-lang{
    display: none;
    position: absolute;
    transition: all 0.5s ease;
    margin-top: 3px;
    border-radius: 5px;
    left: 0;
    background-color: #fff;
    width: 100%;
    text-align: left;
    padding: 3px 8px 6px 8px;
    z-index: 100;
    background-color: #fff;
}
.lang-option > img {
    height: 16px; 
    width: 24px; 
    margin-right: 7px; 
}
a.visit-lang:hover, a.visit-lang:hover > .lang-option{
    text-decoration: none;
    background-color: #f4f4f4;
}
.title-lang{
    color: black; font-size: 13px;
}

.product_tab_button.nav div a.active, .product_tab_button.nav div a:hover {
    text-decoration: none;
    font-weight: 500;
    font-size: 16px!important;
    font-family: 'Myriad-pro';
    color: #4497e5!important;
}

.product_tab_button.nav div a {
    font-size: 16px!important;
    color: black!important;
}

.btn-usermenu {
  color: #000;
  background-color: #fff;
  border-color: #fff;
  font-size: 14px;
}

.btn-usermenu:hover {
  color: #000;
  background-color: #fff;
  border-color: #6f6f6f;
}

</style> 
</head>

<body>
    <?php 
        $loc = app()->getLocale(); 
        if($loc == "ch"){
            $lct = "chn";
        }else if($loc == "in"){
            $lct = "in";
        }else{
            $lct = "en";
        }
    ?>
    <!-- Main Wrapper Start -->
    <!--header area start-->
    <header class="header_area">
        <!--header top start-->
        <div style="background-color: #fff;">
            <div class="container">
                <div class="top_inner" style="padding: 5px 0px; border-bottom: 1px solid #ececec;">
                    <div class="row">
                        <?php
                        if(Auth::guard('eksmp')->user()) {
                            if(Auth::guard('eksmp')->user()->id_role == 3){
                                $user = getCompanyNameImportir(Auth::guard('eksmp')->user()->id);
                            }else if(Auth::guard('eksmp')->user()->id_role == 2){
                                $user = getCompanyName(Auth::guard('eksmp')->user()->id);
                            }
                            ?>
                            <!--<div class="col" style="text-align: left;"><?php //echo $user; ?> | <a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></div>-->
                            
                            <div class="col" class="dropdown">
                                <button class="btn btn-usermenu dropdown-toggle" type="button" id="dropdownMenuUser" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo $user; ?>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuUser" style="font-size: 14px;">
                                    <li><a class="dropdown-item" href="{{url('/profile')}}">Profile</a></li>
                                    <li><a class="dropdown-item" href="{{url('/front_end/history')}}">History</a></li>
                                    <li><a class="dropdown-item" href="{{url('/trx_list')}}">Transaction</a></li>
                                    <li><a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                                </ul>
                            </div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                            </form>
                            <?php
                        }
                        else {
                            ?>
                            <div class="col" style="text-align: left;"><a href="{{url('/login')}}">Sign in</a> or <a href="{{url('/createaccount')}}">Register</a></div>
                            <?php
                        }
                        ?>
                        <div class="col" style="text-align: right;">
                            <ul>
                                <li class="language" style="position: relative; display: inline-block;">
                                    <div class="lang-select" style="height: 100%;">
                                        <button class="btn-select-lang" style="background-color: #fff; border: 1px solid #ccc; height: 50%; width: 140px;">
                                            <!-- <img src="{{asset('front/assets/img/Google.png')}}" style="height: 18px; margin:3px;" align="left"> -->
                                            <span class="title-lang">
                                                    @if($loc == 'en') Select Language @elseif($loc == 'in') Pilih Bahasa @else ???????????? @endif
                                                <i class="fa fa-angle-down" aria-hidden="true" style="padding-left: 8px;"></i></span>
                                            </button>
                                            <ul class="list-lang">
                                                <a class="visit-lang" href="{{ url('locale/en') }}">
                                                    <li class="lang-option">
                                                        <img src="{{asset('negara/en.png')}}">
                                                        <span class="title-lang">English</span>
                                                    </li>
                                                </a>
                                                <a class="visit-lang" href="{{ url('locale/in') }}">
                                                    <li class="lang-option">
                                                        <img src="{{asset('negara/in.png')}}">
                                                        <span class="title-lang">Indonesia</span>
                                                    </li>
                                                </a>
                                                <a class="visit-lang" href="{{ url('locale/ch') }}">
                                                    <li class="lang-option">
                                                        <img src="{{asset('negara/ch.png')}}">
                                                        <span class="title-lang">China</span>
                                                    </li>
                                                </a>
                                            </ul >
                                        </div>
                                    </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--header top start-->
        <!--header middel start-->
        <div class="header_middle" style="background-color: #fff;">
            <div class="container" style="max-width: 98% !important;">
                <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-top">
                <div class="container">
                    <a class="navbar-brand" href="{{url('/')}}">
                    <img src="{{asset('front/assets/img/logo/logonew.png')}}" alt="" width="180">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="font-size: 14px;">
                        <?php
                        $a1 = ""; $a2 = ""; $a3 = ""; $a4 = ""; $a5 = ""; $a6 = ""; $a7 = "";
                        if($topMenu=="home") { $a1 = "active"; }
                        if($topMenu=="product") { $a2 = "active"; }
                        if($topMenu=="supplier") { $a3 = "active"; }
                        if($topMenu=="about") { $a4 = "active"; }
                        if($topMenu=="service") { $a5 = "active"; }
                        if($topMenu=="news") { $a6 = "active"; }
                        if($topMenu=="contact") { $a7 = "active"; }
                        ?>
                        <li class="nav-item">
                        <a class="nav-link <?php echo $a1; ?>" aria-current="page" href="{{url('/')}}">Home</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link <?php echo $a2; ?>" href="{{url('/products')}}">Our Products</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link <?php echo $a3; ?>" href="{{url('/suppliers')}}">Our Suppliers</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link <?php echo $a4; ?>" href="{{url('/about')}}">About Inaexport</a>
                        </li>
                        <li class="nav-item dropdown">
                        <a class="nav-link <?php echo $a5; ?> dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Our Services
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown" style="font-size: 14px;">
                            <li><a class="dropdown-item" href="{{url('/front_end/curris')}}">Trade Update</a></li>
                            <li><a class="dropdown-item" href="{{url('/front_end/research-corner')}}">Market Research</a></li>
                            <li><a class="dropdown-item" href="{{url('/front_end/event')}}">Event</a></li>
                            <li><a class="dropdown-item" href="{{url('/front_end/training')}}">Training</a></li>
                        </ul>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link <?php echo $a6; ?>" href="{{url('/news')}}">News</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link <?php echo $a7; ?>" href="{{url('/contact-us')}}">Contact Us</a>
                        </li>
                    </ul>
                    </div>
                </div>
                </nav>
            </div>
        </div>
    </header>
    <!--header area end-->
    <script type="text/javascript">
        $(document).ready(function(){
            $('html').click(function() {
                $('.list-lang').css('display', 'none');
            });

            $('.btn-select-lang').on('click', function(event){
                event.stopPropagation();
                var visible = $('.list-lang').css('display');
                if(visible == 'none'){
                    $('.list-lang').css('display', 'block');
                } else {
                    $('.list-lang').css('display', 'none');
                }                
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    