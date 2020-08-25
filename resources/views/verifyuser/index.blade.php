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
                    <h5><i></i> List Indonesian Exporter</h5>
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
                    @if(Auth::user()->id_admin_dn != 0)
                    <a id="tambah" href="{{route('addexpor')}}" class="btn">   <i class="fa fa-plus-circle"></i>  Add   </a>
                    @endif
                    <div class="row">
                        <div class="col-md-2">
                            <select id="filter" name="filter" class="form-control" onchange="filtering()">
                                <option value="0" >Choose Filter</option>
                                <option value="1" >Unverified</option>
                                <option value="2" >Verified</option>
                                <option value="3" >Notverified</option>
                            </select> 
                        </div>
                    </div>
                    <div class="col-md-12">
                        <br>
                        <div class="table-responsive">

                           <table id="users-table" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <!-- <tr>
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
                                        <center>Last Activity</center>
                                    </th>
                                    <th>
                                        <center>Email Confirmation</center>
                                    </th>
									<th>
                                        <center>Verify By Admin</center>
                                    </th>
                                    <th width="10%">
                                        <center>Verify Date</center>
                                    </th>
                                    <th width="10%">
                                        <center>Action</center>
                                    </th>
                                </tr> -->
                                <tr>
                                    <th>No</th>
                                    <th>
                                        <center>Company</center>
                                    </th>
                                    <th>
                                        <center>Email</center>
                                    </th>
                                    <th>
                                        <center>PIC Name</center>
                                    </th>
									<th>
                                        <center>PIC Telephone</center>
                                    </th>
									<th>
                                        <center>Register Date</center>
                                    </th>
									<th>
                                        <center>Last Activity</center>
                                    </th>
                                    <th>
                                        <center>NPWP</center>
                                    </th>
                                    <th width="10%">
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
        $(".alert").slideDown(300).delay(1000).slideUp(300);
        var table = $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            // ajax: {
            //         url: "{{ url('geteksportir') }}",
            //         type:'POST',

            //         // data: function (d) {
            //         //     d.filternya = yangdiselect;
            //         //     // d.language = $("#language option:selected").val();
            //         // },
                    
            //     },
            ajax: "{{ url('geteksportir') }}",
            columns: [
                {data: 'row', name: 'row', orderable: false, searchable: false},
                {data: 'company', name: 'itdp_profil_eks.company', orderable: true, searchable: true},
                {data: 'email', name: 'itdp_company_users.email', orderable: true, searchable: true},
                {data: 'name', name: 'name', orderable: true, searchable: true},
                {data: 'phone', name: 'phone', orderable: true, searchable: true},
                {data: 'created_at', name: 'itdp_company_users.created_at', orderable: true, searchable: true},
                {
					data: 'keterangan', name: 'keterangan', orderable: false, searchable: false
				},
				{
					data: 'npwp', name: 'itdp_profil_eks.npwp', orderable: true, searchable: true
				},
                // {
                //     data: 'f8', name: 'f8', orderable: false, searchable: false
                // },
                {
                    data: 'action', name: 'action', orderable: false, searchable: false
                }]
        });

        
    });
    
            // ajax: "{{ url('geteksportir') }}",  
            // data: {filternya : yangdiselect},
            // "data": {_token: '{{csrf_token()}}'}

    function filtering(){
        var yangdiselect = $('#filter').val();
        $('#users-table').DataTable().destroy();
        var table = $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                    url: "{{ url('geteksportir') }}",
                    data: function (d) {
                        d.filternya = yangdiselect;
                        d._token =  '{{csrf_token()}}';
                    },
                }, 
            columns: [
                {data: 'row', name: 'row', orderable: false, searchable: false},
                {data: 'company', name: 'itdp_profil_eks.company', orderable: true, searchable: true},
                {data: 'email', name: 'itdp_company_users.email', orderable: true, searchable: true},
                {data: 'name', name: 'name', orderable: true, searchable: true},
                {data: 'phone', name: 'phone', orderable: true, searchable: true},
                {data: 'created_at', name: 'itdp_company_users.created_at', orderable: true, searchable: true},
                {
					data: 'keterangan', name: 'keterangan', orderable: false, searchable: false
				},
				{
					data: 'npwp', name: 'itdp_profil_eks.npwp', orderable: true, searchable: true
				},
                // {
                //     data: 'f8', name: 'f8', orderable: false, searchable: false
                // },
                {
                    data: 'action', name: 'action', orderable: false, searchable: false
                }]
        });
        
        // table.column( $(this).data('status').search( $(this).val() ).draw();
    }
</script>

@include('footer')
