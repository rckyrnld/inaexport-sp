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
<div class="container">
  <div class="row justify-content-center" style="padding-top: 4%;">
    <div class="col-10">
      <img src="{{asset('front/assets/img/banner list training.png')}}" width="100%">
    </div>
  </div>  
</div>

    <!--Training start-->
    <div class="shop_area shop_reverse">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-12">
                    <div class="row shop_wrapper">
                      @foreach($data as $num => $val)
                        <?php
                          if($loc == "en"){
                            $location = $val->location_en;
                            $topic = $val->topic_en;
                            $training = $val->training_en;
                          } else if($loc == "in"){
                            if($val->location_in != null){
                              $location = $val->location_in;
                            } else {
                              $location = $val->location_en;
                            }

                            if($val->topic_in != null){
                              $topic = $val->topic_in;
                            }  else {
                              $topic = $val->topic_en;
                            }

                            if($val->training_in != null){
                              $training = $val->training_in;
                            }  else {
                              $training = $val->training_en;
                            }
                          } else {
                            if($val->location_chn != null){
                              $location = $val->location_chn;
                            } else {
                              $location = $val->location_en;
                            }

                            if($val->topic_chn != null){
                              $topic = $val->topic_chn;
                            }  else {
                              $topic = $val->topic_en;
                            }

                            if($val->training_chn != null){
                              $training = $val->training_chn;
                            }  else {
                              $training = $val->training_en;
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
                            <div class="col" style="height: 100%; padding-top: 15px;">
                              <span style="color: #edf1f5; font-weight: 600; font-size: 20px;">{{$training}}</span><br>

                              <span class="training">
                                <i class="fa fa-bullhorn"></i>&nbsp;&nbsp;@lang("training.topic")
                              </span><br>
                              <span class="training_topic">
                                {{$topic}}
                              </span>
                              <br>

                              <span class="training">
                                <i class="fa fa-calendar"></i>&nbsp;&nbsp;@lang("training.date")
                              </span><br>
                              <span class="training_topic">
                                {{date("d F Y", strtotime($val->start_date))}} - {{date("d F Y", strtotime($val->end_date))}}
                              </span>
                              <br>

                              <span class="training">
                                <i class="fa fa-clock-o"></i>&nbsp;&nbsp;@lang("training.durasi")
                              </span><br>
                              <span class="training_topic">
                                {{$val->duration}} @lang("training.day")
                              </span>
                              <br>

                              <span class="training">
                                <i class="fa fa-street-view"></i>&nbsp;&nbsp;@lang("training.lokasi")
                              </span><br>
                              <span class="training_topic">
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
                  {{ $data->render("pagination::bootstrap-4") }}
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
    var login = "{{$for}}";
    var id_user = "{{$id_user}}";
    var _token = $('meta[name=csrf-token]').attr('content');

    if(login == 'eksportir'){
      $.ajax({
          url: "{{route('training.join')}}",
          type: 'post',
          data: { _token : _token, id_training_admin:id, id_user:id_user},
          dataType: 'json',
          success: function(data) {
            if(data == 'Success'){
              window.location = "{{url('/training/view')}}";
            } else {
              location.reload();
            }
          }
      });
    } else {
      alert("{{$message}}");
    }
  }
</script>