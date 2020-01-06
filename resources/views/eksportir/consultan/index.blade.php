@include('header')

<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> List Consultant</h5>
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

                    <a class="btn" href="{{url('/eksportir/tambah_consultan')}}"
                       style="background-color: #1089ff; color: white;"><i
                                class="fa fa-plus-circle"></i>
                        Add</a>
                    <div class="col-md-14">
                        <br>
                        <div class="table-responsive">

                            <table id="tableconsultan" class="table  table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        <center>Name</center>
                                    </th>
                                    <th>
                                        <center>Position</center>
                                    </th>
                                    <th>
                                        <center>Phone</center>
                                    </th>
                                    <th>
                                        <center>Problem</center>
                                    </th>
                                    <th>
                                        <center>Solution</center>
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
        $(".alert").slideDown(300).delay(1000).slideUp(300);
        $('#tableconsultan').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('datatables.consultan') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'nama_pegawai', name: 'nama_pegawai'},
                {data: 'jabatan', name: 'jabatan'},
                {data: 'telepon', name: 'telepon'},
                {data: 'masalah', name: 'masalah'},
                {data: 'solusi', name: 'solusi'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>