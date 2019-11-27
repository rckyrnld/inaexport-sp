@include('frontend.layouts.header')
<!-- Kontent 1-->
<div style="background-color: #2492eb">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-10 col-12" style="padding-top: 30px; padding-bottom: 10px; height: 100%;">
            	<h1 align="center" style="color: #ddeffd;">@lang("frontend.about")</h1>
            	<h2 align="center" style="color: #ddeffd;">@lang("footer.foot.directorate")</h2>
            	<table width="100%" height="100%" border="0" cellpadding="5px" style="text-align: center;">
            		<tr>
            			<td rowspan="2" width="50%" height="100%" style="margin:0; padding:0;">
            				<img src="{{asset('front/assets/img/about/about.png')}}" alt="" style="margin:0; padding:0;display:block;" height="100%"/>
            			</td>
            			<td width="25%">
            				<img src="{{asset('front/assets/img/about/about 3.png')}}" alt="" style="width: 100%;">
            			</td>
            			<td width="25%">
            				<img src="{{asset('front/assets/img/about/about 4.png')}}" alt="" style="width: 100%;">
            			</td>
            		</tr>
            		<tr>
            			</td>
            			<td width="25%">
            				<img src="{{asset('front/assets/img/about/about 5.png')}}" alt="" style="width: 100%;">
            			</td>
            			<td width="25%">
            				<img src="{{asset('front/assets/img/about/about 6.png')}}" alt="" style="width: 100%;">
            			</td>
            		</tr>
            	</table>
            </div>
        </div>
    </div>
</div>
<!-- Kontent 2 -->
<div style="background-color: #f2f2f2">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-10 col-12" style="padding-top: 20px; padding-bottom: 20px; height: 100%;">
            	<table width="100%" border="0" cellpadding="5px" style="text-align: center;">
            		<tr>
            			<td width="50%" valign="middle" align="left">
            				<span style="color: #2492eb; font-size: 23px;">DGNED's Membership Services is Indonesia's window to the world for export development and has developed excellently in identifying new markets and opportunities overseas for producers which are capable of meeting the requirements of the markets. As a non-profit government agency, DGNED provides all of its services free of charge.</span>
            			</td>
            			<td width="50%">
            				<img src="{{asset('front/assets/img/about/about 2.png')}}" alt="" style="width: 100%;">
            			</td>
            		</tr>
            	</table>
            </div>
        </div>
    </div>
</div>
<!-- Kontent 3 -->
<div style="background-color: #2492eb">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-10 col-12" style="padding-top: 20px; padding-bottom: 20px; height: 100%;">
				<span style="color: #f2f2f2; font-size: 23px; font-weight: 400;">
					DGNED itself is tasked with the following responsibilities :<br><br>

					<table border="0">
						<tr>
							<td valign="top">1. </td>
							<td style="padding-left: 5px;">To formulate policies and guidelines to encourage and to support the expansion of non-oil and gas products export.</td>
						</tr>
						<tr>
							<td valign="top">2. </td>
							<td style="padding-left: 5px;">To provide information services on overseas markets.</td>
						</tr>
						<tr>
							<td valign="top">3. </td>
							<td style="padding-left: 5px;">To organize export promotion activities.</td>
						</tr>
						<tr>
							<td valign="top">4. </td>
							<td style="padding-left: 5px;">To expand the range of export products and markets.</td>
						</tr>
					</table>
					<br>
					DGNED provides market research, advice on export procedures, licensing requirements,
					and financing. It also assists exporters to participate in its regular trade exhibitions both
					domestic and overseas.<br><br>
					Here Membership Services is provided to help those who want to export and who want to
					buy from Indonesia, with a single windows services.
				</span>
            </div>
        </div>
    </div>
</div>
<!-- End -->
@include('frontend.layouts.footer')