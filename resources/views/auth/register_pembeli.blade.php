@include('headerlog')
  <div id="content-body" style="background-color: #c5e1f8 ; color: black" >
  <center><img height="50px" src="{{url('assets')}}/assets/images/trd.png" alt="." ></center>
    <div class="py-1 text-center w-100">
	
	<h3><b>@lang("login.title3")</b></h3>
	<br>
      <div class="mx-auto" style="width:700px;background: white; border-radius: 0px;">
	  <br>
	  <!-- <h5>LOGIN</h5> -->
	   <h5><center><b>@lang("register.title")</b></center></h5>
	  <div class="wrap-login100" style="padding-left : 70px; font-size:12px;">
	  <form class="form-horizontal" method="POST" action="{{ url('simpan_rpembeli') }}">
	   {{ csrf_field() }}
	   <center>
	  
	   <br><br>
		<div class="form-row">
							<div class="form-group col-sm-5">
                                <label>@lang("register.forms.company") </label>
                                <input type="text" name="company" id="company" class="form-control" style=" color: black; " required>
                            </div>
							<div class="form-group col-sm-2">
							&nbsp;
							</div>
                            <div class="form-group col-sm-5">
                                <label>@lang("register.forms.username")</label>
                                <input type="text" name="username" id="username" class="form-control" style=" color: black; " required>
                            </div>
                        </div>
		<div class="form-row">
							
                            <div class="form-group col-sm-5">
                                <label>@lang("register.forms.email")</label>
                                <input type="text" name="email" id="email" class="form-control" style=" color: black; " required>
                            </div>
							<div class="form-group col-sm-2">
							&nbsp;
							</div>
							<div class="form-group col-sm-5">
                                <label>@lang("register.forms.phone")</label>
                                <input type="text" name="phone" id="phone" class="form-control" style=" color: black; ">
                            </div>
                        </div>
		<div class="form-row">
                            
                            <div class="form-group col-sm-5">
                                <label>@lang("register.forms.fax")</label>
                                <input type="text" name="fax" id="fax" class="form-control" style=" color: black; ">
                            </div>
							<div class="form-group col-sm-2">
							&nbsp;
							</div>
							<div class="form-group col-sm-5">
                                <label>@lang("register.forms.website")</label>
                                <input type="text" name="website" id="website" class="form-control" style=" color: black; ">
                            </div>
                        </div>
		<div class="form-row">
                            <div class="form-group col-sm-5">
                                <label>@lang("register.forms.password")</label>
                                <input type="password" name="password" id="password" class="form-control" style=" color: black; " required>
                            </div>
							<div class="form-group col-sm-2">
							&nbsp;
							</div>
                            <div class="form-group col-sm-5">
                                <label>@lang("register.forms.re-password")</label>
                                <input type="password" name="kpassword" id="kpassword" class="form-control" style=" color: black; ">
                            </div>
                        </div>
		<div class="form-row">
                            <div class="form-group col-sm-5">
                                <label>@lang("login.forms.city")</label>
                                <input type="text" name="city" id="city" class="form-control" style=" color: black; ">
                            </div>
							<div class="form-group col-sm-2">
							&nbsp;
							</div>
                            <div class="form-group col-sm-5">
                                <label>@lang("login.forms.ct")</label>
								
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
                            <div class="form-group col-sm-5">
                                <label>@lang("register.forms.postcode")</label>
                                <input type="text" name="postcode" id="postcode" class="form-control" style=" color: black; ">
                            </div>
							<div class="form-group col-sm-2">
							&nbsp;
							</div>
                            <div class="form-group col-sm-5">
                                <label>@lang("register.forms.address")</label>
                                <textarea name="alamat" id="alamat" class="form-control" style=" color: black; "></textarea>
                            </div>
                        </div>
			
		
						
		
						
				<div class="form-row">
                            <div class="form-group col-sm-5">
                                <a href="{{url('pilihregister')}}" style="width: 100%;" class="btn btn-danger" style="border-color: #4CAF50;"><font color="white">&nbsp;&nbsp;&nbsp;Back&nbsp;&nbsp;&nbsp;</font></a>
                            
                            </div>
							<div class="form-group col-sm-2">
							&nbsp;
							</div>
                            <div class="form-group col-sm-5" align="right">
                                <button style="width: 100%;" class="btn btn-success" style="border-color: #4CAF50;"><font color="white">&nbsp;&nbsp;&nbsp;@lang("register.submit")&nbsp;&nbsp;&nbsp;</font></button>
                            </div>
                        </div>
						
		
                                
					<br>
					<br>
		</center>
		</form>
		

      </div>
	  
		
      </div>
    </div>
  </div>
  <br><br>
      
@include('footerlog')