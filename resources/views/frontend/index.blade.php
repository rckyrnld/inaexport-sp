@include('frontend.layouts.header')
<!--slider area start-->
<style type="text/css">
    .categories_menu_toggle > ul > li ul.categories_mega_menu > li{
        width: 80%;
        padding: 0px 0px 0px 15px
    }

	.categories_menu_toggle > ul > li ul.categories_mega_menu > li > a {
    text-transform: none!important;
	}
    .row-menu{
        margin-top: 10%;
        margin-bottom: 10%;
    }

    .product_tab_button.nav div{
      margin: 2% 0 1% 0;
    }

    .product_tab_button.nav div a{
        font-size: 12px; 
        color: #34b1e5;
        font-family: 'Myriad-pro'; 
    }

    .product_tab_button.nav div a.active, .product_tab_button.nav div a:hover{
        text-decoration: none;
        font-weight: 500;
        font-size: 12px; 
        font-family: 'Myriad-pro'; 
        color: #fe8f00;
    }

    .for-act{
        text-decoration: none;
        opacity: 0.7;
    }

    .box-cu{
        width: 90%;
        background-color: white;
        /*border: 1px solid silver;*/
        border-radius: 20px;
        padding: 3%;
    }

    .button_form{
        width: auto;
    }

    .href-name {
        color: black;
    }

    .href-name:hover {
        text-decoration: none;
    }

    .href-company{
        text-transform: capitalize; 
        font-size: 11px; 
        font-family: 'Open Sans', sans-serif; 
        /*color: black;*/
    }

    .href-company:hover{
        text-decoration: none;
        color: black !important;
    }

    .href-category{
        text-transform: capitalize; 
        font-size: 11px !important; 
        font-family: 'Open Sans', sans-serif; 
    }

    .href-category:hover{
        text-decoration: none;
        /*color: #2777d0 !important;*/
    }
    .single_product:hover{
        box-shadow: 0 0 15px rgba(178,221,255,1); 
    }

    select:required:invalid {
        color: gray !important;
    }
    option[value=""][disabled] {
        display: none !important;
    }
    option {
        color: black !important;
    }
    .container-fluid{
        padding-left: 0px!important;
        padding-right: 0px!important;
    }

    @media only screen and (max-width: 767px) {
        .categories_menu_toggle > ul > li > a {
            /*line-height: 35px;*/
            /*padding: 0;*/
            color: #ffffff;
        }
    }

    @media only screen and (max-width: 1199px) and (min-width: 992px){
        .categories_menu_toggle > ul > li > a {
            color: #ffffff;
        }
    }


</style>
<style>
	#companyspecialevent_wrapper{
		width: 100%!important;
	}
    #companyspecialevent{
        width: 100%!important;
    }
</style>
<style>
.hoveraja {
  position: relative;
  width: 50%;
}

.image {
  opacity: 1;
  display: block;
  width: 100%;
  height: auto;
  transition: .5s ease;
  backface-visibility: hidden;
}

.middle {
  transition: .5s ease;
  opacity: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  text-align: center;
}

.hoveraja:hover .image {
  opacity: 0.3;
}

.hoveraja:hover .middle {
  opacity: 1;
}

.text {
  color: white;
  font-size: 12px;
  padding: 10px 22px;
}

.numberbg {
  background: url({{ URL::asset('image/export-containers.jpg') }}) no-repeat center center fixed;
  background-size: cover;
}

.txtbg {
    background: rgba(0, 0, 0, 0.3);
    color: #fff;
}

</style>
<?php 
    $loc = app()->getLocale(); 
    if($loc == "ch"){
        $lct = "chn";
        $by = "通过";
        $order = "最小订购量 : ";
    }else if($loc == "in"){
        $lct = "in";
        $by = "Oleh";
        $order = "Min Order : ";
    }else{
        $lct = "en";
        $by = "By";
        $order = "Min Order : ";
    }

    $imgarray = ['agriculture','apparel','automotive','jewelry','health_beauty','electrics','furniture','industrial_parts','gift_card','food'];
?>
<!-- main image start -->
<div class="container">
    <div class="row">
        <img src="{{asset('front/assets/img/main/products-diverse.png')}}" class="img-fluid">
    </div>
</div>
<!-- main image end -->

    <!--Event Special start-->
    @if(isset($checkevent))
    <section class="special_event_area mb-50" style=" margin-bottom: 0px;">
    <div class="breadcrumbs_area">
        <div class="container" style="padding-left:0px;padding-right:0px;">
        <!-- <div class="container-fluid"> -->
        <!-- <p> -->
            @if(count($checkevent)>0)
                @foreach($checkevent as $event)
                    <a href="{{url('front_end/list_product/categoryeks/'.$event->id)}}" >
                        <img style="width:100%; max-width: 100%;heigth:231px" src="{{asset('uploads/banner/')}}/{{$event->file}}" alt="">
                        <!-- <img class="img-fluid" style="width:100%; max-width: 100%;heigth:231px" src="{{asset('uploads/banner/')}}/{{$event->file}}" alt=""> -->
                    </a>
                @endforeach
            @endif
        <!-- </p> -->

                {{--<img style="max-width: 100%;min-width: 100%;heigth:231px" src="{{asset('uploads/banner/')}}/{{$checkevent->file}}" data-show-id="{{$checkevent->id}}" data-toggle="modal"  data-target="#modal-special-event" alt="">--}}

        </div>
    </div>
    </section>
    @endif
    
    <!--Event Special end-->
	
<br>

    <!-- mengapa inaexport start -->
    <section class="mb-50" style="padding-top: 30px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12" style="padding-bottom: 50px;">
                    <p style="font-size: 24px; font-weight: bold; text-align:center; border-top: 1px solid #e3e3e3; border-bottom: 1px solid #e3e3e3;" class="py-2">WHY DO BUSINESS WITH INDONESIA EXPORTERS?</p>
                </div>
                <div class="col-lg-6" style="padding-bottom: 15px;">
                    <div class="row">
                        <div class="col-12">
                            <p><b><span style="font-size: 16px;">Verified Supplier</span></b> <br>
                            The registered supplier has been verified based on legal documents valid in Indonesia </p>
                            <p><b><span style="font-size: 16px;">Sustainable Trade</span></b> <br>
                            Indonesia continues to encourage the implementation of the sustainable aspects proclaimed by the UN to be applied to all suppliers</p>
                            <p><b><span style="font-size: 16px;">Diverse Products</span></b> <br>
                            Indonesia's rich geographical and cultural conditions create a wide variety of products ranging from agriculture to high-tech products </p>
                            <p>
                            <a class="btn btn-primary" href="{{url('/about')}}">About Inaexport</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-12" style="align: right;"><img class="img-fluid float-right" src="{{ URL::asset('image/business-deal.jpg') }}" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- mengapa inaexport end -->

    <!-- Inaexport Fact -->
    <section style="padding-top:0px; padding-bottom:30px; background-color: #fff;">
      <div class="container">
        <div class="row numberbg" style="margin:0px auto; padding: 0px auto;">
          <div class="col-12 txtbg" style="padding-bottom: 50px;">
            <div class="col-12" style="padding-top: 50px; padding-bottom: 50px;">
              <p style="text-align:center; font-size: 24px;"><b>INAEXPORT IN NUMBERS</b></p>    
            </div>
            <div class="col-lg-12 row">
            <div class="col" style="text-align: center; padding-bottom: 15px;">
                <!--<img src="{{asset('front/assets/img/exporters.png')}}" alt="" style="width: 33px;margin-left: 10%; float:left">-->
                <span class="counters_number">
                <?php echo number_format(getCountData('itdp_company_users'),'0'); ?>
                <!--{{getCountData('itdp_company_users')}}-->
                </span><br>
                <span class="counters_text">
                    @if($loc == 'ch')
                    出口商
                    @elseif($loc == 'in')
                    Eksportir
                    @else
                    Indonesian Exporters
                    @endif
                </span>
            </div>
            <div class="col" style="text-align: center; padding-bottom: 15px;">
                <!--<img src="{{asset('front/assets/img/products.png')}}" alt="" style="width:35px; margin-left: 10%; float: left;">-->
                <span class="counters_number">
                <?php echo number_format(getCountData('csc_product_single'),'0'); ?>
                <!--{{getCountData('csc_product_single')}}-->
                </span><br>
                <span class="counters_text">
                    @lang('frontend.home.product')
                </span>
            </div>
            <div class="col" style="text-align: center; padding-bottom: 15px;">
                <!--<img src="{{asset('front/assets/img/representative.png')}}" alt="" style="width: 30px;margin-left: 10%; float:left">-->
                    <span class="counters_number">
                    <?php echo number_format(getCountData('itdp_admin_users'),'0'); ?>
                    <!--{{getCountData('itdp_admin_users')}}-->
                    </span><br>
                    <!-- <span class="counters_text" style="margin-right: 23%; font-size: 18px; float: right;"> -->
                    <span class="counters_text">
                    @if($loc == 'ch')
                    海外贸易代表
                    @elseif($loc == 'in')
                    Perwakilan Dagang
                    @else
                    Trade Representative 
                    @endif
                    </span>
            </div>
            <div class="col" style="text-align: center; padding-bottom: 15px;">
              <!--<img src="{{asset('front/assets/img/events.png')}}" alt="" style="width: 35px;;margin-left: 10%; float:left">-->
                <span class="counters_number">
                <?php echo number_format(getCountData('event_detail'),'0'); ?>
                <!--{{getCountData('event_detail')}}-->
                </span><br>
                <span class="counters_text">
                @if($loc == 'ch')
                国际活动
                @elseif($loc == 'in')
                Pameran Internasional
                @else
                International Events
                @endif
                </span>
            </div>
            <div class="col" style="text-align: center; padding-bottom: 15px;">
                <!--<img src="{{asset('front/assets/img/researchcorner.png')}}" alt="" style="width: 35px;margin-left: 10%; float:left">-->
                <span class="counters_number">
                <?php echo number_format(getCountData('csc_research_corner'),'0'); ?>
                <!--{{getCountData('csc_research_corner')}}-->
                </span><br>
                <!-- <span class="counters_text" style="margin-right: 23%; font-size: 18px; float: right;"> -->
                <span class="counters_text">
                @if($loc == 'ch')
                市场调查
                @elseif($loc == 'in')
                Riset Pasar
                @else
                Market Research
                @endif
                </span>
            </div>
          </div>
          </div>
        </div>
    </div>
    </section>

    <!-- our products start --> 
    <section class="mb-50" style="padding-top: 20px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12" style="padding-bottom: 30px;">
                    <p style="font-size: 24px; font-weight: bold; text-align:center; border-top: 1px solid #e3e3e3; border-bottom: 1px solid #e3e3e3;" class="py-2">OUR PRODUCTS</p>
                </div>
                <div class="col-lg-12" style="padding-bottom: 50px;">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-8 justify-content-md-center">
                        <form method="GET" action="{{url('/products')}}" id="formsprod">
                            <div class="input-group flex-nowrap">
                                <?php
                                    if(isset($search)){
                                        $cariprod = $search;
                                    }else{
                                        $cariprod = "";
                                    }

                                    if(isset($get_id_cat)){
                                        $caricat = $get_id_cat;
                                    }else{
                                        $caricat = "";
                                    }

                                    if(isset($getEks)){
                                        $eksprod = $getEks;
                                    }else{
                                        $eksprod = "";
                                    }

                                    if(isset($hl_sort)){
                                        $hlprod = $hl_sort;
                                    }else{
                                        $hlprod = "";
                                    }
                                ?>
                                <input type="text" class="form-control" placeholder="Search product" style="border-radius: 0px;" name="cari_product" value="{{$cariprod}}" id="cari_product">
                                <input type="hidden" name="locnya" value="{{$lct}}" id="locnya">
                                <input type="hidden" name="cari_catnya" value="{{$caricat}}" id="cari_catnya">
                                <input type="hidden" name="eks_prod" value="{{$eksprod}}" id="eks_prod">
                                <input type="hidden" name="hl_prod" value="{{$hlprod}}" id="hl_prod">
                                <input type="hidden" name="sort_prod" value="default" id="sort_prod">
                                <button class="btn btn-primary" type="submit" id="button-addon2">Search</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" style="padding-bottom: 20px;">
                    <div class="card">
                        <img class="card-img-top" src="{{ URL::asset('image/products/prod-agriculture.jpeg') }}" alt="Agriculture">
                        <div class="card-body">
                            <h5 class="card-title"><b>AGRICULTURE</b></h5>
                            <p class="card-text" style="text-align: justify; height: 270px;">
                            Indonesia possesses vast and abundant arable fertile soils. As one of the world's major agricultural nation, the country offers wide diversity of sustainable tropical products and important agricultural commodities; which include palm oil, natural rubber, cocoa, coffee, tea, cassava, rice and tropical spices. As the largest archipelagic country in the world, Indonesia produces superior sustainable agricultural products since the last few decades.
                            </p>
                            <a href="{{url('/products/category/11')}}" class="btn btn-primary">See Products</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" style="padding-bottom: 20px;">
                    <div class="card">
                        <img class="card-img-top" src="{{ URL::asset('image/products/prod-apparel.jpeg') }}" alt="Apparel">
                        <div class="card-body">
                            <h5 class="card-title"><b>TEXTILE & APPAREL</b></h5>
                            <p class="card-text" style="text-align: justify; height: 270px;">
                            With textile production capacity of 3.31 million tons per year, Indonesia have exported textile and apparel products to more than 200 countries in the world. Besides the convential clothing, Indonesia is fame for the traditional fabrics such as Batik, which rewarded by UNESCO as Masterpiece of The Oral and Intangible Heritage of Humanity, alongwith other traditional fabric such as tenun ikat (ikat weaving), and songket that have long been on the world export market. 
                            </p>
                            <a href="{{url('/products/category/12')}}" class="btn btn-primary">See Products</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" style="padding-bottom: 20px;">
                    <div class="card">
                        <img class="card-img-top" src="{{ URL::asset('image/products/prod-otomotif.jpeg') }}" alt="Automobiles & Motorcycles">
                        <div class="card-body">
                            <h5 class="card-title"><b>AUTOMOBILES & PARTS</b></h5>
                            <p class="card-text" style="text-align: justify; height: 270px;">
                            The automotive industry is one of the major contributors to Indonesia's export activities, providing not only automotive components, now also exporting whole automotive or CBU (completely build-up). The types of CBU vehicles that are exported abroad are varied, including sport (sport utility vehicle/SUV), multipurpose (MPV) to pick-up cars and has been exported to more than 80 countries.
                            </p>
                            <a href="{{url('/products/category/13')}}" class="btn btn-primary">See Products</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" style="padding-bottom: 20px;">
                    <div class="card">
                        <img class="card-img-top" src="{{ URL::asset('image/products/prod-beauty.jpeg') }}" alt="Beauty & Personal Care">
                        <div class="card-body">
                            <h5 class="card-title"><b>BEAUTY & PERSONAL CARE</b></h5>
                            <p class="card-text" style="text-align: justify; height: 270px;">
                            Indonesia boast of 30,000 species medicinal plants out of the 40,000 species in the world, which makes a huge advantage to produce safe, natural, and sustainable beauty products. Indonesian beauty and cosmetic product manufacturing companies have carried out various innovations of beauty and cosmetic products both modern and traditional, herbal-based cosmetics.  
                            </p>
                            <a href="{{url('/products/category/14')}}" class="btn btn-primary">See Products</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" style="padding-bottom: 20px;">
                    <div class="card">
                        <img class="card-img-top" src="{{ URL::asset('image/products/prod-chemical.jpeg') }}" alt="Chemicals">
                        <div class="card-body">
                            <h5 class="card-title"><b>CHEMICALS</b></h5>
                            <p class="card-text" style="text-align: justify; height: 270px;">
                            Indonesia’s chemical industry has shifted to the more environment friendly chemical industry and oriented towards nature’s ecosystem sustainability. One of the environment friendly chemical products that has been produced by Indonesia is lubricants made from palm oil (CPO). All Indonesian Chemical products are complying the international standards and are ready to enter worldwide export market.
                            </p>
                            <a href="{{url('/products/category/15')}}" class="btn btn-primary">See Products</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" style="padding-bottom: 20px;">
                    <div class="card">
                        <img class="card-img-top" src="{{ URL::asset('image/products/prod-craft.jpeg') }}" alt="Gift & Crafts">
                        <div class="card-body">
                            <h5 class="card-title"><b>GIFT & CRAFTS</b></h5>
                            <p class="card-text" style="text-align: justify; height: 270px;">
                            Indonesia is fame for its rich tradition and culture. The diversity evident in Indonesia's 300 plus ethnic groups is reflected in the diversity of its art forms. Just as every ethnic group throughout the archipelago has its own language/dialect, cuisine, traditional dress and traditional homes and they have also developed their own textiles, ornaments, carvings and items for daily use and special celebrations.  
                            </p>
                            <a href="{{url('/products/category/115')}}" class="btn btn-primary">See Products</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- our products end -->

    <!--rfq start-->
    <section class="breadcrumbs_area" style="padding-top: 4%;padding-bottom: 4%; margin-bottom: 0px;" data-bgimg="{{asset('front/assets/icon/homepage2.png')}}">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6">
                            <br>
                            <div style="padding-left:10px;padding-right:10px;">
                                <p style="font-size:20px;"><b>@lang("login.lbl5")</b></p>
                                <p style="font-size:16px;">@lang("login.lbl6") <br> @lang("login.lbl7")
                                <br> @lang("login.lbl8")</p>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-5" style="padding-top: 20px;">
                            <div class="box-cu">
							<form class="form-horizontal" method="POST" action="{{ url('br_importir_next') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                                    <center><h5><b>@lang("login.forms.by1")</b></h5></center>
                                    <br>
                                   <div class="form-group row">
                                        <div class="col-md-12">
                                            <input type="text" style="color:black;font-size: 13px;" value="" name="subyek" id="subyek" class="form-control" placeholder="@lang('login.forms.by2')?" required>
                                        </div>
                                   </div>

                                   <div class="form-group row">
                                        <div class="col-md-12">
                                            <select style="font-size: 13px;" class="form-control" name="valid" id="valid" required>
                                                <option value="" disabled selected>@lang("login.forms.by10")</option>
                                                <option value="0">None</option>
                                                <option value="1">Valid within 1 day</option>
                                                <option value="3">Valid within 3 day</option>
                                                <option value="5">Valid within 5 day</option>
                                                <option value="7">Valid within 7 day</option>
                                                <option value="14">Valid within 2 week</option>
                                                <option value="30">Valid within 1 month</option>
                                            </select>
                                        </div>
                                   </div>

                                   <div class="form-group row">
                                        <div class="col-md-12">
                                            <textarea style="color:black; font-size: 13px;" value="" name="spec" id="spec" class="form-control" placeholder="@lang('login.forms.by4')"></textarea>
                                        </div>
                                   </div>

                                   <div class="form-group row">
                                       <div class="col-md-7">
                                           <input style="color:black; font-size: 13px;" type="number" min="1" name="eo" id="eo" class="form-control" placeholder="@lang('login.forms.by5')">
                                       </div>
                                       <div class="col-md-5">
                                           <select class="form-control" name="neo" id="neo" style="font-size: 12px;">
                                                <option value="" disabled selected>@lang("login.forms.by14")</option>
                                                <option value="Each">Each</option>
                                                <option value="Foot">Foot</option>
                                                <option value="Gallons">Gallons</option>
                                                <option value="Kilograms">Kilograms</option>
                                                <option value="Liters">Liters</option>
                                                <option value="Packs">Packs</option>
                                                <option value="Pairs">Pairs</option>
                                                <option value="Pieces">Pieces</option>
                                                <option value="Reams">Reams</option>
                                                <option value="Rods">Rods</option>
                                                <option value="Rolls">Rolls</option>
                                                <option value="Sets">Sets</option>
                                                <option value="Sheets">Sheets</option>
                                                <option value="Square Meters">Square Meters</option>
                                                <option value="Tons">Tons</option>
                                                <option value="Unit">Unit</option>
                                                <option value="令">令</option>
                                                <option value="件">件</option>
                                                <option value="加仑">加仑</option>
                                                <option value="包">包</option>
                                                <option value="千克">千克</option>
                                                <option value="升">升</option>
                                                <option value="单位">单位</option>
                                                <option value="卷">卷</option>
                                                <option value="吨">吨</option>
                                                <option value="套">套</option>
                                                <option value="对">对</option>
                                                <option value="平方米">平方米</option>
                                                <option value="张">张</option>
                                                <option value="根">根</option>
                                                <option value="每个">每个</option>
                                                <option value="英尺">英尺</option>
                                                <option value="集装箱">集装箱</option>
                                            </select>
                                       </div>
                                   </div>

                                   <div class="form-group row">
                                       <div class="col-md-7">
                                            <input style="color:black; font-size: 13px;" type="text" value="" name="tp" id="tp" class="form-control amount" placeholder="@lang('login.forms.by6')">
                                        </div>
                                        <div class="col-md-5">
                                            <select  class="form-control" name="ntp" id="ntp" style="font-size: 12px;">
                                                <option value="" disabled selected>@lang("login.forms.by14")</option>
                                                <option value="SAR">Arab Saudi Riyal(SAR)</option>
                                                <option value="BND">Brunei Dollar(BND)</option>
                                                <option value="CNY">China Yuan(CNY)</option>
                                                <option value="IQD">Dinar Irak(IQD)</option>
                                                <option value="AED">Dirham Uni Emirat Arab(AED)</option>
                                                <option value="USD">Dollar Amerika Serikat(USD)</option>
                                                <option value="AUD">Dollar Australia(AUD)</option>
                                                <option value="HKD">Dollar Hong Kong(HKD)</option>
                                                <option value="SGD">Dollar Singapura(SGD)</option>
                                                <option value="TWD">Dollar Taiwan Baru(TWD)</option>
                                                <option value="EUR">Euro(EUR)</option>
                                                <option value="PHP">Peso Filipina(PHP)</option>
                                                <option value="GBP">Pound Sterling(GBP)</option>
                                                <option value="MYR">Ringgit Malaysia(MYR)</option>
                                                <option value="INR">Rupee India(INR)</option>
                                                <option value="IDR">Rupiah Indonesia(IDR)</option>
                                                <option value="THB">Thai Baht(THB)</option>
                                                <option value="VND">Vietnam Dong(VND)</option>
                                                <option value="KRW">Won Korea(KRW)</option>
                                                <option value="JPY">Yen Jepang(JPY)</option>

                                            </select>
                                        </div>
                                   </div>
                              
                                   <div class="form-group row">
                                      <div class="col-md-12">
                                        <div align="left">
                                            <button type="submit" style="width: 100%;" class="btn btn-danger button_form">
                                                    @if($loc == 'ch')
                                                    立即发布购买请求
                                                    @elseif($loc == 'in')
                                                    Kirim Permintaan Pembelian
                                                    @else
                                                    Request For Quotation
                                                    @endif 
                                            </button>
                                        </div>
                                      </div>
                                   </div>
							</form>
                            </div>
                                <!-- <div class="row">
                                    <div class="col-md-5" style="padding:15px" >
                                        <img src = "{{asset('front/assets/icon/Logo_Exim.png')}}" > 
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-5" style="padding:15px">
                                        <img src = "{{asset('front/assets/icon/Logo_Inatrims.png')}}" > 
                                    </div>
                                   
                                </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--rfq end-->

    <!-- official partner start -->
    <section class="mb-50" style="background-color: #ddeffd; padding-top: 30px; padding-bottom: 30px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12" style="padding-bottom: 30px;">
                    <p style="font-size: 24px; font-weight:bold; text-align: center">OUR PARTNERS</p>
                </div>
                <div class="col-lg-4">
                    <a href="https://exim.kemendag.go.id/"><img src="{{ URL::asset('front/assets/icon/Logo_Exim.png') }}" class="img-fluid mx-auto d-block" style="height: 80px;"></a>
                </div>
                <div class="col-lg-4">
                    <?php
                        if(Auth::guard('eksmp')->user()) {
                            if(Auth::guard('eksmp')->user()->id_role == 2) {
                                ?>
                                <a href="http://inatrims.kemendag.go.id/index.php/main/negara_djpen"><img src="{{ URL::asset('front/assets/icon/Logo_Inatrims.png') }}" class="img-fluid mx-auto d-block" style="height: 80px;"></a>
                                <?php
                            }
                            else {
                                ?>
                                <a href="http://inatrims.kemendag.go.id/"><img src="{{ URL::asset('front/assets/icon/Logo_Inatrims.png') }}" class="img-fluid mx-auto d-block" style="height: 80px;"></a>
                                <?php
                            }
                        }
                        else {
                            ?>
                            <a href="http://inatrims.kemendag.go.id/"><img src="{{ URL::asset('front/assets/icon/Logo_Inatrims.png') }}" class="img-fluid mx-auto d-block" style="height: 80px;"></a>
                            <?php
                        }
                    ?>
                </div>
                <div class="col-lg-4">
                    <a href="http://tr.apec.org/"><img src="{{ URL::asset('front/assets/icon/Logo_Apec.png') }}" class="img-fluid mx-auto d-block" style="height: 80px;"></a>
                </div>
            </div>
        </div>
    </section>
    <!-- official partner end -->

    <!-- news start -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12" style="padding-bottom: 30px;">
                    <p style="font-size: 24px; font-weight: bold; text-align:center; border-top: 1px solid #e3e3e3; border-bottom: 1px solid #e3e3e3;" class="py-2"><a href="{{url('/news')}}">NEWS</a></p>
                </div>
                @foreach($news as $key => $ns)
                <div class="col-lg-4 col-md-4 card">
                    <div class="card-body">
                        <h5 class="card-title"><b><?php echo $ns->title; ?></b></h5>
                        <div class="card-text">
                        <?php echo $ns->short; ?>
                        </div>
                        <a href="{{ url('getnews/'.$ns->id.'/'.$ns->slug) }}" style="color:#ff0000;">Read More <i class="fas fa-chevron-circle-right"></i></a>
                    </div>
                </div>
                @endforeach
                
            </div>
        </div>
    </section>
    <!-- news end -->

</div>
<!-- Plugins JS -->
<script src="{{asset('front/assets/js/plugins.js')}}"></script>
<link rel="stylesheet" href="{{url('assets')}}/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" type="text/css" />
<script src="{{url('assets')}}/libs/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="{{url('assets')}}/libs/datatables.net-bs4/js/dataTables.bootstrap4.js" ></script>
    

@include('frontend.layouts.footer')
<script type="text/javascript">
    $(function() {

        $('.amount').keyup( function() {
            $(this).val( formatAmount( $( this ).val() ) );
        });

        

    });


    $(function() {
        
        $("#companyspecialevent").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": '{!! route('bannercompanyfront.getdata') !!}',
                "dataType": "json",
                "type": "GET",
                "data": {_token: '{{csrf_token()}}',id : $('#idbannernya').val(),}
            },
            "columns": [
                    // {data: 'no'},
                    {data: 'no'},
                    {data: 'company'},
                    
            ],
            language: {
                processing: "Sedang memproses...",
                lengthMenu: "Tampilkan _MENU_ entri",
                zeroRecords: "Tidak ditemukan data yang sesuai",
                emptyTable: "Tidak ada data yang tersedia pada tabel ini",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                infoFiltered: "(disaring dari _MAX_ entri keseluruhan)",
                infoPostFix: "",
                search: "Cari:",
                url: "",
                infoThousands: ".",
                loadingRecords: "Sedang memproses...",
                paginate: {
                    first: "<<",
                    last: ">>",
                    next: "Selanjutnya",
                    previous: "Sebelum"
                },
                aria: {
                    sortAscending: ": Aktifkan untuk mengurutkan kolom naik",
                    sortDescending: ": Aktifkan untuk mengurutkan kolom menurun"
                }
            }
        });
    });

    // $(function() {
    //     $('#modal-special-event').on('show.bs.modal', function(e) {
    //         idbanner = $(e.relatedTarget).data('show-id');
    //         $('#idbannernya').val(idbanner);
    //     });
    // });

    $(document).ready(function () {
        if(window.innerWidth <= 900){
            $( ".menu_item_children.next" ).on('click', function() {
                var href = $("a", this).attr('href');
                // window.location.href = href;
                // ada masalah dalam javascript template
            });
        } 
    });

    // function modalspecialevent(a){
    //     var token = $('meta[name="csrf-token"]').attr('content');
	// 	$.get('{{URL::to("ambilbroad3/")}}/'+a,{_token:token},function(data){
    //         $("#isibroadcast").html(data);
    //         calldata();
    //     })
    // }

    // function calldata(){
    //     var id = $('#id_laporan').val();
    //     $.ajax({
    //         method: "POST",
    //         url: "{!! url('getdatapiliheksportir') !!}",
    //         data:{_token: '{{csrf_token()}}',id_laporan:id}
    //     })
    //     .done(function(data){
    //         $.each(data, function(i, val){
    //             $('#companyspecialevent').DataTable().row.add([val.company,'<div class="checkbox"><input class="eksportir" name="eksportir" type="checkbox" value="'+val.id+'"></div>']).draw();
                
    //             // $('#tabelpiliheksportir').DataTable().row.add([val.company]).draw();
    //         });
    //     });
        

    // }

    function openTab(tabname) {
        $('.tab-pane.product').removeClass('active');
        $('.tabnya').removeClass('active');
        $('#'+tabname).addClass('active');
    }

    function formatAmountNoDecimals( number ) {
        var rgx = /(\d+)(\d{3})/;
        while( rgx.test( number ) ) {
            number = number.replace( rgx, '$1' + '.' + '$2' );
        }
        return number;
    }

    function GoToProduct(id, e, obj){
        e.preventDefault();
        var token = "{{ csrf_token() }}";
        $.ajax({
            url: "{{route('product.hot')}}",
            type: 'post',
            data: {'_token':token,id:id},
            dataType: 'json',
            success:function(response){
                if(response == 'ok'){
                    location.href = obj.href;
                }
            }
        });
    }

    <?php
    $tipe = '';
    $message = '';
    $login = 'non user';
    ?>
    function checkfirst(){
        <?php
        if(Auth::guard('eksmp')->user()){
            if(Auth::guard('eksmp')->user()->id_role == 2){
              $tipe = 'eksportir';
              $login = 'eksportir';
              $message = '';
            } else { 
                $login = 'importir';
              $for = 'importir';
                if($loc == "ch"){
                  $message = "仅适用于印尼公司";
                }elseif($loc == "in"){
                  $message = "Hanya untuk perusahaan Indonesia";
                }else{
                  $message = "Only for Indonesian companies";
                }
            }
        }else{
            $login = 'non user';
            $for = 'non user';
                if($loc == "ch"){
                  $message = "请先登录";
                }elseif($loc == "in"){
                  $message = "Silahkan Login Terlebih Dahulu!";
                }else{
                  $message = "\Please Login to Continue!";
                }
        }
        ?>

        var tipe = '{{$tipe}}';
        var message = '{{$message}}';
        var login = '{{$login}}';
        console.log(tipe);
        console.log(message);
        console.log(login);
        if(login != 'eksportir' && tipe != 'eksportir' ){
            alert("{{$message}}");
            if(login == 'non user'){
                window.location.href = "{{url('/login')}}";
            }
        }else{
            $('#buttoncurris')[0].click();
        }
        
        // if()
    }

    function formatAmount( number ) {

        // remove all the characters except the numeric values
        number = number.replace( /[^0-9]/g, '' );

        // set the default value
        if( number.length == 0 ) number = "0.00";
        else if( number.length == 1 ) number = "0.0" + number;
        else if( number.length == 2 ) number = "0." + number;
        else number = number.substring( 0, number.length - 2 ) + '.' + number.substring( number.length - 2, number.length );
        
        // set the precision
        number = new Number( number );
        number = number.toFixed( 2 );    // only works with the "."

        // change the splitter to ","
        number = number.replace( /\./g, '' );

        // format the amount
        x = number.split( ',' );
        x1 = x[0];
        x2 = x.length > 1 ? ',' + x[1] : '';

        return formatAmountNoDecimals( x1 ) + x2;
    }
</script>