@include('headerlog')
  
  <div id="content-body" style="background-color: #c5e1f8 ; color: black" >
  <center><br><img height="70px" src="{{url('assets')}}/assets/images/logo.jpg" alt="." ></center>
    <div class="py-1 text-center w-100">
	
	<h3><b>@lang("login.title3")</b></h3>
	<!--<h6>@lang("login.title2")</h6> -->
	<br>
      
	  <div class="col-md-12">
	  <center>
	  <table border="0" width="75%">
	  <tr>
	  
	  <td width="45%" align="right"><center><a href="{{url('registrasi_penjual')}}"><img height="320px" src="{{url('assets')}}/assets/images/cr_imp.png" alt="." ><br><br> @lang("login.a3") <font color="red">@lang("login.a4")</font></a></center></td>
	  <td width="10%" valign="center"><center><div valign="center" style="text-align:center;width: 70px; height: 70px;background: #9ec0d7;border-radius: 100%;"><b><br>- OR -</b></div></center></td>
	  <td width="45%" align="left"><center><a href="{{url('registrasi_pembeli')}}"><img height="320px" src="{{url('assets')}}/assets/images/cr_eks.png" alt="." ><br><br> @lang("login.a3") <font color="red">@lang("login.a5")</font></a></center></td>
	 
	  </tr>
	  </table>
	  </center>
	 
	  
		
      </div>
    </div>
  </div>
@include('footerlog')