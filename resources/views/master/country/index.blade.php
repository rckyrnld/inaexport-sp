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
          <a id="tambah" href="{{route('master.country.create')}}" class="md-btn md-raised mb-2 w-sm info"><i class="fa fa-plus-circle"></i>  Add</a>&nbsp;&nbsp;<a id="tambah" href="{{route('master.country.export')}}" class="md-btn md-raised mb-2 w-sm info" target="_blank"><i class="fa fa-print"></i>  Export</a>
      	 </div>
      	  <div class="box-body">
          	 <div class="table-responsive">
			    <table id="table" class="table  table-bordered table-striped" data-plugin="dataTable">
			      <thead class="bg-success text-white">
			          <tr>
			              <th>Kode BPS</th>
			              <th>Country</th>
			              <th>Group</th>
			              <th width="20%">Action</th>
			          </tr>
			      </thead>
			      <tbody>
			      	@foreach($country as $no => $data)
			      		<tr>
			      			<td>{{$data->kode_bps}}</td>
			      			<td>{{$data->country}}</td>
			      			<td>{{$data->group_country}}</td>
			      			<td style="text-align: center;">
			      				<div class="btn-group">
			      				<a href="{{route('master.country.edit', $data->id)}}" class="btn btn-sm btn-info">&nbsp;&nbsp;<i class="fa fa-edit text-white"></i>&nbsp;&nbsp;</a>
			      				<a onclick="return confirm('Apa Anda Yakin untuk Menghapus Provinsi Ini ?')" href="{{route('master.country.destroy', $data->id)}}" class="btn btn-sm btn-danger">&nbsp;&nbsp;<i class="fa fa-trash text-white"></i>&nbsp;&nbsp;</a>
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