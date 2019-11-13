<style> 
.main-header .navbar .nav>li>a>.label {
    position: absolute;
    top: 9px;
    right: 7px;
    text-align: center;
    font-size: 9px;
    padding: 2px 3px;
    line-height: .9;
}

.bg-yellow, .callout.callout-warning, .alert-warning, .label-warning, .modal-warning .modal-body {
    background-color: #f39c12 !important;
}
</style> 
      <div class="content-header white  box-shadow-0" id="content-header" style="background-color:  #1a7688  ; color: #ffffff">
     
  
            <div class="navbar navbar-expand-lg">
              <!-- btn to toggle sidenav on small screen -->
              <a class="d-lg-none mx-2" data-toggle="modal" data-target="#aside">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512"><path d="M80 304h352v16H80zM80 248h352v16H80zM80 192h352v16H80z"/></svg>
              </a>
              <!-- Page title -->
              <div class="navbar-text nav-title flex" id="pageTitle" style="font-size:18px;">{{$pageTitle}}</div>
            
		  
              <ul class="nav flex-row order-lg-2">
                <li class="dropdown notifications-menu d-flex align-items-center">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
			  <?php 
			  if(empty(Auth::user()->name)){ 
			  $querynotifa = DB::select("select * from notif where status_baca='0' and untuk_id='".Auth::guard('eksmp')->user()->id."' and to_role='".Auth::guard('eksmp')->user()->id_role."' order by id_notif desc"); 
			  $querynotif = DB::select("select * from notif where status_baca='0' and untuk_id='".Auth::guard('eksmp')->user()->id."' and to_role='".Auth::guard('eksmp')->user()->id_role."' order by id_notif desc limit 4"); 
			  }else{
				if(Auth::user()->id_group == 1){
				$querynotifa = DB::select("select * from notif where status_baca='0' and to_role='1' order by id_notif desc"); 
				$querynotif = DB::select("select * from notif where status_baca='0' and to_role='1' order by id_notif desc limit 4"); 
			  }else{
				$querynotifa = DB::select("select * from notif where untuk_id='".Auth::user()->id."' and status_baca='0' and to_role='4' order by id_notif desc"); 
				$querynotif = DB::select("select * from notif where untuk_id='".Auth::user()->id."' and status_baca='0' and to_role='4' order by id_notif desc limit 4");
			  }
			  }
			  ?>
              <span class="label label-warning" style="position: absolute!important;
    
    right: 7px!important;
    text-align: center!important;
    font-size: 9px!important;
    padding: 2px 3px!important;
    line-height: .9!important;"><?php if(count($querynotifa) == 0){ echo "0"; }else{ echo count($querynotifa); } ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-right w pt-0 mt-2 animate fadeIn" style="width:300px!important; padding-left:10px;padding-right:10px;">
              <li style="font-size:13px; border:2px;"><br>
			  <?php 
			  
			  foreach($querynotif as $ar){
			  ?>
        @if($ar->id_terkait == NULL)
        <a onclick="closenotif(<?php echo $ar->id_notif; ?>)" href="{{url($ar->url_terkait)}}">
              <?php echo $ar->keterangan; ?><br>
        <b><?php echo $ar->waktu; ?></b>
        </a>
        <hr>
        @else
			  <a onclick="closenotif(<?php echo $ar->id_notif; ?>)" href="{{url($ar->url_terkait.'/'.$ar->id_terkait)}}">
              <?php echo $ar->keterangan; ?><br>
			  <b><?php echo $ar->waktu; ?></b>
			  </a>
			  <hr>
        @endif
			  <?php } ?>
              </li>
              <li><center>
			  <?php if(count($querynotifa) == 0){ echo "<b>Tidak Ada Notifikasi Tersedia Untuk Anda !</b><br><br>"; }else{ ?> 
			  <a href="{{ url('show_all_notif') }}">View all</a> <?php } ?></center></li>
            </ul>
          </li>
				
                <li class="dropdown d-flex align-items-center">
                  <a href="#" data-toggle="dropdown" class="d-flex align-items-center">
                    <span class="avatar w-32">
                      <!-- <img src="{{url('assets')}}/assets/images/logo.png" alt="..."> -->
                    </span>
                    <span class="dropdown-toggle  mx-2 d-none l-h-1x d-lg-block">
                      <span>
					  <?php if(empty(Auth::user()->name)){ 
					  echo Auth::guard('eksmp')->user()->username;
					  }else{ ?>
					  {{ Auth::user()->name }}
					  <?php } ?>
					  
					  </span>
                    </span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right w pt-0 mt-2 animate fadeIn">
				  
                   <!--  <div class="row no-gutters b-b mb-2">
                      <div class="col-4 b-r">
                        <a href="app.user.html" class="py-2 pt-3 d-block text-center">
                          <i class="fa text-md fa-phone-square text-muted"></i>
                          <small class="d-block">Call</small>
                        </a>
                      </div>
                      <div class="col-4 b-r">
                        <a href="app.message.html" class="py-2 pt-3 d-block text-center">
                          <i class="fa text-md fa-comment text-muted"></i>
                          <small class="d-block">Chat</small>
                        </a>
                      </div>
                      <div class="col-4">
                        <a href="app.inbox.html" class="py-2 pt-3 d-block text-center">
                          <i class="fa text-md fa-envelope text-muted"></i>
                          <small class="d-block">Email</small>
                        </a>
                      </div>
                    </div> -->
					 <?php if(empty(Auth::user()->id_group)){  
					 if(Auth::guard('eksmp')->user()->id_role == 2){
					 ?>
					  <a style="padding-top:10px;"class="dropdown-item" href="{{ url('profil/'.Auth::guard('eksmp')->user()->id_role.'/'.Auth::guard('eksmp')->user()->id) }}">
                     <b> Profil <?php if(Auth::guard('eksmp')->user()->id_role == 2){ echo " Eksportir"; }else if(Auth::guard('eksmp')->user()->id_role == 3){ echo " Importir"; } ?></b>
                    </a>
					 <?php } else { ?> 
					 <a style="padding-top:10px;"class="dropdown-item" href="{{ url('profil2/'.Auth::guard('eksmp')->user()->id_role.'/'.Auth::guard('eksmp')->user()->id) }}">
                     <b> Profil <?php if(Auth::guard('eksmp')->user()->id_role == 2){ echo " Eksportir"; }else if(Auth::guard('eksmp')->user()->id_role == 3){ echo " Importir"; } ?></b>
                    </a>
					 <?php } }else{ ?>
					 
					  <?php } ?>
                   
					<!-- <a style="padding-top:10px;"class="dropdown-item" href="{{ url('gantipass') }}">
                     <b> Ganti Password </b>
                    </a> -->
					<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      <b >Log Out </b>
                     </a>
					
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                    </form>
                    
                  </div>
                </li>
                <!-- Navarbar toggle btn -->
                <li class="d-lg-none d-flex align-items-center">
                  <a href="#" class="mx-2" data-toggle="collapse" data-target="#navbarToggler">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 512 512"><path d="M64 144h384v32H64zM64 240h384v32H64zM64 336h384v32H64z"/></svg>
                  </a>
                </li>
              </ul>
              <!-- Navbar collapse -->
                <div class="collapse navbar-collapse no-grow order-lg-1" id="navbarToggler">
              <!-- <form class="input-group m-2 my-lg-0">
                  <span class="input-group-btn">
                    <button type="button" class="btn no-border no-bg no-shadow"><i class="fa fa-search"></i></button>
                  </span>
                  <input type="text" class="form-control no-border no-bg no-shadow" placeholder="Search projects...">
              </form> -->
              </div>
            
            </div>
        </div>




        <!-- Main -->
        <div class="content-main " id="content-main">

        <!-- ############ Main START-->