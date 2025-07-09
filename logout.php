<?php
session_start();
error_reporting(0);
	//include('headerscript.php');
	date_default_timezone_set("Asia/Manila");
	
	session_destroy();
	header("Location: index.php");
	
	
?>
