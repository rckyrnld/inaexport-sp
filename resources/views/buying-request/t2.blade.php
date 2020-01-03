<?php 
$qr = DB::select("select id,nama_kategori_en from csc_product where level_1='".$id."' order by nama_kategori_en asc");
if(count($qr) == 0){
?>
<input type="hidden" name="t2s" id="t2s" value="0">
<?php }else{ ?>
<div class="form-row">
		<div class="col-sm-12">
		<label><b>Sub Category 1</b></label>
		</div>
		<div class="form-group col-sm-12">
			
			<select style="color:black;" class="form-control select2" name="t2s" id="t2s" onchange="t2()">
			<option value="">-- Select Sub Category 1 --</option>
			<?php foreach($qr as $val1){ ?>
			<option value="<?php echo $val1->id; ?>"><?php echo $val1->nama_kategori_en; ?></option>
			<?php } ?>
			</select>
		</div>
		
	</div>
<?php } ?>