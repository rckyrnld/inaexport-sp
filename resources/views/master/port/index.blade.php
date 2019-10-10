@include('header')
<style type="text/css">
	th {text-align: center;}
	td {color: black;}
	#tambah { margin-top: 10px; white-space: pre; text-transform: none;}
</style>
<div class="padding">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
      	 <div class="box-divider m-0"></div>
      	 <div class="box-header bg-info">
          <a id="tambah" href="{{route('master.port.create')}}" class="md-btn md-raised mb-2 w-sm info"><i class="fa fa-plus-circle"></i>  Add</a>&nbsp;&nbsp;<a id="tambah" href="{{route('master.port.export')}}" class="md-btn md-raised mb-2 w-sm info" target="_blank"><i class="fa fa-print"></i>  Export</a>
      	 </div>
      	  <div class="box-body">
          	 <div class="table-responsive">
			    <table id="table" class="table  table-bordered table-striped" data-plugin="dataTable">
			      <thead class="bg-success text-white">
			          <tr>
			              <th>Port</th>
			              <th>Province</th>
			              <th width="20%">Action</th>
			          </tr>
			      </thead>
			      <tbody>
			      	@foreach($port as $no => $data)
			      		<tr>
			      			<td>{{$data->name_port}}</td>
			      			<td>{{$data->province_en}}</td>
			      			<td style="text-align: center;">
			      				<div class="btn-group">
			      				<a href="{{route('master.port.edit', $data->id)}}" class="btn btn-sm btn-info">&nbsp;&nbsp;<i class="fa fa-edit text-white"></i>&nbsp;&nbsp;</a>
			      				<a onclick="return confirm('Apa Anda Yakin untuk Menghapus Provinsi Ini ?')" href="{{route('master.port.destroy', $data->id)}}" class="btn btn-sm btn-danger">&nbsp;&nbsp;<i class="fa fa-trash text-white"></i>&nbsp;&nbsp;</a>
			      			    </div>
			      			</td>
			      		</tr>
			      	@endforeach
			      </tbody>
			    </table>
			  </div>
      	  </div>
      </div>
    </div>
  </div>
</div>
@include('footer')
<script type="text/javascript">
	$(document).ready(function() {
		$('#table').dataTable({
			"order": [[ 1, "asc" ]]
		});
	});
</script>