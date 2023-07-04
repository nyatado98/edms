<?php 
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exeption;
use PHPMailer\PHPMailer\SMTP;


//load composer autoloader
require 'vendor/autoload.php';
 require 'vendor/phpmailer/phpmailer/src/Exception.php';
 require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
 require 'vendor/phpmailer/phpmailer/src/SMTP.php';

   $mail = new PHPMailer();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) AND $_SESSION["email"] == true){
    header("location:index");
    exit;
}

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

 $emailerr = $passworderr = $emailerrr = $passworderrr = $acc_err = "";

 $email = $password = "";
// if ($_SERVER['REQUEST_METHOD'] == "POST") {

if (isset($_POST['login'])) {

	if (empty(trim($_POST['email']))) {
		$emailerr = "Please enter your email";
		}else{
			$sql = "SELECT email FROM users WHERE email =?";
   //          $re = mysqli_query($mysqli,$sql);
   //          $count = mysqli_num_rows($re);
   //          if ($count == 0) {
   //              $emailerrr = "This email in not registered";
                
   //          }else{
   //              $email = trim($_POST['email']);
   //          }
			if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);
            $param_email = trim($_POST["email"]);
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 0){
                    $emailerrr = "This email is not registered.";
                }else{
			$email = trim($_POST['email']);
			}
		}
	}
}
		if (empty(trim($_POST['password']))) {
			$passworderr = "Enter your password please";
		}else{
			$password = trim($_POST['password']);
	}

	

	if (empty($emailerr) && empty($passworderr)) {
		$sql = "SELECT email,password FROM users WHERE email =?";
	// if ($user_status = 'Suspended') {
	// 	echo "You are Suspended";
	// }
		if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $email);
             
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Store result
                $stmt->store_result();
                
                // Check if tel number exists, if yes then verify password
                if($stmt->num_rows == 1){                    
                    // Bind result variables
                    
                    $stmt->bind_result($email,$hashed_password);
                    if($stmt->fetch()){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["email"] = $email;    
                            
                            $sql = "SELECT * FROM users WHERE email = '$email'";
                            $re = mysqli_query($mysqli,$sql);
// var_dump($re);
                                while($row = $re->fetch_assoc()) {
                                  // $row['fullname'] = $fullname;
                                  // $row['user_type'] = $user_type;
                                     //insert into logs table in db
                                     date_default_timezone_set('Africa/Nairobi');
                                     $login_time=strtotime("current");
                                     $login_time = date('Y/m/d  H:i:sa');
                                     $query = "INSERT INTO logs (user_id,fullname,user_type,email,login_time,logout_time,total_time)VALUES ('".$row["id"]."','".$row["fullname"]."','".$row["user_type"]."','$email','$login_time','','')";
                                     $result = mysqli_query($mysqli, $query);

                                     $_SESSION['login_time'] = $login_time;
                              }
                            // Redirect user to index page
                            header("location:index");
                            
                            // $sql = "UPDATE users SET user_status ='Loggedin' WHERE tel = '$tel' AND user_type='admin'";
                            // $rest = mysqli_query($mysqli,$sql);


                        } else{
                            // Display an error message if password is not valid
                            $passworderrr = "The password you entered is not valid.";
                        }
                    }else{
                    	$emailerrr = "no account found";
                    }
                }else{
                 //    $_SESSION['email']= $email;
                	// $sql = "SELECT * FROM users WHERE email = '".$_SESSION['email']."'";
                	// $quer = mysqli_query($mysqli,$sql);
                	// if ($user_status = 'Suspended') {
                	// 	$acc_err = "Your Account is Temporarily Suspended";
                	// }
                	
                }
                 $stmt->close();
            }
        }

	  $mysqli->close();
	}else{
        // $acc_err = "Your Account is Temporarily Suspended";
    }
	
}
// reset password
$emailreset = "";
if (isset($_POST['btn_forgot_password'])) {
  if (empty(trim($_POST['emailreset']))){
        $emailerr = "enter email";
    }else{
        $sql = "SELECT * FROM users WHERE email = '".$_POST['emailreset']."'";
        $re = mysqli_query($mysqli,$sql);
        // while($row=$re->fetch_assoc()){
        //   $row['id'] = $id;
        //   $url = $id;
        // }
        $Count = mysqli_num_rows($re);
        if ($Count<1) {
            $emailerr = "The  email is not registered...Enter a valid email";
        }else{
        $emailreset = trim($_POST['emailreset']);
        $sql = "SELECT * FROM users WHERE email = '$emailreset'";
        $q = mysqli_query($mysqli,$sql);
        while($row = $q->fetch_assoc()){
            $row['id'] = $id;
            // <a href="localhost/edms/reset_pass?edit='.$id.'">Reset here</a>
            $url =$id;
          }
         
  // $message=$_POST['message'];

  $mailto = $emailreset;
    $mailSub = 'EDMS Message';
    // $mailMsg = "".$message."";
    $mailMsg = "Reset your passord by clicking the link below....";

    
   
   $mail ->isSMTP();
   $mail ->SMTPDebug = 2;
   $mail ->SMTPAuth = true;
   //$mail ->SMTPSecure = 'ssl';
   $mail ->SMTPSecure = 'tsl';
   $mail ->Host = "sandbox.smtp.mailtrap.io";
   $mail ->Port = '2525'; // or 587 or 465
   $mail ->IsHTML(true);
   $mail ->Username = "17005d776171e1";
   $mail ->Password = "795f662ec6fcb0";
   $mail ->SetFrom("edms@gmail.com",'Developer Mailer');
   $mail ->Subject = $mailMsg;
   $mail ->Body = $url;
   $mail ->AddAddress($mailto);

   if($mail->Send())
   {
     $message= "Mail Sent";
     header("location:login?".$message);
   }else{
    $message = "Mail not sent";
     header("location:login?".$message);
   }
    }
    }
}
?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>admin/user login page</title>
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
	<div class="container col-md-6 mt-5">
					<div class="card">
					<form class="log-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
						<div class="card-header">
			              <!-- <img src="ccms.jpg" class="img-fluid" alt=""> -->
			              <h4 class="text-center font-weight-bold">Please Input Your Details Below</h4>
		              </div>
		              <div class="card-body">
                        <label class="font-weight-bold">Enter your email :</label>
		              <input type="email" name="email" placeholder="Enter email" class="form-control" value="<?php echo $email ;?>">
		              <span class="text-danger"><?php echo $emailerr ;?></span>
		              <span class="text-danger"><?php echo $emailerrr;?></span><br>
                        <label class="font-weight-bold">Enter your password :</label>
						<input type="password" name="password" placeholder="Enter password" class="form-control" value="<?php echo $password ;?>">
						<span class="text-danger"><?php echo $passworderr ;?></span>
						<span class="text-danger"><?php echo $passworderrr ;?></span>
						<span class="text-danger"><?php echo $acc_err ;?></span><br>
						<input type="submit" name="login" class="btn btn-primary" value="L O G I N">
						<p>Forgot password <a href="#passwordReset" data-toggle="modal">Reset Here</a></p>
                        <p>Signup Here <a href="register" >Register Here</a></p>
					</div>
					</form>
		</div>
	</div>
</body>

<div class="modal fade" id="passwordReset" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header" style="background: #398AD7; color: #fff;"><!--398AD7--><!--08B6CE-->
  
        <h5>RESET PASSWORD</h5>
      </div>

      <div class="modal-body">
        <div class="form-group">
        
        <div class="form-group">

          <input type="email" name="emailreset" class="form-control" placeholder="Enter Email" required>
          <!-- <span class="text-danger"><?php echo $emailerr ;?></span> -->



    </div>

    <div class="modal-footer">
      <button type="submit" name="btn_forgot_password" class="btn btn-primary">Reset Password</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
      </div>

    </form>
  </div>
    </div>
  </div>
    </body>
<script src="bootstrap/jquery/jquery-3.5.1.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="bootstrap/popper/popper.min.js"></script> 
<script src="bootstrap/js/bootstrap.js"></script>
</html>