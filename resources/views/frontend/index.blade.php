@include('frontend.layout.header')

<div class="d-flex flex-column flex" style="">
	<div class="light bg pos-rlt box-shadow" style="padding-left:10px; padding-right:10px; padding-top:10px; padding-bottom:10px;    background-color: #2791a6 ; color: #ffffff">
    <div class="mx-auto">
    	<table border="0" width="100%">
      	<tr>
      	<td width="30%" style="font-size:13px;padding-left:10px"><img height="30px" src="{{url('assets')}}/assets/images/logo.jpg" alt="." ><b>&nbsp;&nbsp;&nbsp; Ministry Of Trade</b></td>
      	<td width="30%"></td>
      	<td width="40%" align="right" style="padding-right:10px;">
        	<a href="{{ url('locale/en') }}"><img width="20px" height="15px" src="{{asset('negara/en.png')}}"></a>&nbsp;
        	<a href="{{ url('locale/in') }}"><img width="20px" height="15px" src="{{asset('negara/in.png')}}"></a>&nbsp;
        	<a href="{{ url('locale/ch') }}"><img width="20px" height="15px" src="{{asset('negara/ch.png')}}"></a>&nbsp;&nbsp;&nbsp;
        	<a href="{{url('login')}}"><font color="white"><i class="fa fa-sign-in"></i> @lang("frontend.lbl3")</font></a>
      	</td>
      	</tr>
    	</table>
    </div>
  </div>
  <div id="content-body">
    <div class="py-5 text-center w-100">
      <h4><b>@lang("frontend.title2")</b></h4><br>
      <center>
      <table class="table" style="width: 90%; padding: 20px;">
        <thead>
          <th colspan="5">
            <h5><b>@lang("frontend.prodtitle")</b></h5>
            <div style="float: right; margin-top: -30px;">
              <a href="{{ url('front_end/all_product') }}" class="btn btn-default btn-sm">@lang("frontend.moreproduct")</a>
            </div>
          </th>
        </thead>
        <tbody>
          <?php
          $co = 0;
          $loc = app()->getLocale();
        ?>
        @foreach($product as $p)
          @if($co < 5)
            @if($co == 0)
            <tr>
            @endif
            <td width="20%">
              <?php
                if($loc == "ch"){
                  $nameprod = $p->prodname_chn;
                }elseif($loc == "in"){
                  $nameprod = $p->prodname_in;
                }else{
                  $nameprod = $p->prodname_en;
                }

                if($nameprod == NULL){
                  $nameprod = $p->prodname_en;
                }
              ?>
              <a type="button" class="btn btn-default" style="width: 220px; background: white; height: 250px; max-height: 250px; max-width: 100%; padding: 10px;" title="{{$nameprod}}">
                <?php
                  $img = "";
                  if($p->image_1 != NULL){
                    $img = $p->image_1;
                  }else if($p->image_2 != NULL){
                    $img = $p->image_2;
                  }else if($p->image_3 != NULL){
                    $img = $p->image_3;
                  }else if($p->image_4 != NULL){
                    $img = $p->image_4;
                  }

                  if($img == ""){
                    $isimg = '/image/noimage.jpg';
                  }else{
                    $image = 'uploads/Eksportir_Product/Image/'.$p->id.'/'.$img; 
                    if(file_exists($image)) {
                      $isimg = '/uploads/Eksportir_Product/Image/'.$p->id.'/'.$img;
                    }else {
                      $isimg = '/image/noimage.jpg';
                    }  
                  }
                ?>
                <img src="{{url('/')}}{{$isimg}}" style="width: 200px; height: 200px;">
                <?php
                  $num_char = 25;
                  $text = $nameprod;
                  if(strlen($text) > 25){
                      $cut_text = substr($text, 0, $num_char);
                      if ($text{$num_char - 1} != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                          $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                          $cut_text = substr($text, 0, $new_pos);
                      }
                      $nameprodnya =  $cut_text . '...';
                  }else{
                      $nameprodnya =  $text;
                  }
                ?>
                <br><b>
                  {{$nameprodnya}}
                </b>
              </a>
            </td>
            @if($co == 4)
            </tr>
            @endif
            <?php if($co == 4){ $co = 0;}else{ $co++; } ?>
          @endif
        @endforeach
        </tbody>
      </table>
    </center>
        <div class="px-3">
         {{--  <div>
            <a href="#" class="btn btn-block indigo text-white mb-2">
              <i class="fa fa-facebook float-left"></i>
              Sign in with Facebook
            </a>
            <a href="#" class="btn btn-block red text-white">
              <i class="fa fa-google-plus float-left"></i>
              Sign in with Google+
            </a>
          </div> --}}
          {{-- <div class="my-3 text-sm">
            OR
          </div> --}}
         
		  
          <div class="my-4">
           <!-- <a href="{{ route('password.request') }}" class="text-primary _600">Forgot password?</a> -->
          </div>
          <div>
           <!-- Do not have an account? 
            <a href="{{url('register')}}" class="text-primary _600">Sign up</a> -->
          </div>
        </div>
		
      </div>
    </div>
  </div>
</div>


<!-- ############ SWITHCHER START-->
<div id="setting">
  <div class="setting dark-white rounded-bottom" id="theme">
    <a href="#" data-toggle-class="active" data-target="#theme" class="dark-white toggle">
      <i class="fa fa-gear text-primary fa-spin"></i>
    </a>
    <div class="box-header">
      <a href="https://themeforest.net/item/apply-web-application-admin-template/21072584?ref=flatfull" class="btn btn-xs rounded danger float-right">BUY</a>
      <strong>Theme Switcher</strong>
    </div>
    <div class="box-divider"></div>
    <div class="box-body">
      <p id="settingLayout">
        <label class="md-check my-1 d-block">
          <input type="checkbox" name="fixedAside">
          <i></i>
          <span>Fixed Aside</span>
        </label>
        <label class="md-check my-1 d-block">
          <input type="checkbox" name="fixedContent">
          <i></i>
          <span>Fixed Content</span>
        </label>
        <label class="md-check my-1 d-block">
          <input type="checkbox" name="folded">
          <i></i>
          <span>Folded Aside</span>
        </label>
        <label class="md-check my-1 d-block">
          <input type="checkbox" name="container">
          <i></i>
          <span>Boxed Layout</span>
        </label>
        <label class="md-check my-1 d-block">
          <input type="checkbox" name="ajax">
          <i></i>
          <span>Ajax load page</span>
        </label>
        <label class="pointer my-1 d-block" data-toggle="fullscreen" data-plugin="screenfull" data-target="fullscreen">
          <span class="ml-1 mr-2 auto">
            <i class="fa fa-expand d-inline"></i>
            <i class="fa fa-compress d-none"></i>
          </span>
          <span>Fullscreen mode</span>
        </label>
      </p>
      <p>Colors:</p>
      <p>
        <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
          <input type="radio" name="theme" value="primary">
          <i class="primary"></i>
        </label>
        <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
          <input type="radio" name="theme" value="accent">
          <i class="accent"></i>
        </label>
        <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
          <input type="radio" name="theme" value="warn">
          <i class="warn"></i>
        </label>
        <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
          <input type="radio" name="theme" value="info">
          <i class="info"></i>
        </label>
        <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
          <input type="radio" name="theme" value="success">
          <i class="success"></i>
        </label>
        <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
          <input type="radio" name="theme" value="warning">
          <i class="warning"></i>
        </label>
        <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
          <input type="radio" name="theme" value="danger">
          <i class="danger"></i>
        </label>
      </p>
      <div class="row no-gutters">
        <div class="col">
          <p>Brand</p>
          <p>
            <label class="radio radio-inline m-0 mr-1 ui-check">
              <input type="radio" name="brand" value="dark-white">
              <i class="light"></i>
            </label>
            <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
              <input type="radio" name="brand" value="dark">
              <i class="dark"></i>
            </label>
          </p>
        </div>
        <div class="col mx-2">
          <p>Aside</p>
          <p>
            <label class="radio radio-inline m-0 mr-1 ui-check">
              <input type="radio" name="aside" value="white">
              <i class="light"></i>
            </label>
            <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
              <input type="radio" name="aside" value="dark">
              <i class="dark"></i>
            </label>
          </p>
        </div>
        <div class="col">
          <p>Themes</p>
          <div class="clearfix">
            <label class="radio radio-inline ui-check">
              <input type="radio" name="bg" value="">
              <i class="light"></i>
            </label>
            <label class="radio radio-inline ui-check ui-check-color">
              <input type="radio" name="bg" value="dark">
              <i class="dark"></i>
            </label>
          </div>
        </div>
      </div>
      <p>Demos</p>
      <div class="text-md">
        <a href="dashboard.html?folded=false&amp;bg=&amp;aside=dark&amp;brand=dark" class="no-ajax badge light">0</a>
        <a href="dashboard.1.html?folded=false&amp;bg=&amp;aside=dark&amp;brand=dark-white" class="no-ajax badge light">1</a>
        <a href="dashboard.2.html?folded=false&amp;bg=&amp;aside=dark&amp;brand=white" class="no-ajax badge light">2</a>
        <a href="dashboard.3.html?folded=false&amp;bg=&amp;aside=white&amp;brand=white" class="no-ajax badge light">3</a>
        <a href="dashboard.4.html?folded=true&amp;bg=&amp;aside=dark" class="no-ajax badge light">4</a>
        <a href="dashboard.5.html?folded=true&amp;bg=&amp;aside=dark&amp;brand=dark" class="no-ajax badge light">5</a>
        <a href="dashboard.6.html?folded=false&amp;bg=&amp;aside=white&amp;brand=white" class="no-ajax badge light">6</a>
        <a href="dashboard.7.html?folded=false&amp;bg=&amp;aside=dark&amp;brand=dark" class="no-ajax badge light">7</a>
        <a href="dashboard.8.html?folded=false&amp;bg=&amp;aside=white&amp;brand=white" class="no-ajax badge light">8</a>
        <a href="rtl.html?folded&amp;bg=" class="no-ajax badge light">RTL</a>
      </div>
    </div>
  </div>
</div>
<!-- ############ SWITHCHER END-->

@include('frontend.layout.footer')