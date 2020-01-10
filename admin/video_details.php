<?php
session_start(); // Starting Session
include_once('utility.php');
//var_dump($_POST);

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if ($_GET['action'] == 'get_video_details') {
            $video_details = array();
            $video_details_obj = array();
            $connection = getConnection();
            $query = mysqli_query($connection, "select video_id, video_path from videodetails");
            $counter=1;
            while ($row = $query->fetch_assoc()) {
                if (mysqli_num_rows($query)>0){
                    $video_details_obj["video_id"] =  $row["video_id"];
                    $video_details_obj["video_path"] = $row["video_path"];
                    array_push($video_details, $video_details_obj);
                }
            }
            echo json_encode($video_details);
        }
    }
    else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['action'] == 'add_video') {
            $message="";
            $video_path = $_POST['video_path'];
            $connection = getConnection();
            $insert_query = "insert into videodetails (video_path) values ('". $video_path."')";
                if(mysqli_query($connection, $insert_query)) {
                    $message = "record inserted";
                }else{
                    $message = "record not inserted";
                }
        }
        else if ($_POST['action'] == 'delete_video') {
            $video_id = $_POST["video_id"];
            $delete_query = "delete from videodetails where video_id=". $video_id;
            $connection = getConnection();
            if(mysqli_query($connection, $delete_query)) {
                $message = "Video deleted successfully";
                getSuccessMsg($message);
            }else{
                $message = "Failed to delete Video";
                throw new Exception($message);
            }
        }
    }
   
} 
catch (exception $e) {
    getErrorMsg($e);
} 
finally {
    // Closing Connection
    if(isset($connection)){
        mysqli_close($connection); 
    }
}

?>