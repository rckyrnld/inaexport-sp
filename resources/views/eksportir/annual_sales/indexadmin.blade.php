@include('header')

<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> Report Exporter</h5>
                </div>

                <div class="box-body bg-light">

                    <div class="col-md-14">
                        <br>
                        <div class="table-responsive">

                            <table id="tableeksportir" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        <center>Company</center>
                                    </th>
                                    <th>
                                        <center>Address</center>
                                    </th>
                                    <th>
                                        <center>Post Code</center>
                                    </th>
                                    <th>
                                        <center>Telephone</center>
                                    </th>
                                    <th>
                                        <center>Fax</center>
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
    $(function () {
        $('#tableeksportir').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('datatables.reporteksportir') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'f1', name: 'f1'},
                {data: 'f2', name: 'f2'},
                {data: 'f3', name: 'f3'},
                {data: 'f4', name: 'phone'},
                {data: 'fax', name: 'fax'},
                {
                    data: 'action', name: 'action', orderable: false, searchable: false
                }
            ]
        });
    });
</script>

@include('footer')
