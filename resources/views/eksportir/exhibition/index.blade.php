@include('header')

<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> Exhibition </h5>
                </div>

                <div class="box-body bg-light">
                    <a class="btn" href="{{url('/eksportir/tambah_exhibition')}}"
                       style="background-color: #1089ff; color: white;"><i
                                class="fa fa-plus-circle"></i>
                        Tambah</a>
                    <div class="col-md-14">
                        <br>
                        <div class="table-responsive">

                            <table id="tableexhibition" class="table  table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>
                                        <center>No</center>
                                    </th>
                                    <th>
                                        <center> Exhibition</center>
                                    </th>
                                    <th>
                                        <center>Booth Area</center>
                                    </th>
                                    <th>
                                        <center>Value Contract</center>
                                    </th>
                                    <th>
                                        <center>Subsidi Djpen</center>
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
        $('#tableexhibition').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('datatables.exhibition') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'id_itdp_eks_event_profil', name: 'id_itdp_eks_event_profil'},
                {data: 'luas_boot', name: 'luas_boot'},
                {data: 'nilai_kontrak', name: 'nilai_kontrak'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>