@include('header')
<title>E-Reporting | Tambah User</title>
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{url($url)}}">
                {{ csrf_field() }}
                <div class="box">
                    <div class="box-divider m-0"></div>
                    <div class="box-body">
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label>Brand</label>
                                <select class="atc form-control select2" required id="brand"
                                        name="brand">
                                    <option value="">- Choose Brand -</option>
                                    @foreach($brand as $sat)
                                        <option value="{{$sat->id}}">{{$sat->merek}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-sm-6">
                                <label>Country</label>
                                <select class="atc form-control select2" required id="country"
                                        name="country">
                                    <option value="">- Choose Country -</option>
                                    @foreach($country as $sa)
                                        <option value="{{$sa->id}}">{{$sa->country}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label>Month</label>
                                <input type="text" class="form-control" name="bulan" id="bulan">
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Year</label>
                                <input type="text" class="form-control" name="year"
                                       id="year" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-sm-6">

                            </div>
                            <div class="form-group col-sm-6">
                                <a style="color: white" href="{{url('/eksportir/country_patern_brand')}}"
                                   class="btn btn-primary"><i style="color: white"></i>
                                    Back
                                </a>
                                <button class="btn btn-success" type="submit"><i
                                            class="fa fa-plus-circle"></i> Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@include('footer')
