<?php
include_once('ui_utility.php');
include_once('utility.php');
?>

<script src="../js/jquery.toaster.js"></script>
<script>
    
    $(document).ready(function() { 
        
        $("#frmChangePassword").submit(function(event){
            if ($("[class='error']").length > 0) {
                $("[class='error']").remove();
            }
            currentPassword = $("#current_password").val();
            newPassword = $("#new_password").val();
            confirmPassword = $("#confirm_password").val();
            if(!currentPassword) {
                $("#current_password").focus();
                $("label[for='current_password']").after('<span class="error">This field is required</span>');
                return false;
            }
            else if(!newPassword) {
                $("#new_password").focus();
                $("label[for='new_password']").after('<span class="error">This field is required</span>');
                return false;
            }
            else if(!confirmPassword) {
                $("#confirm_password").focus();
                $("label[for='confirm_password']").after('<span class="error">This field is required</span>');
                return false;
            }
            if(newPassword != confirmPassword) {
                $("#current_password").val("");
                $("#confirm_password").val("");
                $("#new_password").focus();
                $.toaster({ message : "New password and confirm password doesn't match", title : 'Error', priority : 'danger' });
                return false;
            } 	
            $.ajax({
                type: 'post',
                url: 'change_password_imp.php',
                data: {'currentPassword': currentPassword, 'newPassword': newPassword},
                success: function (response) {//response is value returned from php 
                    jObject = JSON.parse(response)
                    if(jObject['Success']) {
                        $("#current_password").val("");
                        $("#new_password").val("");
                        $("#confirm_password").val("");
                        $.toaster({ message : jObject['Success'], title : 'Success', priority : 'success' });
                    } else {
                        $.toaster({ message :  jObject['error']['msg'], title : 'Error', priority : 'danger' });
                    }
                },
                error: function() {
                    $.toaster({ message : 'Failed to change password', title : 'Error', priority : 'danger' });
                }
            });
            event.preventDefault();
        });  
    });

</script>

<br><br>
<div class="container" style="background-color:azure; padding:30px;">
    <form action="" method="post" id="frmChangePassword">
        <div class="row">
            <div class="form-group required">   
                <label class="control-label themelabel" for="current_password">Current Password</label>
                <input name="current_password" id="current_password" type="text"  class="form-control">
            </div>
        </div>
        
        <div class="row">
            <div class="form-group required">
                <label class="control-label themelabel" for="new_password">New Password</label>
                <input name="new_password" id="new_password" type="password"  class="form-control">
            </div>
        </div>
        
        <div class="row">
            <div class="form-group required">
                    <label class="control-label themelabel" for="confirm_password">Confirm Password</label>
                    <input name="confirm_password" id="confirm_password" type="password"  class="form-control">
            </div>
        </div>
  
        <div class="row">
            <div class="form-group">
                        <input type="submit" name="submit" value="Submit"
                        class="btn btn-primary">
            </div>
        <div>

    </form>
</div>
