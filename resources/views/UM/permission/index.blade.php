@include('header')

<div class="padding">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
      	 <div class="box-divider m-0"></div>
      	  <div class="box-body">
      	  	 <div class="col-md-12">
      	  	 <br>
          	 <div class="table-responsive">
			    <table id="example1" class="table  table-bordered table-striped" data-plugin="dataTable">
			      <thead class="bg-success text-white">
			          <tr>
			              <th width="50">No</th>
			              <th>Group</th>
			              <th><center>Action</center></th>
			          </tr>
			      </thead>
			      <tbody>
			      	@foreach($group as $no => $res)
			      		<tr>
			      			<td>{{$no+1}}</td>
			      			<td>{{$res->group_name}}</td>
			      			<td><center>
			      				<div class="btn-group">
			      				<a href="{{url('/permission_edit/'.$res->id_group)}}" class="btn btn-sm btn-info"><i class="fa fa-edit text-white"></i></a>
			      			    </div>
			      			</center></td>
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