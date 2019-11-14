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
                            <li><a href="{{url('/front_end')}}">@lang('frontend.proddetail.home')</a></li>
                            <li>@lang('frontend.history.title')</li>
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
                      <li class="nav-item">
                        <a class="nav-link nav-me active" href="#ticket" data-toggle="pill" aria-controls="ticket" aria-selected="false">@lang('frontend.history.ticket')</a>
                      </li>
                      @if(Auth::guard('eksmp')->user()->id_role == 3)
                      <li class="nav-item">
                        <a class="nav-link nav-me" href="#inquiry" data-toggle="pill" aria-controls="inquiry" aria-selected="false">@lang('frontend.history.inquiry')</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link nav-me" href="#buyreq" data-toggle="pill" aria-controls="buyreq" aria-selected="false">@lang('frontend.history.buyr')</a>
                      </li>
                      @endif
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="ticket" role="tabpanel">
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
                                    <th width="20%">
                                      <center>@lang('inquiry.action')</center>
                                    </th>
                                  </tr>
                                </thead>
                              </table>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="inquiry">                            
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
                                      <center>Subyek</center>
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

@include('frontend.layouts.footer')
<script type="text/javascript">
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
    });

    function openImage(img) {
      var url = "{{url('/')}}/"+img;
      $('#modalImage').modal('show');
      $('#img01').attr("src", url);
    }
</script>