@include('header')
<style type="text/css">
	th {text-align: center;}
	td {color: black;}
	#tambah { background-color: #1a9cf9; color: white; white-space: pre;}
	#tambah:hover {background-color: #148de4}
	#export { background-color: #28bd4a; color: white; white-space: pre;}
	#export:hover {background-color: #08b32e}
</style>
<style type="text/css">
    .full-banner{
        width: 100%;
        right: 0;
    }
    .content{
        margin-top:5%;
    }

    .main-sidebar{
        padding-top: 15%;
    }
    .over{
        overflow: auto;
        max-width: 100%;
    }


    .switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 34px;
    }

    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 26px;
      width: 26px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }

    input:checked + .slider {
      background-color: #2196F3;
    }

    input:focus + .slider {
      box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
      border-radius: 34px;
    }

    .slider.round:before {
      border-radius: 50%;
    }
</style>
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> List Banner</h5>
                </div>

                <div class="box-body bg-light">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block" style="text-align: center">
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block" style="text-align: center">
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                	<a id="tambah" href="{{route('master.banner.create')}}" class="btn">   <i class="fa fa-plus-circle"></i>  Add   </a>

                    <div class="col-md-14"><br>
		          	 <div class="table-responsive">
					    <table id="satu" class="table  table-bordered table-striped">
					      <thead class="text-white" style="background-color: #1089ff;">
					          <tr>
					              <th width="5%">No</th>
					              <th>File</th>
					              <th>Until</th>
					              <th width="10%">Status</th>
					              <th width="5%">Action</th>
					          </tr>
					      </thead>
						  <tbody>
					    </table>
					  </div>
      	  			</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modalEdit" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Modal Header</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form class="form-horizontal" method="POST" action="{{ route('master.banner.store', 'update') }}" enctype="multipart/form-data">
      {{ csrf_field() }}<br>
      <div class="modal-body">
      	<input type="hidden" name="id" id="id">
      	<input type="hidden" name="semua" id="semua">
        <div class="form-group">
        	<label class="control-label col-md-3">Status</label>
        	<div class="col-md-9">
        		<span>Tidak Aktif</span>
      			<label class="switch">
        		<input type="checkbox" id="check">
        			<span class="slider round"></span>
      			</label>
      			<input type="hidden" id="status" name="status" value="0">
      			<span>Aktif</span>
        	</div>
        </div>
        <div id="pilihcompany" style="display: none;">
        	<div class="form-group">
            <label class="control-label col-md-2" for="date">Active Until</label>
            <div class="col-md-4">
              <input type="Date" class="form-control" name="s_date" id="s_date" autocomplete="off" required>
            </div>
          </div>
          <div class="row" align="right">
              <div class="col-md-6">
              </div>	
              <div class="col-md-6" style="color: black !important;">
                <input  type='checkbox' class='checkall' name='checkall' id='checkall' value=''> Check All
              </div>
          </div>
        	<table id="company" class="table table-bordered table-striped table-hover">
        		<thead>
        			<tr>
        				<th>No</th>
        				<th>Company</th>
        				<th>Aksi</th>
        			</tr>
        		</thead>
          </table>
          <div class="row">
            <div class="col-md-9">
            </div>
            <div class="col-md-3">
              <button onclick="savecheckall()" type="button" class="btn btn-primary" title="save selected company in this page">Save</button>
            </div>
          </div>
        </div>
        
      </div>
     
       <br>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="simpanupdate()">Simpan</button>
      </div>
  		</form>
    </div>

  </div>
</div>

<div id="modalEdit2" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Modal Header</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form class="form-horizontal" method="POST" action="{{ route('master.banner.store', 'update') }}" enctype="multipart/form-data">
      {{ csrf_field() }}<br>
      <div class="modal-body">
      	<input type="hidden" name="id2" id="id2">
      	<input type="hidden" name="semua2" id="semua2">
        <div class="form-group">
        	<label class="control-label col-md-3">Status</label>
        	<div class="col-md-9">
        		<span>Tidak Aktif</span>
      			<label class="switch">
        		<input type="checkbox" id="check2">
        			<span class="slider round"></span>
      			</label>
      			<input type="hidden" id="status2" name="status2" value="0">
      			<span>Aktif</span>
        	</div>
        </div>
        <div id="pilihcompany2" style="display: none;">
        	<div class="form-group">
            <label class="control-label col-md-2" for="date">Active Until</label>
            <div class="col-md-4">
              <input type="Date" class="form-control" name="s_date2" id="s_date2" autocomplete="off" required>
            </div>
          </div>
          <div class="row" align="right">
              <div class="col-md-6">
              </div>	
              <div class="col-md-6" style="color: black !important;">
                <input  type='checkbox' class='checkall2' name='checkall2' id='checkall2' value=''> Check All
              </div>
          </div>
        	<table id="company2" class="table table-bordered table-striped table-hover">
        		<thead>
        			<tr>
        				<th>No</th>
        				<th>Company</th>
        				<th>Aksi</th>
        			</tr>
        		</thead>
          </table>
          <div class="row">
            <div class="col-md-9">
            </div>
            <div class="col-md-3">
              <button onclick="savecheckall2()" type="button" class="btn btn-primary" title="save selected company in this page">Save</button>
            </div>
          </div>
          <div class="form-group">
              <label class="control-label col-md-3">File Image</label>
              <div class="col-md-9">
                  <input type="file" class="form-control" name="file" id="file"><br>
                  <a href="" target="_blank" class="btn btn-outline-secondary"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;Previous Document</a><br>
                  <input type="hidden" name="lastest_file" id="lastest_file" value="fileimagenya">
              </div>
          </div>
        </div>
        
      </div>
     
       <br>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="simpanupdate2()">Simpan</button>
      </div>
  		</form>
    </div>

  </div>
</div>

@include('footer')
<script type="text/javascript">
	var idbanner = 0;
	var idbanner2 = 0;
	var counter = [];
  var dataeksportir = [];
  var dataeksportir2 = [];
	$(document).ready(function () {
		$("#company").DataTable({
			processing: true,
			columnDefs: [
				{ "orderable": false, "targets": 2 }
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
    $("#company2").DataTable({
			processing: true,
			columnDefs: [
				{ "orderable": false, "targets": 2 }
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
		$('#check').change(function() {
	      if($(this).is(':checked')) {
	          $('#status').val(1);
	          $('#company').DataTable().clear().draw();
				$.ajax({
					method: "POST",
					url: "{{ route('master.banner.getCompany') }}",
					data:{_token: '{{csrf_token()}}',id:idbanner}
				})
				.done(function(data){
					$.each(data, function(i, val){
						$('#company').DataTable().row.add([val.no,val.company,'<div class="checkbox"><input class="masuk" type="checkbox" value="'+val.id+'" name="comp" ></div>']).draw();
					});
					$('#pilihcompany').show();
				});
	      } else {
	        $('#status').val(2);
	        $('#pilihcompany').hide();
	      }
	  });
    $('#check2').change(function() {
	      if($(this).is(':checked')) {
          check2active();
          
	      } else {
	        $('#status2').val(2);
	        $('#pilihcompany2').hide();
	      }
	  });
    
    $('#satu').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url":'{!! route('master.banner.getData') !!}',
                "dataType":"json",
                "type":"POST",
                "data":{_token: '{{csrf_token()}}'}
            },
            "columns": [
                {data: 'no'},
                {data: 'file'},
                {data: 'until'},
                {data: 'status'},
                {data: 'aksi'},
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

        $('#modalEdit').on('show.bs.modal', function(e) {
            $('#company').DataTable().clear().draw();
            idbanner = $(e.relatedTarget).data('edit-id');
            $('#id').val(idbanner);
        });

        $('#modalEdit2').on('show.bs.modal', function(e) {
            $('#company2').DataTable().clear().draw();
            idbanner2 = $(e.relatedTarget).data('edit-id');
            $('#id2').val(idbanner2);
            checkbanner2 = $(e.relatedTarget).data('check-id');
            endatbanner2 = $(e.relatedTarget).data('endat-id');
            filebanner2 = $(e.relatedTarget).data('image-id');
            if(checkbanner2 == 1){
              $('#check2').prop("checked", true);
              check2active();
            }else{
              $('#check2').prop("checked", false);
            }
            //untuk set beberapa data bawaan
              endatbanner2 = $(e.relatedTarget).data('endat-id');
              filebanner2 = $(e.relatedTarget).data('image-id');
              var from = endatbanner2.split("-");
              var f = new Date(from[2], from[1] - 1, from[0]);
              var day = ("0" + f.getDate()).slice(-2);
              var month = ("0" + (f.getMonth() + 1)).slice(-2);
              var date = f.getFullYear()+"-"+(month)+"-"+(day) ;
              $('#s_date2').val(date);
              //untuk hidden file
              $('#modalEdit2 input[name="lastest_file"]').each(function() {
                  var text = $(this).val();
                  $(this).val(text.replace('fileimagenya', filebanner2));
              });
              //untuk file previous
              var hrefnya = "{{ url('/').'/uploads/banner/'}}" + filebanner2;
              $("#modalEdit2 a").attr("href", hrefnya);
        });
        $('#checkall').change(function() {
          if(this.checked) {
              $('#semua').val(1);
          }else{
              $('#semua').val(0);
              $("input[name='comp']").prop('checked', false);
              dataeksportir = [];
          }     
        });
        $('#checkall2').change(function() {
          if(this.checked) {
              $('#semua2').val(1);
          }else{
              $('#semua2').val(0);
              $("input[name='comp2']").prop('checked', false);
              dataeksportir2 = [];
          }     
        });

});

        function savecheckall(){
              $.each($(".semua:checked"), function(){
                  val = $(this).val();
                  if(dataeksportir.includes(val)){
                  }else{
                      $('input:checkbox[value=' + val + ']').attr('disabled', true)
                      dataeksportir.push($(this).val());
                      // $(this).prop('checked', false);
                  }
              });
              // $("input[name='checkall']").prop('checked', false);
        }

        function savecheckall2(){
              $.each($(".semua2:checked"), function(){
                  val = $(this).val();
                  if(dataeksportir2.includes(val)){
                  }else{
                      $('input:checkbox[value=' + val + ']').attr('disabled', true)
                      dataeksportir2.push($(this).val());
                      // $(this).prop('checked', false);
                  }
              });
              // $("input[name='checkall']").prop('checked', false);
        }


    function simpanupdate(){
        var id = $('#id').val();
        var s_date = $('#s_date').val();
        var semua = $('#semua').val();
        var status = $('#status').val();
        $.each($("input[name='comp']:checked"), function(){
                  var val = $(this).val();
                  if(dataeksportir.includes(val)){
                
                  }else{
                      dataeksportir.push($(this).val());
                  }
        });
        if ((!isEmptyM(dataeksportir) || semua == 1) && s_date != null) {
            var form_data = new FormData();
            form_data.append('id',id);
            form_data.append('dataeksportir',dataeksportir);
            form_data.append('s_date',s_date);
            form_data.append('semua',semua);
            form_data.append('status',status);
            $.ajaxSetup({
                headers:
                {
                    'X-CSRF-Token': '{{csrf_token()}}'
                }
            });
            $.ajax({
                method: "POST",
                url: "{{ route('master.banner.store', 'update') }}",
                data: form_data,
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData: false,
            })
            .done(function(e){
              if(e == 'sukses'){
                  window.location = "{{ route('master.banner.message') }}";
              }else{
                  window.location = "{{ route('master.banner.message') }}";
              }
            });
        }else{
            alert('make sure to checked at least one exporter');
        }
    }

    function check2active(){
        $('#status2').val(1);
              $('#company2').DataTable().clear().draw();
              $.ajax({
                method: "POST",
                url: "{{ route('master.banner.getCompany2') }}",
                data:{_token: '{{csrf_token()}}',id:idbanner2}
              })
              .done(function(data){
                $.each(data, function(i, val){
                  if(val.status == 1){
                    $('#company2').DataTable().row.add([val.no,val.company,'<div class="checkbox"><input class="masuk2done" type="checkbox" value="'+val.id+'" checked disabled name="comp2done" ></div>']).draw();
                  } else{
                    $('#company2').DataTable().row.add([val.no,val.company,'<div class="checkbox"><input class="masuk2" type="checkbox" value="'+val.id+'" name="comp2" ></div>']).draw();
                  
                  }
                  });
                $('#pilihcompany2').show();
              });
    }



    function simpanupdate2(){
        var id = $('#id2').val();
        var s_date = $('#s_date2').val();
        var semua = $('#semua2').val();
        var status = $('#status2').val();
        var file = $('#file').val();
        var lastest_file = $('#lastest_file').val();
        $.each($("input[name='comp2']:checked"), function(){
                  var val = $(this).val();
                  if(dataeksportir2.includes(val)){
                
                  }else{
                      dataeksportir2.push($(this).val());
                  }
        });
        // (!isEmptyM(dataeksportir2) || semua == 1 ) &&
        if ( s_date != null && (lastest_file != 'fileimagenya' || $file != null)) {
            var form_data = new FormData();
            form_data.append('id',id);
            form_data.append('dataeksportir',dataeksportir2);
            form_data.append('s_date',s_date);
            form_data.append('semua',semua);
            form_data.append('status',status);
            form_data.append('file',$('#file').prop('files')[0]);
            $.ajaxSetup({
                headers:
                {
                    'X-CSRF-Token': '{{csrf_token()}}'
                }
            });
            $.ajax({
                method: "POST",
                url: "{{ route('master.banner.store', 'update2') }}",
                data: form_data,
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData: false,
            })
            .done(function(e){
              if(e == 'sukses'){
                  window.location = "{{ route('master.banner.message') }}";
              }else{
                  window.location = "{{ route('master.banner.message') }}";
              }
            });
        }else{
            alert('make sure to checked at least one exporter');
        }
    }

    function isEmptyM(obj) {
        for(var key in obj) {
            if(obj.hasOwnProperty(key))
                return false;
            }
                return true;
    }
    
</script>