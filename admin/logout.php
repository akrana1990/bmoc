<?php
	session_start();
	session_destroy();
	session_start();
	
	$_SESSION['msg'] = "You have successfully logged out";
	header("Location:login.php");
?>