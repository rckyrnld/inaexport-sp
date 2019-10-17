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
</style>


<div class="tab">
  <button class="tablinks active" onclick="openCity(event, 'London')"><font size="3px">Account Information <?php echo $tx; ?></font></button>
  <button class="tablinks" onclick="openCity(event, 'Paris')"><font size="3px">Profil Company</font></button>
  <?php if($ida == 2){ ?><button class="tablinks" onclick="openCity(event, 'Tokyo')"><font size="3px">Document</font></button> <?php } ?>
</div>
<form class="form-horizontal" method="POST" action="{{ url('simpan_profil') }}">
           {{ csrf_field() }}

<input type="hidden" name="id_role" value="<?php echo $ida; ?>">
<input type="hidden" name="id_user" value="<?php echo $idb; ?>">
<div id="London" class="tabcontent" style="display:block;">
   <div class="box-body">
   <?php 
   $ca = DB::select("select * from itdp_company_users where id='$idb' limit 1");
   foreach($ca as $rhj){
   ?>
                            <div class="form-row">
                                <div class="form-group col-sm-2">
                                    <label><b>Username</b></label>
                                   
                                </div>
								<div class="form-group col-sm-4">
                                    <input type="text" value="<?php echo $rhj->username; ?>" name="username" id="username"
                                           class="form-control" >
                                   
                                </div>

                               
                            </div>
							 <div class="form-row">
                                <div class="form-group col-sm-2">
                                    <label><b>Email</b></label>
                                   
                                </div>
								<div class="form-group col-sm-4">
                                    <input type="text" value="<?php echo $rhj->email; ?>" name="email" id="email"
                                           class="form-control" >
                                   
                                </div>

                               
                            </div>
							<div class="form-row">
                                <div class="form-group col-sm-2">
                                    <label><b>Password</b></label>
                                   
                                </div>
								<div class="form-group col-sm-4">
                                    <input type="password" value="" name="password" id="password"
                                           class="form-control" placeholder="##########" >
                                   
                                </div>

                               
                            </div>
							<div class="form-row">
                                <div class="form-group col-sm-2">
                                    <label><b>Re-Password</b></label>
                                   
                                </div>
								<div class="form-group col-sm-4">
                                    <input type="password" value="" name="repass" id="repass"
                                           class="form-control" placeholder="##########">
                                   
                                </div>

                               
                            </div>
   <?php } ?>
	</div>
</div>

<div id="Paris" class="tabcontent">
  <div class="box-body">
  <?php 
  if($ida == 2){
	  //echo "jual";
	  $ceq = DB::select("select b.* from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and a.id='$idb' limit 1");
  }else{
	  $ceq = DB::select("select b.* from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='$idb' limit 1");
  }
  foreach($ceq as $ryu){
  ?>
  <input type="hidden" name="idu" value="<?php echo $ryu->id; ?>">
	<div class="form-row">
		<div class="form-group col-sm-2">
			<label><b>Name of Company</b></label>
		</div>
		<div class="form-group col-sm-4">
			<input type="text" value="<?php echo $ryu->company; ?>" name="company" id="company" class="form-control" >
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-sm-2">
			<label><b>Address</b></label>
		</div>
		<div class="form-group col-sm-4">
			<textarea name="addres" id="addres" class="form-control" ><?php echo $ryu->addres; ?></textarea>
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-sm-2">
			<label><b>City</b></label>
		</div>
		<div class="form-group col-sm-4">
			<select name="city" id="city" class="form-control select2" >
			<?php
			$qc = DB::select("select city from mst_city order by city asc");
			foreach($qc as $cq){
			?>
				<option <?php if($cq->city == $ryu->city){ echo "selected"; } ?> value="<?php echo $cq->city; ?>"><?php echo $cq->city; ?></option>
				
			<?php } ?>
			</select>
		</div>
	</div>
	
	<div class="form-row">
		<div class="form-group col-sm-2">
			<label><b>Province</b></label>
		</div>
		<div class="form-group col-sm-4">
			<select name="province" id="province" class="form-control select2" >
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
		<div class="form-group col-sm-2">
			<label><b>Zip Code</b></label>
		</div>
		<div class="form-group col-sm-4">
			<input type="text" value="<?php echo $ryu->postcode; ?>" name="postcode" id="postcode" class="form-control" >
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-sm-2">
			<label><b>Fax</b></label>
		</div>
		<div class="form-group col-sm-4">
			<input type="text" value="<?php echo $ryu->fax; ?>" name="fax" id="fax" class="form-control" >
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-sm-2">
			<label><b>Website</b></label>
		</div>
		<div class="form-group col-sm-4">
			<input type="text" value="<?php echo $ryu->website; ?>" name="website" id="website" class="form-control" >
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-sm-2">
			<label><b>Phone</b></label>
		</div>
		<div class="form-group col-sm-4">
			<input type="text" value="<?php echo $ryu->phone; ?>" name="phone" id="phone" class="form-control" >
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
			<label><b>NPWP</b></label>
		</div>
		<div class="form-group col-sm-4">
			<input type="text" value="<?php echo $ryu->npwp; ?>" name="npwp" id="npwp" class="form-control" >
		</div>
		
		<div class="form-group col-sm-4">
			<input type="text" readonly value="" placeholder="Name of NPWP" name="nanpwp" id="nanpwp" class="form-control" >
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
			<label><b>Surat Izin Usaha Perdagangan</b></label>
		</div>
		<div class="form-group col-sm-4">
			<input type="text" value="<?php echo $ryu->siup; ?>" name="siup" id="siup" class="form-control" >
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
			<label><b>Document</b></label>
		</div>
		<div class="form-group col-sm-4">
			<input type="file" value="" name="doc" id="doc" class="form-control" >
			<?php if($ryu->doc == null){
				echo "";
			}else {
			echo "<span>File Sebelumnya : <a>".$ryu->doc."</b></span>";
			} ?>
		</div>
		
		
	</div>
	<div class="form-row">
		<div class="form-group col-sm-3">
			<label><b>Status Ekportir</b></label>
		</div>
		<div class="form-group col-sm-4">
		<?php if(empty(Auth::user()->name)){
			if($rhj->status==1){ echo "Verified"; }else if($rhj->status==2){ echo "Not Verified"; }else{ echo "-"; }
		?>
			<input type="hidden" name="staim" value="<?php echo $rhj->status; ?>">
		<?php 
		}else{ ?>
			<select class="form-control" name="staim">
			<option <?php if($rhj->status == 0){ echo "selected"; } ?> value="0">-- Pilih Status --</option>
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
<a href="{{ url('verifyuser') }}" class="btn btn-md btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
<?php } ?>
<button class="btn btn-md btn-primary"><i class="fa fa-save"></i> Save</button>
</div>
</form>
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
  

                            
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@include('footer')
