@include('frontend.layouts.header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<?php
  $loc = app()->getLocale();
  if(Auth::guard('eksmp')->user() || Auth::user()){
    if(Auth::guard('eksmp')->user()->id_role == 2){
      $for = 'eksportir';
      $message = '';
      $id_user = Auth::guard('eksmp')->user()->id;
      $id_profil = cekid(Auth::guard('eksmp')->user()->id);
      $id_profil = $id_profil->id;
    } else {
      $id_user = '';
      $id_profil = '0';
      $for = 'no akses';
        if($loc == "ch"){
          $message = "您无权加入";
        }elseif($loc == "in"){
          $message = "Anda Tidak Memiliki Akses untuk Bergabung!";
        }else{
          $message = "You do not Have Access to Join!";
        }
    }
  } else {
    $id_user = '';
    $id_profil = '0';
    $for = 'non user';
      if($loc == "ch"){
        $message = "请先登录";
      }elseif($loc == "in"){
        $message = "Silahkan Login Terlebih Dahulu!";
      }else{
        $message = "Please Login to Continue!";
      }
  }

?>
<style type="text/css">
  .training{
    color : #edf1f5;
    font-weight: 500;
    padding-left: 10px;
  }
  .training_topic{
    padding-left: 10px;
    font-weight: 500;
    font-size: 15px; 
  }
  .btn.training{
    width: 100%;
    border-color: #2385d4;
    border-radius: 20px;
  }
  .btn.training.join{
    background-color: #edf1f5;
    color: #2385d4;
  }
  .btn.training.joined{
    background-color: #edf1f5;
    color: #2385d4; 
  }
</style>
<div style="background-color: white;">
  <div class="container">
    <div class="col-md-12 col-lg-12">
      <span style="color: #1a70bb; text-align: center;"><h2>@lang("frontend.jdl_event")</h2></span>
    </div>
  </div>
</div>

    <!--Training start-->
    <div class="shop_area shop_reverse">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-12">
                    <div class="row shop_wrapper">
                      @foreach($e_detail as $num => $val)
                        <?php 
                          $image = 'uploads/Event/Image/'.$val->id.'/'.$val->image_1;
                          if($val->image_1 != null || $val->image_1 != ''){
                            if(file_exists($image)) {
                              $image = 'uploads/Event/Image/'.$val->id.'/'.$val->image_1;
                            } else {
                              $image = '/image/event/NoPicture.png';
                            }
                          } else {
                            $image = '/image/event/NoPicture.png';
                          }
                         ?>
                        <?php
                          if($loc == "en"){
                            $location = $val->event_place_text_en;
                            $topic = $val->event_type_en;
                            $training = $val->event_name_en;
                          } else if($loc == "in"){
                            if($val->event_place_text_in != null){
                              $location = $val->event_place_text_in;
                            } else {
                              $location = $val->event_place_text_en;
                            }

                            if($val->event_type_in != null){
                              $topic = $val->event_type_in;
                            }  else {
                              $topic = $val->event_type_en;
                            }

                            if($val->event_name_in != null){
                              $training = $val->event_name_in;
                            }  else {
                              $training = $val->event_name_en;
                            }
                          } else {
                            if($val->event_place_text_chn != null){
                              $location = $val->event_place_text_chn;
                            } else {
                              $location = $val->event_place_text_en;
                            }

                            if($val->event_type_chn != null){
                              $topic = $val->event_type_chn;
                            }  else {
                              $topic = $val->event_type_en;
                            }

                            if($val->event_name_chn != null){
                              $training = $val->event_name_chn;
                            }  else {
                              $training = $val->event_name_en;
                            }
                          }

                          $cek = checkJoin($val->id, $id_profil);
                          if($cek == 0){
                            $button = '<button class="btn training join btn-info" onclick="__join('.$val->id.')">'.Lang::get('training.join').'</button>';
                          } else {
                            $button = '<button class="btn training joined btn-info">'.Lang::get('training.joined').'</button>';
                          }
                        ?>

                        <div class="col-lg-4 col-md-4 col-12">
                          <div style="background-color: #2385d4; border-radius: 10px; vertical-align: top">
                          <div style="padding: 10px;">
                            <center>
                            <img class="img-responsive" src="{{url('/')}}/{{$image}}" width="50%;">
                            </center>
                          </div>
                            <div class="col" style="height: 100%; padding-top: 15px;">
                              <span style="color: #edf1f5; font-weight: 600; font-size: 20px;">{{$training}}</span><br>

                              <span class="training" style="font-size: 15px;">
                                <i class="fa fa-bullhorn"></i>&nbsp;&nbsp;@lang("training.topic")
                              </span><br>
                              <span class="training_topic" style="font-size: 15px;">
                                {{$topic}}
                              </span>
                              <br>

                              <span class="training" style="font-size: 15px;">
                                <i class="fa fa-calendar"></i>&nbsp;&nbsp;@lang("training.date")
                              </span><br>
                              <span class="training_topic" style="font-size: 15px;">
                                {{date("d F Y", strtotime($val->start_date))}} - {{date("d F Y", strtotime($val->end_date))}}
                              </span>
                              <br>

                              <span class="training" style="font-size: 15px;">
                                <i class="fa fa-street-view"></i>&nbsp;&nbsp;@lang("training.lokasi")
                              </span><br>
                              <span class="training_topic" style="font-size: 15px;">
                                {{$location}}
                              </span>
                              <br><br>

                              <?php echo $button;?><br><br>
                            </div>
                          </div>
                      </div>
                      @endforeach
                    </div>
                </div>
            </div><br><br>
            <div class="row">
              <div class="container">
                <div class="row justify-content-center">
                  {{ $e_detail->render("pagination::bootstrap-4") }}
                </div>
              </div>
            </div>
        </div>
    </div>
    <!--Training end-->
@include('frontend.layouts.footer')
<script type="text/javascript">
  $(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  });

  function __join(id){
    window.location.href = "{{url('/front_end/join_event/')}}/"+id;
  }
</script>