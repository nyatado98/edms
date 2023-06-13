<?php 
session_start();

if(!isset($_SESSION["loggedin"]) && $_SESSION["email"] != true){
    header("location:login");
    exit;
}

$conn = mysqli_connect('localhost','root','','edms');
if (!$conn) {
	echo "Could not connect to the database";
}

$message = "";
if (isset($_POST['update'])) {
	$fullname = trim($_POST['fullname']);
	$email = trim($_POST['email']);
	$phone_no = trim($_POST['phone_no']);
	$password = password_hash(trim($_POST['password']),PASSWORD_DEFAULT); //hash password

	$sql = "UPDATE users SET fullname = '$fullname', email = '$email', phone_no= '$phone_no', password='$password' WHERE email = '".$_SESSION["email"]."'";
	$result = mysqli_query($conn,$sql);
	if ($result) {
		$message = "User details updated successfully";
	}
}
	
	?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/fontawesome.min.css">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Profile page</title>
	<style type="text/css">
    	header{
    		background: url(ccms.jpg);
    		background-repeat: no-repeat;
    		background-size: cover;
    		background-attachment: fixed;
    	}
    </style>
</head>
<body>
	<header class="mb-0">
        <div id="logo" class="col-md-12">
            <!-- <img src="" height="60" width="40"> -->
        </div>
        <h1 class="text-center font-weight-bold text-dark">EDMS</h1>
    </header>
    <nav class="navbar navbar-expand-lg col-md-12 navbar-dark bg-dark sticky-top">
         <a class="navbar-brand font-weight-bold" id="index" href="#">EXAMPLE EDMS</a>
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
            <div class="collapse navbar-collapse" id="navbarNav">
           <ul class="navbar-nav mx-5">
               <li class="nav-item active">
                    <a class="nav-link" href="index">HOME</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="documents">DOCUMENTS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="departments">DEPARTMENTS</a>
                </li>
				<?php 
				$sql = "SELECT * FROM users WHERE email = '".$_SESSION['email']."'";
				$query = mysqli_query($conn,$sql);
while($row=$query->fetch_assoc()) {
    if($row['user_type'] == 'SupperAdmin') {
        ?>
					<li class="nav-item">
                    <a class="nav-link" href="users">USERS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logs">SYSTEM LOGS</a>
                </li>
				<?php

} else {

}
}
			?>
                <li class="nav-item">
                    <a class="nav-link" href="logout">LOGOUT</a>
                </li>
            </ul>
			<div class="dropdown">
			<a class="font-weight-bold dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="" style="text-decoration:none;color:teal"><?php echo $_SESSION['email'];?>  <i class="fa fa-user" style="color:white;font-size:20px"></i></a>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="settings">Settings</a>
    <a class="dropdown-item" href="profile">Profile</a>
    <a class="dropdown-item" href="logout">Logout</a>
  </div>
</div>
</div>
</nav>
<div class="container col-md-6">
	<div class="card">
		<div class="card-header">
			<h4 class="text-center font-weight-bold">Personal Details</h4>
		</div>
		<?php 
		$sql = "SELECT * FROM users WHERE email = '".$_SESSION["email"]."'";
$query = mysqli_query($conn,$sql);
		while($row = $query->fetch_assoc()){


			?>
		<div class="card-body">
			<span class="alert alert-success font-weight-bold alert-dismissible fade show" role="alert" style="position:sticky"><?php 
if(isset($_POST['update'])){
			echo $message;
		}else{
}
			?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
			</span><br>
			<form method="post" action="">
			<label class="font-weight-bold mt-2">FULL NAME :</label>
			<input type="text" name="fullname" placeholder="Your full name" class="form-control" value="<?php echo $row['fullname'];?>">
			<label class="font-weight-bold">EMAIL :</label>
			<input type="email" name="email" placeholder="Your email" class="form-control" value="<?php echo $row['email'];?>" readonly>
			<label class="font-weight-bold"> TEL :</label>
			<input type="number" name="phone_no" placeholder="Your phone number"  class="form-control" value="<?php echo $row['phone_no'];?>">
			<label class="font-weight-bold">PASS :</label>
			<input type="password" name="password" placeholder="Your secret" class="form-control" value="<?php echo $row['password'];?>">
			<input type="submit" name="update" value="U P D A T E" class="btn btn-primary font-weight-bold mt-2 form-control">
			</form>	
		</div>
	<?php }
	?>
	</div>
</div>
</body>
  <script src="bootstrap/jquery/jquery-3.5.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="bootstrap/popper/popper.min.js"></script>
</html>