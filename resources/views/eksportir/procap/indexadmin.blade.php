@include('header')

<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> Data Product Capacity</h5>
                </div>

                <div class="box-body bg-light">
                    <div class="col-md-14">
                        <br>
                        <div class="table-responsive">

                            <table id="tableprocap" class="table  table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>
                                        <center>No</center>
                                    </th>
                                    <th>
                                        <center>
                                            Year
                                        </center>
                                    </th>
                                    <th>
                                        <center>Own Production (%)</center>
                                    </th>
                                    <th>
                                        <center>Outside Production (%)</center>
                                    </th>
                                    <th>
                                        <center>Action</center>
                                    </th>
                                </tr>
                                </thead>

                            </table>
                            <br>
                            <a style="color: white" href="{{ URL::previous() }}"
                               class="btn btn-success pull-right"><i style="color: white"></i>
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

<script>
    $(function () {
        $('#tableprocap').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('eksportir/product_capacity_getdata_admin/'.$id) }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'tahun', name: 'tahun'},
                {data: 'sendiri_persen', name: 'sendiri_persen'},
                {data: 'outsourcing_persen', name: 'outsourcing_persen'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>