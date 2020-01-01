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
    function createCol(chord_name, chord_id, chord_description) {
            return `<div class="col-md-6 text-center">
                <div class="thumbnail">
                    <img class="img-responsive" src="`+ chord_name + `" alt="">
                    <div class="caption">
                        <h3>`+chord_description+`<br>
                            
                        </h3>
                    </div>
                    <button id="` + chord_id +`" class="btn btn-sm btn-danger" type="button" data-toggle="modal" 
                    data-target="#confirmDelete" data-title="Delete User" data-message="Are you sure you want to delete `+chord_description+` ?">
                    <i class="glyphicon glyphicon-trash"></i> Delete
                    </button>
                </div>
            </div>`;
    }

    function get_pdf() {
        $.ajax({
                url: "chord_details.php",
                type: "GET",
                data: {'action' : 'get_chord_details'},
                success: function (response) {
                    $('#chordcharts').html("");
                    chord_details_obj = JSON.parse(response);
                    for (chord_obj in chord_details_obj) {
                        iCol = "";
                        //+ chord_details_obj[chord_obj]['chord_path']
                        iCol = createCol("../" + chord_details_obj[chord_obj]['chord_path'] + chord_details_obj[chord_obj]['chord_name'], chord_details_obj[chord_obj]['chord_id'], chord_details_obj[chord_obj]['chord_name']);
                        $('#chordcharts').append($(iCol));
                    }
                }
            });
    }
    $(document).ready(function () {
        $('#uploadpdf').click(function(){
            $('#viewPdfContainer').hide();
            $('#uploadPdfContainer').show();
        });        

        $('#viewPdf').click(function(){
            $('#uploadPdfContainer').hide();
            $('#viewPdfContainer').show();
            get_pdf();
        });

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

        
         //changing
        $('#confirmDelete').on('show.bs.modal', function (e) {
                $message = $(e.relatedTarget).attr('data-message');
                $(this).find('.modal-body p').text($message);
                $title = $(e.relatedTarget).attr('data-title');
                $(this).find('.modal-title').text($title);
            
                // Pass form reference to modal for submission on yes/ok
                $(this).find('.modal-footer #confirm').data('chord_id', $(e.relatedTarget)[0]['id']);
        });
            
        $('#confirmDelete').find('.modal-footer #confirm').on('click', function(){
            chord_id = $(this).data('chord_id');
            $.ajax({
                type: 'post',
                url: 'chord_details.php',
                data: {'action': 'delete_pdf', 'chord_id': chord_id},
                success: function (response) {
                  jObject = JSON.parse(response);
                  if(jObject['Success']) {
                    $("#confirmDelete").modal("hide");
                    $.toaster({ message : jObject['Success'], title : 'Success', priority : 'success' });
                     get_pdf();
                  } else {
                      $.toaster({ message :  jObject['error']['msg'], title : 'Error', priority : 'danger' });
                  } 
                },
                error: function() {
                    $.toaster({ message : 'Failed to delete PDF', title : 'Error', priority : 'danger' });
                }
            });
        });
    });
</script>

<body>
    <div class="container">
        <br>
        <div class="row">
            <button id="uploadpdf" type="button" class="btn btn-primary">Upload Pdf</button>
            <button id="viewPdf" type="button" class="btn btn-primary">View Pdfs</button>
        </div>
        <br>
        <br>
        <!-- images upload form -->
        <div id="uploadPdfContainer" style="display:none;">
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
        </div>
        <div id="viewPdfContainer" style="display:none;">
            <br><br>
        <div class="chordcharts" id="chordcharts" >
        </div>
        </div>
        </form>

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