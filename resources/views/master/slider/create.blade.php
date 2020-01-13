@include('header')
<style type="text/css">
  .button_form{width: 80px}
  input[type="text"], input[type="text"]:focus{
    border-color: #d6d9daad;
  }
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
          <form class="form-horizontal" method="POST" action="{{ url('save-slider') }}" enctype="multipart/form-data">
           {{ csrf_field() }}<br>
             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">File Image</label>
                 <div class="col-md-7">
                     <input type="file" class="form-control" id="file_img" name="file_img" required>
                    
                 </div>
             </div> 
			 
			 <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Note</label>
                 <div class="col-md-7">
                     <textarea class="form-control" id="keterangan" name="keterangan" required></textarea>
                    
                 </div>
             </div>
			 
			 <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Publish</label>
                 <div class="col-md-2">
                     <select class="form-control" name="publish" id="publish">
						<option value="1">Yes</option>
						<option value="0">No</option>
					 </select>
                    
                 </div>
             </div>

             

             
        
             <div class="form-group row">
                <div class="col-md-11">
                  <div align="right">
                    @if($page != 'view')
                    <button class="btn btn-primary button_form" type="submit">Save</button>
                    @endif
                    <a href="{{url('master-slide')}}" class="btn btn-danger button_form">@if($page != 'view') Cancel @else Back @endif</a>
                  </div>
                </div>
             </div>
          </form>
          </div>
      	 </div>
      </div>
     </div>
  </div>
</div>

@include('footer')
<script type="text/javascript">
  $(document).ready(function () {

    $('.select2').select2({
      placeholder: 'Select Province'
    });

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

    $("#kode_port").focus(function(){}).blur(function(){
      var kode = $('#kode_port').val();
      var kode2 = $('#kode2').val();
      $.ajax({
          url: "{{route('master.port.kode')}}",
          type: 'get',
          data: {kode:kode},
          dataType: 'json',
          success:function(response){
            if(response != null) {
              if(kode2 != kode){
                alert('ID have been used in other Port !');
                $('#kode_port').val('');
              }
            }
          }
      });
    });

  });
</script>