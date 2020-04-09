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
						<div class="table-responsive">


							<style>
								body {font-family: Arial;}

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

								.img_upl {
									/*border: 1px solid #6fccdd;*/
									border: none;
									background: transparent;
								}
							</style>


							<div class="tab">
								<?php if($ida == 2){ ?><button class="tablinks" onclick="openCity(event, 'Tokyo')"><font size="3px">Document</font></button> <?php } ?>
							</div>
							<form class="form-horizontal" method="POST" action="{{ url('simpan_profil_docb') }}" enctype="multipart/form-data">
								{{ csrf_field() }}

								<input type="hidden" name="id_role" value="<?php echo $ida; ?>">
								<input type="hidden" name="id_user" value="<?php echo $idb; ?>">

								<div id="Tokyo" class="tabcontent" style="display:block;">
									<div class="box-body">
										<?php
										$ca = DB::select("select * from itdp_company_users where id='$idb' limit 1");
										foreach($ca as $rhj){
										if($ida == 2){
										//echo "jual";
										$ceq = DB::select("select b.*, a.id as id_user, a.foto_profil from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and a.id='$idb' limit 1");
										}else{
										$ceq = DB::select("select b.*, a.id as id_user, a.foto_profil from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='$idb' limit 1");
										}
										?>
										<?php foreach($ceq as $ryu){ ?>
										<input type="hidden" name="idu" value="<?php echo $ryu->id; ?>">

											@if ($message = Session::get('warning'))
												<div class="alert alert-info text-center">
													<button type="button" class="close" data-dismiss="alert">×</button>
													<strong>{{ $message }}</strong>
												</div>
											@endif

{{--										<div class="form-row">--}}
{{--											<div class="form-group col-sm-4">--}}
{{--											</div>--}}
{{--											<div class="form-group col-sm-4">--}}
{{--												--}}
{{--											</div>--}}

{{--										</div>--}}
											<div class="form-row">
											<div class="form-group col-sm-4">
												<label><b><font color="red">(*)</font> NPWP</b></label>
											</div>
											<div class="form-group col-sm-4">
												<input type="text" placeholder="Number Only(without dot)" value="<?php echo $ryu->npwp; ?>" name="npwp" id="npwp" onkeyup="ceknpwp()" class="form-control" aria-describedby="npwphelp">
												<small id="npwphelp">Diinput hanya karakter angka</small>
											</div>

											<div class="form-group col-sm-3 vld">
												@if($ryu->npwp != 'null')
													<font color="green">Valid</font>
												@else
													<font color="red">Tidak Valid</font><!-- <input type="text" readonly value="" placeholder="Name of NPWP" name="nanpwp" id="nanpwp" class="form-control" > -->
												@endif
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-sm-4">
												<label><b><font color="red">(*)</font> Dokumen NPWP</b></label>
											</div>
											<div class="form-group col-sm-4">
												<?php
												if(empty(Auth::user()->name)){  ?>
												<input type="file" name="npwpfile" id="npwpfile" class="form-control upload1">
												<?php if($ryu->uploadnpwp == null){
													echo "";
												}else { ?>
												<span>File Sebelumnya : <a href="{{ asset('eksportir/'.$ryu->uploadnpwp)}}"></a>
				 <?php echo $ryu->uploadnpwp; ?></span>
												<?php } ?>
												<?php } else{ ?>
												<span><?php if(empty($ryu->uploadnpwp) || $ryu->uploadnpwp == null){ echo "<font color='red'>No File</font>"; }else{ ?>

			  <a href="{{ asset('eksportir/'.$ryu->uploadnpwp)}}"><?php echo $ryu->uploadnpwp; ?></a>
			  <?php } ?>
			  </span>
												<?php } ?>


											</div>


										</div>
										<div class="form-row">
											<div class="form-group col-sm-4">
												<label><b>Tanda Daftar Perusahaan / Nomor Induk Berusaha</b></label>
											</div>
											<div class="form-group col-sm-4">
												<input type="text" value="<?php echo $ryu->tdp; ?>" name="tanda_daftar" id="tanda_daftar" class="form-control" >
											</div>


										</div>
										<div class="form-row">
											<div class="form-group col-sm-4">
												<label><b> Dokumen Tanda Daftar Perusahaan</b></label>
											</div>
											<div class="form-group col-sm-4">

												<?php
												if(empty(Auth::user()->name)){  ?>
												<input type="file" name="tdpfile" id="tdpfile" class="form-control upload1">
												<?php if($ryu->uploadtdp == null){
													echo "";
												}else { ?>
												<span>File Sebelumnya : <a href="{{ asset('eksportir/'.$ryu->uploadtdp)}}"></a><?php echo $ryu->uploadtdp; ?></span>
												<?php } ?>
												<?php } else{ ?>
												<span><?php if(empty($ryu->uploadtdp) || $ryu->uploadtdp == null){ echo "<font color='red'>No File</font>"; }else{ ?>

			  <a href="{{ asset('eksportir/'.$ryu->uploadtdp)}}"><?php echo $ryu->uploadtdp; ?></a>
			  <?php } ?>
			  </span>
												<?php } ?>

											</div>


										</div>
										<div class="form-row">
											<div class="form-group col-sm-4">
												<label><b>Surat Izin Usaha Perdagangan</b></label>
											</div>
											<div class="form-group col-sm-4">
												<input type="text" value="<?php echo $ryu->siup; ?>" name="siup" id="siup" class="form-control" >

											</div>


										</div>
										<div class="form-row">
											<div class="form-group col-sm-4">
												<label><b> Dokumen Surat Izin Usaha Perdagangan</b></label>
											</div>
											<div class="form-group col-sm-4">

												<?php
												if(empty(Auth::user()->name)){  ?>
												<input type="file" name="siupfile" id="siupfile" class="form-control upload1">
												<?php if($ryu->uploadsiup == null){
													echo "";
												}else { ?>
												<span>File Sebelumnya : <a href="{{ asset('eksportir/'.$ryu->uploadsiup)}}"></a><?php echo $ryu->uploadsiup; ?></span>
												<?php } ?>
												<?php } else{ ?>
												<span><?php if(empty($ryu->uploadsiup) || $ryu->uploadsiup == null){ echo "<font color='red'>No File</font>"; }else{ ?>

			  <a href="{{ asset('eksportir/'.$ryu->uploadsiup)}}"><?php echo $ryu->uploadsiup; ?></a>
			  <?php } ?>
			  </span>
												<?php } ?>

											</div>


										</div>
										<div class="form-row">
											<div class="form-group col-sm-4">
												<label><b>Surat Izin Tanda Usaha</b></label>
											</div>
											<div class="form-group col-sm-4">
												<input type="text" value="<?php echo $ryu->upduserid; ?>" name="situ" id="situ" class="form-control" >
											</div>


										</div>
										<div class="form-row">
											<div class="form-group col-sm-4">
												<label><b>Scoope of Business</b></label>
											</div>
											<div class="form-group col-sm-4">
												<select name="scoope" id="scoope" class="form-control" onchange="Scoope(this)">
													<option>-</option>
												<?php
													$sob = DB::select("select * from eks_business_size");
													foreach($sob as $val){
												?>
													<option <?php if($ryu->id_eks_business_size == $val->id){ echo "selected"; } ?> value="<?php echo $val->id; ?>"><?php echo $val->nmsize; ?></option>
													<?php } ?>
												</select>

											</div>
											<div class="form-group col-sm-4">
													<input type="text" id="scoope_in" class="form-control" readonly value="{{$ryu->id_eks_business_size == null ? "" : SOB($ryu->id_eks_business_size)}}">
											</div>


										</div>
										<div class="form-row">
											<div class="form-group col-sm-4">
												<label><b>Type of Business</b></label>
											</div>
											<div class="form-group col-sm-4">
												<select name="tob" id="tob" class="form-control" onchange="TOB(this)">
													<option>-</option>
													<?php
													$tob = DB::select("select * from eks_business_role");
													foreach($tob as $val){
													?>
													<option <?php if($ryu->id_business_role_id == $val->id){ echo "selected"; } ?> value="<?php echo $val->id; ?>"><?php echo $val->nmtype; ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="form-group col-sm-4">
												<input type="text" id="tob_in" class="form-control" readonly value="{{$ryu->id_business_role_id == null ? "" : TOB($ryu->id_business_role_id)}}">
											</div>


										</div>
										<div class="form-row">
											<div class="form-group col-sm-4">
												<label><b>Employee</b></label>
											</div>
											<div class="form-group col-sm-4">
												<input type="text" value="<?php echo $ryu->employe; ?>" name="employee" id="employee" class="form-control" >
											</div>


										</div>
										<div class="form-row">
											<div class="form-group col-sm-4">
												<label><b>
														<?php
														if(empty(Auth::user()->name)){ echo "Document"; }else{ echo "File Upload from Exporter"; } ?>
													</b></label>
											</div>
											<div class="form-group col-sm-4">
												<?php
												if(empty(Auth::user()->name)){  ?>
												<input type="file" value="" name="doc" id="doc" class="form-control upload1">
												<?php if($ryu->doc == null){
													echo "";
												}else { ?>
													<span>File Sebelumnya : <a href="{{ asset('eksportir/'.$ryu->doc)}}"><b><?php echo $ryu->doc; ?></b></a></span>
												<?php } ?>
												<?php } else{ ?>
												<span><?php if(empty($ryu->doc) || $ryu->doc == null){ echo "<font color='red'>No File</font>"; }else{ ?>
													  <a href="{{ asset('eksportir/'.$ryu->doc)}}"><?php echo $ryu->doc; ?></a>
													  <?php } ?>
													  </span>
												<?php } ?>
											</div>


										</div>
										<div class="form-row">
											<div class="form-group col-sm-4">
												<label><b>Status Exporter</b></label>
											</div>
											<div class="form-group col-sm-4">
											<span class="labelverif">
												<?php if(empty(Auth::user()->name)){
												if($rhj->status==1){ echo "Verified"; }else if($rhj->status==2){ echo "Not Verified"; }else{ echo "-"; }
												?>
											</span>
												<input type="hidden" name="staim" id="staim" value="<?php echo $rhj->status; ?>">
												<?php
												}else{ ?>
												<select class="form-control" name="staim">
													<option <?php if($rhj->status == 0){ echo "selected"; } ?> value="0">-- Choose Status --</option>
													<option <?php if($rhj->status == 1){ echo "selected"; } ?> value="1">Verified</option>
													<option <?php if($rhj->status == 2){ echo "selected"; } ?> value="2">Not Verified</option>
												</select>
											<?php } ?>
											<!--
			<select class="form-control" name="staim">
			<option <?php if($ryu->status == 0){ echo "selected"; } ?> value="0">-- Pilih Status --</option>
			<option <?php if($ryu->status == 1){ echo "selected"; } ?> value="1">Verified</option>
			<option <?php if($ryu->status == 2){ echo "selected"; } ?> value="0">Not Verified</option>
			</select> -->
											</div>


										</div>

										{{--penutup foreach ryu--}}
										<?php } ?>
										{{--penutup foreach rhj--}}
										<?php } ?>
									</div>
								</div>
								<br>
								<div align="right">
									<?php if(empty(Auth::user()->name)){ }else{ ?>
									<a href="{{ url('verifyuser') }}" class="btn btn-md btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
									<?php } ?>
									<button class="btn btn-md btn-primary"><i class="fa fa-save"></i> Save</button>
								</div>
							</form>
							<script>
								function ceknpwp(){

									var inputnpwp = $("#npwp").val();
									var jumlahkarakter = inputnpwp.length;
									// alert('1234567');
									if(jumlahkarakter == 15){
										$.get('{{url('/ceknpwp')}}',{id:inputnpwp},function(data){
											json = JSON.parse(data);
											console.log('metro');
											console.log(json.nama);
											console.log(json.status);
											if(json.status == "VALID"){
												$('.vld').html("<font color='green'>Valid</font>");
												$('.labelverif').html("Verified");
												alert("NPWP terdaftar dengan nama "+ json.nama);
												$('#staim').val(1);
											}else{
												alert("NPWP Tidak Benar, Silahkan Hubungin Kantor Pajak Terdekat");
												$('.vld').html("<font color='red'>Not Valid</font>");
												$("#npwp").val('');
												$('#staim').val(0);
												$('.labelverif').html("-");
											}
											//console.log(data.status);
											// alert(jumlahkarakter);

										})
									}else{
										$('.vld').html("<font color='red'>Not Valid</font>");
									}


								}
							</script>
							<script>
								$(document).ready(function () {
									$('.select2').select2();
									$("#img_1").click(function() {
										$("input[id='image_1']").click();
									});
									document.getElementById("image_1").addEventListener('change',handleFileSelect,false);
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

								function handleFileSelect(evt){
									var files = evt.target.files; // FileList object
									var idfile = evt.target.id; // FileList object

									// FileReader support
									if (FileReader && files && files.length) {
										var fr = new FileReader();
										fr.onload = function () {
											document.getElementById(idfile+"_ambil").src = fr.result;
											document.getElementById(idfile+"_ambil").style.width = "100%";
											document.getElementById(idfile+"_ambil").style.height = "100%";
										}
										fr.readAsDataURL(files[0]);
									}
								}
							</script>



						</div>
					</div>
				</div>

			</div>

		</div>
	</div>
</div>

<script>

	$('.upload1').on('change', function(evt){
		var size = this.files[0].size;
		if(size > 5000000){
		// if(size > 20000){
			$(this).val("");
			alert('image size must less than 5MB');
		}
		else{

		}
	})

	function Scoope(obj){
		csrf_token = '{{ csrf_token() }}';
		val = $(obj).val();
		$('#scoope_in').val('');
			$.post("{{ route('getscoope') }}", {'_token':csrf_token, 'id':val}, function(response){
				res = JSON.parse(response);
				$('#scoope_in').val(res.nmsize_ind);
			});
	}

	function TOB(obj){
		csrf_token = '{{ csrf_token() }}';
		val = $(obj).val();
		$('#tob_in').val('');
		$.post("{{ route('gettob') }}", {'_token':csrf_token, 'id':val}, function(response){
			res = JSON.parse(response);
			$('#tob_in').val(res.nmtype_ind);
		});
	}
</script>

@include('footer')
