@include('frontend.layout.header')
<style type="text/css">
  input[type="text"], input[type="text"]:focus{
    border-color: #dce5e8;
  }
</style>
<?php
  $loc = app()->getLocale();
?>
<div class="d-flex flex-column flex" style="">
  <div class="light bg pos-rlt box-shadow" style="padding-left:10px; padding-right:10px; padding-top:10px; padding-bottom:10px;    background-color: #2791a6 ; color: #ffffff">
    <div class="mx-auto">
      <table border="0" width="100%">
        <tr>
        <td width="30%" style="font-size:13px;padding-left:10px"><img height="30px" src="{{url('assets')}}/assets/images/logo.jpg" alt="." ><b>&nbsp;&nbsp;&nbsp; Ministry Of Trade</b></td>
        <td width="30%"></td>
        <td width="40%" align="right" style="padding-right:10px;">
          <a href="{{ url('locale/en') }}"><img width="20px" height="15px" src="{{asset('negara/en.png')}}"></a>&nbsp;
          <a href="{{ url('locale/in') }}"><img width="20px" height="15px" src="{{asset('negara/in.png')}}"></a>&nbsp;
          <a href="{{ url('locale/ch') }}"><img width="20px" height="15px" src="{{asset('negara/ch.png')}}"></a>&nbsp;&nbsp;&nbsp;
          <a href="{{url('login')}}"><font color="white"><i class="fa fa-sign-in"></i> @lang("frontend.lbl3")</font></a>
        </td>
        </tr>
      </table>
    </div>
  </div>
  <div id="content-body">
    <div class="py-5 text-center w-100">
      <h4><b>Tracking of goods</b></h4><br>
      <center>
        <div class="col-md-8">
          <table width="100%" border="0" cellpadding="5">
            <tr>
              <th>Tracking of Type</th>
              <th>:</th>
              <td>
                  <select class="form-control" name="type" id="type" data-toggle="tooltip" data-trigger="manual" title="Please Select Tracking First">
                    <option></option>
                    @foreach($kurir as $val)
                    <option value="{{$val->api}}">{{$val->name}}</option>
                    @endforeach
                  </select>
              </td>
              <td></td>
            </tr>
            <tr>
              <th>Number Tracking</th>
              <th>:</th>
              <td><input type="text" autocomplete="true" name="number" id="number" class="form-control" data-toggle="tooltip" data-trigger="manual" title="Please Input Number"></td>
              <td style="text-align: center; "><button type="submit" class="btn btn-success" onclick="track()">Search</button></td>
            </tr>
          </table><br>
          <div id="TeS"></div><br>
          <table border="0" width="100%" class="table table-borderless" style="" id="tracking" style="display: none;">
            <thead>
              <tr>
                <th id="status" colspan="3"><h5><div id="status_code"></div></h5></th>
              </tr>
            </thead>
            <tbody style="background-color: #e7ebf1; font-size: 14px; color: black" id="tbody_tracking">
            </tbody>
          </table>
        </div>
      </center>
      </div>
    </div>
  </div>
</div>

@include('frontend.layout.header')
<script type="text/javascript">
  $(document).ready(function() {
    $('#type').select2({
      placeholder: 'Select a Courier'
    });
  });

  var list_status = {
      'pending'     : 'Pending',
      'transit'     : 'Transit',
      'pickup'      : 'Pickup',
      'delivered'   : 'Delivered',
      'undelivered' : 'Undelivered',
      'notfound'    : '',
      'exception'   : '',
      'expired'     : 'Expired'
  };

  var sub_status_nf = {
    'notfound001' : 'Information Received',
    'notfound002' : 'Not Found'
  };

  var sub_status_ex = {
    'exception001' : 'Exception',
    'exception002' : 'Information Received',
    'exception003' : 'Information Received',
    'exception004' : 'The Package is Unclaimed',
    'exception005' : 'The Package was Sent Back to the Sender',
    'exception006' : 'The Package is Retained by Customs',
    'exception007' : 'The Package is Damaged',
    'exception008' : 'The Package is Canceled'
  }
  
  function track(){
    if($('#type').val() == ''){
      $('#type').tooltip('toggle');
        setTimeout(function () {
          $('#type').tooltip('toggle');
        }, 1000);

    } else if($('#number').val() == '') {
      $('#number').tooltip('toggle');
        setTimeout(function () {
          $('#number').tooltip('toggle');
        }, 1000);

    } else {
      $('.histori').remove(); 
      var type = $('#type').val();
      var number = $('#number').val();
      $('#tracking').hide(); 
      $('#TeS').show(); 
      $('#TeS').html('<div class="progress"><div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div></div>');
      $('.progress-bar').animate({width: "30%"}, 100);
        
        $.ajax({
            url: "{{route('api.tracking')}}",
            method: 'get',
            data: {
              type : type,
              number : number
            },
            dataType: 'json',
            statusCode: {
              500: function() {
                end_loading();
                $('#tbody_tracking').hide(); 
                $('#status').css({'background-color':'#b1b5b7eb', 'color':'white', 'text-align':'center'});
                $('#status_code').html('Server Busy! Please Try Again.');
                $('#tracking').show('slow'); 
              },
              200: function(response) {
                end_loading();
                console.log(response);
                // console.log(response.meta.code);
                // console.log(response.data.items[0].status);
                // console.log(response.data.items[0].substatus);
                // console.log(response.data.items[0].origin_info);
                // console.log(response.data.items[0].origin_info.trackinfo[0]);
                // console.log(response.data.items[0].origin_info.phone);
                switch(response.meta.code){
                  case 200:
                      $('#tbody_tracking').show(); 
                      var histori = '';
                      var status = response.data.items[0].status;
                      var sub_status = response.data.items[0].substatus;
                      var origin = response.data.items[0].original_country;
                      var destinasi = response.data.items[0].destination_country;
                      var track = response.data.items[0].origin_info.trackinfo;
                      console.log(origin);
                      console.log(track);
                      if(origin != null || typeof origin !== 'undefined' || origin.length > 1){
                        histori += '<tr class="histori"><td>Origin Country - '+origin+'</td>';
                      } else {
                        histori += '<tr class="histori"><td>Origin Country - Not Found</td>';
                      }

                      if(destinasi != null || typeof destinasi !== 'undefined' || destinasi.length > 1){
                        histori += '<td style="text-align: right;">Destination Country - '+destinasi+'</td></tr>';
                      } else {
                        histori += '<td style="text-align: right;">Destination Country - Not Found</td></tr>';
                      }

                      if(sub_status == null || sub_status == ''){
                        var message = list_status[status];
                        if(status == 'expired' || status ==  'undelivered' || status ==  'pending'){
                          $('#status').css({'background-color':'#ead226', 'color':'#525230', 'text-align':'center'});
                        } else {
                          $('#status').css({'background-color':'#6fe45a', 'color':'white', 'text-align':'center'});
                        }
                        $('#status_code').html(message);
                      } else {
                        if(status == 'notfound'){
                          var message = sub_status_nf[sub_status];
                        }else {
                          var message = sub_status_ex[sub_status];
                        }
                        $('#status').css({'background-color':'#ead226', 'color':'#525230', 'text-align':'center'});
                        $('#status_code').html(message);
                      }

                      if(track.length != 0){
                        for(var i=0; i < track.length; i++){
                          histori +='<tr class="histori"><td>Date :'+track[i].Date+'</td>';
                          histori +='<td>'+track[i].StatusDescription+'</td></tr>';
                        }
                      }

                      $('#tbody_tracking').append(histori); 
                      $('#tracking').show('slow'); 
                    break;
                  case 4014:
                      $('#tbody_tracking').hide(); 
                      $('#status_code').html('Tracking Number is Invalid');
                      $('#status').css({'background-color':'#c53731db', 'color':'white', 'text-align':'center'});
                      $('#tracking').show('slow'); 
                    break;
                  default:
                }
              }
            }
        });
    }
  }

  function end_loading(){
    $('.progress-bar').animate({width: "100%"}, 100);
    setTimeout(function(){
        $('.progress-bar').css({width: "100%"});
        setTimeout(function(){
            $('.my-box').html();
        }, 100);
        $('#TeS').hide(); 
    }, 500);
  }

</script>