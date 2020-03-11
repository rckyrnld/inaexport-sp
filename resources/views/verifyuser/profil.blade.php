<?php // echo bcrypt('abc');die(); ?>
@include('header')
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                

                <div class="box-body bg-light">
                   
                    <div class="col-md-14">
                        <div class="table-responsive">
						

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

.img_upl {
    /*border: 1px solid #6fccdd;*/
    border: none;
    background: transparent;
}
</style>


<div class="tab">
  <button class="tablinks active" onclick="openCity(event, 'London')"><font size="3px">Account Information <?php echo $tx; ?></font></button>
  <button class="tablinks" onclick="openCity(event, 'Paris')"><font size="3px">Company Profile</font></button>
  <?php if($ida == 2){ ?><button class="tablinks" onclick="openCity(event, 'Tokyo')"><font size="3px">Document</font></button> <?php } ?>
</div>
<form class="form-horizontal" method="POST" action="{{ url('simpan_profil') }}" enctype="multipart/form-data">
           {{ csrf_field() }}

<input type="hidden" name="id_role" value="<?php echo $ida; ?>">
<input type="hidden" name="id_user" id="id_user" value="<?php echo $idb; ?>">
<div id="London" class="tabcontent" style="display:block;">
   <div class="box-body">
   <?php 
   $ca = DB::select("select * from itdp_company_users where id='$idb' limit 1");
   foreach($ca as $rhj){
   ?>
	   <div class="row">
		   <div class="col-md-6">
			   <div class="form-row">
				   <div class="form-group col-sm-4">
					   <label><b>Username</b></label>

				   </div>
				   <div class="form-group col-sm-8">
					   <input type="text" value="<?php echo $rhj->username; ?>" name="username" id="username"
							  class="form-control" >

				   </div>


			   </div>
			   <div class="form-row">
				   <div class="form-group col-sm-4">
					   <label><b>Email</b></label>

				   </div>
				   <div class="form-group col-sm-8">
					   <input type="email" value="<?php echo $rhj->email; ?>" name="email" id="email"
							  class="form-control" >

				   </div>


			   </div>
			   <div class="form-row">
				   <div class="form-group col-sm-4">
					   <label><b>Password</b></label>

				   </div>
				   <div class="form-group col-sm-8">
					   <input type="password" value="" name="password" id="password"
							  class="form-control" placeholder="##########" >

				   </div>


			   </div>
			   <div class="form-row">
				   <div class="form-group col-sm-4">
					   <label><b>Re-Password</b></label>

				   </div>
				   <div class="form-group col-sm-8">
					   <input type="password" value="" name="repass" id="repass"
							  class="form-control" placeholder="##########">

				   </div>


			   </div>
		   </div>

   <?php }
   		if($ida == 2){
			$ceq = DB::select("select b.*, a.id as id_user, a.foto_profil from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and a.id='$idb' limit 1");
		}else{
			$ceq = DB::select("select b.*, a.id as id_user, a.foto_profil from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='$idb' limit 1");
		}
		foreach($ceq as $ryu){
	?>
	   <div class="col-md-6">
		   <center>
			   <div id="ambil_ttd_1" style="width: 50%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
				   <button type="button" id="qrcode" style="width: 100%;" class="img_upl">
					   <?php
					   //for qrcode
					   $fileqrcode = '../public/uploads/qrcode/qrcode_2_'.$ryu->id_user.'.png';
					   $qrcode = 'uploads/qrcode/profile2.png';
					   if(file_exists($fileqrcode)) {
					   $qrcode = 'uploads/qrcode/qrcode_2_'.$ryu->id_user.'.png';
					   ?>
					   		<br><img src="../../{{$qrcode}}" id="qrcode_ambil1" style="width: 80%;"/>
					   <?php
					   }else{
					   ?>
					   		<br><img src="../../{{$qrcode}}" id="qrcode_ambil1" style="width: 80%;"/>
					   <?php
					   }
					   ?>
				   </button>
				   <a class="btn btn-md btn-primary" id="gen_qrcode" onclick="qrcode()" style="display: none;"></a>
				   {{--													<input type="file" id="image_1" name="image_1" accept="image/*" style="display: none;" />--}}
				   <br><br>
				   <center><span style="font-size: 17px;"><b>QR Code</b></span></center>
			   </div>
			   <br>
			   <span style="color: red;">* Click image to Generate the QRCode</span>
		   </center>
	   </div>
	   <?php
	   }
	   ?>
	   </div>
	</div>
</div>

<div id="Paris" class="tabcontent">
  <div class="box-body">
  <?php 
  if($ida == 2){
	  //echo "jual";
	  $ceq = DB::select("select b.*, a.id as id_user, a.foto_profil from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and a.id='$idb' limit 1");
  }else{
	  $ceq = DB::select("select b.*, a.id as id_user, a.foto_profil from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='$idb' limit 1");
  }
  foreach($ceq as $ryu){
  	$img1 = "front/assets/icon/profile2.png";
	if($ryu->foto_profil != NULL){
        $imge1 = 'uploads/Profile/Eksportir/'.$ryu->id_user.'/'.$ryu->foto_profil;
        if(file_exists($imge1)) {
          $img1 = 'uploads/Profile/Eksportir/'.$ryu->id_user.'/'.$ryu->foto_profil;
        }
    }
  ?>
  <input type="hidden" name="idu" value="<?php echo $ryu->id; ?>">

  	<div class="row">
  		<div class="col-md-6">
  			<div class="form-row">
				<div class="form-group col-sm-4">
					<label><b>Name of Company</b></label>
				</div>
				
				<div class="form-group col-sm-2">
		<select name="badanusaha" class="form-control">
		<option>-</option>
		<?php 
		$bns = DB::select("select * from eks_business_entity");
		foreach($bns as $val){
		?>
		<option <?php if($ryu->badanusaha == $val->nmbadanusaha){ echo "selected"; } ?> value="<?php echo $val->nmbadanusaha; ?>"><?php echo $val->nmbadanusaha; ?></option>
  <?php } ?>
		</select>
		</div>
				
				<div class="form-group col-sm-6">
					<input type="text" value="<?php echo $ryu->company; ?>" name="company" id="company" class="form-control" >
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-sm-4">
					<label><b>Address</b></label>
				</div>
				<div class="form-group col-sm-8">
					<textarea name="addres" id="addres" class="form-control" ><?php echo $ryu->addres; ?></textarea>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-sm-4">
					<label><b>City</b></label>
				</div>
				<div class="form-group col-sm-8">
					<textarea name="city" id="city" class="form-control" ><?php echo $ryu->city; ?></textarea>
					
				</div>
			</div>
	
			<div class="form-row">
				<div class="form-group col-sm-4">
					<label><b>Province</b></label>
				</div>
				<div class="form-group col-sm-8">
					<select name="province" id="province" class="form-control select2" style="width: 100%">
					<?php
					$qc = DB::select("select id,province_en from mst_province order by province_en asc");
					foreach($qc as $cq){
					?>
						<option <?php if($cq->id == $ryu->id_mst_province){ echo "selected"; } ?> value="<?php echo $cq->id; ?>"><?php echo $cq->province_en; ?></option>
						
					<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-sm-4">
					<label><b>Zip Code</b></label>
				</div>
				<div class="form-group col-sm-8">
					<input type="text" value="<?php echo $ryu->postcode; ?>" name="postcode" id="postcode" class="form-control" >
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-sm-4">
					<label><b>Fax</b></label>
				</div>
				<div class="form-group col-sm-8">
					<input type="text" value="<?php echo $ryu->fax; ?>" name="fax" id="fax" class="form-control" >
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-sm-4">
					<label><b>Website</b></label>
				</div>
				<div class="form-group col-sm-8">
					<input type="text" value="<?php echo $ryu->website; ?>" name="website" id="website" class="form-control" >
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-sm-4">
					<label><b>Phone</b></label>
				</div>
				<div class="form-group col-sm-8">
					<input type="text" value="<?php echo $ryu->phone; ?>" name="phone" id="phone" class="form-control" >
				</div>
			</div>
  		</div>
  		<div class="col-md-6">
  			<center>
                <div id="ambil_ttd_1" style="width: 50%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                    <button type="button" id="img_1" style="width: 100%;" class="img_upl">
                        <br><img src="{{asset($img1)}}" id="image_1_ambil" style="width: 80%;"/>
                    </button>
                    <input type="file" id="image_1" name="image_1" accept="image/*" style="display: none;" />
                    <br><br>
                    <center><span style="font-size: 17px;"><b>Profile Photo</b></span></center>
                </div>
                <br>
                <span style="color: red;">* Click image to upload a profile photo</span>
  			</center>
  		</div>
  	</div>
  <?php } ?>
</div>
</div>

<div id="Tokyo" class="tabcontent">
  <div class="box-body">
  <?php foreach($ceq as $ryu){ ?>
	<div class="form-row">
		<div class="form-group col-sm-3">
			<label><b><font color="red">(*)</font> NPWP</b></label>
		</div>
		<div class="form-group col-sm-4">
			<input type="text" value="<?php echo $ryu->npwp; ?>" name="npwp" id="npwp" onkeyup="ceknpwp()" class="form-control" >
			
		</div>
		
		<div class="form-group col-sm-4 vld">
			<font color="red">Not Valid</font><!-- <input type="text" readonly value="" placeholder="Name of NPWP" name="nanpwp" id="nanpwp" class="form-control" > -->
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-sm-3">
			<label><b><font color="red">(*)</font> Dokumen NPWP</b></label>
		</div>
		<div class="form-group col-sm-4">
		 <?php 
			  if(empty(Auth::user()->name)){  ?>
			<input type="file" name="npwpfile" id="npwpfile" class="form-control" >
			<?php if($ryu->uploadnpwp == null){
				echo "";
			}else { ?>
			 <span>File Sebelumnya : <a href="{{ asset('eksportir/'.$ryu->uploadnpwp)}}"></a>
				 <?php echo $ryu->uploadnpwp; ?></span>
			<?php } ?>
			  <?php } else{ ?>
			  <span><?php if(empty($ryu->uploadnpwp) || $ryu->uploadnpwp == null){ echo "<font color='red'>No File</font>"; }else{ ?>
			  
			  <a href="{{ asset('eksportir/'.$ryu->uploadnpwp)}}"><?php echo $ryu->uploadnpwp; ?></a>
			  <?php } ?>
			  </span>
			  <?php } ?>
			
			
		</div>
		
		
	</div>
	<div class="form-row">
		<div class="form-group col-sm-3">
			<label><b>Tanda Daftar Perusahaan</b></label>
		</div>
		<div class="form-group col-sm-4">
			<input type="text" value="<?php echo $ryu->tdp; ?>" name="tanda_daftar" id="tanda_daftar" class="form-control" >
		</div>
		
		
	</div>
	<div class="form-row">
		<div class="form-group col-sm-3">
			<label><b> Dokumen Tanda Daftar Perusahaan</b></label>
		</div>
		<div class="form-group col-sm-4">
			
			<?php 
			  if(empty(Auth::user()->name)){  ?>
			<input type="file" name="tdpfile" id="tdpfile" class="form-control" >
			<?php if($ryu->uploadtdp == null){
				echo "";
			}else { ?>
				<span>File Sebelumnya : <a href="{{ asset('eksportir/'.$ryu->uploadtdp)}}"></a><?php echo $ryu->uploadtdp; ?></span>
			<?php } ?>
			  <?php } else{ ?>
			  <span><?php if(empty($ryu->uploadtdp) || $ryu->uploadtdp == null){ echo "<font color='red'>No File</font>"; }else{ ?>
			  
			  <a href="{{ asset('eksportir/'.$ryu->uploadtdp)}}"><?php echo $ryu->uploadtdp; ?></a>
			  <?php } ?>
			  </span>
			  <?php } ?>
			
		</div>
		
		
	</div>
	<div class="form-row">
		<div class="form-group col-sm-3">
			<label><b>Surat Izin Usaha Perdagangan</b></label>
		</div>
		<div class="form-group col-sm-4">
			<input type="text" value="<?php echo $ryu->siup; ?>" name="siup" id="siup" class="form-control" >
			
		</div>
		
		
	</div>
	<div class="form-row">
		<div class="form-group col-sm-3">
			<label><b> Dokumen Surat Izin Usaha Perdagangan</b></label>
		</div>
		<div class="form-group col-sm-4">
			
			<?php 
			  if(empty(Auth::user()->name)){  ?>
			<input type="file" name="siupfile" id="siupfile" class="form-control" >
			<?php if($ryu->uploadsiup == null){
				echo "";
			}else { ?>
				<span>File Sebelumnya : <a href="{{ asset('eksportir/'.$ryu->uploadsiup)}}"></a><?php echo $ryu->uploadsiup; ?></span>
			<?php } ?>
			  <?php } else{ ?>
			  <span><?php if(empty($ryu->uploadsiup) || $ryu->uploadsiup == null){ echo "<font color='red'>No File</font>"; }else{ ?>
			  
			  <a href="{{ asset('eksportir/'.$ryu->uploadsiup)}}"><?php echo $ryu->uploadsiup; ?></a>
			  <?php } ?>
			  </span>
			  <?php } ?>
			
		</div>
		
		
	</div>
	<div class="form-row">
		<div class="form-group col-sm-3">
			<label><b>Surat Izin Tanda Usaha</b></label>
		</div>
		<div class="form-group col-sm-4">
			<input type="text" value="<?php echo $ryu->upduserid; ?>" name="situ" id="situ" class="form-control" >
		</div>
		
		
	</div>
	<div class="form-row">
		<div class="form-group col-sm-3">
			<label><b>Scoope of Business</b></label>
		</div>
		<div class="form-group col-sm-4">
			<input type="text" value="<?php echo $ryu->id_eks_business_size; ?>" name="scoope" id="scoope" class="form-control" >
		</div>
		
		
	</div>
	<div class="form-row">
		<div class="form-group col-sm-3">
			<label><b>Type of Business</b></label>
		</div>
		<div class="form-group col-sm-4">
			<input type="text" value="<?php echo $ryu->id_business_role_id; ?>" name="tob" id="tob" class="form-control" >
		</div>
		
		
	</div>
	<div class="form-row">
		<div class="form-group col-sm-3">
			<label><b>Employee</b></label>
		</div>
		<div class="form-group col-sm-4">
			<input type="text" value="<?php echo $ryu->employe; ?>" name="employee" id="employee" class="form-control" >
		</div>
		
		
	</div>
	<div class="form-row">
		<div class="form-group col-sm-3">
			<label><b>
			<?php
						echo "Dokumen"
//			  if(empty(Auth::user()->name)){ echo "Document"; }else{ echo "File Upload from Exporter"; } ?>
			</b></label>
		</div>
		<div class="form-group col-sm-4">
		 <?php 
			  if(empty(Auth::user()->name)){  ?>
			<input type="file" value="" name="doc" id="doc" class="form-control" >
			<?php if($ryu->doc == null){
				echo "";
			}else { ?>
			<span>File Sebelumnya : <a href="{{ asset('eksportir/'.$ryu->doc)}}"><?php echo $ryu->doc; ?></b></span>
			<?php } ?>
			  <?php } else{ ?>
			  <span><?php if(empty($ryu->doc) || $ryu->doc == null){ echo "<font color='red'>No File</font>"; }else{ ?>
			  
			  <a href="{{ asset('eksportir/'.$ryu->doc)}}"><?php echo $ryu->doc; ?></a>
			  <?php } ?>
			  </span>
			  <?php } ?>
		</div>
		
		
	</div>
	<div class="form-row">
		<div class="form-group col-sm-3">
			<label><b>Status Exporter</b></label>
		</div>
		<div class="form-group col-sm-4">
		<?php if(empty(Auth::user()->name)){
			if($rhj->status==1){ echo "Verified"; }else if($rhj->status==2){ echo "Not Verified"; }else{ echo "-"; }
		?>
			<input type="hidden" name="staim" value="<?php echo $rhj->status; ?>">
		<?php 
		}else{ ?>
			<select class="form-control" name="staim">
			<option <?php if($rhj->status == 0){ echo "selected"; } ?> value="0">-- Choose Status --</option>
			<option <?php if($rhj->status == 1){ echo "selected"; } ?> value="1">Verified</option>
			<option <?php if($rhj->status == 2){ echo "selected"; } ?> value="2">Not Verified</option>
			</select>
		<?php } ?>
		<!--
			<select class="form-control" name="staim">
			<option <?php if($ryu->status == 0){ echo "selected"; } ?> value="0">-- Pilih Status --</option>
			<option <?php if($ryu->status == 1){ echo "selected"; } ?> value="1">Verified</option>
			<option <?php if($ryu->status == 2){ echo "selected"; } ?> value="0">Not Verified</option>
			</select> -->
		</div>
		
		
	</div>
  <?php } ?>
  </div>
</div>
<br>
<div align="right">
<?php if(empty(Auth::user()->name)){ }else{ ?>
<a href="{{ url('verifyuser') }}" class="btn btn-md btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
<?php if(Auth::user()->id_group == 1){ ?>
<button class="btn btn-md btn-primary"><i class="fa fa-save"></i> Save</button>
<?php } ?>
<?php } ?>

</div>
</form>
<script>
function ceknpwp(){
	
	var inputnpwp = $("#npwp").val();
	var jumlahkarakter = inputnpwp.length;
	// alert('1234567');
	if(jumlahkarakter == 15){
			$.get('{{url('/ceknpwp')}}',{id:inputnpwp},function(data){
			json = JSON.parse(data);
			console.log('metro');
			console.log(json.nama);
			console.log(json.status);
			if(json.status == "VALID"){
				$('.vld').html("<font color='green'>Valid</font>");
				alert("NPWP terdaftar dengan nama "+ json.nama);
				
			}else{
				alert("NPWP Tidak Benar, Silahkan Hubungin Kantor Pajak Terdekat");
				$('.vld').html("<font color='red'>Not Valid</font>");
				$("#npwp").val('');
			}
			//console.log(data.status);
			// alert(jumlahkarakter);
			
			})
	}else{
		$('.vld').html("<font color='red'>Not Valid</font>");
	}
	
	
}
</script>
<script>
	$("#qrcode").click(function() {
		$("#gen_qrcode").click();
	});
	function qrcode() {
		var id = $('#id_user').val();
		console.log(id);

		$.ajax({
			type: 'GET',
			url: "{{route('eksportir.qrcode')}}",
			data: { code: id },
		}).then(function (data) {
			$("#qrcode_ambil1").attr('src','../../uploads/qrcode/qrcode_2_'+id+'.png');
		});

	}
$(document).ready(function () {
	$('.select2').select2();
	$("#img_1").click(function() {
        $("input[id='image_1']").click();
    });
	document.getElementById("image_1").addEventListener('change',handleFileSelect,false);
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

function handleFileSelect(evt){
    var files = evt.target.files; // FileList object
    var idfile = evt.target.id; // FileList object

    // FileReader support
    if (FileReader && files && files.length) {
        var fr = new FileReader();
        fr.onload = function () {
            document.getElementById(idfile+"_ambil").src = fr.result;
            document.getElementById(idfile+"_ambil").style.width = "100%";
            document.getElementById(idfile+"_ambil").style.height = "100%";
        }
        fr.readAsDataURL(files[0]);
    }
 }
</script>
  

                            
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@include('footer')
