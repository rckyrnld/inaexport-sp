
<div class="modal-body">
<?php 
								$pesan = DB::select("select * from csc_buying_request where id='".$id."' limit 1 ");
								foreach($pesan as $ryu){
								?>
								<input type="hidden" id="id_laporan" value="{{$ryu->id_csc_prod}}">
<div class="form-row">
		<div class="col-sm-3">
		<label><b>What are you looking for</b></label>
		</div>
		<div class="form-group col-sm-6">
			<input type="text" readonly style="color:black;" value="<?php echo $ryu->subyek; ?>" name="cmp" id="cmp" class="form-control" >
		</div>
		
	</div>

	

	<div class="form-row">
		<table class="table table-striped" data-plugin="dataTable" id="tabelpiliheksportir" style="/*border-top : 1px solid black;border-bottom : 1px solid black;border-left : 1px solid black;border-right : 1px solid black;/*">
			<thead>
				<tr>
					<th style="width: 70%;">Nama Perusahaan</th>
					<th style="width: 30%;"> Pilih Semua</th>
				</tr>
			</thead>
			<tbody>
				
			</tbody>
		</table>
	</div>
								<?php
								 } 
								?>
								
        </div>
        <div class="modal-footer" style="background-color:#2e899e; color:white;">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><font color="white">Close</font></button>
          {{--<a style="background-color: #d5b824ed!Important;border:#d5b824ed!important;" href="{{ url('br_pw_bc/'.$id) }}" class="btn btn-warning"><font color="white">Broadcast</font></a>--}}
		  <a style="background-color: #d5b824ed!Important;border:#d5b824ed!important;" onclick="broadcast()" class="btn btn-warning"><font color="white">Broadcast</font></a>
        </div>