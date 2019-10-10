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
          <a id="tambah" href="{{route('management.contactus.export')}}" class="md-btn md-raised mb-2 w-sm info"><i class="fa fa-plus-circle"></i>  Add</a>
      	 </div>
      	  <div class="box-body">
          	 <div class="table-responsive">
			    <table id="example1" class="table  table-bordered table-striped" data-plugin="dataTable">
			      <thead class="bg-success text-white">
			          <tr>
			              <th>No</th>
			              <th>Fullname</th>
			              <th>Email</th>
			              <th>Subyek</th>
			              <th>Message</th>
			              <th width="20%">Action</th>
			          </tr>
			      </thead>
			      <tbody>
			      	@foreach($contactus as $no => $data)
			      		<tr>
			      			<td>{{$no++}}</td>
			      			<td>{{$data->fullname}}</td>
			      			<td>{{$data->email}}</td>
			      			<td>{{$data->subyek}}</td>
			      			<td>{{$data->message}}</td>
			      			<td style="text-align: center;">
			      				<div class="btn-group">
			      				<a href="{{route('management.contactus.view', $data->id)}}" class="btn btn-sm btn-info">&nbsp;&nbsp;<i class="fa fa-edit text-white"></i>&nbsp;&nbsp;</a>
			      				<a onclick="return confirm('Apa Anda Yakin untuk Menghapus Provinsi Ini ?')" href="{{route('management.contactus.destroy', $data->id)}}" class="btn btn-sm btn-danger">&nbsp;&nbsp;<i class="fa fa-trash text-white"></i>&nbsp;&nbsp;</a>
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