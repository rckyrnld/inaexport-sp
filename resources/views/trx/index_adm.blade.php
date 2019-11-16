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
                    <h5><i></i> Selling Transaction Admin</h5>
                </div>

                <div class="box-body bg-light">
				<!--<a href="{{ url('br_add') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add</a><br><br>-->
                          
                   <div class="tab">
  <button class="tablinks active" onclick="openCity(event, 'London')"><font size="3px">Selling</font></button>
  <button class="tablinks" onclick="openCity(event, 'Paris')"><font size="3px">Report</font></button>
</div>

<div id="London" class="tabcontent" style="display:block;">
   <div class="box-body">
    <table id="example1" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>No</th>
									
                                  
									
                                    
                                   
									<th>
                                        <center>Product Name</center>
                                    </th>
									<th>
                                        <center>Quantity</center>
                                    </th>
									<th>
                                        <center>Price</center>
                                    </th>
									<th>
                                        <center>Buyer</center>
                                    </th>
									<th>
                                        <center>Eksportir</center>
                                    </th>
									<th>
                                        <center>Subyek</center>
                                    </th>
									<!--<th>
                                        <center>Specification</center>
                                    </th>-->
									 <th>
                                        <center>Type Tracking</center>
                                    </th>
									<th>
                                        <center>No Tracking</center>
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
								<?php $nt = 1; foreach($data as $ruu){ ?>
								<tr>
									<td><?php echo $nt; ?></td>
									
									
									
									<td>
									<?php
$cr = explode(',',$ruu->id_csc_prod);
				$hitung = count($cr);
				$semuacat = "";
				for($a = 0; $a < ($hitung - 1); $a++){
					$namaprod = DB::select("select * from csc_product where id='".$cr[$a]."' ");
					foreach($namaprod as $prod){ $napro = $prod->nama_kategori_en; }
					$semuacat = $semuacat."- ".$napro."<br>";
				}
				echo $semuacat;
									?>
									</td>
									<td><center><?php echo $ruu->eo." ".$ruu->neo; ?></center></td>
									<td><center><?php echo $ruu->tp." ".$ruu->ntp; ?></center></td>
									<td><center><?php if($ruu->by_role == 1){ echo "Admin"; }else if($ruu->by_role == 4){ echo "Perwakilan"; }else{ echo "Importir"; } ?></center></td>
									<td><center><?php 
									$carieks = DB::select("select * from itdp_company_users where id='".$ruu->id_eks."'"); 
									foreach($carieks as $eks){ echo $eks->username; }
									?></center></td>
									<td><center><?php echo $ruu->subyek; ?></center></td>
									
									
									<td><center><?php echo $ruu->type_tracking; ?></center></td>
									<td><center><?php echo $ruu->no_track; ?></center></td>
									
									<td><center>
									<?php if($ruu->status_trx == 1){ ?>
									<center><font color="green">Already Sent</font></center>
									<?php }else { ?>
									<center><font color="orange">On Process</font></center>
									<?php } ?>
									</center></td>
									<td><center>
									<?php if($ruu->status_trx == 1){ ?>
									<a href="{{ url('br_trx2/'.$ruu->ida.'/'.$ruu->idb) }}" class="btn btn-info"><font color="white"><i class="fa fa-list"></i>&nbsp; View</font></a>
									
									
									<?php }else { ?>
									<a href="{{ url('br_trx2/'.$ruu->ida.'/'.$ruu->idb) }}" class="btn btn-success"><font color="white"><i class="fa fa-list"></i>&nbsp; View</font></a>
									
									<?php } ?>
									</center></td>
								</tr>
								<?php $nt++; } ?>
								
								</tbody>

                            </table>
   </div>
 </div>
   
<div id="Paris" class="tabcontent">
  <div class="box-body">
						
                           <center>Greed</center>
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
