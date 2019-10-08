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
<script src="../js/jquery.toaster.js"></script>
<script type="text/javascript" src="../js/jquery.form.js"></script>
<script>
    $(document).ready(function () {
        $('#uploadForm').ajaxForm({
            data : {'action' : 'upload_chord'},
            beforeSubmit: function () {
                if ($("[class='error']").length > 0) {
                    $("[class='error']").remove();
                }
                var file_data = $('#pdfs').prop('files');
                if (file_data.length==0){
                    $("#pdfs").focus();
                    $("label[for='pdfs']").after('<span class="error">This field is required</span>');
                    return false;
                }
                $('#uploadStatus').html('<img style="width:400px;height:200px;" src="../images/uploading.gif"/>');
            },
            success: function (response) {
                jObject = JSON.parse(response);
                if(jObject['Success']){
                    $('#pdfs').val('');
                    $('#uploadStatus').html('');
                    $.toaster({ message : jObject['Success'], title : 'Success', priority : 'success' });
                } else {
                    $.toaster({ message : jObject['error']['msg'], title : 'Error', priority : 'danger' });
                }
            },
            error: function () {
                $.toaster({ message : 'Failed to upload pdf', title : 'Error', priority : 'danger' });
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

        </form>

    </div>

</body>