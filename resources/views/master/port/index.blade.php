@include('header')
<style type="text/css">
	th {text-align: center;}
	td {color: black;}
	#tambah { background-color: #1a9cf9; color: white; white-space: pre;}
	#tambah:hover {background-color: #148de4}
	#export { background-color: #28bd4a; color: white; white-space: pre;}
	#export:hover {background-color: #08b32e}
</style>
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> Data Port</h5>
                </div>

                <div class="box-body bg-light">
                	<a id="tambah" href="{{route('master.port.create')}}" class="btn">   <i class="fa fa-plus-circle"></i>  Add   </a>&nbsp;&nbsp;<a id="export" href="{{route('master.port.export')}}" class="btn" target="_blank"><i class="fa fa-print"></i>  Export </a>

                    <div class="col-md-14"><br>
		          	 <div class="table-responsive">
					    <table id="table" class="table  table-bordered table-striped" data-plugin="dataTable">
					      <thead class="text-white" style="background-color: #1089ff;">
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
					      				<a href="{{route('master.port.view', $data->id)}}" class="btn btn-sm btn-info">&nbsp;<i class="fa fa-search text-white"></i>&nbsp;View&nbsp;</a>&nbsp;&nbsp;
					      				<a href="{{route('master.port.edit', $data->id)}}" class="btn btn-sm btn-success">&nbsp;<i class="fa fa-edit text-white"></i>&nbsp;Edit&nbsp;</a>&nbsp;&nbsp;
					      				<a onclick="return confirm('Apa Anda Yakin untuk Menghapus Port Ini ?')" href="{{route('master.port.destroy', $data->id)}}" class="btn btn-sm btn-danger">&nbsp;<i class="fa fa-trash text-white"></i>&nbsp;Delete&nbsp;</a>
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
</div>
@include('footer')
<script type="text/javascript">
	$(document).ready(function() {
		$('#table').dataTable({
			"order": [[ 1, "asc" ]]
		});
	});
</script>