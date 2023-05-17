<?php 
session_start();

 require 'PHPMailer/PHPMailerAutoload.php';
   $mail = new PHPMailer();



?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Reset Password</title>
</head>
<body>
<div class="container">
	<div class="col-md-6">
	<div class="card">
		<div class="card-header">
			<h4>Reset Password Here</h4>
		</div>
		<div class="card-body">
			<label>Enter your email :</label>
			<input type="email" name="email" class="form-control">
			<input type="submit" name="send" value="S E N D">
		</div>
	</div>
</div>
</div>
</body>
</html>