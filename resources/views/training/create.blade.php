
@include('header')
<style type="text/css">
	th {text-align: center;}
	td {color: black;}
	#tambah { background-color: #1a9cf9; color: white; white-space: pre;}
	#tambah:hover {background-color: #148de4}
	#export { background-color: #28bd4a; color: white; white-space: pre;}
	#export:hover {background-color: #08b32e}
</style>
<div class="padding">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-divider m-0"></div>
        <div class="box-header bg-light">
          <a href="{{url('admin/training')}}" class="btn btn-warning" name="button"><span class="fa fa-arrow-left"></span> Back </a><br>
        </div>
        @if($page == 'create')
				<form class="" action="{{route('training.store.admin')}}" method="post">
        @elseif($page == 'edit')
        <form class="" action="{{route('training.update.admin',$data->id)}}" method="post">
        @endif
					<div class="box-body bg-light">
            @if($page == 'create')
    				 <h4>Form Training</h4><hr>
            @elseif($page == 'edit')
             <h4>Edit Training</h4><hr>
            @elseif($page == 'view')
             <h4>View Training</h4><hr>
            @endif
            <div class="row">
              <div class="col-md-6">
                <div class="row">
                 <div class="col-md-4">
                   <b>Training (EN)</b>
                 </div>
                 <div class="col-md-6">
                   <input type="hidden" name="_token" value="{{ csrf_token() }}">
                   <input type="text" autocomplete="off" class="form-control" name="training_en" @if($page=='edit')  value="{{$data->training_en}}" @endif   @if($page == 'view')value="{{$data->training_en}}" disabled @endif required>
                 </div>
               </div><br>
                <div class="row">
                 <div class="col-md-4">
                   <b>Training (IN)</b>
                 </div>
                 <div class="col-md-6">
                   <input type="hidden" name="_token" value="{{ csrf_token() }}">
                   <input type="text" autocomplete="off" class="form-control" name="training_in" @if($page=='edit')  value="{{$data->training_in}}" @endif   @if($page == 'view')value="{{$data->training_in}}" disabled @endif required>
                 </div>
               </div><br>
                <div class="row">
                 <div class="col-md-4">
                   <b>Training (CHN)</b>
                 </div>
                 <div class="col-md-6">
                   <input type="hidden" name="_token" value="{{ csrf_token() }}">
                   <input type="text" autocomplete="off" class="form-control" name="training_chn" @if($page=='edit')  value="{{$data->training_chn}}" @endif   @if($page == 'view')value="{{$data->training_chn}}" disabled @endif required>
                 </div>
               </div><br>
               <div class="row">
                 <div class="col-md-4">
                   <b>Start Date</b>
                 </div>
                 <div class="col-md-6">
                   <input @if($page == 'create') type="date" @endif autocomplete="off" class="form-control" name="start_date" @if($page=='edit') type="date" value="{{$data->start_date}}" @endif   @if($page == 'view')value="{{date("Y-m-d", strtotime($data->start_date))}}" type="text" disabled @endif required>
                 </div>
               </div><br>
               <div class="row">
                 <div class="col-md-4">
                   <b>Duration</b>
                 </div>
                 <div class="col-md-2">
                   <input type="number" autocomplete="off" class="form-control" name="duration" @if($page=='edit')  value="{{$data->duration}}" @endif   @if($page == 'view')value="{{$data->duration}}" disabled @endif required>
                 </div>
								 <div class="col-md-4">
									 <select class="form-control" name="param">
									 		<option value="Days">Days</option>
											<option value="Week">Week</option>
									 </select>
								 </div>
               </div><br>
               <div class="row">
                 <div class="col-md-4">
                   <b>Location (IN)</b>
                 </div>
                 <div class="col-md-6">
                    <input type="text" autocomplete="off" class="form-control" name="location_in" @if($page=='edit')  value="{{$data->location_in}}" @endif   @if($page == 'view')value="{{$data->location_in}}" disabled @endif required>
                 </div>
               </div><br>
              </div>
              <div class="col-md-6">
                <div class="row">
                 <div class="col-md-4">
                   <b>Topic (EN)</b>
                 </div>
                 <div class="col-md-6">
                   <input type="hidden" name="_token" value="{{ csrf_token() }}">
                   <input type="text" autocomplete="off" class="form-control" name="topic_en" @if($page=='edit')  value="{{$data->topic_en}}" @endif   @if($page == 'view')value="{{$data->topic_en}}" disabled @endif required>
                 </div>
               </div><br>
                <div class="row">
                 <div class="col-md-4">
                   <b>Topic (IN)</b>
                 </div>
                 <div class="col-md-6">
                   <input type="hidden" name="_token" value="{{ csrf_token() }}">
                   <input type="text" autocomplete="off" class="form-control" name="topic_in" @if($page=='edit')  value="{{$data->topic_in}}" @endif   @if($page == 'view')value="{{$data->topic_in}}" disabled @endif required>
                 </div>
               </div><br>
                <div class="row">
                 <div class="col-md-4">
                   <b>Topic (CHN)</b>
                 </div>
                 <div class="col-md-6">
                   <input type="hidden" name="_token" value="{{ csrf_token() }}">
                   <input type="text" autocomplete="off" class="form-control" name="topic_chn" @if($page=='edit')  value="{{$data->topic_chn}}" @endif   @if($page == 'view')value="{{$data->topic_chn}}" disabled @endif required>
                 </div>
               </div><br>
               <div class="row">
                 <div class="col-md-4">
                   <b>End Date</b>
                 </div>
                 <div class="col-md-6">
                   <input @if($page == 'create') type="date" @endif autocomplete="off" class="form-control" name="end_date" @if($page=='edit') type="date" value="{{$data->start_date}}" @endif   @if($page == 'view')value="{{date("Y-m-d", strtotime($data->end_date))}}" type="text" disabled @endif required>
                 </div>
               </div><br>
               <div class="row">
                 <div class="col-md-4">
                   <b>Location (EN)</b>
                 </div>
                 <div class="col-md-6">
                   <input type="text" autocomplete="off" class="form-control" name="location_en" @if($page=='edit')  value="{{$data->location_en}}" @endif   @if($page == 'view')value="{{$data->location_en}}" disabled @endif required>
                 </div>
               </div><br>
               <div class="row">
                 <div class="col-md-4">
                   <b>Location (CHN)</b>
                 </div>
                 <div class="col-md-6">
                    <input type="text" autocomplete="off" class="form-control" name="location_chn" @if($page=='edit')  value="{{$data->location_chn}}" @endif   @if($page == 'view')value="{{$data->location_chn}}" disabled @endif required>
                 </div>
               </div><br>
              </div>
            </div>
            @if($page == 'create' || $page == 'edit')
	          <div class="row">
	            <div class="col-md-9">
	            </div>
	            <div class="col-md-2 ">
	              <button type="submit" class="btn btn-primary" name="button"><span class="fa fa-save"></span> Submit </button>
                <a href="{{url('admin/training')}}" class="btn btn-danger" name="button"><span class="fa fa-close"></span> Cancel </a>
	            </div>
	          </div>
            @endif
            @if($page == 'view')
            <hr>
            <div class="row">
              <div class="col-md-12">
                <table id="table" class="table  table-bordered table-striped" data-plugin="dataTable">
                  <thead class="text-white" style="background-color: #1089ff;">
                    <th>No</th>
                    <th>Company</th>
                    <th>Date</th>
                    <th>Status</th>
                  </thead>
                  <tbody>
                    @foreach($join as $key => $jn)
                      <tr>
                        <td><center>{{$key+1}}</center></td>
                        <td><center>{{$jn->company}}</center></td>
                        <td><center>{{date('Y-m-d',strtotime($jn->date_join))}}</center></td>
                        <td>
                          @if($jn->status == 0)
                            <center>
                              <a href="{{url('admin/training/verifed',[$jn->id,$data->id, $jn->id_profil_eks])}}" class="btn btn-success btn-sm">Verified</a>
                            </center>
                          @elseif($jn->status == 1)
                            <center><span class="fa fa-check"></span></center>
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                {{ $join->render("pagination::bootstrap-4") }}
              </div>
            </div>
            @endif
	        </div>
				</form>
      </div>
    </div>
  </div>
</div>
@include('footer')
