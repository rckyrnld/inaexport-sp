@include('headerlog')
  <div id="content-body" style="background-color: #c5e1f8 ; color: black" >
  <a href="{{url('/')}}"><center><br><img style="height:70px!Important;" src="{{url('assets')}}/assets/images/logo.jpg" alt="." ></center></a>
    <div class="py-1 text-center w-100">
	
	<h3><b>@lang("login.title3")</b></h3>
	<br>
      <div class="mx-auto col-sm-7" style="background: white; border-radius: 0px;">
	  <br>
	  <!-- <h5>LOGIN</h5> -->
	   <h5><center><b>@lang("register2.title")</b></center></h5>
	  <div class="wrap-login100" style="padding-left : 70px;padding-right : 70px; font-size:12px;">
	  <form class="form-horizontal" method="POST" action="{{ url('simpan_rpenjual') }}">
	   {{ csrf_field() }}
	   <center>
	  
	   <br><br>
		<!-- <div class="form-row">
							<div class="form-group col-sm-6">
                                <label>NPWP</label>
                                <input type="text" name="npwp" id="npwp" class="form-control" style=" color: black; ">
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Nama Pemilik NPWP</label>
                                <input type="text" name="namanpwp" id="namanpwp" class="form-control" style=" color: black; " readonly>
                            </div>
                        </div> -->
						<div class="form-row">
							<div class="form-group col-sm-5" align="left">
                                <label>@lang("register2.forms.company")</label>
                                <input type="text" name="company" id="company" class="form-control" style=" color: black; " required>
                            </div>
							<div class="form-group col-sm-2">
							&nbsp;
							</div>
                            <div class="form-group col-sm-5" align="left">
                                <label>@lang("register2.forms.username")</label>
                                <input type="text" name="username" id="username" class="form-control" style=" color: black; " required>
                            </div>
                        </div>
		<div class="form-row">
							
                            <div class="form-group col-sm-5" align="left">
                                <label>@lang("register2.forms.email")</label> &nbsp;&nbsp;&nbsp;<span id="cekmail"></span>
                                <input type="text" onkeyup="cekmail()" name="email" id="email" class="form-control" style=" color: black; " required>
                            </div>
							<div class="form-group col-sm-2">
							&nbsp;
							</div>
							<div class="form-group col-sm-5" align="left">
                                <label>@lang("register2.forms.phone")</label>
                                <input type="text" name="phone" id="phone" class="form-control" style=" color: black; " >
                            </div>
                        </div>
		<div class="form-row">
                            
                            <div class="form-group col-sm-5" align="left">
                                <label>@lang("register2.forms.fax")</label>
                                <input type="text" name="fax" id="fax" class="form-control" style=" color: black; ">
                            </div>
							<div class="form-group col-sm-2">
							&nbsp;
							</div>
							<div class="form-group col-sm-5" align="left">
                                <label>@lang("register2.forms.website")</label>
                                <input type="text" name="website" id="website" class="form-control" style=" color: black; ">
                            </div>
                        </div>
		<div class="form-row">
                            <div class="form-group col-sm-5" align="left">
                                <label>@lang("register2.forms.password")</label>
                                <input type="password" name="password" id="password" class="form-control" style=" color: black; " required>
                            </div>
							<div class="form-group col-sm-2">
							&nbsp;
							</div>
                            <div class="form-group col-sm-5" align="left">
                                <label>@lang("register.forms.re-password")</label>
                                <input type="password" name="kpassword" id="kpassword" class="form-control" style=" color: black; ">
                            </div>
                        </div>
		<div class="form-row">
                            <div class="form-group col-sm-5" align="left">
                                <label>@lang("login.forms.city")</label>
                                <input type="text" name="city" id="city" class="form-control" style=" color: black; ">
                            </div>
							<div class="form-group col-sm-2">
							&nbsp;
							</div>
                            <div class="form-group col-sm-5" align="left">
                                <label>@lang("login.forms.prov")</label>
								
                                <select class="form-control" name="prov" id="prov">
									<option value="">- Choose Province -</option>
									<?php
                                                        $qc = DB::select("select id,province_en from mst_province order by province_en asc");
                                                        foreach($qc as $cq){
                                                        ?>
                                                        <option value="<?php echo $cq->id; ?>"><?php echo $cq->province_en; ?></option>

                                                        <?php } ?>
								</select>
                            </div>
                        </div>
		<div class="form-row">
                            <div class="form-group col-sm-5" align="left">
                                <label>@lang("register.forms.postcode")</label>
                                <input type="text" name="postcode" id="postcode" class="form-control" style=" color: black; ">
                            </div>
							<div class="form-group col-sm-2">
							&nbsp;
							</div>
                            <div class="form-group col-sm-5" align="left">
                                <label>@lang("register.forms.address")</label>
                                <textarea name="alamat" id="alamat" class="form-control" style=" color: black; "></textarea>
                            </div>
                        </div>
		
						
				<div class="form-row">
                            <div class="form-group col-sm-5">
                                <!-- <a href="{{url('pilihregister')}}" style="width: 100%;" class="btn btn-danger" style="border-color: #4CAF50;"><font color="white">&nbsp;&nbsp;&nbsp;Back&nbsp;&nbsp;&nbsp;</font></a> -->
                            
                            </div>
							<div class="form-group col-sm-2">
							&nbsp;
							</div>
                            <div class="form-group col-sm-5" align="right">
							<a style="width: 100%;" class="btn btn-success" style="border-color: #4CAF50;" onclick="simpanpenjual()"><font color="white">&nbsp;&nbsp;&nbsp;@lang("register.submit")&nbsp;&nbsp;&nbsp;</font></a>
                           
                                <!-- <button style="width: 100%;" class="btn btn-success" style="border-color: #4CAF50;"><font color="white">&nbsp;&nbsp;&nbsp;@lang("register.submit")&nbsp;&nbsp;&nbsp;</font></button> -->
                            </div>
                        </div>
						
		
                                
					
		</center>
		</form>
		

      </div>
	  
		
      </div>
    </div><br>
					<br>
  </div>
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#2e899e; color:white;"> <h6>Attention</h6>
          <button type="button" class="btn btn-danger" data-dismiss="modal">&times;</button>
         
        </div>
		
        <div class="modal-body">
          <h5><center><br>
			<img style="height:80px!important;" src="{{url('assets')}}/assets/images/mail.png" alt="." ><br><br>
			Check your mail for activate account !
			</center></h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
 <script>
 function cekmail(){
	 var m = $('#email').val();
	 var token = $('meta[name="csrf-token"]').attr('content');
        $.get('{{URL::to("cekmail/")}}/' + m, {_token: token}, function (data) {
            if(data == 0){
				$('#cekmail').html("<font color='green'>( Available )</font>");
				
			}else{
				$('#cekmail').html("<font color='red'>( Has Been Used ! )</font>");
				alert("Sorry The Mail Has Been Used");
				$('#email').val("");
			}
			

        })
	 //alert(m);
	 //$('#cekmail').html("<font color='red'>( Has Been Used ! )</font>");
 }
function simpanpenjual(){
	var company = $('#company').val();
	var username = $('#username').val();
	var email = $('#email').val();
	var phone = $('#phone').val();
	var fax = $('#fax').val();
	var website = $('#website').val();
	var password = $('#password').val();
	var city = $('#city').val();
	var prov = $('#prov').val();
	var postcode = $('#postcode').val();
	var alamat = $('#alamat').val();
	var token = $('meta[name="csrf-token"]').attr('content');
	if(company == ""){
		alert("Please complete the field !")
	}else{
		/*
		$.post('{{url('/simpan_rpenjual')}}',{company:company,username:username,email:email,phone:phone,fax:fax,password:password,city:city,prov:prov,postcode:postcode,alamat:alamat,_token:token},function (data) {
		 	
		 });
		*/
		$.ajax({
			type: "POST",
			url: '{{url('/simpan_rpenjual')}}',
			data: { company:company,username:username,email:email,website:website,phone:phone,fax:fax,password:password,city:city,prov:prov,postcode:postcode,alamat:alamat,_token:'{{csrf_token()}}' },
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
		$('#prov').val('');
		$('#postcode').val('');
		$('#alamat').val('');
	$("#myModal").modal("show");
	}
}
 </script>
      
@include('footerlog')