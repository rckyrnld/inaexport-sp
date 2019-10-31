@include('header')

<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> Data Annual Sales</h5>
                </div>

                <div class="box-body bg-light">
                    <div class="col-md-14">
                        <br>
                        <div class="table-responsive">

                            <table id="tablesales" class="table  table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        Year
                                    </th>
                                    <th>
                                        <center>Nilai (USD)</center>
                                    </th>
                                    <th>
                                        <center>Persen (%)</center>
                                    </th>
                                    <th>
                                        <center>Nilai Ekspor (USD)</center>
                                    </th>
                                    <th>
                                        <center>Action</center>
                                    </th>
                                </tr>
                                </thead>

                            </table>
                            <br>
                            <a style="color: white" href="{{ url('eksportir/listeksportir/'.$id) }}"
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
        $('#tablesales').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('eksportir/sales_getdata_admin/'.$id) }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'tahun', name: 'tahun'},
                {data: 'nilai', name: 'nilai'},
                {data: 'nilai_persen', name: 'nilai_persen'},
                {data: 'nilai_ekspor', name: 'nilai_ekspor'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>