<?php
session_start();
include_once('utility.php');
if(isset($_SESSION['login_user']) && isLoginSessionExpired()){
    header("Location:logout.php?session_expired=1");
}else if(isset($_SESSION['login_user']) && !isLoginSessionExpired()) {
    header("Location:profile.php");   
}
?>

<head>
    <title>Admin Login</title>
    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/modern-business.css" rel="stylesheet">
</head>

<body>
    <!-- jQuery -->
    <script src="../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() { 
            $("#frmLogin").submit(function(event){
                var userName = $("#user_name").val();
                var password = $("#password").val();
                if(userName == "") 
                {
                    $("#user_name").focus();
                    return false;
                }
                else if(password == "") 
                {
                    $("#password").focus();
                    return false;
                }
                $.ajax({
                    type: 'post',
                    url: 'login.php',
                    data: {'userName': userName, 'password': password},
                    success: function (response) {//response is value returned from php 
                        if (response == "Success"){
                            window.location = "profile.php";
                        }else {
                            $("#errorMessage").html(response);
                        }
                    }
                });
                event.preventDefault();
            });
        });
    </script>

    <div id="header"></div>
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
                <ol class="breadcrumb submenu">
                    <li><a href="index.php">Login</a>
                    </li>
                </ol>
        </div>
        <!-- /.row -->

        <form id="frmLogin">
            <div class="row">
                <div class="form-group required">
                        <label class="control-label themelabel" for="username">Username</label>
                        <input name="user_name" id="user_name" type="text"  class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="form-group required">
                        <label class="control-label themelabel" for="password">Password</label><span id="password_info" class="error-info"></span>
                        <input name="password" id="password" type="password" class="form-control">
                </div>
            </div>
                
            <div class="row">
                <div class="form-group">
                            <input type="submit" name="submit" value="Login"
                            class="btn btn-primary"></span>
                </div>
            </div>

            <span class="themelabel" id="errorMessage"></span>
        </form>
        <div id="footer"></div>
    </div>

</body>

</html>