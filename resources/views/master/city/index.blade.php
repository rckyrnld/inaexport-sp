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
                    <h5><i></i> Data City</h5>
                </div>

                <div class="box-body bg-light">
                	<a id="tambah" href="{{route('master.city.create')}}" class="btn">   <i class="fa fa-plus-circle"></i>  Add   </a>&nbsp;&nbsp;<a id="export" href="{{route('master.city.export')}}" class="btn" target="_blank"><i class="fa fa-print"></i>  Export </a>

                    <div class="col-md-14"><br>
		          	 <div class="table-responsive">
					    <table id="example1" class="table  table-bordered table-striped" data-plugin="dataTable">
					      <thead class="text-white" style="background-color: #1089ff;">
					          <tr>
					              <th>Country</th>
					              <th>City</th>
					              <th width="20%">Action</th>
					          </tr>
					      </thead>
					      <tbody>
					      	@foreach($city as $no => $data)
					      		<tr>
					      			<td>{{$data->country}}</td>
					      			<td>{{$data->city}}</td>
					      			<td style="text-align: center;">
					      				<div class="btn-group">
					      				<a href="{{route('master.city.view', $data->id)}}" class="btn btn-sm btn-info">&nbsp;<i class="fa fa-search text-white"></i>&nbsp;View&nbsp;</a>&nbsp;&nbsp;
					      				<a href="{{route('master.city.edit', $data->id)}}" class="btn btn-sm btn-success">&nbsp;<i class="fa fa-edit text-white"></i>&nbsp;Edit&nbsp;</a>&nbsp;&nbsp;
					      				<a onclick="return confirm('Apa Anda Yakin untuk Menghapus Kota Ini ?')" href="{{route('master.city.destroy', $data->id)}}" class="btn btn-sm btn-danger">&nbsp;<i class="fa fa-trash text-white"></i>&nbsp;Delete&nbsp;</a>
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