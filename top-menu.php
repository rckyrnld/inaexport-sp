<div class="col-lg-10 col-md-9 col-12">
                        <div class="middel_right d-flex justify-content-between row" >
                            <div class="search-container col-md-12 col-lg-5" style="margin-bottom: 10px;">
                                <!-- Nav pills -->
                                <ul class="nav nav-pills" role="tablist" id="tab-me" style="font-size: 14px;">
                                    <li class="nav-item">
                                    <a class="nav-link active" data-toggle="pill" href="#products" id="set_products"  style="font-family: 'Myriad-pro';">@lang('frontend.home.product')</a>
                                    </li>
                                    <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#eksportir" id="set_eksportir" style="font-family: 'Myriad-pro';">@lang('frontend.home.eksporter')</a>
                                    </li>
                                    <!-- <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#request">@lang('frontend.home.sourcer')</a>
                                    </li> -->
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div id="products" class="container tab-pane active">
                                        <form class="form-horizontal" enctype="multipart/form-data" method="GET" action="{{url('/front_end/list_product')}}" id="formsprod">
                                            <div class="search_box" style="width: 100%;">
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

                                                    if(isset($hl_sort)){
                                                        $hlprod = $hl_sort;
                                                    }else{
                                                        $hlprod = "";
                                                    }
                                                ?>
                                                <input placeholder="@lang('frontend.home.cariproduct') ..." type="text" name="cari_product" autocomplete="off" value="{{$cariprod}}" id="cari_product" style="height: 35px;">
                                                <input type="hidden" name="locnya" value="{{$lct}}" id="locnya">
                                                <input type="hidden" name="cari_catnya" value="{{$caricat}}" id="cari_catnya">
                                                <input type="hidden" name="eks_prod" value="{{$eksprod}}" id="eks_prod">
                                                <input type="hidden" name="hl_prod" value="{{$hlprod}}" id="hl_prod">
                                                <input type="hidden" name="sort_prod" value="default" id="sort_prod">
                                                <button type="submit"><i class="ion-ios-search-strong" style="font-size: 22px;"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="eksportir" class="container tab-pane">
                                        <form class="form-horizontal" enctype="multipart/form-data" method="GET" action="{{url('/front_end/list_perusahaan')}}" id="formseksportir">
                                            <div class="search_box" style="width: 100%">
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
                                                <input placeholder="@lang('frontend.home.carieksporter') ..." type="text" name="cari_eksportir" autocomplete="off" value="{{$carieks}}" id="cari_eksportir" style="height: 35px;">
                                                <input type="hidden" name="lctnya" value="{{$lct}}" id="lctnya">
                                                <input type="hidden" name="cat_eks" value="{{$caricateks}}" id="cat_eks">
                                                <input type="hidden" name="sorteks" id="sorteks" value="">
                                                <button type="submit"><i class="ion-ios-search-strong" style="font-size: 22px;"></i></button>
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
                                                    <img src="{{asset('front/assets/icon/product2.png')}}" alt="" style="width: 70px;">
                                                </td>
                                                <td style="">
                                                    <span class="header-span" style="font-family: 'Myriad-pro';">
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
                                
                                @if(Auth::guard('eksmp')->check())
                                <a href="{{url('front_end/tracking')}}" class="a-custom">
                                <div class="mini_cart_wrapper" style="padding-right: 15px">
                                    <table style="width: 150px;">
                                        <tr>
                                            <td rowspan="2" style="width: 50px">
                                                <img src="{{asset('front/assets/icon/tracking2.png')}}" alt="" style="width: 70px;">
                                            </td>
                                            <td style="">
                                                <span class="header-span" style="font-family: 'Myriad-pro';">
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

                                                <img src="{{asset('front/assets/icon/profile2a.png')}}" alt="" class="img-profil-header">
                                                <?php }else{ ?>

                                                <img src="{{asset('uploads/Profile/Importir/'.Auth::guard('eksmp')->user()->id.'/'.Auth::guard('eksmp')->user()->foto_profil)}}" alt="" class="img-profil-header">
                                                <?php } ?>
                                                    @elseif(Auth::guard('eksmp')->user()->id_role == 2)

                                                 <?php if(empty(Auth::guard('eksmp')->user()->foto_profil)){ ?>

												<img src="{{asset('front/assets/icon/PROFIL.png')}}" alt="" class="img-profil-header">
												<?php }else{ ?>

                                                <img src="{{asset('uploads/Profile/Eksportir/'.Auth::guard('eksmp')->user()->id.'/'.Auth::guard('eksmp')->user()->foto_profil)}}" alt="" class="img-profil-header">
												<?php } ?>

                                                    @endif
                                            @else
                                                <img src="{{asset('front/assets/icon/PROFIL.png')}}" alt="" class="img-profil-header">
                                            @endif
                                            </td>
                                            <td style="">
                                                <span class="header-span" style="font-family: 'Myriad-pro';">
                                                    @lang("frontend.lbl10")
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left: 10px;">
                                                @if(Auth::guard('eksmp')->user())
                                                    <?php
                                                    if(Auth::guard('eksmp')->user()->id_role == 3){
                                                        $user = getCompanyNameImportir(Auth::guard('eksmp')->user()->id);
                                                    }else if(Auth::guard('eksmp')->user()->id_role == 2){
                                                        $user = getCompanyName(Auth::guard('eksmp')->user()->id);
                                                    }
                                                    if(strlen($user) > 12){
                                                      $cut_text = substr($user, 0, 12);
                                                      if ($user{12 - 1} != ' ') {
                                                          $new_pos = strrpos($cut_text, ' ');
                                                          $cut_text = substr($user, 0, $new_pos);
                                                      }
                                                      $userName = $cut_text;
                                                    }else{
                                                      $userName = $user;
                                                    }
                                                    ?>
                                                <span style="color:#ff8d00; font-weight: 600; font-size: 12px; font-family: Myriad-pro; padding-left: 1px;" title="{{$user}}">
												<?php
                                                // $userName
												if(Auth::guard('eksmp')->user()->id_role == 3){
                                                        echo "Buyer";
                                                    }else if(Auth::guard('eksmp')->user()->id_role == 2){
                                                        echo "Exporter";
                                                    }

												?>
                                                </span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- <span class="wishlist_quantity">0</span> -->
                                </div>
                                @endif
                            </div>

                        </div>
                    </div>