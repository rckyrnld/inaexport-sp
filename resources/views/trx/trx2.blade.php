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
<style>
.chat
{
    list-style: none;
    margin: 0;
    padding: 0;
}

.chat li
{
    margin-bottom: 10px;
    padding-bottom: 5px;
    border-bottom: 1px dotted #B3A9A9;
}

.chat li.left .chat-body
{
    margin-left: 60px;
}

.chat li.right .chat-body
{
    margin-right: 10px;
}


.chat li .chat-body p
{
    margin: 0;
    color: #777777;
}

.panel .slidedown .glyphicon, .chat .glyphicon
{
    margin-right: 5px;
}

.panel-body
{
   
    height: 280px;
}

::-webkit-scrollbar-track
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #F5F5F5;
}

::-webkit-scrollbar
{
    width: 10px;
    background-color: #F5F5F5;
}

::-webkit-scrollbar-thumb
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
    background-color: #555;
}

</style>



<form class="form-horizontal" method="POST" action="{{ url('save_trx') }}" enctype="multipart/form-data">
           {{ csrf_field() }}
<?php 

$q2 = DB::select("select * from csc_transaksi where id_transaksi='".$id."'");
foreach($q2 as $p2){
?>
	
	<div class="form-row">
		<div class="form-group col-sm-2">
			<b>Sources</b>
		</div>
		<div class="form-group col-sm-4">
			<?php if($p2->origin == 1){ echo "Inquiry"; }else{ echo "Buying Request"; } ?>
		</div>
	</div>
	<?php if($p2->origin == 2){ ?>
	<?php $q3 = DB::select("select * from csc_buying_request where id='".$p2->id_terkait."'");
	foreach($q3 as $p3){
	?>
	
	<div class="form-row">
		<div class="form-group col-sm-2">
			<b>Category Product</b>
		</div>
		<div class="form-group col-sm-4">
			<?php 
$cr = explode(',',$p3->id_csc_prod);
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
			<?php  echo $p3->date; ?>
		</div>
	</div>
	
	<div class="form-row">
		<div class="form-group col-sm-2">
			<b>Quantity</b>
		</div>
		<div class="form-group col-sm-2">
			<input type="number" class="form-control" value="<?php  echo $p3->eo; ?>" readonly>
		</div>
		<div class="form-group col-sm-1">
			<input type="hidden" name="id1" class="form-control" value="<?php echo $id; ?>">
			<input type="text" class="form-control" value="<?php  echo $p3->neo; ?>" readonly>
		</div>
	</div>
	
	<div class="form-row">
		<div class="form-group col-sm-2">
			<b>Price</b>
		</div>
		<div class="form-group col-sm-2">
			<input type="number" class="form-control" value="<?php  echo $p3->tp; ?>" readonly>
		</div>
		<div class="form-group col-sm-1">
			<input type="text" class="form-control" value="<?php  echo $p3->ntp; ?>" readonly>
		</div>
	</div>
	
	<div class="form-row">
		<div class="form-group col-sm-2">
			<b>Subject</b>
		</div>
		<div class="form-group col-sm-4">
			<?php  echo $p3->subyek; ?>
		</div>
	</div>
	
	<div class="form-row">
		<div class="form-group col-sm-2">
			<b>Messages</b>
		</div>
		<div class="form-group col-sm-4">
			<?php  echo $p3->spec; ?>
			<input type="hidden" id="id_br" value="<?php  echo $p3->id; ?>">
		</div>
	</div>
	
	<div class="form-row">
		<div class="form-group col-sm-2">
			<b>File</b>
		</div>
		<div class="form-group col-sm-4">
			<a download href="{{asset('uploads/buy_request/'.$p3->files)}}"><?php  echo $p3->files; ?></a>
		</div>
	</div>
	
	<?php } ?>
	<?php } ?>
	
	
	<div class="form-row">
		<div class="form-group col-sm-2">
			<b>Tracking of Type</b>
		</div>
		<div class="form-group col-sm-3">
			<select <?php if($p2->status_transaksi == 1){ echo "readonly"; }?> class="form-control" name="type_tracking" required>
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
		<div class="form-group col-sm-2">
			<b>No Tracking</b>
		</div>
		<div class="form-group col-sm-3">
			<input class="form-control" type="text" id="no_track" name="no_track" value="<?php echo $p2->no_tracking; ?>" <?php if($p2->status_transaksi == 1){ echo "readonly"; }?> required>
			<input class="form-control" type="hidden" id="tipekirim" name="tipekirim" value="0" required>
			<input class="form-control" type="hidden" id="id_transaksi" name="id_transaksi" value="<?php echo $p2->id_transaksi;?>" required>
		</div>
	</div>
	
	<div class="form-row">
		
		<div class="form-group col-sm-5">
		
			
			<br>
			<?php if($p2->status_transaksi != 1){ ?>
			<button style="width:33%;" onclick="getyou(1)" type="submit" class="btn btn-info">Submit</button>
			<button style="width:30%;" onclick="getyou(0)" type="submit" class="btn btn-warning"><font color="white">Draft</font></button>
			<?php } ?>
			<a style="width:33%;" href="{{url('trx_list')}}" class="btn btn-danger">Cancel</a></center>
		</div>
	</div>
	</div>

</div>

<?php } ?>
</form>

<script>
function getyou(x){
	$('#tipekirim').val(x);
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
