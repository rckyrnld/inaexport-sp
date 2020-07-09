@include('header')

<div class="padding">
    <div class="row">
    <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <div class="row">
                        <div class="col-md-3">
                            <h5><i></i> Report Exporter</h5>
                        </div>
                        <div class="col-md-5"></div>
                        <div class="col-md-4">
                            <a target="_blank" href="annual_sales/cetak"><i class='fa fa-print text-info' style='font-size: 200%;' title='print'></i></a>
                        </div>
                    </div>
                </div>

                <div class="box-body bg-light">

                    <!-- <div class="col-md-12"> -->
                        <br>
                        <div class="table-responsive">
                            <table id="tableeksportir" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <!-- <tr>
                                    <th style="width: 10px !important">No</th>
                                    <th style="width: 30px !important">
                                        <center>Company</center>
                                    </th>
                                    <th style="width: 20px!important">
                                        <center>Address</center>
                                    </th>
                                    <th style="width: 10px!important">
                                        <center>Province</center>
                                    </th>
                                    <th style="width: 15px!important">
                                        <center>Email</center>
                                    </th>
                                    <th style="width: 15px!important">
                                        <center>PIC Name</center>
                                    </th>
                                    <th style="width: 15px!important">
                                        <center>PIC Telephone</center>
                                    </th>
                                    <th style="width: 15px!important">
                                        <center>Verify Date</center>
                                    </th>

                                    <th style="width: 10px!important">
                                        <center>Action</center>
                                    </th>
                                </tr> -->
                                <tr role="row">
                                    <th>No</th>
                                    <th>
                                        <center>Company</center>
                                    </th>
                                    <th>
                                        <center>Address</center>
                                    </th>
                                    <th>
                                        <center>Province</center>
                                    </th>
                                    <th>
                                        <center>Email</center>
                                    </th>
                                    <th>
                                        <center>PIC Name</center>
                                    </th>
                                    <th>
                                        <center>PIC Telephone</center>
                                    </th>
                                    <th>
                                        <center>Verify Date</center>
                                    </th>

                                    <th>
                                        <center>Action</center>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>

                            </table>
                        </div>
                    <!-- </div> -->
                </div>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('#tableeksportir').DataTable({
            processing: true,
            serverSide: true,
            // stateSave: true,
            // bAutoWidth: false, 
            ajax: "{{ route('datatables.reporteksportir') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex',width: '10%',orderable: false, searchable: false},
                {data: 'f1', name: 'f1',width: '10%',orderable: true, searchable: true},
                {data: 'f2', name: 'f2',width: '10%',orderable: true, searchable: true},
                {data: 'province', name: 'province',width: '10%',orderable: true, searchable: true},
                {data: 'email', name: 'email',width: '10%',orderable: true, searchable: true},
                {data: 'pic_name', name: 'pic_name',width: '10%',orderable: false, searchable: false},
                {data: 'pic_telp', name: 'pic_telp',width: '10%',orderable: false, searchable: false},
                {data: 'verify_date', name: 'verify_date',width: '10%',orderable: true, searchable: true},
                
                {
                    data: 'action', name: 'action', orderable: false, searchable: false
                }
            ],
            // {data: 'f3', name: 'f3'},
                // {data: 'f4', name: 'phone'},
                // {data: 'fax', name: 'fax'},
            // scrollX:        true,
            // scrollCollapse: true,
            // aoColumns : [
            //     { sWidth: '10%' },
            //     { sWidth: '10%' },
            //     { sWidth: '10%' },
            //     { sWidth: '10%' },
            //     { sWidth: '10%' },
            //     { sWidth: '10%' },
            //     { sWidth: '10%' },
            //     { sWidth: '10%' },
            //     { sWidth: '10%' },
            // ]
            // columnDefs: [
            //     { width: '10px', targets: 0 },
            //     { width: '100px', targets: 1 },
            //     { width: '50px', targets: 2 },
            //     { width: '50px', targets: 3 },
            //     { width: '50px', targets: 4 },
            //     { width: '50px', targets: 5 },
            //     { width: '50px', targets: 6 },
            //     { width: '50px', targets: 7 },
            //     { width: '50px', targets: 8 }
            // ],
            // fixedColumns: true
        });
    });
</script>
<!-- <style>
        #tableeksportir thead th:first-child {
            width: 10%;
        }
        #tableeksportir thead th:nth-child(2) {
            width: 20%;
        }
        #tableeksportir thead th:nth-child(3) {
            width: 10%;
        }        
        #tableeksportir thead th:nth-child(4) {
            width: 10%;
        }        
        #tableeksportir thead th:nth-child(5) {
            width: 10%;
        }        
        #tableeksportir thead th:nth-child(6) {
            width: 10%;
        }       
         #tableeksportir thead th:nth-child(7) {
            width: 10%;
        }
        #tableeksportir thead th:nth-child(8) {
            width: 10%;
        }
    </style> -->
@include('footer')