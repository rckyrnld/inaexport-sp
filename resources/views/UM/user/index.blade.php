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

<div class="tab">
  <button class="tablinks active" onclick="openCity(event, 'London')"><font size="3px">Administrator & Perwakilan</font></button>
  <button class="tablinks" onclick="openCity(event, 'Paris')"><font size="3px">Eksportir & Importir</font></button>
</div>
<div id="London" class="tabcontent" style="display:block;">
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
<div id="Paris" class="tabcontent">
<br>
<table id="example2" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        <center>Username</center>
                                    </th>
                                    <th>
                                        <center>Email</center>
                                    </th>
                                    <th>
                                        <center>Role</center>
                                    </th>
                                    <th>
                                        <center>Konfirmasi Email</center>
                                    </th>
									<th>
                                        <center>Verify By Admin</center>
                                    </th>
                                    <th width="10%">
                                        <center>Action</center>
                                    </th>
                                </tr>
                                </thead>
								<tbody>
								<?php $i=1; foreach($data as $row){ ?>
								<tr>
									<td><?php echo $i;?></td>
									<td><center><?php echo $row->username;?></center></td>
									<td><center><?php echo $row->email;?></center></td>
									<td><center>
									<?php 
									$cari1 = DB::select("select * from public.group where id_group='".$row->id_role."'");
									foreach($cari1 as $cr1){ echo $cr1->group_name; }
									?>
									</center></td>
									<td><center><?php if($row->agree == 1){ echo "<font color='green'>Sudah</font>";}else{ echo "<font color='red'>Belum</font>";};?></center></td>
									<td><center><?php if($row->status == 1){ echo "<font color='green'>Sudah di Verifikasi</font>";}else{ echo "<font color='red'>Belum di Verifikasi</font>";};?></center></td>
									<td><center>
									<?php if($row->status == 1){ ?>
									<a href="{{url('profil/'.$row->id_role.'/'.$row->id)}}" class="btn btn-sm btn-info"><i class="fa fa-edit text-white"></i> Detail</a>
									
									<?php }else{ ?>
									<a href="{{url('profil/'.$row->id_role.'/'.$row->id)}}" class="btn btn-sm btn-success"><i class="fa fa-edit text-white"></i> Verifikasi</a>
									<?php } ?>
									</center></td>
								</tr>
								<?php $i++; } ?>
								</tbody>

                            </table>
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