<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		a{text-decoration: none;}
		body{ font-family: 'Arial'; }
	</style>
</head>
<body>
	<?php echo $messages; ?>
	@if($file != null)
		<center><img src="{{url('/').'/uploads/Newsletter/File/'.$file}}" style="width: 60%;"></center>
	@endif
	<br>
	<center>Anda mendapat email ini karena terdaftar sebagai <b>newsletter</b> kami.</center><br>
	<center><a href="{{route('newsletter.unsubscribe',$email_unsub)}}" style="font-weight: 600;" target="_blank"><span style="color: red;">Unsubscribe</span> <span style="color: blue;">newsletter</span></a></center>
</body>
</html>