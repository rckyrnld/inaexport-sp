@include('header')
<style type="text/css">
    .thumbnail{ text-align: center; }
    p{ line-height: 5px; }
    .imge{
        height: 2cm;
        width: 7.5cm;
        padding: 10px;
        /*padding-right: 50px;*/
        /*padding-top: 20px;*/
        /*padding-left: 50px;*/
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
        margin: 2cm;
    }
</style>
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i>Event</h5>
                </div>

                <div class="box-body bg-light">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block" style="text-align: center">
                            {{--                            <button type="button" class="close" data-dismiss="alert">×</button>--}}
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block" style="text-align: center">
                            {{--                                <button type="button" class="close" data-dismiss="alert">×</button>--}}
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <a class="btn" href="{{url('event/create')}}"
                       style="background-color: #1089ff; color: white;"><i class="fa fa-plus-circle"></i>&nbsp; Add</a>
                    <div class="col-md-3" style="float: right;">
                        <form action="{{url('/')}}/event/search" method="POST" role="search">
                            {{ csrf_field() }}
                            <div class="input-group">
                                <input type="text" class="form-control" name="q"
                                    placeholder="Search Title..." autocomplete="off"> <span class="input-group-btn">
                                    <button type="submit" class="btn btn-default">
                                        <span class="glyphicon glyphicon-search"></span>
                                        Search
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div><br>
                    <div class="col-md-12"><br>
                        <div class="row">
                          <div class="col-md-6">
                            <table id="tableexd"><tbody>
                            <?php $co=0; ?>
                            @foreach($e_detail as $ed)
                                @if($co < 3)
                                    @if($co == 0) 
                                      <tr>
                                    @endif
                                        <td>
                                            <div class="box" style="width: 7.5cm;height: 8.5cm;margin: 5px;border-radius: 25px;box-shadow: 2px 2px gray, -0.1em 0 .4em gray;">
                                                <div class="thumbnail">
                                                    <div class="imge">
                                                        @if($ed->image_1 !== NULL)
                                                            <?php $topZ='margin-top: -100px;';?>
                                                            <img src="{{url('/')}}/uploads/Event/Image/{{$ed->id}}/{{$ed->image_1}}" class="img-fluid img-thumbnail" style="height: 140px;">
                                                        @else
                                                            <?php $topZ='margin-top: -145px;';?>
                                                            <img src="{{url('/')}}/image/event/NoPicture.png" alt="No Picture" class="img-fluid" style="height: 140px;">
                                                        @endif 
                                                    </div>
                                                    <div align="right">
                                                        @if($ed->status_en == 'Verified') 
                                                            <img src="{{url('/')}}/image/event/ceklis.png" class="" >
                                                        @endif  
                                                    </div>
                                               </div>
                                               <div class="caption">
                                                <?php
                                                    $title = $ed->event_name_en;
                                                    if(strlen($title) > 43){
                                                          $cut_text = substr($title, 0, 43);
                                                          if ($title{43 - 1} != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                                              $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                                              $cut_text = substr($title, 0, $new_pos);
                                                          }
                                                          $titleName = $cut_text . '...';
                                                      }else{
                                                          $titleName = $title;
                                                      }

//                                                    $comodity = getEventComodity($ed->event_comodity);
//                                                    if(strlen($comodity) > 40){
//                                                          $cut_text = substr($comodity, 0, 40);
//                                                          if ($comodity{40 - 1} != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
//                                                              $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
//                                                              $cut_text = substr($comodity, 0, $new_pos);
//                                                          }
//                                                          $comodityName = $cut_text . '...';
//                                                      }else{
//                                                          $comodityName = $comodity;
//                                                      }
                                                ?>
                                                <table width="100%" style="margin-top: 1.5cm">
                                                    <tr><td title="{{$title}}">{{$titleName}}</td></tr>
                                                    <tr><td><b>Start Date - End Date</b></td></tr>
                                                    <tr><td>{{getTanggalIndo($ed->start_date)}} - {{getTanggalIndo($ed->end_date)}}</td></tr>
{{--                                                    <tr><td><b>Comodity</b></td></tr>--}}
{{--                                                    <tr><td title="{{$comodity}}">{{$comodityName}}</td></tr>--}}
                                                    <tr>
                                                        <td style="padding-top: 10px;">
														<?php //if($ed->status_bc == 1){ ?>
														
                                                            <!-- <a href="{{url('/')}}/event/show_detail/{{$ed->id}}" class="btn btn-info"><i class="fa fa-eye"></i></a> 

                                                            <a onclick="return confirm('Are You Sure ?')" href="{{url('/')}}/event/delete/{{$ed->id}}" class="btn btn-danger" title="Delete">&nbsp;<i class="fa fa-trash"></i></a> -->
                                                            <!--<a href="{{url('/')}}/event/edit/{{$ed->id}}" class="btn btn-warning"><i class="fa fa-edit"></i></a>-->
                                                        <?php // }else{ ?>
								                        
														 <a onclick="ihid(<?php echo $ed->id; ?>)" data-toggle="modal" data-target="#myModal" class="btn btn-info" title="Broadcast"><font color="white"><i class="fa fa-bullhorn"></i></font></a>
														    
														<a href="{{url('/')}}/event/edit/{{$ed->id}}" class="btn btn-warning"><font color="white"><i class="fa fa-edit"></i></font></a>
														<a onclick="return confirm('Are You Sure ?')" href="{{url('/')}}/event/delete/{{$ed->id}}" class="btn btn-danger" title="Delete">&nbsp;<i class="fa fa-trash"></i></a>
                                                        
														<?php // } ?>
														</td>
                                                    </tr>
                                                </table>
                                               </div>
                                            </div>
                                        </td>
                                    @if($co==2)
                                      </tr>
                                    @endif
                                    <?php if($co == 2){ $co = 0;}else{ $co++; } ?>
                                @endif
                            @endforeach
                             <tr>
                                <td colspan="3"><br><div style="float: right;">
                                {{ $e_detail->render("pagination::bootstrap-4") }}</div></td>
                            </tr>
                            </tbody></table>
                          </div>
                        </div><br>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#2e899e; color:white;"> <h6>Broadcast Event</h6>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
		<form id="formId" action="{{ url('event/bcevent') }}" enctype="multipart/form-data" method="post">
		   {{ csrf_field() }}
        <div class="modal-body">
		
	<div class="form-row">
		<div class="col-sm-12">
		<p><center>Are you sure Broadcast this event ?</center></p>
		<input type="hidden" id="idet" name="idet">
		</div>
		
		
	</div>
         
		  
        </div>
        <div class="modal-footer">
			<button type="submit" class="btn btn-warning" ><font color="white">Broadcast</font></a>
			<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div> 
		</form>
      </div>
    </div>
  </div>


<script type="text/javascript">

function ihid(x){
	$('#idet').val(x);
}
    function ConfirmDelete()
    {
        var x = confirm("Are you sure you want to delete?");
        if (x)
            return true;
        else
            return false;
    }
    $(document).ready(function () {
        $(".alert").slideDown(300).delay(1000).slideUp(300);
        $('#tableexd').DataTable();
    });
</script>

@include('footer')