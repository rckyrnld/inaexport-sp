@include('frontend.layouts.header')
<?php 
    $loc = app()->getLocale(); 
    if($loc == "ch"){
        $lct = "chn";
        $lcts = "chn";
    }else if($loc == "in"){
        $lct = "in";
        $lcts = "ind";
    }else{
        $lct = "en";
        $lcts = "en";
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
                                        <div class="col-2" style="text-align: right;">
                                            <div class="breadcrumb_content">
                                                <div class="shop_toolbar_btn">
                                                    <button data-role="grid_4" type="button" class="active btn-grid-3" data-toggle="tooltip" title="3"></button>
                                                    <button data-role="grid_list" type="button" class="btn-list" data-toggle="tooltip" title="List"></button>
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
                                                <div class="single_product" style="height: 300px;">
                                                    <div class="product_name grid_name">
                                                        <?php
                                                            $num_char = 16;
                                                            $prodn = getProductAttr($pro->id, 'prodname', $lct);
                                                            if(strlen($prodn) > 16){
                                                                $cut_text = substr($prodn, 0, $num_char);
                                                                if ($prodn{$num_char - 1} != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                                                    $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                                                    $cut_text = substr($prodn, 0, $new_pos);
                                                                }
                                                                $prodnama = $cut_text . '...';
                                                            }else{
                                                                $prodnama = $prodn;
                                                            }
                                                        ?>
                                                        <h3><a href="{{url('front_end/product/'.$pro->id)}}"title="{{$prodn}}">{{$prodnama}}</a></h3>
                                                    </div>
                                                    <div class="product_thumb" align="center">
                                                        <a class="primary_img" href="{{url('front_end/product/'.$pro->id)}}"><img src="{{url('/')}}{{$isimg1}}" alt="" style="height: 150px;"></a>
                                                        <!-- <a class="secondary_img" href="{{url('front_end/product/'.$pro->id)}}"><img src="{{url('/')}}{{$isimg2}}" alt=""></a> -->
                                                    </div>
                                                    <div class="product_name grid_name">
                                                        <?php
                                                            $num_chark = 23;
                                                            if(strlen($categorynya) > 23){
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
                                                        <p class="manufacture_product"><a href="{{url('front_end/list_product/category/'.$idcategory)}}" title="{{$categorynya}}">{{$category}}</a></p>
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
                                                <form class="form-horizontal" enctype="multipart/form-data" method="GET" action="{{url('/front_end/list_perusahaan/view/'.$data->id_user)}}" id="formsrvsort">
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
    })
</script>