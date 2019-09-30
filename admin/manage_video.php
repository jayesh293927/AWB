<?php
include_once('ui_utility.php');
?>
<script src="../js/jquery.toaster.js"></script>
 <script>
        $(document).ready(function() { 
            $("#frmAddVideo").submit(function(event){
                var videoPath = $("#video_path").val();
                if(videoPath == "") 
                {
                    $("#video_path").focus();
                    return false;
                }
                $.ajax({
                    type: 'post',
                    url: 'video_details.php',
                    data: {'action': 'add_video', 'video_path': videoPath},
                    success: function (response) {//response is value returned from php 
                        $.toaster({ message : 'video added successfully', title : 'Success', priority : 'success' });
                        $("#video_path").val("");
                    }
                });
                event.preventDefault();
            });
        });
</script>

<div class="container">
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