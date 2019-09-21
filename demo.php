<?php
            include_once('admin/utility.php');
            $connection = getConnection();
            $query = mysqli_query($connection, "select image_id, image_name, image_path from galleryimagedetails");
            $counter=1;
            while ($row = $query->fetch_assoc()) {
                if (mysqli_num_rows($query)>0){
?>
                <div class="row">
                        <div class="col-md-6 text-center">
                            <div class="thumbnail">
                                <img class="img-responsive" src="<?php echo $row["image_path"] . $row["image_name"]?>"  alt="">
                                <div class="caption">
                                    <h3>Christian Alex<br>
                                        <small>CA</small>
                                    </h3>
                                </div>
                            </div>
                        </div>
                </div>
<?php        
                }
            }
            mysqli_close($connection); // Closing Connection
?>