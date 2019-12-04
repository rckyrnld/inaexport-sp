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



<form class="form-horizontal" method="POST" action="{{ url('br_save') }}" enctype="multipart/form-data">
           {{ csrf_field() }}
<?php 
$q1 = DB::select("select * from csc_buying_request_join where id='".$id."'");
foreach($q1 as $p){ $id_br = $p->id_br; }
$q2 = DB::select("select * from csc_buying_request where id='".$id_br."'");
foreach($q2 as $p2){
?>

<div class="form-row">
<div class="col-md-12">
   <div class="box-body">
   <br><br>
  
	<div class="form-row">
		<div class="form-group col-sm-2">
			<b>Created By</b>
		</div>
		<div class="form-group col-sm-4">
			<?php 
			if($p2->by_role == 1){
				echo "Admin";
			}else if($p2->by_role == 4){
				echo "Perwakilan";
			}else if($p2->by_role == 3){
				$usre = DB::select("select b.company,b.badanusaha from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='".$p2->id_pembuat."'"); 
									foreach($usre as $imp){ 
									echo "Importir - ".$imp->badanusaha." ".$imp->company; 
									}
			}
			?>
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-sm-2">
			<b>Address</b>
		</div>
		<div class="form-group col-sm-4">
			<?php 
			if($p2->by_role == 1){
				$co = $p2->id_mst_country;
				$naco ="";
				$caric = DB::select("select * from mst_country where id='".$co."'");
				foreach($caric as $cc){ $naco = $cc->country; }
				echo $naco." ,".$p2->city;
			}else if($p2->by_role == 4){
				$co = $p2->id_mst_country;
				$naco ="";
				$caric = DB::select("select * from mst_country where id='".$co."'");
				foreach($caric as $cc){ $naco = $cc->country; }
				echo $naco." ,".$p2->city;
			}else if($p2->by_role == 3){
				$usre = DB::select("select b.addres,b.city from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='".$p2->id_pembuat."'"); 
									foreach($usre as $imp){ 
									echo $imp->addres." , ".$imp->city; 
									}
			}
			?>
		</div>
	</div>
	
	<div class="form-row">
		<div class="form-group col-sm-2">
			<b>Category Product</b>
		</div>
		<div class="form-group col-sm-4">
			<?php 
			$cr = explode(',',$p2->id_csc_prod);
				$hitung = count($cr);
				$semuacat = "";
				for($a = 0; $a < ($hitung - 1); $a++){
					$namaprod = DB::select("select * from csc_product where id='".$cr[$a]."' ");
					foreach($namaprod as $prod){ $napro = $prod->nama_kategori_en; }
					$semuacat = $semuacat."- ".$napro."<br>";
				}
				echo $semuacat;
			
			?>
		</div>
	</div>
	
	<div class="form-row">
		<div class="form-group col-sm-2">
			<b>Kind of Subject</b>
		</div>
		<div class="form-group col-sm-4">
			Offer to buy
		</div>
	</div>
	
	<div class="form-row">
		<div class="form-group col-sm-2">
			<b>Date</b>
		</div>
		<div class="form-group col-sm-4">
			<?php echo $p2->date; ?>
		</div>
	</div>
	
	<div class="form-row">
		<div class="form-group col-sm-2">
			<b>Subject</b>
		</div>
		<div class="form-group col-sm-4">
			<?php echo $p2->subyek; ?>
		</div>
	</div>
	
	<div class="form-row">
		<div class="form-group col-sm-2">
			<b>Messages</b>
		</div>
		<div class="form-group col-sm-4">
			<?php echo $p2->spec; ?>
		</div>
	</div>
	
	<div class="form-row">
		<div class="form-group col-sm-2">
			<b>File</b>
		</div>
		<div class="form-group col-sm-4">
			<a download href="{{asset('uploads/buy_request/'.$p2->files)}}"><?php echo $p2->files; ?></a>
		</div>
	</div>
	</div>

</div>


<div class="col-sm-12">
<div align="center"><br>
<a href="{{ url('br_save_join/'.$id) }}" class="btn btn-md btn-primary"><i class="fa fa-comment"></i> Chat</a>
<a href="{{ url('br_list') }}" class="btn btn-md btn-danger"><i class="fa fa-arrow-left"></i> Decline</a>


</div>
</div>
</div>
<?php } ?>
</form>
<?php $quertreject = DB::select("select * from mst_template_reject order by id asc"); ?>
<script>
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
  

                            
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@include('footer')
