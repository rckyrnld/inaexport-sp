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
                    <h5><i></i> List Province</h5>
                </div>

                <div class="box-body bg-light">
                	<a id="tambah" href="{{route('master.province.create')}}" class="btn">   <i class="fa fa-plus-circle"></i>  Add   </a>&nbsp;&nbsp;<a id="export" href="{{route('master.province.export')}}" class="btn" target="_blank"><i class="fa fa-print"></i>  Export </a>

                    <div class="col-md-14"><br>
		          	 <div class="table-responsive">
					    <table id="table" class="table  table-bordered table-striped" data-plugin="dataTable">
					      <thead class="text-white" style="background-color: #1089ff;">
					          <tr>
					              <th width="29%">Province (EN)</th>
					              <th width="29%">Province (IN)</th>
					              <th width="26%">Province (CHN)</th>
					              <th width="20%">Action</th>
					          </tr>
					      </thead>
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
        $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('master.province.getData') }}",
            columns: [
                {data: 'province_en', name: 'province_en'},
                {data: 'province_in', name: 'province_in'},
                {data: 'province_chn', name: 'province_chn'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>