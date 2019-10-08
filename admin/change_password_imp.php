<?php   
session_start();
include_once('utility.php');
$message="";
try {
    if (empty($_POST["currentPassword"]) || empty($_POST["newPassword"])) {
        $message = "currentPassword or newPassword should not be empty";
        throw new Exception($message);
    }
    else {
        $connection = getConnection();
        if (count($_POST) > 0) {
            $result = mysqli_query($connection, "SELECT * from userdetails WHERE user_id='" . $_SESSION["userId"] . "'");
            $row = mysqli_fetch_array($result);
            if ($_POST["currentPassword"] == $row["password"]) {
                mysqli_query($connection, "UPDATE userdetails set password='" . $_POST["newPassword"] . "' WHERE user_id='" . $_SESSION["userId"] . "'");
                $message = "Password Changed Successfully";
                getSuccessMsg($message);
            }else{
                $message = "Current Password is incorrect";
                throw new Exception($message);
            }   
        }
    }
} catch (exception $e) {
    getErrorMsg($e);
} finally {
    // Closing Connection
    if(isset($connection)){
        mysqli_close($connection); 
    }
}
?>