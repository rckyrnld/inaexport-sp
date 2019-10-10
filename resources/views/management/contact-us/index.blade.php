@include('header')
<style type="text/css">
	th {text-align: center;}
	td {color: black;}
	#tambah { background-color: #1a9cf9; color: white; white-space: pre;}
	#tambah:hover {background-color: #148de4}
</style>

<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> Data Contact Us</h5>
                </div>

                <div class="box-body bg-light">
                	<a id="tambah" href="{{route('management.contactus.create')}}" class="btn">   <i class="fa fa-plus-circle"></i>  Add   </a>
                    <div class="col-md-14"><br>
		          	 <div class="table-responsive">
					    <table id="example1" class="table  table-bordered table-striped" data-plugin="dataTable">
					      <thead class="text-white" style="background-color: #1089ff;">
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
					      			<td>{{$no+1}}</td>
					      			<td>{{$data->fullname}}</td>
					      			<td>{{$data->email}}</td>
					      			<td>{{$data->subyek}}</td>
					      			<td>{{$data->message}}</td>
					      			<td style="text-align: center;">
					      				<div class="btn-group">
					      				<a href="{{route('management.contactus.view', $data->id)}}" class="btn btn-sm btn-info">&nbsp;<i class="fa fa-search text-white"></i>&nbsp;View&nbsp;</a>&nbsp;&nbsp;
					      				<a onclick="return confirm('Apa Anda Yakin untuk Menghapus Data Ini ?')" href="{{route('management.contactus.destroy', $data->id)}}" class="btn btn-sm btn-danger">&nbsp;<i class="fa fa-trash text-white"></i>&nbsp;Delete&nbsp;</a>
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