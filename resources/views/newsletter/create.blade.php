@include('header')
<style type="text/css">
  .button_form{width: 120px}
  input[type="text"], input[type="text"]:focus{
    border-color: #dce5e8;
  }
</style>
<?php 
  $view = '';
  if($page == 'view'){ $view = 'disabled'; }
?>
<div class="padding">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
      	 <div class="box-divider m-0"></div>
      	 <div class="box-header bg-info">
      	 	<h4 class="text-white">Form Newsletter</h4>
      	 </div>
      	 <div class="box-body">
          <div class="col-md-12">
          @if($page != 'view')
        	 {!! Form::open(['url' => $url, 'class' => 'form-horizontal', 'files' => true]) !!}
          @endif<br>
             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-2">About</label>
                 <div class="col-md-7">
                    <input type="text" class="form-control" name="about" required {{$view}} @isset($data) value="{{ $data->about }}" @endisset style="border-color: #d1d1d1;">
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-2">File Image</label>
                 <div class="col-md-7">
                  @if($page != 'view')
                    <input type="file" class="form-control" name="file" {{$view}} style="border-color: #d1d1d1;" accept="image/x-png,image/gif,image/jpeg">
                  @else
                    @if($data->file)
                    <a href="{{ url('/').'/uploads/Newsletter/File/'.$data->file}}" target="_blank" class="btn btn-outline-secondary" style="width: 40%; border-color: #d1d1d1;"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;Latest File</a>
                    @else
                    <button type="button" class="btn btn-outline-secondary" style="width: 40%; border-color: #d1d1d1;" disabled>No File</button>
                    @endif
                  @endif
                 </div>
             </div>

             @if($page == 'edit')
               @if($data->file)
               <div class="form-group row">
                <div class="col-md-1"></div>
                   <label class="control-label col-md-2"></label>
                   <div class="col-md-7">
                      <a href="{{ url('/').'/uploads/Newsletter/File/'.$data->file}}" target="_blank" class="btn btn-outline-secondary" style="width: 40%; border-color: #d1d1d1;"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;Latest File</a>
                      <input type="hidden" name="lastest_file" value="{{$data->file}}">
                   </div>
               </div>
               @endif
             @endif

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-2">Messages</label>
                 <div class="col-md-7">
                    <textarea class="form-control" id="messages" name="messages" {{$view}}>@isset($data){{ $data->messages }}@endisset</textarea>
                 </div>
             </div>
        
             <div class="form-group row">
                <div class="col-md-3"></div>
                <div class="col-md-7">
                    @if($page != 'view')
                    <button class="btn btn-primary button_form" type="submit" style="margin-right: 20px">Submit</button>
                    @endif
                    <a href="{{route('newsletter.index')}}" class="btn btn-danger button_form">@if($page != 'view') Cancel @else Back @endif</a>
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
<script type="text/javascript">
  $(document).ready(function () {
    CKEDITOR.replace('messages');
    @isset($data)
      @if($data->status == 1)
        $('input').prop('disabled', true);
        $('.btn[type="submit"]').prop('disabled', true);
      @endif
    @endisset

    $("textarea").each(function () {
      this.style.height = (this.scrollHeight+10)+'px';
    });
    $('.select2').select2({
      placeholder: 'Select Country'
    });
  });
</script>