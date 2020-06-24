@include('header')
<style>
    #set_reminder.nav-link.active, #set_inquiry.nav-link.active {
        background-color: #40bad2 !important;
        color: white !important;
    }
</style>
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> List Inquiry</h5>
                </div>
                <div class="box-body bg-light">
                    <div class="col-md-14">
                        <div id="exTab2" class="container"> 
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a class="nav-link active" href="#reminder" id="set_reminder" data-toggle="tab"><h6><b>Reminder</b></h6></a></li>
                                <li class="nav-item"><a class="nav-link" href="#inquiry" id="set_inquiry" data-toggle="tab"><h6><b>Inquiry</b></h6></a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="reminder">
                                    <br>
                                    <div class="table-responsive">
                                        <table id="tablereminder" class="table  table-bordered table-striped" style="text-transform: capitalize;">
                                            <thead class="text-white" style="background-color: #1089ff;">
                                            <tr>
                                                <th width="5%">
                                                    <center>No</center>
                                                </th>
                                                <th>
                                                    <center>Created By</center>
                                                </th>
                                                <th>
                                                    <center>Creater Status</center>
                                                </th>
                                                <th>
                                                    <center>Subject</center>
                                                </th>
                                                <th>
                                                    <center>Date</center>
                                                </th>
                                                <!-- <th>
                                                    <center>Kind of Subject</center>
                                                </th> -->
												<th>
                                                    <center>Duration</center>
                                                </th>
                                                <th>
                                                    <center>Origin</center>
                                                </th>
                                                <th width="20%">
                                                    <center>Action</center>
                                                </th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="inquiry">
                                    <br>
                                    <div class="table-responsive">
                                        <table id="tableinquiry" class="table  table-bordered table-striped">
                                          <thead class="text-white" style="background-color: #1089ff;">
                                            <tr>
                                              <th width="5%">
                                                <center>No</center>
                                              </th>
                                              <th>
                                                <center>Category Product</center>
                                              </th>
                                              <th>
                                                    <center>Created By</center>
                                                </th>
                                                <th>
                                                    <center>Creater Status</center>
                                                </th>
                                              <th>
                                                <center>Subject</center>
                                              </th>
                                              <th>
                                                <center>Date</center>
                                              </th>
                                              <!-- <th>
                                                <center>Kind Of Subject</center>
                                              </th> -->
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

@include('footer')

<script>
    $(document).ready(function () {
        $('#tablereminder').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('eksportir.inquiry.getData', 1) }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
               {data: 'created_by', name: 'created_by'},
               {data: 'creater_status', name: 'creater_status'},
                {data: 'subject', name: 'subject'},
                {data: 'date', name: 'date'},
				 {data: 'duration', name: 'duration'},
               /* {data: 'kos', name: 'kos'}, */
                {data: 'origin', name: 'origin'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        $('#tableinquiry').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('eksportir.inquiry.getData', 2) }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'category', name: 'category'},
               {data: 'created_by', name: 'created_by'},
               {data: 'creater_status', name: 'creater_status'},
                {data: 'subject', name: 'subject'},
                {data: 'date', name: 'date'},
              /*  {data: 'kos', name: 'kos'}, */
                {data: 'msg', name: 'msg'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>