<?php 
session_start();
if(!isset($_SESSION["loggedin"]) && $_SESSION["email"] != true){
    header("location:login.php");
    exit;
}

if (isset($_SESSION['success'])) {
	$success = "Document updated successfully";
	unset($_SESSION['success']);
}else{
	$success = "";
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
                    <a class="nav-link" href="index.PHP">HOME</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="documents.php">DOCUMENTS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="departments.php">DEPARTMENTS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="users.php">USERS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="settings.php">SETTINGS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">LOGOUT</a>
                </li>
            </ul>
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
				<th colspan="8"><span class="text-success font-weight-bold"><?php echo $success;?></th>

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
				<td class="font-weight-bold text-center"><a href="viewdoc.php?view=<?php echo $rows['id'];?>" name="view"><button class="btn btn-secondary font-weight-bold"> View</button></a></td>
				<td class="font-weight-bold text-center"><a href="update.php?update=<?php echo $rows['id'];?>" name="update"><button name="update" class="btn btn-primary font-weight-bold"> Update</button></a></td>
				<td class="font-weight-bold text-center"><a href="documents.php?print=<?php echo $rows['id'];?>" name="print"><button class="btn btn-warning font-weight-bold"> Print</button></a></td>
				<td class="font-weight-bold text-center"><a href="documents.php?delete=<?php echo $rows['id'];?>" onClick="return confirm('Are you sure you want do delete?')" name="delete"><buttton class="btn btn-danger font-weight-bold" >Delete</buttton></a></td>

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