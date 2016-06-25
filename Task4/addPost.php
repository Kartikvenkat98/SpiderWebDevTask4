<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$_SESSION["username"];
$username = $_SESSION["username"];
$level = $_SESSION["level"];
$mod = $_SESSION["mod"];
if(isset($_POST['submit']))
{
	
	include('conn.php'); 
	$_SESSION["username"];
	$username = $_SESSION["username"];
	global $post;
	$post=$_POST['post'];
	 //$sqlinsert=$conn->prepare("INSERT INTO posts VALUES($post,$username,$time)");
	 if($level == "editor" && $mod == "yes"){
	 $sqlinsert=$conn->prepare('INSERT INTO modposts VALUES(NULL,?,?,now())');
	 }
	 else{
	   $sqlinsert=$conn->prepare('INSERT INTO posts VALUES(NULL,?,?,now())');
	 }
       if($sqlinsert) 
	   {
         $sqlinsert->bind_param("ss",$post,$username);
       }
       else 
	   {
         die("Error preparing statements");
       }
       $result = $sqlinsert->execute();
	 //$sqlinsert="INSERT INTO posts VALUES($post,$username,now())";
	 //$result = mysqli_query($conn, $sqlinsert);
       /*if($sqlinsert) 
	   {
         //$sqlinsert->bind_param("s",$post);
		 $sql->bind_result($post,$user,$time);
		 $sql->store_result();
		 $result = $sql->execute();
       }
       else 
	   {
         die("Error preparing statements");
       }
       //$result = $sqlinsert->execute();*/
       if($result) 
	   {
         echo '<span style="font-size: 24px">Post has been added.<br /><br />';
      }
      else 
	  {
         echo 'Error Type : ',mysqli_error($conn),'<br>';
         die('Error inserting into database');
      }
    mysqli_close($conn);
}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Post</title>
<style>
body
{
	background:url(notes.jpg);
	color: #000;
	font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
}
h2 
{
    font-weight: 200;
}
#add
{
	 position:absolute;
	 top: 30%;
	 left: 38%;
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
 		<a href="Bulletin.php" style="font-size: 24px; color: #0F0">Go to bulletin board</a><br/>
        <a href="Logout.php" style="color: #F00; position: absolute; right: 5%; font-size: 24px">Logout</a>
	<div id="add" align="center">
	<form name="posts" method="post" action="addPost.php">
	<h2>Write Your Post</h2>
    <textarea cols="50" rows="4" name="post"><?php global $post; echo $post; ?></textarea>
    <br /><br />
    <input type="submit" id="button" name="submit" value="Add Post">
    </form>
    </div>
</body>
</html>