<!--product category start-->
<section class="product_area mb-50">
        <div class="container" style="background-color:white!important;"><br>
		<center><h4>Popular Product</h4></center>
			<div class="col-12">
                    <div class="section_title" style="margin-bottom: 0px;">
                        <!-- <div class="row product_tab_button nav" role="tablist" style="background-color: inherit; width: 100%">
                            <div class="col-md-2">
                                
                            </div>
                        </div> -->
                        <div class="row product_tab_button nav justify-content-center" role="tablist" style="background-color: inherit; width: 100%">
                            <?php
                                $numb = 1;
                                $warna = ['red','DarkKhaki','orange','SeaGreen','Cyan','blue']
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
{{--                                    <img src="{{asset('front/assets/img/kategori/')}}/{{$imgarray[$numb-1]}}.png" alt="" style="height: 40px">--}}
                                    <div style="border-radius: 50%; display: table-cell; background-color: {{$warna[$numb-1]}}; vertical-align: middle; width: 85px;height: 85px;">
                                        <img src="{{asset('uploads/Product/Icon')}}/{{$cut->logo}}" alt="" style="height: 75px">
                                    </div>
                                        <p>{{$kategorinya}}</p>
                                </a>
                            </div>
                            <?php $numb++; ?>
                            @endforeach
                        </div>
                    </div>

                </div>
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
                            $product = getProductByCategory2($cuta->id);
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
                        <div class="product_carousel product_column5 owl-carousel" style="padding-top: 25px;padding-bottom: 25px;">
                                @foreach($product as $key => $p)
                                    <?php
                                        $dis2 = "display: none;";
                                        if(in_array($p->id, $hot_product)){
                                            $dis2 = "";
                                        }
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
                                    ?>
                                    <div class="single_product" style="border-radius:0px!important; height: {{$ukuran}}; background-color: #fdfdfc; padding: 0px !important;">
                                        <div class="hot-type" style="{{$dis2}}">
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
                                            $param = $p->id_itdp_company_user.'-'.getCompanyName($p->id_itdp_company_user);
                                        ?>
                                        <div class="product_thumb" align="center" style="background-color: #e8e8e4; height: 210px; border-radius: 0px 0px 0px 0px;">
                                                <a class="primary_img" href="{{url('front_end/product/'.$p->id)}}" onclick="GoToProduct('{{$p->id}}', event, this)"><img src="{{url('/')}}{{$isimg1}}" alt="" style="vertical-align: middle; height: {{$sizeImg}}px; border-radius: 10px 10px 0px 0px; padding: {{$padImg}}"></a>
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
                                                      <b>  {{$pricenya}} </b>
                                                    </span>
                                                    <br>
                                                    @endif
                                                @endif

                                                {{$order}}<span title="{{$minorder}}"></span>{{$minordernya}}<br>
                                                <a href="{{url('front_end/list_perusahaan/view/'.$param)}}" title="{{$compname}}" class="href-company"><span style="color: black;">{{$by}}</span>&nbsp;&nbsp;{{$companame}}</a>
                                            </span>
                                        </div>
                                        
                                        <div class="product_content list_content">
                                            <div class="left_caption">
                                                <div class="product_name">
                                                    <h3>
                                                        <a href="{{url('front_end/product/'.$p->id)}}" title="{{$prodn}}" class="href-name" style="font-size: 15px !important;"><b>{{$prodn}}</b></a>
                                                    </h3>
                                                    <h3>
                                                        <a href="{{url('front_end/list_perusahaan/view/'.$param)}}" title="{{$compname}}" class="href-company"><span style="color: black;">{{$by}}</span>&nbsp;&nbsp;{{$compname}}</a>
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
                        @endif
                    </div>
                    <?php $numbe++; ?>
                @endforeach
            </div>
        </div>
    </section>
    <!--product category end-->