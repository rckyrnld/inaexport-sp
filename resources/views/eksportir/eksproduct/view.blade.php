@include('header')
<title>InaExport | Tambah User</title>
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
                                @if($jenis == 'admin')
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="lbl"><b>Company Name</b></label>
                                    </div>
                                    <div class="col-md-3" >
                                        <input type="text" class="form-control" name="compname" id="compname" autocomplete="off" value="{{getNameCompany($data->id_itdp_company_user)}}" style="text-transform: uppercase; font-weight: bold;" readonly>
                                    </div>
                                    <div class="col-md-3"></div>
                                    <div class="col-md-3"></div>
                                </div><br>
                                @endif
                                <div class="row">
                                    <label for="code" class="col-md-3"><b>Code</b></label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="code" id="code" autocomplete="off" value="{{$data->code_en}}" readonly>
                                    </div>
                                    <div class="col-md-3"></div>
                                    <div class="col-md-3"></div>
                                </div><br>
                                <div class="row">
                                    <label for="code" class="col-md-3"><b>Product Name</b></label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="prodname_en" id="prodname_en" autocomplete="off" value="{{$data->prodname_en}}" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="prodname_in" id="prodname_in" autocomplete="off" value="{{$data->prodname_in}}" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="prodname_chn" id="prodname_chn" autocomplete="off" value="{{$data->prodname_chn}}" readonly>
                                    </div>
                                </div><br>
                                <div class="row" style="border: 1px solid rgba(120, 130, 140, 0.13); padding: 10px;">
                                    <div class="col-md-12"><label><b>Product Category</b></label></div><br>
                                    <div class="col-md-4" style="border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px; max-height: 450px;">
                                        <div id="prod1" class="list-group" style="height: 430px; overflow-y: auto;">
                                            @if($data->id_csc_product != NULL)
                                                @foreach($catprod as $cp)
                                                    <?php
                                                        if($data->id_csc_product == $cp->id){
                                                            $cact = "active";
                                                        }else{
                                                            $cact = "";
                                                        }
                                                    ?>
                                                    <a href="#" class="list-group-item list-group-item-action listbag1 {{$cact}} prefent" id="kat1_{{$cp->id}}">{{$cp->nama_kategori_en}}</a>
                                                @endforeach
                                            @else
                                            Category Not Found
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                        <div id="prod2" class="list-group" style="height: 430px; overflow-y: auto;">
                                            @if($data->id_csc_product_level1 != NULL)
                                                @foreach($catprod2 as $cp1)
                                                    @if($cp1->level_1 == $data->id_csc_product)
                                                        <?php
                                                            if($data->id_csc_product_level1 == $cp1->id){
                                                                $cact1 = "active";
                                                            }else{
                                                                $cact1 = "";
                                                            }
                                                        ?>
                                                        <a href="#" class="list-group-item list-group-item-action listbag2 {{$cact1}} prefent" id="kat2_{{$cp1->id}}">{{$cp1->nama_kategori_en}}</a>
                                                    @endif
                                                @endforeach
                                            @else
                                            Category Not Found
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                        <div id="prod3" class="list-group" style="height: 430px; overflow-y: auto;">
                                            @if($data->id_csc_product_level2 != NULL)
                                                @foreach($catprod3 as $cp2)
                                                    @if($cp2->level_2 == $data->id_csc_product)
                                                        @if($cp2->level_1 == $data->id_csc_product_level1)
                                                            <?php
                                                                if($data->id_csc_product_level2 == $cp2->id){
                                                                    $cact2 = "active";
                                                                }else{
                                                                    $cact2 = "";
                                                                }
                                                            ?>
                                                            <a href="#" class="list-group-item list-group-item-action listbag3 {{$cact2}} prefent" id="kat3_{{$cp2->id}}">{{$cp2->nama_kategori_en}}</a>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @else
                                            Category Not Found
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-2" style="margin-top: 20px;"><label><b>Select</b></label></div>
                                    <div class="col-md-8" style="margin-top: 20px;">
                                        @if($data->id_csc_product != NULL)
                                            <span id="select_1">{{getNameCategoryProduct($data->id_csc_product, 'en')}}</span>
                                            <input type="hidden" name="id_csc_product" id="id_csc_product" value="{{$data->id_csc_product}}">
                                        @endif
                                        @if($data->id_csc_product_level1 != NULL)
                                            <span id="select_2">> {{getNameCategoryProduct($data->id_csc_product_level1, 'en')}}</span>
                                            <input type="hidden" name="id_csc_product_level1" id="id_csc_product_level1" value="{{$data->id_csc_product_level1}}">
                                        @endif
                                        @if($data->id_csc_product_level2 != NULL)
                                            <span id="select_3">> {{getNameCategoryProduct($data->id_csc_product_level2, 'en')}}</span>
                                            <input type="hidden" name="id_csc_product_level2" id="id_csc_product_level2" value="{{$data->id_csc_product_level2}}">
                                        @endif
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
                                        <center><span id="codenya">{{$data->code_en}}</span></center>
                                    </div>
                                    <div class="col-md-3"></div>
                                    <div class="col-md-3"></div>
                                </div><br>
                                <div class="row">
                                    <label for="code" class="col-md-2"><b>Product Name</b></label>
                                    <div class="col-md-3">
                                        <center><span id="prodname_ea">{{$data->prodname_en}}</span></center>
                                    </div>
                                    <div class="col-md-3">
                                        <center><span id="prodname_ia">{{$data->prodname_in}}</span></center>
                                    </div>
                                    <div class="col-md-3">
                                        <center><span id="prodname_ca">{{$data->prodname_chn}}</span></center>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <label for="code" class="col-md-2"><b>Category Product</b></label>
                                    <div class="col-md-3">
                                        <center><span id="cadprod_en">{{getNameCategoryProduct($data->id_csc_product, 'en')}}</span></center>
                                    </div>
                                    <div class="col-md-3">
                                        <center><span id="cadprod_in">{{getNameCategoryProduct($data->id_csc_product, 'in')}}</span></center>
                                    </div>
                                    <div class="col-md-3">
                                        <center><span id="cadprod_chn">{{getNameCategoryProduct($data->id_csc_product, 'chn')}}</span></center>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <label for="code" class="col-md-2"><b>Color</b></label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="color_en" id="color_en" autocomplete="off" value="{{$data->color_en}}" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="color_in" id="color_in" autocomplete="off" value="{{$data->color_in}}" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="color_chn" id="color_chn" autocomplete="off" value="{{$data->color_chn}}" readonly>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <label for="code" class="col-md-2"><b>Size</b></label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="size_en" id="size_en" autocomplete="off" value="{{$data->size_en}}" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="size_in" id="size_in" autocomplete="off" value="{{$data->size_in}}" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="size_chn" id="size_chn" autocomplete="off" value="{{$data->size_chn}}" readonly>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <label for="code" class="col-md-2"><b>Raw Material</b></label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="raw_material_en" id="raw_material_en" autocomplete="off" value="{{$data->raw_material_en}}" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="raw_material_in" id="raw_material_in" autocomplete="off" value="{{$data->raw_material_in}}" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="raw_material_chn" id="raw_material_chn" autocomplete="off" value="{{$data->raw_material_chn}}" readonly>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <label for="code" class="col-md-2"><b>Capacity</b></label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="capacity" id="capacity" autocomplete="off" value="{{$data->capacity}}" readonly>
                                    </div>
                                    <div class="col-md-3">
                                    </div>
                                    <div class="col-md-3">
                                    </div>
                                </div><br>
                                <div class="row">
                                    <label for="code" class="col-md-2"><b>Price (USD)</b></label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="price_usd" id="price_usd" autocomplete="off" value="{{$data->price_usd}}" readonly>
                                    </div>
                                    <div class="col-md-3">
                                    </div>
                                    <div class="col-md-3">
                                    </div>
                                </div><br>
                                <div class="row">
                                        <label for="code" class="col-md-2"><b>HS Code</b></label>
                                        <div class="col-md-9">
                                            <?php
                                                $hscodenya = NULL;
                                                if($hsco != NULL){
                                                    $hscodenya = $hsco->fullhs." - ".$hsco->desc_eng;
                                                }
                                            ?>
                                            <textarea name="hscode" id="hscode" class="form-control" readonly>{{$hscodenya}}</textarea>
                                        </div>
{{--                                        <div class="col-md-3">--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-3">--}}
{{--                                        </div>--}}
                                    </div><br>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label><b>Setting Media</b></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="code" class="col-md-2"><b>Image</b></label>
                                    <div class="col-md-2">
                                        <div id="ambil_ttd_1" style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                            <button type="button" id="img_1_view" style="width: 100%; height: 120px;" class="img_upl">
                                                @if($data->image_1 == NULL)
                                                <img src="{{url('/')}}/image/plus/plusin.png" id="image_1_ambil" style="height: 40px; width: 40px;"/>
                                                @else
                                                <img src="{{url('/')}}/uploads/Eksportir_Product/Image/{{$data->id}}/{{$data->image_1}}" style="height: 100%; width: 100%;"/>
                                                @endif
                                            </button>
                                            <input type="file" id="image_1" name="image_1" style="display: none;" />
                                            <br>
                                            <center>+ Photo 1</center>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div id="ambil_ttd_2" style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                            <button type="button" id="img_2_view" style="width: 100%; height: 120px;" class="img_upl">
                                                @if($data->image_2 == NULL)
                                                <img src="{{url('/')}}/image/plus/plusin.png" id="image_2_ambil" style="height: 40px; width: 40px;"/>
                                                @else
                                                <img src="{{url('/')}}/uploads/Eksportir_Product/Image/{{$data->id}}/{{$data->image_2}}" style="height: 100%; width: 100%;"/>
                                                @endif
                                            </button>
                                            <input type="file" id="image_2" name="image_2" style="display: none;" />
                                            <br>
                                            <center>+ Photo 2</center>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div id="ambil_ttd_3" style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                            <button type="button" id="img_3_view" style="width: 100%; height: 120px;" class="img_upl">
                                                @if($data->image_3 == NULL)
                                                <img src="{{url('/')}}/image/plus/plusin.png" id="image_3_ambil" style="height: 40px; width: 40px;"/>
                                                @else
                                                <img src="{{url('/')}}/uploads/Eksportir_Product/Image/{{$data->id}}/{{$data->image_3}}" style="height: 100%; width: 100%;"/>
                                                @endif
                                            </button>
                                            <input type="file" id="image_3" name="image_3" style="display: none;" />
                                            <br>
                                            <center>+ Photo 3</center>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div id="ambil_ttd_4" style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                            <button type="button" id="img_4_view" style="width: 100%; height: 120px;" class="img_upl">
                                                @if($data->image_4 == NULL)
                                                <img src="{{url('/')}}/image/plus/plusin.png" id="image_4_ambil" style="height: 40px; width: 40px;"/>
                                                @else
                                                <img src="{{url('/')}}/uploads/Eksportir_Product/Image/{{$data->id}}/{{$data->image_4}}" style="height: 100%; width: 100%;"/>
                                                @endif
                                            </button>
                                            <input type="file" id="image_4" name="image_4" style="display: none;" />
                                            <br>
                                            <center>+ Photo 4</center>
                                        </div>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <label for="code" class="col-md-2"><b>Minimum Selling</b></label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="minimum_order" id="minimum_order" autocomplete="off" value="{{$data->minimum_order}}" readonly>
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
                                        <textarea class="form-control" id="product_description_en" name="product_description_en" disabled>{{$data->product_description_en}}</textarea>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <label for="code" class="col-md-3"><b>Indonesia</b></label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" id="product_description_in" name="product_description_in" disabled>{{$data->product_description_in}}</textarea>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <label for="code" class="col-md-3"><b>China</b></label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" id="product_description_chn" name="product_description_chn" disabled>{{$data->product_description_chn}}</textarea>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <label for="code" class="col-md-3"><b>Show Product</b></label>
                                    <div class="col-md-9">
                                        <?php
                                            if($data->status == 0){
                                                $chck = "";
                                            }else{
                                                $chck = "checked";
                                            }
                                        ?>
                                        <input type="checkbox" {{$chck}} data-toggle="toggle" data-on="Publish" data-off="Hide" data-onstyle="info" data-offstyle="default" id="statusnya" disabled>
                                        <input type="hidden" name="status" id="status" value="{{$data->status}}"> 
                                    </div>
                                </div><br>
                                @if($data->status == 3)
                                <div class="row">
                                    <label for="code" class="col-md-3"><b>This product was rejected due to</b></label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="keterangan" rows="5" style="color: black;" readonly>{{$data->keterangan}}</textarea>
                                    </div>
                                </div><br>
                                @endif
                                <div class="row">
                                    <div class="col-md-12">
                                        <div style="float: right;">
                                            <button type="button" class="btn btn-submit" onclick="nextTab('descprod', 'infoprod')">Back</button>
                                            @if(Auth::user())
                                                <a class="btn btn-danger" href="{{url('eksportir/product_admin')}}/{{$id_profil}}">Cancel</a>
                                            @else
                                                <a class="btn btn-danger" href="{{url('eksportir/product')}}">Cancel</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        CKEDITOR.replace('product_description_en');
        CKEDITOR.replace('product_description_in');
        CKEDITOR.replace('product_description_chn');
        $('.prefent').on('click', function(event){
            event.preventDefault();
        });
        // $("#img_utama").click(function() {
        //     $("input[id='image_utama']").click();
        // });

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
            nextTab('formprod','infoprod');
            return true;
        });

        $("#hal2").on("click", function(){
            nextTab('infoprod','descprod');
            return true;
        });

        $("#hal3").on("click", function(){
            // var desc = CKEDITOR.instances.product_description_en.getData();
            // if (desc == "") {
            //     alert("Product Description is empty, Please fill in!");
            //     document.getElementById('product_description_en').focus();
            //     return false;
            // }else {
            //     $("#formnya").submit();
            // }
        });

        $("#code").focus(function(){}).blur(function(){
            $('#codenya').text(this.value);
        });

        $("#prodname_en").focus(function(){}).blur(function(){
            $('#prodname_ea').text(this.value);
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
    })

    function nextTab(now, next) {
        $('#set_'+now).removeClass('active');
        $('#set_'+next).addClass('active');

        $('.tab-pane.active').removeClass('active');
        $('#'+next).addClass('active');
    }

    function getSub(sub, idp, ids, name) {
        if(sub == 3){
            $('#select_3').text('>'+name);
            $('#id_csc_product_level2').val(ids);
            $('.listbag3').removeClass('active');
            $('#kat3_'+ids).addClass('active');
        }else{
            if(sub == 1){
                $('#select_1').text(name);
                $('#cadprod_en').text(name);
                $('#id_csc_product').val(idp);
                $('.listbag1').removeClass('active');
                $('#kat1_'+idp).addClass('active');
            }else{
                $('#select_2').text('>'+name);
                $('#id_csc_product_level1').val(ids);
                $('.listbag2').removeClass('active');
                $('#kat2_'+ids).addClass('active');
            }
            $.ajax({
                url: "{{route('eksproduct.getSub')}}",
                type: 'get',
                data: {level:sub, idparent:idp, idsub:ids},
                success:function(response){
                    // console.log(response);
                    if(sub == 1){
                        $('#prod2').html(response);
                    }else{
                        $('#prod3').html(response);
                    }
                }
            });
        }
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
