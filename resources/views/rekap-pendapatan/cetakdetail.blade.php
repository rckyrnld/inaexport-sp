<?php
 header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=\"pendapatandetail.xls\"");
header("Cache-Control: max-age=0");
?>   
	
 <h5><i></i>List Detail Rekap Pendapatan <?php 
									$carieksportir = DB::select("select b.company,b.badanusaha from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and a.id='".$id."' limit 1");
									if(count($carieksportir) == 0){
										// echo "";
									}else {
										foreach($carieksportir as $ce){
											echo $ce->badanusaha." ".$ce->company;
										}
									}
									?></h5>
									
									      <table id="example1" border="1" class="table table-bordered table-striped">
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
                                        <center>Eksportir</center>
                                    </th>
									
									 <th>
                                        <center>Type Tracking</center>
                                    </th>
									<th>
                                        <center>No Tracking</center>
                                    </th>
									<th>
                                        <center>Harga</center>
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
									$carieks = DB::select("select * from itdp_company_users where id='".$ruu->id_eksportir."'");
									foreach($carieks as $eks){ echo $eks->username; }
									?></center></td>
									
									
									<td><center><?php echo $ruu->type_tracking; ?></center></td>
									<td><center><?php echo $ruu->no_tracking; ?></center></td>
									<td><center><?php echo "$".number_format($ruu->total,2,',','.'); ?></center></td>
									
								</tr>
								<?php $nt++; } ?>
								
								</tbody>

                            </table>
                       
         

                       
         
