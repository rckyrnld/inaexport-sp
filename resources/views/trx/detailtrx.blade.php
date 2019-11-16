@include('frontend.layouts.header')


<!--slider area start-->
<?php 
    $loc = app()->getLocale(); 
    if($loc == "ch"){
        $lct = "chn";
    }else if($loc == "in"){
        $lct = "in";
    }else{
        $lct = "en";
    }
?>

    <!--product area start-->
    <section class="product_area mb-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_title">
                        <br>
                    </div>

                </div>
            </div>

            <div class="tab-content" id="tabing-product">
			<div class="breadcrumb_content">
                        <ul>
                            <li><a href="{{url('front_end')}}">@lang("login.forms.home")</a></li>
                            <li>Detail Transaction</li>
                        </ul>
                    </div>
			<div class="form-row" style="font-size:12px;">
			 <!--<img style="width:100%!important;" src="{{url('assets')}}/assets/images/07-Form-Request_01.png" alt="." >-->
  
  
<?php 
$q1 = DB::select("select * from csc_buying_request_join where id='".$id2."'");
foreach($q1 as $p){ $id_br = $p->id_br; }
$q2 = DB::select("select * from csc_buying_request where id='".$id."'");
foreach($q2 as $p2){
?>

<div class="">
<div class="col-md-12">
   <div class="box-body">
   <br><br>
  
  <div class="form-row">
		<div class="col-md-6">
		<label><b>Category Product</b></label>
		</div>
		<div class="form-group col-md-6">
			<?php 
			$ms1 = DB::select("select id,nama_kategori_en from csc_product where id='".$p2->id_csc_prod_cat."'");
			foreach($ms1 as $kc1){ $rto =  $kc1->nama_kategori_en; }
			?>
		<input type="text" class="form-control" value="<?php echo $rto; ?>" readonly>
			</div>
		
	</div>
	
	<div class="form-row">
		<div class="col-md-6">
		<label><b>Kind of Subject</b></label>
		</div>
		<div class="form-group col-md-6">
			<input type="text" class="form-control" value="Offer to Buy" readonly>
		</div>
		
	</div>
	
	
	
	
	
	
	<div class="form-row">
		<div class="form-group col-sm-6">
			<b>Date</b>
		</div>
		<div class="form-group col-sm-6">
			
			<input type="text" class="form-control" value="<?php echo $p2->date; ?>" readonly>
		</div>
	</div>
	
	<div class="form-row">
		<div class="form-group col-sm-6">
			<b>Quantity</b>
		</div>
		<div class="form-group col-sm-4">
			<input type="number" class="form-control" value="<?php echo $p2->eo; ?>" readonly>
		</div>
		<div class="form-group col-sm-2">
			<input type="hidden" name="id1" class="form-control" value="<?php echo $id; ?>">
			<input type="hidden" name="id2" class="form-control" value="<?php echo $id2; ?>">
			<input type="text" class="form-control" value="<?php echo $p2->neo; ?>" readonly>
		</div>
	</div>
	
	<div class="form-row">
		<div class="form-group col-sm-6">
			<b>Price</b>
		</div>
		<div class="form-group col-sm-4">
			<input type="number" class="form-control" value="<?php echo $p2->tp; ?>" readonly>
		</div>
		<div class="form-group col-sm-2">
			<input type="text" class="form-control" value="<?php echo $p2->ntp; ?>" readonly>
		</div>
	</div>
	
	<div class="form-row">
		<div class="form-group col-sm-6">
			<b>Subject</b>
		</div>
		<div class="form-group col-sm-6">
			
			<input type="text" class="form-control" value="<?php echo $p2->subyek; ?>" readonly>
		</div>
	</div>
	
	<div class="form-row">
		<div class="form-group col-sm-6">
			<b>Messages</b>
		</div>
		<div class="form-group col-sm-6">
			<textarea class="form-control" readonly><?php echo $p2->spec; ?></textarea>
			<input type="hidden" id="id_br" value="<?php echo $id_br; ?>">
		</div>
	</div>
	
	<div class="form-row">
		<div class="form-group col-sm-6">
			<b>File</b>
		</div>
		<div class="form-group col-sm-6">
			<a download href="{{asset('uploads/buy_request/'.$p2->files)}}"><?php echo $p2->files; ?></a>
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-sm-6">
			<b>Sources</b>
		</div>
		<div class="form-group col-sm-6">
			<input type="text" class="form-control" value="Buying Request" readonly>
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-sm-6">
			<b>Tracking of Type</b>
		</div>
		<div class="form-group col-sm-6">
			<select <?php if($p2->status_trx == 1){ echo "readonly"; }?> class="form-control" name="type_tracking" required>
				<option value="">- Select Tracking Type -</option>
				<option <?php if($p2->type_tracking == "DHL Express"){ echo "selected"; }?> value="DHL Express">DHL Express</option>
				<option <?php if($p2->type_tracking == "DHL Active Tracing"){ echo "selected"; }?> value="DHL Active Tracing">DHL Active Tracing</option>
				<option <?php if($p2->type_tracking == "DHL Global Forwarding"){ echo "selected"; }?> value="DHL Global Forwarding">DHL Global Forwarding</option>
				<option <?php if($p2->type_tracking == "Fedex"){ echo "selected"; }?> value="Fedex">Fedex</option>
				<option <?php if($p2->type_tracking == "Fedex Freight"){ echo "selected"; }?> value="Fedex Freight">Fedex Freight</option>
				<option <?php if($p2->type_tracking == "FedEx Ground"){ echo "selected"; }?> value="FedEx Ground">FedEx Ground</option>
				<option <?php if($p2->type_tracking == "China EMS"){ echo "selected"; }?> value="China EMS">China EMS</option>
				<option <?php if($p2->type_tracking == "Deutsche Post DHL"){ echo "selected"; }?> value="Deutsche Post DHL">Deutsche Post DHL</option>
			</select>
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-sm-6">
			<b>No Tracking</b>
		</div>
		<div class="form-group col-sm-6">
			<input class="form-control" type="text" id="no_track" name="no_track" value="<?php echo $p2->no_track; ?>" <?php if($p2->status_trx == 1){ echo "readonly"; }?> required>
			<input class="form-control" type="hidden" id="tipekirim" name="tipekirim" value="" required>
		</div>
	</div>
	
	<div class="form-row">
		
		<div class="form-group col-sm-5">
		
			<center>
			
			<a style="width:33%;" href="{{url('trx_list')}}" class="btn btn-danger">Back</a></center>
		</div>
	</div>
	</div>

</div>


<?php } ?>


			
            </div>
                   
            </div>
        </div>
    </section>
    <!--product area end-->

@include('frontend.layouts.footer')
<?php $quertreject = DB::select("select * from mst_template_reject order by id asc"); ?>
<script type="text/javascript">
	$(document).ready(function() {
    $('#example').DataTable();
	
	$('#tablebureq').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('front.datatables.br3') }}",
            columns: [
                {data: 'row', name: 'row'},
                {data: 'col1', name: 'col1'},
                {data: 'col2', name: 'col2'},
                {data: 'col3', name: 'col3'},
                {data: 'col4', name: 'col4'},
                {data: 'col5', name: 'col5'},
                {data: 'col6', name: 'col6'}
                
            ],
            fixedColumns: true
        });
} );
</script>
<script>
function xy(a){
	var token = $('meta[name="csrf-token"]').attr('content');
		$.get('{{URL::to("ambilbroad/")}}/'+a,{_token:token},function(data){
			$("#isibroadcast").html(data);
			
		 })
}
function t1(){
	$('#t2').html('');
	$('#t3').html('');
	var t1 = $('#category').val();
	var token = $('meta[name="csrf-token"]').attr('content');
		$.get('{{URL::to("ambilt2/")}}/'+t1,{_token:token},function(data){
			$("#t2").html(data);
			$("#t3").html('<input type="hidden" name="t3s" id="t3s" value="0">');
			 $('.select2').select2();
			
		 })
}
function t2(){
	$('#t3').html('');
	var t2 = $('#t2s').val();
	var token = $('meta[name="csrf-token"]').attr('content');
		$.get('{{URL::to("ambilt3/")}}/'+t2,{_token:token},function(data){
			$("#t3").html(data);
			 $('.select2').select2();
			
		 })
}
function nv(){
	var a = $('#staim').val();
	if(a == 2){
		$('#sh1').html('<div class="form-row"><div class="form-group col-sm-4"><label><b>Alasan Reject</b></label></div><div class="form-group col-sm-8"><select onchange="ketv()" id="template_reject" name="template_reject" class="form-control"><option value="">-- Pilih Alasan Reject --</option><?php foreach($quertreject as $qr){ ?><option value="<?php echo $qr->id;?>"><?php echo $qr->nama_template;?></option><?php } ?></select></div></div>')
	}else{
		$('#sh1').html(' ');
		$('#sh2').html(' ');
	}
}
function ketv(){
	var a = $('#template_reject').val();
	if(a == 1){
		$('#sh2').html('<div class="form-row"><div class="form-group col-sm-4"><label><b>Keterangan Reject</b></label></div><div class="form-group col-sm-8"><textarea class="form-control" id="txtreject" name="txtreject"></textarea></div></div>')
	}
}
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
<script type="text/javascript">
    // $(document).ready(function () {
        
    // })
    function openTab(tabname) {
        $('.tab-pane').removeClass('active');
        $('#'+tabname).addClass('active');
    }
</script>