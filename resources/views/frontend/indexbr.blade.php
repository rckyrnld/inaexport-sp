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
			<div class="form-row" style="font-size:12px;">
<div class="col-md-6">
   <div class="box-body">
   <br>
   <img height="10px" src="{{url('assets')}}/assets/images/07-Form-Request_01.png" alt="." >
  
  <table id="example1" border="0" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                               
                                </thead>
								<tbody>
								<?php 
								$pesan = DB::select("select * from csc_buying_request where by_role='3' and id_pembuat='".Auth::guard('eksmp')->user()->id."' order by id desc ");
								foreach($pesan as $ryu){
								?>
								<tr>
								<td><?php echo "<b>".strtoupper($ryu->subyek)."</b><br>";
								$cardata = DB::select("select nama_kategori_en from csc_product where id='".$ryu->id_csc_prod_cat."'");
				 foreach($cardata as $ct){
					 echo $ct->nama_kategori_en."<br>";
				 }
				 echo "Valid until ".$ryu->valid." days<br>";
				 echo $ryu->date;
								?></td>
								<td width="20%"><center>
								<?php if($ryu->status == 0 || $ryu->status == null){ ?>
								<br><a title="Broadcast" onclick="xy(<?php echo $ryu->id; ?>)" data-toggle="modal" data-target="#myModal" class="btn btn-warning"><font color="white"><i class="fa fa-wifi"></i></font></a><a title="Detail" href="{{ url('br_importir_detail/'.$ryu->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i></a>
								<?php }else if($ryu->status == 1 ){ ?>
								<br><a title="Detail" href="{{ url('br_importir_lc/'.$ryu->id) }}" class="btn btn-info"><i class="fa fa-comment"></i></a>
								<?php } else if($ryu->status == 4){ ?>
								<br><a title="Detail" href="{{ url('br_importir_lc/'.$ryu->id) }}" class="btn btn-info"><i class="fa fa-comment"></i></a>
								<?php } ?>
								</center></td>
								</tr>
								<?php } ?>
								
								</tbody>

                            </table>
	
	
	
  
	</div>

</div>
<div class="col-md-1">
</div>
<div class="col-md-5">
<div class="box-body">
<br>
<form class="form-horizontal" method="POST" action="{{ url('br_importir_save') }}" enctype="multipart/form-data">
           {{ csrf_field() }}
<div class="form-row">
		<div class="col-sm-12">
		<label><h5><b>@lang("login.forms.by1")</b></h5></label>
		</div></div>
<div class="form-row">
		<div class="col-sm-12">
		<label><b>@lang("login.forms.by2")</b></label>
		</div>
		<div class="form-group col-sm-8">
			<input type="text" style="color:black;" value="" name="subyek" id="subyek" class="form-control" required>
		</div>
		<div class="form-group col-sm-4">
			<select style="color:black;" class="form-control" name="valid" id="valid" required>
			<option value="">@lang("login.forms.by10")</option>
			<option value="1">Valid within 1 day</option>
			<option value="3">Valid within 3 day</option>
			<option value="5">Valid within 5 day</option>
			<option value="7">Valid within 7 day</option>
			<option value="14">Valid within 2 weak</option>
			<option value="30">Valid within 1 mount</option>
			</select>
		</div>
	</div>
	<div class="form-row">
		<div class="col-sm-12">
		<label><b>@lang("login.forms.by3")</b></label>
		</div>
		<div class="form-group col-sm-12">
			<?php 
			$ms1 = DB::select("select id,nama_kategori_en from csc_product order by nama_kategori_en asc");
			?>
			<select style="color:black;" class="form-control select2" name="category" id="category" onchange="t1()" required>
			<option value="">@lang("login.forms.by11")</option>
			<?php foreach($ms1 as $val1){ ?>
			<option value="<?php echo $val1->id; ?>"><?php echo $val1->nama_kategori_en; ?></option>
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
		<label><b>@lang("login.forms.by4")</b></label>
		</div>
		<div class="form-group col-sm-12">
			<textarea style="color:black;" value="" name="spec" id="spec" class="form-control" ></textarea>
		</div>
		
	</div>
	<div class="form-row">
		<div class="col-sm-6">
		<label><b>@lang("login.forms.by5")</b></label>
		</div>
		<div class="col-sm-6">
		<label><b>@lang("login.forms.by6")</b></label>
		</div>
		<div class="form-group col-sm-6">
			<div class="form-row">
		<div class="col-sm-7"><input style="color:black;" type="number" name="eo" id="eo" class="form-control"> </div>
		<div class="col-sm-5"> <select style="color:black;" class="form-control" name="neo" id="neo"><option value="">@lang("login.forms.by14")</option><option value="Pieces">Pieces</option></select></div>
		</div>
			
			
		</div>
		<div class="form-group col-sm-6">
				
			<div class="form-row">
		<div class="col-sm-7"><input style="color:black;" type="number" value="" name="tp" id="tp" class="form-control" ></div>
		<div class="col-sm-5"> <select style="color:black;" class="form-control" name="ntp" id="ntp"><option value="">@lang("login.forms.by14")</option><option value="IDR">IDR</option><option value="THB">THB</option><option value="USD">USD</option></select></div>
		</div>
		</div>
		
	</div>
<div class="form-row">
		<div class="col-sm-12">
		<label><b>@lang("login.forms.by7")</b></label>
		</div>
		<div class="form-group col-sm-6">
			<?php 
			$ms2 = DB::select("select id,country from mst_country order by country asc");
			?>
			<select style="color:black;" style="border-color: rgba(120, 130, 140, 0.5)!important;
    border-radius: 0.25rem!important;
    color: inherit!important;" class="form-control select2" name="country" id="country" required>
			<option value="">-- @lang("login.forms.by12") --</option>
			<?php foreach($ms2 as $val2){ ?>
			<option value="<?php echo $val2->id; ?>"><?php echo $val2->country; ?></option>
			<?php } ?>
			</select>
		</div>
		<div class="form-group col-sm-6">
			<input style="color:black;" type="text" value="" name="city" id="city" class="form-control" placeholder="@lang("login.forms.by13")">
		</div>
	</div>
<div class="form-row">
		<div class="col-sm-12">
		<label><b>@lang("login.forms.by8")</b></label>
		</div>
		<div class="form-group col-sm-12">
			<textarea style="color:black;" value="" name="ship" id="ship" class="form-control" ></textarea>
		</div>
		
	</div>
<div class="form-row">
		<div class="col-sm-12">
		<label><b>@lang("login.forms.by9")</b></label>
		</div>
		<div class="form-group col-sm-12">
			<input style="color:black;" type="file" value="" name="doc" id="doc" class="form-controlz" required>
		</div>
		
	</div>
<div class="form-row">
		<div class="col-sm-12">
		<button style="width:100%!important;" class="btn btn-md btn-success"><i class="fa fa-save"></i> @lang("login.btn4")</button>
		</div>
		
		
	</div>
</form>
</div>
</div>




</form>
 <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#2e899e; color:white;"> <h6>Broadcast Buying Request</h6>
          <button type="button" class="btn btn-danger" data-dismiss="modal">&times;</button>
         
        </div>
		<div id ="isibroadcast"></div>
        <!--<div class="modal-body">
          1
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> -->
      </div>
    </div>
  </div>

			<!--<a href="{{ url('br_importir_add') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add Buying Request</a><br><br> -->
		
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