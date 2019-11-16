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
          $message = "您无权下载";
        }elseif($loc == "in"){
          $message = "Anda Tidak Memiliki Akses untuk Mengunduh!";
        }else{
          $message = "You do not Have Access to Download!";
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
  img.rc{
    max-width: 100%;
    max-height: 100%;
    border-radius: 10px;
  }
  .detail_rc{
    color: #1a70bb;
    font-family: 'Arial' !important; 
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
                            <li>Research Corner</li>
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
      <div class="col-md-12 col-lg-12">
        <span style="color: #1a70bb; text-align: center;"><h2>Research Corner</h2></span>
      </div>
    </div><br>
      @foreach($research as $key => $data)
      @if($key == 0 || $key == 5 )
        <div class="form-group row utama" style="height: 100%">
      @endif
      
      @if( $key == 0 || $key == 1 )
          <div class="col-lg-6 col-md-6 col-12 second" style="height: 100%;">
      @elseif($key >= 5)
          <div class="col-lg-3 col-md-3 col-12 second" style="height: 100%;">
      @endif

      @if( $key > 0 && $key < 5)
        @if($key == 1)
          <div class="form-group row" style="height: 100%;">
        @endif
          <div class="col-lg-6 col-md-6 col-12" style="height: 50%; padding-top: 5px;">
      @endif
        <?php
          if($loc == "ch"){
            $title = $data->title_en;
            $date = date('d F Y', strtotime($data->publish_date)).' ( '.date('H:i', strtotime($data->publish_date)).' )';
          }elseif($loc == "in"){
            $title = $data->title_in;
            $date = getTanggalIndo(date('Y-m-d', strtotime($data->publish_date))).' ( '.date('H:i', strtotime($data->publish_date)).' )';
          }else{
            $title = $data->title_en;
            $date = date('d F Y', strtotime($data->publish_date)).' ( '.date('H:i', strtotime($data->publish_date)).' )';
          }

          if($for == "admin" || $for == "eksportir"){
            $url = url('/').'/uploads/Research Corner/File/'.$data->exum;
          } else {
            $url = "#";
          }

          $image = 'uploads/Research Corner/Cover/'.$data->cover;
          if($data->cover != null || $data->cover != ''){
            if(file_exists($image)) {
              $image = 'uploads/Research Corner/Cover/'.$data->cover;
            } else {
              $image = '/image/nocover.jpg';
            }
          } else {
            $image = '/image/cover_rc.png';
          }
        ?>
          <div style="width: 100%; height: 75%; margin: auto; text-align: center;">
              <img class="rc" src="{{url('/')}}/{{$image}}" width="100%">
          </div>
          <div style="height: 25%; padding-top: 5px;">
              <span style="font-family: arial; font-weight: 500; font-size: 18px;"><strong>{{$title}}</strong></span><br>
              <span class="detail_rc" style="font-size: 12px;">
              <i class="fa fa-calendar-check-o"></i>&nbsp;&nbsp;{{$date}}
              <br>
              <a href="{{$url}}" class="detail_rc" onclick="__download('{{$data->id}}', event, this)" style="text-decoration: none;"><i class="fa fa-download"></i>&nbsp;&nbsp;&nbsp;@lang("button-name.donlod")</a>
              </span>
          </div>
      </div>
        @if( $key == 4 || $key == 9)
          </div>
          @if($key == 4)
            </div></div>
          @endif
        @endif
      @endforeach
    <div class="row">
      <div class="container">
        <div class="row justify-content-center">
          
        </div>
      </div>
    </div>
  </div>
</div>
<div style="margin-top: 0px; margin-bottom: 5%; background-color: white;"></div>
@include('frontend.layouts.footer')
<script type="text/javascript">
  var login = "{{$for}}";

  function __download(id, e, obj){
    e.preventDefault();

    if(login == 'admin'){
      window.open(obj.href, '_blank');
    } else if(login == 'eksportir'){
      $.ajax({
          url: "{{route('research-corner.download')}}",
          type: 'get',
          data: {id:id},
          dataType: 'json',
          success:function(response){
            if(response == 'nihil'){
              window.open(obj.href, '_blank');
            } else {
              alert('The document has been downloaded');
            }
          }
      });
    } else {
      alert("{{$message}}");
    }
  }
</script>