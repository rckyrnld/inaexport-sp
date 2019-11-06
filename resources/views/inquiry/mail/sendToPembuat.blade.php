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
<p style="color: #8bbbe8; font-size: 20px;">Information</p>
<hr>
<p>Dear {{$company}},</P>
<p>There are responses that have been made by the eksporters, please look immediately.</p>
<p>To knows, please enter the Trade.id application with an account that is already registered.</p>
<br>
<a href="{{url('/login')}}" class="button">Next Log In</a>
