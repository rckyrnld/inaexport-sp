@include('header')
<title>InaExport | Tambah User</title>
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
                                <label>Port</label>
                                <select class="atc form-control select2" required id="port"
                                        name="port">
                                    <option value="">- Select Port -</option>
                                    @foreach($port as $sa)
                                        <option value="{{$sa->id}}">{{$sa->name_port}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-sm-6">

                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-sm-6">

                            </div>
                            <div class="form-group col-sm-6">
                                <a style="color: white" href="{{url('/eksportir/portland')}}"
                                   class="btn btn-danger"><i style="color: white"></i>
                                    Back
                                </a>
                                <button class="btn btn-primary" type="submit">Submit
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
