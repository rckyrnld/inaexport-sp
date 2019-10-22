@include('header')
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> List Company</h5>
                </div>
                <div class="box-body bg-light">
                <a class="btn btn-danger" href="{{url('/event')}}"><i class="fa fa-arrow-left"></i> Kembali</a><br>
                    <div class="col-md-14">
                        <br>
                        <div class="table-responsive">
                            <table id="tableexdes" class="table  table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>No</th>
                                    <th>Company</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($list as $key => $li )
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$li->untuk_nama}}</td>
                                            <td>{{$li->waktu}}</td>
                                            <?php $a = getEventStatus($li->id_terkait);
                                                if ($a == 'Verified') { $btn = 'btn btn-success'; }else{ $btn = 'btn btn-warnig'; }
                                            ?>
                                            <td><button class="{{$btn}}">{{$a}}</button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
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
        $('#tableexdes').DataTable();
    });
</script>