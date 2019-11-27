@include('frontend.layouts.header')
<style type="text/css">
    td span{
        font-size: 18px;font-weight: 400; padding-left: 8px;
    }
</style>
<!-- Kontent 1-->
<div style="background-color: #f2f2f2">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-12 col-12" style="padding-top: 20px; padding-bottom: 20px; height: 100%;">
            	<div class="mapouter">
                    <div class="gmap_canvas">
                        <iframe width="100%" height="400px" id="gmap_canvas" src="https://maps.google.com/maps?q=Ministry%20of%20Trade%20of%20The%20Republic%20of%20Indonesia&t=&z=17&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" style="border-radius: 20px;"></iframe><a href="https://www.embedgooglemap.net/blog/torguard-promo-code/"></a>
                    </div>
                    <style>.mapouter{position:relative;text-align:right;width:100%;}.gmap_canvas {overflow:hidden;background:none!important;width:100%;}</style>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Kontent 3 -->
<div style="background-color: #2492eb">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-12 col-12" style="padding-top: 10px; padding-bottom: 20px; height: 100%;">
				<span style="color: #f2f2f2; font-size: 23px; font-weight: 500;">
                    <div class="form-group row">
                        <div class="col-md-8 col-lg-8 col-12" style="padding-bottom: 30px;">
                            @lang("frontend.cu-add-kontak")<br>
                            <span style="font-size: 46px">@lang("frontend.cu-add-free")</span><br>
                            <span style="font-size: 18px;line-height:2px;">DGNED @lang("frontend.service-title")<br>@lang("footer.foot.directorate")</span><br><br>
                    <form action="{{url('/contact-us/send/')}}" method="POST">
                        {{ csrf_field() }}
                            <table width="100%" border="0" cellpadding="5">
                                <tr>
                                    <td width="48%">
                                        <span>@lang("frontend.cu-fullname")</span>
                                        <input type="text" class="form-control" name="name" autocomplete="off" required/>
                                        <input type="hidden" name="urlnya" value="/contact-us/">
                                    </td>
                                    <td width="4%">&nbsp;</td>
                                    <td width="48%">
                                        <span>@lang("frontend.cu-email")</span>
                                        <input type="email" class="form-control" name="email" autocomplete="off" required/>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <span>@lang("frontend.cu-subyek")</span>
                                        <input type="text" class="form-control" name="subyek" autocomplete="off" required/>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <span>@lang("frontend.cu-message")</span>
                                        <textarea style="resize: none;" name="message" autocomplete="off" required class="form-control" rows="5"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <button type="submit" class="btn btn-danger" style="width: 100%; background-color: #fe0000; font-size: 24px; font-weight: 600;">@lang("button-name.submit")</button>
                                    </td>
                                </tr>
                            </table>
                    </form>
                        </div>
                        <div class="col-md-4 col-lg-4 col-12">
                            @lang("frontend.cu-add-email")<br>
                            <span style="font-size:20px; font-weight: 400; ">csm@kemendag.go.id</span><br><br>
                            @lang("frontend.cu-add-call")<br>
                            <span style="font-size:21px; font-weight: 400; ">+62 21 385 8171<br>+62 21 385 8171</span><br><br>
                            @lang("frontend.cu-add-visit")<br><i style="font-size:21px; font-weight: 500;">@lang("footer.foot.directorate")<br>@lang("footer.foot.ministry")</i><br>
                            <span style="font-size:21px; font-weight: 400; ">Jl. M.I. Ridwan Rais No.5, RT.7/RW.1, Gambir, Kecamatan Gambir, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10110, Indonesia</span><br><br>
                        </div>
                    </div>
				</span>
            </div>
        </div>
    </div>
</div>
<!-- End -->
@include('frontend.layouts.footer')