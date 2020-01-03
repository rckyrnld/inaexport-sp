<?php 
$qr = DB::select("select id,nama_kategori_en from csc_product where level_2='".$id."' order by nama_kategori_en asc");
if(count($qr) == 0){
?>
<input type="hidden" name="t3s" id="t3s" value="0">
<?php }else{ ?>
<div class="form-row">
		<div class="col-sm-12">
		<label><b>Sub Category 2</b></label>
		</div>
		<div class="form-group col-sm-12">
			
			<select style="color:black;" class="form-control select2" name="t3s" id="t3s">
			<option value="">-- Select Sub Category 2 --</option>
			<?php foreach($qr as $val1){ ?>
			<option value="<?php echo $val1->id; ?>"><?php echo $val1->nama_kategori_en; ?></option>
			<?php } ?>
			</select>
		</div>
		
	</div>
<?php } ?>