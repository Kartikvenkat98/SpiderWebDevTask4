<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$_SESSION["username"];
global $username;
$username = $_SESSION["username"];
if($username){
			session_destroy();
			echo "<span style='font-size: 24px'>You have been logged out successfully..<br /><br /><a href='Login.php' style='color: #0F0'>Click Here</a> to Login.";
			
		}
		else
			echo "<span style='font-size: 24px'>You are not logged in</span>";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Member Logout</title>
<style>
body
{
	font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
}
</style>
</head>

<body background="bgimage.jpg">
</body>
</html>