<?php
session_start(); // Starting Session
include_once('utility.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_GET['action'] == 'get_gallery_details') {
        $image_details = array();
        $image_details_obj = array();
        $connection = getConnection();
        $query = mysqli_query($connection, "select image_id, image_name, image_path, image_description from galleryimagedetails");
        $counter=1;
        while ($row = $query->fetch_assoc()) {
            if (mysqli_num_rows($query)>0){
                $image_details_obj["image_id"] =  $row["image_id"];
                $image_details_obj["image_name"] = $row["image_name"];
                $image_details_obj["image_path"] = $row["image_path"];
                $image_details_obj["image_description"] = $row["image_description"];
                array_push($image_details, $image_details_obj);
            }
        }
        mysqli_close($connection);
        echo json_encode($image_details);
    }
}

else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] == 'upload_gallery') {
            $message="";
            // File upload configuration
            $targetDir = "../uploads/gallery/";
            $allowTypes = array('jpg','png','jpeg');
            $image_description = $_POST['image_description'];
            
            $images_arr = array();
            $image_details = array();
            
            foreach($_FILES['images']['name'] as $key=>$val){
                $image_name = $_FILES['images']['name'][$key];
                $tmp_name   = $_FILES['images']['tmp_name'][$key];
                $size       = $_FILES['images']['size'][$key];
                $type       = $_FILES['images']['type'][$key];
                $error      = $_FILES['images']['error'][$key];
                
                // File upload path
                $fileName = basename($_FILES['images']['name'][$key]);
                $targetFilePath = $targetDir . $fileName;
                // Check whether file type is valid
                $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
                
                if(in_array($fileType, $allowTypes)){
                    // Store images on the server
                    
                    if(move_uploaded_file($tmp_name,$targetFilePath)){
                        $images_arr['image_name'] =  $fileName;
                        $images_arr['image_dir'] = "./uploads/gallery/";
                        array_push($image_details,$images_arr);
                    }
                }
            }
            $connection = getConnection();
            foreach($image_details as $key=>$val) {
                $insert_query = "insert into galleryimagedetails (image_name,image_path, image_description) values ('". $val["image_name"]. "','". $val["image_dir"] . "','". $image_description . "')";
                if(mysqli_query($connection, $insert_query)) {
                    $message = "record inserted";
                }else{
                    $message = "record not inserted";
                }
            }
            mysqli_close($connection); // Closing Connection
    }
    else if ($_POST['action'] == 'delete_image') {
        $image_id = $_POST["image_id"];
        $delete_query = "delete from galleryimagedetails where image_id=". $image_id;
        $connection = getConnection();
        if(mysqli_query($connection, $delete_query)) {
            $message = "Success";
        }else{
            $message = "error";
        }
        mysqli_close($connection);
        echo $message;
        }
}
?>