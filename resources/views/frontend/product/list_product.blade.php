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
    .select2-results__options{
        font-size:12px !important;
    }
    .select2-selection__rendered {
        font-size: 12px !important;
    }
    .list-group-item{
        background-color: #DDEFFD; 
        border: none;
    }

    .hover-none:hover,.hover-none:active{
        color: #007bff !important;
        cursor: context-menu;
        text-decoration: none;
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
    .cat-prod:hover{text-decoration: none;}
    #delete_cat{ margin-left:10px; font-size:12px; color: #c4a6a6; cursor: pointer; }
    .select2-container, .select2-dropdown, .select2-search, .select2-results {
        -webkit-transition: none !important;
        -moz-transition: none !important;
        -ms-transition: none !important;
        -o-transition: none !important;
        transition: none !important;
        
    }
    .breadcrumbs_area > li + li:before {
    content: "\3E"
    }
</style>
<!--breadcrumbs area start-->
<div class="breadcrumbs_area">
            @if(isset($page))   
                @if(isset($banner))
                <div class="container-fluid" style="padding-left: 0px;padding-right: 0px;">
                <p>
                    <img class="img-fluid" style="width:100%; max-width: 100%;heigth:231px" src="{{asset('uploads/banner/')}}/{{$banner->file}}" alt="">
                </p>
                </div>
                @endif
            @endif
        <div class="container">
            <div class="row">
                <div class="col-5">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="{{url('/')}}">@lang('frontend.proddetail.home')</a></li>
                            @if($catActive == NULL)
                            <li><a href="{{url('/front_end/list_product')}}">@lang('frontend.proddetail.default')</a></li>
                            @else
                            <?php echo $catActive; ?>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-3" style="text-align: right;">
                    <div class="breadcrumb_content">
                        <div class="page_amount">
                            <p>
                                @if($loc == "ch")
                                    <b>找到5206个产品</b>
                                @elseif($loc == "in")
                                    <b>{{$coproduct}} Produk</b> ditemukan
                                @else
                                    <b>{{$coproduct}} Products</b> Found
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-3" style="text-align: right;">
                    <div class="breadcrumb_content">
                        
                    @if(isset($page))
                        <b>@lang('frontend.liseksportir.sortby')</b> <select name="sortbyproduct" id="sortbyproduct" style="border: none;"class="sortproductnya" disabled>
                                <option value="default" @if(isset($sortbyproduct)) @if($sortbyproduct == "default") selected @endif @endif>@lang('frontend.liseksportir.default')</option>
                                <option value="new" @if(isset($sortbyproduct)) @if($sortbyproduct == "new") selected @endif @endif>@lang('frontend.liseksportir.newest')</option>
                                @if(!empty(Auth::guard('eksmp')->user()))
                                    @if(Auth::guard('eksmp')->user()->status == 1)
                                    <option value="lowhigh" @if(isset($sortbyproduct)) @if($sortbyproduct == "lowhigh") selected @endif @endif>@lang('frontend.proddetail.pricelh')</option>
                                    <option value="highlow" @if(isset($sortbyproduct)) @if($sortbyproduct == "highlow") selected @endif @endif>@lang('frontend.proddetail.pricehl')</option>
                                    @endif
                                @endif
                                <option value="asc" @if(isset($sortbyproduct)) @if($sortbyproduct == "asc") selected @endif @endif>@lang('frontend.liseksportir.prodnm')</option>
                            </select>
                    @else
                        <b>@lang('frontend.liseksportir.sortby')</b> <select name="sortbyproduct" id="sortbyproduct" style="border: none;"class="sortproductnya" >
                                    <option value="default" @if(isset($sortbyproduct)) @if($sortbyproduct == "default") selected @endif @endif>@lang('frontend.liseksportir.default')</option>
                                    <option value="new" @if(isset($sortbyproduct)) @if($sortbyproduct == "new") selected @endif @endif>@lang('frontend.liseksportir.newest')</option>
                                    @if(!empty(Auth::guard('eksmp')->user()))
                                        @if(Auth::guard('eksmp')->user()->status == 1)
                                        <option value="lowhigh" @if(isset($sortbyproduct)) @if($sortbyproduct == "lowhigh") selected @endif @endif>@lang('frontend.proddetail.pricelh')</option>
                                        <option value="highlow" @if(isset($sortbyproduct)) @if($sortbyproduct == "highlow") selected @endif @endif>@lang('frontend.proddetail.pricehl')</option>
                                        @endif
                                    @endif
                                    <option value="asc" @if(isset($sortbyproduct)) @if($sortbyproduct == "asc") selected @endif @endif>@lang('frontend.liseksportir.prodnm')</option>
                                </select>
                    @endif
                    </div>
                </div>
                <div class="col-1 grid_list_btn" style="text-align: right;">
                    <div class="breadcrumb_content">
                        <div class="shop_toolbar_btn">
                            <button data-role="grid_3" type="button" class="active btn-grid-3" data-toggle="tooltip" title="3" id="grid"></button>
                            <button data-role="grid_list" type="button" class="btn-list" data-toggle="tooltip" title="List" id="list"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!--shop  area start-->
    <div class="shop_area shop_reverse">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <!--sidebar widget start-->
                    <aside class="sidebar_widget">
                        <div class="widget_inner">
                            <div class="widget_list widget_categories">
                                <h2>@lang('frontend.liseksportir.category')</h2>
                                <?php
                                    if($loc == "ch"){
                                        $srchcatlang = "搜索类别";
                                    }else if($loc == "in"){
                                        $srchcatlang = "Cari Kategori";
                                    }else{
                                        $srchcatlang = "Search Category";
                                    }
                                ?>
                                @if(isset($page))
                                    <input type="text" class="form-control" id="cari_kategori" name="cari_kategori" disabled placeholder="{{$srchcatlang}}" style="font-size: 12px;">
                                @else
                                    <input type="text" class="form-control" id="cari_kategori" name="cari_kategori" placeholder="{{$srchcatlang}}" style="font-size: 12px;">
                                @endif
                                <br>
                                <div class="list-group list-group-flush" id="catlist">
                                    @foreach($categoryutama as $cu)
                                        <?php
                                            $catprod1 = getCategoryLevelNew(1, $cu->id, "");
                                            $nk = "nama_kategori_".$lct; 
                                            if($cu->$nk == NULL){
                                                $nk = "nama_kategori_en";
                                            }
                                        ?>
                                        @if(count($catprod1) == 0)
                                        
                                            @if(isset($page))
                                            <a class="list-group-item">{{$cu->$nk}}</a>
                                            @else
                                            <a href="{{url('/front_end/list_product/category/'.$cu->id)}}" class="list-group-item">{{$cu->$nk}}</a>
                                            @endif
                                        @else
                                            <div class="list-group-item">
                                                @if(isset($page))
                                                <a class="cat-prod">  {{$cu->$nk}}</a><a ><i class="fa fa-chevron-down" aria-hidden="true" style="float: right; margin-right: -10px;" id="fontdrop{{$cu->id}}"></i></a>
                                                @else
                                                <a class="cat-prod" href="{{url('/front_end/list_product/category/'.$cu->id)}}"> {{$cu->$nk}}</a><a onclick="openCollapse(' {{$cu->id}}')"href="#menus{{$cu->id}}" data-toggle="collapse" data-parent="#MainMenu"><i class="fa fa-chevron-down" aria-hidden="true" style="float: right; margin-right: -10px;" id="fontdrop{{$cu->id}}"></i></a>
                                                @endif
                                            </div>
                                                <div class="collapse" id="menus{{$cu->id}}">
                                                    @foreach($catprod1 as $cat1)
                                                     <?php
                                                        $catprod2 = getCategoryLevelNew(2, $cu->id, $cat1->id);
                                                        $nk = "nama_kategori_".$lct; 
                                                        if($cat1->$nk == NULL){
                                                            $nk = "nama_kategori_en";
                                                        }
                                                    ?>
                                                    @if(count($catprod2) == 0 )
                                                        <a href="{{url('/front_end/list_product/category/'.$cat1->id)}}" class="list-group-item" style="margin-left: 10px;">{{$cat1->$nk}}</a>
                                                    @else
                                                        <div class="list-group-item" style="margin-left: 10px;">
                                                            <a class='cat-prod' href="{{url('/front_end/list_product/category/'.$cat1->id)}}"> {{$cat1->$nk}} </a>
                                                            <a onclick="openCollapse('{{$cat1->id}}')" href="#menus{{$cat1->id}}" data-toggle="collapse" data-parent="#SubMenu"><i class="fa fa-chevron-down" aria-hidden="true" style="float: right; margin-right: -10px;" id="fontdrop{{$cat1->id}}"></i></a>
                                                        </div>
                                                            <div class="collapse" id="menus{{$cat1->id}}">
                                                                @foreach($catprod2 as $cat2)
                                                                <?php
                                                                    $catprod2 = getCategoryLevelNew(2, $cu->id, $cat1->id);
                                                                    $nk = "nama_kategori_".$lct; 
                                                                    if($cat2->$nk == NULL){
                                                                        $nk = "nama_kategori_en";
                                                                    }
                                                                ?>
                                                                <a href="{{url('/front_end/list_product/category/'.$cat2->id)}}" class="list-group-item" style="margin-left: 20px;">{{$cat2->$nk}}</a>
                                                                @endforeach
                                                            </div>
                                                    @endif
                                                    @endforeach
                                                </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </aside>
                    <!--sidebar widget end-->
                    <!--sidebar widget start-->
                    <aside class="sidebar_widget">
                        <div class="widget_inner">
                            <div class="widget_list widget_categories">
                                <!-- <h2>Highlight</h2> -->
                                <h2>@lang('frontend.listprod.advanced')</h2>
                                <h2 style="margin-bottom: 0px; font-size: 14px;">@lang('frontend.home.product')</h2>
                                
                                @if(isset($page))
                                    <input type="text" class="form-control" id="cari_advance" name="cari_advance" disabled placeholder="@lang('frontend.home.cariproduct')" style="font-size: 12px;margin-bottom: 20px;">
                                @else
                                    <input type="text" class="form-control" id="cari_advance" name="cari_advance" placeholder="@lang('frontend.home.cariproduct')" style="font-size: 12px;margin-bottom: 20px;">
                                @endif
                                <h2 style="margin-bottom: 0px; font-size: 14px;">@lang('research-corner.kategori')</h2>
                                
                                @if(isset($page))
                                    <select class="form-control" id="cari_cat_advance" name="cari_cat_advance" disabled>
                                        <option></option>
                                    </select>
                                @else
                                    <select class="form-control" id="cari_cat_advance" name="cari_cat_advance">
                                        <option></option>
                                    </select>
                                @endif
                                <!-- <input type="text" class="form-control"> -->
                                <h2 style="margin-top: 20px; margin-bottom: 20px; font-size: 15px;">@lang('frontend.listprod.highlight')</h2>
                                <?php
                                    $checkedna = '';
                                    $checkedhot = '';
                                    $hlsortnya = '';
                                    if(isset($hl_sort)){
                                        if (strstr($hl_sort, '|')){
                                            $hlist = explode('|', $hl_sort);
                                        }else{
                                            $hlist = [$hl_sort];
                                        }

                                        for ($k=0; $k < count($hlist); $k++) { 
                                            if($hlist[$k] == "new"){
                                                $checkedna = 'checked="true"';
                                            }
                                            if($hlist[$k] == "hot"){
                                                $checkedhot = 'checked="true"';
                                            }
                                        }

                                        $hlsortnya = $hl_sort;
                                    }
                                ?>
                                <ul id="highlightlist" style="margin-bottom: 0px;">
                                    <li>
                                    @if(isset($page))
                                        <input type="checkbox" name="checkhl" value="hot" id="checkhl" class="check_hl" onclick="getProduct(this.value, this.checked)" disabled {{$checkedhot}}>
                                    @else
                                        <input type="checkbox" name="checkhl" value="hot" id="checkhl" class="check_hl" onclick="getProduct(this.value, this.checked)" {{$checkedhot}}>
                                    @endif
                                        <a href="#" class="hover-none">@lang('frontend.listprod.hotprod') ({{$countHot}})</a>
                                        <span class="checkmark"></span>
                                    </li>
                                    <li>
                                    @if(isset($page))
                                        <input type="checkbox" name="checkhl" value="new" id="checkhl" class="check_hl" onclick="getProduct(this.value, this.checked)" disabled {{$checkedna}}>
                                    @else
                                        <input type="checkbox" name="checkhl" value="new" id="checkhl" class="check_hl" onclick="getProduct(this.value, this.checked)" {{$checkedna}}>
                                    @endif
                                        <a href="#" class="hover-none">@lang('frontend.listprod.newarrival') ({{$countNew}})</a>
                                        <span class="checkmark"></span>
                                    </li>
                                </ul>
                            </div>
                            <div class="widget_list widget_categories">
                                <h2 style="margin-bottom: 0px;">@lang('frontend.proddetail.bymanufacture')</h2>
                                <?php
                                    if($loc == "ch"){
                                        $srchmanlang = "搜索制造商";
                                    }else if($loc == "in"){
                                        $srchmanlang = "Cari Produsen";
                                    }else{
                                        $srchmanlang = "Search Manufacturer";
                                    }
                                ?>
                                @if(isset($page))
                                <input type="text" class="form-control" id="cari_manufacture" placeholder="{{$srchmanlang}}" style="font-size: 12px;margin-bottom: 20px;" disabled>
                                @else
                                <input type="text" class="form-control" id="cari_manufacture" placeholder="{{$srchmanlang}}" style="font-size: 12px;margin-bottom: 20px;">
                                @endif
                                <ul id="manufacturlist">
                                    @foreach($manufacturer as $man)
                                        <?php
                                            $checkednya = '';
                                            $prodbyeks = '';
                                            if(isset($getEks)){
                                                if (strstr($getEks, '|')){
                                                    $eks = explode('|', $getEks);
                                                }else{
                                                    $eks = [$getEks];
                                                }

                                                for ($k=0; $k < count($eks); $k++) { 
                                                    if($man->id == $eks[$k]){
                                                        $checkednya = 'checked="true"';
                                                    }
                                                }

                                                $prodbyeks = $getEks;
                                            }
                                        ?>
                                        <li>
                                        @if(isset($page))
                                            <input type="checkbox"  value="{{$man->id}}" onclick="getProductbyEksportir(this.value, this.checked)" disabled {{$checkednya}}>
                                        @else
                                            <input type="checkbox"  value="{{$man->id}}" onclick="getProductbyEksportir(this.value, this.checked)" {{$checkednya}}>
                                        @endif
                                            <a href="#" class="hover-none">{{$man->company}} ({{$man->jml_produk}})</a>
                                            <span class="checkmark"></span>
                                        </li>
                                    @endforeach
									<li>
                                        @if(isset($page))
                                            <a style="color: #007bff;">@lang('frontend.proddetail.listcompany')</a>
                                        @else
                                            <a href="{{url('front_end/list_perusahaan')}}">@lang('frontend.proddetail.listcompany')</a>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </aside>
                    <!--sidebar widget end-->
                </div>
                <div class="col-lg-9 col-md-12">
                    @if(count($product) == 0 )
                        <center>Product Not Found</center>
                    @else
                    <div class="row shop_wrapper">
                        @foreach($product as $pro)
                            <?php
                                //new or not
                                $dis = "display: none;";
                                $dis2 = "display: none;";
                                if(date('Y', strtotime($pro->created_at)) == date('Y')){
                                    if(date('m', strtotime($pro->created_at)) == date('m')){
                                        $dis = "";
                                    }
                                }
                                if(in_array($pro->id, $hot_product)){
                                    $dis2 = "";
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
                                    if(strlen($minorder) > 30){
                                        $cut_desc = substr($minorder, 0, 30);
                                        if ($minorder{30 - 1} != ' ') { 
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
                                <div class="single_product" style="border: 0px!Important;height: {{$ukuran}}; background-color: #fdfdfc; padding: 0px !important;">
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
                                    <div class="hot-type" style="{{$dis2}} @if($dis != ''); left: 78% !important; @endif">
                                        <span class="hot-type-content">
                                             @if($loc == "ch")
                                                热
                                            @elseif($loc == "in")
                                                HOT
                                            @else
                                                HOT
                                            @endif
                                        </span>
                                    </div>
                                    <?php
                                        //cut prod name
                                        $num_char = 29;
                                        $prodn = getProductAttr($pro->id, 'prodname', $lct);
                                        if(strlen($prodn) > 29){
                                            $cut_text = substr($prodn, 0, $num_char);
                                            if ($prodn{$num_char - 1} != ' ') { 
                                                $new_pos = strrpos($cut_text, ' '); 
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
                                            if ($compname{$num_charp - 1} != ' ') { 
                                                $new_pos = strrpos($cut_text, ' '); 
                                                $cut_text = substr($compname, 0, $new_pos);
                                            }
                                            $companame = $cut_text . '...';
                                        }else{
                                            $companame = $compname;
                                        }

                                        $num_chark = 32;
                                        if(strlen($categorynya) > 32){
                                            $cut_text = substr($categorynya, 0, $num_chark);
                                            if ($categorynya{$num_chark - 1} != ' ') { 
                                                $new_pos = strrpos($cut_text, ' '); 
                                                $cut_text = substr($categorynya, 0, $new_pos);
                                            }
                                            $category = $cut_text . '...';
                                        }else{
                                            $category = $categorynya;
                                        }
                                        $param = $pro->id_itdp_company_user.'-'.getCompanyName($pro->id_itdp_company_user);
                                    ?>
                                    <div class="product_thumb" align="center" style="background-color: #e8e8e4; height: 210px; border-radius: 0px 0px 0px 0px;">
                                        <a class="primary_img" href="{{url('front_end/product/'.$pro->id)}}" onclick="GoToProduct('{{$pro->id}}', event, this)"><img src="{{url('/')}}{{$isimg1}}" alt="" style="vertical-align: middle; height: {{$sizeImg}}px; border-radius: 0px 0px 0px 0px; padding: {{$padImg}}"></a>
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
                                                        if ($proddesc{$num_desc - 1} != ' ') { 
                                                            $new_pos = strrpos($cut_desc, ' '); 
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
                    @endif
                    <br>
                    @if($coproduct > 12)
                    
                    <!-- <div class="shop_toolbar t_bottom"> -->
                        <div class="pagination" style="float: right;">
                           <!--  <ul>
                                <li class="current">1</li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li class="next"><a href="#">next</a></li>
                                <li><a href="#">>></a></li>
                            </ul> -->
                            <!-- {{ $product->links() }} -->
                            {!! str_replace('/?', '?', $product->links()) !!}

                        </div>
                    <!-- </div> -->
                    @endif
                    <!--shop toolbar end-->
                    <!--shop wrapper end-->
                </div>
            </div>
        </div>
    </div>
    <!--shop  area end-->
<!-- Plugins JS -->
<script src="{{asset('front/assets/js/plugins.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
@include('frontend.layouts.footer')
<script type="text/javascript">
    $(document).ready(function () {
        var timer
        $('.hover-none').bind('click', function(e) {
          e.preventDefault();
        });

        $('#cari_advance').keypress(function(event) {
            if (event.keyCode == 13 || event.which == 13) {
                $('#cari_product').val(this.value);
                var searchCat = $('#cari_cat_advance').val() + '|searchByName';
                $('#cari_catnya').val(searchCat);
                $('#formsprod').submit();
            }
        });
        $('#cari_cat_advance').select2({
            placeholder: '{{$srchcatlang}}',
            allowClear: true,
            ajax: {
                url: "{{route('front.all-category')}}",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                  return {
                    results: $.map(data, function (item) {
                      return {
                        text: item.nama_kategori_en,
                        id: item.nama_kategori_en
                      }
                    })
                  };
                },
                cache: true
            }
        });
        $("#cari_kategori").on('keyup', function(){
            var isi = this.value;
            clearTimeout(timer);
            timer = setTimeout(function() {
                $.ajax({
                    url: "{{route('front.product.getCategory')}}",
                    type: 'get',
                    data: {name:isi, loc: "{{$lct}}"},
                    success:function(response){
                        $("#catlist").html("");
                        $("#catlist").html(response);
                    }
                });
            }, 1000);
            
        });

        $('#grid').on('click', function(){
            $('.product_thumb').css({ "margin-top": "0px", "border-radius": "0px 0px 0px 0px" });
        })

        $('#list').on('click', function(){
            $('.product_thumb').css({ "margin-top": "60px", "border-radius": "0px 0px 0px 0px" });
        });

        $("#cari_manufacture").keyup(function(){
            var isi = this.value;
            var searchProd = $('#cari_product').val();
            var catProd = $('#cari_catnya').val();
            var cekEks = $('#eks_prod').val();
            var lct = "{{$lct}}";
            if(isi != ''){
                var datanya = {"name":isi,"lang":lct,"ceked":cekEks};
            } else {
                var datanya = {"name":isi,"searchnya":searchProd,"catnya":catProd,"lang":lct,"ceked":cekEks};
            }
            $.ajax({
                url: "{{route('front.product.getManufactur')}}",
                type: 'get',
                data: datanya,
                success:function(response){
                    $("#manufacturlist").html("");
                    $("#manufacturlist").html(response);
                }
            });
        });

        $('#delete_cat').on('click', function(){
            var delete_cat = $('#cari_catnya').val();
            var cekSearch = $('#cari_product').val();
            //DOM with search box
            // if(cekSearch.indexOf(',') !== -1){
            //     var cat = cekSearch.split(',');
            //     cat = cat.map(function(val){
            //         value = val.trim();
            //         return value.toLowerCase();
            //     })
            //     var cat2 = [cat[0]];
            //     for(var i=0; i<cat.length; i++){
            //         if(cat[i] == 'hot' || cat[i] == 'new'){
            //             cat2.push(cat[i]);
            //         }
            //     }
            //     searchnya = cat2.join(", ");
            //     $('#cari_product').val(searchnya);
            // }
            //End of DOM
            if(delete_cat.indexOf('|') !== -1){
                var pecah = delete_cat.split('|');
                pecah.pop();
                hasil = pecah.join("|");
            } else {
                hasil = '';
            }
            $('#cari_catnya').val(hasil);
            $('#formsprod').submit();
        });

        $("#sortbyproduct").on('change', function () {
            $('#sort_prod').val(this.value);
            $('#formsprod').submit();
        });

        // $(".check_eks").on('change', function () {
        //     if(this.checked){
        //         var arrisi = [];
        //         $.each($("input[name='checkexp']:checked"), function(){
        //             arrisi.push($(this).val());
        //         });
        //     }

        //     if(arrisi.length != 0){
        //         var isinya = "";
        //         for (var i = arrisi.length - 1; i >= 0; i--) {
        //             if(isinya == ""){
        //                 isinya += arrisi[i];
        //             }else{
        //                 isinya += '|'+arrisi[i];
        //             }
        //         }
        //         // alert(isinya);
        //         $('#eks_prod').val(isinya);
        //         $('#formsprod').submit();
        //     }
        // });

        // $(".check_hl").on('change', function () {
        //     if(this.checked){
        //         var arrisi = [];
        //         $.each($("input[name='checkhl']:checked"), function(){
        //             arrisi.push($(this).val());
        //         });
        //     }

        //     if(arrisi.length != 0){
        //         var isinya = "";
        //         for (var i = arrisi.length - 1; i >= 0; i--) {
        //             if(isinya == ""){
        //                 isinya += arrisi[i];
        //             }else{
        //                 isinya += '|'+arrisi[i];
        //             }
        //         }

        //         $('#hl_prod').val(isinya);
        //         $('#formsprod').submit();
        //     }
        // });

        $('.hover-none').on('click', function (e) {
            e.preventDefault();
        })
    })

    function openCollapse(col) {
        if($("#fontdrop"+col).hasClass("fa-chevron-down")){
            $('#fontdrop'+col).removeClass('fa-chevron-down');
            $('#fontdrop'+col).addClass('fa-chevron-up');
        }else{
            $('#fontdrop'+col).removeClass('fa-chevron-up');
            $('#fontdrop'+col).addClass('fa-chevron-down');
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

    function getProduct(val, checked) {
        var isinya = "";
        var cekSearch = $('#cari_product').val();
        var isi = $('#hl_prod').val();
        // //DOM with search box
        // if(cekSearch.indexOf(',') !== -1){
        //     var pecah = cekSearch.split(',');
        //     pecah = pecah.map(function(val){
        //         value = val.trim();
        //         return value.toLowerCase();
        //     })
        //     if (pecah.includes(val)) {
        //         var searchnya = pecah.filter(function(e) { return e !== val });
        //         searchnya = searchnya.join(", ");
        //         $('#cari_product').val(searchnya);
        //     }
        // }
        // //end of DOM
        if(checked){
            if(isi == ""){
                isinya = val;
            }else{
                isinya = isi+'|'+val; 
            }
        }else{
            if(isi == ""){
                isinya = "";
            }else{
                var checkstring = isi.includes("|");
                if(checkstring){
                    var isibar = isi.split('|');
                    var isin = $.inArray(val, isibar);
                    isibar.splice(isin, 1);
                    isinya = isibar[0]; 
                }else{
                    isinya = "";
                }
            }
        }

        $('#hl_prod').val(isinya);
        if($('#cari_advance').val() == '' && $('#cari_cat_advance').val() == ''){
            $('#formsprod').submit();
        }
    }

    function getProductbyEksportir(val, checked) {
        var isinya = "";
        var isi = $('#eks_prod').val();
        var cekSearch = $('#cari_product').val();
        // //DOM with search box
        // if(cekSearch.indexOf('-') !== -1){
        //     var pecah = cekSearch.split('-');
        //     if(cekSearch.indexOf(',') !== -1){
        //         searchnya = pecah[0];
        //         pecah = pecah[1].toString();
        //         pecah = pecah.split(',');
        //         pecah.splice(0,1);
        //         searchnya += ',' + pecah.join(",");
        //         $('#cari_product').val(searchnya);

        //     } else {
        //         pecah.splice(1,1);
        //         searchnya = pecah.join("");
        //         $('#cari_product').val(searchnya);
        //     }
        // }
        // //end of DOM
        if(checked){
            if(isi == ""){
                isinya = val;
            }else{
                // var stringcheck = isi.includes("|");
                // if(stringcheck){
                //     var pisah = isi.split('|');
                //     var isismntra = "";
                //     for (var i = pisah.length - 1; i >= 0; i--) {
                //         if(isismntra == ""){
                //             $isinya += pisah[i];
                //         }else{
                //             $isinya += '|'+pisah[i];
                //         }
                //     }
                // }else{
                    isinya = isi+'|'+val; 
                // }
            }
        }else{
            if(isi == ""){
                isinya = "";
            }else{
                var checkstring = isi.includes("|");
                if(checkstring){
                    var isibar = isi.split('|');
                    // var isin = $.inArray(val, isibar);
                    if (isibar.includes(val)) {
                        isibar = isibar.filter(function(e) { return e !== val });
                        isinya = isibar.join("|");
                    }
                    // isibar.splice(isin, 1);
                    // isinya = isibar[0]; 
                }else{
                    isinya = "";
                }
            }
        }

        $('#eks_prod').val(isinya);
        if($('#cari_advance').val() == '' && $('#cari_cat_advance').val() == ''){
            $('#formsprod').submit();
        }
    }
    function stopProcess(e){
        e.preventDefault();
    }
</script>