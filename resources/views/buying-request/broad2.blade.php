
<div class="modal-body">
<?php 
								$pesan = DB::select("select * from csc_buying_request where id='".$id."' limit 1 ");
								foreach($pesan as $ryu){
								?>
								<input type="hidden" id="id_laporan" value="{{$ryu->id_csc_prod}}">
								<input type="hidden" id="id_buyingrequest" value="{{$id}}">
<div class="form-row">
		<div class="col-sm-3">
		<label><b>What are you looking for</b></label>
		</div>
		<div class="form-group col-sm-6">
			<input type="text" readonly style="color:black;" value="<?php echo $ryu->subyek; ?>" name="cmp" id="cmp" class="form-control" >
		</div>
		
	</div>

	<div class="row" align="right">
		<div class="col-md-6">
		</div>	
		<div class="col-md-6">
			<input  type='checkbox' class='checkall' name='checkall' id='checkall' value=''> Check All In This Page
		</div>
	</div>
	

	<div class="form-row">
		<table class="table table-striped" data-plugin="dataTable" id="tabelpiliheksportir" style="/*border-top : 1px solid black;border-bottom : 1px solid black;border-left : 1px solid black;border-right : 1px solid black;/*">
			<thead>
				<tr>
					<th style="width: 70%;">Nama Perusahaan</th>
					<!-- <th style="width: 30%;"> <input type='checkbox' class='checkall' name='checkall' id='checkall' value=''>All</th> -->
					<th style="width: 30%;"> check</th>
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
		<div class="row">
			<div class="col-md-9">
			</div>
			<div class="col-md-3">
				<button onclick="savecheckall();" class="btn btn-primary" title="save selected company in this page">Save</button>
			</div>
		</div>
		<br>
        <div class="modal-footer" style="background-color:#2e899e; color:white;">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><font color="white">Close</font></button>
          {{--<a style="background-color: #d5b824ed!Important;border:#d5b824ed!important;" href="{{ url('br_pw_bc/'.$id) }}" class="btn btn-warning"><font color="white">Broadcast</font></a>--}}
		  <a style="background-color: #d5b824ed!Important;border:#d5b824ed!important;" onclick="broadcast()" class="btn btn-warning"><font color="white">Broadcast</font></a>
		</div>
		<script type="text/javascript">

		// $("input[name='eksportir']").change(function() {
		// 	var ischecked= $(this).is(':checked');
		// 	if(!ischecked){
		// 		dataeksportir.filter(val);
		// 		$("input[name='eksportir']").prop('unchecked',false);
		// 	}else{
		// 		if(dataeksportir.includes(val)){

		// 		}else{
		// 			$('input:checkbox[value=' + val + ']').attr('disabled', true);
		// 			dataeksportir.push($(this).val());
		// 		}
		// 	}
		// 	console.log(dataeksportir);
		// })
			
        $('#checkall').change(function() {
            if(this.checked) {
				if($("input[name='eksportir']").prop('disabled')){

				}else{
					$("input[name='eksportir']").prop('checked', true);
				}
				
            }else{
				if($("input[name='eksportir']").prop('disabled')){

				}else{
					$("input[name='eksportir']").prop('checked', false);
				}
				
			}     
        });
		</script>