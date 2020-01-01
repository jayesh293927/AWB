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

<script src="../js/jquery.toaster.js"></script>
<script type="text/javascript" src="../js/jquery.form.js"></script>
<script>
    function createCol(imageName, image_id, imageDescription) {
            return `<div class="col-md-6 text-center">
                <div class="thumbnail">
                    <img class="img-responsive" src="`+ imageName + `" alt="">
                    <div class="caption">
                        <h3>` + imageDescription + `<br>
                        </h3>
                    </div>
                    <button id="` + image_id +`" class="btn btn-sm btn-danger" type="button" data-toggle="modal" 
                    data-target="#confirmDelete" data-title="Delete User" data-message="Are you sure you want to delete `+imageDescription+` ?">
                    <i class="glyphicon glyphicon-trash"></i> Delete
                    </button>
                </div>
            </div>`;
    }

    function get_gallery() {
        $.ajax({
                url: "gallery_details.php",
                type: "GET",
                data: {'action' : 'get_gallery_details'},
                success: function (response) {
                    $('#gallery').html("");
                    images_details_obj = JSON.parse(response);
                    for (img_obj in images_details_obj) {
                        iCol = "";
                        iCol = createCol("../" + images_details_obj[img_obj]['image_path'] + images_details_obj[img_obj]['image_name'], images_details_obj[img_obj]['image_id'], images_details_obj[img_obj]['image_description']);
                        $('#gallery').append($(iCol));
                    }
                }
            });
    }
    $(document).ready(function () {
       
        $('#uploadImages').click(function(){
            $('#viewImagesContainer').hide();
            $('#uploadImagesContainer').show();
        });
        
        $('#viewImages').click(function(){
            $('#uploadImagesContainer').hide();
            $('#viewImagesContainer').show();
            get_gallery();
        });

        $('#deleteImages').click(function(){
            $('#uploadImagesContainer').hide();
            $('#viewImagesContainer').hide();
            $('#deleteImagesContainer').show();
        });
        
        $("#frmUploadImages").submit(function(event){
            if ($("[class='error']").length > 0) {
                $("[class='error']").remove();
            }
            var image_description = $("#image_description").val();
            var file_data = $('#images').prop('files');
            if (file_data.length==0){
                $("#images").focus();
                $("label[for='images']").after('<span class="error">This field is required</span>');
                return false;
            }
            if(!image_description) {
                $("#image_description").focus();
                $("label[for='image_description']").after('<span class="error">This field is required</span>');
                return false;
            }
            $('#uploadStatus').html('<img style="width:400px;height:200px;" src="../images/uploading.gif"/>');
            var form_data = new FormData();
            for (i=0; i<$('#images').prop('files').length; i++){
                form_data.append('images[]', $('#images').prop('files')[i]);
            }
            form_data.append('action', 'upload_gallery');
            form_data.append('image_description', image_description);
            $.ajax({
                url: 'gallery_details.php',
                cache: false,
                type: 'POST',
                data: form_data,
                processData: false,
                contentType: false,
                success: function (response) {
                    jObject = JSON.parse(response);
                    if(jObject['Success']) {
                        $('#uploadStatus').html('');
                        $("#image_description").val('')
                        $("#images").val('');
                        $.toaster({ message : jObject['Success'], title : 'Success', priority : 'success' });
                    } else {
                        $.toaster({ message :  jObject['error']['msg'], title : 'Error', priority : 'danger' });
                    }
                },
                error: function() {
                    $.toaster({ message : 'Failed to upload images', title : 'Error', priority : 'danger' });
                }
            });
            event.preventDefault();
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
            image_id = $(this).data('image_id');
            $.ajax({
                type: 'post',
                url: 'gallery_details.php',
                data: {'action': 'delete_image', 'image_id': image_id},
                success: function (response) {
                  jObject = JSON.parse(response);
                  if(jObject['Success']) {
                    $("#confirmDelete").modal("hide");
                    $.toaster({ message : jObject['Success'], title : 'Success', priority : 'success' });
                    get_gallery();
                  } else {
                      $.toaster({ message :  jObject['error']['msg'], title : 'Error', priority : 'danger' });
                  } 
                },
                error: function() {
                    $.toaster({ message : 'Failed to delete image', title : 'Error', priority : 'danger' });
                }
            });
        });
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
            <form id="frmUploadImages">
                <div class="row">
                    <div class="form-group required">
                        <label class="control-label themelabel" for="images">Choose Images</label>
                        <input class="form-group" type="file" name="images[]" id="images" multiple >
                    </div>    
                </div>

                <div class="row">
                    <div class="form-group required">
                        <label class="control-label themelabel" for="image_description">Image Description:</label>
                        <input type="text" class="form-control" id="image_description">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <input id="uploadGallery" class="btn btn-primary" type="submit" value="Upload Image"/>
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
        <!-- <button id="deleteImages" type="button" class="btn btn-primary">Delete Images</button> -->
        <br><br>
        <div class="gallery" id="gallery">
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

