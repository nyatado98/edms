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

if (isset($_GET['view'])) {
	$id = $_GET['view'];

	$sql = "SELECT * FROM documents WHERE id ='$id'";
	$res = mysqli_query($conn,$sql);
}
// 
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
	<title>View document page</title>
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
    <div class="container">
    	<div class="col-md-12">
    	<!-- <div class="card-body"> -->
    		<?php 
    		while ($rows = $res->fetch_assoc()) {
    		?>
    		<iframe class="form-control" style="height: 700px;" src="<?php echo 'document_files/'.$rows['document_file'];?>" class="" width="800px"></iframe>
    		<?php 
    	}
    	?>
    <!-- </div> -->
    </div>
    </div>
</body>
    <script src="bootstrap/jquery/jquery-3.5.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="bootstrap/popper/popper.min.js"></script>
</html>