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
                                {{--                                <select class="atc form-control select2" required id="year"--}}
                                {{--                                        name="year">--}}
                                {{--                                    <option value="">- Select Years -</option>--}}
                                {{--                                    @foreach($years as $sa)--}}
                                {{--                                        <option value="{{$sa}}">{{$sa}}</option>--}}
                                {{--                                    @endforeach--}}
                                {{--                                </select>--}}
                            </div>

                            <div class="form-group col-sm-6">
                                <label>Training</label>
                                <input type="text"
                                       class="form-control" name="training">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label>Start Date</label>
                                <input type="date"
                                       class="form-control" name="start_date">

                            </div>

                            <div class="form-group col-sm-6">
                                <label>Due Date</label>
                                <input type="date"
                                       class="form-control" name="due_date">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label>Organizer</label>
                                <input type="text"
                                       class="form-control" name="organizer">
                            </div>

                            <div class="form-group col-sm-6">
                                <label>Inside Outside</label>
                                <select class="atc form-control select2" required id="inside_outside"
                                        name="inside_outside">
                                    <option value="">- Select Status -</option>
                                    <option value="inside"> Inside </option>
                                    <option value="outside"> Outside </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label>Lisenced DGNED</label>
                                <input type="text"
                                       class="form-control" name="lisenced_dgned">
                            </div>

                            <div class="form-group col-sm-6">
                                <label>Country</label>
                                <select class="atc form-control select2" required id="country"
                                        name="country">
                                    <option value="">- Pilih Country -</option>
                                    @foreach($country as $sa)
                                        <option value="{{$sa->id}}">{{$sa->country}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label>Place Of Training</label>
                                <input type="text"
                                       class="form-control" name="place_of_training">
                            </div>

                            <div class="form-group col-sm-6">
                                <label>City</label>
                                <select class="atc form-control select2" required id="city"
                                        name="city">
                                    <option value="">- Select City -</option>
                                    @foreach($city as $sab)
                                        <option value="{{$sab->id}}">{{$sab->city}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-6">

                            </div>

                            <div class="form-group col-sm-6">

                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-sm-6">

                            </div>
                            <div class="form-group col-sm-6">
                                <a style="color: white" href="{{url('/eksportir/training')}}"
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
