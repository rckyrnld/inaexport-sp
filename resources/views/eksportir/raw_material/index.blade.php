@include('header')

<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> List Raw Material</h5>
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
                    <a class="btn" href="{{url('/eksportir/tambah_rawmaterial')}}"
                       style="background-color: #1089ff; color: white;"><i
                                class="fa fa-plus-circle"></i>
                        Add</a>
                    <div class="col-md-14">
                        <br>
                        <div class="table-responsive">

                            <table id="tableexdes" class="table  table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        <center>Year</center>
                                    </th>
                                    <th>
                                        <center>From Domestic</center>
                                    </th>
                                    <th>
                                        <center>Overseas</center>
                                    </th>
                                    <th>
                                        <center>Value From Domestic</center>
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
        $('#tableexdes').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('datatables.rawmaterial') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'tahun', name: 'tahun'},
                {data: 'lokal_persen', name: 'lokal_persen'},
                {data: 'impor_persen', name: 'impor_persen'},
                {data: 'nilai_impor', name: 'nilai_impor'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>