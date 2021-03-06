
@include('header')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<style type="text/css">
	th {text-align: center;}
	td {color: black;}
	#tambah { background-color: #1a9cf9; color: white; white-space: pre;}
	#tambah:hover {background-color: #148de4}
	#export { background-color: #28bd4a; color: white; white-space: pre;}
	#export:hover {background-color: #08b32e}
  button.closedmodal {
    padding: 0;
    background-color: transparent;
    border: 0;
    -webkit-appearance: none;
  }
  .closedmodal {
    float: right;
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1;
    color: #000;
    text-shadow: 0 1px 0 #fff;
    opacity: .5;
  }
  .modal-header .closedmodal {
      padding: 1rem;
      margin: -1rem -1rem -1rem auto;
  }
  .closedmodal:hover{
    color: #fff;
  }
</style>
<div class="padding">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-divider m-0"></div>
        <div class="box-header bg-light">
          <!-- Header Title -->
        </div>
					<div class="box-body bg-light">
	          <table width="100%">
              <tr>
                <td><div style="color: #465a6ed9;" align="left"><h4>Form Customer Support</h4></div></td>
                <td><div align="right"><a href="{{url('admin/ticketing')}}" style="width: 80px;" class="btn btn-danger"> Back</a></div></td>
              </tr>
            </table>
            <hr>
	          <div class="row">
	            <div class="col-md-2">
	              <b>Full Name</b>
	            </div>
	            <div class="col-md-4">
								: {{$users->name}}
              </div>
              @if(!checkticketingcreator($users->id))
                  <div class="col-md-2 offset-md-2">
                      <a onclick="return confirm('Are You Sure ?')" href="{{route('ticket_support.delete.admin', $users->id)}}" id="button" class="btn btn-sm btn-danger" title="Delete">Delete</a>
                            
                      <!-- <a href="{{url('admin/ticketing')}}" style="width: 80px;" class="btn btn-danger"> Delete</a> -->
                  </div>
            @endif
	          </div><br>
	          <div class="row">
	            <div class="col-md-2">
	              <b>E-Mail</b>
	            </div>
	            <div class="col-md-4">
	              : {{$users->email}}
	            </div>
	          </div><br>
	          <div class="row">
	            <div class="col-md-2">
	              <b>Subject</b>
	            </div>
	            <div class="col-md-4">
	              : {{$users->subyek}}
	            </div>
	          </div><br>
            <div class="row">
	            <div class="col-md-2">
	              <b>Messages</b>
				  
	            </div>
	            <div class="col-md-4">
	              : {{$users->main_messages}}
	            </div>
	          </div><br>
			  <div class="row">
	            <div class="col-md-2">
	              <b>Create By</b>
				  
	            </div>
	            <div class="col-md-4">
	              : <?php $ip = $users->id_pembuat; 
				  $cari1 = DB::select("select * from itdp_company_users where id='".$ip."' limit 1");
				  foreach($cari1 as $cr1){ echo $cr1->username; ?> 
				  @if(Cache::has('user-is-eksmp-' . $cr1->id))
              (<span class="text-success">Online</span>)
          @else
              (<span class="text-secondary">Offline</span>)
          @endif
				  <?php }
				  ?>
	            </div>
	          </div>
			  
			  <br>
            <form class="" action="{{url('admin/ticketing/sendchat')}}" method="post">
              <div class="row">
                <div class="col-md-12">
                  <div class="box">
                    <br>
                    
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block" style="text-align: center">
                            <button type="button" class="close" data-dismiss="alert">??</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <div class="row overflow-auto">
                      <?php $datenya = null; ?>
                      @foreach($messages as $msg)
                      @if($datenya != date('Y-m-d', strtotime($msg->messages_send)))
                        <div class="col-md-12">
                          <center><i>{{date('F d,Y', strtotime($msg->messages_send))}}</i></center>
                        </div>
                      @endif
                      <?php $datenya = date('Y-m-d', strtotime($msg->messages_send)); ?>
                      @if($msg->sender == 0)
                      <div class="col-md-1"></div>
                      <div class="col-md-10">
                        <div class="row pull-right">
                          <div class="col-md-10">
                            <label class="label" style="background:orange; border-radius:10px; width:300px; padding: 0px 10px 0px 10px; ">
                            <b>You</b> :
                            @if($msg->file == NULL)
                                {{$msg->messages}}
                            @else
                                @if($msg->messages != null)
                                {{$msg->messages}}<br><br>
                                @endif
                                <a href="{{ url('/').'/uploads/ticketing' }}/{{ $msg->file }}" target="_blank" class="atag" style="color: red; font-weight: 600;"><?php echo wordwrap($msg->file, 35, "<br \>", true);?></a><br>
                            @endif
                            <div align="right">{{date('H:i', strtotime($msg->messages_send))}}</div>
                            </label>
                          </div>
                        </div>
                      </div><br>
                      <div class="col-md-1"></div>
                      @else
                      <div class="col-md-1"></div>
                      <div class="col-md-10">
                        <div class="row">
                          <div class="col-md-10">
                            <label class="label" style="background:aqua; border-radius:10px; width:300px; padding: 0px 10px 0px 10px; ">
                            <b><?php $ip = $users->id_pembuat; 
                  				  $cari1 = DB::select("select * from itdp_company_users where id='".$ip."' limit 1");
                  				  foreach($cari1 as $cr1){ echo $cr1->username; ?> 
                  				  @if(Cache::has('user-is-eksmp-' . $cr1->id))
                                (<span class="text-success">Online</span>)
                            @else
                                (<span class="text-secondary">Offline</span>)
                            @endif
                  				  <?php }?> </b> :
                            @if($msg->file == NULL)
                                {{$msg->messages}}
                            @else
                                @if($msg->messages != null)
                                {{$msg->messages}}<br><br>
                                @endif
                                <a href="{{ url('/').'/uploads/ticketing' }}/{{ $msg->file }}" target="_blank" class="atag" style="color: red; font-weight: 600;"><?php echo wordwrap($msg->file, 35, "<br \>", true);?></a><br>
                            @endif
                            <div align="left">{{date('H:i', strtotime($msg->messages_send))}}</div>
                            </label>
                          </div>
                        </div>
                      </div><br>
                      <div class="col-md-1"></div>
                      @endif
                      @endforeach
                    </div><br>
										@if($jenis == 'chat')
										@if($users->status != 3 )
                    <div class="row">
                      <div class="col-md-1"></div>
                      <div class="col-md-8">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="sender" value="0">
                        <input type="hidden" name="id" value="{{$users->id}}">
                        <input type="hidden" name="reciver" value="{{$users->id_pembuat}}">
                        <div class="input-group">
                          <button type="button" id="uploading2" class="btn" style="background-color: #a3a4abee; border-radius: 5px 0px 0px 5px; color: white; width: 7%;"><i class="fa fa-paperclip"></i></button>
                          <input type="text" class="form-control" name="messages" value="" autocomplete="off">
                        </div>
                      </div>
                      <div class="col-md-2">
                        <button type="submit" name="button" class="btn btn-primary"><span class="fa fa-send"></span> Send Messages</button>
                      </div>
                    </div><br>
										</form>
                    <div class="row">
                      <div class="col-md-1"></div>
                      <div class="col-md-2">
                        <b>Status</b>
                      </div>
											<form id="formchange" action="{{url('admin/ticketing/change/')}}" method="post">
                      	<div class="col-md-4">
													<input type="hidden" name="_token" value="{{ csrf_token() }}">
													<input type="hidden" name="id" value="{{$users->id}}">
                        	<input type="checkbox" id="toggle-two" checked>
                      	</div>
											</form>
                    </div><br>
										@endif
										@endif
                  </div>
                </div>
              </div>
          </div>
      </div>
    </div>
  </div>
</div>

@if($jenis == 'chat')
  @if($users->status != 3 )
<div class="modal fade" id="modalFile" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#b3d4ef; color:#1a3750; font-weight: 600; font-size: 18px;"> Upload File
                <button type="button" class="closedmodal" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{url('admin/ticketing/sendFilechat')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-sm-3">
                            <label><b>File Upload</b></label>
                        </div>
                        <div class="form-group col-sm-7">
                            <input type="file" id="upload_file2" name="upload_file2" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-3">
                            <label><b>Note</b></label>
                        </div>
                        <div class="form-group col-sm-7">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="sender" value="0">
                            <input type="hidden" name="id" value="{{$users->id}}">
                            <input type="hidden" name="reciver" value="{{$users->id_pembuat}}">
                            <textarea class="form-control" name="messages" id="msgfile2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><font color="white">Upload</font></button>
                    <button type="button" class="btn btn-default" style="background-color: #efefef;" data-dismiss="modal">Close</button>
                </div> 
            </form>
        </div>
    </div>
</div>
  @endif
@endif
<script>
  $(document).ready(function() {
    $("#uploading2").click(function() {
      $('#modalFile').modal('show');
    });
    $('#toggle-two').bootstrapToggle({
      on: 'OPEN',
      off: 'CLOSED'
    });
		$("#toggle-two").on( "change", function(evt) {
		 if($(this).prop("checked")) {

		  } else{
				$("#formchange").submit();
		  }
		});
  });

</script>
@include('footer')
