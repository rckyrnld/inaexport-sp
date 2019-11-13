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
                            <li>@lang("login.forms.br")</li>
                        </ul>
                    </div>
			<div class="form-row" style="font-size:12px;">
			 <!--<img style="width:100%!important;" src="{{url('assets')}}/assets/images/07-Form-Request_01.png" alt="." >-->
  
  <table id="example1" border="0" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
								<th>Subyek</th>
								<th>Category</th>
								<th>Create at</th>
								<th>Valid Time</th>
								<th>Create By</th>
                                </thead>
								<tbody>
								<?php 
								$pesan = DB::select("select * from csc_buying_request order by id desc ");
								foreach($pesan as $ryu){
								?>
								<tr>
								<td><?php echo "<b>".strtoupper($ryu->subyek)."</b><br>";
								
				 
				 
								?></td>
				<td><?php $cardata = DB::select("select nama_kategori_en from csc_product where id='".$ryu->id_csc_prod_cat."'");
				 foreach($cardata as $ct){
					 echo $ct->nama_kategori_en."";
				 } ?></td>
				<td><?php echo $ryu->date; ?></td>
				<td><?php echo "Valid until ".$ryu->valid." days<br>"; ?></td>
				<td><?php if($ryu->by_role == 1){ echo "Admin"; }else if($ryu->by_role == 4){ echo "Perwakilan"; }else{ echo "Importir";
				} ?></td>
								<!--<td width="20%"><center>
								<?php if($ryu->status == 0 || $ryu->status == null){ ?>
								<br><a title="Broadcast" onclick="xy(<?php echo $ryu->id; ?>)" data-toggle="modal" data-target="#myModal" class="btn btn-warning"><font color="white"><i class="fa fa-wifi"></i></font></a><a title="Detail" href="{{ url('br_importir_detail/'.$ryu->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i></a>
								<?php }else if($ryu->status == 1 ){ ?>
								<br><a title="Detail" href="{{ url('br_importir_lc/'.$ryu->id) }}" class="btn btn-info"><i class="fa fa-comment"></i></a>
								<?php } else if($ryu->status == 4){ ?>
								<br><a title="Detail" href="{{ url('br_importir_lc/'.$ryu->id) }}" class="btn btn-info"><i class="fa fa-comment"></i></a>
								<?php } ?>
								</center></td> -->
								</tr>
								<?php } ?>
								
								</tbody>

                            </table>


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