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

    .eksporter_img{
        border-radius: 50%;
        width: 50%;
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
                            <li><a href="{{url('/front_end/list_perusahaan')}}">@lang('frontend.home.eksporter')</a></li>
                            <li>@lang('frontend.liseksportir.detailtitle')</li>
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
                        <form class="form-horizontal" enctype="multipart/form-data" method="GET" action="{{url('/front_end/list_perusahaan/view/'.$data->id_user)}}" id="formvekssort">
                        {{ csrf_field() }}
                            <b>@lang('frontend.liseksportir.sortby')</b> <select name="shortprodeks" id="shortprodeks" style="border: none;">
                                <option value="" @if(isset($sortby)) @if($sortby == "") selected @endif @endif>@lang('frontend.liseksportir.default')</option>
                                <option value="new" @if(isset($sortby)) @if($sortby == "new") selected @endif @endif>@lang('frontend.liseksportir.newest')</option>
                                <option value="asc" @if(isset($sortby)) @if($sortby == "asc") selected @endif @endif>@lang('frontend.liseksportir.eksporternm')</option>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="col-1" style="text-align: right;">
                    <div class="breadcrumb_content">
                        <div class="shop_toolbar_btn">
                            <button data-role="grid_4" type="button" class="active btn-grid-3" data-toggle="tooltip" title="3"></button>
                            <button data-role="grid_list" type="button" class="btn-list" data-toggle="tooltip" title="List"></button>
                        </div>
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
                                    <tr>
                                        <td>
                                            <b>@lang('frontend.liseksportir.fax')</b>
                                        </td>
                                        <td>:</td>
                                        <td>{{$data->fax}}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>@lang('frontend.liseksportir.website')</b>
                                        </td>
                                        <td>:</td>
                                        <td>{{$data->website}}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>@lang('frontend.liseksportir.phone')</b>
                                        </td>
                                        <td>:</td>
                                        <td>{{$data->phone}}</td>
                                    </tr>
                                </table>
                                <hr>
                                <h6 style="text-transform: uppercase;"><b>@lang('frontend.liseksportir.address')</b></h6>
                                <p style="font-size: 13px;">
                                    {{$data->addres}}, {{$data->city}}, {{getProvinceName($data->id_mst_province, $lct)}}
                                </p>
                                <hr>
                                <span style="font-size: 13px;">
                                    @if($loc == "ch")
                                        或通过电子邮件与出口商联系：
                                    @elseif($loc == "in")
                                        Atau hubungi eksportir melalui email:
                                    @else
                                        Or contact exporter via email :
                                    @endif
                                    <br>
                                    <span style="color: #007bff;">{{$data->email}}</span>
                                </span>
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
                                           <input type="hidden" name="urlnya" id="urlnya" value="/front_end/list_perusahaan/view/{{$data->id_user}}">
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
                            <div class="col-lg-3 col-md-4 col-12 ">
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
                                        <p class="manufacture_product"><a href="{{url('front_end/list_product/category/'.$idcategory)}}">{{$categorynya}}</a></p>
                                    </div>
                                    <div class="product_thumb">
                                        <a class="primary_img" href="{{url('front_end/product/'.$pro->id)}}"><img src="{{url('/')}}{{$isimg1}}" alt=""></a>
                                        <a class="secondary_img" href="{{url('front_end/product/'.$pro->id)}}"><img src="{{url('/')}}{{$isimg2}}" alt=""></a>
                                    </div>
                                    <div class="product_content grid_content">
                                        <div class="content_inner">
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

        $("#shortprodeks").on('change', function () {
            $('#formvekssort').submit();
        })
    })
</script>