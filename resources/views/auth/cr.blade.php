<!doctype html>
<html class="no-js" lang="{{ app()->getLocale() }}">


<!-- Mirrored from demo.hasthemes.com/autima-preview/autima/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 01 Nov 2019 07:13:46 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Create Account Inaexport</title>
    <meta name="description" content="">
    <meta name="title" content="InaExport">
    <meta name="description" content="InaExport as a media product digital promotion superior export products from Indonesian business people, so they can more easily reach out to foreign buyers.">
    <meta name="keywords" content="inaexport, exporter, importer, buying request, inquiry, kemendag, trade, promotion, products, business, indonesia">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('front/assets/img/logo/kemendag.png')}}">

    <!-- CSS 
    ========================= -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{url('assets')}}/libs/font-awesome/css/font-awesome.min.css" type="text/css" />

    <!-- build:css ../assets/css/app.min.css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{asset('front/assets/css/style.css')}}">

	<style>
	 	.flat {
			border-radius: 0px;
		}	
		.f-select {
			font-size: 14px;
		}
		a {
            color: #306ba1;
        }
        a:hover {
            color: #6ca130;
        }
	</style>
</head>

<body>

<!-- create account start -->
<div class="container mt-5">
	<a href="{{url('/')}}"><img src="{{asset('front/assets/img/logo/logonew-200.png')}}" class="mx-auto d-block" alt="Logo Inaexport"></a>
	<p class="text-center f-text pt-4" style="font-size: 20px; font-weight: bold;">Create an account</a></p>
	<div class="row justify-content-center">
		<div class="col-lg-12 col-md-6 col-sm-12 text-center">
			<form>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" checked="checked" onclick="showbuyer()">
					<label class="form-check-label" for="inlineRadio1">as International Buyer</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2" onclick="showexp()">
					<label class="form-check-label" for="inlineRadio2">as Indonesian Exporter</label>
				</div>
			</form>
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12" name="divbuyer" id="divbuyer">
			<p class="mt-3"><b>International Buyer Account</b></p>
			@if(Session::has('success'))
			<div class="alert alert-success">
				{{ Session::get('success') }}
				@php
					Session::forget('success');
				@endphp
			</div>
			@endif
			<form method="POST" action="{{ url('simpan_rpembeli') }}">
				{{ csrf_field() }}
				<div class="mb-3">
					<label for="txtcountry" class="form-label">Country</label>
					<select class="form-control flat f-select" name="regcountry" id="txtcountry">
						<option value=""><b>-- Please Select --</b></option>
						<?php
						$qc = DB::select("select id,country from mst_country where Upper(country) != 'INDONESIA' order by country asc");
						foreach($qc as $cq){
						?>
						@if (old('regcountry') == $cq->id)
						<option value="<?php echo $cq->id; ?>" selected><?php echo $cq->country; ?></option>
						@else
						<option value="<?php echo $cq->id; ?>"><?php echo $cq->country; ?></option>
						@endif
						<?php } ?>
					</select>
					@if ($errors->has('regcountry'))
                    	<span class="text-danger">{{ $errors->first('regcountry') }}</span>
                	@endif
				</div>
				<div class="mb-3">
					<label for="txtname" class="form-label">Full Name</label>
					<input type="text" class="form-control flat" name="regfullname" id="txtname" value="{{old('regfullname')}}">
					@if ($errors->has('regfullname'))
                    	<span class="text-danger">{{ $errors->first('regfullname') }}</span>
                	@endif
				</div>
				<div class="mb-3">
					<label for="txtemail" class="form-label">Email</label>
					<input type="email" class="form-control flat" name="regemail" id="txtemail" value="{{old('regemail')}}">
					@if ($errors->has('regemail'))
                    	<span class="text-danger">{{ $errors->first('regemail') }}</span>
                	@endif
				</div>
				<div class="mb-3">
					<label for="txtpass" class="form-label">Password</label>
					<input type="password" class="form-control flat" name="regpassword" id="txtpass">
					<input type="checkbox" onclick="showpass()"> <span style="font-size: 13px;">Show Password</span> 
					@if ($errors->has('regpassword'))
                    	<br><span class="text-danger">{{ $errors->first('regpassword') }}</span>
                	@endif
				</div>
				<label class="mb-3" style="font-size: 12px;">By creating an account, you agree to the <a href="#">Term & Condition</a> and have read and understood the <a href="#">Privacy Policy</a>.</label>
				<button type="submit" class="mb-3 btn btn-primary">Create account</button>
			</form>
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12" name="divexp" id="divexp" style="display: none;">
			<p class="mt-3"><b>Indonesian Exporter Account</b></p>
			<form>
				<div class="mb-3">
					<label for="txtprovince" class="form-label">Province</label>
					<select class="form-control flat f-select" name="province" id="txtprovince">
						<option value="">-- Please Select --</option>
                                <?php
                                $qc = DB::select("select id,province_en from mst_province order by province_en asc");
                                foreach($qc as $cq){
                                ?>
                                <option value="<?php echo $cq->id; ?>"><?php echo $cq->province_en; ?></option>

						<?php } ?>
					</select>
				</div>
				<div class="mb-3">
					<label for="txtname" class="form-label">Full Name</label>
					<input type="text" class="form-control flat" id="txtname">
				</div>
				<div class="mb-3">
					<label for="txtemail" class="form-label">Email</label>
					<input type="email" class="form-control flat" id="txtemail">
				</div>
				<div class="mb-3">
					<label for="txtpass" class="form-label">Password</label>
					<input type="password" class="form-control flat" id="txtpass">
					<input type="checkbox" onclick="showpass()"> <span style="font-size: 13px;">Show Password</span> 
				</div>
				<label class="mb-3" style="font-size: 12px;">By creating an account, you agree to the Term & Condition and have read and understood the Privacy Policy.</label>
				<button type="submit" class="mb-3 btn btn-primary">Create account</button>
			</form>
		</div>
		<div class="row justify-content-center">
			<div class="col-lg-4 col-md-6 col-sm-12 mb-3">
				<p>Already have an account? <a href="{{url('login')}}">Sign In</a></p>
			</div>
		</div>
		<hr>
		<p class="text-center" style="font-size:12px;">Copyright © 2019-2021 Inaexport. All rights reserved.</p>
	</div>
</div>
<!-- create account end -->

</body>
<script>
	function showbuyer() {
		var x = document.getElementById("divbuyer");
		var y = document.getElementById("divexp");
		if (x.style.display === "none") {
			x.style.display = "block";
			y.style.display = "none";
		} else {
			x.style.display = "none";
			y.style.display = "block";
		}
	}
	function showexp() {
		var x = document.getElementById("divbuyer");
		var y = document.getElementById("divexp");
		if (y.style.display === "none") {
			y.style.display = "block";
			x.style.display = "none";
		} else {
			y.style.display = "none";
			x.style.display = "block";
		}
	}
	function showpass() {
		var x = document.getElementById("txtpass");
		if (x.type === "password") {
			x.type = "text";
		} else {
			x.type = "password";
		}
	} 
</script>
</html>