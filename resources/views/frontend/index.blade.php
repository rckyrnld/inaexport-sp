@include('frontend.layouts.header')
<!--slider area start-->
<style type="text/css">
    .row-menu{
        margin-top: 10%;
        margin-bottom: 10%;
    }

    .product_tab_button.nav div{
      margin: 2% 0 1% 0;
    }

    .product_tab_button.nav div a{
        font-size: 12px; 
        color: #34b1e5;
        font-family: 'Myriad-pro'; 
    }

    .product_tab_button.nav div a.active, .product_tab_button.nav div a:hover{
        text-decoration: none;
        font-weight: 500;
        font-size: 12px; 
        font-family: 'Myriad-pro'; 
        color: #fe8f00;
    }

    .for-act{
        text-decoration: none;
        opacity: 0.7;
    }

    .box-cu{
        width: 90%;
        background-color: white;
        /*border: 1px solid silver;*/
        border-radius: 20px;
        padding: 3%;
    }

    .button_form{
        width: 30%;
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
</style>
<?php 
    $loc = app()->getLocale(); 
    if($loc == "ch"){
        $lct = "chn";
    }else if($loc == "in"){
        $lct = "in";
    }else{
        $lct = "en";
    }

    $imgarray = ['agriculture','apparel','automotive','jewelry','health_beauty','electrics','furniture','industrial_parts','gift_card','food'];
?>
    <!--menu & category start-->
    <section class="slider_section mb-50" style="margin-bottom: 0px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <div class="categories_menu">
                        <div class="categories_title">
                            <h2 class="categori_toggle">@lang('frontend.home.popcategory')</h2>
                        </div>
                        <div class="categories_menu_toggle">
                            <ul>
                                @foreach($categoryutama as $key => $cu)
                                    <?php
                                        $catprod1 = getCategoryLevel(1, $cu->id, "");
                                        $nk = "nama_kategori_".$lct; 
                                        if($cu->$nk == NULL){
                                            $nk = "nama_kategori_en";
                                        }

                                        $textkat = $cu->$nk;
                                        if(strlen($textkat) > 31){
                                            $cut_text = substr($textkat, 0, 31);
                                            if ($textkat{31 - 1} != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                                $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                                $cut_text = substr($textkat, 0, $new_pos);
                                            }
                                            $kategorinya = $cut_text . '...';
                                        }else{
                                            $kategorinya = $textkat;
                                        }
                                        if($cu->logo != null){
                                            $imagenya = asset('uploads/Product/Icon').'/'.$cu->logo;
                                        } else {
                                            $imagenya = asset('front/assets/img/kategori/').'/'.$imgarray[$key].'.png';
                                        }
                                    ?>
                                    @if(count($catprod1) == 0)
                                        <li><a href="{{url('/front_end/list_product/category/'.$cu->id)}}" title="{{$textkat}}" style="font-size: 13.5px;"><img src="{{$imagenya}}" style="width: 25px; vertical-align: middle;">&nbsp;{{$kategorinya}}</a></li>
                                    @else
                                        <li class="menu_item_children categorie_list"><a href="{{url('/front_end/list_product/category/'.$cu->id)}}" title="{{$textkat}}" style="font-size: 13.5px;"><img src="{{$imagenya}}" style="width: 25px; vertical-align: middle;">&nbsp;{{$kategorinya}} <i class="fa fa-angle-right"></i></a>
                                            <ul class="categories_mega_menu">
                                                @foreach($catprod1 as $key => $c1)
                                                  @if($key < 19)
                                                    <?php
                                                        $catprod2 = getCategoryLevel(2, $cu->id, $c1->id);
                                                        $nk = "nama_kategori_".$lct; 
                                                        if($c1->$nk == NULL){
                                                            $nk = "nama_kategori_en";
                                                        }
                                                    ?>
                                                    <li class="menu_item_children next"><a href="{{url('/front_end/list_product/category/'.$c1->id)}}" style="text-transform: capitalize !important;">{{$c1->$nk}}</a></li>
                                                  @endif
                                                @endforeach
                                                @if(count($catprod1) > 19)
                                                <li class="menu_item_children"><a href="{{url('/front_end/list_product')}}" style="text-transform: capitalize !important;"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;@lang('frontend.home.morecategory')</a></li>
                                                @endif
                                            </ul>
                                        </li>
                                    @endif
                                @endforeach
                                <li id="cat_toggle"><a href="{{url('/front_end/list_product')}}"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;@lang('frontend.home.morecategory')</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-12">
                    <div class="row-menu">
                        <div class="row">
                            <div class="col-md-4">
                                <a href="{{url('/br_importir_all')}}"><img src="{{asset('front/assets/icon/inquiry.png')}}" alt="" class="img-menu"></a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{url('/br_importir')}}"><img src="{{asset('front/assets/icon/buying_request.png')}}" alt="" class="img-menu"></a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{url('/front_end/ticketing_support')}}"><img src="{{asset('front/assets/icon/ticketing.png')}}" alt="" class="img-menu"></a>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-4">
                                <a href="{{url('/front_end/event')}}"><img src="{{asset('front/assets/icon/event.png')}}" alt="" class="img-menu"></a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{url('/front_end/training')}}"><img src="{{asset('front/assets/icon/training.png')}}" alt="" class="img-menu"></a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{url('/front_end/research-corner')}}"><img src="{{asset('front/assets/icon/research_corner.png')}}" alt="" class="img-menu"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--menu & category end-->
    
    <!--buyer & seller start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <div class="row">
                          <div class="col-md-6 col-lg-6 col-12">
                            <center>
                            <?php
                                $url = '/login';
                                if(Auth::guard('eksmp')->user()){
                                    if(Auth::guard('eksmp')->user()->id_role == 2){
                                        $url = '/home';
                                    }else if(Auth::guard('eksmp')->user()->id_role == 3){
                                        $url = '/';
                                    }
                                }
                            ?>
                                @if(Auth::guard('eksmp')->user())
                                @if(Auth::guard('eksmp')->user()->id_role == 3)
                                <a href="{{url($url)}}" class="for-act">
                                @endif
                                @else
                                <a href="{{url($url)}}" class="for-act">
                                @endif
                                  <img src="{{asset('front/assets/icon/for-buyer.png')}}" alt="">
                                @if(Auth::guard('eksmp')->user())
                                @if(Auth::guard('eksmp')->user()->id_role == 3)
                                </a>
                                @endif
                                @else
                                </a>
                                @endif
                            </center>
                          </div>
                          <div class="col-md-6 col-lg-6 col-12">
                            <center>
                                @if(Auth::guard('eksmp')->user())
                                @if(Auth::guard('eksmp')->user()->id_role == 2)
                                <a href="{{url($url)}}" class="for-act">
                                @endif
                                @else
                                <a href="{{url($url)}}" class="for-act">
                                @endif
                                  <img src="{{asset('front/assets/icon/for-indonesia-exportir.png')}}" alt="" >
                                @if(Auth::guard('eksmp')->user())
                                @if(Auth::guard('eksmp')->user()->id_role == 2)
                                </a>
                                @endif
                                @else
                                </a>
                                @endif
                            </center>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--buyer & seller start-->

    <!--category product start-->
    <section class="product_area mb-50" style="background-color: #ddeffd;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_title" style="margin-bottom: 0px;">
                        <!-- <div class="row product_tab_button nav" role="tablist" style="background-color: inherit; width: 100%">
                            <div class="col-md-2">
                                
                            </div>
                        </div> -->
                        <div class="row product_tab_button nav justify-content-center" role="tablist" style="background-color: inherit; width: 100%">
                            <?php
                                $numb = 1;
                            ?>
                            @foreach($categoryutama2 as $cut)
                            <?php
                                $cls = "";
                                if($numb == 1){
                                    $cls = "active";
                                }
                            ?>
                            <div class="col-md-2 col-lg-2 col-4" align="center">
                                <?php
                                    $nkat = "nama_kategori_".$lct; 
                                    if($cut->$nkat == NULL){
                                        $nkat = "nama_kategori_en";
                                    }

                                    $num_char = 30;
                                    $textkat = $cut->$nkat;
                                    if(strlen($textkat) > 30){
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
                                <a class="tabnya {{$cls}}" data-toggle="tab" href="#tabke{{$cut->id}}" aria-controls="tabke{{$cut->id}}" aria-selected="true" title="{{$textkat}}" onclick="openTab('tabke{{$cut->id}}')">
                                    <img src="{{asset('front/assets/img/kategori/')}}/{{$imgarray[$numb-1]}}.png" alt="" style="height: 40px">
                                    <p>{{$kategorinya}}</p>
                                </a>
                            </div>
                            <?php $numb++; ?>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!--category product end-->
<br>
    <!--product category start-->
    <section class="product_area mb-50">
        <div class="container">
            <div class="tab-content" id="tabing-product">
                <?php
                    $numbe = 1;
                ?>
                @foreach($categoryutama2 as $cuta)
                    <?php
                        if($numbe == 1){
                            $clsnya = "active";
                        }else{
                            $clsnya = "";
                        }
                    ?>
                    <div class="tab-pane fade show {{$clsnya}} product" id="tabke{{$cuta->id}}" role="tabpanel">
                        <?php
                            $product = getProductByCategory($cuta->id);
                        ?>
                        @if(count($product) == 0)
                        <center>
                            <span style="font-size: 15px;">
                                @if($loc == "ch")
                                - 此类别的产品为空 -
                                @elseif($loc == "in")
                                - Produk dalam kategori ini kosong - 
                                @else
                                - Products in this category are empty -
                                @endif
                            </span>
                        </center>
                        @else
                        <div class="product_carousel product_column5 owl-carousel">
                                @foreach($product as $key => $p)
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
                                        $ukuran = '300px';
                                        if(Auth::guard('eksmp')->user()){
                                            $ukuran = '350px';
                                        }
                                    ?>
                                    <div class="single_product" style="height: {{$ukuran}};">
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
                                        ?>
                                        <div class="product_thumb" align="center">
                                            <center>
                                                <a class="primary_img" href="{{url('front_end/product/'.$p->id)}}"><img src="{{url('/')}}{{$isimg1}}" alt="" style="height: 170px;"></a>
                                            </center>
                                        </div>
                                        <div class="product_name grid_name">
                                            <p class="manufacture_product">
                                                <a href="{{url('front_end/list_product/category/'.$idcategory)}}" title="{{$categorynya}}" class="href-category">{{$category}}</a>
                                            </p>
                                            <h3>
                                                <a href="{{url('front_end/product/'.$p->id)}}" title="{{$prodn}}" class="href-name"><b>{{$prodnama}}</b></a>
                                            </h3>
                                            <h3>
                                                <a href="{{url('front_end/list_perusahaan/view/'.$p->id_itdp_company_user)}}" title="{{$compname}}" class="href-company"><span style="color: black;">by</span>&nbsp;&nbsp;{{$companame}}</a>
                                            </h3>
                                        </div>
                                        <div class="product_content grid_content">
                                            <div class="content_inner">
                                                <div class="product_footer d-flex align-items-center">
                                                    <div class="price_box">
                                                        @if(Auth::guard('eksmp')->user())
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
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product_content list_content">
                                            <div class="left_caption">
                                                <div class="product_name">
                                                    <h3>
                                                        <a href="{{url('front_end/product/'.$p->id)}}" title="{{$prodn}}" class="href-name" style="font-size: 15px !important;"><b>{{$prodn}}</b></a>
                                                    </h3>
                                                    <h3>
                                                        <a href="{{url('front_end/list_perusahaan/view/'.$p->id_itdp_company_user)}}" title="{{$compname}}" class="href-company"><span style="color: black;">by</span>&nbsp;&nbsp;{{$compname}}</a>
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
                                                    @if(Auth::guard('eksmp')->user())
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <?php $numbe++; ?>
                @endforeach
            </div>
        </div>
    </section>
    <!--product category end-->

    <!--regis start-->
    <section class="breadcrumbs_area" style="padding-top: 4%;padding-bottom: 4%; margin-bottom: 0px;" data-bgimg="{{asset('front/assets/icon/homepage2.png')}}">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-1"></div>
                        <div class="col-md-5" style="padding-top: 20px;">
                            <div class="box-cu">
                                <form action="{{url('/contact-us/send/')}}" method="POST">
                                    {{ csrf_field() }}
                                    <center><h5><b>@lang("frontend.cu-cu")</b></h5></center>
                                    <br>
                                   <div class="form-group row">
                                       <div class="col-md-12">
                                           <input type="text" id="id" class="form-control integer" name="name" autocomplete="off" placeholder="@lang("frontend.cu-fullname")" style="font-size: 13px;" required>
                                       </div>
                                   </div>

                                   <div class="form-group row">
                                       <div class="col-md-12">
                                           <input type="email" class="form-control" name="email" autocomplete="off" placeholder="@lang("frontend.cu-email")" style="font-size: 13px;" required>
                                       </div>
                                   </div>

                                   <div class="form-group row">
                                       <div class="col-md-12">
                                           <input type="text" class="form-control" name="subyek" autocomplete="off" placeholder="@lang("frontend.cu-subyek")" style="font-size: 13px;" required>
                                       </div>
                                   </div>

                                   <div class="form-group row">
                                       <div class="col-md-12">
                                           <textarea class="form-control" name="message" id="message" placeholder="@lang("frontend.cu-message")" style="height: 150px;font-size: 13px;"></textarea>
                                       </div>
                                   </div>
                              
                                   <div class="form-group row">
                                      <div class="col-md-12">
                                        <div align="left">
                                          <button class="btn btn-primary button_form" type="submit">@lang("button-name.submit")</button>
                                        </div>
                                      </div>
                                   </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--regis end-->

    <!--regis start-->
    <section class="product_area mb-50" style="background-color: #ddeffd; padding: 6%; margin-bottom: 0px;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                            @if($loc == "in")
                                <span style="font-size: 20px;">
                                    Buat akun Anda dan mulailah berbisnis <span style="color: #007bff;">skala internasional</span>
                                </span><br>
                            @elseif($loc == "ch")
                                <span style="font-size: 20px;">
                                    创建您的帐户并开始从事业务<span style="color: #007bff;">国际规模</span>
                                </span><br>
                            @else
                                <span style="font-size: 20px;">
                                    Create your account and start doing business on <span style="color: #007bff;">an international scale</span>
                                </span><br>
                            @endif
                            <span style="font-size: 12px; color: #007bff;">+ {{getCountData('itdp_company_users')}}</span>
                            @if($loc == "in")
                                <span style="font-size: 12px; color: silver;">pengusaha telah bergabung</span>
                            @elseif($loc == "ch")
                                <span style="font-size: 12px; color: silver;">位企业家加入</span>
                            @else
                                <span style="font-size: 12px; color: silver;">entrepreneurs have joined</span>
                            @endif
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                            <center>
                                <a href="{{url('/pilihregister')}}" class="btn btn-primary" style="width: 120px; font-size: 18px; border-radius: 30px;">@if($loc == 'ch') 寄存器 @elseif($loc == "in") Daftar @else Register @endif</a>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--regis end-->


<!-- Plugins JS -->
<script src="{{asset('front/assets/js/plugins.js')}}"></script>
@include('frontend.layouts.footer')
<script type="text/javascript">
    $(document).ready(function () {
        if(window.innerWidth <= 900){
            $( ".menu_item_children.next" ).on('click', function() {
                var href = $("a", this).attr('href');
                // window.location.href = href;
                // ada masalah dalam javascript template
            });
        } 
    });
    function openTab(tabname) {
        $('.tab-pane.product').removeClass('active');
        $('.tabnya').removeClass('active');
        $('#'+tabname).addClass('active');
    }
</script>