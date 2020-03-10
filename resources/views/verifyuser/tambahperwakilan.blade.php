@include('header')

<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> Add Representative</h5>
                </div>

                <div class="box-body bg-light">
                   
                    <div class="col-md-14">
                        <br>
                        <div>
				{{Form::open(['url' => 'simpanperwakilan','method' => 'post'])}}
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Type',['class' => 'col-sm-2 col-form-label '])!!}
				      <div class="col-sm-4">
						  <select class="form-control" id="type" name="type" onchange="ganticity()" required></select>
{{--						<select class="form-control" id="type" name="type" onchange="ganticity()" required>--}}
{{--						<option value="">-- Choose Type --</option>--}}
{{--						<option value="ITPC">ITPC</option>--}}
{{--						<option value="KOMJEN">KOMJEN</option>--}}
{{--						<option value="KBRI">KBRI</option>--}}
{{--						<option value="ATASE PERDAGANGAN">ATASE PERDAGANGAN</option>--}}
{{--						<option value="DINAS PERDAGANGAN">DINAS PERDAGANGAN</option>--}}
						
						</select>



				      </div>

				    </div>
				</div>
				<div id="ch1">
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Group Country',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
						<select class="form-control" name="country" required>
						<!-- <option>DJPEN</option> -->
						<option value="">-- Choose Country --</option>
						<?php $mst = DB::select("select * from mst_group_country order by group_country asc"); 
						foreach($mst as $cu){
						?>
						<option value="<?php echo $cu->id; ?>"><?php echo $cu->group_country; ?></option>
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
						<input type="email" class="form-control" name="email" required>
					</div>
					</div>
				</div>
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Telp',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
						<input type="text" class="form-control" name="phone" required>
					</div>
					</div>
				</div>
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Alamat Kantor',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
						<input type="text" class="form-control" name="pejabat" required>
					</div>
					</div>
				</div>
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Website',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
						<input type="text" class="form-control" name="web" required>
					</div>
					</div>
				</div>
				<?php /*
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Username',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
						<input type="text" class="form-control" name="username" required>
					</div>
					</div>
				</div>
				*/ ?>
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Password',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
						<input type="hidden" class="form-control" name="username" required>
						<input type="password" class="form-control" name="password" required>
					</div>
					</div>
				</div>
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Status',['class' => 'col-sm-2 col-form-label '])!!}
						<div class="col-sm-4">
							<select class="form-control" name="status" required>
								<option value="">-- Choose Status --</option>
								<option value="1">Aktif</option>
								<option value="0">Tidak Aktif</option>
							</select>
						</div>
					</div>
				</div>
				
				<div align="left">
				<a class="btn btn-danger" href="{{ URL::previous() }}">Cancel</a>
				<input class="btn btn-primary" type="submit" value=" Submit">
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
	$(document).ready(function () {
		$('#type').select2({
			allowClear: true,
			placeholder: 'Select Type',
			ajax: {
				url: "{{route('admin.perwakilan.type')}}",
				dataType: 'json',
				delay: 250,
				processResults: function (data) {
					return {
						results: $.map(data, function (item) {
							return {
								text: item.type,
								// text: item.desc_eng ,
								id: item.type,
							}
						})
					};
				},
				cache: true
			}
		});
	})


	// function alert(){
		// alert("data tersimpan");
	// }
function ganticity(){
	var a = $('#type').val();
	if(a == 'DINAS PERDAGANGAN'){
		console.log('dp');

		$('#ch1').html('<div class="col-md-12"><div class="form-group row"><label for="password_confirm" class="col-sm-2 col-form-label ">Province</label><div class="col-sm-4"><select class="form-control" name="country"><option value="0">-- Choose Province --</option><?php $mst = DB::select("select * from mst_province order by province_en asc");foreach($mst as $cu){?><option value="<?php echo $cu->id; ?>"><?php echo $cu->province_en; ?></option><?php } ?></select></div></div></div>')
	
	}else{
		console.log('other');
		$('#ch1').html('<div class="col-md-12"><div class="form-group row"><label for="password_confirm" class="col-sm-2 col-form-label ">Group Country</label><div class="col-sm-4"><select class="form-control" name="country"><option value="">-- Choose Country --</option><?php $mst = DB::select("select * from mst_group_country order by group_country asc");foreach($mst as $cu){?><option value="<?php echo $cu->id; ?>"><?php echo $cu->group_country; ?></option><?php } ?></select></div></div></div>')
	}
}
</script>