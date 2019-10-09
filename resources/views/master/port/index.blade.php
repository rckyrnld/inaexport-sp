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
          <a id="tambah" href="{{route('master.port.create', '')}}" class="md-btn md-raised mb-2 w-sm info"><i class="fa fa-plus-circle"></i>  Add</a>
      	 </div>
      	  <div class="box-body">
          	 <div class="table-responsive">
			    <table id="example1" class="table  table-bordered table-striped" data-plugin="dataTable">
			      <thead class="bg-info text-white">
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
			      				<a href="{{route('master.port.view', $data->id)}}" class="btn btn-sm btn-info">&nbsp;&nbsp;View&nbsp;&nbsp;</a>&nbsp;&nbsp;
			      				<a href="{{route('master.port.edit', $data->id)}}" class="btn btn-sm btn-danger">&nbsp;&nbsp;Edit&nbsp;&nbsp;</a>
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