<?php
session_start(); // Starting Session
include_once('utility.php');
$error=''; // Variable To Store Error Message
if (empty($_POST['userName']) || empty($_POST['password'])) {
    $error = "Username or Password is invalid123";
}
else
{ 
    $username=$_POST['userName'];
    $password=$_POST['password'];
    $connection = getConnection();
    $query = mysqli_query($connection, "select * from userdetails where password='$password' AND username='$username'");
    $rows = mysqli_num_rows($query);
   
    if ($rows == 1) {
        while ($row = $query->fetch_assoc()) {
            $_SESSION['userId'] = $row['user_id'];
            $_SESSION['login_user']= $row['username'];
        }
        $_SESSION['loggedin_time'] = time();
        $error = "Success";
        // header("location: profile.php"); // Redirecting To Other Page
    } else {
        $error = "Username or Password is invalid";
    }
    mysqli_close($connection); // Closing Connection
    echo $error;
}
?>