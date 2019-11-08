@include('header')

<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> Edit Perwakilan</h5>
                </div>

                <div class="box-body bg-light">
                   
                    <div class="col-md-14">
                        <br>
                        <div>
				{{Form::open(['url' => 'updateperwakilan','method' => 'post'])}}
				<?php 
				$qe = DB::select("select * from itdp_admin_users where id='".$id."'");
				foreach($qe as $eq){
				if($eq->type == "DINAS PERDAGANGAN"){
					$tq = DB::select("select a.*,b.*,b.id as idb from itdp_admin_users a, itdp_admin_dn b where a.id_admin_dn = b.id and a.id='".$id."' ");
				}else{
					$tq = DB::select("select a.*,b.*,b.id as idb from itdp_admin_users a, itdp_admin_ln b where a.id_admin_ln = b.id and a.id='".$id."' ");
				}
				foreach($tq as $qt){
				?>
				<input type="hidden" value="<?php echo $id; ?>" name="ida">
				<input type="hidden" value="<?php echo $qt->idb; ?>" name="idb">
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Tipe',['class' => 'col-sm-2 col-form-label '])!!}
				      <div class="col-sm-4">
				     
						<select class="form-control" name="type">
						<!-- <option>DJPEN</option> -->
						<option value="">-- Pilih Tipe --</option>
						<option <?php if($qt->type=="ITPC"){ echo "selected"; } ?> value="ITPC">ITPC</option>
						<option <?php if($qt->type=="KOMJEN"){ echo "selected"; } ?> value="KOMJEN">KOMJEN</option>
						<option <?php if($qt->type=="KBRI"){ echo "selected"; } ?> value="KBRI">KBRI</option>
						<option <?php if($qt->type=="ATASE PERDAGANGAN"){ echo "selected"; } ?> value="ATASE PERDAGANGAN">ATASE PERDAGANGAN</option>
						<option <?php if($qt->type=="DINAS PERDAGANGAN"){ echo "selected"; } ?> value="DINAS PERDAGANGAN">DINAS PERDAGANGAN</option>
						
						</select>



				      </div>

				    </div>
				</div>
				<?php if($qt->type=="DINAS PERDAGANGAN"){ ?>
					<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Province',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
						<select class="form-control" name="country">
						<!-- <option>DJPEN</option> -->
						<option value="0">-- Pilih Country --</option>
						<?php $mst = DB::select("select * from mst_province order by province_en asc"); 
						foreach($mst as $cu){
						?>
						<option <?php if($qt->id_country==$cu->id){ echo "selected"; } ?> value="<?php echo $cu->id; ?>"><?php echo $cu->province_en; ?></option>
						<?php } ?>
						
						</select>
					</div>
					</div>
				</div>
				<?php } else { ?>
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Group Country',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
						<select class="form-control" name="country">
						<!-- <option>DJPEN</option> -->
						<option value="0">-- Pilih Country --</option>
						<?php $mst = DB::select("select * from mst_group_country order by group_country asc"); 
						foreach($mst as $cu){
						?>
						<option <?php if($qt->id_country==$cu->id){ echo "selected"; } ?> value="<?php echo $cu->id; ?>"><?php echo $cu->group_country; ?></option>
						<?php } ?>
						
						</select>
					</div>
					</div>
				</div>
				<?php } ?>
				
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Email',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
						<input type="text" class="form-control" name="email" value="<?php echo $eq->email; ?>">
					</div>
					</div>
				</div>
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Telp',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
						<input type="text" class="form-control" name="phone" value="<?php echo $qt->telp; ?>">
					</div>
					</div>
				</div>
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Pejabat',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
						<input type="text" class="form-control" name="pejabat" value="<?php echo $qt->nama; ?>">
					</div>
					</div>
				</div>
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Website',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
						<input type="text" class="form-control" name="web" value="<?php echo $qt->website; ?>">
					</div>
					</div>
				</div>
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Username',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
						<input type="text" class="form-control" name="username" value="<?php echo $qt->username; ?>">
					</div>
					</div>
				</div>
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Password',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
						<input type="password" class="form-control" name="password">
						<span><font color="red">Alert ! Dont fill it, if dont want password change !</font></span>
					</div>
					</div>
				</div>
				<div class="col-md-12">
          	 		<div class="form-group row">
				      {!!Form::label('password_confirm','Status',['class' => 'col-sm-2 col-form-label '])!!}
				    <div class="col-sm-4">
						<select class="form-control" name="status">
							<option value="">-- Pilih Status --</value>
							<option <?php if($qt->status==1){ echo "selected"; } ?> value="1">Aktif</value>
							<option <?php if($qt->status==0){ echo "selected"; } ?> value="0">Tidak Aktif</value>
						</select>
					</div>
					</div>
				</div>
				
				<div align="left">
				<input class="btn btn-primary" type="submit" value=" Update">
				</div>
				<?php } } ?>
				{{Form::close()}}
          	 	
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@include('footer')
