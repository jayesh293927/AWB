<?php
session_start(); // Starting Session
include_once('utility.php');
$error=''; // Variable To Store Error Message
if (isset($_POST['submit'])) {
if (empty($_POST['user_name']) || empty($_POST['password'])) {
    $error = "Username or Password is invalid";
}
else
{ 
    // Define $username and $password
    $username=$_POST['user_name'];
    $password=$_POST['password'];
    // Establishing Connection with Server by passing server_name, user_id and password as a parameter
    // $connection = mysqli_connect("localhost", "root", "DM@#2806","AWB");
    $connection = getConnection();
    // To protect MySQL injection for Security purpose
    //$username = stripslashes($username);
    //$password = stripslashes($password);
    $query = mysqli_query($connection, "select * from userdetails where password='$password' AND username='$username'");
    $rows = mysqli_num_rows($query);
    if ($rows == 1) {
        while ($row = $query->fetch_assoc()) {
            $_SESSION['userId'] = $row['user_id'];
            $_SESSION['login_user']= $row['username'];
        }
        $_SESSION['loggedin_time'] = time();
        //$_SESSION['login_user']=$username; // Initializing Session
        header("location: profile.php"); // Redirecting To Other Page
    } else {
        $error = "Username or Password is invalid";
    }
    mysqli_close($connection); // Closing Connection
}
}
?>