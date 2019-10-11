@include('header')

<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> Verifikasi User</h5>
                </div>

                <div class="box-body bg-light">
                   
                    <div class="col-md-14">
                        <br>
                        <div class="table-responsive">

                            <table id="example1" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        <center>Username</center>
                                    </th>
                                    <th>
                                        <center>Email</center>
                                    </th>
                                    <th>
                                        <center>Role</center>
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
									<td><center><?php echo $row->username;?></center></td>
									<td><center><?php echo $row->email;?></center></td>
									<td><center>
									<?php 
									$cari1 = DB::select("select * from public.group where id_group='".$row->id_role."'");
									foreach($cari1 as $cr1){ echo $cr1->group_name; }
									?>
									</center></td>
									<td><center><?php if($row->agree == 1){ echo "<font color='green'>Sudah</font>";}else{ echo "<font color='red'>Belum</font>";};?></center></td>
									<td><center><?php if($row->status == 1){ echo "<font color='green'>Sudah di Verifikasi</font>";}else{ echo "<font color='red'>Belum di Verifikasi</font>";};?></center></td>
									<td><center>
									<?php if($row->status == 1){ ?>
									<a href="{{url('detailverify/'.$row->id)}}" class="btn btn-sm btn-info"><i class="fa fa-edit text-white"></i> Detail</a>
									
									<?php }else{ ?>
									<a href="{{url('detailverify/'.$row->id)}}" class="btn btn-sm btn-success"><i class="fa fa-edit text-white"></i> Verifikasi</a>
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
