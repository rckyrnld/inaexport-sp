@include('frontend.layouts.header')


<!--slider area start-->
<?php
$loc = app()->getLocale();
if ($loc == "ch") {
    $lct = "chn";
} else if ($loc == "in") {
    $lct = "in";
} else {
    $lct = "en";
}
?>
<style>

    .table-striped > tbody > tr:nth-child(odd) {
        background-color: white !important;
        background-clip: padding-box !important;
    }

    .table-striped > tbody > tr:nth-child(even) {
        background-color: white !important;
        background-clip: padding-box !important;
    }

    .table-bordered td, .table-bordered th {
        border: transparent;
    }

</style>
<!--product area start-->
<section class="product_area mb-50">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section_title">
                    <br>
                </div>

            </div>
        </div>

        <div class="tab-content" id="tabing-product">
            <div class="breadcrumb_content">
                <ul>
                    <li><a href="{{url('front_end')}}">@lang("login.forms.home")</a></li>
                    <li>@lang("login.forms.br")</li>
                </ul>
            </div>
            <div class="form-row" style="font-size:12px;">

                <div class="col-md-6">
                    <div class="box-body">
                        <br>
                        <img width="100%" height="10px" src="{{url('assets')}}/assets/images/07-Form-Request_01.png"
                             alt=".">
                        <div style="font-size:17px;padding-left:10px;padding-right:10px;"><p><b>@lang("login.lbl5")</b>
                            </p>
                            <p style="font-size:16px;">@lang("login.lbl6") <br> @lang("login.lbl7")
                                <br> @lang("login.lbl8")</p>

                        </div>
                    


                    </div>

                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-5">


                    <div class="box-body">
                        <br>
						
                        <form class="form-horizontal" method="POST" action="{{ url('br_importir_save') }}"
                              enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-row">
                                <div class="col-sm-12">
                                    <label><h5><b>@lang("login.forms.by1")</b></h5></label>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-sm-12">
                                    <label><b>@lang("login.forms.by2")</b></label>
                                </div>
                                <div class="form-group col-sm-8">
                                    <input type="text" style="color:black;" value="" name="subyek" id="subyek"
                                           class="form-control" required>
                                </div>
                                <div class="form-group col-sm-4">
                                    <select style="color:black;" class="form-control" name="valid" id="valid" required>
                                        <option value="">@lang("login.forms.by10")</option>
                                        <option value="0">Nan</option>
                                        <option value="1">Valid within 1 day</option>
                                        <option value="3">Valid within 3 day</option>
                                        <option value="5">Valid within 5 day</option>
                                        <option value="7">Valid within 7 day</option>
                                        <option value="14">Valid within 2 week</option>
                                        <option value="30">Valid within 1 month</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-sm-12">
                                    <label><b>@lang("login.forms.by3")</b></label>
                                </div>
                                <div class="form-group col-sm-12">
                                    <?php
                                    $ms1 = DB::select("select id,nama_kategori_en from csc_product order by nama_kategori_en asc");
                                    ?>
                                    <select style="color:black;" class="form-control select2" multiple name="category[]"
                                            id="category" onchange="t1()" required>
                                        <option value="">@lang("login.forms.by11")</option>
                                        <?php foreach($ms1 as $val1){ ?>
                                        <option value="<?php echo $val1->id; ?>"><?php echo $val1->nama_kategori_en; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                            </div>
                            <div id="t2">
                                <input type="hidden" name="t2s" id="t2s" value="0">
                            </div>
                            <div id="t3">
                                <input type="hidden" name="t3s" id="t3s" value="0">
                            </div>
                            <div class="form-row">
                                <div class="col-sm-12">
                                    <label><b>@lang("login.forms.by4")</b></label>
                                </div>
                                <div class="form-group col-sm-12">
                                    <textarea style="color:black;" value="" name="spec" id="spec"
                                              class="form-control"></textarea>
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="col-sm-6">
                                    <label><b>@lang("login.forms.by5")</b></label>
                                </div>
                                <div class="col-sm-6">
                                    <label><b>@lang("login.forms.by6")</b></label>
                                </div>
                                <div class="form-group col-sm-6">
                                    <div class="form-row">
                                        <div class="col-sm-7"><input style="color:black;" type="number" min="1"
                                                                     name="eo" id="eo" class="form-control"></div>
                                        <div class="col-sm-5">
                                            <select class="form-control select2" name="neo" id="neo">
                                                <option value="">@lang("login.forms.by14")</option>

                                                <option value="Each">Each</option>
                                                <option value="Foot">Foot</option>
                                                <option value="Gallons">Gallons</option>
                                                <option value="Kilograms">Kilograms</option>
                                                <option value="Liters">Liters</option>
                                                <option value="Packs">Packs</option>
                                                <option value="Pairs">Pairs</option>
                                                <option value="Pieces">Pieces</option>
                                                <option value="Reams">Reams</option>
                                                <option value="Rods">Rods</option>
                                                <option value="Rolls">Rolls</option>
                                                <option value="Sets">Sets</option>
                                                <option value="Sheets">Sheets</option>
                                                <option value="Square Meters">Square Meters</option>
                                                <option value="Tons">Tons</option>
                                                <option value="Unit">Unit</option>
                                                <option value="令">令</option>
                                                <option value="件">件</option>
                                                <option value="加仑">加仑</option>
                                                <option value="包">包</option>
                                                <option value="千克">千克</option>
                                                <option value="升">升</option>
                                                <option value="单位">单位</option>
                                                <option value="卷">卷</option>
                                                <option value="吨">吨</option>
                                                <option value="套">套</option>
                                                <option value="对">对</option>
                                                <option value="平方米">平方米</option>
                                                <option value="张">张</option>
                                                <option value="根">根</option>
                                                <option value="每个">每个</option>
                                                <option value="英尺">英尺</option>
                                                <option value="集装箱">集装箱</option>

                                            </select>
                                        </div>
                                    </div>


                                </div>
                                <div class="form-group col-sm-6">

                                    <div class="form-row">
                                        <div class="col-sm-7"><input style="color:black;" type="number" min="1" value=""
                                                                     name="tp" id="tp" class="form-control"></div>
                                        <div class="col-sm-5"><select style="color:black;" class="form-control"
                                                                      name="ntp" id="ntp">
                                                <option value="">@lang("login.forms.by14")</option>
                                                <option value="IDR">IDR</option>
                                                <option value="THB">THB</option>
                                                <option value="USD">USD</option>
                                            </select></div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="col-sm-12">
                                    <label><b>@lang("login.forms.by7")</b></label>
                                </div>
                                <div class="form-group col-sm-6">
                                    <?php
                                    $ms2 = DB::select("select id,country from mst_country order by country asc");
                                    ?>
                                    <select style="color:black;" style="border-color: rgba(120, 130, 140, 0.5)!important;
    border-radius: 0.25rem!important;
    color: inherit!important;" class="form-control select2" name="country" id="country" required>
                                        <option value="">-- @lang("login.forms.by12") --</option>
                                        <?php foreach($ms2 as $val2){ ?>
                                        <option value="<?php echo $val2->id; ?>"><?php echo $val2->country; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <input style="color:black;" type="text" value="" name="city" id="city"
                                           class="form-control" placeholder="@lang("login.forms.by13")">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-sm-12">
                                    <label><b>@lang("login.forms.by8")</b></label>
                                </div>
                                <div class="form-group col-sm-12">
                                    <textarea style="color:black;" value="" name="ship" id="ship"
                                              class="form-control"></textarea>
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="col-sm-12">
                                    <label><b>@lang("login.forms.by9")</b></label>
                                </div>
                                <div class="form-group col-sm-12">
                                    <input style="color:black;" type="file" value="" name="doc" id="doc"
                                           class="form-controlz" required>
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="col-sm-12">
                                    <?php if($r == 2){ ?>
                                    <button disabled onclick="buk()" style="width:100%!important;"
                                            class="btn btn-md btn-success"><i
                                                class="fa fa-save"></i> @lang("login.btn4")</button>
                                    <?php }else{ ?>
                                    <button style="width:100%!important;" class="btn btn-md btn-success"><i
                                                class="fa fa-save"></i> @lang("login.btn4")</button>
                                    <?php } ?>
                                </div>


                            </div>
                        </form>
                    </div>
                </div>


                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:#2e899e; color:white;"><h6>Broadcast
                                    Buying Request</h6>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">&times;</button>

                            </div>
                            <div id="isibroadcast"></div>
                            <!--<div class="modal-body">
                              1
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div> -->
                        </div>
                    </div>
                </div>

            <!--<a href="{{ url('br_importir_add') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add Buying Request</a><br><br> -->

            </div>

        </div>
    </div>
</section>
<!--product area end-->

@include('frontend.layouts.footer')
<?php $quertreject = DB::select("select * from mst_template_reject order by id asc"); ?>
<script type="text/javascript">
    function buk() {
        alert('This Form Only For Importir !');
    }

    $(document).ready(function () {
        $('.select2').select2();
        $('#example').DataTable();
    });
</script>
<script>
    function xy(a) {
        var token = $('meta[name="csrf-token"]').attr('content');
        $.get('{{URL::to("ambilbroad/")}}/' + a, {_token: token}, function (data) {
            $("#isibroadcast").html(data);

        })
        $('.cobas2').select2();


    }

    function t1() {
        $('#t2').html('');
        $('#t3').html('');
        var t1 = $('#category').val();
        var token = $('meta[name="csrf-token"]').attr('content');
        $.get('{{URL::to("ambilt2/")}}/' + t1, {_token: token}, function (data) {
            $("#t2").html(data);
            $("#t3").html('<input type="hidden" name="t3s" id="t3s" value="0">');
            $('.select2').select2();

        })
    }

    function t2() {
        $('#t3').html('');
        var t2 = $('#t2s').val();
        var token = $('meta[name="csrf-token"]').attr('content');
        $.get('{{URL::to("ambilt3/")}}/' + t2, {_token: token}, function (data) {
            $("#t3").html(data);
            $('.select2').select2();

        })
    }

    function nv() {
        var a = $('#staim').val();
        if (a == 2) {
            $('#sh1').html('<div class="form-row"><div class="form-group col-sm-4"><label><b>Alasan Reject</b></label></div><div class="form-group col-sm-8"><select onchange="ketv()" id="template_reject" name="template_reject" class="form-control"><option value="">-- Pilih Alasan Reject --</option><?php foreach($quertreject as $qr){ ?><option value="<?php echo $qr->id;?>"><?php echo $qr->nama_template;?></option><?php } ?></select></div></div>')
        } else {
            $('#sh1').html(' ');
            $('#sh2').html(' ');
        }
    }

    function ketv() {
        var a = $('#template_reject').val();
        if (a == 1) {
            $('#sh2').html('<div class="form-row"><div class="form-group col-sm-4"><label><b>Keterangan Reject</b></label></div><div class="form-group col-sm-8"><textarea class="form-control" id="txtreject" name="txtreject"></textarea></div></div>')
        }
    }

    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>
<script type="text/javascript">
    // $(document).ready(function () {

    // })
    function openTab(tabname) {
        $('.tab-pane').removeClass('active');
        $('#' + tabname).addClass('active');
    }
</script>