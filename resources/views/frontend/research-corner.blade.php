@include('frontend.layout.header')

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
      <h4><b>@lang("research-corner.terbaru") Research Corner</b></h4><br>
      <center>
        <h5><b>@lang("research-corner.direktorat")</b></h5>
        <table class="table table-bordered table-striped" style="width: 90%; padding: 20px; text-align: center;">
          <thead>
            <th style="text-align: center;">@lang("research-corner.judul_rc")</th>
            <th style="text-align: center;">@lang("research-corner.tipe_rc")</th>
            <th style="text-align: center;">@lang("research-corner.negara_rc")</th>
            <th style="text-align: center;">@lang("research-corner.publish_rc")</th>
            <th style="text-align: center;">@lang("research-corner.unduh_rc")</th>
          </thead>  
          <tbody>
            @foreach($research as $data)
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
            ?>
            <tr>
              <td>{{$title}}</td>
              <td>{{rc_type($data->id_csc_research_type, $loc)}}</td>
              <td>{{rc_country($data->id_mst_country)}}</td>
              <td>{{$date}}</td>
              <td><a href="{{$url}}" class="btn btn-primary" onclick="__download('{{$data->id}}', event, this)"><span class="fa fa-download"></span></a></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </center>
      </div>
    </div>
  </div>
</div>
@include('frontend.layout.header')
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