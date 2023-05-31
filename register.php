<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'edms');
 
/* Attempt to connect to MySQL database */
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. ");
}
$user_status = 'Not Loggedin';
$typeerr = $fullnameerr = $emailerr = $phone_noerr = $passworderr = $repassworderr = $err = $strlenerr ="";

$user_type = $fullname = $email = $phone_no = $password = $repassword ="";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if(empty(trim($_POST["user_type"]))){
        $typeerr = "Please select user type.";
    } else{
        $user_type = trim($_POST["user_type"]);
    }
	if(empty(trim($_POST["fullname"]))){
        $fullnameerr = "Please enter fullname.";
    } else{
        $fullname = trim($_POST["fullname"]);
    }

    if (empty(trim($_POST['phone_no']))){
    	$phone_noerr = "enter phone number";
    }else{
        $sql = "SELECT * FROM users WHERE phone_no = ".$_POST['phone_no']."";
        $r = mysqli_query($mysqli,$sql);
        $count = mysqli_num_rows($r);
        if ($count>0) {
            $phone_noerr = "The phone number is already registered...Enter another number";
        }else{
    	$phone_no = trim($_POST['phone_no']);
    }
    }

    if (empty(trim($_POST['email']))){
    	$emailerr = "enter email";
    }else{
        $sql = "SELECT * FROM users WHERE email = '".$_POST['email']."'";
        $re = mysqli_query($mysqli,$sql);
        $Count = mysqli_num_rows($re);
        if ($Count>0) {
            $emailerr = "The phone email is already registered...Enter another email";
        }else{
    	$email = trim($_POST['email']);
    }
    }

    if (empty(trim($_POST['password']))){
    	$passworderr = "enter password";
    }elseif(strlen(trim($_POST['password'])) < 6){
    	$strlenerr = "password should be more than six characters";
    }else{
    	$password = trim($_POST['password']);
    }
    if (empty(trim($_POST['repassword']))){
    	$repassworderr = "Confirm password";
    }else{
    	$repassword = trim($_POST['repassword']);
    }
    if (trim($_POST['repassword']) != $password) {
        $repassworderr = "The password don't match";
    }

//checking if there are no existing errors
if(empty($typeerr) && empty($fullnameerr) && empty($emailerr) && empty($phone_noerr) &&  empty($passworderr) && empty($repassworderr)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (user_type,fullname, phone_no,email, password) VALUES (?,?,?,?,?)";

         if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssss",$param_user_type, $param_fullname, $param_phone_no,  $param_email, $param_password);
            

                   // Set parameters
           $param_user_type = $user_type;
            $param_fullname = $fullname;
            
            $param_phone_no = $phone_no;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
           
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location:login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
        $mysqli->close();
    }
    }
 ?>




<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>admin/user signup page</title>
	<!-- <link rel="stylesheet" type="text/css" href="login.css"> -->
    <style type="text/css">
     .card-header{
        background: url(ccms.jpg);
        height: 20vh;
     }   
     h4{
        padding: 40px;
        text-transform: uppercase;
     }
    </style>
</head>
<body>
	<div class="container col-md-8 mt-5">
        <div class="card">
					<form class="log-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<div class="card-header col-md-12">
			              <!-- <img src="1.jfif" class="img-fluid" alt=""> -->
                          <h4 class="text-center font-weight-bold">Fill The Fields Below</h4>
		              </div>
                      <div class="card-body">
                      <label class="font-weight-bold">Enter your User type :</label>
                        <select class="form-control" name="user_type">
                            <option value="">-Select type-</option>
                            <option>Admin</option>
                            <option>ICT</option>
                            <option>CLERCK</option>
                            <option>TREASURER</option>
                            <option>SECRETARY</option>
                        </select>
                        <span class="text-danger"><?php echo $typeerr;?></span><br>
                        <label class="font-weight-bold">Enter your fullname :</label>
		              <input type="text" name="fullname" placeholder="Enter fullname" class="form-control" value="<?php echo $fullname; ?>">
		              <span class="text-danger"><?php echo $fullnameerr; ?></span><br>
                        <label class="font-weight-bold">Enter your phone number :</label>
		              <input type="number" name="phone_no" placeholder="Enter phone number" class="form-control" value="<?php echo $phone_no; ?>">
		              <span class="text-danger"><?php echo $phone_noerr ?></span><br>
                        <label class="font-weight-bold">Enter your email :</label>
		              <input type="email" name="email" placeholder="Enter email" class="form-control" value="<?php echo $email; ?>">
		              <span class="text-danger"><?php echo $emailerr ;?></span><br>
                        <label class="font-weight-bold">Enter password :</label>
						<input type="password" name="password" placeholder="Enter password" class="form-control" value="<?php echo $password ;?>">
						<span class="text-danger"><?php echo $passworderr ;?></span>
						<span class="text-danger"><?php echo $strlenerr ;?></span><br>
                        <label class="font-weight-bold">Please re-enter your password :</label>
						<input type="password" name="repassword" placeholder="Confirm password" class="form-control" value="<?php echo $repassword ;?>">
						<span class="text-danger"><?php echo $repassworderr ;?></span>
						<span class="text-danger"><?php echo $err ;?></span><br>
						<input type="submit" class="btn btn-primary form-control font-weight-bold" value="S I G N U P">
						<p>If Already registered <a href="login.php">Login here</a></p>
                    </div>
					</form>
                </div>
	</div>
</body>
<script src="bootstrap/jquery/jquery-3.5.1.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="bootstrap/popper/popper.min.js"></script> 
<script src="bootstrap/js/bootstrap.js"></script>
</html>