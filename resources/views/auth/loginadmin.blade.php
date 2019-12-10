@include('headerlog')
  
      <section class="product_area" style="background-color:#c5e1f8">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!--<div class="section_title">
                        <br>
                    </div> -->

                </div>
            </div>

            <div class="tab-content" id="tabing-product">
			<center><br><img style="height:70px!Important;" src="{{url('assets')}}/assets/images/logo.jpg" alt="." ></center>
    <div class="py-1 text-center w-100">
	
	<h3><b>@lang("login.title2")</b></h3>
	<h6>@lang("login.title4")</h6>
	<br>
      <div class="mx-auto col-sm-4" style="background: white; border-radius: 0px;box-shadow: 4px 4px 10px 6px #888888; border: 4px; border-radius: 10px;">
	  <br>
	  <!-- <h5>LOGIN</h5> -->
	  <div class="wrap-login100" style="padding-left : 30px; padding-right : 30px; font-size:12px;">
	  
	   <form class="form-horizontal" method="POST" action="{{ route('login') }}">
           {{ csrf_field() }}
           <h4>@lang("login.lbl3")</h4><br>
             <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}" align="left">
			 <label>@lang("login.forms.email")</label>
               <input type="email" placeholder="Email" class="form-control" name="email" style="color: #000000" value="{{ old('email') }}" required autofocus>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
			 
            <div class="form-group" align="left">
			<label>@lang("login.forms.password")</label>
              <input type="password" class="form-control" name="password" placeholder="password" required style="color: #000000">

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
			
			</div>
			<br>
          </form>
        

      </div>
	  
		
      </div><br><br>
     </div>
        </div>
	<br><br>
    </section>
@include('footerlog')