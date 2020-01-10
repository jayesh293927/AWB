<?php
session_start();
include_once('ui_utility.php');
if (!isset($_SESSION['login_user'])){
    header("Location:index.php");
}
?>
<head>
    <title>Manage Videos</title>
       <!-- Bootstrap Core CSS -->
       <link href="../css/bootstrap.min.css" rel="stylesheet">

      <!-- Custom CSS -->
      <link href="../css/modern-business.css" rel="stylesheet">
</head>

<script src="../js/jquery.toaster.js"></script>
<script type="text/javascript" src="../js/jquery.form.js"></script>
 <script>
  function createCol(video_path, video_id) {
            return `<div class="col-md-6 text-center">
                <div class="thumbnail">
                    <iframe class="embed-responsive-item" allowfullscreen src="` + video_path + `">
                    </iframe>
                    <button id="` + video_id +`" class="btn btn-sm btn-danger" type="button" data-toggle="modal" 
                    data-target="#confirmDelete" data-title="Delete User" data-message="Are you sure you want to delete `+video_path+` ?">
                    <i class="glyphicon glyphicon-trash"></i> Delete
                    </button>
                </div>
            </div>`;
    }

    function get_video() {
        $.ajax({
                url: "video_details.php",
                type: "GET",
                data: {'action' : 'get_video_details'},
                success: function (response) {
                    $('#videos').html("");
                    video_details_obj = JSON.parse(response);
                    for (vid_obj in video_details_obj) {
                        iCol = "";
                        iCol = createCol(video_details_obj[vid_obj]['video_path'], video_details_obj[vid_obj]['video_id']);
                        $('#videos').append($(iCol));
                    }
                }
            });
    }
        $(document).ready(function() { 

            $('#uploadVideo').click(function(){
            $('#viewVideoContainer').hide();
            $('#uploadVideoContainer').show();
        });
        
        $('#viewVideo').click(function(){
            $('#uploadVideoContainer').hide();
            $('#viewVideoContainerContainer').show();
            get_video();
        });

        $('#deleteVideo').click(function(){
            $('#uploadVideoContainer').hide();
            $('#viewVideoContainerContainer').hide();
            $('#deleteVideoContainer').show();
        });
        
            $("#frmAddVideo").submit(function(event){
                if ($("[class='error']").length > 0) {
                    $("[class='error']").remove();
                }
                var videoPath = $("#video_path").val();
                if(videoPath == "") 
                {
                    $("#video_path").focus();
                    $("label[for='video_path']").after('<span class="error">This field is required</span>');
                    return false;
                }
                $.ajax({
                    type: 'post',
                    url: 'video_details.php',
                    data: {'action': 'add_video', 'video_path': videoPath},
                    success: function (response) {//response is value returned from php 
                        $.toaster({ message : 'video added successfully', title : 'Success', priority : 'success' });
                        $("#video_path").val("");

                    },
                    error: function() {
                        $.toaster({ message : 'Failed to add video', title : 'Error', priority : 'danger' });
                    }
                });
                event.preventDefault();
            });
        $('#confirmDelete').on('show.bs.modal', function (e) {
                $message = $(e.relatedTarget).attr('data-message');
                $(this).find('.modal-body p').text($message);
                $title = $(e.relatedTarget).attr('data-title');
                $(this).find('.modal-title').text($title);
            
                // Pass form reference to modal for submission on yes/ok
                $(this).find('.modal-footer #confirm').data('video_id', $(e.relatedTarget)[0]['id']);
        });
            
        $('#confirmDelete').find('.modal-footer #confirm').on('click', function(){
            video_id = $(this).data('video_id');
            $.ajax({
                type: 'post',
                url: 'video_details.php',
                data: {'action': 'delete_video', 'video_id': video_id},
                success: function (response) {
                  jObject = JSON.parse(response);
                  if(jObject['Success']) {
                    $("#confirmDelete").modal("hide");
                    $.toaster({ message : jObject['Success'], title : 'Success', priority : 'success' });
                    get_video();
                  } else {
                      $.toaster({ message :  jObject['error']['msg'], title : 'Error', priority : 'danger' });
                  } 
                },
                error: function() {
                    $.toaster({ message : 'Failed to delete Video', title : 'Error', priority : 'danger' });
                }
            });
        });
        });
</script>
<body>
    <div class="container">
        <br>
            <div class="row">
                <button id="uploadVideo" type="button" class="btn btn-primary">Upload Video</button>
                <button id="viewVideo" type="button" class="btn btn-primary">View Videos</button>
            </div>
            <br>

        <div id="uploadVideoContainer" style="display:none;">
            <form id="frmAddVideo">
            <div class="row">
                <div class="form-group required">
                        <label class="control-label themelabel" for="video_path">Video Path</label>
                        <input name="video_path" id="video_path" type="text"  class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                            <input type="submit" name="submit" value="Add Video"
                            class="btn btn-primary"></span>
                </div>
            </div>
        </form>
        </div>
        
    </div>
    <!-- <div id="viewVideoContainer" style="display:none;"> -->
    <div id="videos">
        </div>    
    <!-- </div> -->

    
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