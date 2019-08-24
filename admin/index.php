<?php
include_once('login.php'); // Includes Login Script
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
        function validate() {
            var $valid = true;
            var userName = $("#user_name").val();
            var password = $("#password").val();
            if(userName == "") 
            {
                $("#user_info").text("required");
                $valid = false;
            }
            else if(password == "") 
            {
                $("#password_info").text("required");
                $valid = false;
            }
            return $valid;
        }
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

        <form action="" method="post" id="frmLogin" onSubmit="return validate();">
            <?php 
                if(isset($_SESSION["`error`Message"])) {
                ?>
            <div class="error-message">
                <?php  echo $_SESSION["errorMessage"]; ?>
            </div>
            <?php 
                unset($_SESSION["errorMessage"]);
                } 
                ?>
            <div class="row">
                <div class="form-group required">
                        <label class="control-label" for="username">Username</label><span id="user_info" class="error-info"></span>
                        <input name="user_name" id="user_name" type="text"  class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="form-group required">
                        <label class="control-label" for="password">Password</label><span id="password_info" class="error-info"></span>
            
                        <input name="password" id="password" type="password"  class="form-control">
                </div>
            </div>
                
            <div class="row">
                <div class="form-group">
                            <input type="submit" name="submit" value="Login"
                            class="btn btn-primary"></span>
                </div>
            </div>

            <span><?php echo $error; ?></span>
        </form>
        <div id="footer"></div>
    </div>