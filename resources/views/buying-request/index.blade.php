@include('header')

<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> Buying Request</h5>
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
                        
                        <div class="table-responsive">
						<a href="{{ url('br_add') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add</a><br><br>
                          
                           <table id="users-table" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        <center>Product Name</center>
                                    </th>
                                    <th>
                                        <center>Category</center>
                                    </th>
									<th>
                                        <center>Date</center>
                                    </th>
                                    <th>
                                        <center>Duration</center>
                                    </th>
									<th>
                                        <center>Status</center>
                                    </th>
									<th width="18%">
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
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#2e899e; color:white;"> <h6>Broadcast Buying Request</h6>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
		<div id ="isibroadcast"></div>
        <!--<div class="modal-body">
          1
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> -->
      </div>
    </div>
  </div>
 <script type="text/javascript">
function xy(a){
	var token = $('meta[name="csrf-token"]').attr('content');
		$.get('{{URL::to("ambilbroad2/")}}/'+a,{_token:token},function(data){
            $("#isibroadcast").html(data);
            calldata();
			
         })
        
         
}
function calldata(){
    var id = $('#id_laporan').val();
    $("#tabelpiliheksportir").dataTable().fnDestroy();
    var table = $('#tabelpiliheksportir').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        paging :true,
        searching: false,
        "ajax": {
                "url": '{!! url('getdatapiliheksportir') !!}',
                "dataType": "json",
                "type": "GET",
                "data": {_token: '{{csrf_token()}}',id_laporan: id}
        },
            columns: [
                {data: 'f2', name: 'f2', orderable: false, searchable: false},
                {data: 'f3', name: 'f3', orderable: false, searchable: false},
                ]
        });
}
</script>
<script type="text/javascript">
    $(function () {
        $(".alert").slideDown(300).delay(1000).slideUp(300);
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('getcscperwakilan') }}",
            columns: [
                {data: 'row', name: 'row'},
                {data: 'f1', name: 'f1'},
                {data: 'f4', name: 'f4'},
                {data: 'f3', name: 'f3'},
                {data: 'f2', name: 'f2'},
                
				{
					data: 'f7', name: 'f7', orderable: false, searchable: false
				},
                {
                    data: 'action', name: 'action', orderable: false, searchable: false
                }]
        });
    });

    function ConfirmDelete()
    {
      var x = confirm("Are you sure you want to delete?");
      if (x)
          return true;
      else
        return false;
    }


</script>


@include('footer')
