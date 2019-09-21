<?php
session_start(); // Starting Session
include_once('utility.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_GET['action'] == 'get_chord_details') {
        $chord_details = array();
        $chord_details_obj = array();
        include_once('utility.php');
        $connection = getConnection();
        $query = mysqli_query($connection, "select chord_id, chord_name, chord_path from chorddetails");
        $counter=1;
        while ($row = $query->fetch_assoc()) {
            if (mysqli_num_rows($query)>0){
                $chord_details_obj["chord_name"] = $row["chord_name"];
                $chord_details_obj["chord_path"] = $row["chord_path"];
                array_push($chord_details, $chord_details_obj);
            }
        }
        mysqli_close($connection);
        echo json_encode($chord_details);
    }
}

else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] == 'upload_chord') {
        $message="";
        $targetDir = "../uploads/chords/";
        $allowTypes = array('pdf');
        
        $images_arr = array();
        $chord_details = array();
        
        foreach($_FILES['pdfs']['name'] as $key=>$val){
            $image_name = $_FILES['pdfs']['name'][$key];
            $tmp_name   = $_FILES['pdfs']['tmp_name'][$key];
            $size       = $_FILES['pdfs']['size'][$key];
            $type       = $_FILES['pdfs']['type'][$key];
            $error      = $_FILES['pdfs']['error'][$key];
            
            // File upload path
            $fileName = basename($_FILES['pdfs']['name'][$key]);
            $targetFilePath = $targetDir . $fileName;
        
            // Check whether file type is valid
            $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
            
            if(in_array($fileType, $allowTypes)){
                // Store pdfs on the server
                
                if(move_uploaded_file($tmp_name,$targetFilePath)){
                    $images_arr['pdf_name'] =  $fileName;
                    $images_arr['pdf_dir'] = "./uploads/chords/";
                    array_push($chord_details,$images_arr);
                }
            }
        }
        $connection = getConnection();
        foreach($chord_details as $key=>$val) {
            $insert_query = "insert into chorddetails (chord_name,chord_path) values ('". $val["pdf_name"]. "','". $val["pdf_dir"] . "')";
            if(mysqli_query($connection, $insert_query)) {
                $message = "record inserted";
            }else{
                $message = "record not inserted";
            }
        }
        mysqli_close($connection); // Closing Connection
    }
}

?>