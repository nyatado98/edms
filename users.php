<?php 
session_start();

if(!isset($_SESSION["loggedin"]) && $_SESSION["email"] != true){
    header("location:login");
    exit;
}
$conn = mysqli_connect('localhost','root','','edms');
if (!$conn) {
	die("Could not connect to the database");
}

	$sql = "SELECT * FROM users";
	$result = mysqli_query($conn,$sql);
	//edit a spesific user
	$message = "";
	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$fullname = $_POST['fullname'];
		$email = $_POST['email'];
		$phone_no = $_POST['phone_no'];
		$password = password_hash(trim($_POST['password']),PASSWORD_DEFAULT); //hash password
		$sql = "UPDATE users SET fullname = '$fullname', email = '$email', phone_no = '$phone_no', password='$password' WHERE id='$id'";
		$query =mysqli_query($conn,$sql);
		if($query){
			$message = "User successfully updated";
			header("location:users");
		}else{
			$message = "Something went wrong please try again";
		}
	}

	//update users details
// 	if (isset($_POST['edit'])) {
// 	$fullname = trim($_POST['fullname']);
// 	$email = trim($_POST['email']);
// 	$phone_no = trim($_POST['phone_no']);
// 	$password = password_hash(trim($_POST['password']),PASSWORD_DEFAULT); //hash password

// 	$sql = "UPDATE users SET fullname = '$fullname', email = '$email', phone_no= '$phone_no', password='$password' WHERE id='$id'";
// 	$result = mysqli_query($conn,$sql);
// 	if ($result) {
// 		$message = "User details updated successfully";
// 	}
// }
?>
<!DOCTYPE html>
<html>
<head>
	 <style>
    header{
    		background: url(ccms.jpg);
    		background-repeat: no-repeat;
    		background-size: cover;
    		background-attachment: fixed;
    	}
    </style>
	<title>Update Documents</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<header>
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
                    <a class="nav-link" href="logout.php">LOGOUT</a>
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
    <div class="container-fluid">
    	<h5 class="text-center font-weight-bold">System Users</h5>
    	<div class="table-responsive">
    	<table class="table table-striped table-bordered table-dark table-hover">
    		<thead>
				<tr>
					<td class="text-success font-weight-bold"><?php echo $message;?></td>
				</tr>
    			<tr>
    				<td class="text-center font-weight-bold">#</td>
    				<td class="text-center font-weight-bold">Fullname</td>
    				<td class="text-center font-weight-bold">User Email</td>
    				<td class="text-center font-weight-bold">User Phone</td>
    				<td class="text-center font-weight-bold" colspan="2">Actions</td>
    			</tr>
    		</thead>
    		<tbody>
    			<?php 
    			while ($rows = $result->fetch_assoc()) {
    			?>
    			<tr>
    				<td class="text-center"><?php echo $rows['id'];?></td>
    				<td class="text-center"><?php echo $rows['fullname'];?></td>
    				<td class="text-center"><?php echo $rows['email'];?></td>
    				<td class="text-center"><a href="tel:<?php echo $rows['phone_no'];?>"><?php echo $rows['phone_no'];?></a></td>
    				<td class="text-center"><a href="" class="btn btn-primary"  data-toggle="modal" data-target="#exampleModal<?php echo $rows['id'];?>" >Edit</a></td>
    				<td class="text-center"><a href="" class="btn btn-danger">Delete</a></td>
    			</tr>
    			<!-- Edit Department details Modal -->
							<div class="modal fade" id="exampleModal<?php echo $rows['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  <div class="modal-dialog" role="document">
							    <div class="modal-content">
							      <div class="modal-header">
							        <h5 class="modal-title text-dark" id="exampleModalLabel">Edit User Details</h5>
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <span aria-hidden="true">&times;</span>
							        </button>
							      </div>
							      <div class="modal-body">
							      	<form method="post" action="">
							      		<input type="number" name="id" class="form-control" value="<?php echo $rows['id'];?>" hidden>
							      		<label class="font-weight-bold">Fullname :</label>
							      		<input type="text" name="fullname" class="form-control" value="<?php echo $rows['fullname'];?>
							      		">
							      		<label class="font-weight-bold">Email :</label>
							      		<input type="email" name="email" class="form-control" value="<?php echo $rows['email'];?>
							      		">
							      		<label class="font-weight-bold">Phone number :</label>
							            
							            <input type="number" name="phone_no" class="form-control" value="<?php echo $rows['phone_no'];?>">
							            <input type="password" name="password" class="form-control" value="<?php echo $rows['password'];?>">
							      		
							      	</div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                 
							        <a href="users" name="edit"><input type="submit" name="edit" value="Update" class="btn btn-primary"></a>
							        </form>

                                </div>
                            </div>
                        </div>
                    </div>
    		<?php }?>
    		</tbody>
    	</table>
    </div>

</body>
  <script src="bootstrap/jquery/jquery-3.5.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="bootstrap/popper/popper.min.js"></script>
</html>