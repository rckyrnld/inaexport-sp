@include('header')

<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> Management Perwakilan</h5>
                </div>

                <div class="box-body bg-light">
                   
                    <div class="col-md-14">
                        <br>
                        <div class="table-responsive">
						<a href="{{ url('tambahperwakilan') }}" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Perwakilan</a><br><br>
                           <table id="example2" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        <center>Instansi</center>
                                    </th>
                                    <th>
                                        <center>Email</center>
                                    </th>
                                    <th>
                                        <center>Web</center>
                                    </th>
									<th>
                                        <center>Jenis</center>
                                    </th>
									<th>
                                        <center>Type</center>
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
									<td><center><?php echo $row->name;?></center></td>
									<td><center><?php echo $row->email;?></center></td>
									<td><center><?php echo $row->website;?></center></td>
									
									
									<td><center><?php if($row->id_admin_ln == null || $row->id_admin_ln == 0){ echo "Dalam Negeri"; }else{ echo "Luar Negeri"; }?></center></td>
									<td><center><?php echo $row->type;?></center></td>
									<td><center>
									<a class="btn btn-danger" href="{{ url('hapusperwakilan/'.$row->id) }}">Hapus</a>
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
