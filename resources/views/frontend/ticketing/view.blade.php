@include('frontend.layouts.header')
<style type="text/css">
  .form-control[readonly] {
    background-color: white;
  }
</style>
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
                            <li><a href="{{url('/front_end/history')}}">@lang('frontend.history.title')</a></li>
                            <li>Details Ticketing Support</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!--product details start-->
    <form action="{{route('front.ticket.store')}}" method="post">
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
                      <input type="text" autocomplete="off" class="form-control" name="name" title="@lang('frontend.yourname')" placeholder="@lang('frontend.yourname')" style="font-size: 14px;" value="{{$ticket->name}}" readonly>
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-md-3">
                      <label>@lang('frontend.history.email')</label>
                    </div>
                    <div class="col-md-7">
                      <input type="text" autocomplete="off" class="form-control" name="email" title="@lang('frontend.youremail')" placeholder="@lang('frontend.youremail')" style="font-size: 14px;" value="{{$ticket->email}}" readonly>
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-md-3">
                      <label>@lang('inquiry.subject')</label>
                    </div>
                    <div class="col-md-7">
                      <input type="text" autocomplete="off" class="form-control" name="subject" title="@lang('inquiry.subject')" placeholder="@lang('inquiry.subject')" style="font-size: 14px;" value="{{$ticket->subyek}}" readonly>
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-md-3">
                      <label>@lang('inquiry.msg')</label>
                    </div>
                    <div class="col-md-7">
                      <textarea name="messages" class="form-control" rows="8" cols="80" title="@lang('inquiry.msg')" placeholder="@lang('inquiry.msg')" style="font-size: 14px;" readonly><?php echo $ticket->main_messages; ?></textarea>
                    </div>
                  </div><br><br>
                  <div class="row">
                    <!-- <div class="col-md-3"></div> -->
                    <div class="col-md-10">
                      <div style="float: right;">
                        <a href="{{url('/front_end/history')}}" class="btn btn-danger" style="font-size: 14px;"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;&nbsp;@lang('button-name.back')</a>
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
        
    });
</script>