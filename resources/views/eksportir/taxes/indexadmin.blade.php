@include('header')

<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> Data Taxes</h5>
                </div>

                <div class="box-body bg-light">
                    <div class="col-md-14">
                        <br>
                        <div class="table-responsive">

                            <table id="tabletaxes" class="table  table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        <center>Year</center>
                                    </th>
                                    <th>
                                        <center>Report PPH</center>
                                    </th>
                                    <th>
                                        <center>Report PPN</center>
                                    </th>
                                    <th>
                                        <center>Report Pasal 21</center>
                                    </th>
                                    <th>
                                        <center>Total PPH</center>
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
        $('#tabletaxes').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('eksportir/taxes_getdata_admin/'.$id) }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'tahun', name: 'tahun'},
                {data: 'laporan_pph', name: 'laporan_pph'},
                {data: 'laporan_ppn', name: 'laporan_ppn'},
                {data: 'laporan_psl21', name: 'laporan_psl21'},
                {data: 'setor_pph', name: 'setor_pph'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>