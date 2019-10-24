@include('frontend.layout.header')

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
        <h5><b>@lang("research-corner.direktorat")</b></h5>

      </center>
      </div>
    </div>
  </div>
</div>
@include('frontend.layout.header')