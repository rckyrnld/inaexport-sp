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
.select-dropdown {
  position: static;
}
.select-dropdown .select-dropdown--above {
      margin-top: 336px;
}
#select2-country-results{
	font-size:11px!important;
}
#select2-category-results{
	font-size:11px!important;
}
.select2-container--default{
	width:100%!important;
}

.select2-search__field{
    font-size: 10.5px!important;
}

#select2-t2s-results {
    font-size: 11px!important;
}
#select2-t3s-results {
    font-size: 11px!important;
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
                    <li><a href="{{url('')}}">@lang("login.forms.home")</a></li>
                    <li>@lang("login.forms.br")</li>
                </ul>
            </div>
            <div class="form-row" style="font-size:12px;">

                <div class="col-md-6">
                    <div class="box-body">
                        <br>
                        <img width="100%" height="10px" src="{{url('assets')}}/assets/images/07-Form-Request_01.png">
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


                    <div class="box-body" style="color:black; font-size:13px;">
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
                                    <input type="text" style="color:black;font-size:12px;" value="<?php echo $subyek; ?>" name="subyek" id="subyek"
                                           class="form-control" required>
                                </div>
                                <div class="form-group col-sm-4">
                                    <select style="color:black;font-size:12px;height: 31px;" class="form-control" name="valid" id="valid" required>
                                        <option value="">@lang("login.forms.by10")</option>
                                        <option <?php if($valid == 0){ echo "selected"; } ?> value="0">None</option>
                                        <option <?php if($valid == 1){ echo "selected"; } ?> value="1">Valid within 1 day</option>
                                        <option <?php if($valid == 3){ echo "selected"; } ?> value="3">Valid within 3 day</option>
                                        <option <?php if($valid == 5){ echo "selected"; } ?> value="5">Valid within 5 day</option>
                                        <option <?php if($valid == 7){ echo "selected"; } ?> value="7">Valid within 7 day</option>
                                        <option <?php if($valid == 14){ echo "selected"; } ?> value="14">Valid within 2 week</option>
                                        <option <?php if($valid == 30){ echo "selected"; } ?> value="30">Valid within 1 month</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-sm-12">
                                    <label><b>@lang("login.forms.by3")</b></label>
                                </div>
                                <div class="form-group col-sm-12" style="font-size: 12px !important;">
                                    <?php
                                    $ms1 = DB::select("select id,nama_kategori_en from csc_product order by nama_kategori_en asc");
                                    ?>
                                    <select style="color:black;font-size: 12px !important; " class="form-control select2 col-sm-11"  name="category[]"
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
                                    <textarea style="color:black;font-size:12px;" name="spec" id="spec"
                                              class="form-control"><?php echo $spec; ?></textarea>
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="col-sm-12">
                                    <label><b>@lang("login.forms.by5")</b></label>
                                </div>
                                
                                <div class="form-group col-sm-12">
                                    <div class="form-row">
                                        <div class="col-sm-7"><input style="color:black;font-size:12px;" value="<?php echo $eo; ?>" type="number" min="1"
                                                                     name="eo" id="eo" class="form-control"></div>
                                        <div class="col-sm-5">
                                            <select class="form-control" style="font-size:12px;height: 31px;" name="neo" id="neo">
                                                <option value="">@lang("login.forms.by14")</option>

                                                <option <?php if($neo == "Each"){ echo "selected"; } ?> value="Each">Each</option>
                                                <option <?php if($neo == "Foot"){ echo "selected"; } ?> value="Foot">Foot</option>
                                                <option <?php if($neo == "Gallons"){ echo "selected"; } ?> value="Gallons">Gallons</option>
                                                <option <?php if($neo == "Kilograms"){ echo "selected"; } ?> value="Kilograms">Kilograms</option>
                                                <option <?php if($neo == "Liters"){ echo "selected"; } ?> value="Liters">Liters</option>
                                                <option <?php if($neo == "Packs"){ echo "selected"; } ?> value="Packs">Packs</option>
                                                <option <?php if($neo == "Pairs"){ echo "selected"; } ?> value="Pairs">Pairs</option>
                                                <option <?php if($neo == "Pieces"){ echo "selected"; } ?> value="Pieces">Pieces</option>
                                                <option <?php if($neo == "Reams"){ echo "selected"; } ?> value="Reams">Reams</option>
                                                <option <?php if($neo == "Rods"){ echo "selected"; } ?> value="Rods">Rods</option>
                                                <option <?php if($neo == "Rolls"){ echo "selected"; } ?> value="Rolls">Rolls</option>
                                                <option <?php if($neo == "Sets"){ echo "selected"; } ?> value="Sets">Sets</option>
                                                <option <?php if($neo == "Sheets"){ echo "selected"; } ?> value="Sheets">Sheets</option>
                                                <option <?php if($neo == "Square Meters"){ echo "selected"; } ?> value="Square Meters">Square Meters</option>
                                                <option <?php if($neo == "Tons"){ echo "selected"; } ?> value="Tons">Tons</option>
                                                <option <?php if($neo == "Unit"){ echo "selected"; } ?> value="Unit">Unit</option>
                                                <option <?php if($neo == "令"){ echo "selected"; } ?> value="令">令</option>
                                                <option <?php if($neo == "件"){ echo "selected"; } ?> value="件">件</option>
                                                <option <?php if($neo == "加仑"){ echo "selected"; } ?> value="加仑">加仑</option>
                                                <option <?php if($neo == "包"){ echo "selected"; } ?> value="包">包</option>
                                                <option <?php if($neo == "千克"){ echo "selected"; } ?> value="千克">千克</option>
                                                <option <?php if($neo == "升"){ echo "selected"; } ?> value="升">升</option>
                                                <option <?php if($neo == "单位"){ echo "selected"; } ?> value="单位">单位</option>
                                                <option <?php if($neo == "卷"){ echo "selected"; } ?> value="卷">卷</option>
                                                <option <?php if($neo == "吨"){ echo "selected"; } ?> value="吨">吨</option>
                                                <option <?php if($neo == "套"){ echo "selected"; } ?> value="套">套</option>
                                                <option <?php if($neo == "对"){ echo "selected"; } ?> value="对">对</option>
                                                <option <?php if($neo == "平方米"){ echo "selected"; } ?> value="平方米">平方米</option>
                                                <option <?php if($neo == "张"){ echo "selected"; } ?> value="张">张</option>
                                                <option <?php if($neo == "根"){ echo "selected"; } ?> value="根">根</option>
                                                <option <?php if($neo == "每个"){ echo "selected"; } ?> value="每个">每个</option>
                                                <option <?php if($neo == "英尺"){ echo "selected"; } ?> value="英尺">英尺</option>
                                                <option <?php if($neo == "集装箱"){ echo "selected"; } ?> value="集装箱">集装箱</option>

                                            </select>
                                        </div>
                                    </div>


                                </div>
							</div>
							<div class="form-row">
							<div class="col-sm-12">
                                    <label><b>@lang("login.forms.by6")</b></label>
                                </div>
                                <div class="form-group col-sm-12">

                                    <div class="form-row">
                                        <div class="col-sm-7"><input style="color:black;font-size:12px;" type="text" value="<?php if(empty($tp)){}else{ echo number_format($tp,0,',','.'); } ?>"
                                                                     name="tp" id="tp" class="form-control amount">
																	 </div>
                                        <div class="col-sm-5"><select  style="font-size:12px;height: 31px;" class="form-control"
                                                                      name="ntp" id="ntp">
                                                <option value="">@lang("login.forms.by14")</option>
                                                <option  <?php if($ntp == "SAR"){ echo "selected"; } ?> value="SAR">Arab Saudi Riyal(SAR)</option>
                                                <option  <?php if($ntp == "BND"){ echo "selected"; } ?> value="BND">Brunei Dollar(BND)</option>
                                                <option  <?php if($ntp == "CNY"){ echo "selected"; } ?> value="CNY">China Yuan(CNY)</option>
                                                <option  <?php if($ntp == "IQD"){ echo "selected"; } ?> value="IQD">Dinar Irak(IQD)</option>
                                                <option  <?php if($ntp == "AED"){ echo "selected"; } ?> value="AED">Dirham Uni Emirat Arab(AED)</option>
                                                <option  <?php if($ntp == "USD"){ echo "selected"; } ?> value="USD">Dollar Amerika Serikat(USD)</option>
                                                <option  <?php if($ntp == "AUD"){ echo "selected"; } ?> value="AUD">Dollar Australia(AUD)</option>
                                                <option  <?php if($ntp == "HKD"){ echo "selected"; } ?> value="HKD">Dollar Hong Kong(HKD)</option>
                                                <option  <?php if($ntp == "SGD"){ echo "selected"; } ?> value="SGD">Dollar Singapura(SGD)</option>
                                                <option  <?php if($ntp == "TWD"){ echo "selected"; } ?> value="TWD">Dollar Taiwan Baru(TWD)</option>
                                                <option  <?php if($ntp == "EUR"){ echo "selected"; } ?> value="EUR">Euro(EUR)</option>
                                                <option  <?php if($ntp == "PHP"){ echo "selected"; } ?> value="PHP">Peso Filipina(PHP)</option>
                                                <option  <?php if($ntp == "GBP"){ echo "selected"; } ?> value="GBP">Pound Sterling(GBP)</option>
                                                <option  <?php if($ntp == "MYR"){ echo "selected"; } ?> value="MYR">Ringgit Malaysia(MYR)</option>
                                                <option  <?php if($ntp == "INR"){ echo "selected"; } ?> value="INR">Rupee India(INR)</option>
                                                <option  <?php if($ntp == "IDR"){ echo "selected"; } ?> value="IDR">Rupiah Indonesia(IDR)</option>
                                                <option  <?php if($ntp == "THB"){ echo "selected"; } ?> value="THB">Thai Baht(THB)</option>
                                                <option  <?php if($ntp == "VND"){ echo "selected"; } ?> value="VND">Vietnam Dong(VND)</option>
                                                <option  <?php if($ntp == "KRW"){ echo "selected"; } ?> value="KRW">Won Korea(KRW)</option>
                                                <option  <?php if($ntp == "JPY"){ echo "selected"; } ?> value="JPY">Yen Jepang(JPY)</option>


                                            </select></div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="col-sm-12">
                                    <label><b>@lang("login.forms.by7")</b></label>
                                </div>
                                <div class="form-group col-sm-6" style="font-size: 12px !important;">
                                    <?php
                                    $ms2 = DB::select("select id,country from mst_country order by country asc");
                                    ?>
                                    <select style="color:black;font-size:12px;height: 31px;" style="border-color: rgba(120, 130, 140, 0.5)!important;
    border-radius: 0.25rem!important;
    color: inherit!important; font-size: 12px!important;" class="form-control select2" name="country" id="country" required>
                                        <option value="">-- @lang("login.forms.by12") --</option>
                                        <?php foreach($ms2 as $val2){ ?>
                                        <option value="<?php echo $val2->id; ?>" style="font-size:12px;"><?php echo $val2->country; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <input style="color:black;font-size:12px;" type="text" value="" name="city" id="city"
                                           class="form-control" placeholder="@lang("login.forms.by13")">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-sm-12">
                                    <label><b>@lang("login.forms.by8")</b></label>
                                </div>
                                <div class="form-group col-sm-12">
                                    <textarea style="color:black;font-size:12px;" value="" name="ship" id="ship"
                                              class="form-control"></textarea>
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="col-sm-12">
                                    <label><b>@lang("login.forms.by9")</b></label>
                                </div>
                                <div class="form-group col-sm-12">
                                    <input style="color:black;" type="file" value="" name="doc" id="doc"
                                           class="form-controlz" required><br>
									<span><font color="red">* accept word, excel, ppt & pdf</font></span>
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="col-sm-12">
                                    <?php if($r == 2){ ?>
                                    <a disabled onclick="buk()" style="width:100%!important;"
                                            class="btn btn-md btn-success"><font color="white"><i
                                                class="fa fa-save"></i> @lang("login.btn4")</font></a>
                                    <?php }else{ ?>
                                   <!-- <button style="width:100%!important;" class="btn btn-md btn-success"><i
                                                class="fa fa-save"></i> @lang("login.btn4")</button> -->
                                        <?php if(Auth::guard('eksmp')->check()) {?>
                                            <?php // if(Auth::guard('eksmp')->user()->status == 1){ ?>
                                                <a onclick="simpanbr()"style="width:100%!important;" class="btn btn-md btn-success"><font color="white"><i
                                                        class="fa fa-save"></i> @lang("login.btn4")</i></a>

                                            <?php //}else{ ?>
                                                <!-- <a disabled onclick="bak()" style="width:100%!important;"
                                                    class="btn btn-md btn-success"><font color="white"><i
                                                        class="fa fa-save"></i> @lang("login.btn4")</font></a> -->
                                            <?php //} ?>
                                        <?php } else{ ?>
                                        <a disabled onclick="bak()" style="width:100%!important;"
                                           class="btn btn-md btn-success"><font color="white"><i
                                                        class="fa fa-save"></i> @lang("login.btn4")</font></a>
                                        <?php } ?>
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
                            <div class="modal-body">
                             <font color="black"> You Want Broadcast Buying Request Now ?</font>
                            </div>
                            <div class="modal-footer" id="mf">
							
                              <a href="{{ url('front_end/history') }}" type="button" class="btn btn-info">Go To History List</a>
                            </div>
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
<script>
function simpanbr(){
	var formData = new FormData();
	
	formData.append('subyek',$('#subyek').val());
	formData.append('valid',$('#valid').val());
	formData.append('category',$('#category').val());
	formData.append('t2s',$('#t2s').val());
	formData.append('t3s',$('#t3s').val());
	formData.append('spec',$('#spec').val());
	formData.append('eo',$('#eo').val());
	formData.append('neo',$('#neo').val());
	formData.append('tp',$('#tp').val());
	formData.append('ntp',$('#ntp').val());
	formData.append('country',$('#country').val());
	formData.append('city',$('#city').val());
	formData.append('ship',$('#ship').val());
	formData.append('_token','{{csrf_token()}}');
	formData.append('image',$('input[type=file]')[0].files[0]);
	// var token = $('meta[name="csrf-token"]').attr('content');
	if(category == ""){
		alert("Please complete the field !")
	}else{
		$.ajax({
			type: "POST",
			url: '{{url('/br_importir_save')}}',
			data: formData ,
			contentType : false,
			processData : false,
			success: function (data) {
			   console.log(data);
			   $('#mf').append(data);
			},
			error: function (data, textStatus, errorThrown) {
				console.log(data);

			},
		});
		
		
		
	$("#myModal").modal("show"); 
	}
}
    function formatAmountNoDecimals( number ) {
    var rgx = /(\d+)(\d{3})/;
    while( rgx.test( number ) ) {
        number = number.replace( rgx, '$1' + '.' + '$2' );
    }
    return number;
}

function formatAmount( number ) {

    // remove all the characters except the numeric values
    number = number.replace( /[^0-9]/g, '' );

    // set the default value
    if( number.length == 0 ) number = "0.00";
    else if( number.length == 1 ) number = "0.0" + number;
    else if( number.length == 2 ) number = "0." + number;
    else number = number.substring( 0, number.length - 2 ) + '.' + number.substring( number.length - 2, number.length );
	
    // set the precision
    number = new Number( number );
    number = number.toFixed( 2 );    // only works with the "."

    // change the splitter to ","
    number = number.replace( /\./g, '' );

    // format the amount
    x = number.split( ',' );
    x1 = x[0];
    x2 = x.length > 1 ? ',' + x[1] : '';

    return formatAmountNoDecimals( x1 ) + x2;
}


$(function() {

    $( '.amount' ).keyup( function() {
        $( this ).val( formatAmount( $( this ).val() ) );
    });

});

</script>
<script type="text/javascript">

    function buk() {
        if (confirm('You Must Login First !')) {
            window.location.href = "{{URL::to('/login')}}";
        } else {
        }
        // alert('You Need Login as Importir !');
    }
	
	function bak() {
        if (confirm('You Must Login First !')) {
            window.location.href = "{{URL::to('/login')}}";
        } else {
        }
        {{--alert('You Must Login First ! <a href="{{URL::to('/login')}}">Go to Login Page</a>');--}}
        {{--window.location.href = "{{URL::to('restaurants/20')}}"--}}
    }

    $(document).ready(function () {
        $('.select2').select2({
    dropdownPosition: 'below'
  });
        
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