@include('header')

<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> List Representative</h5>
                </div>

                <div class="box-body bg-light">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block" style="text-align: center">
                            {{--                            <button type="button" class="close" data-dismiss="alert">×</button>--}}
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block" style="text-align: center">
                            {{--                                <button type="button" class="close" data-dismiss="alert">×</button>--}}
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <div class="col-md-14">
                        <br>
                        <div class="table-responsive">
						<a href="{{ url('tambahperwakilan') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add</a><br><br>
                           <table id="users-table" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        <center>Username</center>
                                    </th>
									<th>
                                        <center>Scope</center>
                                    </th>
									<th>
                                        <center>Type</center>
                                    </th>
                                    <th>
                                        <center>Email</center>
                                    </th>
                                    <th>
                                        <center>Website</center>
                                    </th>
									
									
                                    <th width="17%">
                                        <center>Action</center>
                                    </th>
                                </tr>
                                </thead>
								<tbody>
								<!--
								<?php $i=1; foreach($data as $row){ ?>
								<tr>
									<td><?php echo $i;?></td>
									<td><center><?php echo $row->name;?></center></td>
									<td><center><?php echo $row->email;?></center></td>
									<td><center><?php echo $row->website;?></center></td>
									
									
									<td><center><?php if($row->id_admin_ln == null || $row->id_admin_ln == 0){ echo "Dalam Negeri"; }else{ echo "Luar Negeri"; }?></center></td>
									<td><center><?php echo $row->type;?></center></td>
									<td><center>
									<a class="btn btn-danger" href="{{ url('hapusperwakilan/'.$row->id) }}"><i class="fa fa-trash"></i> Hapus</a>
									</center></td>
								</tr> 
								<?php $i++; } ?>
								-->
								</tbody>

                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $(".alert").slideDown(300).delay(1000).slideUp(300);
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('getpw') }}",
            columns: [
                {data: 'row', name: 'row'},
                {data: 'f1', name: 'f1'},
				{
					data: 'f6', name: 'f6', orderable: false, searchable: false
				},
				{
					data: 'f7', name: 'f7', orderable: false, searchable: false
				},
                {data: 'f2', name: 'f2'},
                {data: 'f3', name: 'f3'},
                
                {
                    data: 'action', name: 'action', orderable: false, searchable: false
                }]
        });
    });
</script>
@include('footer')
