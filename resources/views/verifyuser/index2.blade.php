@include('header')

<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> List Importer</h5>
                </div>

                <div class="box-body bg-light">
                   
                    <div class="col-md-14">
                        <br>
                        <div class="table-responsive">

                           <table id="users-table" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        <center>Company</center>
                                    </th>
                                    <th>
                                        <center>Email</center>
                                    </th>
                                    <th>
                                        <center>Zip Code</center>
                                    </th>
									<th>
                                        <center>Telephone</center>
                                    </th>
									<th>
                                        <center>Fax</center>
                                    </th>
                                    <th>
                                        <center>Email Confirmation</center>
                                    </th>
									<th>
                                        <center>Verify By Admin</center>
                                    </th>
                                    <th width="15%">
                                        <center>Action</center>
                                    </th>
                                </tr>
                                </thead>
								<tbody>
								
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
 function ConfirmDelete()
    {
      var x = confirm("Are you sure you want to delete?");
      if (x)
          return true;
      else
        return false;
    }
    $(function () {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('getimportir') }}",
            columns: [
                {data: 'row', name: 'row'},
                {data: 'f1', name: 'f1'},
                {data: 'f2', name: 'f2'},
                {data: 'f3', name: 'f3'},
                {data: 'f4', name: 'f4'},
                {data: 'f5', name: 'f5'},
                {
					data: 'f6', name: 'f6', orderable: false, searchable: false
				},
				{
					data: 'f7', name: 'f7', orderable: false, searchable: false
				},
                {
                    data: 'action', name: 'action', orderable: false, searchable: false
                }]
        });
    });
</script>

@include('footer')
