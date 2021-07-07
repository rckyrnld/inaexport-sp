<div class="container">
                <div class="top_inner">
                    <div class="row align-items-center">
                        <div class="col-lg-12 col-md-12 col-12" align="right">
                            <div class="top_right settocenter">
                                <ul style="padding-top: 5px; margin-bottom: 5px;">
                                    @if(Auth::guard('eksmp')->user())
                                        <li class="top_links"><a href="#"><i class="ion-android-person"></i>
                                        @if(Auth::guard('eksmp')->user()->id_role == 3)
                                            {{getCompanyNameImportir(Auth::guard('eksmp')->user()->id)}}
                                        @elseif(Auth::guard('eksmp')->user()->id_role == 2)
                                            {{getCompanyName(Auth::guard('eksmp')->user()->id)}}
                                        @endif
                                            <i class="ion-ios-arrow-down"></i></a>
                                        <ul class="dropdown_links" style="width: 170px">
                                            @if(Auth::guard('eksmp')->user()->id_role == 3)
                                            <li><a href="{{route('profile')}}" style="text-decoration: none">@lang('frontend.lbl5')</a></li>
											@endif
                                            @if(Auth::guard('eksmp')->user()->id_role == 2)
                                                <li><a href="{{route('login')}}" style="text-decoration: none">@lang('frontend.lbl14')</a></li>
                                            @endif
											<li><a href="{{url('front_end/history')}}" style="text-decoration: none">@lang('frontend.lbl7')</a></li>
											<li><a href="{{url('trx_list')}}" style="text-decoration: none">@lang('frontend.lbl11')</a></li>
                                            <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">@lang('frontend.lbl4')</a></li>
                                        </ul>
                                    </li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                    </form>
                                    @else
                                    <li class="top_links"><a href="{{url('login')}}"><i class="fa fa-sign-in"></i> @lang("frontend.lbl3")</a></li>
                                    @endif
                                    <li class="language" style="position: relative; display: inline-block;">
                                        <div class="lang-select" style="height: 100%;">
                                            <button class="btn-select-lang" style="border-radius: 5px; background-color: #fff; border: 1px solid #ccc; height: 60%; width: 160px;">
                                                <!-- <img src="{{asset('front/assets/img/Google.png')}}" style="height: 18px; margin:3px;" align="left"> -->
                                                <span class="title-lang">
                                                    @if($loc == 'en') Select Language @elseif($loc == 'in') Pilih Bahasa @else 选择语言 @endif
                                                <i class="fa fa-angle-down" aria-hidden="true" style="padding-left: 8px;"></i></span>
                                            </button>
                                            <ul class="list-lang">
                                                <a class="visit-lang" href="{{ url('locale/en') }}">
                                                    <li class="lang-option">
                                                        <img src="{{asset('negara/en.png')}}">
                                                        <span class="title-lang">English</span>
                                                    </li>
                                                </a>
                                                <a class="visit-lang" href="{{ url('locale/in') }}">
                                                    <li class="lang-option">
                                                        <img src="{{asset('negara/in.png')}}">
                                                        <span class="title-lang">Indonesia</span>
                                                    </li>
                                                </a>
                                                <a class="visit-lang" href="{{ url('locale/ch') }}">
                                                    <li class="lang-option">
                                                        <img src="{{asset('negara/ch.png')}}">
                                                        <span class="title-lang">China</span>
                                                    </li>
                                                </a>
                                            </ul >
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>