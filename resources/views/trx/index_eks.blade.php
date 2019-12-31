@include('header')

<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> Selling Transaction</h5>
                </div>

                <div class="box-body bg-light">
                   
                    <div class="col-md-14">
                        
                        <div class="table-responsive">
						
                           <table id="example1" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>No</th>
									
									<th>
                                        <center>Origin</center>
                                    </th>
									<th>
                                        <center>Buyer</center>
                                    </th>
									<th>
                                        <center>Exporter</center>
                                    </th>
									
									 <th>
                                        <center>Type Tracking</center>
                                    </th>
									<th>
                                        <center>No Tracking</center>
                                    </th>
									<th>
                                        <center>Status</center>
                                    </th>
									<th width="18%">
                                        <center>Action</center>
                                    </th>
                                </tr>
                                </thead>
								<tbody>
								<?php $nt = 1; foreach($data as $ruu){ ?>
								<tr>
									<td><?php echo $nt; ?></td>
									
									<td><center><?php if($ruu->origin == 1){ echo "Inquiry"; }else if($ruu->origin == 2){ echo "Buying Request"; }?></center></td>
									<td><center><?php if($ruu->by_role == 1){ echo "Admin"; }else if($ruu->by_role == 4){ echo "Perwakilan"; }else{ 
									$usre = DB::select("select b.company,b.badanusaha from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='".$ruu->id_pembuat."'"); 
									foreach($usre as $imp){ 
									echo "Importir - ".$imp->badanusaha." ".$imp->company; 
									}
									} ?></center></td>
									<td><center><?php 
									if($ruu->id_eksportir == 0 || $ruu->id_eksportir == null){
										
									}else{
									$carieks = DB::select("select * from itdp_company_users where id='".$ruu->id_eksportir."'");
									foreach($carieks as $eks){ echo $eks->username; }
									} ?></center></td>
									
									
									<td><center><?php echo $ruu->type_tracking; ?></center></td>
									<td><center><?php echo $ruu->no_tracking; ?></center></td>
									<td><center><?php if($ruu->status_transaksi == 1){ echo "<font color='green'>Already Sent</font>"; }else{ echo "<font color='red'>On Process</font>"; } ?></center></td>
									
									<td><center>
									<?php if($ruu->status_transaksi == 1){ ?>
									<a href="{{ url('input_transaksi/'.$ruu->id_transaksi) }}" class="btn btn-info" title="View"><font color="white"><i class="fa fa-eye"></i></font></a>
									
									
									<?php }else { ?>
									<a href="{{ url('input_transaksi/'.$ruu->id_transaksi) }}" class="btn btn-success" title="Send"><font color="white"><i class="fa fa-truck"></i></font></a>
									
									<?php } ?>
									</center></td>
								</tr>
								<?php $nt++; } ?>
								
								</tbody>

                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>



@include('footer')
