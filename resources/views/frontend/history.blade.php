@include('frontend.layouts.header')
<style type="text/css">
  .nav-me {
    width: 200px !important;
    font-size: 16px !important;
    background-color: white !important;
    border: 2px solid #a8d4f7 !important;
    color: #5fa9f9 !important;
    border-radius: 30px !important;
    text-align: center;
    margin-right: 3px;
  }
  .nav-me.active {
    background-color: #5fa9f9 !important;
    color: white !important;
  }
  .myImg {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
    width: 40px;
  }

  .myImg:hover {opacity: 0.7;}

  /* The Modal (background) */
  .modal {
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
  }

  /* Modal Content (image) */
  .modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
  }

  /* Caption of Modal Image */
  #caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
  }

  /* Add Animation */
  .modal-content, #caption {  
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.6s;
    animation-name: zoom;
    animation-duration: 0.6s;
  }

  @-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)} 
    to {-webkit-transform:scale(1)}
  }

  @keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
  }

  /* The Close Button */
  .close {
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
  }

  .close:hover,
  .close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
  }

  /* 100% Image Width on Smaller Screens */
  @media only screen and (max-width: 700px){
    .modal-content {
      width: 100%;
    }
  }
</style>
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="{{url('/')}}">@lang('frontend.proddetail.home')</a></li>
                            <li>@lang('frontend.history.title')  
							
							</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!--product details start-->
    <div class="product_details mt-20" style="background-color: #ddeffd; font-size: 13px; margin-bottom: 0px !important; margin-top: 0px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                  <br><br>
                    <ul class="nav nav-pills" role="tablist" style="font-size: 13px;">
                      
                      @if(Auth::guard('eksmp')->user()->id_role == 3)
                      <li class="nav-item">
                        <a class="nav-link nav-me active" href="#inquiry" data-toggle="pill" aria-controls="inquiry" aria-selected="false">@lang('frontend.history.inquiry')</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link nav-me" href="#buyreq" data-toggle="pill" aria-controls="buyreq" aria-selected="false">@lang('frontend.history.buyr')</a>
                      </li>
                      @endif
					  <li class="nav-item">
                        <a class="nav-link nav-me <?php if(Auth::guard('eksmp')->user()->id_role == 2){ echo "active"; } ?>" href="#ticket" data-toggle="pill" aria-controls="ticket" aria-selected="false">@lang('frontend.history.ticket')</a>
                      </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade <?php if(Auth::guard('eksmp')->user()->id_role == 2){ echo "show active"; } ?>" id="ticket" role="tabpanel">
                          <br>
                          <div class="row">
                            <div class="col-lg-12 col-md-12">
                              <table id="tableticket" class="table table-bordered table-striped" style="width: 100%; text-transform: capitalize;">
                                <thead class="text-white" style="background-color: #5fa9f9; color: white;">
                                  <tr>
                                    <th width="5%">
                                      <center>@lang('inquiry.number')</center>
                                    </th>
                                    <th width="15%">
                                      <center>@lang('frontend.history.fullname')</center>
                                    </th>
                                    <th width="15%">
                                      <center>@lang('inquiry.subject')</center>
                                    </th>
                                    <th width="15%">
                                      <center>@lang('frontend.history.email')</center>
                                    </th>
                                    <th width="15%">
                                      <center>@lang('inquiry.msg')</center>
                                    </th>
                                    <th width="15%">
                                      <center>@lang('inquiry.status')</center>
                                    </th>
									<th width="15%">
                                      <center>Created at</center>
                                    </th>
                                    <th width="20%">
                                      <center>@lang('inquiry.action')</center>
                                    </th>
                                  </tr>
                                </thead>
                              </table>
                            </div>
                          </div>
                        </div>
						<?php if(Auth::guard('eksmp')->user()->id_role == 3){ ?>
                        <div class="tab-pane fade show active" id="inquiry">                            
                          <br>
                          <div class="row">
                            <div class="col-lg-12 col-md-12">
                              <table id="tableinquiry" class="table table-bordered table-striped" style="width: 100%; text-transform: capitalize;">
                                <thead class="text-white" style="background-color: #5fa9f9; color: white;">
                                  <tr>
                                    <th width="5%">
                                      <center>@lang('inquiry.number')</center>
                                    </th>
                                    <th width="15%">
                                      <center>@lang('inquiry.prodname')</center>
                                    </th>
                                    <th width="15%">
                                      <center>@lang('frontend.history.compeksp')</center>
                                    </th>
                                    <th width="15%">
                                      <center>@lang('inquiry.subject')</center>
                                    </th>
                                    <th width="15%">
                                      <center>@lang('inquiry.kos')</center>
                                    </th>
                                    <th width="15%">
                                      <center>@lang('inquiry.status')</center>
                                    </th>
                                    <th width="20%">
                                      <center>@lang('inquiry.action')</center>
                                    </th>
                                  </tr>
                                </thead>
                              </table>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="buyreq" role="tabpanel">
                          <br>
                          <div class="row">
                            <div class="col-lg-12 col-md-12">
							
                              <table id="tablebureq" class="table table-bordered table-striped" style="width: 100%; text-transform: capitalize;">
                                <thead class="text-white" style="background-color: #5fa9f9; color: white;">
                                  <tr>
                                    <th width="5%">
                                      <center>No</center>
                                    </th>
									<th>
                                      <center>Subject</center>
                                    </th>
                                    <th>
                                      <center>Category</center>
                                    </th>
                                    <th>
                                      <center>Created at</center>
                                    </th>
                                    <th>
                                      <center>Valid Time</center>
                                    </th>
									<th>
                                      <center>Status</center>
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
						<?php } ?>
                    </div>
                    <br><br>
                </div>
            </div>
        </div>
    </div>
  </form>
  <!--product details end-->

  <!-- The Modal -->
  <!-- <div id="modalImage" class="modal">
    <button type="button" class="close" data-dismiss="modal">&times;</buttontype="button">
    <center>
      <img class="modal-content" id="img01">
    </center>
    <div id="caption"></div>
  </div> -->

  <div class="modal" id="modalImage">
    <div class="modal-dialog">
      <!-- <div class="modal-content"> -->
        <button type="button" class="close" data-dismiss="modal">&times;</button><br><br>
        <img class="modal-content" id="img01">
      <!-- </div> -->
    </div>
  </div>
 <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#2e899e; color:white;"> <h6>Broadcast Buying Request</h6>
          <button type="button" class="btn btn-danger" data-dismiss="modal">&times;</button>
         
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

@include('frontend.layouts.footer')
<script type="text/javascript">
function xy(a){
	var token = $('meta[name="csrf-token"]').attr('content');
		$.get('{{URL::to("ambilbroad2/")}}/'+a,{_token:token},function(data){
            $("#isibroadcast").html(data);
            calldata();
			
    })
  }
// function xy(a){
// 	var token = $('meta[name="csrf-token"]').attr('content');
// 		$.get('{{URL::to("ambilbroad/")}}/'+a,{_token:token},function(data){
// 			$("#isibroadcast").html(data);
			
// 		 })
// 	$('.cobas2').select2();

// }

  
    var dataeksportir = [];
    function calldata(){
        var id = $('#id_laporan').val();
        $.ajax({
        method: "POST",
        url: "{!! url('getdatapiliheksportir') !!}",
        data:{_token: '{{csrf_token()}}',id_laporan:id}
      })
      .done(function(data){
        $.each(data, function(i, val){
            $('#tabelpiliheksportir').DataTable().row.add(['<center>'+val.company+'</center>','<center><div class="checkbox"><input class="eksportir" name="eksportir" type="checkbox" value="'+val.id+'"></div></center>']).draw();
                
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
                url: "{{ route('broadcastbuyingrequest.imp') }}",
                data: form_data,
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData: false,
            })
            .done(function(e){
                window.location = '{{url('front_end/history')}}';
                // window.location = '{{ url('/br_list') }}';
            });
        }else{
            alert('make sure to checked at least one exporter');
        }
    }
    // var checkedValue = $('.eksportirterpilih:checked').val();
    function isEmptyM(obj) {
        for(var key in obj) {
            if(obj.hasOwnProperty(key))
                return false;
        }
        return true;
    }


    $(document).ready(function(){
        $('#tableticket').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('front.datatables.ticketing') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'subyek', name: 'subyek'},
                {data: 'email', name: 'email'},
                {data: 'main_messages', name: 'main_messages'},
                {data: 'status', name: 'status'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        $('#tableinquiry').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('front.datatables.inquiry') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'prodname', name: 'prodname'},
                {data: 'exportir', name: 'exportir'},
                {data: 'subject', name: 'subject'},
                {data: 'kos', name: 'kos'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            fixedColumns: true
        });
		    $('#tablebureq').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('front.datatables.br') }}",
            columns: [
                {data: 'row', name: 'row'},
                {data: 'col1', name: 'col1'},
                {data: 'col2', name: 'col2'},
                {data: 'col3', name: 'col3'},
                {data: 'col4', name: 'col4'},
                {data: 'col5', name: 'col5'},
                {data: 'col7', name: 'col7', orderable: false, searchable: false}
            ],
            fixedColumns: true
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

    function openImage(img) {
      var url = "{{url('/')}}/"+img;
      $('#modalImage').modal('show');
      $('#img01').attr("src", url);
    }
</script>