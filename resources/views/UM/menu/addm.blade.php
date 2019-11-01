@include('header')

<div class="padding">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
      	 <div class="box-divider m-0"></div>
      	 <div class="box-header bg-info">
      	 	<h4 class="text-white">Form</h4>
      	 </div>
      	 <div class="box-body">

      	 	{!! Form::open(['url' => $url, 'class' => 'form-horizontal', 'files' => true]) !!}
			<?php 
			$qm = DB::select("select * from menu where id_menu='".$id."'");
			foreach($qm as $qq){
			?>
                               <div class="form-group">
                                   <label class="control-label col-md-3">Parent Menu <?php // echo $res->parent; ?></label>
                                   <div class="col-md-7">
                    
<input type="hidden" name="idx" value="<?php echo $id; ?>">
                                       <input type="text" <?php if($res->parent == null || $res->parent == 0) { echo ""; }else { echo "readonly"; }?>  class="form-control" name="nama_menu" placeholder="Home"  
										
                                        @if(isset($res))
                                        @if($res->parent > 0)

                                        value="{{ $parent->menu_name }}" 

                                        @else

                                        value="{{ $res->menu_name }}" 

                                        @endif
                                        @endif >

                                        <input type="hidden" class="form-control" name="id_menu" placeholder="Home" 

                                        @if(isset($res))
                                        @if($res->parent > 0)

                                        value="{{ $parent->id_menu }}" 

                                        @else

                                        value="{{ $res->id_menu }}" 

                                        @endif
                                        @endif

                                        >
                                   </div>
                               </div>


                               
                              
                           
                               <div class="form-group">
                                   <label class="control-label col-md-3">Url</label>
                                   <div class="col-md-7">
                                       <input type="text" class="form-control" name="url" placeholder="/menu/submenu" value="<?php echo $qq->url; ?>">
                                   </div>
                               </div>

                               
                               <div class="form-group">
                                   <label class="control-label col-md-3">Urutan</label>
                                   <div class="col-md-7">
                                       <input type="number" class="form-control" name="urutan" min="0" placeholder="" value="<?php echo $qq->order; ?>">
                                   </div>
                               </div>

                                <div class="form-group">
                                   <label class="control-label col-md-3">Icon</label>
                                   <div class="col-md-7">
                                       <input type="text" class="form-control" name="icon"  placeholder="font-awesome - fa-home"  value="<?php echo $qq->icon; ?>">
                                   </div>
                               </div>

                            
                               <div class="form-group">
                                   <label class="control-label col-md-3">Keterangan</label>
                                   <div class="col-md-7">
                                        <textarea class="form-control" name="ket"><?php echo $qq->ket; ?></textarea>
                                   </div>
                               </div>

                          
                               <div class="form-group">
                                   <label class="control-label col-md-3"></label>
                                   <div class="col-md-7">
                                        <button class="btn btn-primary" type="submit"> Simpan</button>
                                   </div>
                               </div>
			<?php } ?>
                               {!! Form::close() !!}

      	 </div>
      </div>
     </div>
  </div>
</div>

@include('footer')

