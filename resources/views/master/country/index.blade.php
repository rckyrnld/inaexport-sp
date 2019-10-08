@include('header')
<style type="text/css">
	th {text-align: center;}
	td {color: black;}
</style>
<div class="padding">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
      	 <div class="box-divider m-0"></div>
      	 <div class="box-header bg-info">
          <a href="{{route('master.country.create', '')}}" class="md-btn md-raised mb-2 w-sm info" style="margin-top: 10px"><i class="fa fa-plus-circle"></i> Buat Baru</a>
      	 </div>
      	  <div class="box-body">
          	 <div class="table-responsive">
			    <table id="example1" class="table  table-bordered table-striped" data-plugin="dataTable">
			      <thead class="bg-info text-white">
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
			      			<td>group</td>
			      			<td style="text-align: center;">
			      				<div class="btn-group">
			      				<a href="{{route('master.country.view', $data->id)}}" class="btn btn-sm btn-info">&nbsp;&nbsp;View&nbsp;&nbsp;</a>&nbsp;&nbsp;
			      				<a href="{{route('master.country.edit', $data->id)}}" class="btn btn-sm btn-danger">&nbsp;&nbsp;Edit&nbsp;&nbsp;</a>
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