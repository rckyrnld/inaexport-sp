@include('header')

<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> List Product</h5>
                </div>
                <div class="box-body bg-light">
                    <!-- <a class="btn" href="{{url('/eksportir/tambah_product')}}"
                       style="background-color: #1089ff; color: white;"><i
                                class="fa fa-plus-circle"></i>
                        Tambah</a> -->
                    <div class="col-md-12" style="max-width: 100%;">
                        <!-- <div class="table-responsive"> -->
                            <table width="320px" id="tablebrands" class="table  table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th style="width:20px!important;padding-left:2px;padding-right:5px;">No</th>
                                    <th  style="width:30px!important;padding-left:2px;padding-right:5px;">
                                        Code
                                    </th>
                                    <th  style="width:30px!important;padding-left:2px;padding-right:5px;">
                                        Product Name
                                    </th>
                                    <th style="width:20px!important;padding-left:2px;padding-right:5px;">
                                        Company Name
                                    </th>
                                    <th style="width:20px!important;padding-left:2px;padding-right:5px;">
                                        Color
                                    </th>
                                    <th style="width:30px!important;padding-left:2px;padding-right:5px;">
                                        Size
                                    </th>
                                    <th style="width:30px!important;padding-left:2px;padding-right:5px;">
                                        Raw Material
                                    </th>
                                    <th style="width:30px!important;padding-left:2px;padding-right:5px;">
                                        Capacity
                                    </th>
                                    <th style="width:20px!important;padding-left:2px;padding-right:5px;">
                                        Price (USD)
                                    </th>
                                    <th style="width:30px!important;padding-left:2px;padding-right:5px;">
                                        Description Product
                                    </th>
                                    <th style="width:20px!important;padding-left:2px;padding-right:5px;">
                                        Status
                                    </th>
                                    <th style="width:20px!important;padding-left:2px;padding-right:5px;">
                                        Information
                                    </th>
                                    <th style="width:20px!important;padding-left:2px;padding-right:5px;">
                                        Action
                                    </th>
                                </tr>
                                </thead>

                            </table>
                            <br>
                            
                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('footer')

<script>
    $(document).ready(function () {
        $('#tablebrands').DataTable({
            processing: true,
            serverSide: true,
            // scrollX : true, 
            scrollX: 200,
            scroller: {
                loadingIndicator: true
            },
            ajax: "{{ route('datatables.eksproduct_admin_un', $id_profil) }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth: '10px'},
                {data: 'code_en', name: 'code_en',sWidth: '20px'},
                {data: 'prodname_en', name: 'prodname_en',sWidth: '20px'},
                {data: 'company_name', name: 'company_name',sWidth: '20px'},
                {data: 'color_en', name: 'color_en',sWidth: '20px'},
                {data: 'size_en', name: 'size_en',sWidth: '20px'},
                {data: 'raw_material_en', name: 'raw_material_en',sWidth: '20px'},
                {data: 'capacity', name: 'capacity',sWidth: '20px'},
                {data: 'price_usd', name: 'price_usd',sWidth: '20px'},
                {data: 'product_description', name: 'product_description',sWidth: '20px'},
                {data: 'status', name: 'status',sWidth: '20px'},
                {data: 'information', name: 'information',sWidth: '20px'},
                {data: 'action', name: 'action', orderable: false, searchable: false,sWidth: '10px'},
                
            ],
            bAutoWidth: false, 
            // Columns : [
            //     { sWidth: '5%' },
            //     { sWidth: '10%' },
            //     { sWidth: '10%' },
            //     { sWidth: '10%' },
            //     { sWidth: '10%' },
            //     { sWidth: '10%' },
            //     { sWidth: '10%' },
            //     { sWidth: '10%' },
            //     { sWidth: '10%' },
            //     { sWidth: '5%' },
            //     { sWidth: '5%' },
            //     { sWidth: '5%' },
            //     { sWidth: '5%' },

            // ]
            
        });
    });
</script>
<style>
    /* #tablebrands.dataTable td:nth-child(1) {
        width: 20px;
        max-width: 20px;
        word-break: break-all;
        white-space: pre-line;
    }
    #tablebrands.dataTable td:nth-child(1) {
        width: 70px;
        max-width: 20px;
        word-break: break-all;
        white-space: pre-line;
    } */
</style>