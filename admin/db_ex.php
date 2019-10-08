<!-- This file is used for reference purpose which represents how we can create connection with database and perform query-->

<?php

$host_name = parse_ini_file("awb_config.ini")['dbHostName'];
$user_name = parse_ini_file("awb_config.ini")['dbUserName'];
$password = parse_ini_file("awb_config.ini")['dbPassword'];
$datbase_name = parse_ini_file("awb_config.ini")['dbDatabaseName'];

$connection = mysqli_connect($host_name, $user_name, $password, $datbase_name);
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
echo $connection;
$query = mysqli_query($connection, "select * from userdetails where password='456' AND username='dharmendra'");
    $rows = mysqli_num_rows($query);
    if ($rows == 1) {
        print_r($query->fetch_assoc()[0]["userId"]);
        while ($row = $query->fetch_assoc()) {
            $_SESSION["userId"] = $row['user_id'];
            $_SESSION['login_user']= $row['username'];
        }
        $_SESSION['loggedin_time'] = time();
        //$_SESSION['login_user']=$username; // Initializing Session
        //header("location: profile.php"); // Redirecting To Other Page
    } else {
        $error = "Username or Password is invalid";
    }
    mysqli_close($connection); // Closing Connection
//print_r($_SESSION);
?>