@include('header')
<title>E-Reporting | Tambah User</title>
<div class="padding">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <style>
        .img_upl {
            border: 1px dashed #6fccdd;
            background: transparent;
        }

        .list-group-item.active, .list-group-item.active:hover, .list-group-item.active:focus {
            background: #1a7688 !important;
            color: white;
        }

        .toggle.btn.btn-info{
            width: 15% !important;
        }
        .toggle.btn.btn-default.off{
            width: 15% !important;   
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
                            <ul class="nav nav-tabs" style="display: none;">
                                <li class="nav-item"><a class="nav-link active" href="#formprod" id="set_formprod" data-toggle="tab">Form Product</a></li>
                                <li class="nav-item"><a class="nav-link" href="#infoprod" id="set_infoprod" data-toggle="tab">Information Product</a></li>
                                <li class="nav-item"><a class="nav-link" href="#descprod" id="set_descprod" data-toggle="tab">Description Product</a></li>
                            </ul>
                            <div class="tab-content ">
                                <div class="tab-pane active" id="formprod">
                                    <br>
                                    <h3>Form Product</h3><hr>
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
                                        <label for="code" class="col-md-3"><b>Code</b></label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="code" id="code" autocomplete="off">
                                        </div>
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3"></div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Product Name</b></label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="prodname_en" id="prodname_en" autocomplete="off">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="prodname_in" id="prodname_in" autocomplete="off">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="prodname_chn" id="prodname_chn" autocomplete="off">
                                        </div>
                                    </div><br>
                                    <div class="row" style="border: 1px solid rgba(120, 130, 140, 0.13); padding: 10px;">
                                        <div class="col-md-12"><label><b>Product Category</b></label></div><br>
                                        <div class="col-md-4" style="border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px; max-height: 450px;">
                                            <input type="text" id="search1" name="search1" class="form-control" onInput="searchsub(1)">
                                            <div id="prod1" class="list-group" style="height: 430px; overflow-y: auto;">
                                                @foreach($catprod as $cp)
                                                    <a href="#" class="list-group-item list-group-item-action listbag1" onclick="getSub(1,'{{$cp->id}}', '', '{{$cp->nama_kategori_en}}', event)" id="kat1_{{$cp->id}}" data-value="{{$cp->id}}">{{$cp->nama_kategori_en}}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-md-4" style="border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                            <div id="tmpsearch2">

                                            </div>
                                            <div id="prod2" class="list-group" style="height: 430px; overflow-y: auto;">
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-4" style="border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                            <div id="tmpsearch3">

                                            </div>
                                            <div id="prod3" class="list-group" style="height: 430px; overflow-y: auto;">
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-2" style="margin-top: 20px;"><label><b>Select</b></label></div>
                                        <div class="col-md-8" style="margin-top: 20px;">
                                            <span id="select_1"></span>
                                            <input type="hidden" name="id_csc_product" id="id_csc_product">
                                            <span id="select_2"></span>
                                            <input type="hidden" name="id_csc_product_level1" id="id_csc_product_level1">
                                            <span id="select_3"></span>
                                            <input type="hidden" name="id_csc_product_level2" id="id_csc_product_level2">
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="btn-group" style="float: right;">
                                                <button type="button" class="btn btn-primary" id="hal1">Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="infoprod">
                                    <br>
                                    <h3>Information Product</h3><hr>
                                    <div class="row">
                                        <div class="col-md-2"></div>
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
                                        <label for="code" class="col-md-2"><b>Code</b></label>
                                        <div class="col-md-3">
                                            <center><span id="codenya"></span></center>
                                        </div>
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3"></div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-2"><b>Product Name</b></label>
                                        <div class="col-md-3">
                                            <center><span id="prodname_ea"></span></center>
                                        </div>
                                        <div class="col-md-3">
                                            <center><span id="prodname_ia"></span></center>
                                        </div>
                                        <div class="col-md-3">
                                            <center><span id="prodname_ca"></span></center>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-2"><b>Category Product</b></label>
                                        <div class="col-md-3">
                                            <center><span id="cadprod_en"></span></center>
                                        </div>
                                        <div class="col-md-3">
                                            <center><span id="cadprod_in"></span></center>
                                        </div>
                                        <div class="col-md-3">
                                            <center><span id="cadprod_chn"></span></center>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-2"><b>Color</b></label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="color_en" id="color_en" autocomplete="off">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="color_in" id="color_in" autocomplete="off">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="color_chn" id="color_chn" autocomplete="off">
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-2"><b>Size</b></label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="size_en" id="size_en" autocomplete="off">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="size_in" id="size_in" autocomplete="off">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="size_chn" id="size_chn" autocomplete="off">
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-2"><b>Raw Material</b></label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="raw_material_en" id="raw_material_en" autocomplete="off">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="raw_material_in" id="raw_material_in" autocomplete="off">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="raw_material_chn" id="raw_material_chn" autocomplete="off">
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-2"><b>Capacity</b></label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="capacity" id="capacity" autocomplete="off">
                                        </div>
                                        <div class="col-md-3">
                                        </div>
                                        <div class="col-md-3">
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-2"><b>Price (USD)</b></label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="price_usd" id="price_usd" autocomplete="off">
                                        </div>
                                        <div class="col-md-3">
                                        </div>
                                        <div class="col-md-3">
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-2"><b>HS Code</b></label>
                                        <div class="col-md-3">
                                            <select class="form-control select2" name="hscode" id="hscode" style="width: 100%;">
                                               <option value=""></option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                        </div>
                                        <div class="col-md-3">
                                        </div>
                                    </div><br>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label><b>Setting Media</b></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label for="code"><b>Image (.png, .jpg, .jpeg, .gif)</b></label>
                                            <label style="color: red">*maksimum file size 200kb</label>
                                        </div>
                                        <!-- <div class="col-md-2">
                                            <div id="ambil_ttd_utama" style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                                <button type="button" id="img_utama" style="width: 100%; height: 120px;" class="img_upl">
                                                    <img src="{{url('/')}}/image/plus/plusin.png" id="image_utama_ambil" style="height: 40px; width: 40px;"/>
                                                </button>
                                                <input type="file" id="image_utama" name="image_utama" style="display: none;" />
                                                <br>
                                                <center>+ Main Photo</center>
                                            </div>
                                        </div> -->
                                        <div class="col-md-2">
                                            <div id="ambil_ttd_1" style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                                <button type="button" id="img_1" style="width: 100%; height: 120px;" class="img_upl">
                                                    <img src="{{url('/')}}/image/plus/plusin.png" id="image_1_ambil" style="height: 40px; width: 40px;"/>
                                                </button>
                                                <input type="file" id="image_1" name="image_1" accept="image/png" style="display: none;" />
                                                <br>
                                                <center>+ Photo 1</center>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div id="ambil_ttd_2" style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                                <button type="button" id="img_2" style="width: 100%; height: 120px;" class="img_upl">
                                                    <img src="{{url('/')}}/image/plus/plusin.png" id="image_2_ambil" style="height: 40px; width: 40px;"/>
                                                </button>
                                                <input type="file" id="image_2" name="image_2" accept="image/png" style="display: none;" />
                                                <br>
                                                <center>+ Photo 2</center>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div id="ambil_ttd_3" style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                                <button type="button" id="img_3" style="width: 100%; height: 120px;" class="img_upl">
                                                    <img src="{{url('/')}}/image/plus/plusin.png" id="image_3_ambil" style="height: 40px; width: 40px;"/>
                                                </button>
                                                <input type="file" id="image_3" name="image_3" accept="image/png" style="display: none;" />
                                                <br>
                                                <center>+ Photo 3</center>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div id="ambil_ttd_4" style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                                <button type="button" id="img_4" style="width: 100%; height: 120px;" class="img_upl">
                                                    <img src="{{url('/')}}/image/plus/plusin.png" id="image_4_ambil" style="height: 40px; width: 40px;"/>
                                                </button>
                                                <input type="file" id="image_4" name="image_4" accept="image/png" style="display: none;" />
                                                <br>
                                                <center>+ Photo 4</center>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-2"><b>Minimum Selling</b></label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="minimum_order" id="minimum_order" autocomplete="off">
                                        </div>
                                        <div class="col-md-3">
                                        </div>
                                        <div class="col-md-3">
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div style="float: right;">
                                                <button type="button" class="btn btn-default" onclick="nextTab('infoprod', 'formprod')">Back</button>
                                                <button type="button" class="btn btn-primary" id="hal2">Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="descprod">
                                    <br>
                                    <h3>Description Product</h3><hr>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>English</b></label>
                                        <div class="col-md-9">
                                            <textarea class="form-control" id="product_description_en" name="product_description_en"></textarea>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Indonesia</b></label>
                                        <div class="col-md-9">
                                            <textarea class="form-control" id="product_description_in" name="product_description_in"></textarea>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>China</b></label>
                                        <div class="col-md-9">
                                            <textarea class="form-control" id="product_description_chn" name="product_description_chn"></textarea>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Show Product</b></label>
                                        <div class="col-md-9">
                                            <input type="checkbox" checked data-toggle="toggle" data-on="Publish" data-off="Hide" data-onstyle="info" data-offstyle="default" id="statusnya">
                                            <input type="hidden" name="status" id="status" value="1"> 
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div style="float: right;">
                                                <button type="button" class="btn btn-default" onclick="nextTab('descprod', 'infoprod')">Back</button>
                                                <a class="btn btn-danger" href="{{url('eksportir/product')}}">Cancel</a>
                                                <button type="button" class="btn btn-primary" id="hal3">Submit</button>
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
        var CSRF_TOKEN = "{{ csrf_token() }}";
        CKEDITOR.replace('product_description_en');
        CKEDITOR.replace('product_description_in');
        CKEDITOR.replace('product_description_chn');

        // $("#img_utama").click(function() {
        //     $("input[id='image_utama']").click();
        // });

        $('.select2').select2({
            allowClear: true,
            placeholder: 'Select HS Code',
            ajax: {
                url: "{{route('eksproduct.getHsCode')}}",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                  return {
                    results: $.map(data, function (item) {
                      return {
                        text: item.fullhs + "  -  " + item.desc_eng,
                        id: item.id
                      }
                    })
                  };
                },
                cache: true
            }
        });

        $("#img_1").click(function() {
            $("input[id='image_1']").click();
        });

        $("#img_2").click(function() {
            $("input[id='image_2']").click();
        });

        $("#img_3").click(function() {
            $("input[id='image_3']").click();
        });

        $("#img_4").click(function() {
            $("input[id='image_4']").click();
        });

        // document.getElementById("image_utama").addEventListener('change',handleFileSelect,false);
        document.getElementById("image_1").addEventListener('change',handleFileSelect,false);
        document.getElementById("image_2").addEventListener('change',handleFileSelect,false);
        document.getElementById("image_3").addEventListener('change',handleFileSelect,false);
        document.getElementById("image_4").addEventListener('change',handleFileSelect,false);

        $("#hal1").on("click", function(){
            // if ($('#prodname_en').val() == "") {
            //     alert("Product name is empty, please fill in!");
            //     return false;
            // }else if ($('#id_csc_product').val() == "") {
            //     alert("Please select a product category!");
            //     return false;
            // }else {
                nextTab('formprod','infoprod');
                return true;
            // }
        });

        $("#hal2").on("click", function(){
            nextTab('infoprod','descprod');
            return true;
        });

        $("#hal3").on("click", function(){
            if ($('#prodname_en').val() == "") {
                alert("Product name is empty, please fill in!");
                return false;
            }else if ($('#id_csc_product').val() == "") {
                alert("Please select a product category!");
                return false;
            }else{
                $("#formnya").submit();
            }
        });

        $("#code").focus(function(){}).blur(function(){
            $('#codenya').text(this.value);
        });

        $("#prodname_en").focus(function(){}).blur(function(){
            $('#prodname_ea').text(this.value);
        });

        $("#prodname_in").focus(function(){}).blur(function(){
            $('#prodname_ia').text(this.value);
        });

        $("#prodname_chn").focus(function(){}).blur(function(){
            $('#prodname_ca').text(this.value);
        });

        $('#statusnya').on('change', function() {
            var isChecked = $(this).is(':checked');
            var selectedData;

            if(isChecked) {
                $('#status').val(1);
            } else {
                $('#status').val(0);
            }

        });

        // $(document).on('keyup', '.select2', function (e) {   
        //     console.log(e);
        //     // alert(this.value);
        // })

    })

    function nextTab(now, next) {
        $('#set_'+now).removeClass('active');
        $('#set_'+next).addClass('active');

        $('.tab-pane.active').removeClass('active');
        $('#'+next).addClass('active');
    }

    function getSub(sub, idp, ids, name, evt) {
        evt.preventDefault();
        if(sub == 3){
            $('#select_3').text('> '+name);
            $('#id_csc_product_level2').val(ids);
            $('.listbag3').removeClass('active');
            $('#kat3_'+ids).addClass('active');
        }else{
            if(sub == 1){
                $('#select_1').text(name);
                $('#cadprod_en').text(name);
                $('#id_csc_product').val(idp);
                $('#select_2').text('');
                $('#id_csc_product_level1').val('');
                $('#select_3').text('');
                $('#id_csc_product_level2').val('');
                $('#prod2').html('');
                $('#prod3').html('');
                $('.listbag1').removeClass('active');
                $('#kat1_'+idp).addClass('active');
                $('#tmpsearch2').html('');
                $('#tmpsearch3').html('');
            }else{
                $('#select_2').text(' >'+name);
                $('#id_csc_product_level1').val(ids);
                $('#select_3').text('');
                $('#id_csc_product_level2').val('');
                $('#prod3').html('');
                $('.listbag2').removeClass('active');
                $('#kat2_'+ids).addClass('active');
                $('#tmpsearch3').html('');
            }
            $.ajax({
                url: "{{route('eksproduct.getSub')}}",
                type: 'get',
                data: {level:sub, idparent:idp, idsub:ids},
                success:function(response){
                    // console.log(response);
                    if(sub == 1){
                        $('#prod2').html(response);
                        $('#tmpsearch2').html("<input type=\"text\" id=\"search2\" name=\"search2\" class=\"form-control\" onInput=\"searchsub(2)\">");
                    }else{
                        $('#prod3').html(response);
                        $('#tmpsearch3').html("<input type=\"text\" id=\"search3\" name=\"search3\" class=\"form-control\" onInput=\"searchsub(3)\">");
                    }
                }
            });
        }
    }

    function searchsub(suba){
        if(suba == 1){
            var tes = document.getElementById("search1");
            var s = tes.value;
            var value = "kosong";
            var value2 = "kosong";
            $('#tmpsearch2').html('');
            $('#tmpsearch3').html('');
            $('#prod2').html('');
            $('#prod3').html('');
        }else if(suba==2){
            var items = document.getElementsByClassName("list-group-item listbag1 active");
            var value = $(items).attr('data-value');
            var tes = document.getElementById("search2");
            var s = tes.value;
            var value2 = "kosong";
            $('#tmpsearch3').html('');
            $('#prod3').html('');
        }else{
            var items = document.getElementsByClassName("list-group-item listbag1 active");
            var value = $(items).attr('data-value');
            var items2 = document.getElementsByClassName("list-group-item listbag2 active");
            var value2 = $(items2).attr('data-value');
            var tes = document.getElementById("search3");
            var s = tes.value;
        }

        $.ajax({
            url: "{{route('eksproduct.searchsub')}}",
            type: 'get',
            data: {level:suba, text:s,parent:value,parent2:value2},
            success:function(response){
                // console.log(response);
                if(suba == 1){
                    $('#prod1').html(response);
                }
                else if(suba == 2){
                    $('#prod2').html(response);
                }else{
                    $('#prod3').html(response);
                }
            }
        });

    }

    function handleFileSelect(evt){
        var files = evt.target.files; // FileList object
        var idfile = evt.target.id; // FileList object

        // FileReader support
        if (FileReader && files && files.length) {
            var fr = new FileReader();
            fr.onload = function () {
                document.getElementById(idfile+"_ambil").src = fr.result;
                document.getElementById(idfile+"_ambil").style.width = "100%";
                document.getElementById(idfile+"_ambil").style.height = "100%";
            }
            fr.readAsDataURL(files[0]);
        }
     }

     function getStatus(data) {
         console.log(data);
     }
</script>

@include('footer')
