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

$sql = "SELECT * FROM departments";
$res = mysqli_query($conn,$sql);

$sql = "SELECT * FROM departments";
$result = mysqli_query($conn,$sql);

$sql = "SELECT * FROM sub_departments";
$results = mysqli_query($conn,$sql);

$departmentName = $subDepartmentName = $department = "";
$departmentNameerr = $subDepartmentNameerr = $departmenterr = $err = $error = $mssg = $message = $errs = $e = $er = "";
//creating new department
if (isset($_POST['submit'])) {
	if (empty($_POST['departmentName'])) {
		$departmentNameerr = "Please Enter The Department Name";
	}else{
		$departmentName = trim($_POST['departmentName']);
		$sql ="SELECT * FROM departments WHERE departmentName = '$departmentName'";
		$q = mysqli_query($conn,$sql);
		$count = mysqli_num_rows($q);
		if (mysqli_num_rows($q)>0) {
			$e = "The department '".$departmentName."' Already exists";
		}else{
		
	}
}

	if (empty($departmentNameerr)&&empty($e)) {
		$sql = "INSERT INTO departments (departmentName) VALUES ('$departmentName')";
		$query = mysqli_query($conn,$sql);
		if ($query) {
			$mssg = "Department '".$departmentName."' Added Successfully";
			// header("location:departments.php");
			unset($_POST['submit']);
		}else{
			$err = "Ooops! Something went wrong. Please try Again";
		}
	}else{
		$error = "Please clear the error department first";
	}
}

//creating new sub department
if (isset($_POST['Submit'])) {
	if (empty($_POST['department'])) {
		$departmenterr = "Please Enter The Department Name";
	}else{
		$department = trim($_POST['department']);
}
	if (empty($_POST['subDepartmentName'])) {
		$subDepartmentNameerr = "Please Enter The sub-Department Name";
	}else{
		$subDepartmentName = trim($_POST['subDepartmentName']);
		$sql ="SELECT * FROM sub_departments WHERE subDepartmentName = '$subDepartmentName'";
		$qe = mysqli_query($conn,$sql);
		$count = mysqli_num_rows($qe);
		if (mysqli_num_rows($qe)>0) {
			$er = "The sub-department '".$subDepartmentName."' Already exists";
		}else{
		
	}
	}
	if (empty($departmenterr)&& empty($subDepartmentNameerr)&&empty($er)) {
		$sql = "INSERT INTO sub_departments (department,subDepartmentName) VALUES ('$department','$subDepartmentName')";
		$query = mysqli_query($conn,$sql);
		if ($query) {
			$message = "sub-Department '".$subDepartmentName."' Added Successfully";
// 				echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" style="position:sticky">
// <strong>sub-Department Added Successfully</strong>
// <button type="button" class="close" data-dismiss="alert" aria-label="Close">
// <span aria-hidden="true">&times;</span>
// </button>
// </div>';
			// header("location:departments.php");
		}else{
			$errs = "Ooops! Something went wrong. Please try Again";
		}
	}else{
		$errors = "Please clear the error department and sub-department first";
	}
}
// edit department

// if (isset($_GET['edit'])) {
// $id = $_GET['edit'];
	
// 	$_SESSION['id'] = $id;

$department = $de = $message="";
if (isset($_POST['edit'])) {
	$id = trim($_POST['id']);
	if (empty(trim($_POST['department']))) {
		$de = "Enter the department name";
	}else{
		$department = trim($_POST['department']);
	}
	if (empty($de)) {
		// $id = $_SESSION['id'];
		$sql = "UPDATE departments SET departmentName ='$department' WHERE id=$id";
		$query = mysqli_query($conn,$sql);
		if ($query) {
			$message = "Department updated Successfully";
			header("location:departments.php");
		}
	}
// unset($_POST['edit']);
}
// }

?>
<!DOCTYPE html>
<html>
<head>
	<title>Departments page</title>
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
		<div class="row">
		<div class="column col-md-6">
		<!-- <div class="col-md-6"> -->
    		<div class="card mx-auto mb-2">
    			<div class="card-header">
    				<h4 class="text-center text-dark font-weight-bold">Add New Department Here</h4>
    			</div>
    			<div class="card-body">
    				<form method="post" action="">
    					
    					<span class="text-danger font-weight-bold"><?php echo $err;?></span>
    					<span class="text-success font-weight-bold"><?php echo $mssg;?></span><br>
       					<label class="font-weight-bold">Enter Department Name :</label>
    					<input type="text" name="departmentName" placeholder="Enter Department Name" class="form-control">
    					<span class="text-danger font-weight-bold"><?php echo $e;?></span>
       					<span class="text-danger font-weight-bold"><?php echo $departmentNameerr;?></span><br>
    					<input type="submit" name="submit" class="btn btn-primary" value="Submit The Department">
    				</form>
    			</div>
    		</div>
    	<!-- </div> -->
    	<!-- <div class="col-md-6"> -->
    		<div class="card mx-auto mb-2">
    			<div class="card-header">
    				<h4 class="text-center text-dark font-weight-bold">Add New Sub-Department Here</h4>
    			</div>
    			<div class="card-body">
    				<form method="post" action="">
    					<span class="text-success font-weight-bold"><?php echo $message;?></span><br>
    					<label class="font-weight-bold">Select Department :</label>
    					<select name="department" class="form-control">
    						<option value="">-select department-</option>
    						<?php 
    						while ($rows = $res->fetch_assoc()) {
    							?>
    						<option><?php echo $rows['departmentName'];?></option>
    						<?php 
    					}
    					?>
    					</select>
    					<span class="text-danger font-weight-bold"><?php echo $departmenterr;?></span><br>
    					<label class="font-weight-bold">Enter Sub-Department Name :</label>
    					<input type="text" name="subDepartmentName" placeholder="Enter Department Name" class="form-control" value="">
    					<span class="text-danger font-weight-bold"><?php echo $subDepartmentNameerr;?></span>
    					<span class="text-danger font-weight-bold"><?php echo $er;?></span><br>
       					<input type="submit" name="Submit" class="btn btn-primary" value="Submit The Sub-Department">
    				</form>
    			</div>
    		</div>
    	</div>
    <!-- </div> -->
    <div class="col-md-6">
    <div class="card">
    	<div class="card-header">
    		<h4 class="text-center font-weight-bold" style="text-transform: uppercase;">Systems Department</h4>
    	</div>
    	<div class="card-body">
    		<div class="table-responsive">
    			<table class="table table-bordered table-dark table-striped table-hover">
    				<thead>
    					<tr><h3 class="font-weight-bold text-success"><?php echo $message;?></h3></tr>
    					<tr>
    						<td class="text-center font-weight-bold">#</td>
    						<td class="text-center font-weight-bold">Department Name</td>
    						<td class="text-center font-weight-bold" colspan="2">Actions</td>
    					</tr>
    				</thead>
    				<tbody>
    					<?php while($row=$result->fetch_assoc()){
    						
    						?>
    						<tr>
    						<td class="text-center"><?php echo $row['id'];?></td>
    						<td class="text-center" id="name"><?php echo $row['departmentName'];?></td>
    						<td class="text-center"><a href="departments.php?edit=<?php echo $row['id'];?>" id="edit" name="edit" data-toggle="modal" data-target="#exampleModal<?php echo $row['id'];?>" class="btn btn-primary">Edit</a></td>
    						<td class="text-center"><a href="#" class="btn btn-danger" onClick="return confirm('Are you sure you want do delete? Department <?php echo $row['departmentName'];?>')">Delete</a></td>
    					</tr>
    					<!-- Edit Department details Modal -->
							<div class="modal fade" id="exampleModal<?php echo $row['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  <div class="modal-dialog" role="document">
							    <div class="modal-content">
							      <div class="modal-header">
							        <h5 class="modal-title text-dark" id="exampleModalLabel">Edit department</h5>
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <span aria-hidden="true">&times;</span>
							        </button>
							      </div>
							      <div class="modal-body">
							      	<form method="post" action="">
							      		<!-- <?php echo $row['id'];?> -->
							      		<input type="number" name="id" class="form-control" value="<?php echo $row['id'];?>">
							      		<label class="font-weight-bold">Department Name :</label>

							      		<input type="text" name="department" class="form-control" value="<?php echo $row['departmentName'];?>
							      		">
							      	
							      		<!-- <span><?php echo $de ?></span> -->
							      		
							      	</div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                 
							        <a href="departments.php" name="edit"><input type="submit" name="edit" value="Edit" class="btn btn-primary"></a>
							        </form>

                                </div>
                            </div>
                        </div>
                    </div>
    					<?php }
    					?>
    				</tbody>
    			</table>
    		</div>
	</div>
	<div class="card-header">
    					<h4 class="text-center font-weight-bold" style="text-transform: uppercase;">Systems sub-Department</h4>
    				</div>
    					<div class="card-body">
    		<div class="table-responsive">
    			<table class="table table-bordered table-dark table-striped table-hover">
    				<thead>
    					<tr>
    						<td class="text-center font-weight-bold">#</td>
    						<td class="text-center font-weight-bold">Sub-Department Name</td>
    						<td class="text-center font-weight-bold" colspan="2">Actions</td>
    					</tr>
    				</thead>
    				<tbody>
    					<?php while($row=$results->fetch_assoc()){
    						?>
    						<tr>
    						<td class="text-center"><?php echo $row['id'];?></td>
    						<td class="text-center"><?php echo $row['subDepartmentName'];?></td>
    						<td class="text-center"><a href="#"  data-toggle="modal" data-target="#Modal<?php echo $row['id'];?>" class="btn btn-primary">Edit</a></td>
    						<td class="text-center"><a href="#" class="btn btn-danger" onClick="return confirm('Are you sure you want do delete? sub-Department <?php echo $row['subDepartmentName'];?>')">Delete</a></td>
    					</tr>
    					
    					<!-- Edit sub-department details Modal -->
							<div class="modal fade" id="Modal<?php echo $row['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  <div class="modal-dialog" role="document">
							    <div class="modal-content">
							      <div class="modal-header">
							        <h5 class="modal-title text-dark" id="exampleModalLabel">Edit Sub-department</h5>
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <span aria-hidden="true">&times;</span>
							        </button>
							      </div>
							      <div class="modal-body">
							      	<form method="post" action="">
							      		<label class="font-weight-bold">Department Name :</label>
							      		<input type="text" name="department" class="form-control" value="<?php echo $row['department'];?>">
							      		<label class="font-weight-bold">Sub-Department Name :</label>
							      		<input type="text" name="subDepartment" class="form-control" value="<?php echo $row['subDepartmentName'];?>">

							      	
							      	</div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                 
							        <a href="departments.php" name="change"><input type="submit" name="change" value="Edit" class="btn btn-primary"></a>
							        </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }?>
    				</tbody>
    			</table>
    		</div>
	</div>

</div>
</div>

							
                    	

</body>
<script type="text/javascript">
	// $("$edit").click(function(){
	// 	var name = $("#name").val();
	// 	// var str = name;
	// 	$("#value").html(name);
	// });
</script>
<script src="bootstrap/jquery/jquery-3.5.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="bootstrap/popper/popper.min.js"></script>
</html>
