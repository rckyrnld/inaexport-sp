@include('header')
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
                                <label>Year</label>
                                <select class="atc form-control select2" required id="year"
                                        name="year">
                                    <option value="">- Select Years -</option>
                                    @foreach($years as $sa)
                                        <option value="{{$sa}}">{{$sa}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-sm-6">
                                <label>Local Employee</label>
                                <input type="text"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       class="form-control" name="local_employee">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label>Foreign Worker</label>
                                <input type="text"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       class="form-control" name="foreign_worker">
                            </div>

                            <div class="form-group col-sm-6">

                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-sm-6">

                            </div>
                            <div class="form-group col-sm-6">
                                <a style="color: white" href="{{url('/eksportir/labor')}}"
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
