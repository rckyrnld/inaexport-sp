@include('frontend.layouts.header')
<?php
  $loc = app()->getLocale();
  if(Auth::user()){
    $for = 'admin';
    $message = '';
  } else if(Auth::guard('eksmp')->user()){
    if(Auth::guard('eksmp')->user()->id_role == 2){
      $for = 'eksportir';
      $message = '';
    } else {
      $for = 'importir';
        if($loc == "ch"){
          $message = "您无权加入";
        }elseif($loc == "in"){
          $message = "Anda Tidak Memiliki Akses untuk Bergabung!";
        }else{
          $message = "You do not Have Access to Join!";
        }
    }
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

</style>
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="{{url('/front_end')}}">@lang('frontend.proddetail.home')</a></li>
                            <li><a href="#">@lang('frontend.history.ticket')</a></li>
                            <li>@lang('frontend.ticket_title')</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!--product details start-->
    <form action="{{route('front.ticket.store')}}" method="post" id="formTicket">
      {{ csrf_field() }}
      <div class="product_details mt-20" style="background-color: #ddeffd; margin-bottom: 0px !important; margin-top: 0px; font-size: 14px;">
          <div class="container">
            <br><br>
            <div class="row">
                <div class="col-lg-2 col-md-12"></div>
                <div class="col-lg-8 col-md-12">
                  <h5><b>@lang('frontend.history.ticket')</b></h5>
                  <br>
                  <div class="row">
                    <div class="col-md-3">
                      <label>@lang('frontend.history.fullname')</label>
                    </div>
                    <div class="col-md-7">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="text" autocomplete="off" class="form-control" name="name" title="@lang('frontend.yourname')" placeholder="@lang('frontend.yourname')" style="font-size: 14px;" required>
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-md-3">
                      <label>@lang('frontend.history.email')</label>
                    </div>
                    <div class="col-md-7">
                      <input type="text" autocomplete="off" class="form-control" name="email" title="@lang('frontend.youremail')" placeholder="@lang('frontend.youremail')" style="font-size: 14px;" required>
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-md-3">
                      <label>@lang('inquiry.subject')</label>
                    </div>
                    <div class="col-md-7">
                      <input type="text" autocomplete="off" class="form-control" name="subject" title="@lang('inquiry.subject')" placeholder="@lang('inquiry.subject')" style="font-size: 14px;" required>
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-md-3">
                      <label>@lang('inquiry.msg')</label>
                    </div>
                    <div class="col-md-7">
                      <textarea name="messages" class="form-control" rows="8" cols="80" title="@lang('inquiry.msg')" placeholder="@lang('inquiry.msg')" style="font-size: 14px;" required></textarea>
                    </div>
                  </div><br><br>
                  <div class="row">
                    <!-- <div class="col-md-3"></div> -->
                    <div class="col-md-10">
                      <div style="float: right;">
                        <a href="{{url('/')}}" class="btn btn-danger" style="font-size: 14px;"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;&nbsp;@lang('button-name.cancel')</a>
                        <button type="button" class="btn btn-primary" name="button" id="button" style="font-size: 14px;"><i class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp;&nbsp;@lang('button-name.submit')</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-2 col-md-12"></div>
            </div>
            <br><br>
          </div>
      </div>
    </form>
  </form>
  <!--product details end-->

@include('frontend.layouts.footer')
<script type="text/javascript">
    $(document).ready(function(){
        $("#button").click(function() {
          @if(Auth::guard('eksmp')->user())
            $( "#formTicket" ).submit();
          @else
            alert("@lang('frontend.lbl6')");
            window.location.href = "{{url('/login')}}";
          @endif
        });
    });
</script>