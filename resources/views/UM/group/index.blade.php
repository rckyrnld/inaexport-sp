@include('header')


<?php 
   if(!empty($res->group_name)){
   	 $group_name = $res->group_name;
   }else{
   	 $group_name = "";
   }
?>


<div class="padding">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
      	  {{-- <div class="box-header">
      	  </div> --}}
      	  <div class="box-divider m-0"></div>
      	  <div class="box-header">
      	  		
          	 	{{Form::open(['url' => $url,'method' => 'post'])}}
          	 	 <div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('group_name',$label,['class' => 'col-sm-2 col-form-label '])!!}
				      <div class="col-sm-4">
				      	{{ csrf_field() }}

				        {!! Form::text('group_name',$group_name, ['class' => 'form-control']) !!}

				      </div>

				      <div class="col-md-1">
				      	{!!Form::submit(' Save',['class' => 'btn btn-dark'])!!}
				      </div>
				    </div>
				  </div>
          	 	{{Form::close()}}
          	 	
      	  </div>
          <div class="box-body">

          	
          	 
          	 
          	 
          	 <div class="col-md-12">
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
			      				<a href="{{url('/group_edit/'.$res->id_group)}}" class="btn btn-sm btn-warning"><i class="fa fa-edit text-white"></i></a>

			      				<a href="{{url('/group_delete/'.$res->id_group)}}" class="btn btn-sm btn-danger"><i class="fa fa-trash text-white"></i></a>
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