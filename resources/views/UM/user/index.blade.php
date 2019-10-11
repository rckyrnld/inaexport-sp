@include('header')


<?php 
   if(!empty($res->name)){
   	 $name = $res->name;
   	 $password = $res->password_real;
   	 $email = $res->email;
   	 $id_group = $res->id_group;
   }else{
   	 $name = "";
   	 $password = "";
   	 $email = "";
   	 $id_group = "";
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
          	 	 	<br>
          	 		<div class="form-group row">
				      {!!Form::label('name','Nama',['class' => 'col-sm-2 col-form-label '])!!}
				      <div class="col-sm-4">
				      	{{ csrf_field() }}

				        {!! Form::text('name',$name, ['class' => 'form-control']) !!} 
						

				      </div>
					  
				    </div>
				  </div>
				   <div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Tipe',['class' => 'col-sm-2 col-form-label '])!!}
				      <div class="col-sm-4">
				     
				        <!--<input type="password" name="password_confirm" class="form-control" value="{{$password}}"> -->
						<select class="form-control" name="type">
						<option>DJPEN</option>
						<option>ITPC</option>
						<option>KOMJEN</option>
						<option>KBRI</option>
						<option>ATASE PERDAGANGAN</option>
						<option>DINAS PERDAGANGAN</option>
						
						</select>



				      </div>

				    </div>
				  </div>

				   <div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('email','Email',['class' => 'col-sm-2 col-form-label '])!!}
				      <div class="col-sm-4">
				      

				        {!! Form::text('email',$email, ['class' => 'form-control']) !!}

				      </div>
					  <div class="col-sm-2">
					  <div id="cekl"></div>
					  </div>

				    </div>
				  </div>

				  <div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password','Password',['class' => 'col-sm-2 col-form-label '])!!}
				      <div class="col-sm-4">
				      

				       <input type="password" name="password" class="form-control" value="{{$password}}">

				      </div>

				    </div>
				  </div>


				  <div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Konfirmasi Password',['class' => 'col-sm-2 col-form-label '])!!}
				      <div class="col-sm-4">
				     
				        <input type="password" name="password_confirm" class="form-control" value="{{$password}}">



				      </div>

				    </div>
				  </div>




				  <div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('group','Group',['class' => 'col-sm-2 col-form-label '])!!}
				      <div class="col-sm-4">
				     
				        	<select class="form-control" name="id_group">
				        		@foreach($group as $res)

				        		 <option @if($id_group == $res->id_group) selected="selected"  @endif value="{{$res->id_group}}">{{$res->group_name}}</option>

				        		@endforeach
				        	</select>
				        	<br>


				        	<input class="btn btn-primary" id="halox" type="submit" value=" Simpan">

				      </div>

				    </div>
				  </div>


          	 	{{Form::close()}}
          	 	
      	  </div>
          <div class="box-body">

          	
          	 
          	 
          
          	  
          </div>
      </div>


	  <ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
  <li><a data-toggle="tab" href="#menu1">Menu 1</a></li>
  <li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
</ul>

<div class="tab-content">
  <div id="home" class="tab-pane fade in active">
    <h3>HOME</h3>
    <p>Some content.</p>
  </div>
  <div id="menu1" class="tab-pane fade">
    <h3>Menu 1</h3>
    <p>Some content in menu 1.</p>
  </div>
  <div id="menu2" class="tab-pane fade">
    <h3>Menu 2</h3>
    <p>Some content in menu 2.</p>
  </div>
</div>
       <div class="box">
      	  {{-- <div class="box-header">
      	  </div> --}}
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
			              <th>User</th>
			              <th><center>Tanggal Daftar</center></th>
			              <th><center>Aksi</center></th>
			             
			          </tr>
			      </thead>
			      <tbody>
			      	@foreach($user as $no => $res)
						
			      		<tr>
			      			<td>{{$no+1}}</td>
			      			<td>{{$res->group_name}}</td>
			      			<td>{{$res->name}}</td>
			      			<td><center>{{$res->ca}}</center></td>
			      			<td><center>
			      				<div class="btn-group">
								
			      				<a href="{{url('/user_edit/'.$res->id)}}" class="btn btn-sm btn-info"><i class="fa fa-edit text-white"></i></a>
								
			      				<a onclick="return confirm('Apa Anda Yakin untuk Menghapus User Ini ?')" href="{{url('/user_delete/'.$res->id)}}" class="btn btn-sm btn-danger"><i class="fa fa-trash text-white"></i></a>
								
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
<script>
function alertaja(){
	alert("Data Masih Digunakan !");
}
$('body').on("keyup", "input[name=email]", function() {
	var em = $('#email').val();
	// alert(em);
	$.get('{{url("getem")}}/'+em,function (data) {
      console.log(data);
	  if(data == 0){
		 // $('#cekl').html("<font color='green'>Email Tersedia</font>");
		 document.getElementById("halox").disabled = false;
	  }else{
		  $('#cekl').html("<font color='red'>Email Telah digunakan</font>");
		  document.getElementById("halox").disabled = true;
		  
	  }
      // $('#alot').html(data);
    });
	
    // do your stuff

});

</script>


@include('footer')