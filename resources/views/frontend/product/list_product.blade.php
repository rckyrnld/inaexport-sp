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
    /*.list-group.panel > .list-group-item {
      border-bottom-right-radius: 4px;
      border-bottom-left-radius: 4px
    }
    .list-group-submenu {
      margin-left:20px;
    }*/
</style>
<!--breadcrumbs area start-->
<div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="index.html">home</a></li>
                            @if($catActive == NULL)
                            <li>Default</li>
                            @else
                            <li>{{$catActive}}</li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-2" style="text-align: right;">
                    <div class="breadcrumb_content">
                        <div class="page_amount">
                            <p><b>{{count($product)}} Products</b> Found</p>
                        </div>
                    </div>
                </div>
                <div class="col-3" style="text-align: right;">
                    <div class="breadcrumb_content">
                        <b>Sort By</b> <select name="orderby" id="short" style="border: none;">
                                <option value="" selected>Default</option>
                                <option value="1">Average rating</option>
                                <option value="2">Popularity</option>
                                <option value="3">Newness</option>
                                <option value="4">Price: low to high</option>
                                <option value="5">Price: high to low</option>
                                <option value="6">Product Name: Z</option>
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
                                <h2>categories</h2>
                                <input type="text" class="form-control" id="cari_kategori" name="cari_kategori" placeholder="Search Category" style="font-size: 12px;">
                                <br>
                                <div class="list-group list-group-flush" id="catlist">
                                    <?php
                                        $numb = 1;
                                    ?>
                                    @foreach($categoryutama as $cu)
                                        <?php
                                            $catprod1 = getCategoryLevel(1, $cu->id, "");
                                            $nk = "nama_kategori_".$lct; 
                                            if($cu->$nk == NULL){
                                                $nk = "nama_kategori_en";
                                            }
                                        ?>
                                        @if(count($catprod1) == 0)
                                            <a href="#" class="list-group-item">{{$cu->$nk}}</a>
                                        @else
                                            <a onclick="openCollapse('{{$numb}}')" href="#menus{{$numb}}" class="list-group-item" data-toggle="collapse" data-parent="#MainMenu"> {{$cu->$nk}} <i class="fa fa-chevron-down" aria-hidden="true" style="float: right; margin-right: -10px;" id="fontdrop{{$numb}}"></i></a>
                                                <div class="collapse" id="menus{{$numb}}">
                                                    @foreach($catprod1 as $cat1)
                                                        <a href="#" class="list-group-item">{{$cat1->$nk}}</a>
                                                    @endforeach
                                                </div>
                                        @endif
                                        <?php $numb++; ?>
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
                                <h2>By Manufacturer</h2>
                                <input type="text" class="form-control" id="cari_eksportir" name="cari_eksportir" placeholder="Search Manufacturer" style="font-size: 12px;">
                                <br>
                                <ul id="manufacturlist">
                                    @foreach($manufacturer as $man)
                                        <li>
                                            <input type="checkbox">
                                            <a href="#">{{$man->company}}({{getCountProduct('company', $man->id)}})</a>
                                            <span class="checkmark"></span>
                                        </li>
                                    @endforeach
                                    <li>
                                        <a href="#">View All</a>
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
                                //get name column
                                $nprod = "prodname_".$lct;
                                $ndesc = "product_description_".$lct;

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
                                    }else{
                                        $categorynya = $cat2;
                                    }
                                }else{
                                    $categorynya = $cat3;
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
                                        <span class="pro-type-content">NEW</span>
                                    </div>
                                    <div class="product_name grid_name">
                                        <h3><a href="{{url('front_end/product/'.$pro->id)}}">{{$pro->$nprod}}</a></h3>
                                        <p class="manufacture_product"><a href="#">{{$categorynya}}</a></p>
                                    </div>
                                    <div class="product_thumb">
                                        <a class="primary_img" href="{{url('front_end/product/'.$pro->id)}}"><img src="{{url('/')}}{{$isimg1}}" alt=""></a>
                                        <a class="secondary_img" href="{{url('front_end/product/'.$pro->id)}}"><img src="{{url('/')}}{{$isimg2}}" alt=""></a>
                                        <div class="action_links">
                                            <ul>
                                                <li class="quick_button"><a href="#" data-toggle="modal" data-target="#modal_box" title="quick view"> <span class="lnr lnr-magnifier"></span></a></li>
                                                <li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><span class="lnr lnr-heart"></span></a></li>
                                                <li class="compare"><a href="compare.html" title="compare"><span class="lnr lnr-sync"></span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_content grid_content">
                                        <div class="content_inner">
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
                                                    <span class="current_price">
                                                        @if(is_numeric($pro->price_usd))
                                                            $ {{$pro->price_usd}}
                                                        @else
                                                            <span style="font-size: 13px;">
                                                                {{$pro->price_usd}}
                                                            </span>
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product_content list_content">
                                        <div class="left_caption">
                                            <div class="product_name">
                                                <h3><a href="{{url('front_end/product/'.$pro->id)}}">{{$pro->$nprod}}</a></h3>
                                            </div>

                                            <div class="product_desc">
                                                <?php echo $pro->$ndesc; ?>
                                            </div>
                                        </div>
                                        <div class="right_caption">
                                            <div class="text_available">
                                                <p>availabe: <span>{{$pro->capacity}} in stock</span></p>
                                            </div>
                                            <div class="price_box">
                                                <span class="current_price">
                                                    @if(is_numeric($pro->price_usd))
                                                        $ {{$pro->price_usd}}
                                                    @else
                                                        <span style="font-size: 13px;">
                                                            {{$pro->price_usd}}
                                                        </span>
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="action_links_btn">
                                                <ul>
                                                    <li class="quick_button"><a href="#" data-toggle="modal" data-target="#modal_box" title="quick view"> <span class="lnr lnr-magnifier"></span></a></li>
                                                    <li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><span class="lnr lnr-heart"></span></a></li>
                                                    <li class="compare"><a href="compare.html" title="compare"><span class="lnr lnr-sync"></span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="shop_toolbar t_bottom">
                        <div class="pagination">
                           <!--  <ul>
                                <li class="current">1</li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li class="next"><a href="#">next</a></li>
                                <li><a href="#">>></a></li>
                            </ul> -->
                            {{ $product->links() }}
                        </div>
                    </div>
                    <!--shop toolbar end-->
                    <!--shop wrapper end-->
                </div>
            </div>
        </div>
    </div>
    <!--shop  area end-->

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
                    console.log(response);
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
                    console.log(response);
                    $("#manufacturlist").html(response);
                }
            });
        });
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