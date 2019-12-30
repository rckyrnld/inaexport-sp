@include('header')

<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> List Contact</h5>
                </div>

                <div class="box-body bg-light">
                    <a class="btn" href="{{url('/eksportir/tambah_contact')}}"
                       style="background-color: #1089ff; color: white;"><i
                                class="fa fa-plus-circle"></i>
                        Add</a>
                    <div class="col-md-14">
                        <br>
                        <div class="table-responsive">

                            <table id="tablecontact" class="table  table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>
                                        <center>No</center>
                                    </th>
                                    <th>
                                        <center>
                                            Name
                                        </center>
                                    </th>
                                    <th>
                                        <center>Position</center>
                                    </th>
                                    <th>
                                        <center>Phone</center>
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
        $('#tablecontact').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('datatables.contact') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'job_title', name: 'job_title'},
                {data: 'phone', name: 'phone'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>