@include('header')

<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> List Training</h5>
                </div>

                <div class="box-body bg-light">
                    <div class="col-md-14">
                        <br>
                        <div class="table-responsive">

                            <table id="tableexdes" class="table  table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        <center>Training</center>
                                    </th>
                                    <th>
                                        <center>Organizer</center>
                                    </th>
                                    <th>
                                        <center>Start Date</center>
                                    </th>
                                    <th>
                                        <center>Due Date</center>
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
        $('#tableexdes').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('eksportir/training_getdata_admin/'.$id) }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'nama_training', name: 'nama_training'},
                {data: 'penyelenggara', name: 'penyelenggara'},
                {data: 'tanggal_mulai', name: 'tanggal_mulai'},
                {data: 'tanggal_selesai', name: 'tanggal_selesai'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>