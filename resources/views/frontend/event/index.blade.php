@include('frontend.layouts.header')
<?php
  $loc = app()->getLocale();
  if(Auth::user()){
    $for = 'admin';
    $message = '';
    $dmr = '1cm';
  } else if(Auth::guard('eksmp')->user()){
    if(Auth::guard('eksmp')->user()->id_role == 2){
      $for = 'eksportir';
      $message = '';
      $dmr = '2cm';
    } else {
      $for = 'importir';
        if($loc == "ch"){
          $message = "您无权加入";
        }elseif($loc == "in"){
          $message = "Anda Tidak Memiliki Akses untuk Bergabung!";
        }else{
          $message = "You do not Have Access to Join!";
        }
        $dmr = '2cm';
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
      $dmr = '1cm';
  }
?>
<style type="text/css">
    .thumbnail{ text-align: center; }
    td{ line-height: 15px; }
    .imge{
        padding-right: 50px;
        padding-top: 20px;
        padding-left: 50px;
    }
    .centerZ {
      display: block;
      margin-left: auto;
      margin-right: auto;
      width: 100%;
      height: 100%;
    }
    .icon_{
        height: 22px;
        width: 22px;
        margin-top: 5px;
    }
    table,tr,td{
        text-align: center;
    }
    #tableexd{
        margin: 1cm;
    }
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
      <div class="col-md-12 col-lg-12">
        <span style="color: #1a70bb; text-align: center;"><h2>@lang("frontend.jdl_event")</h2></span>
      </div>
    </div><br>
      @foreach($e_detail as $key => $ed)
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
          <div class="col-lg-6 col-md-6 col-12" style="height: 50%; padding-top: 10px;">
      @endif
        <?php
          if($loc == "ch"){
            $title = $ed->event_name_chn;
            $s_date = date('d F Y', strtotime($ed->start_date));
            $e_date = date('d F Y', strtotime($ed->end_date));
            $comod = getEventCom($ed->event_comodity,'ch');
            $lokasi = $ed->name_chn;
          }elseif($loc == "in"){
            $title = $ed->event_name_in;
            $s_date = getTanggalIndo(date('Y-m-d', strtotime($ed->start_date)));
            $e_date = getTanggalIndo(date('Y-m-d', strtotime($ed->end_date)));
            $comod = getEventCom($ed->event_comodity,'in');
            $lokasi = $ed->name_in;
          }else{
            $title = $ed->event_name_en;
            $s_date = date('d F Y', strtotime($ed->start_date));
            $e_date = date('d F Y', strtotime($ed->end_date));
            $comod = getEventCom($ed->event_comodity, 'en');
            $lokasi = $ed->name_en;
          }

          if($for == "admin" || $for == "eksportir"){
            $url = url('/').'/front_end/join_event/'.$ed->id;
          } else {
            $url = "#";
          }

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

        ?>
          <div style="width: 100%; height: 75%; margin: auto; text-align: center;">
            <img class="rc" src="{{url('/')}}/{{$image}}">
          </div>
          <div style="height: 25%; padding-top: 5px;">
              <span style="font-family: arial; font-weight: 500; font-size: 18px;">{{$title}}</span><br>
              <span class="detail_rc">
              <i class="fa fa-calendar-check-o"></i>&nbsp;&nbsp;{{$s_date}} - {{$e_date}}
              <br>
              <i class="fa fa-map-marker"></i>&nbsp;&nbsp;&nbsp;{{$lokasi}}
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
    csrf_token = '{{ csrf_token() }}';

    function _Join(id,e,obj){
       e.preventDefault();
       console.log(login);
        if(login == 'admin'){
          alert('admin');
        } else if(login == 'eksportir'){
          $.post("{{ url('event/store_company') }}", {'_token': csrf_token, 'id_event': id}, function(data){
              location.reload();
           });
        } else if(login == 'importir'){
          alert("{{$message}}");
        } else {
          alert("{{$message}}");
        }
    }
    // $(document).ready(function () {
    // });
</script>
