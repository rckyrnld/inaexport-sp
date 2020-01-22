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
.link-company{color: black;} .link-company:hover{text-decoration: none;color: blue;}
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
<div class="col-md-12">
 <?php 
	   if(!empty(Auth::guard('eksmp')->user()->status)){
	   if (Auth::guard('eksmp')->user()->status == 1) {
	   ?>
	   <h5><center><?php echo $pageTitle; ?></center></h5>
	   <br><br>
	   <a href="{{ url('br_importir') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a><br><br>
		<table id="example1" border="0" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
									<th width="5%">No</th>
									<th><center>Company Name</center></th>
									<th><center>Address</center></th>
									<th><center>Email</center></th>
									<th><center>Status</center></th>
									<th><center>Action</center></th>
                                </thead>
								<tbody>
								<?php 
								$pesan = DB::select("select a.*,b.*,c.*,a.email as oemail,b.id as idb,a.id as id_user from itdp_company_users a, csc_buying_request_join b, itdp_profil_eks c where a.id=b.id_eks and a.id_profil = c.id and id_br='".$id."'");
								$na = 1;
								foreach($pesan as $ryu){
								?>
								<tr>
								<td><?php echo $na; ?></td>
								<td><a class="link-company" href="{{url('front_end/list_perusahaan/view', $ryu->id_user)}}-{{$ryu->company}}" target="_blank"><?php echo $ryu->company; ?></a></td>
								<td><?php echo $ryu->addres." ,".$ryu->city; ?></td>
								<td><?php echo $ryu->oemail; ?></td>
								<td><center>
								<?php if($ryu->status_join == null){echo "pending";}else if($ryu->status_join == "1"){ echo "Menunggu Verifikasi Importir"; }else if($ryu->status_join == "2"){ echo "Negosiation"; }
									else if($ryu->status_join == "4"){ echo "Deal"; }else{ echo "-"; }?>
								</center></td>
								<td><center>
								<?php if($ryu->status_join == 1){ ?>
								<a href="{{url('br_konfirm/'.$ryu->idb.'/'.$id)}}" class="btn btn-success" title="Verify"><i class="fa fa-check"></i></a>
								<?php }else if($ryu->status_join == 2){ ?>
								<a href="{{url('br_importir_chat/'.$id.'/'.$ryu->idb)}}" class="btn btn-info" title="Chat"><i class="fa fa-comment"></i></a>
								<?php }else if($ryu->status_join == 4){ ?>
								<a href="{{url('br_importir_chat/'.$id.'/'.$ryu->idb)}}" class="btn btn-success" title="View"><i class="fa fa-list"></i></a>
								<?php } ?>
								</center></td>
								</tr>
								<?php  $na++; } ?>
								
								</tbody>

                            </table>
	   <?php } else { ?>
	   <h5><center>Pemberitahuan</center></h5>
	   <br><br>
	   <h6><center>" Akun anda belum diverifikasi oleh Admin / Perwakilan, Silahkan Lengkapi Terlebih Dahulu Profil Anda <br><br>Klik <a href="{{url('profil2/3/'.Auth::guard('eksmp')->user()->id)}}">Disini</a> Untuk Melengkapi Profil Anda !
	   <br><br>Lalu Tunggu Sampai Admin / Perwakilan Meng-Verifikasi Akun Anda ! "</center></h6>
	   <?php } } else { ?>
	   <h5><center>Pemberitahuan</center></h5>
	   <br><br>
	   <h6><center>" Halaman Ini Khusus Untuk User Importir "</center></h6>
	   <?php } ?>
					<br>
</div>
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