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

<style>
body {font-family: Arial;}

/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 8px 10px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
</style>
<div class="padding">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
      	  {{-- <div class="box-header">
      	  </div> --}}
      	  <div class="box-divider m-0"></div>
      	  <div class="box-header">
      	  		
          	 	{{Form::open(['url' => $url,'method' => 'post'])}}
				<?php // echo $url; ?>
				 <div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Group',['class' => 'col-sm-2 col-form-label '])!!}
				      <div class="col-sm-4">
				     <select class="form-control" name="id_group">
				        		@foreach($group as $res)

				        		 <option @if($id_group == $res->id_group) selected="selected"  @endif value="{{$res->id_group}}">{{$res->group_name}}</option>

				        		@endforeach
				        	</select>
				      </div>

				    </div>
				  </div>
				  <div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Type',['class' => 'col-sm-2 col-form-label '])!!}
				      <div class="col-sm-4">
				     
				        <input type="text" name="type" class="form-control" value="DJPEN" readonly> 
						</div>

				    </div>
				  </div>
          	 	 <div class="col-md-12">
          	 	 	
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
				      

				       <input type="password" name="password" class="form-control" value="">

				      </div>

				    </div>
				  </div>


				  <div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Konfirmasi Password',['class' => 'col-sm-2 col-form-label '])!!}
				      <div class="col-sm-4">
				     
				        <input type="password" name="password_confirm" class="form-control" value="">



				      </div>

				    </div>
				  </div>




				  <div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('group','&nbsp;',['class' => 'col-sm-2 col-form-label '])!!}
				      <div class="col-sm-4">
				     
				        	
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


<table id="example1" class="table  table-bordered table-striped" data-plugin="dataTable">
			      <thead class="bg-success text-white">
			          <tr>
			              <th width="50">No</th>
			              <th>Group</th>
			              <th>User</th>
			              <th>Email</th>
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
			      			<td>{{$res->email}}</td>
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

<script>
$(document).ready(function () {
        $('.select2').select2();
});
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>
  


@include('footer')