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
$login_time = $_SESSION['login_time'];

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
    $sql = "UPDATE logs SET logout_time ='$logout_time' WHERE login_time = '$login_time'";
    $result = mysqli_query($mysqli, $sql);

$sql = "SELECT * FROM logs WHERE login_time = '$login_time'";
$re = mysqli_query($mysqli,$sql);
while($row = $re->fetch_assoc()){

$row['login_time'] = $login_time;
$row['logout_time'] = $logout_time;

date_default_timezone_set('Africa/Nairobi');
$row['login_time'] =new DateTime($row['login_time']);
$row['logout_time'] =new DateTime($row['logout_time']);

$total_time = $row['login_time']->diff($row['logout_time']);
// var_dump($total_time->format('%H'));
$diff = $total_time->format('%s');

if($diff <= 60){
    $dif = $diff .'Secs';
}elseif($diff > 60){
    $dif =($diff/60) .'Minutes';
}elseif($diff >= 3600){
    $dif = ($diff/3600). 'Hours';
}

$sql = "UPDATE logs SET total_time ='$dif' WHERE login_time = '$login_time'";
$result = mysqli_query($mysqli,$sql);

}
header("location:login.php");
exit;


?>