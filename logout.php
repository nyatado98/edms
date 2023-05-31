<?php
session_start();
// Unset all of the session variables
// $_SESSION = array();
 
// Destroy the session.
// session_destroy();
$mysqli = mysqli_connect('localhost','root','','edms');

// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. ");
}
$email = $_SESSION['email'];

unset($_SESSION['loggedin']);
unset($_SESSION['email']);
 
// Redirect to login page
// $startTime = new DateTime('10:00:00');
// $endTime = new DateTime('12:30:00');

// $timeDifference = $startTime->diff($endTime);

// echo $timeDifference->format('%H:%I:%S');


date_default_timezone_set('Africa/Nairobi');
                                     $logout_time=strtotime("current");
                                     $logout_time = date('Y/m/d  H:i:sa');

$sql = "UPDATE logs SET logout_time ='$logout_time' WHERE email = '$email'";
$result = mysqli_query($mysqli,$sql);


$sql = "SELECT * FROM logs WHERE email = '$email'";
$re = mysqli_query($mysqli,$sql);
while($row = $re->fetch_assoc()){

$row['login_time'] = $login_time;
$row['logout_time'] = $logout_time;

$login_time =new DateTime($login_time);
$logout_time =new DateTime($logout_time);

$total_time = $login_time->diff($logout_time);
$to = $total_time->format('%H:%I:%S');

$sql = "UPDATE logs SET total_time ='$to' WHERE email = '$email'";
$result = mysqli_query($mysqli,$sql);

}
header("location:login.php");
exit;


?>