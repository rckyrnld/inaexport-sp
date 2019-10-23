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
          <!-- Header Title -->
        </div>
        <div class="box-body bg-light">
          <h4> View All Eksportir Training</h4><hr>
          <a href="{{route('training.view')}}" class="btn btn-info">View Training Will You Join</a><br>
          <div class="col-md-14"><br>
            @foreach($data as $num => $val)
              <div class="box">
                <div class="box-body">
                  <b>{{$val->training_in}}</b><hr>
                  <div class="row">
                    <div class="col-md-4">
                      <i>{{date("Y/m/d", strtotime($val->start_date))}} - {{date("Y/m/d", strtotime($val->end_date))}}</i>
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-md-2">
                      <b>Lokasi</b>
                    </div>
                    <div class="col-md-4">
                      : {{$val->location_in}}
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-md-2">
                      <b>Topic</b>
                    </div>
                    <div class="col-md-4">
                      : {{$val->topic_in}}
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-md-2">
                      <b>Duration</b>
                    </div>
                    <div class="col-md-4">
                      : {{$val->duration}} Days
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-2">
                      <?php $cek = checkJoin($val->id, $id->id) ?>
                      @if($cek == 0)
                      <form action="{{route('training.join')}}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id_training_admin" value="{{$val->id}}">
                        <button type="submit" name="button" class="btn btn-primary btn-sm"> Join Now</button>
                      </form>
                      @else
                        <button class="btn btn-success btn-sm"> Sudah Join</button>
                      @endif
                    </div>
                  </div><br>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@include('footer')
