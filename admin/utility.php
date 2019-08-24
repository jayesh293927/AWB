<?php
function isLoginSessionExpired() {
	$login_session_duration = 10; 
	$current_time = time(); 
	if(isset($_SESSION['loggedin_time']) and isset($_SESSION["login_user"])){  
		if(((time() - $_SESSION['loggedin_time']) > $login_session_duration)){ 
			return true; 
		}
	}
	return false;
}

function getConnection(){
	$host_name = parse_ini_file("awb_config.ini")['dbHostName'];
	$user_name = parse_ini_file("awb_config.ini")['dbUserName'];
	$password = parse_ini_file("awb_config.ini")['dbPassword'];
	$datbase_name = parse_ini_file("awb_config.ini")['dbDatabaseName'];
	$connection = mysqli_connect($host_name, $user_name, $password, $datbase_name);
	return $connection;
}

?>