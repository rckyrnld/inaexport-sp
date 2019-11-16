@include('frontend.layouts.header')
<?php 
    $loc = app()->getLocale(); 
    if($loc == "ch"){
        $lct = "chn";
    }else if($loc == "in"){
        $lct = "in";
    }else{
        $lct = "en";
    }

    //get category
    $cat1 = getCategoryName($data->id_csc_product, $lct);
    $cat2 = getCategoryName($data->id_csc_product_level1, $lct);
    $cat3 = getCategoryName($data->id_csc_product_level2, $lct);

    $img1 = "image/noimage.jpg";
    $img2 = "image/noimage.jpg";
    $img3 = "image/noimage.jpg";
    $img4 = "image/noimage.jpg";
    if($data->image_1 != NULL){
        $imge1 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_1;
        if(file_exists($imge1)) {
          $img1 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_1;
        }
    }
    if($data->image_2 != NULL){
        $imge2 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_2;
        if(file_exists($imge2)) {
          $img2 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_2;
        }
    }
    if($data->image_3 != NULL){
        $imge3 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_3;
        if(file_exists($imge3)) {
          $img3 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_3;
        }
    }
    if($data->image_4 != NULL){
        $imge4 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_4;
        if(file_exists($imge4)) {
          $img4 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_4;
        }
    }
?>
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="{{url('/')}}">Home</a></li>
                            @if($data->id_csc_product == NULL)
                            <li><a href="{{url('/front_end/list_product')}}">Default</a></li>
                            @else
                                @if($cat1 == "-")
                                    <li><a href="{{url('/front_end/list_product')}}">Default</a></li>
                                @else
                                    @if($cat2 == "-")
                                        <li><a href="{{url('/front_end/list_product/category/'.$data->id_csc_product_level1)}}">{{$cat1}}</a></li>
                                    @else
                                        @if($cat3 == "-")
                                            <li><a href="{{url('/front_end/list_product/category/'.$data->id_csc_product)}}">{{$cat1}}</a></li>
                                            <li><a href="{{url('/front_end/list_product/category/'.$data->id_csc_product_level1)}}">{{$cat2}}</a></li>
                                        @else
                                             <li><a href="{{url('/front_end/list_product/category/'.$data->id_csc_product)}}">{{$cat1}}</a></li>
                                            <li><a href="{{url('/front_end/list_product/category/'.$data->id_csc_product_level1)}}">{{$cat2}}</a></li>
                                            <li><a href="{{url('/front_end/list_product/category/'.$data->id_csc_product_level2)}}">{{$cat3}}</a></li>
                                        @endif
                                    @endif
                                @endif
                            @endif
                            <li>Product Details</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!--product details start-->
    <div class="product_details mt-20">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product-details-tab">

                        <div id="img-1" class="zoomWrapper single-zoom">
                            <a href="#">
                                <img id="zoom1" src="{{url('/')}}/{{$img1}}" data-zoom-image="{{url('/')}}/{{$img1}}" alt="big-1">
                            </a>
                        </div>

                        <div class="single-zoom-thumb">
                            <ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">
                                <li>
                                    <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{url('/')}}/{{$img1}}" data-zoom-image="{{url('/')}}/{{$img1}}">
                                        <img src="{{url('/')}}/{{$img1}}" alt="zo-th-1" />
                                    </a>

                                </li>
                                <li>
                                    <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{url('/')}}/{{$img2}}" data-zoom-image="{{url('/')}}/{{$img2}}">
                                        <img src="{{url('/')}}/{{$img2}}" alt="zo-th-1" />
                                    </a>

                                </li>
                                <li>
                                    <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{url('/')}}/{{$img3}}" data-zoom-image="{{url('/')}}/{{$img3}}">
                                        <img src="{{url('/')}}/{{$img3}}" alt="zo-th-1" />
                                    </a>

                                </li>
                                <li>
                                    <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{url('/')}}/{{$img4}}" data-zoom-image="{{url('/')}}/{{$img4}}">
                                        <img src="{{url('/')}}/{{$img4}}" alt="zo-th-1" />
                                    </a>

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product_d_right">
                            <h1>{{getProductAttr($data->id, 'prodname', $lct)}}</h1>
                            <div class="price_box">
                                <span class="current_price">
                                    @if(is_numeric($data->price_usd))
                                        $ {{$data->price_usd}}
                                    @else
                                        {{$data->price_usd}}
                                    @endif
                                </span>
                            </div>
                            <div class="product_desc">
                                <?php echo getProductAttr($data->id, 'product_description', $lct); ?>
                            </div>
                            <div class="product_variant quantity">
                                <label>@lang('frontend.proddetail.minorder')</label>
                                <input type="text" name="minorder" value="{{$data->minimum_order}}" readonly>

                            </div><br>
                            <div class="">
                                <center>
                                    <a href="{{url('/front_end/inquiry_product')}}/{{$data->id}}" class="btn btn-primary" style="width: 50%;"><i class="fa fa-envelope" aria-hidden="true"></i> @lang('product.inquiry')</a>
                                </center>
                            </div>
                        <!-- </form> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--product details end-->

    <!--product info start-->
    <div class="product_details mt-20">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product_d_inner">
                        <div class="product_info_button">
                            <ul class="nav" role="tablist">
                                <li>
                                    <a class="active" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="false">@lang('frontend.proddetail.desc')</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#sheet" role="tab" aria-controls="sheet" aria-selected="false">@lang('frontend.proddetail.specs')</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="info" role="tabpanel">
                                <div class="product_info_content">
                                    <?php echo getProductAttr($data->id, 'product_description', $lct); ?>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="sheet" role="tabpanel">
                                <div class="product_d_table">
                                    <form action="#">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td class="first_child">@lang('product.color')</td>
                                                    <td>{{getProductAttr($data->id, 'color', $lct)}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="first_child">@lang('product.size')</td>
                                                    <td>{{getProductAttr($data->id, 'size', $lct)}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="first_child">@lang('product.rawmaterial')</td>
                                                    <td>{{getProductAttr($data->id, 'raw_material', $lct)}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="first_child">@lang('product.capacity')</td>
                                                    <td>{{$data->capacity}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--product info end-->

    <!--product area start-->
    <section class="product_area mb-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_title">
                        <h2><span>@lang('frontend.proddetail.relprod')</span></h2>
                    </div>
                    <div class="product_carousel product_column5 owl-carousel">
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
                                    <h3><a href="{{url('/front_end/product/'.$p->id)}}">{{getProductAttr($p->id, 'prodname', $lct)}}</a></h3>
                                    <p class="manufacture_product"><a href="#">{{$categorynya}}</a></p>
                                </div>
                                <div class="product_thumb">
                                    <a class="primary_img" href="{{url('/front_end/product/'.$p->id)}}"><img src="{{url('/')}}{{$isimg1}}" alt=""></a>
                                    <a class="secondary_img" href="{{url('/front_end/product/'.$p->id)}}"><img src="{{url('/')}}{{$isimg2}}" alt=""></a>
                                    <!-- <div class="action_links">
                                        <ul>
                                            <li class="quick_button"><a href="#" data-toggle="modal" data-target="#modal_box" title="quick view"> <span class="lnr lnr-magnifier"></span></a></li>
                                            <li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><span class="lnr lnr-heart"></span></a></li>
                                            <li class="compare"><a href="compare.html" title="compare"><span class="lnr lnr-sync"></span></a></li>
                                        </ul>
                                    </div> -->
                                </div>
                                <div class="product_content">
                                    <!-- <div class="product_ratings">
                                        <ul>
                                            <li><a href="#"><i class="ion-star"></i></a></li>
                                            <li><a href="#"><i class="ion-star"></i></a></li>
                                            <li><a href="#"><i class="ion-star"></i></a></li>
                                            <li><a href="#"><i class="ion-star"></i></a></li>
                                            <li><a href="#"><i class="ion-star"></i></a></li>
                                        </ul>
                                    </div> -->
                                    <div class="product_footer d-flex align-items-center">
                                        <div class="price_box">
                                            <span class="regular_price">
                                                @if(is_numeric($p->price_usd))
                                                    $ {{$p->price_usd}}
                                                @else
                                                    {{$p->price_usd}}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!--product area end-->
<!-- Plugins JS -->
<script src="{{asset('front/assets/js/plugins.js')}}"></script>
@include('frontend.layouts.footer')