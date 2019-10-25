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
          <table width="100%" border="0">
            <tr>
              <th>Tracking of Type</th>
              <th>:</th>
              <td>
                  <select class="form-control" name="type" id="type" data-toggle="tooltip" data-trigger="manual" title="Please Select Tracking First">
                    <option></option>
                    <option value="china-ems">China EMS</option>
                    <option value="fedex">Fedex</option>
                    <option value="dhl">DHL Express</option>
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
          <div id="TeS"></div>
          <table class=""></table>
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
      placeholder: 'Select Type'
    });
  });
  
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
      var type = $('#type').val();
      var number = $('#number').val();
        $.ajax({
            url: "{{route('api.tracking')}}",
            method: 'get',
            data: {
              type : type,
              number : number
            },
            dataType: 'json',
            success:function(data){
              console.log(data);
              console.log(data.meta.code);
              console.log(data.data.items);
              // console.log(JSON.parse(data));
            }
        });
    }
  }
</script>