@include('header')
<style type="text/css">
	th {text-align: center;}
	td {color: black;}
	#tambah { background-color: #1a9cf9; color: white; white-space: pre;}
	#tambah:hover {background-color: #148de4}
</style>

<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> List Contact Us</h5>
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
                    <div class="col-md-14"><br>
		          	 <div class="table-responsive">
					    <table id="table" class="table  table-bordered table-striped" data-plugin="dataTable">
					      <thead class="text-white" style="background-color: #1089ff;">
					          <tr>
					              <th width="7%">No</th>
					              <th>Full Name</th>
					              <th>Email</th>
					              <th>Subject</th>
					              <th>Message</th>
					              <th width="14%">Action</th>
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
        $(".alert").slideDown(300).delay(1000).slideUp(300);
        $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('management.contact-us.getData') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'fullname', name: 'fullname'},
                {data: 'email', name: 'email'},
                {data: 'subyek', name: 'subyek'},
                {data: 'message', name: 'message'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>