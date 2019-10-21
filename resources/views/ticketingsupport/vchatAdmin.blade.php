
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
	          <h4>Form Ticketing</h4><hr>
	          <div class="row">
	            <div class="col-md-2">
	              <b>Full Name</b>
	            </div>
	            <div class="col-md-4">
								: {{$users->name}}
	            </div>
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
            <form class="" action="{{url('admin/ticketing/sendchat')}}" method="post">
              <div class="row">
                <div class="col-md-12">
                  <div class="box">
                    <br>
                    <div class="row overflow-auto">
                      @foreach($messages as $msg)
                      @if($msg->sender == 0)
                      <div class="col-md-1"></div>
                      <div class="col-md-10">
                        <div class="row pull-right">
                          <div class="col-md-10">
                            <label class="label" style="background:orange; border-radius:10px; width:300px ">
                            &nbsp;&nbsp<b>You</b> :
                            &nbsp;&nbsp{{$msg->messages}}<br>
                            &nbsp;&nbsp<i>{{$msg->messages_send}}</i>
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
                            <label class="label" style="background:aqua; border-radius:10px; width:300px">
                            &nbsp;&nbsp<b>{{$msg->name}}</b> :
                            &nbsp;&nbsp{{$msg->messages}}<br>
                            &nbsp;&nbsp<i>{{$msg->messages_send}}</i>
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
                        <input type="text" class="form-control" name="messages" value="" autocomplete="off">
                      </div>
                      <div class="col-md-2 pull-right">
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
<script>
  $(document).ready(function() {
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
