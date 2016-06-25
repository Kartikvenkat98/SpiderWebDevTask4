<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$username = $_SESSION["username"];
$level = $_SESSION["level"];
$id = $_SESSION["id"];
$mod = $_SESSION["mod"];
if(isset($_POST['submit']))
{
	/*session_start();
	$username = $_SESSION['username'];*/
	if($username = $_SESSION["username"]){
		echo '<span style="font-size: 24px">You are already logged in</span>';
	}
	else
	{
	global $user, $password;
	$user = $_POST['user'];
	$password = $_POST['password'];
	if($user){
		if($password){
			include('conn.php');
			$query = "SELECT * FROM users WHERE username = '$user'";
			//$numrows = mysql_num_rows($query);
			//if($numrows == 1)
			//{
				$result = mysqli_query($conn, $query);
				//if($result)
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				$dbuser = $row['username'];
				$dbpass = $row['password'];
				$dbmod = $row['mod'];
				$dblevel = $row['level'];
				if($password == $dbpass){
					$_SESSION["username"] = $dbuser;
					$_SESSION["level"] = $dblevel;
					$_SESSION["mod"] = $dbmod;
					echo "<span style='font-size: 24px'>You are logged in as $dbuser.<br /><br /><a href='Bulletin.php' style='color: #0F0'>Click here</a> to go to bulletin" ;
				//}
				/*else
					echo "You have entered the wrong password";*/
			}
			else
				echo "<span style='font-size: 24px'>The username or password you entered is wrong :( Try Again</span>";
			mysqli_close($conn);
		}
		else
			echo '<span style="font-size: 24px">You must enter your password.</span>';
		}
		else
			echo '<span style="font-size: 24px">You must enter your username.</span>';
	}
}
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
	<title>Member - Login</title>
    <style>
              body 
              {
                font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
                color: #000;
				background: url(bgimage.jpg);
              }
              h1,h3 
              {
                font-weight: 200;
              }
			  #login
			  {
				  position:absolute;
				  top: 20%;
				  left: 40%;
			  }
			  #button
			  {
			  	  font-size:20px;
			      background-color:black;
				  color:white;
				  border:2px solid black;
				  padding:5px;
			  }
			  #button:hover
			  {
				  background-color:white;
				  color:black;
			  }
        </style>
</head>
<body>
	<div id="login" align="center">
      <h1>Member Login</h1>
	  <form name="users" method="post" action="Login.php">
      <h3>Username</h3>
      <input type="text" name="user" size="30" value="<?php global $user; echo $user;?>" placeholder="Enter your username">
      <h3>Password</h3>
      <input type="password" name="password" size="30" value="<?php global $password; echo $password;?>" placeholder="Enter your password">
      <br/><br/>
      <input type="submit" id="button" name="submit" value="Login">
	
</body>
</html>﻿
