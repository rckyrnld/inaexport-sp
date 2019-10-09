@include('header')
<style type="text/css">
  .button_form{width: 80px}
</style>
<?php 
  if($page == 'view'){
    $view = 'disabled';
  } else {
    $view = '';
  }
?>
<div class="padding">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
      	 <div class="box-divider m-0"></div>
      	 <div class="box-header bg-info">
      	 	<h4 class="text-white">Form </h4>
      	 </div>
      	 <div class="box-body">
          <div class="col-md-12">
          @if($page != 'view')
        	 {!! Form::open(['url' => $url, 'class' => 'form-horizontal', 'files' => true]) !!}
          @endif
             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Province</label>
                 <div class="col-md-7">
                     <select class="form-control" required name="province" {{$view}}>
                       <option style="display: none;" value="">Select Province</option>
                       @foreach($province as $val)
                       <option value="{{$val->id}}" @isset($data) @if($data->id_mst_province == $val->id) selected @endif  @endisset>{{$val->province_en}}</option>
                       @endforeach
                     </select>
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Port</label>
                 <div class="col-md-7">
                     <input type="text" class="form-control" name="port" autocomplete="off" required placeholder="Input" {{$view}}  @isset($data) value="{{ $data->name_port }}" @endisset>
                 </div>
             </div>
        
             <div class="form-group row">
                <div class="col-md-11">
                  <div align="right">
                    @if($page != 'view')
                    <button class="btn btn-primary button_form" type="submit">Save</button>
                    @endif
                    <a href="{{route('master.port.index')}}" class="btn btn-danger button_form">@if($page != 'view') Cancel @else Back @endif</a>
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