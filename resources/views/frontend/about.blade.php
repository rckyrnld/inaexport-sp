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
            				<span style="color: #2492eb; font-size: 23px;">@lang("frontend.about-det.1")</span>
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
					@lang("frontend.about-det.2")<br><br>

					<table border="0">
						<tr>
							<td valign="top">1. </td>
							<td style="padding-left: 5px;">@lang("frontend.about-det.2-1")</td>
						</tr>
						<tr>
							<td valign="top">2. </td>
							<td style="padding-left: 5px;">@lang("frontend.about-det.2-2")</td>
						</tr>
						<tr>
							<td valign="top">3. </td>
							<td style="padding-left: 5px;">@lang("frontend.about-det.2-3")</td>
						</tr>
						<tr>
							<td valign="top">4. </td>
							<td style="padding-left: 5px;">@lang("frontend.about-det.2-4")</td>
						</tr>
					</table>
					<br>
					@lang("frontend.about-det.3")<br><br>
					@lang("frontend.about-det.4")
				</span>
            </div>
        </div>
    </div>
</div>
<!-- End -->
@include('frontend.layouts.footer')