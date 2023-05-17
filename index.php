<?php 
session_start();

if(!isset($_SESSION["loggedin"]) && $_SESSION["email"] != true){
    header("location:login.php");
    exit;
}

$conn = mysqli_connect('localhost','root','','edms');
if (!$conn) {
	die("Could not connect to the database");
}

$sql = "SELECT * FROM departments";
$res = mysqli_query($conn,$sql);

$sql = "SELECT * FROM sub_departments";
$result = mysqli_query($conn,$sql);





 $docname = $docFile = $docName = $department = $subDepartment = $docDesc = $message = '';
 $docerr = $docFileerr = $docNameerr = $departmenterr = $subDepartmenterr = $docDescerr = $messageerr = $err = '';
// $errors = array();
 $errors = " ";
if (isset($_POST['search'])) {
	if (empty($_POST['docname'])) {
		$docerr = "Enter the document name please";
	}else{
		$docname = trim($_POST['docname']);
	}
	if (empty($docerr)) {
		$sql ="SELECT * FROM documents WHERE document_name = '$docname'";
		$r = mysqli_query($conn,$sql);
		$count = mysqli_num_rows($r);
		if ($count>0) {
			$_SESSION['docname'] = $docname;
			
		}else{
			$err = "No document with that name found";
			}
		}
}

if (isset($_POST['upload'])) {
	// if (empty($_POST['docFile'])) {
	// 	$docFileerr = "Please select a document file";
	// }else{
	$name = $_FILES['docFile']['name'];
	if (empty($name)) {
		$docFileerr = "Please select a document file";
	}else{
		
    $target = "document_files/";
    $target_file =$target . basename($_FILES["docFile"]["name"]);
    $fileName = basename($_FILES["docFile"]["name"]);
    $file_size = $_FILES["docFile"]["size"];
    $file_type = $_FILES["docFile"]["type"];
    $tmp_name = $_FILES['docFile']['tmp_name'];
    $file_ext = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    $extensions = array("jpeg","jpg","png","gif","mp3","mp4","pdf","txt","doc","jfif","docx","zip");
    if (!in_array($file_ext, $extensions)) {
    	$errors = "The file type is not allowed...Please choose another file";
    }
    if ($file_size < 0) {
    	$errors = "The file size is invalid...choose another file";
    }
}
	
	if (empty($_POST['docName'])) {
		$docNameerr = "Please enter a document Name";
	}else{
		$docName = trim($_POST['docName']);
	}
	if (empty($_POST['department'])) {
		$departmenterr = "Please select a department";
	}else{
		$department = trim($_POST['department']);
	}
	if (empty($_POST['subDepartment'])) {
		$subDepartmenterr = "Please select a subDepartment";
	}else{
		$subDepartment = trim($_POST['subDepartment']);
	}
	if (empty($_POST['docDesc'])) {
		$docDescerr = "Please enter the document description";
	}else{
		$docDesc = trim($_POST['docDesc']);
	}

	date_default_timezone_set('Africa/Nairobi');
        $date_added=strtotime("current");
        $date_added = date('Y/m/d  H:i:sa');
        $round = round((((time() - (int)date(strtotime("current")))/60)/60)/24). 'day(s) ago';
	if (empty($docFileerr)&&empty($docNameerr)&&empty($docNameerr)&&empty($departmenterr)&&empty($subDepartmenterr)&&empty($docDescerr)) {
		$sql = "INSERT INTO documents (document_file,document_name,document_department,document_sub_department,document_description,date_added) VALUES('$fileName','$docName','$department','$subDepartment','$docDesc','$date_added')";
		$re =mysqli_query($conn,$sql);
		if ($re) {
			 move_uploaded_file($tmp_name,$target.$name);
			$message = "Document successfully Addded";
			unset($_POST['upload']);
			header("location:index.php");
		}else{
			$messageerr = "Document could not be added";
		}
	}
	$conn->close();

}
//delete document
if (isset($_GET['del'])) {
	$document_name = $_GET['del'];

	$sql = "DELETE FROM documents WHERE document_name = '$document_name'";
	$r = mysqli_query($conn,$sql);
	if ($r) {
		header("location:index.php?document deleted");
		unset($document_name);
	}
	
}
?>
<!DOCTYPE html>
<html>
<head>
	<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
	<title>EDMS HOME PAGE</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    <a class="nav-link" href="logs.php">SYSTEM LOGS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">LOGOUT</a>
                </li>
            </ul>
</div>
    </nav>
    
    	<div class="container-fluid mb-2">
    		<h4 class="font-weight-bold m-2">Search Your Document Here</h4>
    		
    		<form method="post" action="">
    			<span class="text-danger font-weight-bold"><?php echo $docerr;?></span>
    			<span class="text-danger font-weight-bold"><?php echo $err;?></span>
    		<div class="row m-2">
    		<input type="text" name="docname" placeholder="Enter the document name" class="col-md-5 form-control mb-2">
    		<input type="submit" name="search" class="btn btn-primary col-md-3 mx-1 font-weight-bold text-dark" value="SEARCH">
    	</div>
    </form>
    	</div>
    	<div class="container-fluid">
    	<div class="row">
    		<div class="col-md-7">
    		<div class="card mb-2">
    			<div class="card-header">
    				<h4 class="font-weight-bold text-center text-dark">View Your Documents Here</h4>
    			</div>
    			<?php 

if (isset($_POST['search'])) {
	if (empty($_POST['docname'])) {
		$docerr = "Enter the document name please";
	}else{
		$docname = trim($_POST['docname']);
	}
	if (empty($docerr)) {
		$sql ="SELECT * FROM documents WHERE document_name = '$docname'";
		$r = mysqli_query($conn,$sql);
		$count = mysqli_num_rows($r);
		if ($count>0) {
			while ($row = $r->fetch_assoc()) {
		
		// else{
		// 	$err = "No document with that name found";
		// 	}
				$document_name =$row['document_name'];
		 

    			
    			?>
    			<div class="card-body">
    				<!-- <p><?php echo $row['document_name'];?></p> -->
    			<!-- <img style="height: 500px" src="<?php echo 'document_files/' .$row['document_file'];?>"alt="" class="img-fluid" width="800px"> -->
    			<iframe style="height: 500px;width: 800px" src="<?php echo 'document_files/'.$row['document_file'];?>" class="img-fluid"></iframe>
    			</div>
    		<?php }}}
    	}
    		?>
    			<div class="card-footer">
    				<form method="post" action="">
    				<div class="row">
    					
    					<a href="index.php?del=<?php (!isset($_POST['search']))? print_r(""): print_r($document_name);?>" onClick="return confirm('Are you sure you want do delete?')" name="del"><buttton class="btn btn-danger font-weight-bold" >Delete</buttton></a>
    					<a href="index.php?print=<?php echo $docname;?>" name="print"><buttton class="btn btn-primary font-weight-bold mx-2" >Print</buttton></a>
    					<a href="index.php?export=<?php echo $docname;?>" name="export"><buttton class="btn btn-warning mx-2 font-weight-bold" >Export</buttton></a>
    				</div>
    			</form>
    			</div>
    		</div>
    	</div>
    		<div class="col-md-4">
    		<div class="card mx-auto mb-2">
    			<div class="card-header">
    				<h4 class="text-center text-dark font-weight-bold">Add New Documents Here</h4>
    			</div>
    			<div class="card-body">
    				<form method="post" action="" enctype="multipart/form-data">
    					<span class="text-success font-weight-bold"><?php echo $message;?>
						</span><br>
    					<label class="font-weight-bold">Select Document File :</label>
    					<input type="file" name="docFile" placeholder="Select document" class="form-control" value="<?php echo $name;?>">
    					<span class="text-danger"><?php print_r($errors);?></span>
    					<span class="text-danger"><?php echo $docFileerr;?></span><br>
    					<label class="font-weight-bold">Document name  :</label>
    					<input type="text" name="docName" placeholder="Enter Document Name" class="form-control">
    					<span class="text-danger"><?php echo $docNameerr;?></span><br>
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
    					<span class="text-danger"><?php echo $departmenterr;?></span><br>
    					<label class="font-weight-bold">Select Sub-department :</label>
    					<select name="subDepartment" class="form-control">
    						<option value="">-select sub-department-</option>
    						<?php 
    						while ($rows = $result->fetch_assoc()) {
    						?>
    						<option><?php echo $rows['subDepartmentName'];?></option>
    							<?php 
    					}
    					?>
    					</select>
    					<span class="text-danger"><?php echo $subDepartmenterr;?></span><br>
    					<label class="font-weight-bold">Enter Document Description :</label>
    					<textarea name="docDesc" placeholder="Describe the document" maxlength="100" class="form-control"></textarea>
    					<span class="text-danger"><?php echo $docDescerr;?></span><br>
    					<input type="submit" name="upload" class="btn btn-primary" value="Submit The Document">
    				</form>
    			</div>
    		</div>
    	</div>
    	</div>
    </div>




</body>
    <script src="bootstrap/jquery/jquery-3.5.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="bootstrap/popper/popper.min.js"></script>
</html>
