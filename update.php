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
$success = $err =  "" ;

    $sql = "SELECT * FROM departments";
	$re = mysqli_query($conn,$sql);

	$sql = "SELECT * FROM sub_departments";
	$result = mysqli_query($conn,$sql);
	
	if (isset($_GET['update'])) {
	$id = $_GET['update'];
$_SESSION['id'] = $id;
	$sql = "SELECT * FROM documents WHERE id ='$id'";
	$results = mysqli_query($conn,$sql);

    						while ($row =$results->fetch_assoc()) {
    							 $document_name = $row['document_name'];
    							 $document_department = $row['document_department'];
    							 $document_sub_department = $row['document_sub_department'];
    							 $document_description = $row['document_description'];
    
}}
if (isset($_POST['save'])) {
	$id = $_SESSION['id'];
	$document_name = $_POST['document_name'];
	$document_department = $_POST['document_department'];
	$document_sub_department = $_POST['document_sub_department'];
	$document_description = $_POST['document_description'];

		$sql = "UPDATE documents SET document_name ='$document_name',document_department ='$document_department',document_sub_department ='$document_sub_department',document_description ='$document_description' WHERE id=$id";
		$r = mysqli_query($conn,$sql);
		if ($r) {
				$_SESSION['success'] = $success;
				$_SESSION['err'] = $err;
			$success = "Document updated successfully";
			$err = "";
		header("location:documents");
		}
	}
	
    						
    	
    						
    				
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
    <div class="container">
    	<div class="card">
    		<div class="card-header">
    			<h4>UPDATE YOUR DOCUMENTS DETAILS</h4>
    		</div>
    		<div class="card-body">
    			<form method="post" action="">
 
						</span><br>
						    					<label class="font-weight-bold">Document name  :</label>
    					

    					<input type="text" name="document_name" placeholder="Enter Document Name" class="form-control" value="<?php echo $document_name;?>">
    					
    					<label class="font-weight-bold">Select Department :</label>
    					<select name="document_department" class="form-control">
    						<option class=""><?php echo $document_department;?></option>
    						<?php while ($row=$re->fetch_assoc()) { ?>
    						<option><?php echo $row['departmentName'];?></option>
    						<?php }?>
    						
    					</select>
    					
    					<label class="font-weight-bold">Select Sub-department :</label>
    					<select name="document_sub_department" class="form-control">
    						<option><?php echo $document_sub_department;?></option>
    						<?php while ($row=$result->fetch_assoc()) { ?>
    						<option><?php echo $row['subDepartmentName'];?></option>
    						<?php }?>
    					</select>
    					<label class="font-weight-bold">Enter Document Description :</label>
    						
    					<textarea name="document_description" placeholder="Describe the document" maxlength="100" class="form-control"><?php echo $document_description;?></textarea>
    				
    					<input type="submit" name="save" class="btn btn-primary" value="Update The Document">
    				</form>
    			</div>
    		</div>
    	</div>

</body>
</html>