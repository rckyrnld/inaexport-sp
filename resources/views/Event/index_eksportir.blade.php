@include('header')
<section class="content container-fluid">
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i>List Event Exportir</h5>
                </div>
                <div class="box-body bg-light">
                    <div class="col-md-14"><br>
                        <div class="table-responsive">
                            <table id="tableexd" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                    <th>No</th>
                                    <th>Event Nama</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Event Comodity</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                @foreach($e_detail as $key => $ed) 
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$ed->event_name_en}}</td>
                                        <td>{{getTanggalIndo($ed->start_date)}}</td>
                                        <td>{{getTanggalIndo($ed->end_date)}}</td>
                                        <td>{{getEventComodity($ed->event_comodity)}}</td>
                                        <td>{{$ed->status_en}}</td>
                                        <td><a href="{{url('/')}}/event/show_detail/{{$ed->id}}" class="btn btn-primary">Join</a></td>
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
</section>
<script type="text/javascript">
    $(document).ready(function(){
        $('#tableexd').DataTable();
    })
</script>

@include('footer')