@include('header')

<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> Data Country Patern Brand</h5>
                </div>

                <div class="box-body bg-light">
                    <a class="btn" href="{{url('/eksportir/tambah_country_patern_brand')}}"
                       style="background-color: #1089ff; color: white;"><i
                                class="fa fa-plus-circle"></i>
                        Tambah</a>
                    <div class="col-md-14">
                        <br>
                        <div class="table-responsive">

                            <table id="tablebrand" class="table  table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        <center>Merek</center>
                                    </th>
                                    <th>
                                        <center>Country</center>
                                    </th>
                                    <th>
                                        <center>Month</center>
                                    </th>
                                    <th>
                                        <center>Year</center>
                                    </th>
                                    <th>
                                        <center>Action</center>
                                    </th>
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

<script>
    $(function () {
        $('#tablebrand').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('datatables.country_patern_brand') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'merek', name: 'merek'},
                {data: 'country', name: 'country'},
                {data: 'bulan', name: 'bulan'},
                {data: 'tahun', name: 'tahun'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>