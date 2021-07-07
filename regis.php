<!--regis start-->
<section class="product_area mb-50" style="background-color: #ddeffd; padding: 4%; margin-bottom: 0px;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-5">
                            @if($loc == "in")
                                <span style="font-size: 20px;">
                                    Buat akun Anda dan mulailah <br>berbisnis <span style="color: #007bff;">skala internasional</span>
                                </span><br>
                            @elseif($loc == "ch")
                                <span style="font-size: 20px;">
                                    创建您的帐户并开始从事业务<span style="color: #007bff;">国际规模</span>
                                </span><br>
                            @else
                                <span style="font-size: 20px;">
                                    Create your account and start doing<br> business on <span style="color: #007bff;">an international scale</span>
                                </span><br>
                            @endif
                            <span style="font-size: 18px; color: #007bff;">{{getCountData('itdp_company_users')}}+ </span>
                            @if($loc == "in")
                                <span style="font-size: 18px; color: #666;">pengusaha telah bergabung</span>
                            @elseif($loc == "ch")
                                <span style="font-size: 18px; color: #666;">位企业家加入</span>
                            @else
                                <span style="font-size: 18px; color: #666;">entrepreneurs have joined</span>
                            @endif
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                            <center>
                                <a href="{{url('/pilihregister')}}" class="btn btn-primary" style="width: 200px; font-size: 18px; border-radius: 30px;">@if($loc == 'ch') 寄存器 @elseif($loc == "in") Daftar @else Register @endif</a>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--regis end-->