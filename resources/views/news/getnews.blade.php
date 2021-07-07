@include('frontend.layouts.header')

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
				<li><a href="{{url('/news')}}">News</a></li>
				<li><?php echo $detail->title; ?>
			</ul>
		</div>
	</div>
	<div class="row pt-4">
		<div class="col-lg-12 col-12 mt-4">
			<p style="margin: 0px;"><span style="color: #007bff; font-size: 16px;"><b><?php echo $detail->title; ?></b></span></p>
			<p class="pb-3"><?php echo $detail->publish_date; ?></p>
		</div>
		<div class="container pt-3">
			<div class="row">
				<div class="col-lg-12 justify-content-start">
					<?php echo $detail->content; ?>
				</div>
			</div>
		</div>
	</div>
</div>

@include('frontend.layouts.footer')