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
                    <a class="btn" href="{{url('/eksportir/tambah_procap')}}"
                       style="background-color: #1089ff; color: white;"><i
                                class="fa fa-plus-circle"></i>
                        Tambah</a>
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
            ajax: "{{ route('datatables.procap') }}",
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