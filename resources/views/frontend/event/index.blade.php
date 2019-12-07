@include('frontend.layouts.header')
<?php
  $loc = app()->getLocale();
  if(Auth::guard('eksmp')->user()){
    if(Auth::guard('eksmp')->user()->id_role == 2){
      $id_user = Auth::guard('eksmp')->user()->id;
    } else {
      $id_user = '0';
    }
  } else {
    $id_user = '0';
  }

?>
<style type="text/css">
    img.rc{
      max-width: 100%;
      max-height: 100%;
      border-radius: 10px;
    }
    .detail_rc{
      color: #1a70bb;
      font-family: 'Myriad-pro' !important; 
      font-size: 14px;
    }
    .a-modif:hover{
      text-decoration: none;
      background-color: #f1ecec;
    }
    .a-modif.small{
      height: 100%; padding-top: 13px; border-radius: 10px; padding-bottom: 10px;
    }
</style>
<!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="index.html">@lang("frontend.proddetail.home")</a></li>
                            <li>Events</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--breadcrumbs area end-->

<div style="background-color: white; padding-bottom: 3%;">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-lg-6">
        <span style="color: #1a70bb;"><h2>@lang("frontend.jdl_event")</h2></span>
      </div>
      <div class="col-md-6 col-lg-6" align="right">
        <form class="form-horizontal" enctype="multipart/form-data" method="GET" action="{{url('/front_end/event')}}">
          {{ csrf_field() }}
          <div class="input-group" style="width: 60%;">
              <input type="text" name="search" class="form-control" placeholder="Search" autocomplete="off">
              <div class="input-group-prepend">
                <button type="submit" class="input-group-text" style="border-top-right-radius: 5px;border-bottom-right-radius: 5px;">&nbsp;<i class="fa fa-search"></i>&nbsp;</button>
              </div>
          </div>
        </form>
      </div>
    </div><br>
    @if($page > 1 || $search != null)
      <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12 col-12">
          <div class="row shop_wrapper">
    @endif
      @foreach($e_detail as $key => $ed)
        @if($page == 1 && $search == null)
          @if($key == 0 || $key == 5 )
            <div class="form-group row utama" style="height: 100%">
          @endif
        @endif


        @if($page == 1 && $search == null)
          @if( $key == 0 || $key == 1 )
              <div class="col-lg-6 col-md-6 col-12 second @if($key == 0) a-modif @endif" style="height: 100%; padding-bottom: 10px; border-radius: 10px; @if($key == 0) padding-top: 13px; @endif">
                <?php $size = 426; $num_char = 65;?>
          @elseif($key >= 5)
              <div class="col-lg-3 col-md-3 col-12 second a-modif small">
                <?php $size = 162; $num_char = 25;?>
          @endif
        @else
          <div class="col-lg-3 col-md-3 col-12 second a-modif small">
          <?php $size = 162; $num_char = 25;?>
        @endif

        @if($page == 1 && $search == null)
          @if( $key > 0 && $key < 5)
            @if($key == 1)
              <div class="form-group row" style="height: 100%;">
            @endif
              <div class="col-lg-6 col-md-6 col-12 a-modif" style="height: 50%; padding-bottom: 10px; padding-top: 13px; border-radius: 10px;">
                <?php $size = 162; $num_char = 25;?>
          @endif
        @endif
        <?php
          if($loc == "ch"){
            if($ed->event_name_chn != null){
              $title = $ed->event_name_chn;
            } else {
              $title = $ed->event_name_en;
            }
          }elseif($loc == "in"){
            if($ed->event_name_in != null){
              $title = $ed->event_name_in;
            } else {
              $title = $ed->event_name_en;
            }
          }else{
            $title = $ed->event_name_en;
          }

          if(date('Y-m-d', strtotime($ed->start_date)) == date('Y-m-d', strtotime($ed->end_date))){
            $tanggal = date('d F Y', strtotime($ed->start_date));
          } else if(date('Y-m', strtotime($ed->start_date)) == date('Y-m', strtotime($ed->end_date))){
            $tanggal = date('d', strtotime($ed->start_date)).' - '.date('d F Y', strtotime($ed->end_date));
          } else {
            $tanggal = date('d F Y', strtotime($ed->start_date)).' - '.date('d F Y', strtotime($ed->end_date));
          }

          $lokasi = EventPlaceName($ed->id_event_place, $loc);

          if (Auth::guard('eksmp')->user()) {
                $id_ = Auth::guard('eksmp')->user()->id;
                $data = DB::table('event_company_add')->where('id_itdp_profil_eks', $id_)->where('id_event_detail', $ed->id)->first();
                if ($data) {
                    $statt = $data->status;
                }else{
                    $statt = null;
                }
           }else{
                 $statt = null;
           }

           $image = 'uploads/Event/Image/'.$ed->id.'/'.$ed->image_1;
          if($ed->image_1 != null || $ed->image_1 != ''){
            if(file_exists($image)) {
              $image = 'uploads/Event/Image/'.$ed->id.'/'.$ed->image_1;
            } else {
              $image = '/image/event/NoPicture.png';
            }
          } else {
            $image = '/image/event/NoPicture.png';
          }

          if(strlen($title) > $num_char){
              $cut_text = substr($title, 0, $num_char);
              if ($title{$num_char - 1} != ' ') { 
                  $new_pos = strrpos($cut_text, ' '); 
                  $cut_text = substr($title, 0, $new_pos);
              }
              $titleName = $cut_text . '...';
          }else{
              $titleName = $title;
          }

          if(strlen($lokasi) > ($num_char+12)){
              $cut_text = substr($lokasi, 0, ($num_char+12));
              if ($lokasi{ ($num_char+12) - 1} != ' ') {
                  $new_pos = strrpos($cut_text, ' '); 
                  $cut_text = substr($lokasi, 0, $new_pos);
              }
              $lokasiName = $cut_text . '...';
          }else{
              $lokasiName = $lokasi;
          }
          ?>
          <a href="{{url('/front_end/join_event/')}}/{{$ed->id}}" class="a-modif">
          <div style="width: 100%; height: 75%; margin: auto; text-align: center;">
            <img class="rc fix-image" src="{{url('/')}}/{{$image}}" style="height: {{$size}}px;">
          </div>
          <div style="height: 25%; padding-top: 5px;">
              <span style="font-family: arial; font-weight: 530; font-size: 18px; color: black !important;" title="{{$title}}">{{$titleName}}</span><br>
              <span class="detail_rc" title="{{$lokasi}}">
              <i class="fa fa-calendar-check-o"></i>&nbsp;&nbsp;{{$tanggal}}
              <br>
              <i class="fa fa-map-marker"></i>&nbsp;&nbsp;&nbsp;{{$lokasiName}}<br>
              </span>
          </div>
          </a>
      </div>
        @if($page == 1 && $search == null)
          @if( $key == 4 || $key == 9)
            </div>
            @if($key == 4)
              </div></div>
            @endif
          @endif
        @endif
      @endforeach

      @if($page > 1)
        </div></div></div>
      @endif
  </div>
  <br><br>
    <div class="row">
      <div class="container">
        <div class="row justify-content-center" align="center">
          {{ $e_detail->render("pagination::bootstrap-4") }}
        </div>
      </div>
    </div>
    <br>
</div>
<div style="margin-top: 0px; margin-bottom: 5%; background-color: white;"></div>
@include('frontend.layouts.footer')
<script type="text/javascript">
  $(document).ready(function() {
    if(window.innerWidth <= 760){
        $('.fix-image').css('height','162px');
    } 
  })
</script>