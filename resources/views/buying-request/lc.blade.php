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
                        <div class="">
						

<style>
body {font-family: Arial;}

.select2-container--default .select2-selection--single {
    background-color: #fff!important;
    border: 1px solid rgba(120, 130, 140, 0.5)!important;
    border-radius: 4px!important;
}


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



<?php 
								$pesan = DB::select("select * from csc_buying_request where id='".$id."' limit 1 ");
								foreach($pesan as $ryu){
									?>
<div class="form-row">
<div class="col-md-6">
   <div class="box-body">
   <br><br>
  
	<div class="form-row">
		<div class="form-group col-sm-12">
			<b>Created By</b>
		</div>
		<div class="form-group col-sm-12">
		<?php 
			if($ryu->by_role == 1){
				$t = "Admin";
			}else if($ryu->by_role == 4){
				$t =  "Perwakilan";
			}else if($ryu->by_role == 3){
				$usre = DB::select("select b.company,b.badanusaha from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='".$ryu->id_pembuat."'"); 
									foreach($usre as $imp){ 
									$t = "Importir - ".$imp->badanusaha." ".$imp->company; 
									}
			}
			?>
		<input type="text" class="form-control" value="<?php echo $t; ?>" readonly>
			
		
		</div>
		
	</div>
	<div class="form-row">
		<div class="col-sm-12">
		<label><b>What are you looking for</b></label>
		</div>
		<div class="form-group col-sm-8">
			<input readonly type="text" style="color:black;" value="<?php echo $ryu->subyek; ?>" name="cmp" id="cmp" class="form-control" >
		</div>
		<div class="form-group col-sm-4">
			<select disabled style="color:black;" class="form-control" name="valid" id="valid">
			<option <?php if($ryu->valid == "7"){ echo "selected"; }?> value="7">Valid within 7 day</option>
			</select>
		</div>
	</div>
	<div class="form-row">
		<div class="col-sm-12">
		<label><b>Category</b></label>
		</div>
		<div class="form-group col-sm-12">
			<?php 
			$ms1 = DB::select("select id,nama_kategori_en from csc_product order by nama_kategori_en asc");
			?>
			<select style="color:black;" disabled class="form-control" name="category" id="category" onchange="t1()">
			<option value="">-- Select Category --</option>
			<?php foreach($ms1 as $val1){ ?>
			<option <?php if($ryu->id_csc_prod_cat == $val1->id){ echo "selected"; }?>  value="<?php echo $val1->id; ?>"><?php echo $val1->nama_kategori_en; ?></option>
			<?php } ?>
			</select>
		</div>
		
	</div>
	<div id="t2">
	<input type="hidden" name="t2s" id="t2s" value="0">
	</div>
	<div id="t3">
	<input type="hidden" name="t3s" id="t3s" value="0">
	</div>
	<div class="form-row">
		<div class="col-sm-12">
		<label><b>Specification</b></label>
		</div>
		<div class="form-group col-sm-12">
			<textarea readonly style="color:black;" name="spec" id="spec" class="form-control" ><?php echo $ryu->spec; ?></textarea>
		</div>
		
	</div>
	
	<div class="form-row">
		<div class="col-sm-6">
		<label><b>Estimated order quantity</b></label>
		</div>
		<div class="col-sm-6">
		<label><b>Targeted price (Estimated total)</b></label>
		</div>
		<div class="form-group col-sm-6">
			<div class="form-row">
		<div class="col-sm-7"><input readonly style="color:black;" type="number" value="<?php echo $ryu->eo; ?>" name="eo" id="eo" class="form-control"> </div>
		<div class="col-sm-5"> <select disabled style="color:black;" class="form-control" name="neo" id="neo"><option <?php if($ryu->neo == "Pieces"){ echo "selected"; }?> value="Pieces">Pieces</option></select></div>
		</div>
			
			
		</div>
		<div class="form-group col-sm-6">
				
			<div class="form-row">
		<div class="col-sm-7"><input readonly style="color:black;" type="number" value="<?php echo $ryu->tp; ?>" name="tp" id="tp" class="form-control" ></div>
		<div class="col-sm-5"> <select disabled style="color:black;" class="form-control" name="ntp" id="ntp"><option <?php if($ryu->ntp == "IDR"){ echo "selected"; }?> value="IDR">IDR</option><option <?php if($ryu->ntp == "THB"){ echo "selected"; }?> value="THB">THB</option><option <?php if($ryu->ntp == "USD"){ echo "selected"; }?> value="USD">USD</option></select></div>
		</div>
		</div>
		
	</div>
  
	</div>

</div>
<div class="col-md-6">
<div class="box-body">
<br><br>
<div class="form-row">
		<div class="col-sm-12">
		<label><b>Location of delivery</b></label>
		</div>
		<div class="form-group col-sm-6">
			<?php 
			$ms2 = DB::select("select id,country from mst_country order by country asc");
			?>
			<select style="color:black;" style="border-color: rgba(120, 130, 140, 0.5)!important;
    border-radius: 0.25rem!important;
    color: inherit!important;" readonly class="form-control" name="country" id="country">
			<option value="">-- Select Country --</option>
			<?php foreach($ms2 as $val2){ ?>
			<option <?php if($ryu->id_mst_country == $val2->id){ echo "selected"; }?> value="<?php echo $val2->id; ?>"><?php echo $val2->country; ?></option>
			<?php } ?>
			</select>
		</div>
		<div class="form-group col-sm-6">
			<input readonly style="color:black;" type="text" value="<?php echo $ryu->city; ?>" name="city" id="city" class="form-control" placeholder="City/State">
		</div>
	</div>
<div class="form-row">
		<div class="col-sm-12">
		<label><b>Shipping & Payment conditions</b></label>
		</div>
		<div class="form-group col-sm-12">
			<textarea readonly style="color:black;" value="" name="ship" id="ship" class="form-control" ><?php echo $ryu->shipping; ?></textarea>
		</div>
		
	</div>
<div class="form-row">
		<div class="col-sm-12">
		<label><b>Add attachment (Relevant to  a request)</b></label>
		</div>
		<div class="form-group col-sm-12">
			<!-- <input style="color:black;" type="file" value="" name="doc" id="doc" class="form-control" > -->
			<a class="btn btn-warning" download href="{{ asset('uploads/buy_request/'.$ryu->files) }}">Download File</a>
		</div>
		
	</div>
	
	

</div>

</div>


<div class="col-md-12">
<div class="box-body">
<table id="example1" border="0" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
									<th width="5%">No</th>
									<th><center>Company Name</center></th>
									<th><center>Address</center></th>
									<th><center>Email</center></th>
									<th><center>Status</center></th>
									<th><center>Aksi</center></th>
                                </thead>
								<tbody>
								<?php 
								$pesan = DB::select("select a.*,b.*,c.*,a.email as oemail,b.id as idb,a.id as id_user from itdp_company_users a, csc_buying_request_join b, itdp_profil_eks c where a.id=b.id_eks and a.id_profil = c.id and id_br='".$id."'");
								$na = 1;
								foreach($pesan as $ryu){
								?>
								<tr>
								<td><?php echo $na; ?></td>
								<td><div align="left"><a href="{{url('front_end/list_perusahaan/view', $ryu->id_user)}}-{{$ryu->company}}" target="_blank"><?php echo $ryu->company; ?></a></div></td>
								<td><?php echo $ryu->addres." , ".$ryu->city; ?></td>
								<td><?php echo $ryu->oemail; ?></td>
								<td><center>
								<?php if($ryu->status_join == null){echo 'pending';}else if($ryu->status_join == "1"){ echo "Menunggu Verifikasi Importir"; }else if($ryu->status_join == "2"){ echo "Negosiation"; }
									else if($ryu->status_join == "4"){ echo "Deal"; }else{ echo "-"; }?>
								</center></td>
								<td><center>
								<?php if($ryu->status_join == 1){ ?>
								<a href="{{url('br_konfirm2/'.$ryu->idb.'/'.$id)}}" class="btn btn-success" title="Verifikasi"><i class="fa fa-check"></i></a>
								<?php }else if($ryu->status_join == 2){ ?>
								<a href="{{url('br_pw_chat/'.$ryu->idb)}}" class="btn btn-info" title="Chat"><i class="fa fa-comment"></i></a>
								<?php }else if($ryu->status_join == 4){ ?>
								<a href="{{url('br_pw_chat/'.$ryu->idb)}}" class="btn btn-success" title="View"><i class="fa fa-list"></i></a>
								<?php } ?>
								</center></td>
								</tr>
								<?php  $na++; } ?>
								
								</tbody>

                            </table>
</div>
</div>



<div class="col-sm-12">
<div align="right">
<a href="{{ url('br_list') }}" class="btn btn-md btn-danger"><i class="fa fa-arrow-left"></i> Back</a>


</div>
</div>

								<?php } ?>


  

                            
                        </div>
 

                   </div>
                </div>

            </div>

        </div>
    </div>
</div>

@include('footer')
