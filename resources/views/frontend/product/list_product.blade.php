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
</style>
<!--breadcrumbs area start-->
<div class="breadcrumbs_area">
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
                <div class="col-2" style="text-align: left;">
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
                <div class="col-4" style="text-align: left;">
                    <div class="breadcrumb_content">
                        <b>@lang('frontend.liseksportir.sortby')</b> <select name="orderby" id="short" style="border: none;">
                                <option value="" @if(isset($sortbyproduct)) @if($sortbyproduct == "") selected @endif @endif>@lang('frontend.liseksportir.default')</option>
                                <option value="new" @if(isset($sortbyproduct)) @if($sortbyproduct == "new") selected @endif @endif>@lang('frontend.liseksportir.newest')</option>
                                <option value="lowhigh" @if(isset($sortbyproduct)) @if($sortbyproduct == "lowhigh") selected @endif @endif>@lang('frontend.proddetail.pricelh')</option>
                                <option value="highlow" @if(isset($sortbyproduct)) @if($sortbyproduct == "highlow") selected @endif @endif>@lang('frontend.proddetail.pricehl')</option>
                                <option value="asc" @if(isset($sortbyproduct)) @if($sortbyproduct == "asc") selected @endif @endif>@lang('frontend.liseksportir.eksporternm')</option>
                            </select>
                    </div>
                </div>
                <div class="col-1" style="text-align: right;">
                    <div class="breadcrumb_content">
                        <div class="shop_toolbar_btn">
                            <button data-role="grid_3" type="button" class="active btn-grid-3" data-toggle="tooltip" title="3"></button>
                            <button data-role="grid_list" type="button" class="btn-list" data-toggle="tooltip" title="List"></button>
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
                                <input type="text" class="form-control" id="cari_kategori" name="cari_kategori" placeholder="{{$srchcatlang}}" style="font-size: 12px;">
                                <br>
                                <div class="list-group list-group-flush" id="catlist">
                                    @foreach($categoryutama as $cu)
                                        <?php
                                            $catprod1 = getCategoryLevel(1, $cu->id, "");
                                            $nk = "nama_kategori_".$lct; 
                                            if($cu->$nk == NULL){
                                                $nk = "nama_kategori_en";
                                            }
                                        ?>
                                        @if(count($catprod1) == 0)
                                            <a href="{{url('/front_end/list_product/category/'.$cu->id)}}" class="list-group-item">{{$cu->$nk}}</a>
                                        @else
                                            <a onclick="openCollapse('{{$cu->id}}')" href="#menus{{$cu->id}}" class="list-group-item" data-toggle="collapse" data-parent="#MainMenu"> {{$cu->$nk}} <i class="fa fa-chevron-down" aria-hidden="true" style="float: right; margin-right: -10px;" id="fontdrop{{$cu->id}}"></i></a>
                                                <div class="collapse" id="menus{{$cu->id}}">
                                                    @foreach($catprod1 as $cat1)
                                                        <a href="{{url('/front_end/list_product/category/'.$cat1->id)}}" class="list-group-item">{{$cat1->$nk}}</a>
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
                                <h2>@lang('frontend.proddetail.bymanufacture')</h2>
                                <?php
                                    if($loc == "ch"){
                                        $srchmanlang = "搜索制造商";
                                    }else if($loc == "in"){
                                        $srchmanlang = "Cari Produsen";
                                    }else{
                                        $srchmanlang = "Search Manufacturer";
                                    }
                                ?>
                                <input type="text" class="form-control" id="cari_eksportir" name="cari_eksportir" placeholder="{{$srchmanlang}}" style="font-size: 12px;">
                                <br>
                                <ul id="manufacturlist">
                                    @foreach($manufacturer as $man)
                                        <li>
                                            <input type="checkbox" name="checkexp" value="{{$man->id}}">
                                            <a href="#">{{$man->company}}({{getCountProduct('company', $man->id)}})</a>
                                            <span class="checkmark"></span>
                                        </li>
                                    @endforeach
									<li>
                                        <a href="{{url('front_end/list_perusahaan')}}">@lang('frontend.proddetail.listcompany')</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </aside>
                    <!--sidebar widget end-->
                </div>
                <div class="col-lg-9 col-md-12">
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
                                    $isimg1 = '/image/noimage.jpg';
                                }else{
                                    $image1 = 'uploads/Eksportir_Product/Image/'.$pro->id.'/'.$img1; 
                                    if(file_exists($image1)) {
                                      $isimg1 = '/uploads/Eksportir_Product/Image/'.$pro->id.'/'.$img1;
                                    }else {
                                      $isimg1 = '/image/noimage.jpg';
                                    }  
                                }

                                if($img2 == NULL){
                                    $isimg2 = '/image/noimage.jpg';
                                }else{
                                    $image2 = 'uploads/Eksportir_Product/Image/'.$pro->id.'/'.$img2; 
                                    if(file_exists($image2)) {
                                      $isimg2 = '/uploads/Eksportir_Product/Image/'.$pro->id.'/'.$img2;
                                    }else {
                                      $isimg2 = '/image/noimage.jpg';
                                    }  
                                }
                            ?>
                            <div class="col-lg-4 col-md-4 col-12 ">
                                <div class="single_product">
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
                                    <div class="product_name grid_name">
                                        <h3><a href="{{url('front_end/product/'.$pro->id)}}">{{getProductAttr($pro->id, 'prodname', $lct)}}</a></h3>
                                    </div>
                                    <h3 style="text-transform: uppercase; font-size: 14px; font-weight: 400; font-family: "Open Sans", sans-serif;"><a href="{{url('front_end/list_perusahaan/View/'.$pro->id_itdp_company_user)}}">{{getCompanyName($pro->id_itdp_company_user)}}</a></h3>
                                    <div class="product_thumb">
                                        <a class="primary_img" href="{{url('front_end/product/'.$pro->id)}}"><img src="{{url('/')}}{{$isimg1}}" alt=""></a>
                                        <!-- <a class="secondary_img" href="{{url('front_end/product/'.$pro->id)}}"><img src="{{url('/')}}{{$isimg2}}" alt=""></a> -->
                                    </div>
                                    <div class="product_name grid_name">
                                        <p class="manufacture_product"><a href="{{url('front_end/list_product/category/'.$idcategory)}}">{{$categorynya}}</a></p>
                                    </div>
                                    <div class="product_content grid_content">
                                        <div class="content_inner">
                                            <div class="product_footer d-flex align-items-center">
                                                <div class="price_box">
                                                    @if(Auth::guard('eksmp')->user())
                                                    <span class="current_price">
                                                        @if(is_numeric($pro->price_usd))
                                                            $ {{$pro->price_usd}}
                                                        @else
                                                            <span style="font-size: 13px;">
                                                                {{$pro->price_usd}}
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
                                                <h3><a href="{{url('front_end/product/'.$pro->id)}}">{{getProductAttr($pro->id, 'prodname', $lct)}}</a></h3>
                                            </div>

                                            <div class="product_desc">
                                                <?php echo getProductAttr($pro->id, 'product_description', $lct); ?>
                                            </div>
                                        </div>
                                        <div class="right_caption">
                                            <div class="text_available">
                                                <p>
                                                    @lang('frontend.available'): 
                                                    @if($loc == "ch")
                                                        <span>库存{{$pro->capacity}}件</span>
                                                    @elseif($loc == "in")
                                                        <span>{{$pro->capacity}} dalam persediaan</span>
                                                    @else
                                                        <span>{{$pro->capacity}} in stock</span>
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="price_box">
                                                @if(Auth::guard('eksmp')->user())
                                                <span class="current_price">
                                                    @if(is_numeric($pro->price_usd))
                                                        $ {{$pro->price_usd}}
                                                    @else
                                                        <span style="font-size: 13px;">
                                                            {{$pro->price_usd}}
                                                        </span>
                                                    @endif
                                                </span>
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
                    <!-- <div class="shop_toolbar t_bottom"> -->
                        <div class="pagination" style="float: right;">
                           <!--  <ul>
                                <li class="current">1</li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li class="next"><a href="#">next</a></li>
                                <li><a href="#">>></a></li>
                            </ul> -->
                            {{ $product->links() }}
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
@include('frontend.layouts.footer')
<script type="text/javascript">
    $(document).ready(function () {
        $("#cari_kategori").keyup(function(){
            var isi = this.value;
            $.ajax({
                url: "{{route('front.product.getCategory')}}",
                type: 'get',
                data: {name:isi, loc: "{{$lct}}"},
                success:function(response){
                    $("#catlist").html("");
                    // console.log(response);
                    $("#catlist").html(response);
                }
            });
        });

        $("#cari_eksportir").keyup(function(){
            var isi = this.value;
            $.ajax({
                url: "{{route('front.product.getManufactur')}}",
                type: 'get',
                data: {name:isi},
                success:function(response){
                    $("#manufacturlist").html("");
                    // console.log(response);
                    $("#manufacturlist").html(response);
                }
            });
        });

        $("#short").on('change', function () {
            var search = $('#cari_product').val();
            var lct = $('#locnya').val();
            var category = $('#cari_catnya').val();
            var exportir = [];
            $.each($("input[name='checkexp']:checked"), function(){
                exportir.push($(this).val());
            });

            if(search == ""){
                search = null;
            }

            if(lct == ""){
                lct = null;
            }

            if(category == ""){
                category = null;
            }

            if(exportir.length == 0){
                exportir = null;
            }
            
            // $.ajax({
            //     url: "{{url('/front_end/list_product')}}",
            //     type: 'get',
            //     data: {cari_catnya:category, cari_product: search, locnya: lct, isieks: exportir},
            //     success:function(response){
                    
            //     }
            // });
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
</script>