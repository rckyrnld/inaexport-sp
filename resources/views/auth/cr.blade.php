@include('headerlog')
  
  <div id="content-bodyz" class="product_area">
  <div class="py-1 text-center w-100">
	
	<h3><b>@lang("login.title3")</b></h3>
	<!--<h6>@lang("login.title2")</h6> -->
	<br><br><br>
      
	 
	  <center>
	  <table border="0" width="75%">
	  <tr>
	  
		  <td width="45%" align="right"><center><a href="{{url('registrasi_penjual')}}"><img style="height:170px!Important; border-radius:30px!important" src="{{url('assets')}}/assets/images/cr_eks2.png" alt="." ><br><br> <p style="font-size:100%;">@lang("login.a3") <font color="red">@lang("login.a4")</font></p></a></center></td>
	  <td width="10%" valign="center"><center><div valign="center" style="text-align:center;width: 70px; height: 70px;background: #9ec0d7;border-radius: 100%;"><b><br>- OR -</b></div></center></td>
		  <td width="45%" align="left"><center><a href="{{url('registrasi_pembeli')}}"><img style="height:170px!Important;border-radius:30px!important" src="{{url('assets')}}/assets/images/cr_imp2.png" alt="." ><br><br> <p style="font-size:100%;">@lang("login.a3") <font color="red">@lang("login.a5")</font></p></a></center></td>
	 
	  </tr>
	  </table>
	  </center>
	 
	  <br>
		
      </div>
    </div>
  </div>
@include('footerlog')