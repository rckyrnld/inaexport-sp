@include('headerlog')
  
  <div id="content-body" style="background-color: #c5e1f8 ; color: black" >
  <center><img height="50px" src="{{url('assets')}}/assets/images/trd.png" alt="." ></center>
    <div class="py-1 text-center w-100">
	
	<h3><b>@lang("login.title2")</b></h3>
	
	<br>
      <div class="mx-auto" style="width:400px;background: white; border-radius: 0px;">
	  <br>
	  <!-- <h5>LOGIN</h5> -->
	  <div class="wrap-login100" style="padding-left : 30px; padding-right : 30px; font-size:12px;">
	  
	   <form class="form-horizontal" method="POST" action="{{ url('resetpass') }}">
           {{ csrf_field() }}
           <h4>@lang("login.lbl4")</h4><br>
             <div class="form-group">
            <select class="form-control" id="id_role" name="id_role" style="color:black;" >
				<option value="1">Exporter/Importer</option>
				<option value="2">Perwakilan</option>
			</select>
        </div>
		
		<div class="form-group">
               <input id="email" type="email" placeholder="Email" class="form-control" name="email" style="color: #000000" value="" required="" autofocus="">

        </div>
		<div class="form-group">
		<center><button style="width: 100%;" type="submit" class="btn primary">@lang("login.btn2")</button></center>
		</div>
			<br>
          </form>
        

      </div>
	  
		
      </div>
    </div>
  </div>
@include('footerlog')