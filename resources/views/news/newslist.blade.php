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
				<li>News</li>

			</ul>
		</div>
	</div>
	<div class="row pt-4">
		<div class="col-lg-12 col-12 mt-4">
			<p class="pb-3"><span style="color: #007bff; font-size: 16px;"><b>NEWS</b></span></p>
		</div>
		<div class="container pt-3">
			<div class="row">
				@foreach($news as $key => $ns)
                <div class="col-lg-12 pb-4">
					<p style="font-size: 15px; font-weight: bold;  margin: 0px 0px;"><?php echo $ns->title; ?></p>
					<p style="font-size: 12px;"><?php echo $ns->publish_date; ?></p>
					<p>
					{{ \Illuminate\Support\Str::limit(strip_tags($ns->content), 300, $end='...') }}
					</p>
					<a href="{{url('getnews/'.$ns->id.'/'.$ns->slug)}}" style="color:#ff0000;">Read More <i class="fas fa-chevron-circle-right"></i></a>
				</div>
                @endforeach
			</div>
		</div>
	</div>
</div>

@include('frontend.layouts.footer')