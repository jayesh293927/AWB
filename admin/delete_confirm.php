<?php
include_once('ui_utility.php');
?>
<!-- Dialog show event handler -->
<script type="text/javascript">
 $(document).ready(function () {
        $('#confirmDelete').on('show.bs.modal', function (e) {
            $message = $(e.relatedTarget).attr('data-message');
            $(this).find('.modal-body p').text($message);
            $title = $(e.relatedTarget).attr('data-title');
            $(this).find('.modal-title').text($title);
        
            // Pass form reference to modal for submission on yes/ok
            $(this).find('.modal-footer #confirm').data('user_id', $(e.relatedTarget)[0]['id']);
        });
        
        //  Form confirm (yes/ok) handler, submits form 
        $('#confirmDelete').find('.modal-footer #confirm').on('click', function(){
            console.log('dharmendra');
            $.ajax({
                type: 'post',
                url: 'user_details.php',
                data: {'action': 'delete_user', 'user_id': $(this).data('user_id')},
                success: function (response) {
                   $("#confirmDelete").modal("hide");
                }
            });
        });
 });
</script>

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


<button id="2" class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete User" data-message="Are you sure you want to delete this user ?">
    <i class="glyphicon glyphicon-trash"></i> Delete
</button>

<button id="3" class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete User" data-message="Are you sure you want to delete this user ?">
    <i class="glyphicon glyphicon-trash"></i> Delete
</button>

<button id="4" class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete User" data-message="Are you sure you want to delete this user ?">
    <i class="glyphicon glyphicon-trash"></i> Delete
</button>
