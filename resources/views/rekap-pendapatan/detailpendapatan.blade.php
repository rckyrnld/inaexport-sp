@include('header')
<style>
table, th, tr, td {
    text-align: left;
}
</style>
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i>List Detail Rekap Pendapatan <?php 
									$carieksportir = DB::select("select b.company,b.badanusaha,b.addres,b.city from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and a.id='".$id."' limit 1");
									if(count($carieksportir) == 0){
										$na1= "";
										$na2= "";
									}else {
										foreach($carieksportir as $ce){
											$na1 = $ce->badanusaha." ".$ce->company;
											$na2 = $ce->addres." ,".$ce->city;
										}
									}
									?></h5><br>
					<div class="form-row">
						<div class="form-group col-sm-2">
							<b>Perusahaan Eksportir</b>
						</div>
						<div class="form-group col-sm-4">
							:<?php echo $na1; ?>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-sm-2">
							<b>Alamat</b>
						</div>
						<div class="form-group col-sm-4">
							: <?php echo $na2; ?>
						</div>
					</div>
	
	<br>
					<br>
				<a href="{{ url('pendapatan_list') }}" class="btn btn-danger"><font color="white"><i class="fa fa-arrow-left"></i> Back</font></a> &nbsp;
				<a href="{{ url('exportpendapatandetail/'.$id) }}" class="btn btn-success"><i class="fa fa-download" ></i> Export Excel</a>
				
                </div>
				
				
                <div class="box-body bg-light">
				
				       <table id="example1" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th>No</th>
									
									<th>
                                        <center>Origin</center>
                                    </th>
									<th>
                                        <center>Buyer</center>
                                    </th>
									<th>
                                        <center>Eksportir</center>
                                    </th>
									
									 <th>
                                        <center>Type Tracking</center>
                                    </th>
									<th>
                                        <center>No Tracking</center>
                                    </th>
									<th>
                                        <center>Harga</center>
                                    </th>
									
									
                                </tr>
                                </thead>
								<tbody>
								<?php $nt = 1; foreach($data as $ruu){ ?>
								<tr>
									<td><?php echo $nt; ?></td>
									
									<td><center><?php if($ruu->origin == 1){ echo "Inquiry"; }else if($ruu->origin == 2){ echo "Buying Request"; }?></center></td>
									<td><center><?php if($ruu->by_role == 1){ echo "Admin"; }else if($ruu->by_role == 4){ echo "Perwakilan"; }else{ 
									$usre = DB::select("select b.company,b.badanusaha from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='".$ruu->id_pembuat."'"); 
									foreach($usre as $imp){ 
									echo "Importir - ".$imp->badanusaha." ".$imp->company; 
									}
									} ?></center></td>
									<td><center><?php 
									$carieks = DB::select("select * from itdp_company_users where id='".$ruu->id_eksportir."'");
									foreach($carieks as $eks){ echo $eks->username; }
									?></center></td>
									
									
									<td><center><?php echo $ruu->type_tracking; ?></center></td>
									<td><center><?php echo $ruu->no_tracking; ?></center></td>
									<td><center><?php echo "$".number_format($ruu->total,2,',','.'); ?></center></td>
									
								</tr>
								<?php $nt++; } ?>
								
								</tbody>

                            </table>
                       
         

  


            </div>

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