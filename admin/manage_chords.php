<?php
session_start();
include_once('ui_utility.php');
if (!isset($_SESSION['login_user'])){
    header("Location:index.php");
}
?>
<head>
    <title>Manage Chords</title>
       <!-- Bootstrap Core CSS -->
      <link href="../css/bootstrap.min.css" rel="stylesheet">

      <!-- Custom CSS -->
      <link href="../css/modern-business.css" rel="stylesheet">
</head>
<script type="text/javascript" src="../js/jquery.form.js"></script>
<script>
    $(document).ready(function () {
        $('#uploadForm').ajaxForm({
            data : {'action' : 'upload_chord'},
            beforeSubmit: function () {
                $('#uploadStatus').html('<img style="width:400px;height:200px;" src="../images/uploading.gif"/>');
            },
            success: function () {
                $('#pdfs').val('');
                $('#uploadMsg').html('pdfs uploaded successfully');
                $('#uploadStatus').html('');
            },
            error: function () {
                $('#uploadMsg').html('Pdf upload failed, please try again.');
            }
        });
    });
</script>

<body>
    <div class="container">
        <!-- images upload form -->
        <form method="post" id="uploadForm" enctype="multipart/form-data" action="chord_details.php">
            <div class="row">
                <div class="form-group">
                    <label class="control-label themelabel" for="pdfs">Choose Pdf</label>
                    <input class="form-group" type="file" name="pdfs[]" id="pdfs" multiple >
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

</body>