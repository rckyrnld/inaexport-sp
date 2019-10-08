@include('header')

<div class="padding">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
      	 <div class="box-divider m-0"></div>
      	 <div class="box-header bg-info">
      	 	<h4 class="text-white">Hakakses Menu</h4>
      	 </div>
      	 <div class="box-body">
      	  {!! Form::open(['url' => '/permission_update/'.$id, 'class' => 'form-horizontal', 'files' => true]) !!}



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


                                <?php 

                                $chek = DB::table('permissions')->where('id_menu',$res->id_menu)->where('id_group',$id)->first();
                                ?>

                                    <tr>
                                        <td><center>{{ $no++ }}</center></td>
                                        <td><b>{{ $res->menu_name }}</b>
                                       
                                        </td>
                                        <td>{{ $res->url }}</td>
                                        <td><center>{{ $res->order}}</center></td>
                                        <td>{{ $res->icon }}</td>
                                        <td><center>
                                            <input type="checkbox" name="id_menu[]" value="{{ $res->id_menu }}" @isset($chek->id_menu) @if($res->id_menu == $chek->id_menu) checked="checked"  @endif @endisset>
                                            </center>
                                        </td>
                                    </tr>
                                @endif
                               

                                @foreach($menu as $restwo)
                                @if($res->id_menu == $restwo->parent )

                                <?php 

                                $chek = DB::table('permissions')->where('id_menu',$restwo->id_menu)->where('id_group',$id)->first();
                                ?>
                                <tr>
                                    <td></td>
                                    <td>{{ $restwo->menu_name }}


                                    </td>
                                    <td>{{ $restwo->url }}</td>
                                    <td><center>{{ $restwo->order }} </center></td>
                                    <td>{{ $restwo->ket }}</td>
                                    <td><center>
                                    <input type="checkbox" name="id_menu[]" value="{{ $restwo->id_menu }}" @isset($chek->id_menu) @if($restwo->id_menu == $chek->id_menu) checked="checked"  @endif @endisset>
                                    </center></td>
                                </tr>
                                 @endif
                                @endforeach 
                                
                                @endforeach                           
                            </tbody>
                        </table>
   


                        <br>

                         <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Simpan</button>

          		</div>
          	</div>
          </div>

          {!! Form::close() !!}
      	 </div>

      </div>
     </div>
    </div>
</div>

@include('footer')
