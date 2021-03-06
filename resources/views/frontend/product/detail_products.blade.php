@include('frontend.layouts.header')
<?php 
    $loc = app()->getLocale(); 
    if($loc == "ch"){
        $lct = "chn";
        $by = "通过";
        $order = "最小订购量 : ";
    }else if($loc == "in"){
        $lct = "in";
        $by = "Oleh";
        $order = "Min Order : ";
    }else{
        $lct = "en";
        $by = "By";
        $order = "Min Order : ";
    }

    //get category
    $cat1 = getCategoryName($data->id_csc_product, $lct);
    $cat2 = getCategoryName($data->id_csc_product_level1, $lct);
    $cat3 = getCategoryName($data->id_csc_product_level2, $lct);

    $arrimg = [];

    $img1 = "image/notAvailable.png";
    // $img2 = "image/notAvailable.png";
    // $img3 = "image/notAvailable.png";
    // $img4 = "image/notAvailable.png";
    if($data->image_1 != NULL){
        $imge1 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_1;
        if(file_exists($imge1)) {
          $img1 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_1;
          array_push($arrimg, $img1);
        }
    }
    if($data->image_2 != NULL){
        $imge2 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_2;
        if(file_exists($imge2)) {
          $img2 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_2;
          array_push($arrimg, $img2);
        }
    }
    if($data->image_3 != NULL){
        $imge3 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_3;
        if(file_exists($imge3)) {
          $img3 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_3;
          array_push($arrimg, $img3);
        }
    }
    if($data->image_4 != NULL){
        $imge4 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_4;
        if(file_exists($imge4)) {
          $img4 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_4;
          array_push($arrimg, $img4);
        }
    }
?>

<style type="text/css">
    .kurs-coll{
        color: black; 
        border: none;
        background-color: #efefef;
    }

    .href-name {
        color: black;
    }

    .href-name:hover {
        text-decoration: none;
    }

    .href-company{
        text-transform: capitalize; 
        font-size: 11px; 
        font-family: 'Open Sans', sans-serif; 
        /*color: black;*/
    }

    .href-company:hover{
        text-decoration: none;
        color: black !important;
    }

    .href-category{
        text-transform: capitalize; 
        font-size: 11px !important; 
        font-family: 'Open Sans', sans-serif; 
    }

    .href-category:hover{
        text-decoration: none;
        /*color: #2777d0 !important;*/
    }
    .single_product:hover{
        box-shadow: 0 0 15px rgba(178,221,255,1); 
    }
</style>

    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="{{url('/')}}">@lang('frontend.proddetail.home')</a></li>
                            @if($data->id_csc_product == NULL)
                            <li><a href="{{url('/front_end/list_product')}}">@lang('frontend.proddetail.default')</a></li>
                            @else
                                @if($cat1 == "-")
                                    <li><a href="{{url('/front_end/list_product')}}">@lang('frontend.proddetail.default')</a></li>
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

                        <div id="img-1" class="zoomWrapper single-zoom" align="center">
                            <a href="#">
                                <img id="zoom1" src="{{url('/')}}/{{$img1}}" data-zoom-image="{{url('/')}}/{{$img1}}" alt="big-1" style="width: auto; height: 400px;">
                            </a>
                        </div>

                        @if(count($arrimg) != 0)
                        <div class="single-zoom-thumb" align="center">
                            <ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">
                                <?php
                                    for ($m=0; $m < count($arrimg); $m++) { 
                                ?>
                                        <li>
                                            <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{url('/')}}/{{$arrimg[$m]}}" data-zoom-image="{{url('/')}}/{{$arrimg[$m]}}">
                                                <img src="{{url('/')}}/{{$arrimg[$m]}}" alt="zo-th-1" style="width: auto; height: 105px;" />
                                            </a>

                                        </li>
                                <?php
                                    }
                                ?>
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product_d_right">
                            <h1>{{getProductAttr($data->id, 'prodname', $lct)}}</h1>
                            <div class="price_box">
                                <?php
                                    $usd = NULL;
                                    if(is_numeric($data->price_usd)){
                                        $usd = $data->price_usd;
                                    }else{

                                    }
                                ?>
                                @if(!empty(Auth::guard('eksmp')->user()))
                                    @if(Auth::guard('eksmp')->user()->status == 1)
                                    <span class="current_price">
                                        @if(is_numeric($data->price_usd))
                                            $ {{number_format($data->price_usd,0,",",".")}}
                                        @else
                                            {{$data->price_usd}}
                                        @endif
                                    </span>
                                    @endif
                                @endif
                                <!--@if(!empty(Auth::guard('eksmp')->user()))
                                    @if(Auth::guard('eksmp')->user()->status == 1)
                                    <div class="list-group" id="kurslist">
                                        <a onclick="openKurs('kurs')" href="#kurs" class="list-group-item" data-toggle="collapse" data-parent="#MainMenus" style="color: black; border: none; text-align: right"><span class="badge badge-secondary">$</span>&nbsp;&nbsp;USD&nbsp;&nbsp;<i class="fa fa-chevron-down" aria-hidden="true" id="icon-kurs"></i></a>
                                        
                                        <div class="collapse" id="kurs">
                                            <div class="row" style="border: 1px solid silver; border-radius: 3px; background-color: #efefef;">
                                                @if($usd != NULL)
                                                    <?php
                                                        //for ($n=0; $n < count($imgarr); $n++) { 
                                                    ?>
                                                    @if($n == 0 || $n == 6)
                                                    <div class="col-md-6" style="padding-left: 0px; padding-right: 0px;">
                                                    @endif
                                                        <div class="list-group-item kurs-coll">
                                                            <table border="0" style="width: 100%; font-size: 12px;" cellspacing="5" cellpadding="5">
                                                                <tr>
                                                                    <td width="15%"><img src="{{asset('front/assets/icon/negara/'.$imgarr[$n])}}"></td>
                                                                    <td width="55%">{{$smtarr[$n]}} {{$nmtarr[$n]}}</td>
                                                                    <td width="30%" style="text-align: right;">
                                                                        <?php
                                                                            /*$mtuang = $smtarr[$n];
                                                                            $konver = $rates->$mtuang;
                                                                            $convert = round($usd * $konver, 2);
                                                                            echo number_format($convert,2,",",".");*/
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    @if($n == 5 || $n == 11)
                                                    </div>
                                                    @endif
                                                    <?php
                                                        //}
                                                    ?>
                                                @else
                                                    <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                                        <div class="list-group-item kurs-coll">
                                                            <table border="0" style="width: 100%; font-size: 15px;" cellspacing="5" cellpadding="5">
                                                                <tr>
                                                                    <td width="100%" style="vertical-align: middle; text-align: center;">
                                                                            @if($loc == "ch")
                                                                            - 无法使用 -
                                                                            @elseif($loc == "in")
                                                                            - Tidak Tersedia -
                                                                            @else
                                                                            - Not Available -
                                                                            @endif
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endif-->
                            </div>
                            <div class="product_desc">
                                <?php echo nl2br(getProductAttr($data->id, 'product_description', $lct)); ?>
                            </div>
                            <div class="product_variant quantity">
                                <label>@lang('frontend.proddetail.minorder')</label>
                                <input type="text" name="minorder" value="{{$data->minimum_order}}" readonly>

                            </div><br>
                            <div class="">
                                <?php
                                    if(Auth::guard('eksmp')->user()){
                                        if(Auth::guard('eksmp')->user()->id_role == 2){
                                            $jns = "eksportir";
                                        }else if(Auth::guard('eksmp')->user()->id_role == 3){
                                            $jns = "importir";
                                        }
                                    }else{
                                        $jns = "not login";
                                    }
                                ?>
                                    <!-- <a href="{{url('/front_end/inquiry_product')}}/{{$data->id}}" class="btn btn-primary" style="width: 50%;"><i class="fa fa-envelope" aria-hidden="true"></i> @lang('product.inquiry')</a> -->
                                    <button class="btn btn-primary" style="width: 50%;" onclick="openInquiry('{{$jns}}')"><i class="fa fa-envelope" aria-hidden="true"></i> @lang('product.inquiry')</button>
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
                                    <?php echo nl2br(getProductAttr($data->id, 'product_description', $lct)); ?>
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
                                $cat1 = getCategoryName($p->id_csc_product, $lct);
                                $cat2 = getCategoryName($p->id_csc_product_level1, $lct);
                                $cat3 = getCategoryName($p->id_csc_product_level2, $lct);

                                if($cat3 == "-"){
                                    if($cat2 == "-"){
                                        $categorynya = $cat1;
                                        $idcategory = $p->id_csc_product;
                                    }else{
                                        $categorynya = $cat2;
                                        $idcategory = $p->id_csc_product_level1;
                                    }
                                }else{
                                    $categorynya = $cat3;
                                    $idcategory = $p->id_csc_product_level2;
                                }

                                $img1 = $p->image_1;
                                $img2 = $p->image_2;

                                if($img1 == NULL){
                                    $isimg1 = '/image/notAvailable.png';
                                }else{
                                    $image1 = 'uploads/Eksportir_Product/Image/'.$p->id.'/'.$img1; 
                                    if(file_exists($image1)) {
                                      $isimg1 = '/uploads/Eksportir_Product/Image/'.$p->id.'/'.$img1;
                                    }else {
                                      $isimg1 = '/image/notAvailable.png';
                                    }  
                                }

                                $cekImage = explode('.', $img1);
                                $sizeImg = 210;
                                $padImg = '0px';
                                if($cekImage[(count($cekImage)-1)] == 'png'){
                                    $sizeImg = 190;
                                    $padImg = '10px 5px 0px 5px';
                                }
                                $minorder = '-';
                                $minordernya = '-';
                                if($p->minimum_order != null){
                                    $minorder = $p->minimum_order;
                                    if(strlen($minorder) > 18){
                                        $cut_desc = substr($minorder, 0, 18);
                                        if ($minorder{18 - 1} != ' ') { 
                                            $new_pos = strrpos($cut_desc, ' '); 
                                            $cut_desc = substr($minorder, 0, $new_pos);
                                        }
                                        $minordernya = $cut_desc . '...';
                                    }else{
                                        $minordernya = $minorder;
                                    }
                                }
                                $ukuran = '340px';

                                if(!empty(Auth::guard('eksmp')->user())){
                                    if(Auth::guard('eksmp')->user()->status == 1){
                                        $ukuran = '375px';
                                    }
                                }

                                if($img2 == NULL){
                                    $isimg2 = '/image/notAvailable.png';
                                }else{
                                    $image2 = 'uploads/Eksportir_Product/Image/'.$p->id.'/'.$img2; 
                                    if(file_exists($image2)) {
                                      $isimg2 = '/uploads/Eksportir_Product/Image/'.$p->id.'/'.$img2;
                                    }else {
                                      $isimg2 = '/image/notAvailable.png';
                                    }  
                                }
                            ?>
                            <div class="single_product" style="border:0px!important;height: {{$ukuran}}; background-color: #fdfdfc; padding: 0px !important;">
                                <?php
                                    //cut prod name
                                    $num_char = 20;
                                    $prodn = getProductAttr($p->id, 'prodname', $lct);
                                    if(strlen($prodn) > 20){
                                        $cut_text = substr($prodn, 0, $num_char);
                                        if ($prodn{$num_char - 1} != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                            $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                            $cut_text = substr($prodn, 0, $new_pos);
                                        }
                                        $prodnama = $cut_text . '...';
                                    }else{
                                        $prodnama = $prodn;
                                    }

                                    //cut company
                                    $num_charp = 25;
                                    $compname = getCompanyName($p->id_itdp_company_user);
                                    if(strlen($compname) > 25){
                                        $cut_text = substr($compname, 0, $num_charp);
                                        if ($compname{$num_charp - 1} != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                            $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                            $cut_text = substr($compname, 0, $new_pos);
                                        }
                                        $companame = $cut_text . '...';
                                    }else{
                                        $companame = $compname;
                                    }

                                    $num_chark = 25;
                                    if(strlen($categorynya) > 25){
                                        $cut_text = substr($categorynya, 0, $num_chark);
                                        if ($categorynya{$num_chark - 1} != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                            $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                            $cut_text = substr($categorynya, 0, $new_pos);
                                        }
                                        $category = $cut_text . '...';
                                    }else{
                                        $category = $categorynya;
                                    }
                                    $param = $p->id_itdp_company_user.'-'.getCompanyName($p->id_itdp_company_user);
                                ?>
                                <div class="product_thumb" align="center" style="background-color: #e8e8e4; height: 210px; border-radius: 0px 0px 0px 0px;">
                                    <a class="primary_img" href="{{url('front_end/product/'.$p->id)}}" onclick="GoToProduct('{{$p->id}}', event, this)"><img src="{{url('/')}}{{$isimg1}}" alt="" style="vertical-align: middle; height: {{$sizeImg}}px; border-radius: 0px 0px 0px 0px; padding: {{$padImg}}"></a>
                                    <!-- <a class="secondary_img" href="{{url('front_end/product/'.$p->id)}}"><img src="{{url('/')}}{{$isimg2}}" alt=""></a> -->
                                </div>
                                <div class="product_name grid_name" style="padding: 0px 13px 0px 13px;">
                                    <p class="manufacture_product">
                                        <a href="{{url('front_end/list_product/category/'.$idcategory)}}" title="{{$categorynya}}" class="href-category">{{$category}}</a>
                                    </p>
                                    <h3>
                                        <a href="{{url('front_end/product/'.$p->id)}}" title="{{$prodn}}" class="href-name" onclick="GoToProduct('{{$p->id}}', event, this)"><b>{{$prodnama}}</b></a>
                                    </h3>
                                    <span style="font-size: 12px; font-family: 'Open Sans', sans-serif; ">
                                        @if(!empty(Auth::guard('eksmp')->user()))
                                            @if(Auth::guard('eksmp')->user()->status == 1)
                                            
                                                @if(is_numeric($p->price_usd))
                                                    <?php 
                                                        $pricenya = "$ ".number_format($p->price_usd,0,",",".");
                                                        $price = $pricenya;
                                                    ?>
                                                @else
                                                    <?php 
                                                        $price = $p->price_usd;
                                                        if(strlen($price) > 18){
                                                            $cut_text = substr($price, 0, 18);
                                                            if ($price{18 - 1} != ' ') { 
                                                                $new_pos = strrpos($cut_text, ' ');
                                                                $cut_text = substr($price, 0, $new_pos);
                                                            }
                                                            $pricenya = $cut_text . '...';
                                                        }else{
                                                            $pricenya = $price;
                                                        }
                                                    ?>
                                                @endif
                                            <span style="color: #fd5018;" title="{{$price}}">
                                               <b> {{$pricenya}} </b>
                                            </span>
                                            <br>
                                            @endif
                                        @endif

                                        {{$order}}<span title="{{$minorder}}">{{$minordernya}}</span><br>
                                        <a href="{{url('front_end/list_perusahaan/view/'.$param)}}" title="{{$compname}}" class="href-company"><span style="color: black;">{{$by}}</span>&nbsp;&nbsp;{{$companame}}</a>
                                    </span>
                                </div>
                                <div class="product_content list_content">
                                    <div class="left_caption">
                                        <div class="product_name">
                                            <h3>
                                                <a href="{{url('front_end/product/'.$p->id)}}" title="{{$prodn}}" class="href-name" style="font-size: 15px !important;" onclick="GoToProduct('{{$p->id}}', event, this)"><b>{{$prodn}}</b></a>
                                            </h3>
                                            <h3>
                                                <a href="{{url('front_end/list_perusahaan/view/'.$param)}}" title="{{$compname}}" class="href-company"><span style="color: black;">by</span>&nbsp;&nbsp;{{$compname}}</a>
                                            </h3>
                                        </div>
                                        <div class="product_desc">
                                            <?php
                                                $proddesc = getProductAttr($p->id, 'product_description', $lct);
                                                $num_desc = 350;
                                                if(strlen($proddesc) > $num_desc){
                                                    $cut_desc = substr($proddesc, 0, $num_desc);
                                                    if ($proddesc{$num_desc - 1} != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                                        $new_pos = strrpos($cut_desc, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                                        $cut_desc = substr($proddesc, 0, $new_pos);
                                                    }
                                                    $product_desc = $cut_desc . '...';
                                                }else{
                                                    $product_desc = $proddesc;
                                                }
                                                $product_desc = strip_tags($product_desc, "<p><a><br><i><b><u><hr><strong><small>");
                                            ?>
                                            <?php echo $product_desc; ?>
                                        </div>
                                    </div>
                                    <div class="right_caption">
                                        <div class="text_available">
                                            <p>
                                                @lang('frontend.available'): 
                                                @if($loc == "ch")
                                                    <span>库存{{$p->capacity}}件</span>
                                                @elseif($loc == "in")
                                                    <span>{{$p->capacity}} dalam persediaan</span>
                                                @else
                                                    <span>{{$p->capacity}} in stock</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="price_box">
                                            @if(!empty(Auth::guard('eksmp')->user()))
                                                @if(Auth::guard('eksmp')->user()->status == 1)
                                                <span class="current_price">
                                                    @if(is_numeric($p->price_usd))
                                                        $ {{number_format($p->price_usd,0,",",".")}}
                                                    @else
                                                        <span style="font-size: 13px;">
                                                            {{$p->price_usd}}
                                                        </span>
                                                    @endif
                                                </span>
                                                @endif
                                            @endif
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
<?php
    if($loc == "ch"){
        $alertnot = "请登录进行查询！";
        $alerteks = "只有买家可以查询！";
    }else if($loc == "in"){
        $alertnot = "Silahkan Login untuk melakukan Inquiry!";
        $alerteks = "Hanya pembeli yang dapat melakukan Inquiry!";
    }else{
        $alertnot = "Please Sign In to do an Inquiry!";
        $alerteks = "Only buyers can make an Inquiry!";
    }
?>
<!-- Plugins JS -->
<script src="{{asset('front/assets/js/plugins.js')}}"></script>
@include('frontend.layouts.footer')
<script type="text/javascript">
    function openKurs(col) {
        if($("#icon-"+col).hasClass("fa-chevron-down")){
            $('#icon-'+col).removeClass('fa-chevron-down');
            $('#icon-'+col).addClass('fa-chevron-up');
        }else{
            $('#icon-'+col).removeClass('fa-chevron-up');
            $('#icon-'+col).addClass('fa-chevron-down');
        }
    }

    function openInquiry(bagian) {
        if(bagian == "not login"){
            alert("{{$alertnot}}");
        }else if(bagian == "eksportir"){
            alert("{{$alerteks}}");
        }else{
            window.location = "{{url('/front_end/inquiry_product/'.$data->id)}}";
        }
    }

    function GoToProduct(id, e, obj){
        e.preventDefault();
        var token = "{{ csrf_token() }}";
        $.ajax({
            url: "{{route('product.hot')}}",
            type: 'post',
            data: {'_token':token,id:id},
            dataType: 'json',
            success:function(response){
                if(response == 'ok'){
                    location.href = obj.href;
                }
            }
        });
    }
</script>