@include('frontend.layout.header')
<style type="text/css">
	th {text-align: center;}
	td {color: black;}
	#tambah { background-color: #1a9cf9; color: white; white-space: pre;}
	#tambah:hover {background-color: #148de4}
	#export { background-color: #28bd4a; color: white; white-space: pre;}
	#export:hover {background-color: #08b32e}
</style>
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
<div class="padding">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-divider m-0"></div>
        <div class="box-header bg-light">
          <!-- Header Title -->
        </div>
        <div class="box-body bg-light">
          <a id="tambah" href="{{route('ticket_support.create')}}" class="btn">   <i class="fa fa-plus-circle"></i>  Add </a>
          <div class="col-md-14"><br>
            <div class="table-responsive">
              <table id="table" class="table  table-bordered table-striped" data-plugin="dataTable">
                <thead class="text-white" style="background-color: #1089ff;">
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subyek</th>
                    <th>Massages</th>
                    <th>Status</th>
                    <th width="20%">Action</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@include('footer')
<script type="text/javascript">
	$(function () {
        $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('ticket_support.getData')}}",
            columns: [
							{data: 'name', name: 'name'},
							{data: 'email', name: 'email'},
              {data: 'subyek', name: 'subyek'},
							{data: 'main_messages', name: 'main_messages'},
              {data: 'status', name: 'status'},
              {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>
