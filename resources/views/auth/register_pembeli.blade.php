@include('headerlog')
<link href="{{asset('')}}/js/tagsinput.css" rel="stylesheet" type="text/css">
<style>
    .badge {
        font-size: 95% !important;
    }
    .form-control{
        font-size: 13px;
    }
</style>
<div id="content-bodys" class="product_area" style="color: black">
    <div class="py-1 w-100">

        <center><h3><b>@lang("login.title3")</b></h3>
            <h6>@lang("login.title5") <a href="{{url('login')}}"><font color="red"> @lang("login.btn")</font></a></h6>
            <br></center>
        <br>
        <div class="mx-auto col-sm-6"
             style="background: white; border-radius: 0px; box-shadow: 4px 4px 10px 7px #888888; border: 4px; border-radius: 10px;">
            <br>
            <!-- <h5>LOGIN</h5> -->
            <h5>
                <center><b>@lang("register.title")</b></center>
            </h5>
            <div class="wrap-login100" style="padding-left : 70px; padding-right : 70px; font-size:14px;">
                <form class="form-horizontal" method="POST" action="{{ url('simpan_rpembeli') }}">
                    {{ csrf_field() }}

                    <br><br>

                    <p><h6>Enter Your Account Information</h6></p>
                    <hr>

                    <div class="form-row">

                        <div class="form-group col-sm-4" align="left">
                            <label><font color="red">*</font> @lang("login.forms.ct")</label>
                        </div>
                        <div class="form-group col-sm-6" align="left">
                            <select class="form-control" name="country" id="country">
                                <option value="">- Choose Country -</option>
                                <?php
                                $qc = DB::select("select id,country from mst_country order by country asc");
                                foreach($qc as $cq){
                                ?>
                                <option value="<?php echo $cq->id; ?>"><?php echo $cq->country; ?></option>

                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-4" align="left">
                            <label><font color="red">*</font> @lang("login.forms.city")</label>
                        </div>
                        <div class="form-group col-sm-6" align="left">
                            <input type="text" name="city" id="city" class="form-control" style=" color: black; ">
                        </div>


                    </div>
                    <!-- <div class="form-row">

                                        <div class="form-group col-sm-4" align="left">
                                            <label>&nbsp; Account Type</label>
                                        </div>
                                        <div class="form-group col-sm-5" align="left">
                                            <input type="radio" name="Supplier" disabled> Supplier &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="Buyer" checked> Buyer

                                        </div>
                                    </div> -->

                    <div class="form-row">

                        <div class="form-group col-sm-4" align="left">
                            <label><font color="red">*</font> @lang("register.forms.email")
                            </label>&nbsp;&nbsp;&nbsp;<span id="cekmail"></span>
                        </div>
                        <div class="form-group col-sm-6" align="left">
                            <input type="text" name="email" id="email" class="form-control" style=" color: black; "
                                   required onkeyup="cekmail()">

                        </div>
                    </div>

                    <div class="form-row">

                        <div class="form-group col-sm-4" align="left">
                            <label><font color="red">*</font> @lang("register.forms.password")</label>

                        </div>

                        <div class="form-group col-sm-6" align="left">
                            <input type="password" name="password" id="password" class="form-control"
                                   style=" color: black; " required>

                        </div>
                    </div>

                    <div class="form-row">

                        <div class="form-group col-sm-4" align="left">
                            <label><font color="red">*</font> @lang("register.forms.re-password")</label>

                        </div>

                        <div class="form-group col-sm-6" align="left">
                            <input type="password" name="kpassword" id="kpassword" class="form-control"
                                   style=" color: black; ">

                        </div>

                    </div>


                    <br>
                    <p><h6>Enter Your Business Information</h6></p>
                    <hr>

                    <div class="form-row">

                        <div class="form-group col-sm-4" align="left">
                            <label><font color="red">*</font> @lang("register.forms.company") </label>

                        </div>

                        <div class="form-group col-sm-6" align="left">
                            <input type="text" name="company" id="company" class="form-control" style=" color: black; "
                                   required>

                        </div>

                    </div>
                    <div class="form-row">

                        <div class="form-group col-sm-4" align="left">
                            <label> &nbsp;Product Interest </label>

                        </div>

                        <div class="form-group col-sm-6" align="left">
                            <input type="text" data-role="tagsinput" class="form-control" value="">

                        </div>

                    </div>
                    <div class="form-row">

                        <div class="form-group col-sm-4" align="left">
                            <label><font color="red">*</font>@lang("register.forms.username")</label>

                        </div>

                        <div class="form-group col-sm-6" align="left">
                            <input type="text" name="username" id="username" class="form-control"
                                   style=" color: black; " required>
                        </div>

                    </div>


                    <div class="form-row">


                        <div class="form-group col-sm-4" align="left">
                            <label><font color="red">*</font> @lang("register.forms.phone")</label>
                        </div>
                        <div class="form-group col-sm-6" align="left">
                            <input type="text" name="phone" id="phone" class="form-control" style=" color: black; ">
                        </div>
                    </div>
                    <div class="form-row">


                        <div class="form-group col-sm-4" align="left">
                            <label>&nbsp;@lang("register.forms.fax")</label>
                        </div>
                        <div class="form-group col-sm-6" align="left">
                            <input type="text" name="fax" id="fax" class="form-control" style=" color: black; ">
                        </div>
                    </div>
                    <div class="form-row">


                        <div class="form-group col-sm-4" align="left">
                            <label>&nbsp;@lang("register.forms.website")</label>
                        </div>
                        <div class="form-group col-sm-6" align="left">
                            <input type="text" name="website" id="website" class="form-control" style=" color: black; ">
                        </div>
                    </div>

                    <div class="form-row">


                        <div class="form-group col-sm-4" align="left">
                            <label>&nbsp;@lang("register.forms.postcode")</label>
                        </div>
                        <div class="form-group col-sm-6" align="left">
                            <input type="text" name="postcode" id="postcode" class="form-control"
                                   style=" color: black; ">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-4" align="left">
                            <label><font color="red">*</font> @lang("register.forms.address")</label>
                        </div>
                        <div class="form-group col-sm-6" align="left">
                            <textarea name="alamat" id="alamat" class="form-control" style=" color: black; "></textarea>
                        </div>
                    </div>
{{--                    <div class="form-row">--}}
{{--                        <div class="form-group col-sm-4" align="left">--}}
{{--                            <label><font color="red">*</font> Verification Code</label>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-sm-2" align="left">--}}
{{--                            <img style="height:20px!Important;" src="{{url('assets')}}/assets/images/captcha.jfif"--}}
{{--                                 alt=".">--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-sm-4" align="left">--}}
{{--                            <input type="text" class="form-control" name="chp" id="chp">--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="form-row">
                        <div class="form-group col-sm-4" align="left">
                            <label><font color="red">*</font> Verification Code</label>
                        </div>
                        <div class="form-group col-sm-3 captcha" align="left" id="captcha">
                            <span>{!!captcha_img()!!}</span>
                        </div>
                        <div class="form-group col-sm-1" align="left">
                            <button type="button" class="btn btn-success" id="refresh"><i class="fa fa-refresh"></i></button>
                        </div>
                        <div class="form-group col-sm-2" align="left">
                            <input type="text" class="form-control" name="captchainput" id="captchainput">
                        </div>
                    </div>





                    <div class="form-row" align="left">

                        <div class="form-group col-sm-12"><br>
                            <input type="checkbox" name="ckk" id="ckk"> I agree to the Term & Condition and have read
                            and understood the Privacy Policy.<br><br>
                            <input type="checkbox" name="ckk2" id="ckk2"> Sign up for news letter.
                            <br><br>
                            <center>

                                <br>
                                <a onclick="simpanpembeli()" class="btn btn-danger"><font color="white">&nbsp;&nbsp;&nbsp;@lang("register.submit")
                                        &nbsp;&nbsp;&nbsp;</font></a>
                            <!-- <button style="width: 100%;" class="btn btn-success" style="border-color: #4CAF50;"><font color="white">&nbsp;&nbsp;&nbsp;@lang("register.submit")&nbsp;&nbsp;&nbsp;</font></button> -->
                            </center>
                        </div>
                    </div>


                    <br>
                    <br>

                </form>


            </div>


        </div>
    </div>
    <br><br>
    <center>
        @lang("login.title6") <br> @lang("login.title7")

        <br><br>
        @lang("login.title8") <br> <a href="{{url('front_end/ticketing_support')}}">@lang("login.title9")</a>
    </center>
    <br><br><br>
</div>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#2e899e; color:white;"><h6>Attention</h6>
                <button type="button" class="btn btn-danger" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <h5>
                    <center><br>
                        <img style="height:80px!important;" src="{{url('assets')}}/assets/images/mail.png"
                             alt="."><br><br>
                        @lang("register.modal")
                    </center>
                </h5>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
                <a href="{{url('login')}}" type="button" class="btn btn-danger">Close</a>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('')}}/js/tagsinput.js"></script>
<script>

    $('#refresh').click(function(){
        refresh()
    });

    function refresh(){
        $.ajax({
            type:'GET',
            url:'refreshcaptcha',
            success:function(data){
                console.log(data);
                $(".captcha span").html(data);
            }
        });
    }

    function cekmail() {
        var m = $('#email').val();
        var token = $('meta[name="csrf-token"]').attr('content');
        $.get('{{URL::to("cekmail/")}}/' + m, {_token: token}, function (data) {
            if (data == 0) {
                $('#cekmail').html("<font color='green'>( Available )</font>");

            } else {
                $('#cekmail').html("<font color='red'>( Has Been Used ! )</font>");
                $('#email').val("");
                alert("Sorry The Mail Has Been Used");
            }


        })
        //alert(m);
        //$('#cekmail').html("<font color='red'>( Has Been Used ! )</font>");
    }


    function simpanpembeli(){
        var company = $('#company').val();
        var username = $('#username').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var fax = $('#fax').val();
        var website = $('#website').val();
        var password = $('#password').val();
        var kpassword = $('#kpassword').val();
        var city = $('#city').val();
        var country = $('#country').val();
        var postcode = $('#postcode').val();
        var alamat = $('#alamat').val();
        var captcha = $('#captchainput').val();
        var token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            url: '{{url('/captchaValidate')}}',
            data: {
                captcha : captcha,
                _token: '{{csrf_token()}}'
            },
            success: function (data) {
                // console.log(data);
                if(data.jawab == 'gagal'){
                    alert("Your captcha failed");
                    $('#captchainput').val('');
                }
                else{
                    simpanpembeli2();
                }
            },
            error: function (data, textStatus, errorThrown) {
                console.log(data);
            },
        });
    }

    function simpanpembeli2() {
        var company = $('#company').val();
        var username = $('#username').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var fax = $('#fax').val();
        var website = $('#website').val();
        var password = $('#password').val();
        var kpassword = $('#kpassword').val();
        var city = $('#city').val();
        var country = $('#country').val();
        var postcode = $('#postcode').val();
        var alamat = $('#alamat').val();
        var chp = $('#chp').val();

        var token = $('meta[name="csrf-token"]').attr('content');
        if (password == kpassword) {
            if (company == "" || username == "" || email == "" || phone == "" || password == "" || country == "" || city == "" || alamat == "" || chp == "") {
                alert("Please complete the field !")
                refresh();
                $('#captchainput').val('');
            } else {
                $.ajax({
                    type: "POST",
                    url: '{{url('/simpan_rpembeli')}}',
                    data: {
                        company: company,
                        username: username,
                        email: email,
                        website: website,
                        phone: phone,
                        fax: fax,
                        password: password,
                        city: city,
                        country: country,
                        postcode: postcode,
                        alamat: alamat,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (data) {
                        console.log(data);
                    },
                    error: function (data, textStatus, errorThrown) {
                        console.log(data);

                    },
                });
                $('#company').val('');
                $('#username').val('');
                $('#website').val('');
                $('#email').val('');
                $('#phone').val('');
                $('#fax').val('');
                $('#password').val('');
                $('#kpassword').val('');
                $('#city').val('');
                $('#country').val('');
                $('#postcode').val('');
                $('#alamat').val('');
                $('#chp').val('');
                // $('#captchainput').val('');
                $("#myModal").modal("show");
            }
        } else {
            alert("Your Password Not Same !");
            $('#password').val('');
            $('#kpassword').val('');
            refresh();
            $('#captchainput').val('');

        }
    }
</script>

@include('footerlog')