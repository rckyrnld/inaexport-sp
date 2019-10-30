@include('header')
<div class="padding">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <style>
        .lebar_btn{
            width: 80px;
        }
        .toggle.btn.btn-info{
            width: 15% !important;
        }
        .toggle.btn.btn-default.off{
            width: 15% !important;   
        }
        .form-group input[type="checkbox"] {
            display: none;
        }
        .form-group input[type="checkbox"] + .btn-group > label span {
            width: 20px;
        }
        .form-group input[type="checkbox"] + .btn-group > label span:first-child {
            display: none;
        }
        .form-group input[type="checkbox"] + .btn-group > label span:last-child {
            display: inline-block;   
        }
        .form-group input[type="checkbox"]:checked + .btn-group > label span:first-child {
            display: inline-block;
        }
        .form-group input[type="checkbox"]:checked + .btn-group > label span:last-child {
            display: none;   
        }
    </style>
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{url($url)}}" id="formnya">
                {{ csrf_field() }}
                <div class="box">
                    <div class="box-divider m-0"></div>
                    <div class="box-body">
                        <div id="exTab2" class="container"> 
                            <div class="tab-content ">
                                <div class="tab-pane active" id="formprod">
                                    <br>
                                    <h3>Form Service</h3><hr>
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3">
                                            <center><label for="lbl"><b>English</b></label></center>
                                        </div>
                                        <div class="col-md-3">
                                            <center><label for="lbl"><b>Indonesia</b></label></center>
                                        </div>
                                        <div class="col-md-3">
                                            <center><label for="lbl"><b>China</b></label></center>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Name</b></label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="name_en" id="name_en" autocomplete="off">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="name_ind" id="name_ind" autocomplete="off">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="name_chn" id="name_chn" autocomplete="off">
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Field of Work</b></label>
                                        <div class="col-md-3">
                                            <div class="form-group" onclick="bidang_1(1)" style="width: 80%; height: 35px">
                                                <input type="checkbox" name="bidang_en[]" id="bidang_en" autocomplete="off" value="Pre Production"/>
                                                <div class="btn-group" style="width: 100%; height: 100%">
                                                    <label for="bidang_en" class="btn btn-default border-color" style="border-color: #aeb5b7; width: 25%; height: 100%;">
                                                        <span class="fa fa-check" style="font-size: 16px;"></span>
                                                        <span></span>
                                                    </label>
                                                    <label for="bidang_en" class="btn btn-default active border-color" style="border-color: #aeb5b7; width: 75%; height: 100%;">
                                                        Pre Production
                                                    </label>
                                                </div>
                                            </div><br>
                                            <div class="form-group" onclick="bidang_2(1)" style="width: 80%; height: 35px">
                                                <input type="checkbox" name="bidang_en[]" id="bidang_en_2" autocomplete="off" value="Production"/>
                                                <div class="btn-group" style="width: 100%; height: 100%;">
                                                    <label for="bidang_en_2" class="btn btn-default border-color" style="border-color: #aeb5b7; width: 25%; height: 100%;">
                                                        <span class="fa fa-check" style="font-size: 16px"></span>
                                                        <span></span>
                                                    </label>
                                                    <label for="bidang_en_2" class="btn btn-default active border-color" style="border-color: #aeb5b7; width: 75%; height: 100%;">
                                                        Production
                                                    </label>
                                                </div>
                                            </div><br>
                                            <div class="form-group" onclick="bidang_3(1)" style="width: 80%; height: 35px">
                                                <input type="checkbox" name="bidang_en[]" id="bidang_en_3" autocomplete="off" value="Post Production"/>
                                                <div class="btn-group" style="width: 100%; height: 100%;">
                                                    <label for="bidang_en_3" class="btn btn-default border-color" style="border-color: #aeb5b7; width: 25%; height: 100%;">
                                                        <span class="fa fa-check" style="font-size: 16px"></span>
                                                        <span></span>
                                                    </label>
                                                    <label for="bidang_en_3" class="btn btn-default active border-color" style="border-color: #aeb5b7; width: 75%; height: 100%;">
                                                        Post Production
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                             <div class="form-group" onclick="bidang_1(2)" style="width: 80%; height: 35px">
                                                <input type="checkbox" name="bidang_ind[]" id="bidang_ind" autocomplete="off" value="Pre Produksi"/>
                                                <div class="btn-group" style="width: 100%; height: 100%;">
                                                    <label for="bidang_ind" class="btn btn-default border-color" style="border-color: #aeb5b7; width: 25%; height: 100%;">
                                                        <span class="fa fa-check" style="font-size: 16px"></span>
                                                        <span></span>
                                                    </label>
                                                    <label for="bidang_ind" class="btn btn-default active border-color" style="border-color: #aeb5b7; width: 75%; height: 100%;">
                                                        Pre Produksi
                                                    </label>
                                                </div>
                                            </div><br>
                                            <div class="form-group" onclick="bidang_2(2)" style="width: 80%; height: 35px">
                                                <input type="checkbox" name="bidang_ind[]" id="bidang_ind_2" autocomplete="off" value="Produksi"/>
                                                <div class="btn-group" style="width: 100%; height: 100%;">
                                                    <label for="bidang_ind_2" class="btn btn-default border-color" style="border-color: #aeb5b7; width: 25%; height: 100%;">
                                                        <span class="fa fa-check" style="font-size: 16px"></span>
                                                        <span></span>
                                                    </label>
                                                    <label for="bidang_ind_2" class="btn btn-default active border-color" style="border-color: #aeb5b7; width: 75%; height: 100%;">
                                                        Produksi
                                                    </label>
                                                </div>
                                            </div><br>
                                            <div class="form-group" onclick="bidang_3(2)" style="width: 80%; height: 35px">
                                                <input type="checkbox" name="bidang_ind[]" id="bidang_ind_3" autocomplete="off" value="Pasca Produksi"/>
                                                <div class="btn-group" style="width: 100%; height: 100%;">
                                                    <label for="bidang_ind_3" class="btn btn-default border-color" style="border-color: #aeb5b7; width: 25%; height: 100%;">
                                                        <span class="fa fa-check" style="font-size: 16px"></span>
                                                        <span></span>
                                                    </label>
                                                    <label for="bidang_ind_3" class="btn btn-default active border-color" style="border-color: #aeb5b7; width: 75%; height: 100%;">
                                                        Pasca Produksi
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group" onclick="bidang_1(3)" style="width: 80%; height: 35px">
                                                <input type="checkbox" name="bidang_chn[]" id="bidang_chn" autocomplete="off" value="预生产"/>
                                                <div class="btn-group" style="width: 100%; height: 100%;">
                                                    <label for="bidang_chn" class="btn btn-default border-color" style="border-color: #aeb5b7; width: 25%; height: 100%;">
                                                        <span class="fa fa-check" style="font-size: 16px"></span>
                                                        <span></span>
                                                    </label>
                                                    <label for="bidang_chn" class="btn btn-default active border-color" style="border-color: #aeb5b7; width: 75%; height: 100%;">
                                                        预生产
                                                    </label>
                                                </div>
                                            </div><br>
                                            <div class="form-group" onclick="bidang_2(3)" style="width: 80%; height: 35px">
                                                <input type="checkbox" name="bidang_chn[]" id="bidang_chn_2" autocomplete="off" value="生产"/>
                                                <div class="btn-group" style="width: 100%; height: 100%;">
                                                    <label for="bidang_chn_2" class="btn btn-default border-color" style="border-color: #aeb5b7; width: 25%; height: 100%;">
                                                        <span class="fa fa-check" style="font-size: 16px"></span>
                                                        <span></span>
                                                    </label>
                                                    <label for="bidang_chn_2" class="btn btn-default active border-color" style="border-color: #aeb5b7; width: 75%; height: 100%;">
                                                        生产
                                                    </label>
                                                </div>
                                            </div><br>
                                            <div class="form-group" onclick="bidang_3(3)" style="width: 80%; height: 35px">
                                                <input type="checkbox" name="bidang_chn[]" id="bidang_chn_3" autocomplete="off" value="后期制作"/>
                                                <div class="btn-group" style="width: 100%; height: 100%;">
                                                    <label for="bidang_chn_3" class="btn btn-default border-color" style="border-color: #aeb5b7; width: 25%; height: 100%;">
                                                        <span class="fa fa-check" style="font-size: 16px"></span>
                                                        <span></span>
                                                    </label>
                                                    <label for="bidang_chn_3" class="btn btn-default active border-color" style="border-color: #aeb5b7; width: 75%; height: 100%;">
                                                        后期制作
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Skills</b></label>
                                        <div class="col-md-3">
                                            <textarea class="form-control" autocomplete="off" name="skill_en" id="skill_en"></textarea>
                                        </div>
                                        <div class="col-md-3">
                                            <textarea class="form-control" autocomplete="off" name="skill_ind" id="skill_ind"></textarea>
                                        </div>
                                        <div class="col-md-3">
                                            <textarea class="form-control" autocomplete="off" name="skill_chn" id="skill_chn"></textarea>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Experiences ( EN )</b></label>
                                        <div class="col-md-9">
                                            <textarea class="form-control" id="experience_en" name="experience_en"></textarea>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Experiences ( IND )</b></label>
                                        <div class="col-md-9">
                                            <textarea class="form-control" id="experience_ind" name="experience_ind"></textarea>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Experiences ( CHN )</b></label>
                                        <div class="col-md-9">
                                            <textarea class="form-control" id="experience_chn" name="experience_chn"></textarea>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Links</b></label>
                                        <div class="col-md-9">
                                            <textarea class="form-control" id="link" name="link"></textarea>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Show Services</b></label>
                                        <div class="col-md-9">
                                            <input type="checkbox" checked data-toggle="toggle" data-on="Publish" data-off="Hide" data-onstyle="info" data-offstyle="default" id="statusnya">
                                            <input type="hidden" name="status" id="status" value="1"> 
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div style="float: right;">
                                                <a class="btn btn-danger lebar_btn" href="{{url('eksportir/service')}}">Cancel</a>
                                                <button type="button" class="btn btn-primary lebar_btn" id="kirim">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        CKEDITOR.replace('experience_en');
        CKEDITOR.replace('experience_ind');
        CKEDITOR.replace('experience_chn');
        CKEDITOR.replace('link');

        $('#kirim').on('click', function(){
            checked = $("input[type=checkbox]:checked").length;
            var experience = CKEDITOR.instances.experience_en.getData();
            var link = CKEDITOR.instances.link.getData();
            
            if( $('#name_en').val() == ''){
                alert('Name ( EN ) is empty, please fill in!');
                return false;
            } else if(checked < 3) {
                alert("You must check at least one Field of Work!");
                return false;
            } else if( $('#skill_en').val() == ''){
                alert('Skills ( EN ) is empty, please fill in!');
                return false;
            } else if( experience == ''){
                alert('Experiences ( EN ) is empty, please fill in!');
                return false;
            } else if( link == ''){
                alert('Links is empty, please fill in!');
                return false;
            } else {
                $('#formnya').submit();
            }
        });

        $('#statusnya').on('change', function() {
            var isChecked = $(this).is(':checked');

            if(isChecked) {
                $('#status').val(1);
            } else {
                $('#status').val(0);
            }

        });
    })

     function bidang_1(value){
        switch(value){
            case 1:
                    $('#bidang_ind').click();
                    $('#bidang_chn').click();
                break;
            case 2:
                    $('#bidang_en').click();
                    $('#bidang_chn').click();
                break;
            case 3:
                    $('#bidang_en').click();
                    $('#bidang_ind').click();
                break;
        }
     }

     function bidang_2(value){
        switch(value){
            case 1:
                    $('#bidang_ind_2').click();
                    $('#bidang_chn_2').click();
                break;
            case 2:
                    $('#bidang_en_2').click();
                    $('#bidang_chn_2').click();
                break;
            case 3:
                    $('#bidang_en_2').click();
                    $('#bidang_ind_2').click();
                break;
        }
     }

     function bidang_3(value){
        switch(value){
            case 1:
                    $('#bidang_ind_3').click();
                    $('#bidang_chn_3').click();
                break;
            case 2:
                    $('#bidang_en_3').click();
                    $('#bidang_chn_3').click();
                break;
            case 3:
                    $('#bidang_en_3').click();
                    $('#bidang_ind_3').click();
                break;
        }
     }
</script>

@include('footer')
