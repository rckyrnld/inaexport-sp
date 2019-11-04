@include('frontend.layout.header')

<div class="d-flex flex-column flex" style="">
	<div class="light bg pos-rlt box-shadow" style="padding-left:10px; padding-right:10px; padding-top:10px; padding-bottom:10px;    background-color: #2791a6 ; color: #ffffff">
    <div class="mx-auto">
    	<table border="0" width="100%">
      	<tr>
      	<td width="30%" style="font-size:13px;padding-left:10px"><img height="30px" src="{{url('assets')}}/assets/images/logo.jpg" alt="." ><b>&nbsp;&nbsp;&nbsp; Ministry Of Trade</b></td>
      	<td width="30%"></td>
      	<td width="40%" align="right" style="padding-right:10px;">
        	<a href="{{ url('locale/en') }}"><img width="20px" height="15px" src="{{asset('negara/en.png')}}"></a>&nbsp;
        	<a href="{{ url('locale/in') }}"><img width="20px" height="15px" src="{{asset('negara/in.png')}}"></a>&nbsp;
        	<a href="{{ url('locale/ch') }}"><img width="20px" height="15px" src="{{asset('negara/ch.png')}}"></a>&nbsp;&nbsp;&nbsp;
        	<a href="{{url('login')}}"><font color="white"><i class="fa fa-sign-in"></i> @lang("frontend.lbl3")</font></a>
      	</td>
      	</tr>
    	</table>
    </div>
  </div>
  <div id="content-body">
    <div class="py-5 w-100">
      <center><h4><b>@lang("frontend.title2")</b></h4><br></center>
      <div class="container">
        <div class="box" style="padding: 20px;">
        <?php
          $loc = app()->getLocale();
          $lct = "";
          if($loc == "ch"){
            $lct = "chn";
          }elseif($loc == "in"){
            $lct = "in";
          }else{
            $lct = "en";
          }
        ?>
          <br>
          <div class="row">
            <div class="col-md-12">
              <h5><b>@lang('inquiry.list')</b></h5>
            </div>
          </div>
          <br>
          <div class="table-responsive">
            <table id="tableinquiry" class="table  table-bordered table-striped">
              <thead class="text-white" style="background-color: #1089ff;">
                <tr>
                  <th width="5%">
                    <center>@lang('inquiry.number')</center>
                  </th>
                  <th>
                    <center>@lang('inquiry.category')</center>
                  </th>
                  <th>
                    <center>@lang('inquiry.subject')</center>
                  </th>
                  <th>
                    <center>@lang('inquiry.date')</center>
                  </th>
                  <th>
                    <center>@lang('inquiry.kos')</center>
                  </th>
                  <th width="15%">
                    <center>@lang('inquiry.msg')</center>
                  </th>
                  <th>
                    <center>@lang('inquiry.status')</center>
                  </th>
                  <th>
                    <center>@lang('inquiry.action')</center>
                  </th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
        <div class="px-3">
         {{--  <div>
            <a href="#" class="btn btn-block indigo text-white mb-2">
              <i class="fa fa-facebook float-left"></i>
              Sign in with Facebook
            </a>
            <a href="#" class="btn btn-block red text-white">
              <i class="fa fa-google-plus float-left"></i>
              Sign in with Google+
            </a>
          </div> --}}
          {{-- <div class="my-3 text-sm">
            OR
          </div> --}}
         
		  
          <div class="my-4">
           <!-- <a href="{{ route('password.request') }}" class="text-primary _600">Forgot password?</a> -->
          </div>
          <div>
           <!-- Do not have an account? 
            <a href="{{url('register')}}" class="text-primary _600">Sign up</a> -->
          </div>
        </div>
		
      </div>
    </div>
    </form>
  </div>
</div>
<script>
  $(document).ready(function () {
        $('#tableinquiry').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('front.datatables.inquiry') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'category', name: 'category'},
                {data: 'subject', name: 'subject'},
                {data: 'date', name: 'date'},
                {data: 'kos', name: 'kos'},
                {data: 'msg', name: 'msg'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>

@include('frontend.layout.footer')