@include('header')

<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> Management Importir</h5>
                </div>

                <div class="box-body bg-light">
                   
                    <div class="col-md-14">
                        <br>
                        <div class="table-responsive">

                           <table id="example2" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        <center>Company</center>
                                    </th>
                                    <th>
                                        <center>Address</center>
                                    </th>
                                    <th>
                                        <center>Zip Code</center>
                                    </th>
									<th>
                                        <center>Telepon</center>
                                    </th>
									<th>
                                        <center>Fax</center>
                                    </th>
                                    <th>
                                        <center>Konfirmasi Email</center>
                                    </th>
									<th>
                                        <center>Verify By Admin</center>
                                    </th>
                                    <th width="10%">
                                        <center>Action</center>
                                    </th>
                                </tr>
                                </thead>
								<tbody>
								<?php $i=1; foreach($data as $row){ ?>
								<tr>
									<td><?php echo $i;?></td>
									<td><center><?php echo $row->company;?></center></td>
									<td><center><?php echo $row->addres;?></center></td>
									<td><center><?php echo $row->postcode;?>
									<?php /*
									$cari1 = DB::select("select * from public.group where id_group='".$row->id_role."'");
									foreach($cari1 as $cr1){ echo $cr1->group_name; }
									*/ ?>
									</center></td>
									<td><center><?php echo $row->phone;?></center></td>
									<td><center><?php echo $row->fax;?></center></td>
									<td><center><?php if($row->agree == 1){ echo "<font color='green'>Sudah</font>";}else{ echo "<font color='red'>Belum</font>";};?></center></td>
									<td><center><?php if($row->status_a == 1){ echo "<font color='green'>Verified</font>";} else if($row->status_a == 2){ echo "<font color='red'>Not Verified</font>";}else{ echo "<font color='orange'>Wait Administrator</font>";};?></center></td>
									<td><center>
									<?php if($row->status_a == 1 || $row->status_a == 2){ ?>
									<a href="{{url('profil2/'.$row->id_role.'/'.$row->ida)}}" class="btn btn-sm btn-info"><i class="fa fa-edit text-white"></i> Detail</a>
									
									<?php }else{ ?>
									<a href="{{url('profil2/'.$row->id_role.'/'.$row->ida)}}" class="btn btn-sm btn-success"><i class="fa fa-edit text-white"></i> Verify</a>
									<?php } ?>
									</center></td>
								</tr>
								<?php $i++; } ?>
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
