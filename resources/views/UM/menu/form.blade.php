@include('header')

<div class="padding">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
      	 <div class="box-divider m-0"></div>
      	 <div class="box-header bg-info">
      	 	<h4 class="text-white">Form </h4>
      	 </div>
      	 <div class="box-body">

      	 	 {!! Form::open(['url' => $url, 'class' => 'form-horizontal', 'files' => true]) !!}
                               <div class="form-group">
                                   <label class="control-label col-md-3">Nama Menu</label>
                                   <div class="col-md-7">

                                       <input type="text" class="form-control" name="nama_menu" placeholder="Home"   @isset($res) value="{{ $res->menu_name }}"  @endisset>
                                   </div>
                               </div>

                              
                           
                               <div class="form-group">
                                   <label class="control-label col-md-3">Url</label>
                                   <div class="col-md-7">
                                       <input type="text" class="form-control" name="url" placeholder="/Home" @isset($res) value="{{ $res->url }}"  @endisset>
                                   </div>
                               </div>

                               
                               <div class="form-group">
                                   <label class="control-label col-md-3">Urutan</label>
                                   <div class="col-md-7">
                                       <input type="number" class="form-control" name="urutan" min="0" placeholder="" @isset($res) value="{{ $res->order }}"  @endisset>
                                   </div>
                               </div>

                                <div class="form-group">
                                   <label class="control-label col-md-3">Icon</label>
                                   <div class="col-md-7">
                                       <input type="text" class="form-control" name="icon"  placeholder="font-awesome - fa-home" @isset($res) value="{{ $res->icon }}"  @endisset>
                                   </div>
                               </div>

                            
                               <div class="form-group">
                                   <label class="control-label col-md-3">Keterangan</label>
                                   <div class="col-md-7">
                                        <textarea class="form-control" name="ket">@isset($res) {{ $res->ket }}  @endisset</textarea>
                                   </div>
                               </div>

                          
                               <div class="form-group">
                                   <label class="control-label col-md-3"></label>
                                   <div class="col-md-7">
                                        <button class="btn btn-info" type="submit"> Simpan</button>
                                   </div>
                               </div>
                               {!! Form::close() !!}

      	 </div>
      </div>
     </div>
  </div>
</div>

@include('footer')

