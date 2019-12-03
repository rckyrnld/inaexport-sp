@include('header')
<style type="text/css">
  .mySlides{ height: 300px; }
  #left td{
    text-align: left !important;
    font-size: 16px;
    color: #515663;
    font-weight: 600;
  }
  .modal-body {background-image: url('{{url('/')}}/front/assets/img/cp/bg.png');background-size: cover;background-repeat: no-repeat;width: 100%; margin: 0px; background-color: transparent; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px; border-top-left-radius: 20px; border-top-right-radius: 20px; height: 380px;}
  .modal-content{ background-color: transparent; border:none; }
  .icon{ width:15%;}
  .cp-data{padding-left: 25px;color: white;font-size: 20px; font-family: arial;text-align: left !important;"}
  #times:hover{color: red !important;}
</style>
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i>Event</h5>
                </div>

                <div class="box-body bg-light">
                    <div class="col-md-12"><br>
                        <div class="row">
                          <div class="col-md-6 col-lg-6 col-12">
                            <div class="w3-content w3-display-container">
                                @if($detail->image_1 !== NULL)
                                    <img class="mySlides" src="{{url('/')}}/uploads/Event/Image/{{$detail->id}}/{{$detail->image_1}}" style="width:100%;">
                                @else
                                    <img class="mySlides" src="{{url('/')}}/image/event/NoPicture.png" style="width:100%;">
                                @endif

                                @if($detail->image_2 !== NULL)
                                    <img class="mySlides" src="{{url('/')}}/uploads/Event/Image/{{$detail->id}}/{{$detail->image_2}}" style="width:100%;">
                                @endif

                                @if($detail->image_3 !== NULL)
                                    <img class="mySlides" src="{{url('/')}}/uploads/Event/Image/{{$detail->id}}/{{$detail->image_3}}" style="width:100%;">
                                @endif

                                @if($detail->image_4 !== NULL)
                                    <img class="mySlides" src="{{url('/')}}/uploads/Event/Image/{{$detail->id}}/{{$detail->image_4}}" style="width:100%;">
                                @endif

                              <button class="w3-button w3-display-left" style="background-color: #eae8e4;" onclick="plusDivs(-1)">&#10094;</button>
                              <button class="w3-button w3-display-right" style="background-color: #eae8e4;" onclick="plusDivs(1)">&#10095;</button>
                            </div><br>
                            <div class="w3-center">
                              <button class="btn btn-primary btn-lg" onclick="__join('{{getContactPerson($detail->id, 'event')}}')">&nbsp; Join &nbsp;</button>&nbsp;&nbsp;
                              <a href="{{url('/')}}/event" class="btn btn-danger btn-lg">&nbsp; Back &nbsp;</a>
                            </div>
                          </div>
                          <div class="col-md-6 col-lg-6 col-12">
                            <h2><b>{{$detail->event_name_en}}</b></h2>
                            <h5>{{date("d F Y", strtotime($detail->start_date))}} - {{date("d F Y", strtotime($detail->end_date))}}</h5>
                            <table id="left">
                              <tr>
                                  <td>Type</td>
                                  <td style="padding-left: 5px;padding-right: 10px;">:</td>
                                  <td>{{$detail->event_type_en}}</td>
                              </tr>
                              <tr>
                                  <td>Event Organizer</td>
                                  <td style="padding-left: 5px;padding-right: 10px;">:</td>
                                  <td>{{EventOrganizerName($detail->id_event_organizer, 'en')}}</td>
                              </tr>
                              <tr>
                                  <td>Comodity</td>
                                  <td style="padding-left: 5px;padding-right: 10px;">:</td>
                                  <td>{{EventComodityName($detail->event_comodity, 'en')}}</td>
                              </tr>
                              <tr>
                                  <td>Scope</td>
                                  <td style="padding-left: 5px;padding-right: 10px;">:</td>
                                  <td>{{$detail->event_scope_en}}</td>
                              </tr>
                              <tr>
                                  <td>Place</td>
                                  <td style="padding-left: 5px;padding-right: 10px;">:</td>
                                  <td>{{EventPlaceName($detail->id_event_place, 'en')}}</td>
                              </tr>
                              <tr>
                                  <td>Website</td>
                                  <td style="padding-left: 5px;padding-right: 10px;">:</td>
                                  <td>{{$detail->website}}</td>
                              </tr>
                            </table>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

  <!-- Modal Contact Person -->
    <div class="modal fade" id="modal_cp" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body" >
                  <table border="0" width="90%" align="center" height="30%">
                    <tr>
                      <td style="text-align: right !important;"><i class="fa fa-times" id="times" data-dismiss="modal" style="color: white !important; font-size: 24px !important;"></i></td>
                    </tr>
                  </table>
                  <table border="0" width="80%" align="center" style="margin-top: 10px;">
                    <tr>
                      <td class="icon" align="center"><img src="{{url('/')}}/front/assets/img/cp/nama.png" height="100%"></td>
                      <td class="cp-data" style="text-transform: capitalize;"><span id="cp_name"></span></td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <div style="height: 8px;">
                          <img src="{{url('/')}}/front/assets/img/cp/line.png" width="100%" height="100%" style="vertical-align: top;">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="icon" align="center"><img src="{{url('/')}}/front/assets/img/cp/phone.png" height="100%"></td>
                      <td class="cp-data"><span id="cp_phone"></span></td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <div style="height: 8px;">
                          <img src="{{url('/')}}/front/assets/img/cp/line.png" width="100%" height="100%" style="vertical-align: top;">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="icon" align="center"><img src="{{url('/')}}/front/assets/img/cp/email.png" height="100%" height="100%"></td>
                      <td class="cp-data"><span id="cp_email"></span></td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <div style="height: 8px;">
                          <img src="{{url('/')}}/front/assets/img/cp/line.png" width="100%" style="vertical-align: top;">
                        </div>
                      </td>
                    </tr>
                  </table>
                </div>
            </div>
        </div>
    </div>

<script>
var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  if (n > x.length) {slideIndex = 1}
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  x[slideIndex-1].style.display = "block";  
}

    function __join(id){
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
    }
</script>

@include('footer')