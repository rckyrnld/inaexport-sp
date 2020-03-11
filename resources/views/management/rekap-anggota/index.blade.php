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
                    <h5><i></i> Rekap Anggota</h5>
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
{{--                	<a id="tambah" href="{{route('management.category-product.create')}}" class="btn">   <i class="fa fa-plus-circle"></i>  Add   </a>--}}
                    <div class="container" style="border: 1px solid black; padding-top: 1rem">
                        <div class="form-group row">
                            <br>
                            <div class="col-md-3" >
                                <select id="tipe" class="form-control select2" required>
                                    <option value="0"> -- Choose user type --</option>
                                    <option value="2">Indonesian Exporter</option>
                                    <option value="3">Buyer</option>
                                </select>
                            </div>
                            <div class="col-md-3" >
                                <input type="text" class="form-control" id="tanggal_awal" placeholder="Register Date From" style="background-color: white;" readonly required>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="tanggal_akhir" placeholder="Register Date Until" style="background-color: white;" readonly required>
                            </div>
                            <div class="col-md-3">
                                <button id="click" onclick="clicksend()" class="btn btn-info"> Send </button>
                            </div>
                        </div>

                    </div>

{{--                        <button class="btn" type="button" data-toggle="modal" data-target="#modal-show">   <i class="fa fa-hashtag"></i>  Setting Show   </button>--}}
                    <div class="col-md-14"><br>
		          	 <div class="table-responsive">
					    <table id="table" class="table table-bordered table-striped" style="display: none" data-plugin="dataTable">
					      <thead class="text-white" style="background-color: #1089ff;">
					          <tr>
					              <th>No</th>
					              <th>Nama Perusahaan</th>
					              <th>Tanggal Register</th>
					              <th>Tanggal Verifikasi</th>
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