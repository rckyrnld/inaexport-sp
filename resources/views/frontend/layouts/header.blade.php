<!DOCTYPE html>
<html class="no-js" lang="{{ app()->getLocale() }}">


<!-- Mirrored from demo.hasthemes.com/autima-preview/autima/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 01 Nov 2019 07:13:46 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@lang("frontend.title")</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('front/assets/img/favicon.ico')}}">

    <!-- CSS 
    ========================= -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{url('assets')}}/libs/font-awesome/css/font-awesome.min.css" type="text/css" />

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{asset('front/assets/css/plugins.css')}}">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{asset('front/assets/css/style.css')}}">
    <!-- build:css ../assets/css/app.min.css -->
    <link rel="stylesheet" href="{{url('assets')}}/libs/bootstrap/dist/css/bootstrap.min.css" type="text/css" />
    <!-- endbuild -->
    <link rel="stylesheet" href="{{url('assets')}}/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" type="text/css" />

    <style type="text/css">
        .a-custom:hover{
            text-decoration: none;
        }

        .a-custom span:hover{
            color: #2FB4C2 !important;
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

    <script src="{{url('assets')}}/libs/datatables/media/js/jquery.dataTables.min.js" ></script>
    <script src="{{url('assets')}}/libs/datatables.net-bs4/js/dataTables.bootstrap4.js" ></script>

    <script src="{{url('assets')}}/html/scripts/plugins/datatable.js" ></script>

<script src="{{ url('/') }}/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    <?php
        if(isset($jenisnya)){
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
        <div class="header_top">
            <div class="container">
                <div class="top_inner">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-6">
                            <div class="follow_us">
                                <label><i class="ion-social-whatsapp-outline"></i> hotline : +62 000 111 222 333</label>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="top_right text-right">
                                <ul>
                                    @if(Auth::guard('eksmp')->user())
                                        <li class="top_links"><a href="#"><i class="ion-android-person"></i>
                                        @if(Auth::guard('eksmp')->user()->id_role == 3)
                                            {{getCompanyNameImportir(Auth::guard('eksmp')->user()->id)}}
                                        @elseif(Auth::guard('eksmp')->user()->id_role == 2)
                                            {{getCompanyName(Auth::guard('eksmp')->user()->id)}}
                                        @endif
                                            <i class="ion-ios-arrow-down"></i></a>
                                        <ul class="dropdown_links">
                                            @if(Auth::guard('eksmp')->user()->id_role == 3)
                                            <li><a href="{{route('profile')}}" style="text-decoration: none">@lang('frontend.lbl5')</a></li>
											@endif
											<li><a href="{{url('front_end/history')}}" style="text-decoration: none">@lang('frontend.lbl7')</a></li>
											<li><a href="{{url('trx_list')}}" style="text-decoration: none">@lang('frontend.lbl11')</a></li>
                                            <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">@lang('frontend.lbl4')</a></li>
                                        </ul>
                                    </li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                    </form>
                                    @else
                                    <li class="top_links"><a href="{{url('login')}}"><i class="fa fa-sign-in"></i> @lang("frontend.lbl3")</a></li>
                                    @endif
                                    <li>
                                        <?php 
                            			  if(empty(Auth::user()->name) && empty(Auth::guard('eksmp')->user()->id)){
                            				$sao = 0;
                            			  }else{
                            				$sao = 1;
                            			  if(empty(Auth::user()->name)){ 
                            			  $querynotifa = DB::select("select * from notif where status_baca='0' and untuk_id='".Auth::guard('eksmp')->user()->id."' and to_role='".Auth::guard('eksmp')->user()->id_role."' order by id_notif desc"); 
                            			  $querynotif = DB::select("select * from notif where status_baca='0' and untuk_id='".Auth::guard('eksmp')->user()->id."' and to_role='".Auth::guard('eksmp')->user()->id_role."' order by id_notif desc limit 4"); 
                            			  }else{
                            				if(Auth::user()->id_group == 1){
                            				$querynotifa = DB::select("select * from notif where status_baca='0' and to_role='1' order by id_notif desc"); 
                            				$querynotif = DB::select("select * from notif where status_baca='0' and to_role='1' order by id_notif desc limit 4"); 
                            			  }else{
                            				$querynotifa = DB::select("select * from notif where untuk_id='".Auth::user()->id."' and status_baca='0' and to_role='4' order by id_notif desc"); 
                            				$querynotif = DB::select("select * from notif where untuk_id='".Auth::user()->id."' and status_baca='0' and to_role='4' order by id_notif desc limit 4");
                            			  }
                            			  }
                            			  }
                            			 
                            			  if($sao == 0) {
                            			  ?>
                            			   <font color="white"> <i class="fa fa-bell-o"></i></font>
                            			<?php 
                                            }else{ 
                                        ?>
                            			<ul class="nav flex-row order-lg-2">
                                            <li class="dropdown notifications-menu d-flex align-items-center">
                                                <a href="#" class="dropdown-toggles" data-toggle="dropdown">
                                                    <font color="white"> <i class="fa fa-bell-o"></i></font>
                                                    <span class="label label-warning" style="position: absolute!important;
                                                        color : white!important;
                                                        right: 7px!important;
                                                        text-align: center!important;
                                                        font-size: 9px!important;
                                                        padding: 2px 3px!important;
                                                        line-height: .9!important;">
                                                        <?php 
                                                            if(count($querynotifa) == 0){ 
                                                                echo "0"; 
                                                            }else{ 
                                                                echo count($querynotifa); 
                                                            } 
                                                        ?>
                                                    </span>
                                                    <i class="ion-ios-arrow-down"></i>
                                                </a>
                                                <ul class="dropdown_links" style="min-width: 250px!important;">
                            						<?php 
                            			                 foreach($querynotif as $ar){
                                                    ?>
                                                    @if($ar->id_terkait == NULL)
                                                        <a onclick="closenotif(<?php echo $ar->id_notif; ?>)" href="{{url($ar->url_terkait)}}">
                                                    		<p style="width:100%; font-size:12px!important;">
                                                                <?php echo $ar->keterangan; ?><br>
                                                                <b><?php echo $ar->waktu; ?></b>
                                                            </p>
                                                		</a>
                                                        <hr>
                                                    @else
                                                        <a onclick="closenotif(<?php echo $ar->id_notif; ?>)" href="{{url($ar->url_terkait.'/'.$ar->id_terkait)}}">
                                                            <p style="width:100%; font-size:12px!important;">
                                                                <?php echo $ar->keterangan; ?><br>
                                                                <b><?php echo $ar->waktu; ?></b>
                                                			</p>
                                        			    </a>
                                        			    <hr>
                                                    @endif
                                                    <?php } ?>
                                                    <li><center>
                                                        <?php 
                                                            if(count($querynotifa) == 0){ 
                                                                echo "<b>Tidak Ada Notifikasi Tersedia Untuk Anda !</b><br><br>"; 
                                                            }else{ ?> 
                                                                <a href="{{ url('show_all_notif') }}">View all</a> 
                                                        <?php } ?>
                                                    </center></li>
                                                   <!-- Navarbar toggle btn -->
                                                    <li class="d-lg-none d-flex align-items-center">
                                                      <a href="#" class="mx-2" data-toggle="collapse" data-target="#navbarToggler">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 512 512"><path d="M64 144h384v32H64zM64 240h384v32H64zM64 336h384v32H64z"/></svg>
                                                      </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                            			  <?php } ?>
                                    </li>
                                    <li class="language">
                                        <a href="{{ url('locale/en') }}"><img width="20px" height="15px" src="{{asset('negara/en.png')}}"></a>&nbsp;
                                    	<a href="{{ url('locale/in') }}"><img width="20px" height="15px" src="{{asset('negara/in.png')}}"></a>&nbsp;
                                    	<a href="{{ url('locale/ch') }}"><img width="20px" height="15px" src="{{asset('negara/ch.png')}}"></a>&nbsp;&nbsp;&nbsp;
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--header top start-->
        <!--header middel start-->
        <div class="header_middle">
            <div class="container" style="max-width: 1200px!important;">
                <div class="row align-items-center">
                    <div class="col-lg-2 col-md-6">
                        <div class="logo">
                            <a href="{{url('/')}}"><img src="{{asset('front/assets/img/logo/logo.png')}}" alt="" width="111"></a>
                        </div>
                    </div>
                    <div class="col-lg-10 col-md-6">
                        <div class="middel_right">
                            <div class="search-container" style="margin-right: 48px!important;">
                                <!-- Nav pills -->
                                <ul class="nav nav-pills" role="tablist" id="tab-me">
                                    <li class="nav-item">
                                    <a class="nav-link active" data-toggle="pill" href="#products" id="set_products">@lang('frontend.home.product')</a>
                                    </li>
                                    <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#eksportir" id="set_eksportir">@lang('frontend.home.eksporter')</a>
                                    </li>
                                    <!-- <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#request">@lang('frontend.home.sourcer')</a>
                                    </li> -->
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div id="products" class="container tab-pane active">
                                        <form class="form-horizontal" enctype="multipart/form-data" method="GET" action="{{url('/front_end/list_product')}}" id="formsprod">
                                            {{ csrf_field() }}
                                            <div class="search_box" style="width:484px!important;">
                                                <?php
                                                    if(isset($search)){
                                                        $cariprod = $search;
                                                    }else{
                                                        $cariprod = "";
                                                    }

                                                    if(isset($get_id_cat)){
                                                        $caricat = $get_id_cat;
                                                    }else{
                                                        $caricat = "";
                                                    }

                                                    if(isset($getEks)){
                                                        $eksprod = $getEks;
                                                    }else{
                                                        $eksprod = "";
                                                    }
                                                ?>
                                                <input placeholder="@lang('frontend.home.cariproduct') ..." type="text" name="cari_product" autocomplete="off" value="{{$cariprod}}" id="cari_product">
                                                <input type="hidden" name="locnya" value="{{$lct}}" id="locnya">
                                                <input type="hidden" name="cari_catnya" value="{{$caricat}}" id="cari_catnya">
                                                <input type="hidden" name="eks_prod" value="{{$eksprod}}" id="eks_prod">
                                                <input type="hidden" name="sort_prod" value="" id="sort_prod">
                                                <button type="submit"><i class="ion-ios-search-strong" style="font-size: 27px;"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="eksportir" class="container tab-pane">
                                        <form class="form-horizontal" enctype="multipart/form-data" method="GET" action="{{url('/front_end/list_perusahaan')}}" id="formseksportir">
                                            {{ csrf_field() }}
                                            <div class="search_box" style="width:484px!important;">
                                                <?php
                                                    if(isset($search_eks)){
                                                        $carieks = $search_eks;
                                                    }else{
                                                        $carieks = "";
                                                    }

                                                    if(isset($get_cat_eks)){
                                                        $caricateks = $get_cat_eks;
                                                    }else{
                                                        $caricateks = "";
                                                    }
                                                ?>
                                                <input placeholder="@lang('frontend.home.carieksporter') ..." type="text" name="cari_eksportir" autocomplete="off" value="{{$carieks}}" id="cari_eksportir">
                                                <input type="hidden" name="lctnya" value="{{$lct}}" id="lctnya">
                                                <input type="hidden" name="cat_eks" value="{{$caricateks}}" id="cat_eks">
                                                <input type="hidden" name="sorteks" id="sorteks" value="">
                                                <button type="submit"><i class="ion-ios-search-strong" style="font-size: 27px;"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- <div id="request" class="container tab-pane fade">
                                        <form action="#">
                                            <div class="search_box">
                                                <input placeholder="Enter a keyword to search sourcing request ..." type="text">
                                                <button type="submit"><i class="ion-ios-search-strong"></i></button>
                                            </div>
                                        </form>
                                    </div> -->
                                </div>
                                <!-- <form action="#">
                                    <div class="search_box">
                                        <input placeholder="Search entire store here ..." type="text">
                                        <button type="submit"><i class="ion-ios-search-strong"></i></button>
                                    </div>
                                </form> -->
                            </div>
                            <div class="middel_right_info">
                                <a href="{{url('/front_end/list_product')}}" class="a-custom">
                                    <div class="mini_cart_wrapper" style="padding-right: 15px">
                                        <table style="width: 150px;">
                                            <tr>
                                                <td rowspan="2" style="width: 50px">
                                                    <img src="{{asset('front/assets/icon/product1.png')}}" alt="" style="width: 50px;">
                                                </td>
                                                <td style="">
                                                    <span style="color: #ff3e3e; font-weight: 500; padding-left: 10px;">
                                                        @lang("frontend.lbl8")
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </a>
								<a href="{{url('front_end/tracking')}}" class="a-custom">
								<div class="mini_cart_wrapper" style="padding-right: 15px">
                                    <table style="width: 150px;">
                                        <tr>
                                            <td rowspan="2" style="width: 50px">
                                                <img src="{{asset('front/assets/icon/tracking.png')}}" alt="" style="width: 50px;">
                                            </td>
                                            <td style="">
                                                <span style="color: #ff3e3e; font-weight: 500; padding-left: 10px;">
                                                    @lang("frontend.lbl9")
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                               
                                            </td>
                                        </tr>
                                    </table>
                                </div>
								</a>
                                <div class="header_wishlist">
                                    <table style="width: 150px;">
                                        <tr>
                                            <td rowspan="2" style="width: 50px">
											@if(Auth::guard('eksmp')->user())
                                                
                                                    @if(Auth::guard('eksmp')->user()->id_role == 3)
														
												<?php if(empty(Auth::guard('eksmp')->user()->foto_profil)){ ?>
												
												<img src="{{asset('front/assets/icon/user.png')}}" alt="" style="width: 50px;">
												<?php }else{ ?>
												
                                                <img src="{{asset('uploads/Profile/Importir/'.Auth::guard('eksmp')->user()->id.'/'.Auth::guard('eksmp')->user()->foto_profil)}}" alt="" style="width: 50px;">
												<?php } ?>
                                                    @elseif(Auth::guard('eksmp')->user()->id_role == 2)
													
                                                 <?php if(empty(Auth::guard('eksmp')->user()->foto_profil)){ ?>
												<img src="{{asset('front/assets/icon/user.png')}}" alt="" style="width: 50px;">
												<?php }else{ ?>
												
                                                <img src="{{asset('uploads/Profile/Importir/'.Auth::guard('eksmp')->user()->id.'/'.Auth::guard('eksmp')->user()->foto_profil)}}" alt="" style="width: 50px;">
												<?php } ?>
                                                    @endif
											@else	
												<img src="{{asset('front/assets/icon/user.png')}}" alt="" style="width: 50px;">
                                            @endif
                                                
                                            </td>
                                            <td style="">
                                                <span style="color: #ff3e3e; font-weight: 500; padding-left: 10px;">
                                                    @lang("frontend.lbl10")
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                @if(Auth::guard('eksmp')->user())
                                                <span style="color: black; font-weight: 600; font-size: 12px; padding-left: 10px;">
                                                    @if(Auth::guard('eksmp')->user()->id_role == 3)
                                                        {{getCompanyNameImportir(Auth::guard('eksmp')->user()->id)}}
                                                    @elseif(Auth::guard('eksmp')->user()->id_role == 2)
                                                        {{getCompanyName(Auth::guard('eksmp')->user()->id)}}
                                                    @endif
                                                </span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- <span class="wishlist_quantity">0</span> -->
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--header middel end-->
        <!--header bottom satrt-->
        <!-- <div class="header_bottom sticky-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="main_menu header_position">
                            <nav>
                                <ul>
                                    <li><a href="index.html">home<i class="fa fa-angle-down"></i></a>
                                        <ul class="sub_menu">
                                            <li><a href="index.html">Home 1</a></li>
                                            <li><a href="index-2.html">Home 2</a></li>
                                            <li><a href="index-3.html">Home 3</a></li>
                                            <li><a href="index-4.html">Home 4</a></li>
                                            <li><a href="index-5.html">Home 5</a></li>
                                            <li><a href="index-6.html">Home 6</a></li>
                                        </ul>
                                    </li>
                                    <li class="mega_items"><a href="shop.html">shop<i class="fa fa-angle-down"></i></a>
                                        <div class="mega_menu">
                                            <ul class="mega_menu_inner">
                                                <li><a href="#">Shop Layouts</a>
                                                    <ul>
                                                        <li><a href="shop-fullwidth.html">Full Width</a></li>
                                                        <li><a href="shop-fullwidth-list.html">Full Width list</a></li>
                                                        <li><a href="shop-right-sidebar.html">Right Sidebar </a></li>
                                                        <li><a href="shop-right-sidebar-list.html"> Right Sidebar list</a></li>
                                                        <li><a href="shop-list.html">List View</a></li>
                                                    </ul>
                                                </li>
                                                <li><a href="#">other Pages</a>
                                                    <ul>
                                                        <li><a href="cart.html">cart</a></li>
                                                        <li><a href="wishlist.html">Wishlist</a></li>
                                                        <li><a href="checkout.html">Checkout</a></li>
                                                        <li><a href="my-account.html">my account</a></li>
                                                        <li><a href="404.html">Error 404</a></li>
                                                    </ul>
                                                </li>
                                                <li><a href="#">Product Types</a>
                                                    <ul>
                                                        <li><a href="product-details.html">product details</a></li>
                                                        <li><a href="product-sidebar.html">product sidebar</a></li>
                                                        <li><a href="product-grouped.html">product grouped</a></li>
                                                        <li><a href="variable-product.html">product variable</a></li>

                                                    </ul>
                                                </li>
                                                <li><a href="#">Concrete Tools</a>
                                                    <ul>
                                                        <li><a href="shop.html">Cables & Connectors</a></li>
                                                        <li><a href="shop-list.html">Graphics Tablets</a></li>
                                                        <li><a href="shop-fullwidth.html">Printers, Ink & Toner</a></li>
                                                        <li><a href="shop-fullwidth-list.html">Refurbished Tablets</a></li>
                                                        <li><a href="shop-right-sidebar.html">Optical Drives</a></li>

                                                    </ul>
                                                </li>
                                            </ul>
                                            <div class="banner_static_menu">
                                                <a href="shop.html"><img src="assets/img/bg/banner1.jpg" alt=""></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li><a href="blog.html">blog<i class="fa fa-angle-down"></i></a>
                                        <ul class="sub_menu pages">
                                            <li><a href="blog-details.html">blog details</a></li>
                                            <li><a href="blog-fullwidth.html">blog fullwidth</a></li>
                                            <li><a href="blog-sidebar.html">blog sidebar</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">pages <i class="fa fa-angle-down"></i></a>
                                        <ul class="sub_menu pages">
                                            <li><a href="about.html">About Us</a></li>
                                            <li><a href="services.html">services</a></li>
                                            <li><a href="faq.html">Frequently Questions</a></li>
                                            <li><a href="login.html">login</a></li>
                                            <li><a href="compare.html">compare</a></li>
                                            <li><a href="privacy-policy.html">privacy policy</a></li>
                                            <li><a href="coming-soon.html">Coming Soon</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="about.html">about Us</a></li>
                                    <li><a href="contact.html"> Contact Us</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>
        </div> -->
        <!--header bottom end-->

    </header>
    <!--header area end-->

    