<style>
	.button{
		background: #8bbbe8; 
		padding: 10px 12px; 
		border-radius: 3px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 16px;
		margin: 4px 2px;
		-webkit-transition-duration: 0.4s; /* Safari */
		transition-duration: 0.4s;
		cursor: pointer;
		color: black;
	}

	.button:hover{
		background: #afcde8;
	}
</style>
<div align="center" style="width: 100%">
    <div align="center" style="width: 580px;">
        <img height="100%" width="580px" src="{{url('assets')}}/assets/images/headeremail2.jpg" alt="." >
        <p style="color: #8bbbe8; font-size: 20px;text-align: left">Information</p>
        <hr>
        <p style="text-align: left">Dear {{($bur== '-')? '': $bur." "}}{{$penerima}},</P>
        <p style="text-align: left">Inquiry with subject {{$subjek}} has been Deal by Exporter {{($bu== '-')? '': $bu." "}}{{$company}}.</p>
        <p style="text-align: left"><a href="{{url('/login')}}">Click here</a> to login in application.</p>
        <br>
        <p style="text-align: left">Thanks</p>
        <!-- <a href="{{url('/login')}}" class="button">Next Log In</a> -->
        <img height="100%" width="580px" src="{{url('assets')}}/assets/images/footeremail2.jpg" alt="." >
    </div>
</div>