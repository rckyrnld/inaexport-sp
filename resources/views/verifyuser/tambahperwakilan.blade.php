@include('header')

<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> Tambah Perwakilan</h5>
                </div>

                <div class="box-body bg-light">
                   
                    <div class="col-md-14">
                        <br>
                        <div>
				{{Form::open(['url' => 'simpanperwakilan','method' => 'post'])}}
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Tipe',['class' => 'col-sm-2 col-form-label '])!!}
				      <div class="col-sm-4">
				     
						<select class="form-control" id="type" name="type" onchange="ganticity()">
						<!-- <option>DJPEN</option> -->
						<option value="">-- Pilih Tipe --</option>
						<option value="ITPC">ITPC</option>
						<option value="KOMJEN">KOMJEN</option>
						<option value="KBRI">KBRI</option>
						<option value="ATASE PERDAGANGAN">ATASE PERDAGANGAN</option>
						<option value="DINAS PERDAGANGAN">DINAS PERDAGANGAN</option>
						
						</select>



				      </div>

				    </div>
				</div>
				<div id="ch1">
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Country',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
						<select class="form-control" name="country">
						<!-- <option>DJPEN</option> -->
						<option value="0">-- Pilih Country --</option>
						<?php $mst = DB::select("select * from mst_country order by country asc"); 
						foreach($mst as $cu){
						?>
						<option value="<?php echo $cu->id; ?>"><?php echo $cu->country; ?></option>
						<?php } ?>
						
						</select>
					</div>
					</div>
				</div>
				</div>
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Email',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
						<input type="text" class="form-control" name="email">
					</div>
					</div>
				</div>
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Telp',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
						<input type="text" class="form-control" name="phone">
					</div>
					</div>
				</div>
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Pejabat',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
						<input type="text" class="form-control" name="pejabat">
					</div>
					</div>
				</div>
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Website',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
						<input type="text" class="form-control" name="web">
					</div>
					</div>
				</div>
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Username',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
						<input type="text" class="form-control" name="username">
					</div>
					</div>
				</div>
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Password',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
						<input type="password" class="form-control" name="password">
					</div>
					</div>
				</div>
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Status',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
						<select class="form-control" name="status">
							<option value="">-- Pilih Status --</value>
							<option value="1">Aktif</value>
							<option value="0">Tidak Aktif</value>
						</select>
					</div>
					</div>
				</div>
				
				<div align="left">
				<input class="btn btn-primary" type="submit" value=" Simpan">
				</div>
				{{Form::close()}}
          	 	
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@include('footer')

<script>
function ganticity(){
	var a = $('#type').val();
	if(a == 'DINAS PERDAGANGAN'){
		$('#ch1').html('<div class="col-md-12"><div class="form-group row"><label for="password_confirm" class="col-sm-2 col-form-label ">Province</label><div class="col-sm-4"><select class="form-control" name="country"><option value="0">-- Pilih Province --</option><?php $mst = DB::select("select * from mst_province order by province_en asc");foreach($mst as $cu){?><option value="<?php echo $cu->id; ?>"><?php echo $cu->province_en; ?></option><?php } ?></select></div></div></div>')
	
	}else{
		$('#ch1').html('<div class="col-md-12"><div class="form-group row"><label for="password_confirm" class="col-sm-2 col-form-label ">Country</label><div class="col-sm-4"><select class="form-control" name="country"><option value="0">-- Pilih Country --</option><?php $mst = DB::select("select * from mst_country order by country asc");foreach($mst as $cu){?><option value="<?php echo $cu->id; ?>"><?php echo $cu->country; ?></option><?php } ?></select></div></div></div>')
	}
}
</script>