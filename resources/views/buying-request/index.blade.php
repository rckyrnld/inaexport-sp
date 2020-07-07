@include('header')

<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> Buying Request</h5>
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
                    <div class="col-md-14">
                        
                        <div class="table-responsive">
						<a href="{{ url('br_add') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add</a><br><br>
                          
                           <table id="users-table" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        <center>Product Name</center>
                                    </th>
                                    <th>
                                        <center>Category</center>
                                    </th>
									<th>
                                        <center>Date</center>
                                    </th>
                                    <th>
                                        <center>Duration</center>
                                    </th>
									<th>
                                        <center>Status</center>
                                    </th>
									<th width="18%">
                                        <center>Action</center>
                                    </th>
                                </tr>
                                </thead>
								<tbody>
								
								</tbody>

                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#2e899e; color:white;"> <h6>Broadcast Buying Request</h6>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
		<div id ="isibroadcast"></div>
        <!--<div class="modal-body">
          1
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> -->
      </div>
    </div>
  </div>
 <script type="text/javascript">
 
 var dataeksportir = [];
function xy(a){
	var token = $('meta[name="csrf-token"]').attr('content');
		$.get('{{URL::to("ambilbroad2/")}}/'+a,{_token:token},function(data){
            $("#isibroadcast").html(data);
            calldata();
			
         })
        
         
}
function calldata(){
    var id = $('#id_laporan').val();
    $.ajax({
		method: "POST",
		url: "{!! url('getdatapiliheksportir') !!}",
		data:{_token: '{{csrf_token()}}',id_laporan:id}
	})
	.done(function(data){
		$.each(data, function(i, val){
	    	$('#tabelpiliheksportir').DataTable().row.add([val.company,'<div class="checkbox"><input class="eksportir" name="eksportir" type="checkbox" value="'+val.id+'"></div>']).draw();
            
            // $('#tabelpiliheksportir').DataTable().row.add([val.company]).draw();
		});
	});
     

}


function savecheckall(){
    $.each($("input[name='eksportir']:checked"), function(){
        val = $(this).val();
        if(dataeksportir.includes(val)){
        }else{
            $('input:checkbox[value=' + val + ']').attr('disabled', true)
            dataeksportir.push($(this).val());
        }
    });
    $("input[name='checkall']").prop('checked', false);
}

function broadcast(){
    var id = $('#id_buyingrequest').val();
    // var dataeksportir = [];
    // dataTable.rows().nodes().to$().find('input[name="eksportir"]').each(function(){
    //     dataeksportir.push($(this).val());
    // })
    $.each($("input[name='eksportir']:checked"), function(){
        var val = $(this).val();
        if(dataeksportir.includes(val)){
       
        }else{
            dataeksportir.push($(this).val());
        }
    });
    if (!isEmptyM(dataeksportir)) {
        var form_data = new FormData();
        form_data.append('id',id);
        form_data.append('dataeksportir',dataeksportir);
        $.ajaxSetup({
                    headers:
                        {
                            'X-CSRF-Token': '{{csrf_token()}}'
                        }
        });
        $.ajax({
            method: "POST",
            url: "{{ route('broadcastbuyingrequest.pw') }}",
            data: form_data,
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData: false,
        })
        .done(function(e){
            console.log(e);
            
            window.location = "{{ route('br_list.message') }}";
            // window.location = '{{ url('/br_list') }}';
        });
    }else{
        alert('make sure to checked at least one exporter');
    }
    // var checkedValue = $('.eksportirterpilih:checked').val();
    function isEmptyM(obj) {
            for(var key in obj) {
                if(obj.hasOwnProperty(key))
                    return false;
            }
            return true;
        }
        
    
}
</script>

<script type="text/javascript">
    $(function () {
        
        $(".alert").slideDown(300).delay(1000).slideUp(300);
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('getcscperwakilan') }}",
            columns: [
                {data: 'row', name: 'row'},
                {data: 'f1', name: 'f1'},
                {data: 'f4', name: 'f4'},
                {data: 'f3', name: 'f3'},
                {data: 'f2', name: 'f2'},
                
				{
					data: 'f7', name: 'f7', orderable: false, searchable: false
				},
                {
                    data: 'action', name: 'action', orderable: false, searchable: false
                }]
        });

        $("#tabelpiliheksportir").DataTable({
			processing: true,
            orderable: false,
            language: {
                processing: "Sedang memproses...",
                lengthMenu: "Tampilkan MENU entri",
                zeroRecords: "Tidak ditemukan data yang sesuai",
                emptyTable: "Tidak ada data yang tersedia pada tabel ini",
                info: "Menampilkan START sampai END dari TOTAL entri",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                infoFiltered: "(disaring dari MAX entri keseluruhan)",
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
    });

    function ConfirmDelete()
    {
      var x = confirm("Are you sure you want to delete?");
      if (x)
          return true;
      else
        return false;
    }


</script>


@include('footer')
