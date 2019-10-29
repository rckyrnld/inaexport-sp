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
          <div class="col-md-14">
            <div class="table-responsive">
              <h4>View Training</h4><hr>
              <table id="table" class="table  table-bordered table-striped" data-plugin="dataTable">
                <thead class="text-white" style="background-color: #1089ff;">
                  <tr>
                    <th>Training</th>
                    <th>Date</th>
                    <th>Duration</th>
                    <th>Topic</th>
                    <th>Location</th>
                    <th>Status</th>
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
            ajax: "{{ route('training.getData')}}",
            columns: [
							{data: 'training_in', name: 'training_in'},
							{data: 'start_date', name: 'start_date'},
              {data: 'duration', name: 'duration'},
              {data: 'topic_in', name: 'topic_in'},
							{data: 'location_in', name: 'location_in'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    });
</script>
