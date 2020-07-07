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
                                body {
                                    font-family: Arial;
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


                            <form class="form-horizontal" method="POST" action="{{ url('simpan_profil2') }}"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <input type="hidden" name="id_role" value="<?php echo $ida; ?>">
                                <input type="hidden" name="id_user" value="<?php echo $idb; ?>">

                                <div class="form-row">
                                    <div class="col-md-7">
                                        <div class="box-body">
{{--                                            @if ($message = Session::get('success'))--}}
{{--                                                <div class="alert alert-success alert-block" style="text-align: center">--}}
{{--                                                    <button type="button" class="close" data-dismiss="alert">×</button>--}}
{{--                                                    <strong>{{ $message }}</strong>--}}
{{--                                                </div>--}}
{{--                                            @endif--}}
                                            <b>Account Information Buyer</b><br><br>
                                            <?php
                                            $ca = DB::select("select * from itdp_company_users where id='$idb' limit 1");
                                            foreach($ca as $rhj){
                                            ?>
                                            <!--<div class="form-row">
                                                <div class="form-group col-sm-4">
                                                    <label><b>Username</b></label>

                                                </div>
                                                <div class="form-group col-sm-8">
                                                    <input type="text" value="<?php echo $rhj->username; ?>"
                                                           name="username" id="username"
                                                           class="form-control">

                                                </div>


                                            </div> -->
											<input type="hidden" value="<?php echo $rhj->username; ?>"
                                                           name="username" id="username"
                                                           class="form-control">
                                            <div class="form-row">
                                                <div class="form-group col-sm-4">
                                                    <label><b>Email</b></label>

                                                </div>
                                                <div class="form-group col-sm-8">
                                                    <input type="email" value="<?php echo $rhj->email; ?>" name="email"
                                                           id="email"
                                                           class="form-control">

                                                </div>


                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-sm-4">
                                                    <label><b>Password</b></label>

                                                </div>
                                                <div class="form-group col-sm-8">
                                                    <input type="password" value="" name="password" id="password"
                                                           class="form-control" placeholder="##########">

                                                </div>


                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-sm-4">
                                                    <label><b>Re-Password</b></label>

                                                </div>
                                                <div class="form-group col-sm-8">
                                                    <input type="password" value="" name="repass" id="repass"
                                                           class="form-control" placeholder="##########">

                                                </div>


                                            </div>
                                            <?php } ?>
                                            <hr>
                                            <b>Information Company</b><br><br>
                                            <?php

                                            $ceq = DB::select("select b.* from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='$idb' limit 1");

                                            foreach($ceq as $ryu){
                                            ?>
                                            <input type="hidden" name="idu" value="<?php echo $ryu->id; ?>">
                                            <div class="form-row">
                                                <div class="form-group col-sm-4">
                                                    <label><b>Name of Company</b></label>
                                                </div>
                                                <div class="form-group col-sm-8">
                                                    <input type="text" value="<?php echo $ryu->company; ?>"
                                                           name="company" id="company" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-sm-4">
                                                    <label><b>Address</b></label>
                                                </div>
                                                <div class="form-group col-sm-8">
                                                    <textarea name="addres" id="addres"
                                                              class="form-control"><?php echo $ryu->addres; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-sm-4">
                                                    <label><b>City</b></label>
                                                </div>
                                                <div class="form-group col-sm-8">
                                                    <input type="text" value="<?php echo $ryu->city; ?>" name="city"
                                                           id="city" class="form-control">
                                                <!-- <select name="city" id="city" class="form-control select2" >
			<?php
                                                $qc = DB::select("select city from mst_city order by city asc");
                                                foreach($qc as $cq){
                                                ?>
                                                        <option <?php if ($cq->city == $ryu->city) {
                                                    echo "selected";
                                                } ?> value="<?php echo $cq->city; ?>"><?php echo $cq->city; ?></option>
				
			<?php } ?>
                                                        </select> -->
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-sm-4">
                                                    <label><b>Country</b></label>
                                                </div>
                                                <div class="form-group col-sm-8">
                                                    <select name="province" id="province" class="form-control select2">
                                                        <?php
                                                        $qc = DB::select("select id,country from mst_country order by country asc");
                                                        foreach($qc as $cq){
                                                        ?>
                                                        <option <?php if ($cq->id == $ryu->id_mst_country) {
                                                            echo "selected";
                                                        } ?> value="<?php echo $cq->id; ?>"><?php echo $cq->country; ?></option>

                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-sm-4">
                                                    <label><b>Zip Code</b></label>
                                                </div>
                                                <div class="form-group col-sm-8">
                                                    <input type="text" value="<?php echo $ryu->postcode; ?>"
                                                           name="postcode" id="postcode" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-sm-4">
                                                    <label><b>Fax</b></label>
                                                </div>
                                                <div class="form-group col-sm-8">
                                                    <input type="text" value="<?php echo $ryu->fax; ?>" name="fax"
                                                           id="fax" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-sm-4">
                                                    <label><b>Website</b></label>
                                                </div>
                                                <div class="form-group col-sm-8">
                                                    <input type="text" value="<?php echo $ryu->website; ?>"
                                                           name="website" id="website" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-sm-4">
                                                    <label><b>Phone</b></label>
                                                </div>
                                                <div class="form-group col-sm-8">
                                                    <input type="text" value="<?php echo $ryu->phone; ?>" name="phone"
                                                           id="phone" class="form-control">
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>

                                    </div>
                                    <div class="col-md-5">
                                        <div class="box-body">
                                            <br><br>
                                            <?php foreach($ca as $rhj){ ?>
                                            <div class="form-row">
                                                <div class="form-group col-sm-4">
                                                    <label><b>Logo</b></label>
                                                </div>
                                                <div class="form-group col-sm-8">
                                                    <?php if($rhj->foto_profil == null){ ?>
                                                    <center><img width="150px" height="150px"
                                                                 src="{{ asset('image/fotoprofil/nofoto.jpg') }}">
                                                    </center>
                                                    <?php }else{ ?>
                                                    <center><img width="150px" height="150px"
                                                                 src="{{ asset('uploads/Profile/Importir/'.$idb.'/'.$rhj->foto_profil) }}">
                                                    </center>
                                                    <?php } ?>
                                                    <br>
                                                    <input type="file" class="form-control upload1" name="foto_profil"
                                                           id="foto_profil">
                                                </div>
                                            </div>
											
											 <div class="form-row">
                                                <div class="form-group col-sm-4">
                                                    <label><b>Supporting Documents</b></label>
                                                </div>
                                                <div class="form-group col-sm-8">
                                                    <input type="file" name="filependukung"
                                                           id="filependukung" class="form-control upload1" >
                                                </div>
                                            </div>
											
                                            <div class="form-row">
                                                <div class="form-group col-sm-4">
                                                    <label><b>Status Buyer</b></label>
                                                </div>
                                                <div class="form-group col-sm-8">
                                                    <?php if(empty(Auth::user()->name)){
                                                    if ($rhj->status == 1) {
                                                        echo "Verified";
                                                    } else if ($rhj->status == 2) {
                                                        echo "Not Verified";
                                                    } else {
                                                        echo "-";
                                                    }
                                                    ?>
                                                    <input type="hidden" name="staim"
                                                           value="<?php echo $rhj->status; ?>">
                                                    <?php
                                                    }else{ ?>
                                                    <select class="form-control" id="staim" name="staim"
                                                            onchange="nv()">
                                                        <option <?php if ($rhj->status == 0) {
                                                            echo "selected";
                                                        } ?> value="0">-- Choose Status --
                                                        </option>
                                                        <option <?php if ($rhj->status == 1) {
                                                            echo "selected";
                                                        } ?> value="1">Verified
                                                        </option>
                                                        <option <?php if ($rhj->status == 2) {
                                                            echo "selected";
                                                        } ?> value="2">Not Verified
                                                        </option>
                                                    </select>
                                                    <?php } ?>
                                                </div>
											

                                            </div>
                                            <div id="sh1">
                                            </div>
                                            <div id="sh2">
                                            </div>
                                            <?php } ?>
                                        </div>

                                    </div>
                                </div>
								
								



                                <div align="right">
                                    <?php if(empty(Auth::user()->name)){
                                    }else{ ?>
                                    <a href="{{ url('verifyimportir') }}" class="btn btn-md btn-danger"><i
                                                class="fa fa-arrow-left"></i> Back</a>
                                    <?php } ?>
                                    <button class="btn btn-md btn-primary"><i class="fa fa-save"></i> Save</button>
                                </div>
				</form>
							<hr>	
		<br><h5><center>List Contact</center></h5><br><br>
		<?php if(empty(Auth::user()->name)){ ?>
			<a data-toggle="modal" data-target="#myModal"  class="btn btn-success"><font color="white"><i class="fa fa-plus"></i> Add Contact</font></a><br><br>
                                   <?php }else{ ?>
		
									<?php } ?>
		<table id="example1" class="table  table-bordered table-striped">
			      <thead class="bg-success text-white">
			          <tr>
			              <th width="50">No</th>
			              <th>Name</th>
			              <th>Email</th>
			              <th><center>Phone</center></th>
			              <th><center>Action</center></th>
			             
			          </tr>
					</thead>
					<tbody>
					<?php 
					$qr = DB::select("select * from itdp_contact_imp where id_user='".$idb."'");
					$nb = 1;
					foreach($qr as $rq){
					?>
					<tr style="color:black;">
						<td><?php echo $nb; ?></td>
						<td><?php echo $rq->name; ?></td>
						<td><?php echo $rq->email; ?></td>
						<td><?php echo $rq->phone; ?></td>
						<td><a href="{{url('verifyimportir')}}" class="btn btn-danger"><font color="white"><i class="fa fa-trash"></i> Hapus</a></a></td>
					</tr>
					<?php $nb++; } ?>
					</tbody>
					  </table>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#2e899e; color:white;"> <h6>Add Contact Importir</h6>
          <button type="button" class="btn btn-danger" data-dismiss="modal">&times;</button>
         
        </div>
		<form class="form-horizontal" method="POST" action="{{ url('simpan_kontak') }}"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}
		<div class="modal-body">
		 <div class="form-row">
                                                <div class="form-group col-sm-1">
												</div>
                                                <div class="form-group col-sm-2">
                                                    <label><b>Name</b></label>
                                                </div>
                                                <div class="form-group col-sm-5">
                                                    <input type="hidden" value="<?php echo $idb; ?>" name="idb" class="form-control">
                                                    <input type="text" value="" name="name" id="name" class="form-control">
                                                </div>
                                            </div>
			<div class="form-row">	
												<div class="form-group col-sm-1">
												</div>
                                                <div class="form-group col-sm-2">
                                                    <label><b>Email</b></label>
                                                </div>
                                                <div class="form-group col-sm-5">
                                                    <input type="text" value="" name="email" id="email" class="form-control">
                                                </div>
                                            </div>
			<div class="form-row">
												<div class="form-group col-sm-1">
												</div>
                                                <div class="form-group col-sm-2">
                                                    <label><b>Phone</b></label>
                                                </div>
                                                <div class="form-group col-sm-5">
                                                    <input type="text" value="" name="phone" id="phone" class="form-control">
                                                </div>
                                            </div>
          
        </div>
        <div class="modal-footer">
		
          <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Close</button>
		  <button class="btn btn-md btn-primary"><i class="fa fa-save"></i> Save</button>
        </div>
		</form>
      </div>
    </div>
  </div>
                            
                            <?php $quertreject = DB::select("select * from mst_template_reject order by id asc"); ?>
                            <script>
                                function nv() {
                                    var a = $('#staim').val();
                                    if (a == 2) {
                                        $('#sh1').html('<div class="form-row"><div class="form-group col-sm-4"><label><b>Alasan Reject</b></label></div><div class="form-group col-sm-8"><select onchange="ketv()" id="template_reject" name="template_reject" class="form-control"><option value="">-- Pilih Alasan Reject --</option><?php foreach($quertreject as $qr){ ?><option value="<?php echo $qr->id;?>"><?php echo $qr->nama_template;?></option><?php } ?></select></div></div>')
                                    } else {
                                        $('#sh1').html(' ');
                                        $('#sh2').html(' ');
                                    }
                                }

                                function ketv() {
                                    var a = $('#template_reject').val();
                                    if (a == 1) {
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
