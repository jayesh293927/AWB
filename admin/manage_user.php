<?php
include_once('ui_utility.php');
?>
<script src="../js/jquery.toaster.js"></script>
<script type="text/javascript">

    function createRow(userId, userName, emailId, contactNumber) {
        return `<tr id="` +userId + `">
            <td>` + userName + `</td>
            <td>` + emailId + `</td>
            <td>` + contactNumber + `</td>
            <td class="text-center"><a class='btn btn-info btn-sm' href="#"><span class="glyphicon glyphicon-edit"></span> Edit</a> <button id="` + userId + `" class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete User" data-message="Are you sure you want to delete this user ?">
            <i class="glyphicon glyphicon-trash"></i> Delete</button></td></tr>`;
    }

    $(document).ready(function () {
        $.ajax({
            type: 'get',
            url: 'user_details.php',
            data : {'action' : 'get_user_details'},
            success: function (response) {
                user_details_obj = JSON.parse(response);
                for (user_obj in user_details_obj) {
                    iCol = "";
                    user = user_details_obj[user_obj];
                    iCol = createRow(user['user_id'], user['user_name'], user['email_id'], user['contact_number']);
                    $('#userdetails').append($(iCol));
                }
            }
        });

        $("#saveUser").click(function(e){
            userName = $("#userName").val();
            password = $("#password").val();
            contactNumber = $("#contactNumber").val();
            emailId = $("#emailId").val();
            if(!userName) {
                $("#userName").focus();
                return false;
            }
            else if(!password) {
                $("#password").focus();
                return false;
            }
            $.ajax({
                type: 'post',
                url: 'user_details.php',
                data: {'action': 'create_user', 'username': userName, 'password': password, 'emailId':emailId, 'contactNumber':contactNumber},
                success: function (response) {
                    $("#userName").val("");
                    $("#password").val("");
                    $("#contactNumber").val("");
                    $("#emailId").val("");
                    $("#addUserModal").modal('hide');
                    $.toaster({ message : 'user created successfully', title : 'Success', priority : 'success' });
                }
            });
        });

        $('#confirmDelete').on('show.bs.modal', function (e) {
            $message = $(e.relatedTarget).attr('data-message');
            $(this).find('.modal-body p').text($message);
            $title = $(e.relatedTarget).attr('data-title');
            $(this).find('.modal-title').text($title);
        
            // Pass form reference to modal for submission on yes/ok
            $(this).find('.modal-footer #confirm').data('user_id', $(e.relatedTarget)[0]['id']);
        });
        
        <!-- Form confirm (yes/ok) handler, submits form -->
        $('#confirmDelete').find('.modal-footer #confirm').on('click', function(){
            $.ajax({
                type: 'post',
                url: 'user_details.php',
                data: {'action': 'delete_user', 'user_id': $(this).data('user_id')},
                success: function (response) {
                   $("#confirmDelete").modal("hide");
                   $.toaster({ message : 'user deleted successfully', title : 'Success', priority : 'success' });
                }
            });
        });

    });
</script>


<!-- Modal dialog to add user-->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group required">
            <label for="userName" class="control-label col-form-label">User Name:</label>
            <input type="text" class="form-control" id="userName">
          </div>
          <div class="form-group required">
            <label for="password" class="control-label col-form-label">Password:</label>
            <input type="text" class="form-control" id="password">
          </div>
          <div class="form-group">
            <label for="emailId" class="col-form-label">Email Id:</label>
            <input type="text" class="form-control" id="emailId">
          </div>
          <div class="form-group">
            <label for="contactNumber" class="col-form-label">Contact Number:</label>
            <input type="text" class="form-control" id="contactNumber">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="saveUser" type="button" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- end of modal dialog -->

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
<!-- end of modal dialog -->

<br><br>
<div class="container">
    <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addUserModal" >Add User</button>
    <div class="row custyle" style="background-color:azure;">
    <table id="userdetails" class="table table-striped custab">
    <thead>
        <tr>
            <th>User Name</th>
            <th>Email Id</th>
            <th>Contact number</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
        
    </table>
    </div>
</div>