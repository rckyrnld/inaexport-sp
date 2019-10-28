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
                                <label>Report PPH</label>
                                <input type="text"
                                       class="form-control" name="laporan_pph">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label>Report PPN</label>
                                <input type="text"
                                       class="form-control" name="laporan_ppn">
                            </div>

                            <div class="form-group col-sm-6">
                                <label>Report Pasal 21</label>
                                <input type="text"
                                       class="form-control" name="laporan_pasal_21">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label>Total PPH</label>
                                <input type="text"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       class="form-control" name="total_pph">
                            </div>

                            <div class="form-group col-sm-6">
                                <label>Total PPN</label>
                                <input type="text"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       class="form-control" name="total_ppn">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label>Total Pasal 21</label>
                                <input type="text"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       class="form-control" name="total_pasal_21">
                            </div>

                            <div class="form-group col-sm-6">
                                <label>Arrears PPH</label>
                                <input type="text"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       class="form-control" name="tunggakan_pph">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label>Arrears PPN</label>
                                <input type="text"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       class="form-control" name="tunggakan_ppn">
                            </div>

                            <div class="form-group col-sm-6">
                                <label>Arrears Pasal 21</label>
                                <input type="text"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       class="form-control" name="tunggakan_pasal_21">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-sm-6">

                            </div>
                            <div class="form-group col-sm-6">
                                <a style="color: white" href="{{url('/eksportir/taxes')}}"
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
