@include('frontend.layouts.header')
<style>
/*
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
*/
</style>
<style type="text/css">
  .chat-container{
    width: 100%;
    background-color: white;
    border-radius: 30px;
  }

  .chat-header{
    width: 100%;
    height: 5%;
    background-color: #DDEFFD;
    border-radius: 30px 30px 0px 0px;
    padding: 2% 2% 2% 3%;
  }

  .chat-user{
    font-size: 15px;
    font-family: 'Verdana';
  }

  .chat-body{
    height: 500px;
    max-height: 500px;
    overflow-y: scroll;
    overflow-x: hidden;
    padding: 2%;
    font-size: 15px;
  }

  .chat-footer{
    width: 100%;
    height: 5%;
    border-top: 2px solid #87c4ee;
    border-radius: 0px 0px 30px 30px;
    padding: 1% 1% 1% 1%;
  }

  .chat-message{
    border: 1.5px solid #4088C6;
    height: 100%;
    width: 100%;
    border-radius: 10px;
    resize: none;
    padding: 1%;
    font-size: 15px;
  }

  .chat-me{
    background: #64abe4; 
    border-radius: 10px 0px 10px 10px;
    width: 400px;
    padding: 10px;
    color: white;
  }

  .chat-other{
    background: #DDEFFD;
    border-radius: 0px 10px 10px 10px;
    width: 400px;
    padding: 10px;
  }

  #uploading2{
    cursor: pointer;
    transition: 0.3s;
  }

  #uploading2:hover{
    opacity: 0.7;
  }

  #sendmessage{
    cursor: pointer;
    transition: 0.3s;
  }

  #sendmessage:hover{
    opacity: 0.7;
  }

  .chat-back:hover{
    opacity: 0.7;
  }

  button.closedmodal {
    padding: 0;
    background-color: transparent;
    border: 0;
    -webkit-appearance: none;
  }

  .closedmodal {
    float: right;
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1;
    color: #000;
    text-shadow: 0 1px 0 #fff;
    opacity: .5;
  }
  .modal-header .closedmodal {
      padding: 1rem;
      margin: -1rem -1rem -1rem auto;
  }

  .closedmodal:hover{
    color: #fff;
  }
</style>
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
<style>

  .table-striped > tbody > tr:nth-child(odd) {
    background-color: white!important;
    background-clip: padding-box!important;
}
.table-striped > tbody > tr:nth-child(even) {
    background-color: white!important;
    background-clip: padding-box!important;
}
.table-bordered td, .table-bordered th {
    border: transparent;
}

  </style>
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
                            <li>@lang("login.forms.br")</li>
                        </ul>
                    </div>
					
<?php 
$nyariek = DB::select("select * from csc_buying_request_join where id='".$idb."'");
foreach($nyariek as $ek1){ $id_eks = $ek1->id_eks; }
$nyariek2 = DB::select("select b.* from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and a.id='".$id_eks."'");
foreach($nyariek2 as $ek2){ $idu = $ek2->id; $company = $ek2->company; $addres = $ek2->addres; $city = $ek2->city;  }
//echo $company;die();
?>
			<div class="form-row" style="font-size:12px;">
 <div id="content-body" style="color: #ffffff" >
    <div class="py-2 w-100">
	
	
      <div class="" style="color:black;padding-left:10px; padding-right:10px; border-radius: 3px;">
	  <br>
	 

<?php 
								$pesan = DB::select("select * from csc_buying_request where id='".$id."' limit 1 ");
								foreach($pesan as $ryu){
									?>
<div class="form-row">
<div class="col-md-6">
   <div class="box-body">
   <br><br>
  
	<div class="form-row">
		<div class="col-sm-12">
		<label><b>Eksportir </b></label>
		</div>
		<div class="form-group col-sm-12">
		<input type="text" readonly class="form-control" value="<?php echo $company;?> <?php if(Cache::has('user-is-eksmp-' . $idu)){ ?>(Online)<?php }else{ ?>(Offline)<?php } ?>">
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
			<option <?php if($ryu->valid == "1"){ echo "selected"; }?> value="7">Valid within 1 day</option>
			<option <?php if($ryu->valid == "3"){ echo "selected"; }?> value="7">Valid within 3 day</option>
			<option <?php if($ryu->valid == "5"){ echo "selected"; }?> value="7">Valid within 5 day</option>
			<option <?php if($ryu->valid == "7"){ echo "selected"; }?> value="7">Valid within 7 day</option>
			<option <?php if($ryu->valid == "14"){ echo "selected"; }?> value="7">Valid within 2 week</option>
			<option <?php if($ryu->valid == "30"){ echo "selected"; }?> value="7">Valid within 1 month</option>
			</select>
		</div>
	</div>
	<div class="form-row">
		<div class="col-sm-12">
		<label><b>Category</b></label>
		</div>
		<div class="form-group col-sm-12">
			<?php 
			$cr = explode(',',$ryu->id_csc_prod);
				$hitung = count($cr);
				$semuacat = "";
				for($a = 0; $a < ($hitung - 1); $a++){
					$namaprod = DB::select("select * from csc_product where id='".$cr[$a]."' ");
					foreach($namaprod as $prod){ $napro = $prod->nama_kategori_en; }
					$semuacat = $semuacat."- ".$napro." ";
					echo "<input class='form-control' type='text' value='- ".$napro."' readonly><br>";
				}
				// echo $semuacat;
			?>
			<!--<textarea class="form-control"><?php echo $semuacat; ?></textarea> -->
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
		<label><b>Address Eksportir</b></label>
		</div>
		<div class="form-group col-sm-12">
		<textarea readonly class="form-control"><?php echo $addres." ,".$city;?></textarea>
			</div>
		
	</div>
<div class="form-row">
		<div class="col-sm-12">
		<label><b>Location of delivery</b></label>
		</div>
		<div class="form-group col-sm-6">
			<?php 
			$ms2 = DB::select("select id,country from mst_country order by country asc");
			?>
			<select disabled style="color:black;" style="border-color: rgba(120, 130, 140, 0.5)!important;
    border-radius: 0.25rem!important;
    color: inherit!important;" class="form-control select2" name="country" id="country">
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
			<a class="btn btn-warning" download href="{{ asset('uploads/buy_request/'.$ryu->files) }}"><i class="fa fa-download"></i> Download File</a>
		</div>
		
	</div>
	
	

</div>

</div>
</div>
<!-- 
<div class="form-row">
<div class="col-md-12">
   <div class="box-body">
   <br><br>
<div class="col-sm-12">
<div align="center"><br>
<center>
<div class="">
    <div class="row">
	
	
	<div class="col-sm-12">
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
                  
                </div>
			<br>
                <div class="panel-body" style="overflow-y: scroll;">
                    <ul class="chat" id="rchat" style="color:black!Important;">
					<?php 
					$qwr = DB::select("select * from csc_buying_request_chat where id_br='".$id."' and id_join='".$idb."'");
					foreach($qwr as $r){
					?>
					
					<?php if($r->id_pengirim == Auth::guard('eksmp')->user()->id){?>
						<li class="right clearfix"><span class="chat-img pull-right">
                            <img src="http://placehold.it/50/FA6F57/fff&text=ME" alt="User Avatar" class="img-circle" />
                        </span>
                            <div class="chat-body clearfix pull-right">
                                <div class="header">
                                    <strong class=" text-muted"><span class="pull-right primary-font"></span><b><?php echo $r->username_pengirim; ?>
									 
				  
				 
									</b></strong>
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
						<li class="left clearfix" align="left"><span class="chat-img pull-left">
                            <img src="http://placehold.it/50/55C1E7/fff&text=H" alt="User Avatar" class="img-circle" />
                        </span>
                            <div class="chat-body clearfix">
                                <div class="header">
									<strong class=" text-muted"><span class="pull-right primary-font"></span><b><?php echo $r->username_pengirim; ?>
									@if(Cache::has('user-is-eksmp-' . $r->id_pengirim))
    (<span class="text-success">Online</span>)
@else
    (<span class="text-secondary">Offline</span>)
@endif
									</b></strong>
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
                        <input style="color:black;" id="inputan" type="text" class="form-control input-sm" placeholder="Type your message here..." />
                        <span class="input-group-btn">
                            <a  class="btn btn-info" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-paperclip"></i></a>
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

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#2e899e; color:white;"> <h6>Upload Proof of Payment</h6>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
		<form id="formId" action="{{ url('uploadpop') }}" enctype="multipart/form-data" method="post">
		   {{ csrf_field() }}
        <div class="modal-body">
		<div class="form-row">
		<div class="col-sm-3">
		<label><b>File Upload</b></label>
		</div>
		<div class="form-group col-sm-7">
			 <input type="hidden" class="form-control" name="idq" id="idq" value="<?php echo $id; ?>">
			 <input type="hidden" class="form-control" name="idb" id="idb" value="<?php echo $idb; ?>">
			 <input type="hidden" class="form-control" name="idc" id="idc" value="<?php echo Auth::guard('eksmp')->user()->id; ?>">
			 <input type="hidden" class="form-control" name="idd" id="idd" value="<?php echo Auth::guard('eksmp')->user()->username; ?>">
			 <input type="hidden" class="form-control" name="ide" id="ide" value="<?php echo Auth::guard('eksmp')->user()->id_role; ?>">
			 <input type="file" class="form-control" name="filez" id="filez">
		</div>
		
	</div>
	<div class="form-row">
		<div class="col-sm-3">
		<label><b>Note</b></label>
		</div>
		<div class="form-group col-sm-7">
			 <textarea class="form-control" name="catatan"></textarea>
		</div>
		
	</div>
         
		  
        </div>
        <div class="modal-footer">
			<button type="submit" class="btn btn-success" ><font color="white">Upload</font></button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> 
		</form>
      </div>
    </div>
  </div>


</div>
</div>
</div>

</div>
</div>
</div>

-->


<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#2e899e; color:white;"> <h6>Upload Proof of Payment</h6>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
		<form id="formId" action="{{ url('uploadpop') }}" enctype="multipart/form-data" method="post">
		   {{ csrf_field() }}
        <div class="modal-body">
		<div class="form-row">
		<div class="col-sm-3">
		<label><b>File Upload</b></label>
		</div>
		<div class="form-group col-sm-7">
			 <input type="hidden" class="form-control" name="idq" id="idq" value="<?php echo $id; ?>">
			 <input type="hidden" class="form-control" name="idb" id="idb" value="<?php echo $idb; ?>">
			 <input type="hidden" class="form-control" name="idc" id="idc" value="<?php echo Auth::guard('eksmp')->user()->id; ?>">
			 <input type="hidden" class="form-control" name="idd" id="idd" value="<?php echo Auth::guard('eksmp')->user()->username; ?>">
			 <input type="hidden" class="form-control" name="ide" id="ide" value="<?php echo Auth::guard('eksmp')->user()->id_role; ?>">
			 <input type="file" class="form-control" name="filez" id="filez">
		</div>
		
	</div>
	<div class="form-row">
		<div class="col-sm-3">
		<label><b>Note</b></label>
		</div>
		<div class="form-group col-sm-7">
			 <textarea class="form-control" name="catatan"></textarea>
		</div>
		
	</div>
         
		  
        </div>
        <div class="modal-footer">
			<button type="submit" class="btn btn-success" ><font color="white">Upload</font></button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> 
		</form>
      </div>
    </div>
  </div>








<div class="col-sm-12">
<div align="right">
<a href="{{ url('br_importir_lc/'.$id) }}" class="btn btn-md btn-danger"><i class="fa fa-arrow-left"></i> Back</a>


</div>
</div> 



								<?php } ?>

<?php $quertreject = DB::select("select * from mst_template_reject order by id asc"); ?>
<script type="text/javascript">
  $(function () {
   $('#example1').DataTable({
     "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    });
	
	$('#example2').DataTable({
     "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    });
	
	$('#yahoo').DataTable({
     
    });

  $('.select2').select2();
 });
 </script>
<script type="text/javascript">
    $(function () {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('getcsc') }}",
            columns: [
                {data: 'row', name: 'row'},
                {data: 'f1', name: 'f1'},
                {data: 'f2', name: 'f2'},
                {data: 'f3', name: 'f3'},
                {data: 'f4', name: 'f4'},
                {
					data: 'f6', name: 'f6', orderable: false, searchable: false
				},
				{
					data: 'f7', name: 'f7', orderable: false, searchable: false
				},
                {
                    data: 'action', name: 'action', orderable: false, searchable: false
                }]
        });
    });
</script>
<script>
/*$('#formId' ).submit(
    function( e ) {
        $.ajax( {
            url: '{{URL::to("uploadpop")}}',
            type: 'POST',
            data: new FormData( this ),
            processData: false,
            contentType: false,
            success: function(result){
                console.log(result);
                //$("#div1").html(str);
            }
        } );
        e.preventDefault();
    } 
); */

function kirimchat(){
	var a= $('#inputan').val();
	var b= <?php echo $id; ?>;
	var c = 3;
	var d = <?php echo Auth::guard('eksmp')->user()->id;?>;
	var e = '<?php echo Auth::guard('eksmp')->user()->username;?>';
	var f= <?php echo $idb; ?>;
	var token = $('meta[name="csrf-token"]').attr('content');
	if(a == null || a == ""){
			alert("Write Something !");
	}else{
		$.get('{{URL::to("simpanchatbr/")}}/a/'+b+'/'+c+'/'+d+'/'+e+'/'+f,{a:a,_token:token},function(data){
			
		 });
	//$('#rchat').append('<li class="right clearfix"><span class="chat-img pull-right"><img src="http://placehold.it/50/FA6F57/fff&text=ME" alt="User Avatar" class="img-circle" /></span><div class="chat-body clearfix pull-right"><div class="header"><strong class=" text-muted"><span class="pull-right primary-font"></span><b><?php echo Auth::guard('eksmp')->user()->username;?></b></strong><small class="glyphicon glyphicon-time"> (<?php echo date('Y-m-d H:m:s'); ?>)</small></div><p>'+ a +'</p></div></li>');
	$('#inputan').val('');
	
	x = <?php echo $id; ?>;
	y = <?php echo $idb; ?>;
	$.get('{{URL::to("refreshchat/")}}/'+x+'/'+y,{_token:token},function(data){
		$('#rchat').html(data)
		 });
	
	}
	
}
function rfr(){
	a = <?php echo $id; ?>;
	b = <?php echo $idb; ?>;
	var token = $('meta[name="csrf-token"]').attr('content');
	$.get('{{URL::to("refreshchat/")}}/'+a+'/'+b,{_token:token},function(data){
		$('#rchat').html(data)
		 });
	//$('#rchat').html('Kosong')
}
</script>
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
  

			<!-- <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#2e899e; color:white;"> <h6>Broadcast Buying Request</h6>
          <button type="button" class="btn btn-danger" data-dismiss="modal">&times;</button>
         
        </div>
		<div id ="isibroadcast"></div>
        
      </div>
    </div>
  </div> -->

			<!--<a href="{{ url('br_importir_add') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add Buying Request</a><br><br> -->
		
            </div>
                   
            </div>
        </div>
    </section>
	
	<div class="product_details mt-20" style="background-color: #1A70BB; margin-bottom: 0px !important; margin-top: 0px; font-size: 14px;">
          <div class="container">
            <br><br>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                  <div class="chat-container">
                    <div class="chat-header">
                      <div class="row">
                        <div class="col-md-1">
                          <br>
                          <a href="{{url('/front_end/history')}}" style="width: 100%; height: 100%;" class="chat-back">
                            <i class="fa fa-arrow-left" aria-hidden="true" style="color: #1A70BB; font-size: 40px;"></i>
                          </a>
                        </div>
                        <div class="col-md-1" style="padding-left: 0px;">
                          <img src="{{asset('front/assets/icon/user.png')}}" alt="" width="100%" />
                        </div>
                        <div class="col-md-4" style="padding-left: 0px;">
                          <span class="chat-user" style=""><b>Chat</b></span>
                          <br>
                          <span class="chat-user" style="text-transform: capitalize;"><b>{{$company}}</b>&nbsp;&nbsp;<img src="{{asset('front/assets/icon/icon-exportir.png')}}" alt="" /></span>
						<br>
						<?php 
						$messages = DB::select("select * from csc_buying_request_chat where id_br='".$id."' and id_join='".$idb."'");
						$ry = 40055; ?>
						@if(Cache::has('user-is-eksmp-' . $idu))
    <span class="text-success">Online</span>
@else
    <span class="text-secondary">Offline</span>
@endif
						</div>
                      </div>
                    </div>
                    <div class="chat-body">
                      <div class="row" id="rchat">
                        <?php
                          $datenya = NULL;
                        ?>
                        @foreach($messages as $msg)
                          @if($msg->id_pengirim == Auth::guard('eksmp')->user()->id)
                          <div class="col-md-12">
                            @if($datenya == NULL)
                                <?php
                                   $datenya = date('d-m-Y', strtotime($msg->tanggal));
										$pecah = (explode("-",$datenya));
									$hari = $pecah[0];
									if($pecah[1] == 1){ $bulan = "Januari";}else if($pecah[1] == 2){ $bulan = "Februari";}else if($pecah[1] == 3){ $bulan = "Maret";}
									else if($pecah[1] == 4){ $bulan = "April";}else if($pecah[1] == 5){ $bulan = "Mei";}else if($pecah[1] == 6){ $bulan = "Juni";}
									else if($pecah[1] == 7){ $bulan = "Juli";}else if($pecah[1] == 8){ $bulan = "Agustus";}else if($pecah[1] == 9){ $bulan = "September";}
									else if($pecah[1] == 10){ $bulan = "Oktober";}else if($pecah[1] == 11){ $bulan = "November";}else if($pecah[1] == 12){ $bulan = "Desember";}
									else { $bulan=""; }
									$thnn = $pecah[2];
									 $fix = $bulan." ".$hari.",".$thnn;
                                ?>
                                <center>
                                    <i>
										{{$fix}}
                                    </i>
                                </center><br>
                            @else
                                @if($datenya != date('d-m-Y', strtotime($msg->tanggal)))
                                    <?php
                                        $datenya = date('d-m-Y', strtotime($msg->tanggal));
										$pecah = (explode("-",$datenya));
									$hari = $pecah[0];
									if($pecah[1] == 1){ $bulan = "Januari";}else if($pecah[1] == 2){ $bulan = "Februari";}else if($pecah[1] == 3){ $bulan = "Maret";}
									else if($pecah[1] == 4){ $bulan = "April";}else if($pecah[1] == 5){ $bulan = "Mei";}else if($pecah[1] == 6){ $bulan = "Juni";}
									else if($pecah[1] == 7){ $bulan = "Juli";}else if($pecah[1] == 8){ $bulan = "Agustus";}else if($pecah[1] == 9){ $bulan = "September";}
									else if($pecah[1] == 10){ $bulan = "Oktober";}else if($pecah[1] == 11){ $bulan = "November";}else if($pecah[1] == 12){ $bulan = "Desember";}
									else { $bulan=""; }
									$thnn = $pecah[2];
									 $fix = $bulan." ".$hari.",".$thnn;
                                    ?>
                                    <center>
                                        <i>
                                           {{$fix}}
                                        </i>
                                    </center><br>
                                @endif
                            @endif
                            <div class="row pull-right">
                              <div class="col-md-10">
                                <label class="label chat-me">
                                    @if($msg->files == NULL)
                                        {{$msg->pesan}}<br>
                                    @else
                                        <a href="{{ url('/').'/uploads/pop/' }}/{{ $msg->files }}" target="_blank" class="atag" style="color: white;">{{$msg->files}}</a><br><br>
                                        {{$msg->pesan}}<br>
                                    @endif
                                    <span style="float: right;">{{date('H:i',strtotime($msg->tanggal))}}</span>
                                </label>
                              </div>
                            </div>
                          </div><br>
                          @else
                          <!-- <div class="col-md-1"></div> -->
                          <div class="col-md-12">
                            @if($datenya == NULL)
                                <?php
                                    $datenya = date('d-m-Y', strtotime($msg->tanggal));
									$pecah = (explode("-",$datenya));
									$hari = $pecah[0];
									if($pecah[1] == 1){ $bulan = "Januari";}else if($pecah[1] == 2){ $bulan = "Februari";}else if($pecah[1] == 3){ $bulan = "Maret";}
									else if($pecah[1] == 4){ $bulan = "April";}else if($pecah[1] == 5){ $bulan = "Mei";}else if($pecah[1] == 6){ $bulan = "Juni";}
									else if($pecah[1] == 7){ $bulan = "Juli";}else if($pecah[1] == 8){ $bulan = "Agustus";}else if($pecah[1] == 9){ $bulan = "September";}
									else if($pecah[1] == 10){ $bulan = "Oktober";}else if($pecah[1] == 11){ $bulan = "November";}else if($pecah[1] == 12){ $bulan = "Desember";}
									else { $bulan=""; }
									$thnn = $pecah[2];
									 $fix = $bulan." ".$hari.",".$thnn;
									
                                ?>
                                <center>
                                    <i>
                                        {{$fix}}
                                    </i>
                                </center><br>
                            @else
                                @if($datenya != date('d-m-Y', strtotime($msg->tanggal)))
                                    <?php
                                        $datenya = date('d-m-Y', strtotime($msg->tanggal));
										$pecah = (explode("-",$datenya));
									$hari = $pecah[0];
									if($pecah[1] == 1){ $bulan = "Januari";}else if($pecah[1] == 2){ $bulan = "Februari";}else if($pecah[1] == 3){ $bulan = "Maret";}
									else if($pecah[1] == 4){ $bulan = "April";}else if($pecah[1] == 5){ $bulan = "Mei";}else if($pecah[1] == 6){ $bulan = "Juni";}
									else if($pecah[1] == 7){ $bulan = "Juli";}else if($pecah[1] == 8){ $bulan = "Agustus";}else if($pecah[1] == 9){ $bulan = "September";}
									else if($pecah[1] == 10){ $bulan = "Oktober";}else if($pecah[1] == 11){ $bulan = "November";}else if($pecah[1] == 12){ $bulan = "Desember";}
									else { $bulan=""; }
									$thnn = $pecah[2];
									 $fix = $bulan." ".$hari.",".$thnn;
                                    ?>
                                    <center>
                                        <i>
                                            {{$fix}}
                                        </i>
                                    </center><br>
                                @endif
                            @endif
                            <div class="row">
                              <div class="col-md-10">
                                <label class="label chat-other">
                                    @if($msg->files == NULL)
                                        {{$msg->pesan}}<br>
                                    @else
                                        <a href="{{ url('/').'/uploads/pop/' }}/{{ $msg->files }}" target="_blank" class="atag" style="color: white;">{{$msg->files}}</a><br><br>
                                        {{$msg->pesan}}<br>
                                    @endif
                                    <span style="color: #555; float: right;">{{date('H:i',strtotime($msg->tanggal))}}</span>
                                </label>
                              </div>
                            </div>
                          </div><br>
                          <!-- <div class="col-md-1"></div> -->
                          @endif
                        @endforeach
                      </div>
                    </div>
                    <div class="chat-footer">
                      <div class="row">
                        <div class="col-md-1">
                            <a  class="" data-toggle="modal" data-target="#myModal">
                                <img src="{{asset('front/assets/icon/plus-circle.png')}}" alt="" width="100%" id="" />
								</a>
                            
                          </form>
                        </div>
                        <div class="col-md-10" style="padding-left: 0px;">
                          <textarea id="inputan" rows="2" class="chat-message"></textarea>
                        </div>
						
                        <div class="col-md-1" style="padding-left: 0px;">
                          <a onclick="kirimchat()" class="" id="btn-chat"><img src="{{asset('front/assets/icon/send-message.png')}}" alt="" width="70%" id="sendmessage" /></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <br><br>
          </div>
      </div>
   <br><br><br>
    <!--product area end-->

@include('frontend.layouts.footer')
<?php $quertreject = DB::select("select * from mst_template_reject order by id asc"); ?>
<script type="text/javascript">
	$(document).ready(function() {
    $('#example').DataTable();
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