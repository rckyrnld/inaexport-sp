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
          <a id="tambah" href="{{route('training.create.admin')}}" class="btn">   <i class="fa fa-plus-circle"></i>  Add </a>
          <div class="col-md-14"><br>
            <div class="table-responsive">
              <table id="table" class="table  table-bordered table-striped" data-plugin="dataTable">
                <thead class="text-white" style="background-color: #1089ff;">
                  <tr>
                    <th>No</th>
                    <th>Training</th>
                    <th>Date</th>
                    <th>Duration</th>
                    <th>Topic</th>
                    <th>Location</th>
                    <th>Status</th>
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
            ajax: "{{ route('training.getData.admin')}}",
            columns: [
							{data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'training_en', name: 'training_en'},
							{data: 'start_date', name: 'start_date'},
              {data: 'duration', name: 'duration'},
              {data: 'topic_en', name: 'topic_en'},
							{data: 'location_en', name: 'location_en'},
              {data: 'status', name: 'status'},
              {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>
