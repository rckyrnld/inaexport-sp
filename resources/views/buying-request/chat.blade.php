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



<?php 
$q1 = DB::select("select * from csc_buying_request_join where id='".$id."'");
foreach($q1 as $p){ $id_br = $p->id_br; $ij = $p->status_join;}
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
		<div class="form-group col-sm-6" align="right">
		<?php if($ij == 4){ ?>
		
		<?php }else{ ?>
		<a data-toggle="modal" data-target="#myModal" class="btn btn-warning"><font color="white">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-hand-o-right "></i> Deal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></a>
		<?php } ?>
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-sm-2">
			<b>Address</b>
		</div>
		<div class="form-group col-sm-4">
			<?php 
			if($p2->by_role == 1){
				
			}else if($p2->by_role == 4){
				
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
			<input type="hidden" id="id_br" value="<?php echo $id_br; ?>">
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
<center>
<div class="">
    <div class="row"><div class="col-sm-12">
        <div class="col-md-12" style="background-color: #1a7688;color:white;">
		<div class="row">
		<div class="col-sm-1">
		</div>
		<div class="col-sm-10">
		<br><h6><b>Chat</b></h6><br>
		</div>
		<div class="col-sm-1">
		<br>
		<a class="btn btn-info" onclick="rfr()">Refresh</a>
		</div>
		</div>
		</div>
        <div class="col-md-12" style="background-color: #def1f1;">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-comment"></span>
                   <!-- <div class="btn-group pull-right">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-chevron-down"></span>
                        </button>
                        <ul class="dropdown-menu slidedown">
                            <li><a href="http://www.jquery2dotnet.com"><span class="glyphicon glyphicon-refresh">
                            </span>Refresh</a></li>
                            <li><a href="http://www.jquery2dotnet.com"><span class="glyphicon glyphicon-ok-sign">
                            </span>Available</a></li>
                            <li><a href="http://www.jquery2dotnet.com"><span class="glyphicon glyphicon-remove">
                            </span>Busy</a></li>
                            <li><a href="http://www.jquery2dotnet.com"><span class="glyphicon glyphicon-time"></span>
                                Away</a></li>
                            <li class="divider"></li>
                            <li><a href="http://www.jquery2dotnet.com"><span class="glyphicon glyphicon-off"></span>
                                Sign Out</a></li>
                        </ul>
                    </div> -->
                </div>
			<br>
                <div class="panel-body" style="overflow-y: scroll;">
                    <ul class="chat" id="rchat">
					<?php 
					$qwr = DB::select("select * from csc_buying_request_chat where id_br='".$id_br."' and id_join='".$id."'");
					foreach($qwr as $r){
					?>
					
					<?php if($r->id_pengirim == Auth::guard('eksmp')->user()->id){?>
						<li class="right clearfix"><span class="chat-img pull-right">
                            <img src="http://placehold.it/50/FA6F57/fff&text=ME" alt="User Avatar" class="img-circle" />
                        </span>
                            <div class="chat-body clearfix pull-right">
                                <div class="header">
                                    <strong class=" text-muted"><span class="pull-right primary-font"></span><b><?php echo $r->username_pengirim; ?></b></strong>
									<small class="glyphicon glyphicon-time"> (<?php echo $r->tanggal; ?>)</small>
                                </div>
                                 <p>
                                    <?php echo $r->pesan; ?>
									
                                </p>
								<p>
								<?php if(empty($r->files)){}else{?>
									<br><a target="_BLANK" href="{{asset('uploads/pop/'.$r->files)}}"><font color="green"><?php echo $r->files; ?></font></a>
									<?php } ?>
								</p>
								
                            </div>
                        </li>
					<?php }else{ ?>
						<li class="left clearfix"><span class="chat-img pull-left">
                            <img src="http://placehold.it/50/55C1E7/fff&text=H" alt="User Avatar" class="img-circle" />
                        </span>
                            <div class="chat-body clearfix">
                                <div class="header">
									<strong class=" text-muted"><span class="pull-right primary-font"></span><b><?php echo $r->username_pengirim; ?></b></strong>
									<small class="glyphicon glyphicon-time"> (<?php echo $r->tanggal; ?>)</small>
                                </div>
                                 <p>
                                    <?php echo $r->pesan; ?>
									
                                </p>
								<p>
								<?php if(empty($r->files)){}else{?>
									<br><a target="_BLANK" href="{{asset('uploads/pop/'.$r->files)}}"><font color="green"><?php echo $r->files; ?></font></a>
									<?php } ?>
								</p>
								
                            </div>
                        </li>
					<?php } ?>
                        
                        
					<?php } ?>
                        
                    </ul>
                </div>
                <div class="panel-footer">
                    <div class="input-group">
                        <input id="inputan" type="text" class="form-control input-sm" placeholder="Type your message here..." />
                        <span class="input-group-btn">
                            <a onclick="kirimchat()" class="btn btn-warning" id="btn-chat">
                                <i class="fa fa-paper-plane"></i> Send</a>
                        </span>
                    </div>
                </div>
				<br>
            </div>
        </div>
    </div>
</div>
</center>
<div align="right"><br><br>
<a href="{{url('br_list')}}" class="btn btn-danger"><font color="white">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-left "></i> Kembali&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></a>
</div>
<!--
<a href="{{ url('br_save_join/'.$id) }}" class="btn btn-md btn-primary"><i class="fa fa-comment"></i> Chat</a>
<a href="{{ url('br_list') }}" class="btn btn-md btn-danger"><i class="fa fa-arrow-left"></i> Decline</a>
-->

</div>
</div>
</div>
<?php } ?>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#2e899e; color:white;"> <h6>Validation Deal</h6>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
		<!--<div id ="isibroadcast"></div> -->
        <div class="modal-body">
          What do you choose about Deal ?
        </div>
        <div class="modal-footer" style="color:white!important;">
			<a href="{{url('br_deal/'.$id.'/'.$id_br.'/'.Auth::guard('eksmp')->user()->id)}}" class="btn btn-warning"><font color="white">Deal</font></a>
			<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div> 
      </div>
    </div>
  </div>
<?php $quertreject = DB::select("select * from mst_template_reject order by id asc"); ?>
<script>
function kirimchat(){
	var a= $('#inputan').val();
	var b= $('#id_br').val();
	var c = 2;
	var d = <?php echo Auth::guard('eksmp')->user()->id;?>;
	var e = '<?php echo Auth::guard('eksmp')->user()->username;?>';
	var f = '<?php echo $id;?>';
	var token = $('meta[name="csrf-token"]').attr('content');
	if(a == null || a == ""){
			alert("Write Something !");
	}else{
		$.get('{{URL::to("simpanchatbr/")}}/a/'+b+'/'+c+'/'+d+'/'+e+'/'+f,{a:a,_token:token},function(data){
			
		 });
	$('#rchat').append('<li class="right clearfix"><span class="chat-img pull-right"><img src="http://placehold.it/50/FA6F57/fff&text=ME" alt="User Avatar" class="img-circle" /></span><div class="chat-body clearfix pull-right"><div class="header"><strong class=" text-muted"><span class="pull-right primary-font"></span><b><?php echo Auth::guard('eksmp')->user()->username;?></b></strong><small class="glyphicon glyphicon-time"> (<?php echo date('Y-m-d H:m:s'); ?>)</small></div><p>'+ a +'</p></div></li>');
	$('#inputan').val('');
	}
	
}
function rfr(){
	a = $('#id_br').val();
	b = <?php echo $id; ?>;
	var token = $('meta[name="csrf-token"]').attr('content');
	$.get('{{URL::to("refreshchat/")}}/'+a+'/'+b,{_token:token},function(data){
		$('#rchat').html(data)
		 });
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
  

                            
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@include('footer')
