<?php
session_start();
include_once('ui_utility.php');
if (!isset($_SESSION['login_user'])){
    header("Location:index.php");
}
?>

<head>
    <title>Profile</title>
</head>

<body>
    <div id="header"></div>
    <div class="container">
        <div id="footer"></div>
    </div>
</body>

 </html