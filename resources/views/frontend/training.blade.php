@include('frontend.layouts.header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<?php
  $loc = app()->getLocale();
  if(Auth::guard('eksmp')->user() || Auth::user()){
    $for = "user";
    $message = '';
  } else {
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
  .modal-header { background-color: #2385d4; color: white; font-size: 20px; text-align: center;}
  .modal-body{ height: 300px; }
  .modal-content { border-bottom-left-radius: 20px; border-bottom-right-radius: 20px; border-top-left-radius: 20px; border-top-right-radius: 20px; overflow: hidden;}
  .modal-footer { background-color: #2385d4; color: white; font-size: 20px; text-align: center;}
  #Tablemodal td {
    text-align: left !important;
  }
  .cp{
    padding-left: 25px;
    font-weight: 600;
  }
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
  i.mod:hover{
    color: red;
  }
</style>
<div class="container">
  <div class="row justify-content-center" style="padding-top: 4%;">
    <div class="col-lg-10 col-md-10">
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

                          if($val->param){
                            if($val->param == 'Days'){
                              $duration = Lang::get('training.day');
                            } else {
                              $duration = Lang::get('training.week');
                            }
                          } else {
                            $duration = '';
                          }

                          if($for == 'user'){
                            $button = '<button class="btn training join btn-info" onclick="__join(\''.getContactPerson($val->id, 'training').'\')">'.Lang::get('training.minat').'</button>';
                          } else {
                            $button = '<button class="btn training join btn-info" onclick="__join()">'.Lang::get('training.minat').'</button>';
                          }
                        ?>

                        <div class="col-lg-4 col-md-4 col-12" style="padding-top: 20px;">
                          <div style="background-color: #2385d4; border-radius: 10px; vertical-align: top; height: 100%;">
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
                                {{$val->duration}} {{$duration}}
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
    </div>
    <!--Training end-->

    @if($for == 'user')
    <!-- Modal Contact Person -->
    <div class="modal fade" id="modal_cp" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  <table width="100%">
                    <tr>
                      <td width="20%"></td>
                      <td width="60%"><span class="modal-title" id="exampleModalLabel"><b>@lang("frontend.contact-person")</b></span></td>
                      <td width="20%" align="right">
                        <i class="fa fa-times mod" data-dismiss="modal"></i>
                      </td>
                    </tr>
                  </table>
                </div>
                <div class="modal-body" style="height: auto;">
                  <table width="80%" style="font-size: 15px;" id="Tablemodal" cellpadding="10px">
                    <tr>
                      <td class="cp" width="40%">@lang("service.nama")</td>
                      <td width="5%">:</td>
                      <td style="padding-left: 20px;" colspan="2"><span id="cp_name"></span></td>
                    </tr>
                    <tr>
                      <td class="cp" width="40%">@lang("register2.forms.phone")</td>
                      <td width="5%">:</td>
                      <td style="padding-left: 20px;" colspan="2"><span id="cp_phone"></span></td>
                    </tr>
                    <tr>
                      <td class="cp" width="40%">@lang("register2.forms.email")</td>
                      <td width="5%">:</td>
                      <td style="padding-left: 20px;" colspan="2"><span id="cp_email"></span></td>
                    </tr>
                  </table>
                  <br>
                </div>
                <div class="modal-footer">
                  <table width="100%">
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                  </table>
                </div>
            </div>
        </div>
    </div>
    @endif
@include('frontend.layouts.footer')
<script type="text/javascript">
  function __join(id){
    var login = "{{$for}}";
    if(login == 'user'){
      if(id != '-'){
        var pecah = id.split('|');
        $('#cp_name').html(pecah[0]);
        $('#cp_phone').html(pecah[1]);
        $('#cp_email').html(pecah[2]);
      } else {
        $('#cp_name').html('No Contact');
        $('#cp_phone').html('No Contact');
        $('#cp_email').html('No Contact');
      }

      $('#modal_cp').modal('show'); 
    } else {
      alert("{{$message}}");
    }
  }
</script>