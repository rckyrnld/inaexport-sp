   <!-- Flex nav content -->

      <div class="flex hide-scroll" style="padding-top:15px; background-color:  black  ; color: #ffffff">
     
      <div class="scroll">
        <div class="nav-border b-primary" data-nav>
          <ul class="nav bg">
		  <?php $menu=DB::select('select * from menu order by id_menu desc');
      ?>
           @foreach(Menu::get() as $res)
           @if($res->parent == NULL && $res->url != NULL)

           <li>
            <a href="{{url($res->url)}}">
              <span class="nav-icon">
                <i class="fa {{$res->icon}}"></i>
              </span>
              <span class="nav-text"><b>{{$res->menu_name}}</b></span>
            </a>
          </li>

          {{-- independent menu --}}

          @elseif($res->parent == NULL && $res->url == NULL)

          <li>
            <a>
              <span class="nav-caret">
                <i class="fa fa-caret-down"></i>
              </span>
              <span class="nav-icon">
                <i class="fa {{$res->icon}}"></i>
              </span>
              <span class="nav-text"><b>{{$res->menu_name}}</b></span>
            </a>

            <ul class="nav-sub">
             @foreach(Menu::get() as $sub)
             @if($sub->parent == $res->id_menu)
             <li>
               <a href="{{url($sub->url)}}"><span class="nav-icon">
                <i class="fa {{$sub->icon}}"></i>
              </span>{{$sub->menu_name}}</span></a>
             </li>
             @endif
             @endforeach
           </ul>

         </li>

         @endif


         @endforeach
		 
		 <?php if(empty(Auth::user()->id_group)){ ?>
		 
		 <?php }else { ?>

         @if(Auth::user()->id_group == 1)

         <li class="nav-header hidden-folded mt-2">
          <span class="text-xs">Users Management</span>
        </li>

        <li>
          <a href="{{url('/group')}}">
            <span class="nav-icon">
              <i class="badge badge-xs badge-o md b-warning"></i>
            </span>
            <span class="nav-text">Group</span>
          </a>
        </li> 

        <li>
          <a href="{{url('/users')}}">
            <span class="nav-icon">
              <i class="badge badge-xs badge-o md b-primary"></i>
            </span>
            <span class="nav-text">User</span>
          </a>
        </li> 

        <li>
          <a href="{{url('/menus')}}">
            <span class="nav-icon">
              <i class="badge badge-xs badge-o md"></i>
            </span>
            <span class="nav-text">Menu</span>
          </a>
        </li> 

        <li>
          <a href="{{url('/permissions')}}">
            <span class="nav-icon">
              <i class="badge badge-xs badge-o md b-success"></i>
            </span>
            <span class="nav-text">Setting Menu</span>
          </a>
        </li> 
		

        @endif

		 <?php } ?>

        <li class="pb-2 hidden-folded"></li>

      </ul>

    </div>
  </div>
</div>
