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
          @endif<br>
             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">ID</label>
                 <div class="col-md-7">
                     <input type="text" id="id" class="form-control integer" name="kode_province" autocomplete="off" required placeholder="Input" {{$view}}  @isset($data) value="{{ $data->id }}" @endisset>
                     <input type="hidden" id="kode" @isset($data) value="{{ $data->id }}" @endisset>
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Province (EN)</label>
                 <div class="col-md-7">
                     <input type="text" class="form-control" name="province_en" autocomplete="off" required placeholder="Input" {{$view}}  @isset($data) value="{{ $data->province_en }}" @endisset>
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Province (IN)</label>
                 <div class="col-md-7">
                     <input type="text" class="form-control" name="province_in" autocomplete="off" required placeholder="Input" {{$view}}  @isset($data) value="{{ $data->province_in }}" @endisset>
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Province (CHN)</label>
                 <div class="col-md-7">
                     <input type="text" class="form-control" name="province_chn" autocomplete="off" placeholder="Input" {{$view}}  @isset($data) value="{{ $data->province_chn }}" @endisset>
                 </div>
             </div>
        
             <div class="form-group row">
                <div class="col-md-11">
                  <div align="right">
                    @if($page != 'view')
                    <button class="btn btn-primary button_form" type="submit">Save</button>
                    @endif
                    <a href="{{route('master.province.index')}}" class="btn btn-danger button_form">@if($page != 'view') Cancel @else Back @endif</a>
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
        repeat:2,
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

    $("#id").focus(function(){}).blur(function(){
      var kode = $('#id').val();
      var kode2 = $('#kode').val();
      $.ajax({
            url: "{{route('master.province.kode')}}",
            type: 'get',
            data: {kode:kode},
            dataType: 'json',
            success:function(response){
              if(response != null) {
                if(kode2 != kode){
                  alert('ID have been used in other Province !');
                  $('#id').val('');
                }
              }
            }
        });
    });
  });
</script>