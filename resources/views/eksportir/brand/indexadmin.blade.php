@include('header')

<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> List Brand</h5>
                </div>

                <div class="box-body bg-light">

                    <div class="col-md-14">
                        <br>
                        <div class="table-responsive">

                            <table id="tablebrands" class="table  table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        Brand
                                    </th>
                                    <th>
                                        <center>Meaning Of Brand</center>
                                    </th>
                                    <th>
                                        <center>Month</center>
                                    </th>
                                    <th>
                                        <center>Year</center>
                                    </th>
                                    <th>
                                        <center>Copyright Number</center>
                                    </th>
                                    <th>
                                        <center>Action</center>
                                    </th>
                                </tr>
                                </thead>

                            </table>
                            <br>
                            <a style="color: white" href="{{ url('eksportir/listeksportir/'.$id) }}"
                               class="btn btn-danger pull-right"><i style="color: white"></i>
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
        $('#tablebrands').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('eksportir/brand_getdata_admin/'.$id) }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'merek', name: 'merek'},
                {data: 'arti_merek', name: 'arti_merek'},
                {data: 'bulan_merek', name: 'bulan_merek'},
                {data: 'tahun_merek', name: 'tahun_merek'},
                {data: 'paten_merek', name: 'paten_merek'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>