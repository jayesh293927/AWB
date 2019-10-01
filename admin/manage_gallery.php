<?php
session_start();
include_once('ui_utility.php');
if (!isset($_SESSION['login_user'])){
    header("Location:index.php");
}
?>
<head>
    <title>Manage Gallery</title>
       <!-- Bootstrap Core CSS -->
       <link href="../css/bootstrap.min.css" rel="stylesheet">

      <!-- Custom CSS -->
      <link href="../css/modern-business.css" rel="stylesheet">
</head>

<script type="text/javascript" src="../js/jquery.form.js"></script>
<script>
    function createCol(imageName, image_id) {
            return `<div class="col-md-6 text-center">
                <div class="thumbnail">
                    <img class="img-responsive" src="`+ imageName + `" alt="">
                    <div class="caption">
                        <h3>Christian Alex<br>
                            <small>CA</small>
                        </h3>
                    </div>
                    <button id="` + image_id +`" class="btn btn-sm btn-danger" type="button" data-toggle="modal" 
                    data-target="#confirmDelete" data-title="Delete User" data-message="Are you sure you want to delete this user ?">
                    <i class="glyphicon glyphicon-trash"></i> Delete
                    </button>
                </div>
            </div>`;
    }

    $(document).ready(function () {
        $('#uploadImages').click(function(){
            $('#viewImagesContainer').hide();
            $('#uploadImagesContainer').show();
        });
        
        $('#viewImages').click(function(){
            $('#uploadImagesContainer').hide();
            $('#viewImagesContainer').show();
            $.ajax({
                url: "gallery_details.php",
                type: "GET",
                data: {'action' : 'get_gallery_details'},
                success: function (response) {
                    $('#gallery').html("");
                    images_details_obj = JSON.parse(response);
                    for (img_obj in images_details_obj) {
                        iCol = "";
                        iCol = createCol("../" + images_details_obj[img_obj]['image_path'] + images_details_obj[img_obj]['image_name'],images_details_obj[img_obj]['image_id']);
                        $('#gallery').append($(iCol));
                    }
                }
            });
        });

        $('#deleteImages').click(function(){
            $('#uploadImagesContainer').hide();
            $('#viewImagesContainer').hide();
            $('#deleteImagesContainer').show();
        });
        
        $('#uploadForm').ajaxForm({
            data : {'action' : 'upload_gallery'},
            beforeSubmit: function () {
                $('#uploadStatus').html('<img style="width:400px;height:200px;" src="../images/uploading.gif"/>');
            },
            success: function () {
                $('#images').val('');
                $('#uploadMsg').html('images uploaded successfully');
                $('#uploadStatus').html('');
            },
            error: function () {
                $('#uploadMsg').html('Images upload failed, please try again.');
            }
        });
          //changing
        $('#confirmDelete').on('show.bs.modal', function (e) {
                $message = $(e.relatedTarget).attr('data-message');
                $(this).find('.modal-body p').text($message);
                $title = $(e.relatedTarget).attr('data-title');
                $(this).find('.modal-title').text($title);
            
                // Pass form reference to modal for submission on yes/ok
                $(this).find('.modal-footer #confirm').data('image_id', $(e.relatedTarget)[0]['id']);
        });
            

        $('#confirmDelete').find('.modal-footer #confirm').on('click', function(){
            console.log('dharmendra');
            $.ajax({
                type: 'post',
                url: 'gallery_details.php',
                data: {'action': 'delete_image', 'image_id': $(this).data('image_id')},
                success: function (response) {
                   $("#confirmDelete").modal("hide");
                }
            });
        });
        //location.reload(forceGet);
        //window.location.reload(true);
    });
  
</script>

<body>
    <div class="container">
        <br>
        <div class="row">
            <button id="uploadImages" type="button" class="btn btn-primary">Upload Images</button>
            <button id="viewImages" type="button" class="btn btn-primary">View Images</button>
        </div>
        <br>
        <br>

        <!-- images upload form -->
        <div id="uploadImagesContainer" style="display:none;">
            
            <form method="post" id="uploadForm" enctype="multipart/form-data" action="gallery_details.php">
                <div class="row">
                    <div class="form-group">
                        <label class="control-label themelabel" for="images">Choose Images</label>
                        <input class="form-group" type="file" name="images[]" id="images" multiple >
                    </div>    
                </div>

                <div class="row">
                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" name="submit" value="UPLOAD"/>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                    <!-- display upload status -->
                    <div id="uploadStatus"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label class="control-label" id="uploadMsg"></label>
                    </div>
                </div>
            </form>
        </div>

        <!-- gallery view of uploaded images --> 
        <div id="viewImagesContainer" style="display:none;">
        <button id="deleteImages" type="button" class="btn btn-primary">Delete Images</button>
        <br><br>
        <div class="gallery" id="gallery" >
        </div>
        </div>

    </div>

     <!-- Modal Dialog for delete confirmition -->
    <div class="modal fade" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title">Delete Parmanently</h4>
          </div>
          <div class="modal-body">
            <p>Are you sure about this ?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" id="confirm">Delete</button>
          </div>
        </div>
      </div>
    </div>

</body>
