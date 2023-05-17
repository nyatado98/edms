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

// $sql = "UPDATE users SET user_status='Not Loggedin' WHERE tel = '$tel' AND user_type= 'admin'";
// $result = mysqli_query($mysqli,$sql);
header("location:login.php");
exit;


?>