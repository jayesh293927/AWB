<?php   
session_start();
include_once('utility.php');
$message="";
if (empty($_POST["currentPassword"]) || empty($_POST["newPassword"])) {
    $message = "currentPassword or newPassword should not be empty";
}
else {
$connection = getConnection();
if (count($_POST) > 0) {
    $result = mysqli_query($connection, "SELECT * from userdetails WHERE user_id='" . $_SESSION["userId"] . "'");
    $row = mysqli_fetch_array($result);
    if ($_POST["currentPassword"] == $row["password"]) {
        mysqli_query($connection, "UPDATE userdetails set password='" . $_POST["newPassword"] . "' WHERE user_id='" . $_SESSION["userId"] . "'");
        $message = "Password Changed Successfully";
    } else
        $message = "Current Password is incorrect";
}
mysqli_close($connection); // Closing Connection
}

echo ($message);
?>