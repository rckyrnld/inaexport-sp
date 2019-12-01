<?php // echo bcrypt('abc');die(); ?>
@include('header')
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                

                <div class="box-body bg-light">
                   
                    <div class="col-md-14">
                        <div class="">
						

<style>
body {font-family: Arial;}

.select2-container--default .select2-selection--single {
    background-color: #fff!important;
    border: 1px solid rgba(120, 130, 140, 0.5)!important;
    border-radius: 4px!important;
}


/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 8px 10px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
</style>



<form class="form-horizontal" method="POST" action="{{ url('br_save') }}" enctype="multipart/form-data">
           {{ csrf_field() }}


<div class="form-row">
<div class="col-md-6">
   <div class="box-body">
   <br><br>
  
	<div class="form-row">
		<div class="col-sm-12">
		<label><b>What are you looking for</b></label>
		</div>
		<div class="form-group col-sm-8">
			<input type="text" value="" name="cmp" id="cmp" class="form-control" >
		</div>
		<div class="form-group col-sm-4">
			<select class="form-control" name="valid" id="valid">
			<option value="0">None</option>
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
		<label><b>Category</b></label>
		</div>
		<div class="form-group col-sm-12">
			<?php 
			$ms1 = DB::select("select id,nama_kategori_en from csc_product order by nama_kategori_en asc");
			?>
			<select class="form-control select2" multiple name="category[]" id="category" onchange="t1()">
			<option value="">-- Select Category --</option>
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
		<label><b>Specification</b></label>
		</div>
		<div class="form-group col-sm-12">
			<textarea value="" name="spec" id="spec" class="form-control" ></textarea>
		</div>
		
	</div>
	
	<div class="form-row">
		<div class="col-sm-6">
		<label><b>Estimated order quantity</b></label>
		</div>
		<div class="col-sm-6">
		<label><b>Targeted price (Estimated total)</b></label>
		</div>
		<div class="form-group col-sm-6">
			<div class="form-row">
		<div class="col-sm-7"><input type="number" name="eo" id="eo" class="form-control"> </div>
		<div class="col-sm-5"> 
		<select class="form-control select2" name="neo" id="neo">
		 
                  											                    											  <option value="Each">Each</option>
                  											                    											  <option value="Foot">Foot</option>
                  											                    											  <option value="Gallons">Gallons</option>
                  											                    											  <option value="Kilograms">Kilograms</option>
                  											                    											  <option value="Liters">Liters</option>
                  											                    											  <option value="Packs">Packs</option>
                  											                    											  <option value="Pairs">Pairs</option>
                  											  		                                      <option value="Pieces" selected="selected">Pieces</option>
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
		
		</select></div>
		</div>
			
                                  </select>
			
		</div>
		<div class="form-group col-sm-6">
				
			<div class="form-row">
		<div class="col-sm-7"><input type="text" value="" name="tp" id="tp" class="amount form-control" ></div>
		<div class="col-sm-5"> <select class="form-control" name="ntp" id="ntp"><option value="IDR">IDR</option><option value="USD">USD</option><option value="THB">THB</option></select></div>
		</div>
		</div>
		
	</div>
  
	</div>

</div>
<div class="col-md-6">
<div class="box-body">
<br><br>
<div class="form-row">
		<div class="col-sm-12">
		<label><b>Location of delivery</b></label>
		</div>
		<div class="form-group col-sm-6">
			<?php 
			$ms2 = DB::select("select id,country from mst_country order by country asc");
			?>
			<select style="border-color: rgba(120, 130, 140, 0.5)!important;
    border-radius: 0.25rem!important;
    color: inherit!important;" class="form-control select2" name="country" id="country">
			<option value="">-- Select Country --</option>
			<?php foreach($ms2 as $val2){ ?>
			<option value="<?php echo $val2->id; ?>"><?php echo $val2->country; ?></option>
			<?php } ?>
			</select>
		</div>
		<div class="form-group col-sm-6">
			<input type="text" value="" name="city" id="city" class="form-control" placeholder="City/State">
		</div>
	</div>
<div class="form-row">
		<div class="col-sm-12">
		<label><b>Shipping & Payment conditions</b></label>
		</div>
		<div class="form-group col-sm-12">
			<textarea value="" name="ship" id="ship" class="form-control" ></textarea>
		</div>
		
	</div>
<div class="form-row">
		<div class="col-sm-12">
		<label><b>Add attachment (Relevant to  a request)</b></label>
		</div>
		<div class="form-group col-sm-12">
			<input type="file" value="" name="doc" id="doc" class="form-control" >
		</div>
		
	</div>

</div>
</div>



<div class="col-sm-12">
<div align="right">
<button class="btn btn-md btn-primary"><i class="fa fa-save"></i> Submit</button>
<a href="{{ url('verifyimportir') }}" class="btn btn-md btn-danger"><i class="fa fa-arrow-left"></i> Cancel</a>


</div>
</div>
</form>
<?php $quertreject = DB::select("select * from mst_template_reject order by id asc"); ?>
<script>
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
<script>
function t1(){
	$('#t2').html('');
	$('#t3').html('');
	var t1 = $('#category').val();
	var token = $('meta[name="csrf-token"]').attr('content');
		$.get('{{URL::to("ambilt2/")}}/'+t1,{_token:token},function(data){
			$("#t2").html(data);
			$("#t3").html('<input type="hidden" name="t3s" id="t3s" value="0">');
			 $('.select2').select2();
			
		 })
}
function t2(){
	$('#t3').html('');
	var t2 = $('#t2s').val();
	var token = $('meta[name="csrf-token"]').attr('content');
		$.get('{{URL::to("ambilt3/")}}/'+t2,{_token:token},function(data){
			$("#t3").html(data);
			 $('.select2').select2();
			
		 })
}
function nv(){
	var a = $('#staim').val();
	if(a == 2){
		$('#sh1').html('<div class="form-row"><div class="form-group col-sm-4"><label><b>Alasan Reject</b></label></div><div class="form-group col-sm-8"><select onchange="ketv()" id="template_reject" name="template_reject" class="form-control"><option value="">-- Pilih Alasan Reject --</option><?php foreach($quertreject as $qr){ ?><option value="<?php echo $qr->id;?>"><?php echo $qr->nama_template;?></option><?php } ?></select></div></div>')
	}else{
		$('#sh1').html(' ');
		$('#sh2').html(' ');
	}
}
function ketv(){
	var a = $('#template_reject').val();
	if(a == 1){
		$('#sh2').html('<div class="form-row"><div class="form-group col-sm-4"><label><b>Keterangan Reject</b></label></div><div class="form-group col-sm-8"><textarea class="form-control" id="txtreject" name="txtreject"></textarea></div></div>')
	}
}
$(document).ready(function () {
        $('.select2').select2();
});
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
  

                            
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@include('footer')
