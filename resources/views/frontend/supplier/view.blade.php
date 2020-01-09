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
?>
<style>
    #catlist{
        font-size: 12px;
        color: #037CFF;
    }
    .list-group-item{
        background-color: #DDEFFD; 
        border: none;
    }

    .eksporter_img{
        border-radius: 50%;
        width: 50%;
    }

    .panel-srv{
        /*background-color: silver;*/
        color: black;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 20px;
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
                <div class="col-5">
                    <div class="breadcrumb_content" style="padding-bottom: 0px;">
                        <ul>
                            <li><a href="{{url('/')}}">@lang('frontend.proddetail.home')</a></li>
                            <li><a href="{{url('/front_end/list_perusahaan')}}">@lang('frontend.home.eksporter')</a></li>
                            <li>@lang('frontend.liseksportir.detailtitle')</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <?php
        //Image
        $img1 = $data->foto_profil;

        if($img1 == NULL){
            $isimg1 = '/front/assets/icon/icon logo.png';
        }else{
            $image1 = 'uploads/Profile/Eksportir/'.$data->id_user.'/'.$img1; 
            if(file_exists($image1)) {
              $isimg1 = '/uploads/Profile/Eksportir/'.$data->id_user.'/'.$img1; 
            }else {
              $isimg1 = '/front/assets/icon/icon logo.png';
            }  
        }
        $param = $data->id_user.'-'.getCompanyName($data->id_user);
    ?>

    <!--shop  area start-->
    <div class="shop_area shop_reverse">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <!--sidebar widget start-->
                    <aside class="sidebar_widget">
                        <div class="widget_inner">
                            <div class="widget_list widget_categories">
                                <center>
                                    <img src="{{url('/')}}{{$isimg1}}" alt="" class="eksporter_img">
                                </center>
                                <br>
                                <h6 style="text-transform: uppercase;"><b>{{$data->company}}</b></h6>
                                <br>
                                <table border="0" style="width: 100%; font-size: 13px;">
{{--                                    <tr>--}}
{{--                                        <td>--}}
{{--                                            <b>@lang('frontend.liseksportir.fax')</b>--}}
{{--                                        </td>--}}
{{--                                        <td>:</td>--}}
{{--                                        <td>{{$data->fax}}</td>--}}
{{--                                    </tr>--}}
                                    <tr>
                                        <td>
                                            <b>@lang('frontend.liseksportir.website')</b>
                                        </td>
                                        <td>:</td>
                                        <td>{{$data->website}}</td>
                                    </tr>
{{--                                    <tr>--}}
{{--                                        <td>--}}
{{--                                            <b>@lang('frontend.liseksportir.phone')</b>--}}
{{--                                        </td>--}}
{{--                                        <td>:</td>--}}
{{--                                        <td>{{$data->phone}}</td>--}}
{{--                                    </tr>--}}
                                </table>
                                <hr>
                                <h6 style="text-transform: uppercase;"><b>@lang('frontend.liseksportir.address')</b></h6>
                                <p style="font-size: 13px;">
                                    {{$data->addres}}, {{$data->city}}, {{getProvinceName($data->id_mst_province, $lct)}}
                                </p>
                                <hr>
{{--                                <span style="font-size: 13px;">--}}
{{--                                    @if($loc == "ch")--}}
{{--                                        或通过电子邮件与出口商联系：--}}
{{--                                    @elseif($loc == "in")--}}
{{--                                        Atau hubungi eksportir melalui email:--}}
{{--                                    @else--}}
{{--                                        Or contact exporter via email :--}}
{{--                                    @endif--}}
{{--                                    <br>--}}
{{--                                    <span style="color: #007bff;">{{$data->email}}</span>--}}
{{--                                </span>--}}
                            </div>
                        </div>
                    </aside>
                    <!--sidebar widget end-->
                    <!--sidebar widget start-->
                    <aside class="sidebar_widget">
                        <div class="widget_inner">
                            <div class="widget_list widget_categories">
                                <span style="text-transform: uppercase;"><b>@lang("frontend.cu-cu")</b></span><br>
                                <span style="font-size: 13px;">
                                    @if($loc == "ch")
                                        你需要更多信息？
                                    @elseif($loc == "in")
                                        Apakah Anda memerlukan informasi lebih lanjut?
                                    @else
                                        Do you need more information?
                                    @endif
                                </span>
                                <br>
                                <span style="color: red; font-size: 13px;">
                                    @if($loc == "ch")
                                        给我们发信息！
                                    @elseif($loc == "in")
                                        Kirim pesan kepada kami!
                                    @else
                                        Send us a message!
                                    @endif
                                </span>
                                <br><br>
                                <form action="{{url('/contact-us/send/')}}" method="POST">
                                    {{ csrf_field() }}
                                   <div class="form-group row">
                                       <div class="col-md-12">
                                           <input type="text" id="id" class="form-control integer" name="name" autocomplete="off" placeholder="@lang("frontend.cu-fullname")" style="font-size: 13px;" required>
                                           <input type="hidden" name="urlnya" id="urlnya" value="/front_end/list_perusahaan/view/{{$param}}">
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
                                           <textarea class="form-control" name="message" id="message" placeholder="@lang("frontend.cu-message")" style="font-size: 13px;" rows="3"></textarea>
                                       </div>
                                   </div>
                              
                                   <div class="form-group row">
                                      <div class="col-md-12">
                                          <button class="btn btn-primary button_form" type="submit" style="font-size: 13px; width: 100%;">@lang("button-name.submit")</button>
                                      </div>
                                   </div>
                                </form>
                            </div>
                        </div>
                    </aside>
                    <!--sidebar widget end-->
                </div>
                <div class="col-lg-9 col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs" id="">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#products-eks" data-toggle="tab" aria-controls="products-eks" aria-selected="false">@lang('frontend.home.product')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#services-eks" data-toggle="tab" aria-controls="services-eks" aria-selected="false">@lang('frontend.title-services')</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="tabjns">
                                <div class="tab-pane active" id="products-eks">
                                    <div class="row" style="margin: 0px; font-size: 14px;">
                                        <div class="col-3"></div>
                                        <div class="col-3" style="text-align: left;">
                                            <div class="breadcrumb_content">
                                                <div class="page_amount">
                                                    <p>
                                                        @if($loc == "ch")
                                                            <b>找到{{$coproduct}}个产品</b>
                                                        @elseif($loc == "in")
                                                            <b>{{$coproduct}} Produk</b> ditemukan
                                                        @else
                                                            <b>{{$coproduct}} Products</b> Found
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4" style="text-align: left;">
                                            <div class="breadcrumb_content">
                                                <form class="form-horizontal" enctype="multipart/form-data" method="GET" action="{{url('/front_end/list_perusahaan/view/'.$param)}}" id="formvekssort">
                                                {{ csrf_field() }}
                                                    <b>@lang('frontend.liseksportir.sortby')</b> <select name="shortprodeks" id="shortprodeks" style="border: none;">
                                                        <option value="" @if(isset($sortby)) @if($sortby == "") selected @endif @endif>@lang('frontend.liseksportir.default')</option>
                                                        <option value="new" @if(isset($sortby)) @if($sortby == "new") selected @endif @endif>@lang('frontend.liseksportir.newest')</option>
                                                        <option value="asc" @if(isset($sortby)) @if($sortby == "asc") selected @endif @endif>@lang('frontend.liseksportir.eksporternm')</option>
                                                    </select>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-2" style="text-align: right;">
                                            <div class="breadcrumb_content">
                                                <div class="shop_toolbar_btn">
                                                    <button data-role="grid_3" type="button" class="active btn-grid-4" data-toggle="tooltip" title="3" id="grid"></button>
                                                    <button data-role="grid_list" type="button" class="btn-list" data-toggle="tooltip" title="List" id="list"></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row shop_wrapper">
                                        @foreach($product as $pro)
                                            <?php
                                                //new or not
                                                if(date('m', strtotime($pro->created_at)) == date('m')){
                                                    $dis = "";
                                                }else{
                                                    $dis = "display: none;";
                                                }

                                                //category
                                                $cat1 = getCategoryName($pro->id_csc_product, $lct);
                                                $cat2 = getCategoryName($pro->id_csc_product_level1, $lct);
                                                $cat3 = getCategoryName($pro->id_csc_product_level2, $lct);

                                                if($cat3 == "-"){
                                                    if($cat2 == "-"){
                                                        $categorynya = $cat1;
                                                        $idcategory = $pro->id_csc_product;
                                                    }else{
                                                        $categorynya = $cat2;
                                                        $idcategory = $pro->id_csc_product_level1;
                                                    }
                                                }else{
                                                    $categorynya = $cat3;
                                                    $idcategory = $pro->id_csc_product_level2;
                                                }

                                                //Image
                                                $img1 = $pro->image_1;
                                                $img2 = $pro->image_2;

                                                if($img1 == NULL){
                                                    $isimg1 = '/image/notAvailable.png';
                                                }else{
                                                    $image1 = 'uploads/Eksportir_Product/Image/'.$pro->id.'/'.$img1; 
                                                    if(file_exists($image1)) {
                                                      $isimg1 = '/uploads/Eksportir_Product/Image/'.$pro->id.'/'.$img1;
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
                                                if($pro->minimum_order != null){
                                                    $minorder = $pro->minimum_order;
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
                                                    $image2 = 'uploads/Eksportir_Product/Image/'.$pro->id.'/'.$img2; 
                                                    if(file_exists($image2)) {
                                                      $isimg2 = '/uploads/Eksportir_Product/Image/'.$pro->id.'/'.$img2;
                                                    }else {
                                                      $isimg2 = '/image/notAvailable.png';
                                                    }  
                                                }
                                            ?>
                                            <div class="col-lg-4 col-md-4 col-12 ">
                                                <div class="single_product" style="height: {{$ukuran}}; background-color: #fdfdfc; padding: 0px !important;">
                                                    <div class="pro-type" style="{{$dis}}">
                                                        <span class="pro-type-content">
                                                             @if($loc == "ch")
                                                                新
                                                            @elseif($loc == "in")
                                                                BARU
                                                            @else
                                                                NEW
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <?php
                                                        //cut prod name
                                                        $num_char = 29;
                                                        $prodn = getProductAttr($pro->id, 'prodname', $lct);
                                                        if(strlen($prodn) > 29){
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
                                                        $compname = getCompanyName($pro->id_itdp_company_user);
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

                                                        $num_chark = 32;
                                                        if(strlen($categorynya) > 32){
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
                                                    <div class="product_thumb" align="center" style="background-color: #e8e8e4; height: 210px; border-radius: 10px 10px 0px 0px; vertical-align: middle;">
                                                        <a class="primary_img" href="{{url('front_end/product/'.$pro->id)}}" onclick="GoToProduct('{{$pro->id}}', event, this)"><img src="{{url('/')}}{{$isimg1}}" alt="" style="vertical-align: middle; height: {{$sizeImg}}px; border-radius: 10px 10px 0px 0px; padding: {{$padImg}}"></a>
                                                        <!-- <a class="secondary_img" href="{{url('front_end/product/'.$pro->id)}}"><img src="{{url('/')}}{{$isimg2}}" alt=""></a> -->
                                                    </div>
                                                    <div class="product_name grid_name" style="padding: 0px 13px 0px 13px;">
                                                        <p class="manufacture_product">
                                                            <a href="{{url('front_end/list_product/category/'.$idcategory)}}" title="{{$categorynya}}" class="href-category">{{$category}}</a>
                                                        </p>
                                                        <h3>
                                                            <a href="{{url('front_end/product/'.$pro->id)}}" title="{{$prodn}}" class="href-name" onclick="GoToProduct('{{$pro->id}}', event, this)"><b>{{$prodnama}}</b></a>
                                                        </h3>
                                                        <span style="font-size: 12px; font-family: 'Open Sans', sans-serif; ">
                                                            @if(!empty(Auth::guard('eksmp')->user()))
                                                                @if(Auth::guard('eksmp')->user()->status == 1)
                                                                Price :
                                                                    @if(is_numeric($pro->price_usd))
                                                                        <?php 
                                                                            $pricenya = "$ ".number_format($pro->price_usd,0,",",".");
                                                                            $price = $pricenya;
                                                                        ?>
                                                                    @else
                                                                        <?php 
                                                                            $price = $pro->price_usd;
                                                                            if(strlen($price) > 25){
                                                                                $cut_text = substr($price, 0, 25);
                                                                                if ($price{25 - 1} != ' ') { 
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
                                                            @endif

                                                            {{$order}}<span title="{{$minorder}}">{{$minordernya}}</span><br>
                                                            <a href="{{url('front_end/list_perusahaan/view/'.$param)}}" title="{{$compname}}" class="href-company"><span style="color: black;">{{$by}}</span>&nbsp;&nbsp;{{$companame}}</a>
                                                        </span>
                                                    </div>
                                                    <div class="product_content list_content" style="width: 100%;">
                                                        <div class="left_caption">
                                                            <div class="product_name">
                                                                <h3>
                                                                    <a href="{{url('front_end/product/'.$pro->id)}}" title="{{$prodn}}" class="href-name" style="font-size: 15px !important;" onclick="GoToProduct('{{$pro->id}}', event, this)"><b>{{$prodn}}</b></a>
                                                                </h3>
                                                                <h3>
                                                                    <a href="{{url('front_end/list_perusahaan/view/'.$param)}}" title="{{$compname}}" class="href-company"><span style="color: black;">by</span>&nbsp;&nbsp;{{$compname}}</a>
                                                                </h3>
                                                            </div>
                                                            <div class="product_desc">
                                                                <?php
                                                                    $proddesc = getProductAttr($pro->id, 'product_description', $lct);
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
                                                                    $product_desc = strip_tags($product_desc, "<br><i><b><u><hr>");
                                                                    $capacitynya = '-';
                                                                    if($pro->capacity != null){
                                                                        if($loc == "ch"){
                                                                            $capacitynya = '库存 '.$pro->capacity.' 件';
                                                                        } else if($loc == 'in'){
                                                                            $capacitynya = $pro->capacity.' dalam persediaan';
                                                                        } else {
                                                                            $capacitynya = $pro->capacity.' in stock';
                                                                        }
                                                                    }
                                                                ?>
                                                                <?php echo $product_desc; ?>
                                                            </div>
                                                        </div>
                                                        <div class="right_caption">
                                                            <div class="text_available">
                                                                <p>
                                                                    @lang('frontend.available'): 
                                                                    <span>{{$capacitynya}}</span>
                                                                </p>
                                                            </div>
                                                            <div class="price_box">
                                                                @if(!empty(Auth::guard('eksmp')->user()))
                                                                    @if(Auth::guard('eksmp')->user()->status == 1)
                                                                    <span class="current_price">
                                                                        @if(is_numeric($pro->price_usd))
                                                                            $ {{number_format($pro->price_usd,0,",",".")}}
                                                                        @else
                                                                            <span style="font-size: 13px;">
                                                                                {{$pro->price_usd}}
                                                                            </span>
                                                                        @endif
                                                                    </span>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <br>
                                    @if($coproduct > 12)
                                        <div class="pagination" style="float: right;">
                                            {{ $product->links() }}
                                        </div>
                                    @endif
                                </div>
                                <div class="tab-pane" id="services-eks">
                                    <div class="row" style="margin: 0px; font-size: 14px;">
                                        <div class="col-5"></div>
                                        <div class="col-3" style="text-align: left;">
                                            <div class="breadcrumb_content">
                                                <div class="page_amount">
                                                    <p>
                                                        @if($loc == "ch")
                                                            <b>找到{{count($service)}}个服务</b>
                                                        @elseif($loc == "in")
                                                            <b>{{count($service)}} Pelayanan</b> ditemukan
                                                        @else
                                                            <b>{{count($service)}} Services</b> Found
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4" style="text-align: left;">
                                            <div class="breadcrumb_content">
                                                <form class="form-horizontal" enctype="multipart/form-data" method="GET" action="{{url('/front_end/list_perusahaan/view/'.$param)}}" id="formsrvsort">
                                                {{ csrf_field() }}
                                                    <b>@lang('frontend.liseksportir.sortby')</b> <select name="shortsrveks" id="shortsrveks" style="border: none;">
                                                        <option value="" @if(isset($sortbysrv)) @if($sortbysrv == "") selected @endif @endif>@lang('frontend.liseksportir.default')</option>
                                                        <option value="new" @if(isset($sortbysrv)) @if($sortbysrv == "new") selected @endif @endif>@lang('frontend.liseksportir.newest')</option>
                                                        <option value="asc" @if(isset($sortbysrv)) @if($sortbysrv == "asc") selected @endif @endif>@lang('frontend.liseksportir.eksporternm')</option>
                                                    </select>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @foreach($service as $srv)
                                            <div class="col-lg-12 col-md-4 col-12" style="margin-bottom: 2%;">
                                                <div class="panel-srv">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h5><b>{{getServiceAttribute($srv->id ,'nama', $lcts)}}</b></h5>
                                                        </div>
                                                    </div><hr style="margin-top: 0px;">
                                                    <div class="row" style="font-size: 13px;">
                                                        <div class="col-md-6">
                                                            <label><b>Field of Work :</b></label><br>
                                                            <?php
                                                                $bidang = getServiceAttribute($srv->id ,'bidang', $lcts);
                                                                $bid = explode(', ', $bidang);
                                                                for ($b=0; $b < count($bid); $b++) { 
                                                                    echo $bid[$b].'<br>';
                                                                }
                                                            ?>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label><b>Skills :</b></label><br>
                                                            {{getServiceAttribute($srv->id ,'skill', $lcts)}}
                                                        </div>
                                                        <br>
                                                    </div><br>
                                                    <div class="row" style="font-size: 13px;">
                                                        <div class="col-md-6">
                                                            <label><b>Experiences :</b></label><br>
                                                            <?php echo getServiceAttribute($srv->id ,'pengalaman', $lcts); ?>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label><b>Links :</b></label><br>
                                                            <?php echo getServiceAttribute($srv->id ,'link', ''); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--shop toolbar end-->
                    <!--shop wrapper end-->
                </div>
            </div>
        </div>
    </div>
    <!--shop  area end-->
<!-- Plugins JS -->
<script src="{{asset('front/assets/js/plugins.js')}}"></script>
@include('frontend.layouts.footer')
<script type="text/javascript">
    $(document).ready(function () {

        $("#shortprodeks").on('change', function () {
            $('#formvekssort').submit();
        })

        $("#shortsrveks").on('change', function () {
            $('#formsrvsort').submit();
        })

        $('#grid').on('click', function(){
            $('.product_thumb').css({ "margin-top": "0px", "border-radius": "10px 10px 0px 0px" });
        })

        $('#list').on('click', function(){
            $('.product_thumb').css({ "margin-top": "60px", "border-radius": "0px 10px 10px 0px" });
        });
    });

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