<!doctype html>
<html class="no-js" lang="{{ app()->getLocale() }}">


<!-- Mirrored from demo.hasthemes.com/autima-preview/autima/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 01 Nov 2019 07:13:46 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Sign In Inaexport</title>
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
        .f-text {
            font-size: 14px;
        }
        .flat {
            border-radius: 0px;
        }
        .td-none {
            text-decoration: none;
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

<!-- login start -->
<section>
    <div class="container mt-5">
        <a href="{{url('/')}}"><img src="{{asset('front/assets/img/logo/logonew-200.png')}}" class="mx-auto d-block" alt="Logo Inaexport"></a>
        <p class="text-center f-text pt-2">Sign in to Inaexport or <a href="{{url('createaccount')}}">create an account</a></p>
        <div class="row justify-content-center pt-5">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <form class="form-horizontal" id="formlogin" method="POST" action="{{route('loginei.login')}}">
                {{csrf_field()}}       
                    <div class="mb-3">
                        <label for="txtemail" class="form-label">@lang("login.forms.email")</label>
                        <input type="email" class="form-control flat" name="email2" id="txtemail">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong style="color: red; font-weight: lighter;">{{$errors->first('email')}}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="txtpassword" class="form-label">@lang("login.forms.password")</label>
                        <input type="password" class="form-control flat" name="password2" id="txtpassword">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <button type="submit" class="form-control btn btn-success">@lang("login.btn")</button>
                    <p class="text-start mt-2"><a href="{{url('forget_a')}}" class="td-none">@lang("login.forms.fp")</a><p>
                </form>
                <hr>
                <p class="text-center" style="font-size:12px;">Copyright © 2019-2021 Inaexport. All rights reserved.</p>
            </div>
        </div>
    </div>
</section>
<!--login end -->

</body>
</html>

<script>
    function check() {
        email2 = $('#email2').val();
        password2 = $('#password2').val();
        if(!isEmptyM(email2) && !isEmptyM(password2)){
            $.post("{{ route('login.check_status') }}",
                {
                    '_token': '{{csrf_token()}}',
                    'email2': email2,
                    // 'password2': password2,
                }, function (response) {
                    var res = JSON.parse(response);
                    //console.log(res);
                    if(res == 'status2'){
                        var r = confirm("Aktivasi Akun Anda?");
                        // var status = 0;
                        // $('#status').val(0);
                        if (r == true) {
                            $.post("{{ route('login.change_status') }}",
                                {
                                    '_token': '{{csrf_token()}}',
                                    'email' : email2,
                                }, function (response) {

                                });
                            document.getElementById("formlogin").submit();
                        }
                    }else if( res == 'status0'){
                        alert('wait for admin to verified your account first')
                    }
                    // else if(res == 'statusoke'){
                    //     // $('#status').val(1);
                    //     console.log('testing');
                    //     document.getElementById("formlogin").submit();
                    // }
                    else{
                        document.getElementById("formlogin").submit();
                    }
                });
        }else{
            alert('please fill the email and password field first');
        }

    }

    function isEmptyM(obj) {
        for(var key in obj) {
            if(obj.hasOwnProperty(key))
                return false;
        }
        return true;
    }
</script>