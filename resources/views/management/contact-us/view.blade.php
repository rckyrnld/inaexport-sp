@include('header')
<style type="text/css">
  .button_form{width: 80px}
</style>
<div class="padding">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
      	 <div class="box-divider m-0"></div>
      	 <div class="box-header bg-info">
      	 	<h4 class="text-white">Message</h4>
      	 </div>
      	 <div class="box-body">
          <div class="col-md-12">
          <br>
             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Full Name</label>
                 <div class="col-md-7">
                     <input type="text" id="id" class="form-control integer" name="name" autocomplete="off" required placeholder="Input" disabled value="{{ $data->fullname }}">
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Email</label>
                 <div class="col-md-7">
                     <input type="email" class="form-control" name="email" autocomplete="off" required placeholder="Input" disabled value="{{ $data->email }}">
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Subject</label>
                 <div class="col-md-7">
                     <input type="text" class="form-control" name="subyek" autocomplete="off" required placeholder="Input" disabled value="{{ $data->subyek }}">
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Messages</label>
                 <div class="col-md-7">
                     <textarea class="form-control" name="message" rows="16" disabled/>{{ $data->message }}</textarea>
                 </div>
             </div>
        
             <div class="form-group row">
                <div class="col-md-11">
                  <div align="right">
                    <a href="{{route('management.contact-us.index')}}" class="btn btn-danger button_form">Back</a>
                  </div>
                </div>
             </div>
          </div>
      	 </div>
      </div>
     </div>
  </div>
</div>

@include('footer')