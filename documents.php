<?php 
session_start();
if(!isset($_SESSION["loggedin"]) && $_SESSION["email"] != true){
    header("location:login");
    exit;
}

if (isset($_SESSION['success'])) {
	$success = "Document updated successfully";
	$err = "";
	unset($_SESSION['success']);
}else{
	$success = $err = $user_type = "";
}
$conn = mysqli_connect('localhost','root','','edms');
if (!$conn) {
	die("Could not connect to the database");
}

$sql = "SELECT * FROM documents";
$res = mysqli_query($conn,$sql);
if (isset($_GET['delete'])) {
	$id = $_GET['delete'];

	$sql = "SELECT * FROM documents WHERE id = '$id'";
	$req = mysqli_query($conn,$sql);
	// if
	while ($ro = $req->fetch_assoc()) {
		$document_name = $ro['document_name'];
	}
	$sql = "SELECT * FROM users WHERE email = '".$_SESSION["email"]."'";
	$query = mysqli_query($conn,$sql);
	while($r = $query->fetch_assoc()){
		$r['user_type'] = $user_type;
	}
	if ($user_type != 'SupperAdmin') {
		$err = "You don't have rights to delete this document";
	}else{
	$sql = "DELETE FROM documents WHERE id ='$id'";
	$r = mysqli_query($conn,$sql);
	if ($r) {
header("location:documents.php?document deleted successfully");
		$message = "Document deleted successfully";
		echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" style="position:sticky">
<strong> "'.$message.'"</strong>
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>';


	}else{
		echo "document could not be deleted...problem occured";
	}
}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>EDMS DOCUMENTS PAGE</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <style>
    header{
    		background: url(ccms.jpg);
    		background-repeat: no-repeat;
    		background-size: cover;
    		background-attachment: fixed;
    	}
    </style>
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

	<div class="container-fluid">
<div class="table-responsive">
	<table class="table table-striped table-bordered table-dark table-hover ">
		<thead>
			<tr>
				<th colspan="9" class="font-weight-bold text-center">All System Documents</th>
			</tr>
			<tr>
				<th class="font-weight-bold text-center"><a href="index.php"><button class="btn btn-success font-weight-bold">Back To Dashboard</button></a></th>
				<th colspan="8"><span class=""><?php 
				echo '<div class="text-success font-weight-bold">'.$success.'</div>';
echo '<div class="text-danger font-weight-bold">'.$err.'</div>';
?>
</span>
			</th>

			</tr>
			<tr>
				<td class="font-weight-bold text-center">#</td>
				<td class="font-weight-bold text-center">Document Name</td>
				<td class="font-weight-bold text-center">Document Department</td>
				<td class="font-weight-bold text-center">Document Sub-department</td>
				<td class="font-weight-bold text-center">Document Description</td>
				<td class="font-weight-bold text-center" colspan="4">Actions</td>
			</tr>
		</thead>
		<tbody>
			<?php 
			while ($rows=$res->fetch_assoc()) {
			?>
			<tr>
				<td class="font-weight-bold text-center"><?php echo $rows['id']?></td>
				<td class="font-weight-bold text-center"> <?php echo $rows['document_name']?></td>
				<td class="font-weight-bold text-center"> <?php echo $rows['document_department']?></td>
				<td class="font-weight-bold text-center"> <?php echo $rows['document_sub_department']?></td>
				<td class="font-weight-bold text-center"> <?php echo $rows['document_description']?></td>
				<td class="font-weight-bold text-center"><a href="viewdoc?view=<?php echo $rows['id'];?>" name="view"><button class="btn btn-secondary font-weight-bold"> View</button></a></td>
				<td class="font-weight-bold text-center"><a href="update?update=<?php echo $rows['id'];?>" name="update"><button name="update" class="btn btn-primary font-weight-bold"> Update</button></a></td>
				<td class="font-weight-bold text-center"><a href="documents?print=<?php echo $rows['id'];?>" name="print"><button class="btn btn-warning font-weight-bold"> Print</button></a></td>
				<td class="font-weight-bold text-center"><a href="documents?delete=<?php echo $rows['id'];?>" onClick="return confirm('Are you sure you want do delete?')" name="delete"><buttton class="btn btn-danger font-weight-bold" >Delete</buttton></a></td>

			</tr>
		<?php }
		?>
		</tbody>
	</table>
</div>
</div>
</body>
<script src="bootstrap/jquery/jquery-3.5.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="bootstrap/popper/popper.min.js"></script>
</html>