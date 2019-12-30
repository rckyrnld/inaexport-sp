
@include('header')
<style type="text/css">
	th {text-align: center;}
	td {color: black;}
	#tambah { background-color: #1a9cf9; color: white; white-space: pre;}
	#tambah:hover {background-color: #148de4}
	#export { background-color: #28bd4a; color: white; white-space: pre;}
	#export:hover {background-color: #08b32e}
  .btn{
    width: 80px;
  }
  .table-css{color: #fff; font-size: 12px; font-weight: 600;}
</style>
<div class="padding" id="form">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-divider m-0"></div>
        @if($page == 'create')
				<form action="{{route('training.store.admin')}}" method="post">
        @elseif($page == 'edit')
        <form action="{{route('training.update.admin',$data->id)}}" method="post">
        @endif
					<div class="box-body bg-light">
            <table style="width: 100%">
              <tr>
                <td>
                  <div align="left" style="color: #627384;">
                    @if($page == 'create')
            				 <h4>Form Training</h4>
                    @elseif($page == 'edit')
                     <h4>Edit Training</h4>
                    @elseif($page == 'view')
                     <h4>View Training</h4>
                    @endif
                  </div>
                </td>
                <td>
                  <div align="right">
                    @if($page == 'view')
                     <a href="{{url('admin/training')}}" class="btn btn-danger" name="button">Back</a>
                    @endif
                  </div>
                </td>
              </tr>
            </table>
            <hr>
            <div class="row">
              <div class="col-md-6">
                <div class="row">
                 <div class="col-md-1"></div>
                 <div class="col-md-4">
                   <b>Training (EN)</b>
                 </div>
                 <div class="col-md-6">
                   <input type="hidden" name="_token" value="{{ csrf_token() }}">
                   <input type="text" autocomplete="off" class="form-control dis" name="training_en" @if($page != 'create')  value="{{$data->training_en}}" @endif required>
                 </div>
               </div><br>
                <div class="row">
                 <div class="col-md-1"></div>
                 <div class="col-md-4">
                   <b>Training (IN)</b>
                 </div>
                 <div class="col-md-6">
                   <input type="text" autocomplete="off" class="form-control dis" name="training_in" @if($page != 'create')  value="{{$data->training_in}}" @endif required>
                 </div>
               </div><br>
                <div class="row">
                 <div class="col-md-1"></div>
                 <div class="col-md-4">
                   <b>Training (CHN)</b>
                 </div>
                 <div class="col-md-6">
                   <input type="text" autocomplete="off" class="form-control dis" name="training_chn" @if($page != 'create')  value="{{$data->training_chn}}" @endif required>
                 </div>
               </div><br>
               <div class="row">
                 <div class="col-md-1"></div>
                 <div class="col-md-4">
                   <b>Start Date</b>
                 </div>
                 <div class="col-md-6">
                   <input type="date" autocomplete="off" class="form-control dis" name="start_date" @if($page != 'create') value="{{date('Y-m-d', strtotime($data->start_date))}}" @endif required>
                 </div>
               </div><br>
               <div class="row">
                 <div class="col-md-1"></div>
                 <div class="col-md-4">
                   <b>End Date</b>
                 </div>
                 <div class="col-md-6">
                    <input type="date" autocomplete="off" class="form-control dis" name="end_date" @if($page != 'create') value="{{date('Y-m-d', strtotime($data->end_date))}}" @endif required>
                 </div>
               </div><br>
               <div class="row">
                 <div class="col-md-1"></div>
                 <div class="col-md-4">
                   <b>Duration</b>
                 </div>
                 <div class="col-md-6">
                   <table width="100%">
                     <tr>
                       <td style="padding-right: 10px; width: 60%;"><input type="number" autocomplete="off" class="form-control dis" name="duration" @if($page != 'create')  value="{{$data->duration}}" @endif required></td>
                       <td><select class="form-control dis" name="param">
                              <option value="Days" @if($page != 'create') @if($data->param == "Days") selected @endif @endif>Days</option>
                              <option value="Week" @if($page != 'create') @if($data->param == "Week") selected @endif @endif>Week</option>
                           </select>
                        </td>
                     </tr>
                   </table>
                 </div>
               </div><br>
              </div>
              <div class="col-md-6">
                <div class="row">
                 <div class="col-md-4">
                   <b>Topic (EN)</b>
                 </div>
                 <div class="col-md-6">
                   <input type="text" autocomplete="off" class="form-control dis" name="topic_en" @if($page != 'create')  value="{{$data->topic_en}}" @endif required>
                 </div>
               </div><br>
                <div class="row">
                 <div class="col-md-4">
                   <b>Topic (IN)</b>
                 </div>
                 <div class="col-md-6">
                   <input type="text" autocomplete="off" class="form-control dis" name="topic_in" @if($page != 'create')  value="{{$data->topic_in}}" @endif required>
                 </div>
               </div><br>
                <div class="row">
                 <div class="col-md-4">
                   <b>Topic (CHN)</b>
                 </div>
                 <div class="col-md-6">
                   <input type="text" autocomplete="off" class="form-control dis" name="topic_chn" @if($page != 'create')  value="{{$data->topic_chn}}" @endif required>
                 </div>
               </div><br>
               <div class="row">
                 <div class="col-md-4">
                   <b>Location (EN)</b>
                 </div>
                 <div class="col-md-6">
                   <input type="text" autocomplete="off" class="form-control dis" name="location_en" @if($page != 'create')  value="{{$data->location_en}}" @endif required>
                 </div>
               </div><br>
               <div class="row">
                 <div class="col-md-4">
                   <b>Location (IN)</b>
                 </div>
                 <div class="col-md-6">
                   <input type="text" autocomplete="off" class="form-control dis" name="location_in" @if($page != 'create')  value="{{$data->location_in}}" @endif required>
                 </div>
               </div><br>
               <div class="row">
                 <div class="col-md-4">
                   <b>Location (CHN)</b>
                 </div>
                 <div class="col-md-6">
                    <input type="text" autocomplete="off" class="form-control dis" name="location_chn" @if($page != 'create')  value="{{$data->location_chn}}" @endif required>
                 </div>
               </div><br>
              </div>
            </div><br>
              <h4>Contact Person</h4><hr>
            <div class="row">
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-1"></div>
                  <div class="col-md-4">
                    <b>Full Name</b>
                  </div>
                  <div class="col-md-6">
                    <input type="text" autocomplete="off" class="form-control dis" name="cp_name" @if($page != 'create') @if($cp) value="{{$cp->name}}" @endif @endif required>
                  </div>
                </div><br>
                <div class="row">
                  <div class="col-md-1"></div>
                  <div class="col-md-4">
                    <b>Email</b>
                  </div>
                  <div class="col-md-6">
                    <input type="email" autocomplete="off" class="form-control dis" name="cp_email" @if($page != 'create') @if($cp) value="{{$cp->email}}" @endif @endif required>
                  </div>
                </div><br>
              </div><div class="col-md-6">
                <div class="row">
                  <div class="col-md-4">
                    <b>Phone</b>
                  </div>
                  <div class="col-md-6">
                    <input type="text" onblur="this.value=removeSpaces(this.value);" autocomplete="off" class="form-control dis" name="cp_phone" maxlength="15" @if($page != 'create') @if($cp) value="{{$cp->phone}}" @endif @endif required>
                  </div>
                </div><br>
              </div>
            </div>
            @if($page != 'view')
	          <div class="row">
              <div class="col-md-11">
                <div align="right">
                  <a href="{{url('admin/training')}}" class="btn btn-danger" name="button"> Cancel</a>
  	               <button type="submit" class="btn btn-primary" name="button"><span class="fa fa-save"></span> Submit </button>
                </div>
              </div>
	          </div>
            @else 
              <br>
              <div class="row justify-content-center">
                <div class="col-md-11">
                  <table id="table" class="table table-bordered table-striped">
                    <thead style="background-color: #1089ff;">
                      <tr>
                        <td class="table-css">No</td>
                        <td class="table-css">Company</td>
                        <td class="table-css">Interested at</td>
                      </tr>
                    </thead>
                  </table>
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
<script type="text/javascript">
  $(document).ready(function (){
    var type = '{{$page}}';
    @if($page == 'view')
      $('#table').dataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('training.getDataInterest', $data->id)}}",
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'company', name: 'company'},
              {data: 'interest', name: 'interest'}
          ]
      });
    @endif
    if(type == "view"){
      $('.dis').prop('disabled', true);
    } 
  })

  function removeSpaces(string) {
   return string.split(' ').join('');
  }
</script>