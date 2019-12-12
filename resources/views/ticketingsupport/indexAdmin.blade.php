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
          <!-- Header Title -->
        </div>
        <div class="box-body bg-light">
          <div class="col-md-14"><br>
            <div class="table-responsive">
              <table id="table" class="table  table-bordered table-striped" data-plugin="dataTable">
                <thead class="text-white" style="background-color: #1089ff;">
                  <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subyek</th>
                    <th>Massages</th>
                    <th>Status</th>
                    <th>Created At</th>
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
	$(function () {
        $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('ticket_support.getData.admin')}}",
            columns: [
							{data: 'row', name: 'row'},
							{data: 'name', name: 'name'},
							{data: 'email', name: 'email'},
              {data: 'subyek', name: 'subyek'},
							{data: 'main_messages', name: 'main_messages'},
              {data: 'status', name: 'status'},
              {data: 'created_at', name: 'created_at'},
              {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>
