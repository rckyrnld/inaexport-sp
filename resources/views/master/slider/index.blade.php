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
                    <h5><i></i> List Master Slider</h5>
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
                	<a id="tambah" href="{{url('tambah-slide')}}" class="btn">   <i class="fa fa-plus-circle"></i>  Add   </a>

                    <div class="col-md-14"><br>
		          	 <div class="table-responsive">
					    <table id="example1" class="table  table-bordered table-striped">
					      <thead class="text-white" style="background-color: #1089ff;">
					          <tr>
					              <th>No</th>
					              <th>File</th>
					              <th>Note</th>
					              <th>Publish</th>
					              <th width="20%">Action</th>
					          </tr>
					      </thead>
						  <tbody>
						  <?php 
						  $data = DB::select("select * from mst_slide order by id desc"); 
						  $no = 1;
						  foreach($data as $val){
							
						  ?>
						  <tr>
							<td width="7%"><?php echo $no; ?></td>
							<td width="12%"><img src="{{asset('uploads/slider')}}<?php echo "/".$val->file_img;?>" width="120px"></td>
							<td><?php echo $val->keterangan; ?></td>
							<td><?php if($val->publish == 1){ echo "Yes";}else{ echo "No"; } ?></td>
							<td><a href="{{ url('edit-slide/'.$val->id) }}" class="btn btn-success"><font color="white"><i class="fa fa-pencil"></i></font></a></td>
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