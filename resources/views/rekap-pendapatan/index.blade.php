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
                    <h5><i></i>List Company Incomes</h5>
					<br>
				<a href="{{ url('exportpendapatanall') }}" class="btn btn-success"><i class="fa fa-download" ></i> Export Excel</a>
				
                </div>
				
				
                <div class="box-body bg-light">
				
				       <table id="example1" class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th><center>No</center></th>
									<th>
                                        <center>Exporter</center>
                                    </th>
									<th>
                                        <center>Address Company</center>
                                    </th>
                                    <th width="20%">
                                        <center>Incomes</center>
                                    </th>
									<th width="18%">
                                        <center>Action</center>
                                    </th>
                                </tr>
                                </thead>
								<tbody>
								<?php $nt = 1; 
								$data = DB::select("select id_eksportir from csc_transaksi where status_transaksi ='1' group by id_eksportir ");
								foreach($data as $ruu){ ?>
								<tr>
									<td><center><?php echo $nt; ?></center></td>
									<td><?php 
									$carieksportir = DB::select("select b.company,b.badanusaha from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and a.id='".$ruu->id_eksportir."' limit 1");
									if(count($carieksportir) == 0){
										echo "";
									}else {
										foreach($carieksportir as $ce){
											echo $ce->badanusaha." ".$ce->company;
										}
									}
									?></td>
									<td><?php 
									$carieksportir = DB::select("select b.addres,b.city from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and a.id='".$ruu->id_eksportir."' limit 1");
									if(count($carieksportir) == 0){
										echo "";
									}else {
										foreach($carieksportir as $ce){
											echo $ce->addres." ,".$ce->city;
										}
									}
									?></td>
									<td style="text-align:right!important;">
									<?php 
									$caritotal = DB::select("select sum(tp)as maxc from csc_transaksi where id_eksportir='".$ruu->id_eksportir."' and status_transaksi ='1'");
									if(count($caritotal) == 0){
										echo "$0";
									}else{
									foreach($caritotal as $ct){
										echo "$".number_format($ct->maxc,2,',','.');
									}
									}
									?>
									</td>
									<td><center><a href="{{url('detailpendapatan/'.$ruu->id_eksportir)}}" class="btn btn-warning" title="Detail"><font color="white"><i class="fa fa-list"></i></font></a></center></td>
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
