
<div class="modal-body">
<?php 
								$pesan = DB::select("select * from csc_buying_request where id='".$id."' limit 1 ");
								foreach($pesan as $ryu){
									?>
<div class="form-row">
		<div class="col-sm-3">
		<label><b>@lang("login.forms.by2")</b></label>
		</div>
		<div class="form-group col-sm-6">
			<input type="text" readonly style="color:black;" value="<?php echo strtoupper($ryu->subyek); ?>" name="cmp" id="cmp" class="form-control" >
		</div>
		
	</div>
<div class="form-row">
		<div class="col-sm-3">
		<label><b>@lang("login.forms.by3")</b></label>
		</div>
		<div class="form-group col-sm-6">
			<?php 
			$ms1 = DB::select("select id,nama_kategori_en from csc_product order by nama_kategori_en asc");
			?>
			<select class="form-control select2" name="category" id="category" onchange="t1()">
			<option value="">-- Select Category --</option>
			<?php foreach($ms1 as $val1){ ?>
			<option <?php if($ryu->id_csc_prod_cat == $val1->id){ echo "selected"; }?> value="<?php echo $val1->id; ?>"><?php echo $val1->nama_kategori_en; ?></option>
			<?php } ?>
			</select>
			
		</div>
		
	</div>
	
								<?php } ?>
        </div>
        <div class="modal-footer" style="background-color:#2e899e; color:white;">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><font color="white">Close</font></button>
          <a style="background-color: #d5b824ed!Important;border:#d5b824ed!important;" href="{{ url('br_importir_bc/'.$id) }}" class="btn btn-warning"><font color="white">Broadcast</font></a>
        </div>