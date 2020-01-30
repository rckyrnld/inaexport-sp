@include('header')
<style type="text/css">
	th {text-align: center;}
	td {color: black;}
	#tambah { background-color: #1a9cf9; color: white; white-space: pre;}
	#tambah:hover {background-color: #148de4}
	#export { background-color: #28bd4a; color: white; white-space: pre;}
	#export:hover {background-color: #08b32e}
</style>
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> List Representative Category</h5>
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
                	<a id="tambah" data-toggle="modal" data-target="#modal-addw" class="btn">   <i class="fa fa-plus-circle"></i>  Add   </a>

                    <div class="col-md-14"><br>
		          	 <div class="table-responsive">
					    <table id="example1" class="table  table-bordered table-striped">
					      <thead class="text-white" style="background-color: #1089ff;">
					          <tr>
					              <th>No</th>
					              <th>Type</th>
					              <th width="20%">Action</th>
					          </tr>
					      </thead>
						  <tbody>
						  <?php 
						  $data = DB::select("select * from mst_catper order by id desc");
						  $no = 1;
						  foreach($data as $val){

						  ?>
						  <tr>
							<td width="7%"><?php echo $no; ?></td>
                            <td><?php echo $val->type; ?></td>
							<td>
							<a onclick="return confirm('Are You Sure ?')" href="{{ url('hapus-catper/'.$val->id) }}" class="btn btn-danger"><font color="white"><i class="fa fa-trash"></i></font></a>
							</td>
						  </tr>
						  <?php $no++; } ?>
						  </tbody>
					    </table>
					  </div>
      	  			</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-addw" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="row-col h-v">
        <div class="row-cell v-m">
            <div class="modal-dialog modal-lg">
                <form id="checkpass" method="POST" action="{{ route('catper.save') }}"
                      class="form-horizontal form-label-left">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #1089ff;">
                            <h5 class="modal-title" id="judul" style="color: white;">Add Category Representative</h5>
                        </div>
                        <div class="modal-body text-center p-lg" style="background-color: #ffffff;" id="state">
                            <div class="box-header">
                                <div class="col-md-12">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        {{--                                                            <div class="col-md-4">--}}
                                      <div class="row">
                                          <div class="col-md-3">
                                              <label class="form-label" style="color: black;"><b>Category Representative</b>
                                              </label>
                                          </div>
                                          <div class="col-lg-9">
                                              <input type="text" style="color: black; text-align: left;" id="catper" name="catper"
                                                     class="form-control" autocomplete="off" required>
                                          </div>
                                      </div>

                                        {{--                                                            </div>--}}
                                        {{--                                                            <div class="col-md-6">--}}


                                        {{--                                                            </div>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="background-color: #1089ff;">
                            <button type="button" class="btn btn-danger p-x-md" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-warning" id="btn-savez" value="add">Kirim</button>
                        </div>
                    </div><!-- /.modal-content -->
                </form>
            </div>
        </div>
    </div>
</div>

@include('footer')
<script type="text/javascript">
	$(document).ready(function () {
        $(".alert").slideDown(300).delay(1000).slideUp(300);
        $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('master.port.getData') }}",
            columns: [
                {data: 'name_port', name: 'name_port'},
                {data: 'province_en', name: 'province_en'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>