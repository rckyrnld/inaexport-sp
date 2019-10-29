@include('header')
<style type="text/css">
  .button_form{width: 80px}
</style>
<?php 
  if($page == 'view'){
    $view = 'disabled';
    if(substr_count( $data->message, "\n" ) > 2){
      $height = 22 * ( substr_count( $data->message, "\n" ) + 1 );
    } else {
      $height = 50;
    }
  } else {
    $view = '';
    $height = 50;
  }
?>
<div class="padding">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
      	 <div class="box-divider m-0"></div>
      	 <div class="box-header bg-info">
      	 	<h4 class="text-white">Message
          <a href="{{route('management.contact-us.index')}}" style="float: right;" class="btn btn-danger button_form"> Back</a><br><br></h4> </h4>
      	 </div>
      	 <div class="box-body">
          <div class="col-md-12">
          @if($page != 'view')
        	 {!! Form::open(['url' => $url, 'class' => 'form-horizontal', 'files' => true]) !!}
          @endif<br>
             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Full Name</label>
                 <div class="col-md-7">
                     <input type="text" id="id" class="form-control integer" name="name" autocomplete="off" required placeholder="Input" {{$view}}  @isset($data) value="{{ $data->fullname }}" @endisset>
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Email</label>
                 <div class="col-md-7">
                     <input type="email" class="form-control" name="email" autocomplete="off" required placeholder="Input" {{$view}}  @isset($data) value="{{ $data->email }}" @endisset>
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Subyek</label>
                 <div class="col-md-7">
                     <input type="text" class="form-control" name="subyek" autocomplete="off" required placeholder="Input" {{$view}}  @isset($data) value="{{ $data->subyek }}" @endisset>
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Messages</label>
                 <div class="col-md-7">
                     <textarea class="form-control" name="message" style="height: {{$height}}px" {{$view}}>@isset($data){{ $data->message }}@endisset</textarea>
                 </div>
             </div>
        
             <div class="form-group row">
                <div class="col-md-11">
                  <div align="right">
                    @if($page != 'view')
                    <button class="btn btn-primary button_form" type="submit">Submit</button>
                    <a href="{{route('management.contact-us.index')}}" class="btn btn-danger button_form">@if($page != 'view') Cancel @else Back @endif</a>
                    @endif
                  </div>
                </div>
             </div>
          @if($page != 'view')
            {!! Form::close() !!}
          @endif
          </div>
      	 </div>
      </div>
     </div>
  </div>
</div>

@include('footer')