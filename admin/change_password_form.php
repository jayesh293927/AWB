<?php
include_once('ui_utility.php');
include_once('utility.php');
?>
<script>
    
    $(document).ready(function() { 
        
        $("#frmChangePassword").submit(function(event){
            currentPassword = $("#current_password").val();
            newPassword = $("#new_password").val();
            confirmPassword = $("#confirm_password").val();
            if(!currentPassword) {
                $("#current_password").focus();
                $("#current_password_info").text("required");
                return false;
            }
            else if(!newPassword) {
                $("#new_password").focus();
                $("#new_password_info").text("required")
                return false;
            }
            else if(!confirmPassword) {
                $("#confirm_password").focus();
                $("#current_password_info").text("required")
                return false;
            }
            if(newPassword != confirmPassword) {
                $("#new_password").val("");
                $("#confirm_password").val("");
                $("#new_password").focus();
                $("#error_message").text("New password and confirm password doesn't match");
                return false;
            } 	
            $.ajax({
                type: 'post',
                url: 'change_password_imp.php',
                data: {'currentPassword': currentPassword, 'newPassword': newPassword},
                success: function (response) {//response is value returned from php 
                    alert(response);
                    $("#current_password").val("");
                    $("#new_password").val("");
                    $("#confirm_password").val("");
                }
            });
            event.preventDefault();
        });  
    });

</script>

<br><br>
<div class="container">
    <form action="" method="post" id="frmChangePassword">
        <div class="row">
            <div class="form-group required">   
                <label class="control-label themelabel" for="current_password">Current Password</label><span id="current_password_info"></span>
            
                <input name="current_password" id="current_password" type="text"  class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="form-group required">
                <label class="control-label themelabel" for="new_password">New Password</label><span id="new_password_info"></span>
                <input name="new_password" id="new_password" type="password"  class="form-control">
            </div>
        </div>
        
        <div class="row">
            <div class="form-group required">
                    <label class="control-label themelabel" for="confirm_password">Confirm Password</label><span id="confirm_password_info"></span>
                    <input name="confirm_password" id="confirm_password" type="password"  class="form-control">
            </div>
        </div>
        
        <div class="row">
            <div class="form-group">
                <span id="error_message"></span>
            </div>
        </div>
        
        <div class="row">
            <div class="form-group">
                        <input type="submit" name="submit" value="Submit"
                        class="btn btn-primary"></span>
            </div>
        <div>
    </form>
</div>
