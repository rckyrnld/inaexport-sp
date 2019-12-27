@include('header')
<style>
    #set_admin.nav-link.active, #set_perwakilan.nav-link.active, #set_importir.nav-link.active {
        background-color: #40bad2 !important;
        color: white !important;
    }
    /*CSS MODAL*/
    .modal-lg{ width: 700px; }
    .modal-header { background-color: #84afd4; color: white; font-size: 20px; text-align: center;}
    .modal-body{ height: 300px; }
    .modal-content { border-bottom-left-radius: 20px; border-bottom-right-radius: 20px; border-top-left-radius: 20px; border-top-right-radius: 20px; overflow: hidden;}
    .modal-footer { background-color: #84afd4; color: white; font-size: 20px; text-align: center;}
</style>
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> List Inquiry</h5><br>
                    <a class="btn" href="{{url('/inquiry_admin/create')}}" style="background-color: #1089ff; color: white;"><i class="fa fa-plus-circle"></i> Add</a>
                </div>
                <div class="box-body bg-light">
                    <div class="col-md-14">
                        <div id="exTab2" class="container"> 
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a class="nav-link active" href="#admin" id="set_admin" data-toggle="tab"><h6><b>Admin</b></h6></a></li>
                                <li class="nav-item"><a class="nav-link" href="#perwakilan" id="set_perwakilan" data-toggle="tab"><h6><b>Representative</b></h6></a></li>
                                <li class="nav-item"><a class="nav-link" href="#importir" id="set_importir" data-toggle="tab"><h6><b>Importer</b></h6></a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="admin">
                                    <br>
                                    <div class="table-responsive">
                                        <table id="tableadmin" class="table  table-bordered table-striped" style="text-transform: capitalize;">
                                            <thead class="text-white" style="background-color: #1089ff;">
                                                <tr>
                                                  <th width="5%">
                                                    <center>No</center>
                                                  </th>
                                                  <th>
                                                    <center>Category Product</center>
                                                  </th>
                                                  <th>
                                                    <center>Subject</center>
                                                  </th>
                                                  <th>
                                                    <center>Date</center>
                                                  </th>
                                                  <th>
                                                    <center>Kind Of Subject</center>
                                                  </th>
                                                  <th width="15%">
                                                    <center>Messages</center>
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
                                <div class="tab-pane" id="perwakilan">
                                    <br>
                                    <div class="table-responsive">
                                        <table id="tableperwakilan" class="table  table-bordered table-striped">
                                            <thead class="text-white" style="background-color: #1089ff;">
                                                <tr>
                                                  <th width="5%">
                                                    <center>No</center>
                                                  </th>
                                                  <th>
                                                    <center>Name</center>
                                                  </th>
                                                  <th>
                                                    <center>Action</center>
                                                  </th>
                                                </tr>
                                            </thead>
                                        </table>
                                      </div>
                                </div>
                                <div class="tab-pane" id="importir">
                                    <br>
                                    <div class="table-responsive">
                                        <table id="tableimportir" class="table  table-bordered table-striped" style="text-transform: capitalize;">
                                            <thead class="text-white" style="background-color: #1089ff;">
                                                <tr>
                                                  <th width="5%">
                                                    <center>No</center>
                                                  </th>
                                                  <th>
                                                    <center>Company Name</center>
                                                  </th>
                                                  <th>
                                                    <center>Category Product</center>
                                                  </th>
                                                  <th>
                                                    <center>Subject</center>
                                                  </th>
                                                  <th>
                                                    <center>Date</center>
                                                  </th>
                                                  <th>
                                                    <center>Kind Of Subject</center>
                                                  </th>
                                                  <th width="15%">
                                                    <center>Messages</center>
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
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<!-- The Modal -->
  <div class="modal fade" id="modalBroadcast">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4><center><b>Broadcast Inquiry</b></center></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{url('/inquiry_admin/broadcasting')}}" id="formnya">
            {{ csrf_field() }}
                <br><br>
                <div class="row">
                    <div class="col-md-3">
                        <label style="font-size: 15px;"><b>Subject</b></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="subjectnya" id="subjectnya" class="form-control" readonly>
                        <input type="hidden" name="idnya" id="idnya" class="form-control">
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-3">
                        <label style="font-size: 15px;"><b>Category Product</b></label>
                    </div>
                    <div class="col-md-9">
                        <select class="form-control" id="categori" style="width: 100% !important;" width="90%" name="categori[]" multiple="multiple" required>{{optionCategory()}}
                        </select>
                    </div>
                </div><br><br>
                <div class="row">
                    <div class="col-md-12">
                        <center>
                            <button type="submit" class="btn btn-primary" style="width: 20%; margin-right: 4%;">Send</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" style="width: 20%;">Close</button>
                        </center>            
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
            
        </div>
        
      </div>
    </div>
  </div>

@include('footer')

<script>
    $(document).ready(function () {
        $('#tableadmin').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.inquiry.getDataAdmin') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'category', name: 'category'},
                {data: 'subject', name: 'subject'},
                {data: 'date', name: 'date'},
                {data: 'kos', name: 'kos'},
                {data: 'msg', name: 'msg'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        $('#tableperwakilan').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.inquiry.getPerwakilan') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        $('#tableimportir').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.inquiry.getDataImportir') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'company', name: 'company'},
                {data: 'category', name: 'category'},
                {data: 'subject', name: 'subject'},
                {data: 'date', name: 'date'},
                {data: 'kos', name: 'kos'},
                {data: 'msg', name: 'msg'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        //kategori broadcast
        $('#categori').select2({
          sorter: function(data) {
            return data.sort(function(a, b) {
                return a.text < b.text ? -1 : a.text > b.text ? 1 : 0;
            });
        }
        }).on("select2:select", function (e) { 
          $('.select2-selection__rendered li.select2-selection__choice').sort(function(a, b) {
              return $(a).text() < $(b).text() ? -1 : $(a).text() > $(b).text() ? 1 : 0;
            }).prependTo('.select2-selection__rendered');
        });
    });

    function broadcastInquiry(isi) {
        var isi = isi.split('|');
        var id = parseInt(isi[1]);
        var subject = isi[0];

        $('#idnya').val(id);
        $('#subjectnya').val(subject);
        $('#modalBroadcast').modal('show');
    }
</script>