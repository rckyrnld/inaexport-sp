@include('frontend.layouts.header')
<!--slider area start-->
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
<section class="slider_section mb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <div class="categories_menu">
                        <div class="categories_title">
                            <h2 class="categori_toggle">@lang('frontend.home.popcategory')</h2>
                        </div>
                        <div class="categories_menu_toggle">
                            <ul>
                                @foreach($categoryutama as $cu)
                                    <?php
                                        $catprod1 = getCategoryLevel(1, $cu->id, "");
                                        $nk = "nama_kategori_".$lct; 
                                        if($cu->$nk == NULL){
                                            $nk = "nama_kategori_en";
                                        }
                                    ?>
                                    @if(count($catprod1) == 0)
                                        <li><a href="#">{{$cu->$nk}}</a></li>
                                    @else
                                        <li class="menu_item_children categorie_list"><a href="#">{{$cu->$nk}} <i class="fa fa-angle-right"></i></a>
                                            <ul class="categories_mega_menu">
                                                @foreach($catprod1 as $c1)
                                                    <?php
                                                        $catprod2 = getCategoryLevel(2, $cu->id, $c1->id);
                                                        $nk = "nama_kategori_".$lct; 
                                                        if($c1->$nk == NULL){
                                                            $nk = "nama_kategori_en";
                                                        }
                                                    ?>
                                                    @if(count($catprod2) == 0)
                                                        <li class="menu_item_children"><a href="#">{{$c1->$nk}}</a></li>
                                                    @else
                                                        <li class="menu_item_children"><a href="#">{{$c1->$nk}}</a>
                                                            <ul class="categorie_sub_menu">
                                                                @foreach($catprod2 as $c2)
                                                                <?php
                                                                    $nk = "nama_kategori_".$lct; 
                                                                    if($c2->$nk == NULL){
                                                                        $nk = "nama_kategori_en";
                                                                    }
                                                                ?>
                                                                    <li><a href="#">{{$c2->$nk}}</a></li>
                                                            @endforeach
                                                            </ul>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endif
                                @endforeach
                                <li id="cat_toggle" class="has-sub"><a href="#"> @lang('frontend.home.allcategory')</a>
                                    <ul class="categorie_sub">
                                        <!-- <li><a href="#">Hide Categories</a></li> -->
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-12">
                    <div class="slider_area owl-carousel">
                        <div class="single_slider d-flex align-items-center" data-bgimg="{{asset('front/assets/img/slider/slider0.png')}}">
                            <div class="slider_content">
                                <h1>#1 B2B2C</h1>
                                <h2>Online Marketplace</h2><br><br>
                                <h2>234.000 wholesale<br>
                                & retail product online<br><br>
                                at a quality you can trust</h2><br>
                                <a class="button-join" href="shop.html">Join Now</a>
                            </div>

                        </div>
                        <!-- <div class="single_slider d-flex align-items-center" data-bgimg="assets/img/slider/slider5.jpg">
                            <div class="slider_content">
                                <h2>Height - Quality</h2>
                                <h1>The Parts Of shock Absorbers & Brake Kit</h1>
                                <a class="button" href="shop.html">shopping now</a>
                            </div>
                        </div>
                        <div class="single_slider d-flex align-items-center" data-bgimg="assets/img/slider/slider6.jpg">
                            <div class="slider_content">
                                <h2>Engine Oils</h2>
                                <h1>Top Quality Oil For Every Vehicle</h1>
                                <a class="button" href="shop.html">shopping now</a>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!--slider area end-->

    <!--product area start-->
    <section class="product_area mb-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_title">
                        <ul class="product_tab_button nav" role="tablist">
                            <?php
                                $numb = 1;
                            ?>
                            @foreach($categoryutama as $cut)
                            <?php
                                $cls = "";
                                if($numb == 1){
                                    $cls = "active";
                                }
                            ?>
                            <li>
                                <?php
                                    $nkat = "nama_kategori_".$lct; 
                                    if($cut->$nkat == NULL){
                                        $nkat = "nama_kategori_en";
                                    }

                                    $num_char = 20;
                                    $textkat = $cut->$nkat;
                                    if(strlen($textkat) > 20){
                                        $cut_text = substr($textkat, 0, $num_char);
                                        if ($textkat{$num_char - 1} != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                            $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                            $cut_text = substr($textkat, 0, $new_pos);
                                        }
                                        $kategorinya = $cut_text . '...';
                                    }else{
                                        $kategorinya = $textkat;
                                    }
                                ?>
                                <a class="{{$cls}}" data-toggle="tab" href="#tabke{{$numb}}" role="tab" aria-controls="tabke{{$numb}}" aria-selected="true" title="{{$textkat}}" onclick="openTab('tabke{{$numb}}')">
                                    <img src="{{asset('front/assets/img/kategori/agriculture.png')}}" alt="">
                                    {{$kategorinya}}
                                </a>
                            </li>
                            <?php $numb++; ?>
                            @endforeach
                            <!-- <li>
                                
                                    <a data-toggle="tab" href="#wheels" role="tab" aria-controls="wheels" aria-selected="false">
                                        <img src="{{asset('front/assets/img/kategori/apparel.png')}}" alt="">
                                        Apparel
                                    </a>
                                
                            </li>
                            <li>
                                
                                    <a data-toggle="tab" href="#turbo" role="tab" aria-controls="turbo" aria-selected="false">
                                        <img src="{{asset('front/assets/img/kategori/food.png')}}" alt="">
                                        Food
                                    </a>
                                
                            </li>
                            <li>
                                
                                    <a data-toggle="tab" href="#" role="tab" aria-controls="" aria-selected="false">
                                        <img src="{{asset('front/assets/img/kategori/furniture.png')}}" alt="">
                                        Furniture
                                    </a>
                                
                            </li>
                            <li>
                                
                                    <a data-toggle="tab" href="#" role="tab" aria-controls="" aria-selected="false">
                                        <img src="{{asset('front/assets/img/kategori/jewelry.png')}}" alt="">
                                        Jewelry
                                    </a>
                                
                            </li>
                            <li>
                                
                                    <a data-toggle="tab" href="#" role="tab" aria-controls="" aria-selected="false">
                                        <img src="{{asset('front/assets/img/kategori/gift_card.png')}}" alt="">
                                        Gift & Card
                                    </a>
                                
                            </li>
                            <li>
                                
                                    <a data-toggle="tab" href="#" role="tab" aria-controls="" aria-selected="false">
                                        <img src="{{asset('front/assets/img/kategori/health_beauty.png')}}" alt="">
                                        Health & Beauty
                                    </a>
                                
                            </li>
                            <li>
                                
                                    <a data-toggle="tab" href="#" role="tab" aria-controls="" aria-selected="false">
                                        <img src="{{asset('front/assets/img/kategori/industrial_parts.png')}}" alt="">
                                        Industrial Parts
                                    </a>
                                
                            </li>
                            <li>
                                
                                    <a data-toggle="tab" href="#" role="tab" aria-controls="" aria-selected="false">
                                        <img src="{{asset('front/assets/img/kategori/electrics.png')}}" alt="">
                                        Electrics
                                    </a>
                                
                            </li>
                            <li>
                                
                                    <a data-toggle="tab" href="#" role="tab" aria-controls="" aria-selected="false">
                                        <img src="{{asset('front/assets/img/kategori/automotive.png')}}" alt="">
                                        Automotive
                                    </a>
                                
                            </li> -->
                        </ul>
                    </div>

                </div>
            </div>

            <div class="tab-content" id="tabing-product">
                <?php
                    $numbe = 1;
                ?>
                @foreach($categoryutama as $cuta)
                    <?php
                        if($numbe == 1){
                            $clsnya = "active";
                        }else{
                            $clsnya = "";
                        }
                    ?>
                    <div class="tab-pane fade show {{$clsnya}}" id="tabke{{$numbe}}" role="tabpanel">
                        <div class="product_carousel product_column5 owl-carousel">
                            <?php

                            ?>
                            @foreach($product as $p)
                            <?php
                                $nprod = "prodname_".$lct;
                                $cat1 = getCategoryName($p->id_csc_product, $lct);
                                $cat2 = getCategoryName($p->id_csc_product_level1, $lct);
                                $cat3 = getCategoryName($p->id_csc_product_level2, $lct);

                                if($cat3 == "-"){
                                    if($cat2 == "-"){
                                        $categorynya = $cat1;
                                    }else{
                                        $categorynya = $cat2;
                                    }
                                }else{
                                    $categorynya = $cat3;
                                }

                                $img1 = $p->image_1;
                                $img2 = $p->image_2;

                                if($img1 == NULL){
                                    $isimg1 = '/image/noimage.jpg';
                                }else{
                                    $image1 = 'uploads/Eksportir_Product/Image/'.$p->id.'/'.$img1; 
                                    if(file_exists($image1)) {
                                      $isimg1 = '/uploads/Eksportir_Product/Image/'.$p->id.'/'.$img1;
                                    }else {
                                      $isimg1 = '/image/noimage.jpg';
                                    }  
                                }

                                if($img2 == NULL){
                                    $isimg2 = '/image/noimage.jpg';
                                }else{
                                    $image2 = 'uploads/Eksportir_Product/Image/'.$p->id.'/'.$img2; 
                                    if(file_exists($image2)) {
                                      $isimg2 = '/uploads/Eksportir_Product/Image/'.$p->id.'/'.$img2;
                                    }else {
                                      $isimg2 = '/image/noimage.jpg';
                                    }  
                                }
                            ?>
                                <div class="single_product">
                                    <div class="product_name">
                                        <h3><a href="{{url('front_end/product/'.$p->id)}}">{{$p->$nprod}}</a></h3>
                                        <p class="manufacture_product"><a href="#">{{$categorynya}}</a></p>
                                    </div>
                                    <div class="product_thumb">
                                        <a class="primary_img" href="{{url('front_end/product/'.$p->id)}}"><img src="{{url('/')}}{{$isimg1}}" alt=""></a>
                                        <a class="secondary_img" href="{{url('front_end/product/'.$p->id)}}"><img src="{{url('/')}}{{$isimg2}}" alt=""></a>
                                        <div class="label_product">
                                            <!-- <span class="label_sale">-57%</span> -->
                                        </div>

                                        <div class="action_links">
                                            <ul>
                                                <li class="quick_button"><a href="#" data-toggle="modal" data-target="#modal_box" title="quick view"> <span class="lnr lnr-magnifier"></span></a></li>
                                                <li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><span class="lnr lnr-heart"></span></a></li>
                                                <li class="compare"><a href="compare.html" title="compare"><span class="lnr lnr-sync"></span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_content">
                                        <div class="product_footer d-flex align-items-center">
                                            <div class="price_box">
                                                @if(is_numeric($p->price_usd))
                                                    <span class="regular_price">
                                                        $ {{$p->price_usd}}
                                                    </span>
                                                @else
                                                    <span class="regular_price" style="font-size: 13px;">
                                                        {{$p->price_usd}}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="add_to_cart">
                                                <a href="cart.html" title="add to cart"><span class="lnr lnr-cart"></span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <?php $numbe++; ?>
                @endforeach
            </div>
        </div>
    </section>
    <!--product area end-->
@include('frontend.layouts.footer')
<script type="text/javascript">
    // $(document).ready(function () {
        
    // })
    function openTab(tabname) {
        $('.tab-pane').removeClass('active');
        $('#'+tabname).addClass('active');
    }
</script>