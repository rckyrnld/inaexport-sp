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

				 <?php if(empty(Auth::user()->name)){ 
				 if(Auth::guard('eksmp')->user()->status == 1){
				 ?>
				 <a class="btn" href="{{url('/eksportir/tambah_product')}}"
                       style="background-color: #1089ff; color: white;"><i
                                class="fa fa-plus-circle"></i>
                        Add</a>
				 <?php }else{ ?>
				 
				 <?php } ?>
				 
					<?php   }else{ ?>
					  
					  <?php } ?>
                    
                    <div class="col-md-14">
                        <br>
                        <div class="table-responsive">
                            <table id="tablebrands" class="table  table-responsive table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        <center>Code</center>
                                    </th>
                                    <th>
                                        <center>Product Name</center>
                                    </th>
                                    <th>
                                        <center>Color</center>
                                    </th>
                                    <th>
                                        <center>Size</center>
                                    </th>
                                    <th>
                                        <center>Raw Material</center>
                                    </th>
                                    <th>
                                        <center>Capacity</center>
                                    </th>
                                    <th>
                                        <center>Price (USD)</center>
                                    </th>
                                    <th>
                                        <center>Description Product</center>
                                    </th>
                                    <th>
                                        <center>Status</center>
                                    </th>
                                    <th>
                                        <center>Information</center>
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

@include('footer')

<script>
    $(document).ready(function () {
        $(".alert").slideDown(300).delay(1000).slideUp(300);
        $('#tablebrands').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('datatables.eksproduct') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'code_en', name: 'code_en'},
                {data: 'prodname_en', name: 'prodname_en'},
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