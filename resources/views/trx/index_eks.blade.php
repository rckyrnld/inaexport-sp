@include('header')

<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> Selling Transaction Eksportir</h5>
                </div>

                <div class="box-body bg-light">
                   
                    <div class="col-md-14">
                        
                        <div class="table-responsive">
						
                           <table id="example1" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>No</th>
									
                                  
									
                                    
                                   
									<th>
                                        <center>Product Name</center>
                                    </th>
									<th>
                                        <center>Quantity</center>
                                    </th>
									<th>
                                        <center>Price</center>
                                    </th>
									<th>
                                        <center>Buyer</center>
                                    </th>
									<th>
                                        <center>Subyek</center>
                                    </th>
									<!--<th>
                                        <center>Specification</center>
                                    </th>-->
									 <th>
                                        <center>Type Tracking</center>
                                    </th>
									<th>
                                        <center>No Tracking</center>
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
									?>
									</td>
									<td><center><?php echo $ruu->eo." ".$ruu->neo; ?></center></td>
									<td><center><?php echo $ruu->tp." ".$ruu->ntp; ?></center></td>
									<td><center><?php if($ruu->by_role == 1){ echo "Admin"; }else if($ruu->by_role == 4){ echo "Perwakilan"; }else{ echo "Importir"; } ?></center></td>
									<td><center><?php echo $ruu->subyek; ?></center></td>
									
									
									<td><center><?php echo $ruu->type_tracking; ?></center></td>
									<td><center><?php echo $ruu->no_track; ?></center></td>
									
									<td><center>
									<?php if($ruu->status_trx == 1){ ?>
									<a href="{{ url('br_trx/'.$ruu->ida.'/'.$ruu->idb) }}" class="btn btn-info"><font color="white"><i class="fa fa-list"></i>&nbsp; View</font></a>
									
									
									<?php }else { ?>
									<a href="{{ url('br_trx/'.$ruu->ida.'/'.$ruu->idb) }}" class="btn btn-success"><font color="white"><i class="fa fa-truck"></i>&nbsp; Send</font></a>
									
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
