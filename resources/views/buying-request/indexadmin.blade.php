@include('header')
<style>
body {font-family: Arial;}

/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 8px 10px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
</style>
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> Buying Request</h5>
                </div>
				
				
				
				
                <div class="box-body bg-light">
				<div class="form-row">
						<div class="form-group col-sm-2">
							<b>Created By</b>
						</div>
						<div class="form-group col-sm-4">
							<select id="bct" class="form-control" onchange="ganti()">
				<option value="0">All</option>
				<option value="1">Admin</option>
				<option value="4">Representative</option>
				<option value="3">Importer</option>
				</select>
						</div>
						<div class="form-group col-sm-2">
							<div id="cb"><a href="{{url('allgr/0')}}" class="btn btn-info" download><i class="fa fa-download"></i> Cetak</a></div>
						</div>
					</div>
				<hr>
				<br>
				<a href="{{ url('br_add') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add</a><br><br>
                          
                   <div class="tab">
  <button class="tablinks active" onclick="openCity(event, 'London')"><font size="3px">Admin</font></button>
  <button class="tablinks" onclick="openCity(event, 'Paris')"><font size="3px">Representative</font></button>
  <button class="tablinks" onclick="openCity(event, 'Tokyo')"><font size="3px">Importer</font></button>
</div>

<div id="London" class="tabcontent" style="display:block;">
   <div class="box-body">
   <table id="users-table0" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        <center>Subyek</center>
                                    </th>
                                    <th>
                                        <center>Duration</center>
                                    </th>
                                    <th>
                                        <center>Date</center>
                                    </th>
									<th>
                                        <center>Category</center>
                                    </th>
									<th>
                                        <center>Create By</center>
                                    </th>
                                    <th>
                                        <center>Status</center>
                                    </th>
									<th width="18%">
                                        <center>Action</center>
                                    </th>
                                </tr>
                                </thead>
								<tbody>
								
								</tbody>

                            </table>
   </div>
 </div>
   
<div id="Paris" class="tabcontent">
  <div class="box-body">
						
                           <table id="users-table" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        <center>Subyek</center>
                                    </th>
                                    <th>
                                        <center>Duration</center>
                                    </th>
                                    <th>
                                        <center>Date</center>
                                    </th>
									<th>
                                        <center>Category</center>
                                    </th>
									<th>
                                        <center>Create By</center>
                                    </th>
                                    <th>
                                        <center>Status</center>
                                    </th>
									<th width="18%">
                                        <center>Action</center>
                                    </th>
                                </tr>
                                </thead>
								<tbody>
								
								</tbody>

                            </table>
</div>
</div>

<div id="Tokyo" class="tabcontent">
  <div class="box-body">
  <table id="users-table3" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>No</th>
                                    <th>
                                        <center>Subyek</center>
                                    </th>
                                    <th>
                                        <center>Duration</center>
                                    </th>
                                    <th>
                                        <center>Date</center>
                                    </th>
									<th>
                                        <center>Category</center>
                                    </th>
									<th>
                                        <center>Create By</center>
                                    </th>
                                    <th>
                                        <center>Status</center>
                                    </th>
									<th width="18%">
                                        <center>Action</center>
                                    </th>
                                </tr>
                                </thead>
								<tbody>
								
								</tbody>

                            </table>
  </div>
  </div>

            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#2e899e; color:white;"> <h6>Broadcast Buying Request</h6>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
		<div id ="isibroadcast"></div>
        <!--<div class="modal-body">
          1
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> -->
      </div>
    </div>
  </div>
 <script>
$(document).ready(function () {
        $('.select2').select2();
});

function ganti(){
	var a = $('#bct').val();
	// alert(a);
	if(a == 0){
		$('#cb').html('<a href="{{url('allgr/0')}}" class="btn btn-info"><i class="fa fa-download"></i> Cetak</a>');
	}else if(a == 1){
		$('#cb').html('<a href="{{url('allgr/1')}}" class="btn btn-info"><i class="fa fa-download"></i> Cetak</a>');
	}else if(a == 4){
		$('#cb').html('<a href="{{url('allgr/4')}}" class="btn btn-info"><i class="fa fa-download"></i> Cetak</a>');
	}else if(a == 3){
		$('#cb').html('<a href="{{url('allgr/3')}}" class="btn btn-info"><i class="fa fa-download"></i> Cetak</a>');
	}
}
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>
 <script type="text/javascript">
function xy(a){
	var token = $('meta[name="csrf-token"]').attr('content');
		$.get('{{URL::to("ambilbroad2/")}}/'+a,{_token:token},function(data){
			$("#isibroadcast").html(data);
			
		 })
}
</script>
<script type="text/javascript">
    $(function () {
        $('#users-table0').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('getcsc0') }}",
            columns: [
                {data: 'row', name: 'row'},
                {data: 'f1', name: 'f1'},
                {data: 'f2', name: 'f2'},
                {data: 'f3', name: 'f3'},
                {data: 'f4', name: 'f4'},
                {
					data: 'f6', name: 'f6', orderable: false, searchable: false
				},
				{
					data: 'f7', name: 'f7', orderable: false, searchable: false
				},
                {
                    data: 'action', name: 'action', orderable: false, searchable: false
                }]
        });
		
		$('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('getcsc') }}",
            columns: [
                {data: 'row', name: 'row'},
                {data: 'f1', name: 'f1'},
                {data: 'f2', name: 'f2'},
                {data: 'f3', name: 'f3'},
                {data: 'f4', name: 'f4'},
                {
					data: 'f6', name: 'f6', orderable: false, searchable: false
				},
				{
					data: 'f7', name: 'f7', orderable: false, searchable: false
				},
                {
                    data: 'action', name: 'action', orderable: false, searchable: false
                }]
        });
		$('#users-table3').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('getcsc3') }}",
            columns: [
                {data: 'row', name: 'row'},
                {data: 'f1', name: 'f1'},
                {data: 'f2', name: 'f2'},
                {data: 'f3', name: 'f3'},
                {data: 'f4', name: 'f4'},
                {
					data: 'f6', name: 'f6', orderable: false, searchable: false
				},
				{
					data: 'f7', name: 'f7', orderable: false, searchable: false
				},
                {
                    data: 'action', name: 'action', orderable: false, searchable: false
                }]
        });
    });
</script>


@include('footer')
