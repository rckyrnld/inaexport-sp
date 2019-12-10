@include('headerlog')


<!--slider area start-->
<?php 
    $loc = app()->getLocale(); 
    if($loc == "ch"){
        $lct = "chn";
    }else if($loc == "in"){
        $lct = "in";
    }else{
        $lct = "en";
    }
?>
<style>

  .table-striped > tbody > tr:nth-child(odd) {
    background-color: white!important;
    background-clip: padding-box!important;
}
.table-striped > tbody > tr:nth-child(even) {
    background-color: white!important;
    background-clip: padding-box!important;
}
.table-bordered td, .table-bordered th {
    border: transparent;
}

  </style>
  
    <!--product area start-->
    <section class="product_area" style="background-color:#ddeffd">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!--<div class="section_title">
                        <br>
                    </div> -->

                </div>
            </div>

            <div class="tab-content" id="tabing-product">
			<!--<center><br><img style="height:70px!Important;" src="{{url('assets')}}/assets/images/logo.jpg" alt="." ></center> -->
			
    <div class="py-1 text-center w-100">
	
	<h3><b>@lang("login.title2")</b></h3>
	<h6>@lang("login.title4")</h6><br>
			
		        <div class="mx-auto col-sm-4" style="background: white; border-radius: 0px;box-shadow: 4px 4px 10px 6px #888888; border: 4px; border-radius: 10px;">
	  <br>
	  <!-- <h5>LOGIN</h5> -->
	  <div class="wrap-login100" style="padding-left : 30px; padding-right : 30px; font-size:12px;">
	  
	   <form class="form-horizontal" method="POST" action="{{ route('loginei.login') }}">
           {{ csrf_field() }}
           <center><h4>@lang("login.lbl3")</h4><br></center>
             <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}" align="left">
			 <label>@lang("login.forms.email")</label>
               <input type="email" placeholder="Email" class="form-control" name="email2" style="color: #000000" value="{{ old('email') }}" required autofocus>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
			 
            <div class="form-group" align="left">
			<label>@lang("login.forms.password")</label>
              <input type="password" class="form-control" name="password2" placeholder="password" required style="color: #000000">

                  @if ($errors->has('password'))
                      <span class="help-block">
                          <strong>{{ $errors->first('password') }}</strong>
                      </span>
                  @endif
            </div>      
             <div class="form-group">
			<table width="100%">
				<tr>
				<td width="50%"></td>
				<td width="50%" align="right"><a href="{{url('forget_a')}}"><font color="blue"><b>@lang("login.forms.fp")</b></font></a></td>
				</tr>
			</table>
				
			</div>
			<div class="form-group">
            <button style="width: 100%;" type="submit" class="btn btn-primary">@lang("login.btn")</button>
			<br><br>
			@lang("login.forms.r1") <a href="{{url('pilihregister')}}">@lang("login.forms.r2")</a>
			</div>
			<br>
          </form>
        

      </div>
	  
		
      </div>
            </div>
        </div>
	<br><br>
    </section>
    <!--product area end-->

@include('footerlog')
<?php $quertreject = DB::select("select * from mst_template_reject order by id asc"); ?>
<script type="text/javascript">
	$(document).ready(function() {
    $('#example').DataTable();
} );
</script>
<script>
function xy(a){
	var token = $('meta[name="csrf-token"]').attr('content');
		$.get('{{URL::to("ambilbroad/")}}/'+a,{_token:token},function(data){
			$("#isibroadcast").html(data);
			
		 })
}
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
<script type="text/javascript">
    // $(document).ready(function () {
        
    // })
    function openTab(tabname) {
        $('.tab-pane').removeClass('active');
        $('#'+tabname).addClass('active');
    }
</script>