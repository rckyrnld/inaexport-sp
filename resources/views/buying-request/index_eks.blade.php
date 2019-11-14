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
                                        <center>Duration</center>
                                    </th>
                                    <th>
                                        <center>Importir</center>
                                    </th>
									<th>
                                        <center>Subyek</center>
                                    </th>
                                    
                                   
									<th>
                                        <center>Category</center>
                                    </th>
									<!--<th>
                                        <center>Specification</center>
                                    </th>-->
									 <th>
                                        <center>Expired at</center>
                                    </th>
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
									<td><center>Valid for <?php echo $ruu->valid; ?> days</center></td>
									<td><center>
									<?php $usre = DB::select("select b.company from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='".$ruu->id_pembuat."'"); 
									foreach($usre as $imp){ 
									echo $imp->company; 
									}
									?>
									</center></td>
									<td><center><?php echo $ruu->subyek; ?></center></td>
									
									
									<td>
									<?php
$cr = explode(',',$ruu->id_csc_prod);
				$hitung = count($cr);
				$semuacat = "";
				for($a = 0; $a < ($hitung - 1); $a++){
					$namaprod = DB::select("select * from csc_product where id='".$cr[$a]."' ");
					foreach($namaprod as $prod){ $napro = $prod->nama_kategori_en; }
					$semuacat = $semuacat."- ".$napro."<br>";
				}
				echo $semuacat;
									/*
									$ms1 = DB::select("select id,nama_kategori_en from csc_product where id='".$ruu->id_csc_prod_cat."'");
									foreach($ms1 as $c1){ 
									echo $c1->nama_kategori_en; 
									}
									*/
									?>
									</td>
									<td><center><?php echo $ruu->expired_at; ?></center></td>
									<td><center>
									<?php if($ruu->status_join == "1"){ echo "Menunggu Verifikasi Importir"; }else if($ruu->status_join == "2"){ echo "Negosiation"; }
									else if($ruu->status_join == "4"){ echo "Deal"; }else{ echo "-"; }?>
									</center></td>
									<td><center>
									<?php if($ruu->status_join == null){ ?>
									<a href="{{ url('br_join/'.$ruu->idb) }}" class="btn btn-success"><font color="white"><i class="fa fa-plus"></i> Join</font></a>
									<?php }else if($ruu->status_join == 1){ ?>
									Wait Verification
									<?php }else if($ruu->status_join == 2){ ?>
									<a href="{{ url('br_chat/'.$ruu->idb) }}" class="btn btn-info"><font color="white"><i class="fa fa-comment"></i> Chat</font></a>
									<?php }else if($ruu->status_join == 4){ ?>
									<a href="{{ url('br_chat/'.$ruu->idb) }}" class="btn btn-success"><font color="white"><i class="fa fa-list"></i> View</font></a>
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
