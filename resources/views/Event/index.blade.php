@include('header')
<style type="text/css">
    .thumbnail{ text-align: center; }
    p{ line-height: 5px; }
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
        margin: 2cm;
    }
</style>
<section class="content container-fluid">
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i>Event</h5>
                </div>

                <div class="box-body bg-light">
                    <a class="btn" href="{{url('event/create')}}"
                       style="background-color: #1089ff; color: white;"><i class="fa fa-plus-circle"></i>&nbsp; Add</a>
                    <div class="col-md-3" style="float: right;">
                        <form action="{{url('')}}/event/search" method="POST" role="search">
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
                                            <div class="box" style="width: 7cm;height: 7.5cm;margin: 5px;border-radius: 25px;">
                                                <div class="thumbnail">
                                                    <div style="float: left;margin-top: 10px;margin-left: 5px;">
                                                        <a href="{{url('/')}}/event/show_company/{{$ed->id}}"><img src="{{url('/')}}/image/event/show.png" class="icon_"></a> 
                                                    </div>
                                                    <div class="imge">
                                                        @if($ed->image_1 !== NULL)
                                                            <?php $topZ='margin-top: -100px;';?>
                                                            <img src="{{url('/')}}/uploads/Event/Image/{{$ed->id}}/{{$ed->image_1}}" class="centerZ">
                                                        @else
                                                            <?php $topZ='margin-top: -145px;';?>
                                                            <img src="{{url('/')}}/image/event/NoPicture.png" alt="No Picture">
                                                        @endif
                                                    </div>
                                                    <div style="float: right;margin-right: 5px;{{$topZ}}">
                                                        <a href="{{url('/')}}/event/delete/{{$ed->id}}"><img src="{{url('/')}}/image/event/hapus.png" class="icon_"></a><br>
                                                        <a href="{{url('/')}}/event/edit/{{$ed->id}}"><img src="{{url('/')}}/image/event/edit.png" class="icon_"></a><br>
                                                        @if($ed->status_en == 'Verified') 
                                                            <img src="{{url('/')}}/image/event/ceklis.png" class="icon_">
                                                        @endif 
                                                    </div>   
                                               </div>
                                               <table style="margin-left:28px;" class="tbl_">
                                                    <tr><td>{{$ed->event_name_en}}</td></tr>
                                                    <tr><td><b>Start Date - End Date</b></td></tr>
                                                    <tr><td>{{getTanggalIndo($ed->start_date)}} - {{getTanggalIndo($ed->end_date)}}</td></tr>
                                                    <tr><td><b>Comodity</b></td></tr>
                                                    <tr><td>{{getEventComodity($ed->event_comodity)}}</td></tr>
                                                </table>
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
</section>
<script type="text/javascript">
    $(document).ready(function () {
        $('#tableexd').DataTable();
        $(".tbl_")
    });
</script>

@include('footer')