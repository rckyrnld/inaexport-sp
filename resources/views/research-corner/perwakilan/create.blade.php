@include('header')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<style type="text/css">
  .button_form{width: 80px}
  input:read-only{ background-color:white !important}
  input:disabled{ background-color:white !important}
</style>
<?php 
  if($page == 'view'){
    $view = 'disabled';
    $id = $data->id;
  } else {
    $id = '';
    $view = '';
  }
?>
<div class="padding">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
      	 <div class="box-divider m-0"></div>
      	 <div class="box-header bg-info">
      	 	<h4 class="text-white">@if($page == 'view') View @else Form @endif Research Corner
          @if($page == 'view')<a href="{{route('perwakilan.research-corner.index')}}" style="float: right;" class="btn btn-danger button_form"> Back</a><br><br>@endif</h4>
         </div>
      	 <div class="box-body">
          <div class="col-md-12">
          @if($page != 'view')
        	 {!! Form::open(['url' => $url, 'class' => 'form-horizontal', 'files' => true, 'id' => 'form']) !!}
          @endif<br>
             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Title (EN)</label>
                 <div class="col-md-7">
                     <input type="text" class="form-control" name="title_en" autocomplete="off" required placeholder="Input" {{$view}}  @isset($data) value="{{ $data->title_en }}" @endisset>
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Title (IN)</label>
                 <div class="col-md-7">
                     <input type="text" class="form-control" name="title_in" autocomplete="off" required placeholder="Input" {{$view}}  @isset($data) value="{{ $data->title_in }}" @endisset>
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Type</label>
                 <div class="col-md-7">
                  @if($page == 'view')
                    <input type="text" class="form-control" readonly value="{{rc_type($data->id_csc_research_type, 'en')}}">
                  @else
                     <select class="form-control" id="type" required name="type" {{$view}}>
                       <option></option>
                       @foreach($type as $val)
                       <option value="{{$val->id}}" @isset($data) @if($data->id_csc_research_type == $val->id) selected @endif @endisset>{{$val->nama_en}}</option>
                       @endforeach
                     </select>
                  @endif
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Country</label>
                 <div class="col-md-7">
                  @if($page == 'view')
                    <input type="text" class="form-control" readonly value="{{rc_country($data->id_mst_country)}}">
                  @else
                     <select class="form-control" id="country" required name="country" {{$view}}>
                      <option></option>
                       @foreach($country as $val)
                       <option value="{{$val->id}}" @isset($data) @if($data->id_mst_country == $val->id) selected @endif @endisset>{{$val->country}}</option>
                       @endforeach
                     </select>
                  @endif
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">HS Code</label>
                 <div class="col-md-7">
                  @if($page == 'view')
                    <input type="text" class="form-control" readonly value="{{rc_hscodes($data->id_mst_hscodes)}}">
                  @else
                     <select class="form-control" id="code" required name="code" {{$view}}>
                       <option></option>
                       @foreach($hscode as $val)
                       <option value="{{$val->id}}" @isset($data) @if($data->id_mst_hscodes == $val->id) selected @endif @endisset>{{$val->desc_eng}}</option>
                       @endforeach
                     </select>
                  @endif
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Publish Date</label>
                 <div class="col-md-7">
                     <input type="text" class="form-control" id="date" name="date" placeholder="Date Time" autocomplete="off" {{$view}}  @isset($data) value="{{ $data->publish_date }}" @endisset>
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">File</label>
                 <div class="col-md-7">
                    @if($page != 'view')
                     <input type="file" class="form-control" name="file" autocomplete="off" placeholder="Input" {{$view}} @if($page == 'create') required @endif>
                     <input type="hidden" name="lastest_file" @isset($data) value="{{ $data->exum }}" @endisset>
                    @else 
                      <a href="{{ url('/').'/uploads/Research Corner/File/'.$data->exum}}" target="_blank" class="btn btn-outline-secondary" style="width: 30%"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;Document</a>
                    @endif
                 </div>
             </div>

            @if($page == 'view')
            <br>
              <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                  <table id="table" class="table  table-bordered table-striped" data-plugin="dataTable">
                    <thead class="text-white" style="background-color: #1089ff;">
                      <tr>
                        <th width="8%">No</th>
                        <th>Company / Eksportir</th>
                        <th>Download Date</th>
                      </tr>
                    </thead>
                  </table>
                </div>
                <div class="col-md-1"></div>
              </div>
            @endif
        
          @if($page != 'view')
             <div class="form-group row">
                <div class="col-md-11">
                  <div align="right">
                    <a href="{{route('perwakilan.research-corner.index')}}" class="btn btn-danger button_form">@if($page != 'view') Cancel @else Back @endif</a>
                    @if($page != 'view')
                    <button class="btn btn-primary button_form" type="submit">Save</button>
                    @endif
                  </div>
                </div>
             </div>
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
    var page = "{{$page}}";
    
    if(page == 'view'){
      $('#table').dataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('perwakilan.research-corner.getDataDownload', $id)}}",
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'company', name: 'company'},
              {data: 'download_date', name: 'download_date'}
          ]
      });
    }

    $("#date").flatpickr({
      altInput: true,
      altFormat: "j F Y  ( H:i )",
      dateFormat: "Y-m-d H:i:ss",
      enableTime: true,
    });

    $('#type').select2({
      placeholder: 'Select Type'
    });

    $('#country').select2({
      placeholder: 'Select Country'
    });

    $('#code').select2({
      placeholder: 'Select Code'
    });
  });
</script>