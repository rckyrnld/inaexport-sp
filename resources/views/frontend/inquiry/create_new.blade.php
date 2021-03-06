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
    $cat1 = getCategoryName($data->id_csc_product, $lct);
    $cat2 = getCategoryName($data->id_csc_product_level1, $lct);
    $cat3 = getCategoryName($data->id_csc_product_level2, $lct);

    $arrimg = [];

    $img1 = "image/noimage.jpg";
    // $img2 = "image/noimage.jpg";
    // $img3 = "image/noimage.jpg";
    // $img4 = "image/noimage.jpg";
    if($data->image_1 != NULL){
        $imge1 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_1;
        if(file_exists($imge1)) {
          $img1 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_1;
          array_push($arrimg, $img1);
        }
    }
    if($data->image_2 != NULL){
        $imge2 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_2;
        if(file_exists($imge2)) {
          $img2 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_2;
          array_push($arrimg, $img2);
        }
    }
    if($data->image_3 != NULL){
        $imge3 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_3;
        if(file_exists($imge3)) {
          $img3 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_3;
          array_push($arrimg, $img3);
        }
    }
    if($data->image_4 != NULL){
        $imge4 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_4;
        if(file_exists($imge4)) {
          $img4 = 'uploads/Eksportir_Product/Image/'.$data->id.'/'.$data->image_4;
          array_push($arrimg, $img4);
        }
    }
?>
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="{{url('/')}}">@lang('frontend.proddetail.home')</a></li>
                            @if($data->id_csc_product == NULL)
                            <li><a href="{{url('/front_end/list_product')}}">@lang('frontend.proddetail.dafault')</a></li>
                            @else
                                @if($cat1 == "-")
                                    <li><a href="{{url('/front_end/list_product')}}">@lang('frontend.proddetail.dafault')</a></li>
                                @else
                                    @if($cat2 == "-")
                                        <li><a href="{{url('/front_end/list_product/category/'.$data->id_csc_product_level1)}}">{{$cat1}}</a></li>
                                    @else
                                        @if($cat3 == "-")
                                            <li><a href="{{url('/front_end/list_product/category/'.$data->id_csc_product)}}">{{$cat1}}</a></li>
                                            <li><a href="{{url('/front_end/list_product/category/'.$data->id_csc_product_level1)}}">{{$cat2}}</a></li>
                                        @else
                                             <li><a href="{{url('/front_end/list_product/category/'.$data->id_csc_product)}}">{{$cat1}}</a></li>
                                            <li><a href="{{url('/front_end/list_product/category/'.$data->id_csc_product_level1)}}">{{$cat2}}</a></li>
                                            <li><a href="{{url('/front_end/list_product/category/'.$data->id_csc_product_level2)}}">{{$cat3}}</a></li>
                                        @endif
                                    @endif
                                @endif
                            @endif
                            <li>@lang('inquiry.form')</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!--product details start-->
  <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{url($url)}}" id="formnya">
  {{ csrf_field() }}
    <div class="product_details mt-20">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product-details-tab">

                        <div id="img-1" class="zoomWrapper single-zoom" align="center">
                            <a href="#">
                                <img id="zoom1" src="{{url('/')}}/{{$img1}}" data-zoom-image="{{url('/')}}/{{$img1}}" alt="big-1" style="width: 400px; height:400x;">
                            </a>
                        </div>

                        @if(count($arrimg) != 0)
                        <?php echo "Ngapa yaa";?>
                        <div class="single-zoom-thumb" align="center">
                            <ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">
                                <?php
                                    for ($m=0; $m < count($arrimg); $m++) { 
                                ?>
                                        <li>
                                            <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{url('/')}}/{{$arrimg[$m]}}" data-zoom-image="{{url('/')}}/{{$arrimg[$m]}}">
                                                <img src="{{url('/')}}/{{$arrimg[$m]}}" alt="zo-th-1" />
                                            </a>

                                        </li>
                                <?php
                                    }
                                ?>
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product_d_right">
                      <!-- <h1>{{getProductAttr($data->id, 'prodname', $lct)}}</h1>
                        <div class="price_box">
                            <span class="current_price">
                                @if(is_numeric($data->price_usd))
                                    $ {{$data->price_usd}}
                                @else
                                    {{$data->price_usd}}
                                @endif
                            </span>
                        </div> -->
                        <div class="product_desc">
                            <table border="0" cellpadding="10" cellspacing="10" style="width: 100%; font-size: 14px;">
                              <tbody>
                                <tr>
                                  <td width="30%">@lang('inquiry.prodname')</td>
                                  <td width="60%">
                                    <input type="hidden" name="id_product" id="id_product" value="{{$data->id}}">
                                    <input type="hidden" name="type" id="type" value="importir">
                                    <b>{{getProductAttr($data->id, 'prodname', $lct)}}</b>
                                  </td>
                                </tr>
                                <tr>
                                  <td width="30%">@lang('inquiry.category')</td>
                                  <td width="60%">
                                    <?php
                                      if($cat1 == "-"){
                                        echo $cat1;
                                      }else{
                                        if($cat2 == "-"){
                                          echo $cat1;
                                        }else{
                                          if($cat3 == "-"){
                                            echo $cat1." > ".$cat2;
                                          }else{
                                            echo $cat1." > ".$cat2." > ".$cat3;
                                          }
                                        }
                                      }

                                      $param = $data->id_itdp_company_user.'-'.getCompanyName($data->id_itdp_company_user);
                                    ?>
                                  </td>
                                </tr>
                                <tr>
                                  <td width="30%">@lang('inquiry.kos')</td>
                                  <td width="60%">
                                    @lang('inquiry.otb')
                                    <input type="hidden" name="kos" id="kos" class="form-control" value="offer to buy">
                                  </td>
                                </tr>
                                <tr>
                                  <td width="30%">@lang('inquiry.company')</td>
                                  <td width="60%">
                                    <a href="{{url('/front_end/list_perusahaan/view/'.$param)}}" style="text-transform: uppercase;">
                                      {{getCompanyName($data->id_itdp_company_user)}}
                                    </a>
                                  </td>
                                </tr>
                                <tr>
                                  <td width="30%">@lang('inquiry.subject')</td>
                                  <td width="60%">
                                    <input type="text" name="subject" class="form-control" id="subject" autocomplete="off" style="font-size: 14px;">
                                  </td>
                                </tr>
                                <tr>
                                  <td width="30%" style="vertical-align: top;">@lang('inquiry.msg')</td>
                                  <td width="60%">
                                    <textarea class="form-control" id="messages" name="messages" style="font-size: 14px;" rows="5"></textarea>
                                  </td>
                                </tr>
                                <tr>
                                  <td width="30%">@lang('inquiry.file')</td>
                                  <td width="60%">
                                    <div class="input-group mb-3">
                                      <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="filedo" name="filedo" style="font-size: 14px;" accept=".doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel,.ppt,.pptx,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,.pdf,application/pdf">
                                        <label class="custom-file-label" for="inputGroupFile01" id="labfiledo"> - @lang('inquiry.choose') - </label>
                                      </div>
                                    </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td width="30%">@lang('inquiry.duration')</td>
                                  <td width="60%">
                                    <select class="form-control" name="duration" id="duration" style="font-size: 14px;">
                                      <option value="" style="display: none;"> - @lang('inquiry.selectduration') - </option>
                                      <option value="None">@lang('inquiry.none')</option>
                                      <option value="1 week">@lang('inquiry.v1w')</option>
                                      <option value="2 weeks">@lang('inquiry.v2w')</option>
                                      <!-- <option value="3 weeks">@lang('inquiry.v3w')</option> -->
                                      <option value="1 month">@lang('inquiry.v1m')</option>
                                      <option value="2 months">@lang('inquiry.v2m')</option>
                                      <!-- <option value="3 months">@lang('inquiry.v3m')</option>
                                      <option value="4 months">@lang('inquiry.v4m')</option>
                                      <option value="5 months">@lang('inquiry.v5m')</option> -->
                                      <option value="6 months">@lang('inquiry.v6m')</option>
                                    </select>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                        </div>
                        <!-- <div class="product_variant quantity">
                            <label>@lang('frontend.proddetail.minorder')</label>
                            <input type="text" name="minorder" value="{{$data->minimum_order}}" readonly>

                        </div><br> -->
                        <div class="">
                            <center>
                                <a href="{{url('/front_end/list_product')}}" class="btn btn-danger"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;&nbsp;@lang('button-name.cancel')</a>
                                <button type="button" class="btn btn-primary" id="btnsubmit"><i class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp;&nbsp;@lang('button-name.submit')</button>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </form>
<?php
  $alertkos = "";
  $alertsubject = "";
  $alertmsg = "";
  $alertfile = "";
  $alertdurasi = "";

  if($loc == "ch"){
    $alertkos = "?????????????????????????????????";
    $alertsubject = "???????????????????????????";
    $alertmsg = "???????????????????????????";
    $alertfile = "???????????????????????????";
    $alertdurasi = "???????????????????????????";    
  }else if($loc == "in"){
    $alertkos = "Jenis Subjek kosong, silahkan isi!";
    $alertsubject = "Subjek kosong, silahkan isi!";
    $alertmsg = "Pesan kosong, silahkan isi!";
    $alertfile = "File kosong, silahkan isi!";
    $alertdurasi = "Durasi kosong, silahkan isi!";
  }else{
    $alertkos = "Kind of Subject is empty, please fill in!";
    $alertsubject = "Subject is empty, please fill in!";
    $alertmsg = "Messages is empty, please fill in!";
    $alertfile = "File is empty, please fill in!";
    $alertdurasi = "Duration is empty, please fill in!";
  }
?>
    <!--product details end-->
<!-- Plugins JS -->
<script src="{{asset('front/assets/js/plugins.js')}}"></script>
@include('frontend.layouts.footer')
<script type="text/javascript">
    $(document).ready(function(){
        //Upload File
        $("#filedo").on('change', function() {
            if(this.value != ""){
              var val = this.value;
              var v = val.split('\\');
              $('#labfiledo').html(v[v.length - 1]);
            }else{
                alert('The file cannot be uploaded');
            }
        });

        $('#btnsubmit').on('click', function () {
          
          if ($('#kos').val() == "") {
              alert("<?php echo $alertkos; ?>");
          }else if ($('#subject').val() == "") {
              alert("<?php echo $alertsubject; ?>");
          }else if ($('#messages').val() == "") {
              alert("<?php echo $alertmsg; ?>");
          }else {
              $('#formnya').submit();
          }
        });
    });
</script>