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
                    <div class="col-md-14">
                        <div class="table-responsive">
                            <table id="tablebrands" class="table  table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        Code
                                    </th>
                                    <th>
                                        Product Name
                                    </th>
                                    <th>
                                        Company Name
                                    </th>
                                    <th>
                                        Color
                                    </th>
                                    <th>
                                        Size
                                    </th>
                                    <th>
                                        Raw Material
                                    </th>
                                    <th>
                                        Capacity
                                    </th>
                                    <th>
                                        Price (USD)
                                    </th>
                                    <th>
                                        Description Product
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    <th>
                                        Information
                                    </th>
                                    <th>
                                        Action
                                    </th>
                                </tr>
                                </thead>

                            </table>
                            <br>
                            
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
        $('#tablebrands').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('datatables.eksproduct_admin_un', $id_profil) }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'code_en', name: 'code_en'},
                {data: 'prodname_en', name: 'prodname_en'},
                {data: 'company_name', name: 'company_name'},
                {data: 'color_en', name: 'color_en'},
                {data: 'size_en', name: 'size_en'},
                {data: 'raw_material_en', name: 'raw_material_en'},
                {data: 'capacity', name: 'capacity'},
                {data: 'price_usd', name: 'price_usd'},
                {data: 'product_description', name: 'product_description'},
                {data: 'status', name: 'status'},
                {data: 'information', name: 'information'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>