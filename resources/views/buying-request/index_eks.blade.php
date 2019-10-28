@include('header')

<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> Buying Request Eksportir</h5>
                </div>

                <div class="box-body bg-light">
                   
                    <div class="col-md-14">
                        
                        <div class="table-responsive">
						
                           <table id="example1" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        <center>Importir</center>
                                    </th>
									<th>
                                        <center>Subyek</center>
                                    </th>
                                    <th>
                                        <center>Duration</center>
                                    </th>
                                    <th>
                                        <center>Date</center>
                                    </th>
									<th>
                                        <center>Category</center>
                                    </th>
									<!--<th>
                                        <center>Specification</center>
                                    </th>-->
                                    <th> 
                                        <center>Status</center>
                                    </th>
									<th width="10%">
                                        <center>Action</center>
                                    </th>
                                </tr>
                                </thead>
								<tbody>
								<?php $nt = 1; foreach($data as $ruu){ ?>
								<tr>
									<td><?php echo $nt; ?></td>
									<td><center>
									<?php $usre = DB::select("select b.company from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='".$ruu->id_pembuat."'"); 
									foreach($usre as $imp){ 
									echo $imp->company; 
									}
									?>
									</center></td>
									<td><center><?php echo $ruu->subyek; ?></center></td>
									<td><center><?php echo $ruu->valid; ?></center></td>
									<td><center><?php echo $ruu->date; ?></center></td>
									<td><center>
									<?php 
									$ms1 = DB::select("select id,nama_kategori_en from csc_product where id='".$ruu->id_csc_prod_cat."'");
									foreach($ms1 as $c1){ 
									echo $c1->nama_kategori_en; 
									}
									?>
									</center></td>
									<td><center>
									<?php if($ruu->status_join == "1"){ echo "Menggung Verifikasi Importir"; }else if($ruu->status_join == "2"){ echo "Chat"; }
									else if($ruu->status_join == "3"){ echo "Deal"; }else{ echo "-"; }?>
									</center></td>
									<td><center>
									<?php if($ruu->status_join == null){ ?>
									<a href="{{ url('br_join/'.$ruu->idb) }}" class="btn btn-success"><font color="white">Join</font></a>
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
