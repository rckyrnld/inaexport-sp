<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		a{text-decoration: none;}
		body{ font-family: 'Arial'; }
		#messages{font-size: 16px;}
	</style>
</head>
<body>
	<div style="margin: 0% 18% 0% 18%;">
		<img src="{{url('/').'/assets/assets/images/headeremail2.jpg'}}" style="width: 100%;"><br>
		<h2 style="color: skyblue;">Information</h2><hr>
		<span id="messages">
			<?php echo $messages; ?>
		</span>
		@if($file != null)
			<center><img src="{{url('/').'/uploads/Newsletter/File/'.$file}}" style="width: 100%;"></center>
		@endif
		<br>
		<center>Anda mendapat email ini karena terdaftar sebagai <b>newsletter</b> kami.</center><br>
		<center><a href="{{route('newsletter.unsubscribe',$email_unsub)}}" style="font-weight: 600;" target="_blank"><span style="color: red;">Unsubscribe</span> <span style="color: blue;">newsletter</span></a></center>
		<img src="{{url('/').'/assets/assets/images/footeremail2.jpg'}}" style="width: 100%; margin-top: 10px;"><br>
	</div>
</body>
</html>