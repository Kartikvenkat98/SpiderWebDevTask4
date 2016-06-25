<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$_SESSION["username"];
$username = $_SESSION["username"];
$level = $_SESSION["level"];
$id = $_SESSION["id"];
$mod = $_SESSION["mod"];
if($username){
			echo "<span style='font-size: 24px'>Welcome <b>$username</b>.<br /><br /></span>";
			echo "<a href='Logout.php' style='color: #F00; position: absolute; right: 5%; font-size: 24px'>Logout</a><br /><br />";	
		}
		else
			echo "<span style='font-size: 30px; position: absolute; left: 30%; top: 10%'>You have to <a href='Login.php' style='color: #0F0'>Login </a> to view this page</span>";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bulletin Board</title>
<style>
body
{
	background: url(board.jpg);
	font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
}
 .button
			  {
			  	  font-size:20px;
			      background-color:black;
				  color:white;
				  border:2px solid black;
				  padding:5px;
			  }
			  .button:hover
			  {
				  background-color:white;
				  color:black;
			  }
 .buttondel
			  {
			  	  font-size:20px;
			      background-color:red;
				  color:white;
				  border:2px solid red;
				  padding:5px;
			  }
			  .buttondel:hover
			  {
				  background-color:white;
				  color:red;
			  }			  
			  
</style>
</head>

<body>

<form id="myForm" method="post">
 <input type="hidden" name="postId" />
</form>
<?php
if($level == admin)
{
	echo "<button type='button' class='button' onclick=\"location.href='Display.php'\">Admin Panel</button><br /><br />";
	echo "<button type='button' class='button' onclick=\"location.href='addPost.php'\">Add Post</button><br />";
}
if($level == editor)
{
	echo "<button type='button' class='button' onclick=\"location.href='addPost.php'\">Add Post</button><br />";
}
?>
<h1 align="center">Bulletin Board</h1>
			<?php
			if($username)
			{
				include "conn.php";
				if($level == admin && isset($_POST['postId'])) {
        $delpost = $conn->prepare("DELETE FROM posts WHERE id=?");
        if($delpost)  {
          $delpost->bind_param("i",$_POST['postId']);
        }
        else {
          die("Error preparing statement");
        }
        $delresult = $delpost->execute();
        if(!$delresult)  {
          die("Error deleting post");
        }
      }
				$seeAllQuery = "SELECT * FROM posts";
				$resAll = mysqli_query($conn, $seeAllQuery);
				if($resAll->num_rows == 0)
				{
					echo '<div id="posts" align="center" style="background-color: #CF0; font-size: 24px;">';
					echo "No posts yet.. Sorry";
					echo '</div>';
				}
				else 
				{
					/*echo "<table>";
      				echo '<tr><th>post</th><th>user</th></tr>';
     				 while($res = mysqli_fetch_array($resAll,MYSQLI_ASSOC)) 
	  				{
        				echo '<tr><td>';
        				echo $res['post'];
       	 				echo '</td><td>';
        				echo $res['user'];
						echo '</td></tr>';
					}*/
					while($res = mysqli_fetch_array($resAll, MYSQLI_ASSOC))
					{
						echo '<div id="posts" align="center" style="background-color: #CF0">';

						echo "<h4>$res[post]</h4>";
						echo "<p> by <span style='color: #00F'>$res[user]</span> at <span style='color: #090'>$res[time]</span></p>";
						
						if($level == admin)
						{
							echo "<center><input type='button' name='button' class='buttondel' value='Delete Post &times;' onClick='delPost(".$res['id'].")'></center>";
						}
						echo "</div><br /><br />";
					}
				}
						/*while($tuple = mysqli_fetch_array($result,MYSQLI_ASSOC)) 
	  					{
        					echo '<tr><td>';
        					echo $tuple['post'];
        					echo '</td><td>';
        					echo $tuple['user'];
					}*/
				mysqli_close($conn);
			}
			?>
            <script type="text/javascript">
    function delPost(postId)  {
      var cnf = window.confirm("Are you sure you want to delete this post??");
      if(cnf) {
        document.getElementById('myForm').elements[0].value = postId;
        document.getElementById('myForm').submit();
      }
    }
  </script>
</body>
</html>