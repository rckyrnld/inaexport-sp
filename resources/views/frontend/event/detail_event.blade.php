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

    //get category
    $cat1 = getCategoryName($detail->id_prod_cat, $lct);
    $cat2 = getCategoryName($detail->id_prod_sub1_kat, $lct);
    $cat3 = getCategoryName($detail->id_prod_sub2_kat, $lct);

    if (isset($detail->id_prod_sub2_kat) && $detail->id_prod_sub2_kat != 0) {
        $kategori = $cat1." > ".$cat2." > ".$cat3;
    } else if (isset($detail->id_prod_sub1_kat) && $detail->id_prod_sub1_kat != 0) {
        $kategori = $cat1." > ".$cat2;
    } else if (isset($detail->id_prod_cat) && $detail->id_prod_cat != 0) {
        $kategori = $cat1;
    } else {
        $kategori = '-';
    }

    $img1 = "image/noimage.jpg";
    $img2 = "image/noimage.jpg";
    $img3 = "image/noimage.jpg";
    $img4 = "image/noimage.jpg";
    if($detail->image_1 != NULL){
        $imge1 = 'uploads/Event/Image/'.$detail->id.'/'.$detail->image_1;
        if(file_exists($imge1)) {
          $img1 = 'uploads/Event/Image/'.$detail->id.'/'.$detail->image_1;
        }
    }
    if($detail->image_2 != NULL){
        $imge2 = 'uploads/Event/Image/'.$detail->id.'/'.$detail->image_2;
        if(file_exists($imge2)) {
          $img2 = 'uploads/Event/Image/'.$detail->id.'/'.$detail->image_2;
        }
    }
    if($detail->image_3 != NULL){
        $imge3 = 'uploads/Event/Image/'.$detail->id.'/'.$detail->image_3;
        if(file_exists($imge3)) {
          $img3 = 'uploads/Event/Image/'.$detail->id.'/'.$detail->image_3;
        }
    }
    if($detail->image_4 != NULL){
        $imge4 = 'uploads/Event/Image/'.$detail->id.'/'.$detail->image_4;
        if(file_exists($imge4)) {
          $img4 = 'uploads/Event/Image/'.$detail->id.'/'.$detail->image_4;
        }
    }

    if (isset($data)) {
        $button = '<button class="btn training joined btn-info" style="width: 50%;"><i class="fa fa-envelope" aria-hidden="true"></i> '.Lang::get('training.joined').'</button>';
    } else {
        if (Auth::guard('eksmp')->user()) {
            if (Auth::guard('eksmp')->user()->id_role == 2) {
                $button = '<button class="btn training join btn-info" onclick="__join('.$detail->id.')" style="width: 50%;"><i class="fa fa-envelope" aria-hidden="true"></i> '.Lang::get('training.join').'</button>';
            } else {
                $button = '<button class="btn training join btn-info" onclick="notif()" style="width: 50%;"><i class="fa fa-envelope" aria-hidden="true"></i> '.Lang::get('training.join').'</button>';
            }
        } else {
            $button = '<button class="btn training join btn-info" onclick="__join('.$detail->id.')" style="width: 50%;"><i class="fa fa-envelope" aria-hidden="true"></i> '.Lang::get('training.join').'</button>';
        }
    }
?>
    <!--breadcrumbs area start-->
   <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="index.html">@lang("frontend.proddetail.home")</a></li>
                            <li>Events</li>
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

                        <div id="img-1" class="zoomWrapper single-zoom">
                            <a href="#">
                                <img id="zoom1" src="{{url('/')}}/{{$img1}}" data-zoom-image="{{url('/')}}/{{$img1}}" alt="big-1">
                            </a>
                        </div>

                        <div class="single-zoom-thumb">
                            <ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">
                                <li>
                                    <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{url('/')}}/{{$img1}}" data-zoom-image="{{url('/')}}/{{$img1}}">
                                        <img src="{{url('/')}}/{{$img1}}" alt="zo-th-1" />
                                    </a>

                                </li>
                                <li>
                                    <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{url('/')}}/{{$img2}}" data-zoom-image="{{url('/')}}/{{$img2}}">
                                        <img src="{{url('/')}}/{{$img2}}" alt="zo-th-1" />
                                    </a>

                                </li>
                                <li>
                                    <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{url('/')}}/{{$img3}}" data-zoom-image="{{url('/')}}/{{$img3}}">
                                        <img src="{{url('/')}}/{{$img3}}" alt="zo-th-1" />
                                    </a>

                                </li>
                                <li>
                                    <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{url('/')}}/{{$img4}}" data-zoom-image="{{url('/')}}/{{$img4}}">
                                        <img src="{{url('/')}}/{{$img4}}" alt="zo-th-1" />
                                    </a>

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product_d_right">
                            <h1>{{$detail->event_name_in}}</h1>
                            <div class="product_desc">
                                {{date("d F Y", strtotime($detail->start_date))}} - {{date("d F Y", strtotime($detail->end_date))}}<br>
                                Jenis Event : {{$detail->jenis_in}}<br>
                                @lang("training.lokasi") : {{$detail->event_place_text_in}}<br>
                                Kategori Produk : {{$kategori}}
                            </div>
                            <div>
                                <center>
                                    <?php echo $button; ?>
                                </center>
                            </div>
                        <!-- </form> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--product details end-->
<!-- Plugins JS -->
<script src="{{asset('front/assets/js/plugins.js')}}"></script>
<script type="text/javascript">
    function __join(id){
        @if(!Auth::guard('eksmp')->user())
            alert("@lang('frontend.lbl12')");
            window.location.href = "{{url('/login')}}";
        @else
            window.location.href = "{{url('/front_end/gabung_event')}}/"+id;
        @endif
    }

    function notif() {
        alert("@lang('frontend.lbl13')");
    }
</script>
@include('frontend.layouts.footer')