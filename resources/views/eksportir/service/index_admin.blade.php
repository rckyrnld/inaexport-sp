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
                    <h5><i></i> List Service</h5>
                </div>

                <div class="box-body bg-light">
                    <div class="col-md-14">
		          	 <div class="table-responsive">
					    <table id="table" class="table  table-bordered table-striped" data-plugin="dataTable">
					      <thead class="text-white" style="background-color: #1089ff;">
					          <tr>
					              <th>Name</th>
					              <th width="15%">Field of Works</th>
                                  <th width="15%">Skills</th>
                                  <th width="30%">Experiences (DN/LN)</th>
                                  <th width="10%">Links</th>
                                  <th>Status</th>
					              <th>Action</th>
					          </tr>
					      </thead>
					    </table>
                        <br>
                        <a style="color: white" href="{{ url('eksportir/listeksportir/'.$id) }}"
                           class="btn btn-danger pull-right"><i style="color: white"></i>
                            Back
                        </a>
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
            "ordering": false,
            processing: true,
            serverSide: true,
            ajax: "{{ route('service.getData', $id) }}",
            columns: [
                {data: 'nama_en', name: 'nama_en'},
                {data: 'bidang_en', name: 'bidang_en'},
                {data: 'skill_en', name: 'skill_en'},
                {data: 'pengalaman_en', name: 'pengalaman_en'},
                {data: 'link', name: 'link'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
    
</script>