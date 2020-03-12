@include('header')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<style type="text/css">
	th {text-align: center;}
	td {color: black;}
	#tambah { background-color: #1a9cf9; color: white; white-space: pre;}
	#tambah:hover {background-color: #148de4}
	#export { background-color: #28bd4a; color: white; white-space: pre;}
	#export:hover {background-color: #08b32e}
</style>
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> Research Corner Recapitulation</h5>
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
                    <div class="col-md-14"><br>
                        <h3 style="text-align: center">Based on Research Corner Title</h3>
                        <br>
                        <div class="row">
                            <div class="col-md-11"></div>
                            <div class="col-md-1"><button class="btn btn-primary" id="cetakrc">Print XLX</button></div>
                        </div>
                        <br>
		          	 <div class="table-responsive">
					    <table id="tablerc" class="table table-bordered table-striped" style="/*display: none*/" data-plugin="dataTable">
					      <thead class="text-white" style="background-color: #1089ff;">
					          <tr>
					              <th>No</th>
					              <th>Research Corner</th>
					              <th>Download</th>
					          </tr>
					      </thead>
					    </table>
					  </div>
      	  			</div>

                        <br><br>
                    <div class="col-md-14"><br>
                        <h3 style="text-align: center">Based on Company</h3>
                        <br>
                        <div class="row">
                            <div class="col-md-11"></div>
                            <div class="col-md-1"><button class="btn btn-primary" id="cetakcomp">Print XLX</button></div>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table id="tablecomp" class="table table-bordered table-striped" style="/*display: none*/" data-plugin="dataTable">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>No</th>
                                    <th>Company Name</th>
                                    <th>Download</th>
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
<script type="text/javascript">

    $(document).ready(function () {
        $("#tanggal_awal").flatpickr({
            allowInput: true,
            // altInput: true,
            // altFormat: "j F Y  ( H:i )",
            dateFormat: "d-m-Y",
            // enableTime: true,
        });

        $("#tanggal_akhir").flatpickr({
            allowInput: true,
            // altFormat: "j F Y  ( H:i )",
            // altInput: true,
            dateFormat: "d-m-Y",
            // enableTime: true,
        });
    });
	$(document).ready(function () {

        var table = $('#tablerc').DataTable({
            "processing": true,
            "serverSide": true,
            "retrieve": true,
            "ajax": {
                "url": '{!! route('rekaprc1.getData') !!}',
                "dataType": "json",
                "type": "GET",
                "data": function (data) {
                    data._token = '{{csrf_token()}}';
                    // data.tipe = $('#tipe').val();
                    // data.tanggalawal = $('#tanggal_awal').val();
                    // data.tanggalakhir = $('#tanggal_akhir').val();
                }
                {{--{_token: '{{csrf_token()}}', _id:$('#tahun').val(),_status : $('#status').val()}--}}
            },
            "columns": [
                {data: 'no'},
                {data: 'rc'},
                {data: 'download'},
            ],
            language: {
                processing: "Sedang memproses...",
                lengthMenu: "Tampilkan _MENU_ entri",
                zeroRecords: "Tidak ditemukan data yang sesuai",
                emptyTable: "Tidak ada data yang tersedia pada tabel ini",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                infoFiltered: "(disaring dari _MAX_ entri keseluruhan)",
                infoPostFix: "",
                search: "Cari:",
                url: "",
                infoThousands: ".",
                loadingRecords: "Sedang memproses...",
                paginate: {
                    first: "<<",
                    last: ">>",
                    next: "Selanjutnya",
                    previous: "Sebelum"
                },
                aria: {
                    sortAscending: ": Aktifkan untuk mengurutkan kolom naik",
                    sortDescending: ": Aktifkan untuk mengurutkan kolom menurun"
                }
            }
        });

        var table2 = $('#tablecomp').DataTable({
            "processing": true,
            "serverSide": true,
            "retrieve": true,
            "ajax": {
                "url": '{!! route('rekaprc2.getData') !!}',
                "dataType": "json",
                "type": "GET",
                "data": function (data) {
                    data._token = '{{csrf_token()}}';
                }
                {{--{_token: '{{csrf_token()}}', _id:$('#tahun').val(),_status : $('#status').val()}--}}
            },
            "columns": [
                {data: 'no'},
                {data: 'company'},
                {data: 'download'},
            ],
            language: {
                processing: "Sedang memproses...",
                lengthMenu: "Tampilkan _MENU_ entri",
                zeroRecords: "Tidak ditemukan data yang sesuai",
                emptyTable: "Tidak ada data yang tersedia pada tabel ini",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                infoFiltered: "(disaring dari _MAX_ entri keseluruhan)",
                infoPostFix: "",
                search: "Cari:",
                url: "",
                infoThousands: ".",
                loadingRecords: "Sedang memproses...",
                paginate: {
                    first: "<<",
                    last: ">>",
                    next: "Selanjutnya",
                    previous: "Sebelum"
                },
                aria: {
                    sortAscending: ": Aktifkan untuk mengurutkan kolom naik",
                    sortDescending: ": Aktifkan untuk mengurutkan kolom menurun"
                }
            }
        });

        $('#cetakrc').on('click', function (e) {
            console.log('ke klik');
            window.location.href = "{{route('cetakrc1.printcsv')}}";
        });

        $('#cetakcomp').on('click', function (e) {
            console.log('ke klik');
            window.location.href = "{{route('cetakrc2.printcsv')}}";
        });

        {{--$('#btnrc').on('click', function (e) {--}}
        {{--    console.log('ke klik');--}}
        {{--    window.location.href = "{{route('cetakrc1.printcsv')}}";--}}
        {{--});--}}

        $('#cat1').select2({
          placeholder: 'Select Category'
        });
        $('#cat2').select2({
          placeholder: 'Select Category'
        });
        $('#cat3').select2({
          placeholder: 'Select Category'
        });
        $('#cat4').select2({
          placeholder: 'Select Category'
        });
        $('#cat5').select2({
          placeholder: 'Select Category'
        });
        $('#cat6').select2({
          placeholder: 'Select Category'
        });
    });

    function isEmptyM(obj) {
        for(var key in obj) {
            if(obj.hasOwnProperty(key))
                return false;
        }
        return true;
    }

	function clicksend() {
        var tipe = $('#tipe').val();
        var tanggal_awal = $('#tanggal_awal').val();
        var tanggal_akhir = $('#tanggal_akhir').val();

        console.log(tipe);
        console.log(tanggal_awal);
        console.log(tanggal_akhir);

        if(tipe != 0 && tanggal_awal != null && tanggal_akhir != null){
           document.getElementById('table').removeAttribute("style");
            $("#table").dataTable().fnDestroy()
            var table = $('#table').DataTable({
                "processing": true,
                "serverSide": true,
                "retrieve": true,
                "ajax": {
                    "url": '{!! route('rekapang.getData') !!}',
                    "dataType": "json",
                    "type": "GET",
                    "data": function (data) {
                        data._token = '{{csrf_token()}}';
                        data.tipe = $('#tipe').val();
                        data.tanggalawal = $('#tanggal_awal').val();
                        data.tanggalakhir = $('#tanggal_akhir').val();
                    }
                    {{--{_token: '{{csrf_token()}}', _id:$('#tahun').val(),_status : $('#status').val()}--}}
                },
                "columns": [
                    {data: 'no'},
                    {data: 'nama_perusahaan'},
                    {data: 'tanggal_register'},
                    {data: 'tanggal_verifikasi'},
                ],
                language: {
                    processing: "Sedang memproses...",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    zeroRecords: "Tidak ditemukan data yang sesuai",
                    emptyTable: "Tidak ada data yang tersedia pada tabel ini",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                    infoFiltered: "(disaring dari _MAX_ entri keseluruhan)",
                    infoPostFix: "",
                    search: "Cari:",
                    url: "",
                    infoThousands: ".",
                    loadingRecords: "Sedang memproses...",
                    paginate: {
                        first: "<<",
                        last: ">>",
                        next: "Selanjutnya",
                        previous: "Sebelum"
                    },
                    aria: {
                        sortAscending: ": Aktifkan untuk mengurutkan kolom naik",
                        sortDescending: ": Aktifkan untuk mengurutkan kolom menurun"
                    }
                }
            });
        }else{
            alert('choose user type, start date , end date');
        }
    }
</script>