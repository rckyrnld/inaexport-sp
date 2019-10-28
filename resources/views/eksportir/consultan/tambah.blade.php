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
                                <label>Name</label>
                                <input type="text"
                                       class="form-control" name="name">
                                {{--                                <label>Year</label>--}}
                                {{--                                <select class="atc form-control select2" required id="year"--}}
                                {{--                                        name="year">--}}
                                {{--                                    <option value="">- Select Years -</option>--}}
                                {{--                                    @foreach($years as $sa)--}}
                                {{--                                        <option value="{{$sa}}">{{$sa}}</option>--}}
                                {{--                                    @endforeach--}}
                                {{--                                </select>--}}
                            </div>

                            <div class="form-group col-sm-6">
                                <label>Position</label>
                                <input type="text"
                                       class="form-control" name="posotion">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label>Phone</label>
                                <input type="text"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       class="form-control" name="phone">
                            </div>

                            <div class="form-group col-sm-6">
                                <label>Official</label>
                                <input type="text"
                                       class="form-control" name="pejabat">
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label style="font-weight:bold" for="problem">Problem</label>
                                <textarea class="form-control" id="problem" name="problem"></textarea>
                            </div>

                            <div class="form-group col-sm-6">
                                <label style="font-weight:bold" for="solution">Solution</label>
                                <textarea type="text" class="form-control" name="solution" id="solution"></textarea>
                            </div>
                        </div>
                        <br>

                        <div class="form-row">
                            <div class="form-group col-sm-6">

                            </div>
                            <div class="form-group col-sm-6">
                                <a style="color: white" href="{{url('/eksportir/consultan')}}"
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
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script>
    CKEDITOR.replace('problem');
    CKEDITOR.replace('solution');
</script>

@include('footer')
