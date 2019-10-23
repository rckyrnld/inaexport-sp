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
    <div class="content-body">
        <div class="py-5 text-center w-100">
            <!-- <div class="box"> -->
                <h4><b>@lang("frontend.jdl_event")</b></h4><br>
                <center>
                    <h5><b>@lang("frontend.direktorat")</b></h5>
                    <div class="col-md-3" style="float: right;">
                        <form action="{{url('/')}}/front_end/event/search" method="POST" role="search">
                            {{ csrf_field() }}
                            <div class="input-group">
                                <input type="text" class="form-control" name="eq"
                                    placeholder="Search Title..." autocomplete="off"> <span class="input-group-btn">
                                    <button type="submit" class="btn btn-default">
                                        <span class="glyphicon glyphicon-search"></span>
                                        @lang("frontend.cari")
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div><br>
                    <div class="col-md-12"><br>
                        <div class="row">
                            <table id="tableexd"><tbody>
                            <?php $co=0; ?>
                            @foreach($e_detail as $ed) 
                                @if($co < 4)
                                    @if($co==0)
                                        <tr>
                                    @endif
                                        <td>
                                            <div class="box" style="width: 7cm;height: 7.7cm;margin: 5px;border-radius: 25px;">
                                                <div class="thumbnail">
                                                    <div class="imge">
                                                        @if($ed->image_1 !== NULL)
                                                            <img src="{{url('/')}}/uploads/Event/Image/{{$ed->id}}/{{$ed->image_1}}" class="centerZ">
                                                        @else
                                                            <img src="{{url('/')}}/image/event/NoPicture.png" alt="No Picture" style="width:55%;height: 50%">
                                                        @endif
                                                    </div>
                                               </div><br>
                                               <table style="margin-left:28px;" class="tbl_">
                                                <?php
                                                  if($loc == "ch"){
                                                    $title = $ed->event_name_chn;
                                                    $s_date = date('d F Y', strtotime($ed->start_date));
                                                    $e_date = date('d F Y', strtotime($ed->end_date));
                                                    $comod = getEventCom($ed->event_comodity,'ch');
                                                  }elseif($loc == "in"){
                                                    $title = $ed->event_name_in;
                                                    $s_date = getTanggalIndo(date('Y-m-d', strtotime($ed->start_date)));
                                                    $e_date = getTanggalIndo(date('Y-m-d', strtotime($ed->end_date)));
                                                    $comod = getEventCom($ed->event_comodity,'in');
                                                  }else{
                                                    $title = $ed->event_name_en;
                                                    $s_date = date('d F Y', strtotime($ed->start_date));
                                                    $e_date = date('d F Y', strtotime($ed->end_date));
                                                    $comod = getEventCom($ed->event_comodity, 'en');
                                                  }

                                                  if($for == "admin" || $for == "eksportir"){
                                                    $url = url('/').'/front_end/join_event/'.$ed->id;
                                                  } else {
                                                    $url = "#";
                                                  }
                                                ?>

                                                    <tr><td>{{$ed->event_name_en}}</td></tr>
                                                    <tr><td><b>@lang("frontend.t_date") </b></td></tr>
                                                    <tr><td>{{$s_date}} - {{$e_date}}</td></tr>
                                                    <tr><td><b>@lang("frontend.t_Comodity")</b></td></tr>
                                                    <tr><td>{{$comod}}</td></tr>
                                                    <tr><td style="padding-top: 9px"><a href="{{$url}}" onclick="_Join('{{$ed->id}}', event, this)" class="btn btn-primary">@lang("frontend.t_join")</a></td></tr>
                                                </table>
                                            </div>
                                        </td>
                                    @if($co==3)
                                        </tr>
                                    @endif
                                    <?php if ($co==3){ $co=0; }else{ $co++; }  ?>
                                @endif
                            @endforeach
                            <tr>
                                <td colspan="4"><br><br><div style="float: right;">
                                {{ $e_detail->render("pagination::bootstrap-4") }}</div></td>
                            </tr>
                            </tbody></table>
                        </div><br><br>
                    </div>
                </center>
                
            <!-- </div> -->
        </div>
    </div>
</div>
@include('frontend.layout.footer')
<script type="text/javascript">
    var login = "{{$for}}";
    function _Join(id,e,obj){
       e.preventDefault();
       console.log(login);
        if(login == 'admin'){
          alert('admin');
        } else if(login == 'eksportir'){
          alert('eksportir');
        } else if(login == 'importir'){
          alert("{{$message}}");
        } else {
          alert("{{$message}}");
        }
    }
    // $(document).ready(function () {
    // });
</script>
