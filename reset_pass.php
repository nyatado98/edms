<?php 
session_start();
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'edms');
 
/* Attempt to connect to MySQL database */
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($conn === false){
    die("ERROR: Could not connect. ");
}
$password = $repassword="";
$passworderr = $repassworderr= $err="";

if(isset($_GET['edit'])){
	$id = $_GET['edit'];
	if(isset($_POST['send'])){
		if(empty(trim($_POST['password']))){
			$passworderr = "Please enter password";
		}else{
			$password = trim($_POST['password']);
		}
		if(isset($_POST['send'])){
			if(empty(trim($_POST['repassword']))){
				$repassworderr = "Please Re-enter password";
			}else{
				$repassword = trim($_POST['repassword']);
			}
			if($repassword != $password){
				$err = "The password doesnot match";
			}
			$hash_password = password_hash($password, PASSWORD_DEFAULT);
			if(empty($passworderr) && empty($repassworderr) && empty($err)){
				$sql= "UPDATE users SET password = '$hash_password' WHERE id = '$id'";
				$results = mysqli_query($conn,$sql);
				header("location:login");
			}
		}
	}
}


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
			<form action="" method="post">
			<label>Enter your password :</label>
			<input type="password" name="password" class="form-control">
			<span><?php echo $passworderr;?></span>
			<label>Confirm your password :</label>
			<input type="password" name="repassword" class="form-control">
			<span><?php echo $repassworderr;?></span>
			<span><?php echo $err;?></span>
			<input type="submit" name="send" value="R E S E T">
</form>
		</div>
	</div>
</div>
</div>
</body>
</html>