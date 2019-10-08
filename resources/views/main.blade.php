     @if(Auth::user()->id_group==1)
   <div class="content-header white  box-shadow-0" id="content-header" style="background-color:  #2791a6  ; color: #ffffff">
    @elseif(Auth::user()->id_group==3)
    <div class="content-header white  box-shadow-0" id="content-header" style="background-color:  #2791a6  ; color: #ffffff">
      @else
      <div class="content-header white  box-shadow-0" id="content-header" style="background-color:  #2791a6  ; color: #ffffff">
      @endif
  
            <div class="navbar navbar-expand-lg">
              <!-- btn to toggle sidenav on small screen -->
              <a class="d-lg-none mx-2" data-toggle="modal" data-target="#aside">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512"><path d="M80 304h352v16H80zM80 248h352v16H80zM80 192h352v16H80z"/></svg>
              </a>
              <!-- Page title -->
              <div class="navbar-text nav-title flex" id="pageTitle">{{$pageTitle}}</div>
            
              <ul class="nav flex-row order-lg-2">
                <!-- Notification -->
             
                <!-- User dropdown menu -->
                <li class="dropdown d-flex align-items-center">
                  <a href="#" data-toggle="dropdown" class="d-flex align-items-center">
                    <span class="avatar w-32">
                      <!-- <img src="{{url('assets')}}/assets/images/logo.png" alt="..."> -->
                    </span>
                    <span class="dropdown-toggle  mx-2 d-none l-h-1x d-lg-block">
                      <span>{{ Auth::user()->name }}</span>
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
					
                    <a style="padding-top:10px;"class="dropdown-item" href="{{ url('gantipass') }}">
                      Ganti Password
                    </a>
					<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      Log Out
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