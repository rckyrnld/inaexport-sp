<!--shipping area start-->
<!-- <section class="shipping_area" style="background-color: #ddeffd;">
        <div class="container">
            <div class=" row">
                <div class="col-12">
                    <div class="shipping_inner">
                        <div class="single_shipping">
                            <div class="shipping_content">
                                <img src="{{asset('front/assets/img/perlindungan_konsumen.png')}}" alt="">
                                <h2>Perlindungan Konsumen</h2>
                                <p>Jaminan perlindungan keamanan kepada konsumen & supplier</p>
                            </div>
                        </div>
                        <div class="single_shipping">
                            <div class="shipping_content">
                                <img src="{{asset('front/assets/img/pengiriman.png')}}" alt="">
                                <h2>Jaminan Pengiriman</h2>
                                <p>Uang dikembalikan 100% jika barang tidak dikirimkan</p>
                            </div>
                        </div>
                        <div class="single_shipping">
                            <div class="shipping_content">
                                <img src="{{asset('front/assets/img/pembayaran.png')}}" alt="">
                                <h2>Pembayaran Aman</h2>
                                <p>Pilihan metode pembayaran yang beragam, cepat dan aman</p>
                            </div>
                        </div>
                        <div class="single_shipping">
                            <div class="shipping_content">
                                <img src="{{asset('front/assets/img/respon.png')}}" alt="">
                                <h2>Respon Cepat</h2>
                                <p>Pelayanan komunikasi 24jam/hari Solusi komunikasi cepat</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <!--shipping area end-->
<?php if(empty($loc)){ $loc = 'en'; } ?>
    <section class="call_to_action">
        <div class="container">
            <div class="row counters">

                <div class="col-lg-4 col-6 text-center">
                    <ul class="list-group list-group-horizontal-sm justify-content-center">
                        <li>
                            <img src="{{asset('front/assets/img/exporters.png')}}" alt="" style="width: 20%;">
                            <span class="counters_number">{{getCountData('itdp_company_users')}}</span>
                        </li>
                         <li style="padding-left: 20%;">
                            <p class="counters_text" style="font-size: 18px;">
							
                                @if($loc == 'ch')
                                出口商
                                @elseif($loc == 'in')
                                Eksportir
                                @else
                                Exporters
                                @endif 
                            </p>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-4 col-6 text-center">
                    <ul class="list-group list-group-horizontal-sm justify-content-center">
                        <li>
                            <img src="{{asset('front/assets/img/events.png')}}" alt="" style="width: 20%;">
                            <span class="counters_number">{{getCountData('event_detail')}}</span>
                        </li>
                        <li style="padding-left: 20%;">
                            <p class="counters_text" style="font-size: 18px;">
                                @if($loc == 'ch')
                                事件
                                @elseif($loc == 'in')
                                Acara
                                @else
                                Events
                                @endif
                            </p>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-4 col-6 text-center">
                    <ul class="list-group list-group-horizontal-sm justify-content-center">
                        <li>
                            <img src="{{asset('front/assets/img/products.png')}}" alt="" style="width: 20%;">
                            <span class="counters_number">{{getCountData('csc_product_single')}}</span>
                        </li>
                        <li style="padding-left: 20%;">
                            <p class="counters_text" style="font-size: 18px;">@lang('frontend.home.product')</p>
                        </li>
                    </ul>
                </div>
    
            </div>
        </div>
    </section>

<!--footer area start-->
<footer class="footer_widgets mt-50">
        <div class="container">
            <div class="footer_top">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="widgets_container contact_us">
                            <div class="footer_logo">
                                <a href="#"><img src="{{asset('front/assets/img/logo/logo.png')}}" alt="" width="150"></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6">
                        <div class="widgets_container widget_menu">
                            <h3>TRADE.ID</h3>
                            <div class="footer_menu">
                                <ul>
                                    <li><a href="#">@lang("footer.tentangkami")</a></li>
                                    <li><a href="#">@lang("footer.karir")</a></li>
                                    <li><a href="#">@lang("footer.hubungikami")</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="widgets_container widget_menu">
                            <h3>@lang("footer.informasilayanan")</h3>
                            <div class="footer_menu">
                                <ul>
                                    <li><a href="#">@lang("footer.pengembalianbarang")</a></li>
                                    <li><a href="#">@lang("footer.syaratkondisi")</a></li>
                                    <li><a href="#">@lang("footer.kebijakanprivasi")</a></li>
                                </ul>
                            </div>
                        </div><br>
                        <div class="widgets_container widget_menu">
                            <h3>@lang("footer.informasipenting")</h3>
                            <div class="footer_menu">
                                <ul>
                                    <li><a href="#">@lang("footer.analisapasar")</a></li>
                                    <li><a href="#">@lang("footer.even")</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6">
                        <div class="widgets_container widget_menu">
                            <h3>@lang("footer.bantuandukungan")</h3>
                            <div class="footer_menu">
                                <ul>
                                    <li><a href="#">@lang("footer.mulai")</a></li>
                                    <li><a href="#">@lang("footer.faq")</a></li>
                                    <li><a href="#">@lang("footer.turvideo")</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6">
                        <div class="widgets_container widget_menu">
                            <h3>@lang("footer.contactcenter")</h3>
                            <div class="footer_menu">
                                <ul>
                                    <li><a href="#">021-1234-5678</a></li>
                                    <li><a href="#">0811-222-3333</a></li>
                                </ul>
                            </div>
                        </div><br>
                        <div class="widgets_container widget_menu">
                            <h3>@lang("footer.lgd")</h3>
                            <div class="footer_menu">
                                <div class="row">
                                    <div class="container">
                                        <a href="#"><img src="{{asset('front/assets/img/icon/fb.png')}}" alt=""></a>
                                        <a href="#"><img src="{{asset('front/assets/img/icon/wa.png')}}" alt=""></a>
                                        <a href="#"><img src="{{asset('front/assets/img/icon/ig.png')}}" alt=""></a>
                                        <a href="#"><img src="{{asset('front/assets/img/icon/yt.png')}}" alt=""></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer_bottom">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="copyright_area">
                            <p>@lang("footer.cc") &copy; <?php echo date("Y"); ?> </p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--footer area end-->
<!-- JS
============================================ -->

    <!-- Plugins JS -->
    <!-- <script src="{{asset('front/assets/js/plugins.js')}}"></script> -->
    <!-- Main JS -->
    <script src="{{asset('front/assets/js/main.js')}}"></script>
	<script>
function closenotif(x){
	var token = $('meta[name="csrf-token"]').attr('content');
		$.get('{{URL::to("bacanotif/")}}/'+x,{_token:token},function(data){
			
		 });
}
</script>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'en', layout:google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
        }
        function ce(){
            var a = $('#lang').val();
            var url = '<?php  echo url('locale/') ?>/'+a;
            window.open(url,'myWindow');
        }
    </script>

    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>


</body>


<!-- Mirrored from demo.hasthemes.com/autima-preview/autima/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 01 Nov 2019 07:14:17 GMT -->
</html>