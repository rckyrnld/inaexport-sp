@include('frontend.layouts.header')
<!-- Kontent 1-->
<style>
	ul.a {
		list-style-type: disc;
		/* list-style-position: inside; */
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
<!-- <div class="container" style="padding-bottom: 30px;">
    <div class="row">
        <div class="col-lg-12 col-12" style="padding-top: 30px; padding-bottom: 10px; height: 100%;">
			<p><span style="font-size: 18px;"><b>@lang("frontend.about")</b></span></p>
			<p style="text-align : justify">@lang("frontend.about-det.1")</p>
			<p style="text-align : justify">@lang("frontend.about-det.2")</p>
			 <ul class="a" >
				<li>
					<p style="text-align : justify">
						@lang("frontend.about-det.4")
					</p>
				</li> 
				<li >
					<p style="text-align : justify">
					@lang("frontend.about-det.4")
					</p>
				</li>
				<li>
					<p style="text-align : justify">
				@lang("frontend.about-det.5")
					</p>
				</li>
			</ul> 
		</div>
	</div>-->
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
	?>
	<div class="container pb-4" style="border-bottom: 1px solid #e3e3e3;">
		<div class="col-lg-12" style="border-bottom: 1px solid #e3e3e3;">
			<div class="row breadcrumb_content">
				<ul>
					<li><a href="{{url('/')}}">Home</a></li>
					<li>About Inaexport</li>
				</ul>
			</div>
		</div>
		<div class="row pt-4">
			<div class="col-lg-12 col-12 mt-4">
				<div class="container">
					<p class="pb-3"><span style="color: #007bff; font-size: 20px;"><b>WHY DO BUSINESS WITH INDONESIAN EXPORTERS?</b></span></p>
					<div class="row numberbg" style="margin:0px auto; padding: 0px auto;">
						<div class="col-lg-12 txtbg" style="padding-bottom: 50px;">
							<div class="col-12" style="padding-top: 50px; padding-bottom: 50px;">
							<p style="text-align:center; font-size: 24px;"><b>INAEXPORT IN NUMBERS</b></p>    
						</div>
						<!-- inaexport numbers start -->
						<div class="col-lg-12 row">
							<div class="col" style="text-align: center; padding-bottom: 15px;">
								<span class="counters_number">
								<?php echo number_format(getCountData('itdp_company_users'),'0'); ?>
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
								<span class="counters_number">
								<?php echo number_format(getCountData('csc_product_single'),'0'); ?>
								</span><br>
								<span class="counters_text">
									@lang('frontend.home.product')
								</span>
							</div>
							<div class="col" style="text-align: center; padding-bottom: 15px;">
								<span class="counters_number">
								<?php echo number_format(getCountData('itdp_admin_users'),'0'); ?>
								</span><br>
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
								<span class="counters_number">
								<?php echo number_format(getCountData('event_detail'),'0'); ?>
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
								<span class="counters_number">
								<?php echo number_format(getCountData('csc_research_corner'),'0'); ?>
								</span><br>
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
				<!-- inaexport numbers end -->
				<div class="container pt-3">
					<div class="row">
							<span style="font-weight: bold; font-size: 16px;">Verified Suppliers</span>
							<div class="col-lg-12">
								<ul style="font-weight: lighter; list-style-type: square;">
									<li>Inaexport ensure each company registered in Inaexport.id has been verified and legally registered in the official Indonesian government institution.</li>
									<li>Only Certified companies and those who complies with export compliances are eligible to be listed in Inaexport.</li>
								</ul>
							</div>
							
							<span style="font-weight: bold; font-size: 16px; padding-top: 10px;">Sustainable Trade</span>
							<div class="col-lg-12">
								<ul style="font-weight: lighter; list-style-type: square;">
									<li>Inaexport members are encouraged to actively participate in sustainable trade practices and producing sustainable products.</li>
									<li>The Indonesian government continues to encourage the implementation of the sustainability aspects proclaimed by the UN to be applied to suppliers of Inaexport members, encouraging Inaexport members to obtain various certificates both national and international which comply with sustainable trade.</li>
								</ul>
							</div>
							<span style="font-weight: bold; font-size: 16px; padding-top: 10px;">Diverse Products</span>
							<div class="col-lg-12">
								<ul style="font-weight: lighter; list-style-type: square;">
									<li>With its vast and abundant fertile soile and forest and marine resources, Indonesia is a major key producer of a wide variety of agri and aquaculture, mining, and forestry products. The agricultural sector is an important source of income and employment. Indonesia has a population of approximately 265 million, of which 120 million live in rural areas, and 50 million of them are economically active in agriculture.</li>
									<li>Currently, Indonesia offers a wide variety of products to the world, ranging from products based on natural resources such as agricultural products, mining products, either in the form of raw materials or in processed form. </li>
									<li>In addition, Indonesia also produces industrial products such as processed food products, textile products, electronic products, automotive products and other manufacturing products.</li>
									<li>What is equally important is that Indonesia is also known as a producer of handy craft products and one of the best furniture producer in the world, which is proven that these products can be accepted in various markets around the world.</li>
									<li>With progressive technology, Indonesians are also able to produce high-tech products that are in demand of many countries, such as airplanes, weaponry products, trains and others.</li>
								</ul>
							</div>
						<a href="{{url('/suppliers')}}" class="btn btn-primary my-3">Find Inaexport Suppliers</a>
					</div>
				</div>
				<hr>
				<div class="container pt-3">
					<p><span style="color: #007bff; font-size: 20px;"><b>ABOUT INAEXPORT</b></span></p>
					<p>Inaexport is the official B2B directories platform of the Directorate General of National Export Development, Ministry of Trade of the Republic of Indonesia, which was developed at the end of 2019.</p>
					<p>This platform goals are as follows:
						<ul style="list-style-type: square; padding-left: 20px;">
							<li>to connect Indonesian exporters with worldwide buyers.</li>
							<li>to promote Indonesian companies and their products online to reach greater audience.</li>
							<li>to provide updated Indonesian trade news for both exporters and buyers.</li>
						</ul>
					</p>
					<p>Through this platform, buyers will get the best and various product choices as well as a diverse selection of certified suppliers.</p>
					<p><span style="color: #007bff;"><b>Are you a buyer who is interested in buying products from Indonesia?</b></span>
						<ul style="list-style-type: square; padding-left: 20px;">
							<li>Use Inaexport platform as the official source to get up to date information and to find a large selection of quality products and a comprehensive list of certified suppliers from Indonesia.</li>
							<li>After submitting an inquiry to the supplier, Inaexport supplier will respond directly to your inquiry. Furthermore, a chat function with the supplier is available on Inaexport platform for easier communication.</li>
							<li>To be able to submit an inquiry to Inaexport supplier, you are required to register first (your profile will NOT be visible to other suppliers except the one you have sent the inquiry to).</li>
						</ul>
					</p>
					<a href="{{url('/register_buyer')}}" class="btn btn-primary my-2">Register as Buyers</a>
					<p class="pt-3"><span style="color: #007bff;"><b>Are you an exporter company or a potential exporter from Indonesia?</b></span>
						<ul style="list-style-type: square; padding-left: 20px;">
							<li>For those of you Indonesian companies who have met the export requirements and compliances, you can register your company profile in Inaexport.id platform and be found by buyers worldwide.</li>
							<li>Through Inaexport platform, your company profile and products can be accessed online by buyers and trade representatives worldwide. Make sure to display detailed information about your company, such as product images, summary of company profile, and your product specifications.</li>
							<li>As registered member of Inaexport, you will have access to buyers’ inquiries and will be able to communicate directly with the buyers and representative of Ministry of Trade (Indonesian trade attaché, ITPC).</li>
							<li>As registered member of Inaexport, you will have access to the trade news and market reports from representatives of the Ministry of Trade, the Embassy of the Republic of Indonesia and from the Consul General of the Republic of Indonesia in respective countries. And be the first one to receive update about trade statistics, workshops, training, and trade show participation.</li>
						</ul>
					</p>
					<a href="{{url('/registrasi_penjual')}}" class="btn btn-primary my-2">Register as Indonesian Exporters</a>
				</div>
			</div>	
		</div>
	</div>
</div>
<!-- End -->
@include('frontend.layouts.footer')