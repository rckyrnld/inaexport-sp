@include('header')
        
         &nbsp;

<div class="padding">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
       {{-- <div class="box-header">
       </div> --}}
       <div class="box-divider m-0"></div>
      
      <div class="box-body">
      	  @if(Auth::user()->id_group == 3)
      <div class="tab-content p-3 mb-3">
        <div class="tab-pane animate fadeIn text-muted active show" id="tab4">
          <?php 

          	$sc=DB::table('pendaftaran_sc')->where('id_user',auth::user()->id)->get();
           ?>


          <div class="row">
           <div class="table-responsive">
             <table id="example1" class="table table-bordered table-striped">
              <thead class="bg-dark text-white">
                <tr>
                  <th width="40"><center>No</center></th>
                  <th><center>Tanggal Daftar</center></th>
                  <th><center>Tanggal Terbit</center></th>
                  <th><center>Tanggal Berakhir</center></th>
                  <th><center>Nama Instansi</center></th>
                  <th><center>Detail SC</center></th>
                  <!-- <th><center>Alamat</center></th>
                  <th><center>Kategori Sc</center></th> -->
                   <th><center>Status Proses</center></th>
                   <th><center>Status SC</center></th>
                  <th width="15%"><center>Aksi</center></th> 
                </tr>
              </thead>
              <tbody>
              	@foreach($sc as $no => $res)
               <tr>
                <td>{{$no+1}}</td>
                
                 <td align="center">{{$res->tanggal_pendaftaran}}</td>
                 <td align="center">{{$res->tanggal_terbit}}</td>
				 <td align="center">{{$res->tanggal_experied}}</td>
                  <td>
                      @if($res->kategori_sc==1)
                    {{$res->nama_perusahaan}}
                   @else
                    {{$res->nama_perusahaan}}
                   @endif

                    </td>
					<td align="center">{{$res->detailsc}}</td>
                 <!-- <td>
                    @if($res->kategori_sc==1)
                    {{$res->alamat}}
                   @else
                    {{$res->alamat}}
                   @endif
                 </td>
                 <td>
                   @if($res->kategori_sc==1)
                    Perusahaan
                   @else
                    Mahasiswa
                   @endif

                 </td> -->
                  <td>
                  @if($res->status_sc==0)
                  <?php 
                  $belumdiupload=DB::table('persaratan_relasi')->where('id_sc',$res->id_sc)->where('status_berkas', 0)->count();
                  $belumverifikasi=DB::table('persaratan_relasi')->where('id_sc',$res->id_sc)->where('status_berkas', 1)->count();
                  $terverifikasi=DB::table('persaratan_relasi')->where('id_sc',$res->id_sc)->where('status_berkas', 2)->count();
                  ?>

                 {{ $belumdiupload}}  Belum di upload || 
                  {{ $belumverifikasi}}  Belum di verifikasi ||
                   {{ $terverifikasi}}  Terverifikasi 


                  @elseif($res->status_sc==1)
                  <small style="color:green">Terverifikasi Semua Berkas</small>
                  @endif
                </td>
                <td> 
                   @if($res->publish==1)
                 <small style="color:green">Berlaku</small>
                  
                  @else
                 <small style="color:orange">Belum di verifikasi</small>
                  @endif
                </td>
                 <td><a class="btn btn-warning" href="{{url('pendaftaran_berkas/'.$res->id_sc)}}"><font color="white">Detail</font></a><!-- {{$res->nama_perusahaan}} --></td>
               </tr>
               @endforeach
              </tbody>
            </table>
          </div>
        </div>

      </div>
      <div class="tab-pane animate fadeIn text-muted" id="tab5">
    </div>
  </div>
  
   @else
      <div class="tab-content p-3 mb-3">
        <div class="tab-pane animate fadeIn text-muted active show" id="tab4">
		<br>
         <center><b><h4>Selamat Datang Di Aplikasi Kementerian Perdagangan <br><br>Republik Indonesia</h4></b></center>
		<br>
          <div class="row">
           <div class="table-responsive">
             
          </div>
        </div>

      </div>
      <div class="tab-pane animate fadeIn text-muted" id="tab5">
    </div>
  </div>

  @endif
  
</div>
</div>
</div>
</div>
</div>
&nbsp;


@include('footer')