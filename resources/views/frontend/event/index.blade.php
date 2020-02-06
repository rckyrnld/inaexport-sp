@include('frontend.layouts.header')
<?php
$loc = app()->getLocale();
if(Auth::guard('eksmp')->user()){
    if(Auth::guard('eksmp')->user()->id_role == 2){
        $id_user = Auth::guard('eksmp')->user()->id;
    } else {
        $id_user = '0';
    }
} else {
    $id_user = '0';
}

?>
<style type="text/css">
    img.rc{
        max-width: 100%;
        max-height: 100%;
        border-radius: 10px;
    }
    .detail_rc{
        color: #1a70bb;
        font-family: 'Myriad-pro' !important;
        font-size: 14px;
    }
    .a-modif:hover{
        text-decoration: none;
        background-color: #f4f4f5;
    }
    .a-modif.small{
        height: 100%; border-radius: 10px; background-color: white;
    }
    .form-control:focus {
        border-color: #66afe9;
        outline: 0;
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6);
        box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6);
    }
    .search{
        border-top: 2px solid #1a70bb;
        border-bottom: 2px solid #1a70bb;
    }

    .kontennya:hover{
        box-shadow: 0 0 15px rgba(194, 216, 255, 1)
    }

    .sel-event{
        height: 100%;
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
        padding-left: 5px;
        background-color: #f7f7f7;
        border-left: 2px solid #1a70bb;
        border-top: 2px solid #1a70bb;
        border-bottom: 2px solid #1a70bb;
    }

    .css-title{ font-family: arial; font-weight: 530; font-size: 18px; color: black !important; }

    .search-event{
        width: 100%;
    }
    .tabcontent {
        display: none;
    }
    .tablinks{
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
        font-size: 17px;
    }
    .tabmin button.active {
        background-color: red;
    }

    /*@media only screen and (max-width: 767px) {
      .search-event{
        width: 100%;
      }
    }
    @media only screen and (max-width: 479px) {
      .search-event{
        width: 100%;
      }
    }*/
</style>
<!--breadcrumbs area start-->
<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="{{url('/')}}">@lang("frontend.proddetail.home")</a></li>
                        <li>Events</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<div style="background-color: white; padding-bottom: 3%;">
    <div class="container ">
        <ul class="nav nav-tabs" id="tab1">
            <li class="nav-item tabmin" >
                <button class="tablinks" onclick="openTab(event, 'all')">@lang("frontend.jdl_event1")</button>
                {{--                <a class="nav-link show active" data-toggle="tab" id="all" href="#all">All</a>--}}
            </li>
            <li class="nav-item tabmin">
                <button class="tablinks" onclick="openTab(event, 'indonesia')">@lang("frontend.jdl_event2")</button>
                {{--                <a class="nav-link show" data-toggle="tab" id="indonesia" href="#indonesia">Indonesia</a>--}}
            </li>
            <li class="nav-item tabmin">
                <button class="tablinks" onclick="openTab(event, 'foreign')">@lang("frontend.jdl_event3")</button>
                {{--                <a class="nav-link show" data-toggle="tab" id="foreign" href="#foreign">Foreign</a>--}}
            </li>
        </ul>
    </div>
    {{--  tab all start  --}}
    <div class="tabcontent" id="all" style="display: block" >
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-6" style="padding-right: 0px;"><br>
                    <span style="color: #1a70bb;"><h2>@lang("frontend.jdl_event")</h2></span>
                </div>
                <div class="col-md-6 col-lg-6" align="right"><br>
                    <form class="form-horizontal" enctype="multipart/form-data" method="GET" action="{{url('/front_end/event')}}">
                        {{ csrf_field() }}
                        <div class="input-group search-event">
                            <div class="input-group-prepend">
                                <select id="search" name="search" class="sel-event">
                                    <option value="1" @if($searchEvent == 1) selected @endif>Name</option>
                                    <option value="2" @if($searchEvent == 2) selected @endif>Date</option>
                                    <option value="3" @if($searchEvent == 3) selected @endif>Country</option>
                                </select>
                            </div>
                            <input type="text" id="search_name" name="nama" class="form-control search" placeholder="Search" autocomplete="off" @if($searchEvent == 1) value="{{$param}}" @endif>
                            <input type="date" id="search_date" name="tanggal" class="form-control search" placeholder="Search" autocomplete="off" @if($searchEvent == 2) value="{{$param}}" @endif>
                            <select class="form-control search" id="search_country" name="country">
                                <option value="" style="display: none;">Select Country</option>
                                @foreach($country as $data)
                                    <option value="{{$data->id}}" @if($searchEvent == 3 && $data->id == $param) selected @endif>{{$data->country}}</option>
                                @endforeach
                            </select>
                            <div class="input-group-prepend">
                                <button type="submit" class="input-group-text" style="border-top-right-radius: 5px;border-bottom-right-radius: 5px; background-color: #1a70bb; border-color: transparent; color: white;">&nbsp;<i class="fa fa-search"></i>&nbsp;</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!--       <div class="col-md-6 col-lg-3"></div> -->
            </div><br>
            @if($page > 1 || $searchEvent != null)
                <div class="row justify-content-center">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="row shop_wrapper">
                            @endif
                            @foreach($e_detail as $key => $ed)
                                <a href="{{url('/front_end/join_event/')}}/{{$ed->id}}" class="a-modif">
                                    @if($page == 1 && $searchEvent == null)
                                        @if($key == 0 || $key == 5 )
                                            <div class="form-group row utama" style="height: 100%">
                                                @endif
                                                @endif

                                                @if($page == 1 && $searchEvent == null)
                                                    @if( $key == 0 || $key == 1 )
                                                        <div class="col-lg-6 col-md-6 col-12 second @if($key == 0) a-modif @endif" style="height: 100%; border-radius: 10px; @if($key == 0) background-color: white; @endif">
                                                            <?php $size = 438; $num_char = 55;?>
                                                            @if($key == 0 )
                                                                <div class="kontennya" style="width: 100%;padding: 12px; background-color: #f8f8f8; border-radius: 10px">
                                                                    @endif
                                                                    @elseif($key >= 5)
                                                                        <div class="col-lg-3 col-md-3 col-12 second a-modif small">
                                                                            <?php $size = 162; $num_char = 25;?>
                                                                            <div class="kontennya" style="width: 100%;padding: 12px; background-color: #f8f8f8; border-radius: 10px">
                                                                                @endif
                                                                                @else
                                                                                    <div class="col-lg-3 col-md-3 col-12 second a-modif small">
                                                                                        <div class="kontennya" style="width: 100%;padding: 12px; background-color: #f8f8f8; margin-bottom: 12px; border-radius: 10px">
                                                                                            <?php $size = 162; $num_char = 25;?>
                                                                                            @endif

                                                                                            @if($page == 1 && $searchEvent == null)
                                                                                                @if( $key > 0 && $key < 5)
                                                                                                    @if($key == 1)
                                                                                                        <div class="form-group row" style="height: 100%;">
                                                                                                            @endif
                                                                                                            <div class="col-lg-6 col-md-6 col-12 a-modif" style="height: 50%; border-radius: 10px; background-color: white;">
                                                                                                                <?php $size = 162; $num_char = 25;?>
                                                                                                                <div class="kontennya" style="width: 100%;padding: 12px; margin-bottom: 10px; background-color: #f8f8f8; border-radius: 10px">
                                                                                                                    @endif
                                                                                                                    @endif
                                                                                                                    <?php
                                                                                                                    if($loc == "ch"){
                                                                                                                        if($ed->event_name_chn != null){
                                                                                                                            $title = $ed->event_name_chn;
                                                                                                                        } else {
                                                                                                                            $title = $ed->event_name_en;
                                                                                                                        }
                                                                                                                    }elseif($loc == "in"){
                                                                                                                        if($ed->event_name_in != null){
                                                                                                                            $title = $ed->event_name_in;
                                                                                                                        } else {
                                                                                                                            $title = $ed->event_name_en;
                                                                                                                        }
                                                                                                                    }else{
                                                                                                                        $title = $ed->event_name_en;
                                                                                                                    }

                                                                                                                    if(date('Y-m-d', strtotime($ed->start_date)) == date('Y-m-d', strtotime($ed->end_date))){
                                                                                                                        $tanggal = date('d F Y', strtotime($ed->start_date));
                                                                                                                    } else if(date('Y-m', strtotime($ed->start_date)) == date('Y-m', strtotime($ed->end_date))){
                                                                                                                        $tanggal = date('d', strtotime($ed->start_date)).' - '.date('d F Y', strtotime($ed->end_date));
                                                                                                                    } else {
                                                                                                                        $tanggal = date('d F Y', strtotime($ed->start_date)).' - '.date('d F Y', strtotime($ed->end_date));
                                                                                                                    }

                                                                                                                    $lokasi = EventPlaceName($ed->id_event_place, $loc);

                                                                                                                    if (Auth::guard('eksmp')->user()) {
                                                                                                                        $id_ = Auth::guard('eksmp')->user()->id;
                                                                                                                        $data = DB::table('event_company_add')->where('id_itdp_profil_eks', $id_)->where('id_event_detail', $ed->id)->first();
                                                                                                                        if ($data) {
                                                                                                                            $statt = $data->status;
                                                                                                                        }else{
                                                                                                                            $statt = null;
                                                                                                                        }
                                                                                                                    }else{
                                                                                                                        $statt = null;
                                                                                                                    }

                                                                                                                    $image = 'uploads/Event/Image/'.$ed->id.'/'.$ed->image_1;
                                                                                                                    if($ed->image_1 != null || $ed->image_1 != ''){
                                                                                                                        if(file_exists($image)) {
                                                                                                                            $image = 'uploads/Event/Image/'.$ed->id.'/'.$ed->image_1;
                                                                                                                        } else {
                                                                                                                            $image = '/image/event/NoPicture.png';
                                                                                                                        }
                                                                                                                    } else {
                                                                                                                        $image = '/image/event/NoPicture.png';
                                                                                                                    }

                                                                                                                    if(strlen($title) > $num_char - 5){
                                                                                                                        $cut_text = substr($title, 0, $num_char - 5);
                                                                                                                        if ($title{$num_char - 5 - 1} != ' ') {
                                                                                                                            $new_pos = strrpos($cut_text, ' ');
                                                                                                                            $cut_text = substr($title, 0, $new_pos);
                                                                                                                        }
                                                                                                                        $titleName = $cut_text . '...';
                                                                                                                    }else{
                                                                                                                        $titleName = $title;
                                                                                                                    }

                                                                                                                    if(strlen($lokasi) > ($num_char+11)){
                                                                                                                        $cut_text = substr($lokasi, 0, ($num_char+11));
                                                                                                                        if ($lokasi{ ($num_char+11) - 1} != ' ') {
                                                                                                                            $new_pos = strrpos($cut_text, ' ');
                                                                                                                            $cut_text = substr($lokasi, 0, $new_pos);
                                                                                                                        }
                                                                                                                        $lokasiName = $cut_text . '...';
                                                                                                                    }else{
                                                                                                                        $lokasiName = $lokasi;
                                                                                                                    }
                                                                                                                    ?>

                                                                                                                    <div style="width: 100%; height: 75%; margin: auto; text-align: center;">
                                                                                                                        <img class="rc fix-image" src="{{url('/')}}/{{$image}}" style="height: {{$size}}px;">
                                                                                                                    </div>
                                                                                                                    <div style="height: 25%; padding-top: 5px;">
                                                                                                                        <span class="css-title" title="{{$title}}">{{$titleName}}<span class="badge badge-primary" style="font-size: 11px !important; vertical-align: middle; background-color: #387bbf; margin-left: 10px;">{{getDataInterest($ed->id)}}&nbsp;&nbsp;<i class="fa fa-eye"></i></span></span><br>
                                                                                                                        <span class="detail_rc" title="{{$lokasi}}">
                  <i class="fa fa-calendar-check-o"></i>&nbsp;&nbsp;{{$tanggal}}
                  <br>
                  <i class="fa fa-map-marker"></i>&nbsp;&nbsp;&nbsp;{{$lokasiName}}<br>
                  </span>
                                                                                                                    </div>
                                </a>
                        </div>
                    </div>
                    @if($page == 1 && $searchEvent == null)
                        @if( $key == 4 || $key == 9)
                </div>
                @if($key == 4)
        </div></div>
    @endif
    @endif
    @endif
    @endforeach

    @if($page > 1)
</div></div>
</div>
@endif
</div>
<br><br>
<div class="row">
    <div class="container">
        <div class="row justify-content-center" align="center" id="paginate1">
            {{ $e_detail->fragment('page_a')->render("pagination::bootstrap-4") }}
        </div>
    </div>
</div>
<br>
</div>
</div>
{{--  tab all end  --}}
{{--  tab indonesia start  --}}
<div class="tabcontent" id="indonesia">
    <div class="container"  >
        <div class="row">
            <div class="col-md-6 col-lg-6" style="padding-right: 0px;"><br>
                <span style="color: #1a70bb;"><h2>@lang("frontend.jdl_event")</h2></span>
            </div>
            <div class="col-md-6 col-lg-6" align="right"><br>
                <form class="form-horizontal" enctype="multipart/form-data" method="GET" action="{{url('/front_end/event')}}">
                    {{ csrf_field() }}
                    <div class="input-group search-event">
                        <div class="input-group-prepend">
                            <select id="search2" name="search2" class="sel-event">
                                <option value="1" @if($searchEvent2 == 1) selected @endif>Name</option>
                                <option value="2" @if($searchEvent2 == 2) selected @endif>Date</option>
                                <option value="3" @if($searchEvent2 == 3) selected @endif>Country</option>
                            </select>
                        </div>
                        <input type="text" id="search_name2" name="nama" class="form-control search" placeholder="Search" autocomplete="off" @if($searchEvent2 == 1) value="{{$param2}}" @endif>
                        <input type="date" id="search_date2" name="tanggal" class="form-control search" placeholder="Search" autocomplete="off" @if($searchEvent2 == 2) value="{{$param2}}" @endif>
                        <select class="form-control search" id="search_country2" name="country">
                            <option value="" style="display: none;">Select Country</option>
                            @foreach($country as $data)
                                <option value="{{$data->id}}" @if($searchEvent2 == 3 && $data->id == $param2) selected @endif>{{$data->country}}</option>
                            @endforeach
                        </select>
                        <div class="input-group-prepend">
                            <button type="submit" class="input-group-text" style="border-top-right-radius: 5px;border-bottom-right-radius: 5px; background-color: #1a70bb; border-color: transparent; color: white;">&nbsp;<i class="fa fa-search"></i>&nbsp;</button>
                        </div>
                    </div>
                </form>
            </div>
            <!--       <div class="col-md-6 col-lg-3"></div> -->
        </div><br>
        @if($page2 > 1 || $searchEvent2 != null)
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="row shop_wrapper">
                        @endif
                        @foreach($e_detail2 as $key => $ed)
                            <a href="{{url('/front_end/join_event/')}}/{{$ed->id}}" class="a-modif">
                                @if($page2 == 1 && $searchEvent2 == null)
                                    @if($key == 0 || $key == 5 )
                                        <div class="form-group row utama" style="height: 100%">
                                            @endif
                                            @endif

                                            @if($page2 == 1 && $searchEvent2 == null)
                                                @if( $key == 0 || $key == 1 )
                                                    <div class="col-lg-6 col-md-6 col-12 second @if($key == 0) a-modif @endif" style="height: 100%; border-radius: 10px; @if($key == 0) background-color: white; @endif">
                                                        <?php $size = 438; $num_char = 55;?>
                                                        @if($key == 0 )
                                                            <div class="kontennya" style="width: 100%;padding: 12px; background-color: #f8f8f8; border-radius: 10px">
                                                                @endif
                                                                @elseif($key >= 5)
                                                                    <div class="col-lg-3 col-md-3 col-12 second a-modif small">
                                                                        <?php $size = 162; $num_char = 25;?>
                                                                        <div class="kontennya" style="width: 100%;padding: 12px; background-color: #f8f8f8; border-radius: 10px">
                                                                            @endif
                                                                            @else
                                                                                <div class="col-lg-3 col-md-3 col-12 second a-modif small">
                                                                                    <div class="kontennya" style="width: 100%;padding: 12px; background-color: #f8f8f8; margin-bottom: 12px; border-radius: 10px">
                                                                                        <?php $size = 162; $num_char = 25;?>
                                                                                        @endif

                                                                                        @if($page2 == 1 && $searchEvent2 == null)
                                                                                            @if( $key > 0 && $key < 5)
                                                                                                @if($key == 1)
                                                                                                    <div class="form-group row" style="height: 100%;">
                                                                                                        @endif
                                                                                                        <div class="col-lg-6 col-md-6 col-12 a-modif" style="height: 50%; border-radius: 10px; background-color: white;">
                                                                                                            <?php $size = 162; $num_char = 25;?>
                                                                                                            <div class="kontennya" style="width: 100%;padding: 12px; margin-bottom: 10px; background-color: #f8f8f8; border-radius: 10px">
                                                                                                                @endif
                                                                                                                @endif
                                                                                                                <?php
                                                                                                                if($loc == "ch"){
                                                                                                                    if($ed->event_name_chn != null){
                                                                                                                        $title = $ed->event_name_chn;
                                                                                                                    } else {
                                                                                                                        $title = $ed->event_name_en;
                                                                                                                    }
                                                                                                                }elseif($loc == "in"){
                                                                                                                    if($ed->event_name_in != null){
                                                                                                                        $title = $ed->event_name_in;
                                                                                                                    } else {
                                                                                                                        $title = $ed->event_name_en;
                                                                                                                    }
                                                                                                                }else{
                                                                                                                    $title = $ed->event_name_en;
                                                                                                                }

                                                                                                                if(date('Y-m-d', strtotime($ed->start_date)) == date('Y-m-d', strtotime($ed->end_date))){
                                                                                                                    $tanggal = date('d F Y', strtotime($ed->start_date));
                                                                                                                } else if(date('Y-m', strtotime($ed->start_date)) == date('Y-m', strtotime($ed->end_date))){
                                                                                                                    $tanggal = date('d', strtotime($ed->start_date)).' - '.date('d F Y', strtotime($ed->end_date));
                                                                                                                } else {
                                                                                                                    $tanggal = date('d F Y', strtotime($ed->start_date)).' - '.date('d F Y', strtotime($ed->end_date));
                                                                                                                }

                                                                                                                $lokasi = EventPlaceName($ed->id_event_place, $loc);

                                                                                                                if (Auth::guard('eksmp')->user()) {
                                                                                                                    $id_ = Auth::guard('eksmp')->user()->id;
                                                                                                                    $data = DB::table('event_company_add')->where('id_itdp_profil_eks', $id_)->where('id_event_detail', $ed->id)->first();
                                                                                                                    if ($data) {
                                                                                                                        $statt = $data->status;
                                                                                                                    }else{
                                                                                                                        $statt = null;
                                                                                                                    }
                                                                                                                }else{
                                                                                                                    $statt = null;
                                                                                                                }

                                                                                                                $image = 'uploads/Event/Image/'.$ed->id.'/'.$ed->image_1;
                                                                                                                if($ed->image_1 != null || $ed->image_1 != ''){
                                                                                                                    if(file_exists($image)) {
                                                                                                                        $image = 'uploads/Event/Image/'.$ed->id.'/'.$ed->image_1;
                                                                                                                    } else {
                                                                                                                        $image = '/image/event/NoPicture.png';
                                                                                                                    }
                                                                                                                } else {
                                                                                                                    $image = '/image/event/NoPicture.png';
                                                                                                                }

                                                                                                                if(strlen($title) > $num_char - 5){
                                                                                                                    $cut_text = substr($title, 0, $num_char - 5);
                                                                                                                    if ($title{$num_char - 5 - 1} != ' ') {
                                                                                                                        $new_pos = strrpos($cut_text, ' ');
                                                                                                                        $cut_text = substr($title, 0, $new_pos);
                                                                                                                    }
                                                                                                                    $titleName = $cut_text . '...';
                                                                                                                }else{
                                                                                                                    $titleName = $title;
                                                                                                                }

                                                                                                                if(strlen($lokasi) > ($num_char+11)){
                                                                                                                    $cut_text = substr($lokasi, 0, ($num_char+11));
                                                                                                                    if ($lokasi{ ($num_char+11) - 1} != ' ') {
                                                                                                                        $new_pos = strrpos($cut_text, ' ');
                                                                                                                        $cut_text = substr($lokasi, 0, $new_pos);
                                                                                                                    }
                                                                                                                    $lokasiName = $cut_text . '...';
                                                                                                                }else{
                                                                                                                    $lokasiName = $lokasi;
                                                                                                                }
                                                                                                                ?>

                                                                                                                <div style="width: 100%; height: 75%; margin: auto; text-align: center;">
                                                                                                                    <img class="rc fix-image" src="{{url('/')}}/{{$image}}" style="height: {{$size}}px;">
                                                                                                                </div>
                                                                                                                <div style="height: 25%; padding-top: 5px;">
                                                                                                                    <span class="css-title" title="{{$title}}">{{$titleName}}<span class="badge badge-primary" style="font-size: 11px !important; vertical-align: middle; background-color: #387bbf; margin-left: 10px;">{{getDataInterest($ed->id)}}&nbsp;&nbsp;<i class="fa fa-eye"></i></span></span><br>
                                                                                                                    <span class="detail_rc" title="{{$lokasi}}">
                      <i class="fa fa-calendar-check-o"></i>&nbsp;&nbsp;{{$tanggal}}
                      <br>
                      <i class="fa fa-map-marker"></i>&nbsp;&nbsp;&nbsp;{{$lokasiName}}<br>
                      </span>
                                                                                                                </div>
                            </a>
                    </div>
                </div>
                @if($page2 == 1 && $searchEvent2 == null)
                    @if( $key == 4 || $key == 9)
            </div>
            @if($key == 4)
    </div></div>
@endif
@endif
@endif
@endforeach

@if($page2 > 1)
</div></div></div>
@endif
</div>
<br><br>
<div class="row">
    <div class="container" id="2">
        <div class="row justify-content-center" align="center" id="paginate2">
            {{ $e_detail2->fragment('page_b')->render("pagination::bootstrap-4") }}
        </div>
    </div>
</div>
<br>
</div>
</div>
{{--</div>--}}
{{--</div>--}}
{{--  tab indonesia end  --}}


{{--  tab foreign start  --}}
<div class="tabcontent"  id="foreign">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-6" style="padding-right: 0px;"><br>
                <span style="color: #1a70bb;"><h2>@lang("frontend.jdl_event")</h2></span>
            </div>
            <div class="col-md-6 col-lg-6" align="right"><br>
                <form class="form-horizontal" enctype="multipart/form-data" method="GET" action="{{url('/front_end/event')}}">
                    {{ csrf_field() }}
                    <div class="input-group search-event">
                        <div class="input-group-prepend">
                            <select id="search3" name="search3" class="sel-event">
                                <option value="1" @if($searchEvent3 == 1) selected @endif>Name</option>
                                <option value="2" @if($searchEvent3 == 2) selected @endif>Date</option>
                                <option value="3" @if($searchEvent3 == 3) selected @endif>Country</option>
                            </select>
                        </div>
                        <input type="text" id="search_name3" name="nama" class="form-control search" placeholder="Search" autocomplete="off" @if($searchEvent3 == 1) value="{{$param3}}" @endif>
                        <input type="date" id="search_date3" name="tanggal" class="form-control search" placeholder="Search" autocomplete="off" @if($searchEvent3 == 2) value="{{$param3}}" @endif>
                        <select class="form-control search" id="search_country3" name="country">
                            <option value="" style="display: none;">Select Country</option>
                            @foreach($country as $data)
                                <option value="{{$data->id}}" @if($searchEvent3 == 3 && $data->id == $param3) selected @endif>{{$data->country}}</option>
                            @endforeach
                        </select>
                        <div class="input-group-prepend">
                            <button type="submit" class="input-group-text" style="border-top-right-radius: 5px;border-bottom-right-radius: 5px; background-color: #1a70bb; border-color: transparent; color: white;">&nbsp;<i class="fa fa-search"></i>&nbsp;</button>
                        </div>
                    </div>
                </form>
            </div>
            <!--       <div class="col-md-6 col-lg-3"></div> -->
        </div><br>
        @if($page3 > 1 || $searchEvent3 != null)
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="row shop_wrapper">
                        @endif
                        @foreach($e_detail3 as $key => $ed)
                            <a href="{{url('/front_end/join_event/')}}/{{$ed->id}}" class="a-modif">
                                @if($page3 == 1 && $searchEvent3 == null)
                                    @if($key == 0 || $key == 5 )
                                        <div class="form-group row utama" style="height: 100%">
                                            @endif
                                            @endif

                                            @if($page3 == 1 && $searchEvent3 == null)
                                                @if( $key == 0 || $key == 1 )
                                                    <div class="col-lg-6 col-md-6 col-12 second @if($key == 0) a-modif @endif" style="height: 100%; border-radius: 10px; @if($key == 0) background-color: white; @endif">
                                                        <?php $size = 438; $num_char = 55;?>
                                                        @if($key == 0 )
                                                            <div class="kontennya" style="width: 100%;padding: 12px; background-color: #f8f8f8; border-radius: 10px">
                                                                @endif
                                                                @elseif($key >= 5)
                                                                    <div class="col-lg-3 col-md-3 col-12 second a-modif small">
                                                                        <?php $size = 162; $num_char = 25;?>
                                                                        <div class="kontennya" style="width: 100%;padding: 12px; background-color: #f8f8f8; border-radius: 10px">
                                                                            @endif
                                                                            @else
                                                                                <div class="col-lg-3 col-md-3 col-12 second a-modif small">
                                                                                    <div class="kontennya" style="width: 100%;padding: 12px; background-color: #f8f8f8; margin-bottom: 12px; border-radius: 10px">
                                                                                        <?php $size = 162; $num_char = 25;?>
                                                                                        @endif

                                                                                        @if($page3 == 1 && $searchEvent3 == null)
                                                                                            @if( $key > 0 && $key < 5)
                                                                                                @if($key == 1)
                                                                                                    <div class="form-group row" style="height: 100%;">
                                                                                                        @endif
                                                                                                        <div class="col-lg-6 col-md-6 col-12 a-modif" style="height: 50%; border-radius: 10px; background-color: white;">
                                                                                                            <?php $size = 162; $num_char = 25;?>
                                                                                                            <div class="kontennya" style="width: 100%;padding: 12px; margin-bottom: 10px; background-color: #f8f8f8; border-radius: 10px">
                                                                                                                @endif
                                                                                                                @endif
                                                                                                                <?php
                                                                                                                if($loc == "ch"){
                                                                                                                    if($ed->event_name_chn != null){
                                                                                                                        $title = $ed->event_name_chn;
                                                                                                                    } else {
                                                                                                                        $title = $ed->event_name_en;
                                                                                                                    }
                                                                                                                }elseif($loc == "in"){
                                                                                                                    if($ed->event_name_in != null){
                                                                                                                        $title = $ed->event_name_in;
                                                                                                                    } else {
                                                                                                                        $title = $ed->event_name_en;
                                                                                                                    }
                                                                                                                }else{
                                                                                                                    $title = $ed->event_name_en;
                                                                                                                }

                                                                                                                if(date('Y-m-d', strtotime($ed->start_date)) == date('Y-m-d', strtotime($ed->end_date))){
                                                                                                                    $tanggal = date('d F Y', strtotime($ed->start_date));
                                                                                                                } else if(date('Y-m', strtotime($ed->start_date)) == date('Y-m', strtotime($ed->end_date))){
                                                                                                                    $tanggal = date('d', strtotime($ed->start_date)).' - '.date('d F Y', strtotime($ed->end_date));
                                                                                                                } else {
                                                                                                                    $tanggal = date('d F Y', strtotime($ed->start_date)).' - '.date('d F Y', strtotime($ed->end_date));
                                                                                                                }

                                                                                                                $lokasi = EventPlaceName($ed->id_event_place, $loc);

                                                                                                                if (Auth::guard('eksmp')->user()) {
                                                                                                                    $id_ = Auth::guard('eksmp')->user()->id;
                                                                                                                    $data = DB::table('event_company_add')->where('id_itdp_profil_eks', $id_)->where('id_event_detail', $ed->id)->first();
                                                                                                                    if ($data) {
                                                                                                                        $statt = $data->status;
                                                                                                                    }else{
                                                                                                                        $statt = null;
                                                                                                                    }
                                                                                                                }else{
                                                                                                                    $statt = null;
                                                                                                                }

                                                                                                                $image = 'uploads/Event/Image/'.$ed->id.'/'.$ed->image_1;
                                                                                                                if($ed->image_1 != null || $ed->image_1 != ''){
                                                                                                                    if(file_exists($image)) {
                                                                                                                        $image = 'uploads/Event/Image/'.$ed->id.'/'.$ed->image_1;
                                                                                                                    } else {
                                                                                                                        $image = '/image/event/NoPicture.png';
                                                                                                                    }
                                                                                                                } else {
                                                                                                                    $image = '/image/event/NoPicture.png';
                                                                                                                }

                                                                                                                if(strlen($title) > $num_char - 5){
                                                                                                                    $cut_text = substr($title, 0, $num_char - 5);
                                                                                                                    if ($title{$num_char - 5 - 1} != ' ') {
                                                                                                                        $new_pos = strrpos($cut_text, ' ');
                                                                                                                        $cut_text = substr($title, 0, $new_pos);
                                                                                                                    }
                                                                                                                    $titleName = $cut_text . '...';
                                                                                                                }else{
                                                                                                                    $titleName = $title;
                                                                                                                }

                                                                                                                if(strlen($lokasi) > ($num_char+11)){
                                                                                                                    $cut_text = substr($lokasi, 0, ($num_char+11));
                                                                                                                    if ($lokasi{ ($num_char+11) - 1} != ' ') {
                                                                                                                        $new_pos = strrpos($cut_text, ' ');
                                                                                                                        $cut_text = substr($lokasi, 0, $new_pos);
                                                                                                                    }
                                                                                                                    $lokasiName = $cut_text . '...';
                                                                                                                }else{
                                                                                                                    $lokasiName = $lokasi;
                                                                                                                }
                                                                                                                ?>

                                                                                                                <div style="width: 100%; height: 75%; margin: auto; text-align: center;">
                                                                                                                    <img class="rc fix-image" src="{{url('/')}}/{{$image}}" style="height: {{$size}}px;">
                                                                                                                </div>
                                                                                                                <div style="height: 25%; padding-top: 5px;">
                                                                                                                    <span class="css-title" title="{{$title}}">{{$titleName}}<span class="badge badge-primary" style="font-size: 11px !important; vertical-align: middle; background-color: #387bbf; margin-left: 10px;">{{getDataInterest($ed->id)}}&nbsp;&nbsp;<i class="fa fa-eye"></i></span></span><br>
                                                                                                                    <span class="detail_rc" title="{{$lokasi}}">
                      <i class="fa fa-calendar-check-o"></i>&nbsp;&nbsp;{{$tanggal}}
                      <br>
                      <i class="fa fa-map-marker"></i>&nbsp;&nbsp;&nbsp;{{$lokasiName}}<br>
                      </span>
                                                                                                                </div>
                            </a>
                    </div>
                </div>
                @if($page3 == 1 && $searchEvent3 == null)
                    @if( $key == 4 || $key == 9)
            </div>
            @if($key == 4)
    </div></div>
@endif
@endif
@endif
@endforeach

@if($page3 > 1)
</div></div></div>
@endif
</div>
<br><br>
<div class="row">
    <div class="container">
        <div class="row justify-content-center" align="center" id="paginate3">
            {{ $e_detail3->fragment('page_c')->render("pagination::bootstrap-4") }}
        </div>
    </div>
</div>
<br>
</div>

</div>

{{--  tab foreign end  --}}
</div>
<input type="hidden" id="urlprev" value="">

<div style="margin-top: 0px; margin-bottom: 5%; background-color: white;"></div>
</div>
@include('frontend.layouts.footer')
<script type="text/javascript">




    // document.onload
    // $('#paginate1').click(function(){
    //
    // });
    // $('#paginate2').click(function(){
    //     document.getElementById('indonesia').style.display = "block";
    // });
    // $('#paginate3').click(function(){
    //     alert('paginate3');
    // });


    $(document).ready(function() {
        $( window ).on( 'load hashchange', function(){

            var tab_id = location.hash || '';
            // Remove the hash (i.e. `#`)
            tab_id = tab_id.substring(1);
            //
            console.log(tab_id);
            if ( tab_id ) {
                if(tab_id == 'page_a'){
                    document.getElementById('all').style.display = "block";
                    document.getElementById('indonesia').style.display = "none";
                    document.getElementById('foreign').style.display = "none";
                }else if(tab_id == 'page_b'){
                    document.getElementById('all').style.display = "none";
                    document.getElementById('indonesia').style.display = "block";
                    document.getElementById('foreign').style.display = "none";
                }else if(tab_id == 'page_c'){
                    document.getElementById('all').style.display = "none";
                    document.getElementById('indonesia').style.display = "none";
                    document.getElementById('foreign').style.display = "block";
                }
            }
            else {
            }
        } );


        if(window.innerWidth <= 760){
            $('.fix-image').css('height','162px');
        }

        var search = "{{$searchEvent}}";
        if(search == 2){
            $('#search_name').hide();
            $('#search_country').hide();
        } else if(search == 3){
            $('#search_name').hide();
            $('#search_date').hide();
        } else {
            $('#search_date').hide();
            $('#search_country').hide();
        }

        var search2 = "{{$searchEvent2}}";
        if(search2 == 2){
            $('#search_name2').hide();
            $('#search_country2').hide();
        } else if(search2 == 3){
            $('#search_name2').hide();
            $('#search_date2').hide();
        } else {
            $('#search_date2').hide();
            $('#search_country2').hide();
        }

        var search3 = "{{$searchEvent3}}";
        if(search3 == 2){
            $('#search_name3').hide();
            $('#search_country3').hide();
        } else if(search3 == 3){
            $('#search_name3').hide();
            $('#search_date3').hide();
        } else {
            $('#search_date3').hide();
            $('#search_country3').hide();
        }

        $('#search').on('change', function(){
            var pilihan = this.value;
            if(pilihan == 1){
                $('#search_name').show();
                $('#search_date').hide();
                $('#search_country').hide();

                $('#search_date').val('');
                $('#search_country').val('');
            } else if(pilihan == 2){
                $('#search_name').hide();
                $('#search_date').show();
                $('#search_country').hide();

                $('#search_name').val('');
                $('#search_country').val('');
            } else {
                $('#search_name').hide();
                $('#search_date').hide();
                $('#search_country').show();

                $('#search_name').val('');
                $('#search_date').val('');
            }
        });

        $('#search2').on('change', function(){
            var pilihan = this.value;
            if(pilihan == 1){
                $('#search_name2').show();
                $('#search_date2').hide();
                $('#search_country2').hide();

                $('#search_date2').val('');
                $('#search_country2').val('');
            } else if(pilihan == 2){
                $('#search_name2').hide();
                $('#search_date2').show();
                $('#search_country2').hide();

                $('#search_name2').val('');
                $('#search_country2').val('');
            } else {
                $('#search_name2').hide();
                $('#search_date2').hide();
                $('#search_country2').show();

                $('#search_name2').val('');
                $('#search_date2').val('');
            }
        });

        $('#search3').on('change', function(){
            var pilihan = this.value;
            if(pilihan == 1){
                $('#search_name3').show();
                $('#search_date3').hide();
                $('#search_country3').hide();

                $('#search_date3').val('');
                $('#search_country3').val('');
            } else if(pilihan == 2){
                $('#search_name3').hide();
                $('#search_date3').show();
                $('#search_country3').hide();

                $('#search_name3').val('');
                $('#search_country3').val('');
            } else {
                $('#search_name3').hide();
                $('#search_date3').hide();
                $('#search_country3').show();

                $('#search_name3').val('');
                $('#search_date3').val('');
            }
        });
    })

    function openTab(evt, Tabname) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";


        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(Tabname).style.display = "block";
        evt.currentTarget.className += " active";
        // console.log(location.pathname);
        // function reloadPageWithHash() {
        //     var initialPage = location.pathname;
        // }
        // var button = Tabname;
        // console.log(button);
        var halaman = Tabname;
        if(halaman == 'all'){
            document.getElementById('all').style.display = "block";
        } else if(halaman == 'indonesia'){
            console.log('indonesia');
            document.getElementById('indonesia').style.display = "block";
        }else if(halaman == 'foreign'){
            console.log('foreign');
            document.getElementById('foreign').style.display = "block";
        }
        // console.log(location.pathname);
        // location.hash
        // location.replace('http://localhost:88/kemendag/public/front_end/event?page=1');
        // console.log(halaman);
    }

    $(window).bind('hashchange', function() {
       alert('tes');
    });

    // $('.pagination').onclick()
</script>

