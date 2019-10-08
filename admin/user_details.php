<?php
session_start(); // Starting Session
include_once('utility.php');
try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if ($_GET['action'] == 'get_user_details') {
            $user_details = array();
            $user_details_obj = array();
            include_once('utility.php');
            $connection = getConnection();
            $query = mysqli_query($connection, "select user_id, username, emailid, contact_number from userdetails");
            $counter=1;
            while ($row = $query->fetch_assoc()) {
                if (mysqli_num_rows($query)>0){
                    $user_details_obj["user_id"] = $row["user_id"];
                    $user_details_obj["user_name"] = $row["username"];
                    $user_details_obj["email_id"] = $row["emailid"];
                    $user_details_obj["contact_number"] = $row["contact_number"];
                    array_push($user_details, $user_details_obj);
                }
            }
            echo json_encode($user_details);
        }
    }

    else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['action'] == 'create_user') {
            $message="";
            $user_name = $_POST["username"];
            $password = $_POST["password"];
            $emailId = $_POST["emailId"];
            $contactNumber = $_POST["contactNumber"];
            $connection = getConnection();
            $insert_query = "insert into userdetails (username, password, emailid, contact_number) values ('" . $user_name. "', '". $password. "', '". $emailId . "',". $contactNumber . ")";
            if(mysqli_query($connection, $insert_query)) {
                $message = "user created successfully";
                getSuccessMsg($message);
            }else{
                $message = "Failed to create user";
                throw new Exception($message);
            }
        }
        else if ($_POST['action'] == 'delete_user') {
            $user_id = $_POST["user_id"];
            $delete_query = "delete from userdetails where user_id=". $user_id;
            $connection = getConnection();
            if(mysqli_query($connection, $delete_query)) {
                $message = "user deleted successfully";
                getSuccessMsg($message);
            }else{
                $message = "Failed to delete user";
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