@include('frontend.layout.header')
<style type="text/css">
  .button_form{width: 80px}
</style>
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
      <h4><b>@lang("frontend.cu-cu")</b></h4><br>
      <center>
        <div class="col-md-8">
         {!! Form::open(['url' => $url, 'class' => 'form-horizontal', 'files' => true]) !!}
           <div class="form-group row">
            <div class="col-md-1"></div>
               <label class="control-label col-md-3">@lang("frontend.cu-fullname")</label>
               <div class="col-md-6">
                   <input type="text" id="id" class="form-control integer" name="name" autocomplete="off" required>
               </div>
           </div>

           <div class="form-group row">
            <div class="col-md-1"></div>
               <label class="control-label col-md-3">@lang("frontend.cu-email")</label>
               <div class="col-md-6">
                   <input type="email" class="form-control" name="email" autocomplete="off" required>
               </div>
           </div>

           <div class="form-group row">
            <div class="col-md-1"></div>
               <label class="control-label col-md-3">@lang("frontend.cu-subyek")</label>
               <div class="col-md-6">
                   <input type="text" class="form-control" name="subyek" autocomplete="off" required>
               </div>
           </div>

           <div class="form-group row">
            <div class="col-md-1"></div>
               <label class="control-label col-md-3">@lang("frontend.cu-message")</label>
               <div class="col-md-6">
                   <textarea class="form-control" name="message" id="message" style="height: 150px"></textarea>
               </div>
           </div>
      
           <div class="form-group row">
              <div class="col-md-10">
                <div align="right">
                  <button class="btn btn-primary button_form" type="submit">@lang("frontend.cu-submit")</button>
                </div>
              </div>
           </div>
          {!! Form::close() !!}
        </div>
      </center>
      </div>
    </div>
  </div>
</div>
@include('frontend.layout.footer')