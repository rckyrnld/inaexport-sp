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
                                <label>Domestic</label>
                                <input type="text"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       class="form-control" name="domestic">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label>Overseas</label>
                                <input type="text"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       class="form-control" name="overseas">
                            </div>

                            <div class="form-group col-sm-6">
                                <label>Value From Domestic</label>
                                <input type="text"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       class="form-control" name="valuefromdomestic">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-sm-6">

                            </div>
                            <div class="form-group col-sm-6">
                                <a style="color: white" href="{{url('/eksportir/capulti')}}"
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
