@include('header')

<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i>DETAIL <?php echo $company ?></h5>
                </div>

                <div class="box-body bg-light">
                    <div class="col-md-14">
                        <p><h6><a href="{{url('/eksportir/product_admin/'.$id)}}" style="color: blue">Products</a></h6>
                        <p><h6><a href="{{url('/eksportir/annual_sales_admin/'.$id)}}" style="color: blue">Annual
                                Sales</a></h6>
                        <p><h6><a href="{{url('/eksportir/brand_admin/'.$id)}}" style="color: blue">Brand</a></h6>
                        <p><h6><a href="{{url('/eksportir/country_patern_brand_admin/'.$id)}}" style="color: blue">Country
                                Patent Brand</a></h6>
                        <p><h6><a href="{{url('/eksportir/product_capacity_admin/'.$id)}}" style="color: blue">Production
                                Capacity</a></h6>
                        <p><h6><a href="{{url('/eksportir/export_destination_admin/'.$id)}}" style="color: blue">Export
                                Destination</a></h6>
                        <p><h6><a href="{{url('/eksportir/portland_admin/'.$id)}}" style="color: blue">Port of
                                Loading</a></h6>
                        <p><h6><a href="{{url('/eksportir/exhibition_admin/'.$id)}}" style="color: blue">Exhibition</a>
                        </h6>
                        <p><h6><a href="{{url('/eksportir/capulti_admin/'.$id)}}" style="color: blue">Capacity
                                Utilization</a></h6>
                        <p><h6><a href="{{url('/eksportir/rawmaterial_admin/'.$id)}}" style="color: blue">Raw
                                Material</a></h6>
                        <p><h6><a href="{{url('/eksportir/labor_admin/'.$id)}}" style="color: blue">Labor</a>
                        <p><h6><a href="{{url('/eksportir/consultan_admin/'.$id)}}" style="color: blue">Consultation</a>
                        </h6>
                        <p><h6><a href="{{url('/eksportir/training_admin/'.$id)}}" style="color: blue">Training</a></h6>
                        <p><h6><a href="{{url('/eksportir/taxes_admin/'.$id)}}" style="color: blue">Tax</a></h6>
                        <p><h6><a href="{{url('/eksportir/contact_admin/'.$id)}}" style="color: blue">Contact</a></h6>
                        <p><h6><a href="{{url('/eksportir/service/admin/'.$id)}}" style="color: blue">Service</a></h6>
                    </div>
                    <br>
                    <div class="form-group col-sm-6">
                        <a style="color: white" href="{{ url('eksportir/admin') }}"
                           class="btn btn-success"><i style="color: white"></i>
                            Back
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@include('footer')

<script>
    $(function () {
        $('#tablesales').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('datatables.sales') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'tahun', name: 'tahun'},
                {data: 'nilai', name: 'nilai'},
                {data: 'nilai_persen', name: 'nilai_persen'},
                {data: 'nilai_ekspor', name: 'nilai_ekspor'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>