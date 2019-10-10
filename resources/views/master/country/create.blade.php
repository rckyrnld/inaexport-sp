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
                 <label class="control-label col-md-3">Group</label>
                 <div class="col-md-7">
                     <select class="form-control" required name="group" {{$view}}>
                       <option style="display: none;" value="">Select Group</option>
                        @foreach($country_group as $val)
                        <option value="{{$val->id}}" @isset($data) selected  @endisset>{{$val->group_country}}</option>
                        @endforeach
                     </select>
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Region</label>
                 <div class="col-md-7">
                     <select class="form-control" required name="region" {{$view}}>
                       <option style="display: none;" value="">Select Region</option>
                        @foreach($country_region as $val)
                        <option value="{{$val->id}}" @isset($data) selected  @endisset>{{$val->name}}</option>
                        @endforeach
                     </select>
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Kode BPS</label>
                 <div class="col-md-7">
                     <input type="text" class="form-control integer" id="kode" autocomplete="off" required name="kode_bps" placeholder="Input" {{$view}} @isset($data) value="{{ $data->kode_bps }}" @endisset>
                     <input type="hidden" id="kode2" @isset($data) value="{{ $data->kode_bps }}" @endisset>
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Country</label>
                 <div class="col-md-7">
                     <input type="text" class="form-control" name="country" autocomplete="off" required placeholder="Input" {{$view}}  @isset($data) value="{{ $data->country }}" @endisset>
                 </div>
             </div>
        
             <div class="form-group row">
                <div class="col-md-11">
                  <div align="right">
                    @if($page != 'view')
                    <button class="btn btn-primary button_form" type="submit">Save</button>
                    @endif
                    <a href="{{route('master.country.index')}}" class="btn btn-danger button_form">@if($page != 'view') Cancel @else Back @endif</a>
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
<script type="text/javascript">
  $(document).ready(function() {
    $('.integer').inputmask({
        alias:"integer",
        repeat:3,
        digitsOptional:false,
        decimalProtect:false,
        radixFocus:true,
        autoUnmask:false,
        allowMinus:false,
        rightAlign:false,
        clearMaskOnLostFocus: false,
        onBeforeMask: function (value, opts) {
            return value;
        },        removeMaskOnSubmit:true
    });

    $("#kode").focus(function(){}).blur(function(){
      var kode = $('#kode').val();
      var kode2 = $('#kode2').val();
      $.ajax({
          url: "{{route('master.country.kode')}}",
          type: 'get',
          data: {kode:kode},
          dataType: 'json',
          success:function(response){
            if(response != null) {
              if(kode2 != kode){
                alert('Kode Sudah Tersedia !');
                $('#kode').val('');
              }
            }
          }
      });
    });
  });
</script>