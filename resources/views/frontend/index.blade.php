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
        width: auto;
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
                                        if($p->minimum_order != null){
                                            $minorder = $p->minimum_order;
                                        }
                                        $ukuran = '340px';
                                        if(Auth::guard('eksmp')->user()){
                                            $ukuran = '375px';
                                        }
                                    ?>
                                    <div class="single_product" style="height: {{$ukuran}}; background-color: #fdfdfc; padding: 0px !important;">
                                        <?php
                                            //cut prod name
                                            $num_char = 19;
                                            $prodn = getProductAttr($p->id, 'prodname', $lct);
                                            if(strlen($prodn) > 19){
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
                                        <div class="product_thumb" align="center" style="background-color: #e8e8e4; height: 210px; border-radius: 10px 10px 0px 0px;">
                                                <a class="primary_img" href="{{url('front_end/product/'.$p->id)}}"><img src="{{url('/')}}{{$isimg1}}" alt="" style="vertical-align: middle; height: {{$sizeImg}}px; border-radius: 10px 10px 0px 0px; padding: {{$padImg}}"></a>
                                        </div>
                                        <div class="product_name grid_name" style="padding: 0px 13px 0px 13px;">
                                            <p class="manufacture_product">
                                                <a href="{{url('front_end/list_product/category/'.$idcategory)}}" title="{{$categorynya}}" class="href-category">{{$category}}</a>
                                            </p>
                                            <h3>
                                                <a href="{{url('front_end/product/'.$p->id)}}" title="{{$prodn}}" class="href-name"><b>{{$prodnama}}</b></a>
                                            </h3>
                                            <span style="font-size: 12px; font-family: 'Open Sans', sans-serif; ">
                                                @if(Auth::guard('eksmp')->user())
                                                    Price :
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
                                                        {{$pricenya}}
                                                    </span>
                                                    <br>
                                                @endif

                                                {{$order}}{{$minorder}}<br>
                                                <a href="{{url('front_end/list_perusahaan/view/'.$p->id_itdp_company_user)}}" title="{{$compname}}" class="href-company"><span style="color: black;">{{$by}}</span>&nbsp;&nbsp;{{$companame}}</a>
                                            </span>
                                        </div>
                                        
                                        <div class="product_content list_content">
                                            <div class="left_caption">
                                                <div class="product_name">
                                                    <h3>
                                                        <a href="{{url('front_end/product/'.$p->id)}}" title="{{$prodn}}" class="href-name" style="font-size: 15px !important;"><b>{{$prodn}}</b></a>
                                                    </h3>
                                                    <h3>
                                                        <a href="{{url('front_end/list_perusahaan/view/'.$p->id_itdp_company_user)}}" title="{{$compname}}" class="href-company"><span style="color: black;">{{$by}}</span>&nbsp;&nbsp;{{$compname}}</a>
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
                                                        $product_desc = strip_tags($product_desc, "<a><br><i><b><u><hr>");
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
                        <div class="col-md-6">
                            <br>
                            <div style="padding-left:10px;padding-right:10px;">
                                <p style="font-size:20px;"><b>@lang("login.lbl5")</b></p>
                                <p style="font-size:16px;">@lang("login.lbl6") <br> @lang("login.lbl7")
                                <br> @lang("login.lbl8")</p>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-5" style="padding-top: 20px;">
                            <div class="box-cu">
							<form class="form-horizontal" method="POST" action="{{ url('br_importir_next') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                                    <center><h5><b>@lang("login.forms.by1")</b></h5></center>
                                    <br>
                                   <div class="form-group row">
                                        <div class="col-md-12">
                                            <input type="text" style="color:black;font-size: 13px;" value="" name="subyek" id="subyek" class="form-control" placeholder="@lang('login.forms.by2')?" required>
                                        </div>
                                   </div>

                                   <div class="form-group row">
                                        <div class="col-md-12">
                                            <select style="color:black;font-size: 13px;" class="form-control" name="valid" id="valid" required>
                                                <option value="">@lang("login.forms.by10")</option>
                                                <option value="0">None</option>
                                                <option value="1">Valid within 1 day</option>
                                                <option value="3">Valid within 3 day</option>
                                                <option value="5">Valid within 5 day</option>
                                                <option value="7">Valid within 7 day</option>
                                                <option value="14">Valid within 2 week</option>
                                                <option value="30">Valid within 1 month</option>
                                            </select>
                                        </div>
                                   </div>

                                   <div class="form-group row">
                                        <div class="col-md-12">
                                            <textarea style="color:black; font-size: 13px;" value="" name="spec" id="spec" class="form-control" placeholder="@lang('login.forms.by4')"></textarea>
                                        </div>
                                   </div>

                                   <div class="form-group row">
                                       <div class="col-md-7">
                                           <input style="color:black; font-size: 13px;" type="number" min="1" name="eo" id="eo" class="form-control" placeholder="@lang('login.forms.by5')">
                                       </div>
                                       <div class="col-md-5">
                                           <select class="form-control" name="neo" id="neo" style="color: black; font-size: 12px;">
                                                <option value="">@lang("login.forms.by14")</option>
                                                <option value="Each">Each</option>
                                                <option value="Foot">Foot</option>
                                                <option value="Gallons">Gallons</option>
                                                <option value="Kilograms">Kilograms</option>
                                                <option value="Liters">Liters</option>
                                                <option value="Packs">Packs</option>
                                                <option value="Pairs">Pairs</option>
                                                <option value="Pieces">Pieces</option>
                                                <option value="Reams">Reams</option>
                                                <option value="Rods">Rods</option>
                                                <option value="Rolls">Rolls</option>
                                                <option value="Sets">Sets</option>
                                                <option value="Sheets">Sheets</option>
                                                <option value="Square Meters">Square Meters</option>
                                                <option value="Tons">Tons</option>
                                                <option value="Unit">Unit</option>
                                                <option value="令">令</option>
                                                <option value="件">件</option>
                                                <option value="加仑">加仑</option>
                                                <option value="包">包</option>
                                                <option value="千克">千克</option>
                                                <option value="升">升</option>
                                                <option value="单位">单位</option>
                                                <option value="卷">卷</option>
                                                <option value="吨">吨</option>
                                                <option value="套">套</option>
                                                <option value="对">对</option>
                                                <option value="平方米">平方米</option>
                                                <option value="张">张</option>
                                                <option value="根">根</option>
                                                <option value="每个">每个</option>
                                                <option value="英尺">英尺</option>
                                                <option value="集装箱">集装箱</option>
                                            </select>
                                       </div>
                                   </div>

                                   <div class="form-group row">
                                       <div class="col-md-7">
                                            <input style="color:black; font-size: 13px;" type="text" value="" name="tp" id="tp" class="form-control amount" placeholder="@lang('login.forms.by6')">
                                        </div>
                                        <div class="col-md-5">
                                            <select  class="form-control" name="ntp" id="ntp" style="color: black; font-size: 12px;">
                                                <option value="">@lang("login.forms.by14")</option>
                                                <option value="IDR">IDR</option>
                                                <option value="THB">THB</option>
                                                <option value="USD">USD</option>
                                            </select>
                                        </div>
                                   </div>
                              
                                   <div class="form-group row">
                                      <div class="col-md-12">
                                        <div align="left">
                                            <button type="submit" style="width: 100%;" class="btn btn-danger button_form">
                                                    @if($loc == 'ch')
                                                    立即发布购买请求
                                                    @elseif($loc == 'in')
                                                    Kirim Permintaan Pembelian Sekarang
                                                    @else
                                                    Post Buying Request Now
                                                    @endif 
											<i class="fa fa-arrow-right"></i>
                                            </button>
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
    $(function() {

        $('.amount').keyup( function() {
            $(this).val( formatAmount( $( this ).val() ) );
        });

    });

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

    function formatAmountNoDecimals( number ) {
        var rgx = /(\d+)(\d{3})/;
        while( rgx.test( number ) ) {
            number = number.replace( rgx, '$1' + '.' + '$2' );
        }
        return number;
    }

    function formatAmount( number ) {

        // remove all the characters except the numeric values
        number = number.replace( /[^0-9]/g, '' );

        // set the default value
        if( number.length == 0 ) number = "0.00";
        else if( number.length == 1 ) number = "0.0" + number;
        else if( number.length == 2 ) number = "0." + number;
        else number = number.substring( 0, number.length - 2 ) + '.' + number.substring( number.length - 2, number.length );
        
        // set the precision
        number = new Number( number );
        number = number.toFixed( 2 );    // only works with the "."

        // change the splitter to ","
        number = number.replace( /\./g, '' );

        // format the amount
        x = number.split( ',' );
        x1 = x[0];
        x2 = x.length > 1 ? ',' + x[1] : '';

        return formatAmountNoDecimals( x1 ) + x2;
    }
</script>