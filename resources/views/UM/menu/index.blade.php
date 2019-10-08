@include('header')

<div class="padding">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
      	 <div class="box-divider m-0"></div>
      	 <div class="box-header bg-info">
      	 	<p class="text-white">Buat Menu</p>

          <a href="{{url('menu_add')}}" class="md-btn md-raised mb-2 w-sm info"><i class="fa fa-plus-circle"></i> Buat Baru</a>
      	 </div>
      	 <div class="box-body">
      	



          <div class="col-md-12">
          	<div class="row">
          		<div class="table-responsive">
          			
          			    <table id="" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th><center>No</center></th>
                                    <th><center>Nama Menu</center></th>
                                    <th><center>Url</center></th>
                                    <th><center>Ururtan</center></th>
                                    <th><center>Icon</center></th>
                                    <th width="15%"><center>Read</center></th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; ?>
                                @foreach($menu as $res)
                                @if($res->parent == 0 )
                                    <tr>
                                        <td><center>{{ $no++ }}</center></td>
                                        <td><b>{{ $res->menu_name }}</b>
                                       
                                        </td>
                                        <td>{{ $res->url }}</td>
                                        <td><center>{{ $res->order}}</center></td>
                                        <td>{{ $res->icon }}</td>
                                        <td>
                                          
                                            <div class="btn-group">
                                            <a href="{{url('/menu_edit/'.$res->id_menu)}}" class="btn btn-warning btn-xs" title="Edit"><i class="fa fa-edit text-white"></i></a>

                                            <a href="{{url('/menu_delete/'.$res->id_menu)}}" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-trash"></i></a>

                                            <a href="{{url('/submenu_add/'.$res->id_menu)}}" class="btn btn-primary btn-xs" title="Tambah Submenu"><i class="fa fa-plus-circle"></i> Submenu</a>
                                            </div>
                                           
                                        </td>
                                    </tr>
                                @endif
                               

                                @foreach($menu as $restwo)
                                @if($res->id_menu == $restwo->parent )

                               
                                <tr>
                                    <td></td>
                                    <td>{{ $restwo->menu_name }}


                                    </td>
                                    <td>{{ $restwo->url }}</td>
                                    <td><center>{{ $restwo->order }} </center></td>
                                    <td>{{ $restwo->ket }}</td>
                                    <td>
                                      <div class="btn-group">
                                         <a href="{{url('/submenu_edit/'.$restwo->id_menu)}}" class="btn btn-warning btn-xs" title="Edit"><i class="fa fa-edit text-white"></i></a>

                                        <a href="{{url('/menu_delete/'.$restwo->id_menu)}}" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-trash"></i></a>
                                      </div>
                                    </td>
                                </tr>
                                 @endif
                                @endforeach 
                                
                                @endforeach                           
                            </tbody>
                        </table>
   


                        
                       
          		</div>
          	</div>
          </div>

         
      	 </div>

      </div>
     </div>
    </div>
</div>

@include('footer')
