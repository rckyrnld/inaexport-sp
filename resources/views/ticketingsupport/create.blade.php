
@include('header')
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
				<form class="" action="{{route('ticket_support.store')}}" method="post">
					<div class="box-body bg-light">
	          <h4>Ticketing Support</h4><hr>
	          <div class="row">
	            <div class="col-md-2">
	              Full Name
	            </div>
	            <div class="col-md-4">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
	              <input type="text" autocomplete="off" class="form-control" name="name" value=""required>
	            </div>
	          </div><br>
	          <div class="row">
	            <div class="col-md-2">
	              E-Mail
	            </div>
	            <div class="col-md-4">
	              <input type="text" autocomplete="off" class="form-control" name="email" value=""required>
	            </div>
	          </div><br>
	          <div class="row">
	            <div class="col-md-2">
	              Subject
	            </div>
	            <div class="col-md-4">
	              <input type="text" autocomplete="off" class="form-control" name="subject" value=""required>
	            </div>
	          </div><br>
	          <div class="row">
	            <div class="col-md-2">
	              Messages
	            </div>
	            <div class="col-md-4">
	              <textarea name="messages" class="form-control" rows="8" cols="80"></textarea>
	            </div>
	          </div><br>
	          <div class="row">
	            <div class="col-md-2">
	            </div>
	            <div class="col-md-4">
	              <button type="submit" class="btn btn-primary" name="button">Submit </button>
	            </div>
	          </div>
	        </div>
				</form>
      </div>
    </div>
  </div>
</div>
@include('footer')
