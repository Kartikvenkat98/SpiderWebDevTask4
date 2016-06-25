<?php
error_reporting(E_ALL ^ E_NOTICE);
include('conn.php');
session_start();
$_SESSION["username"];
$username = $_SESSION["username"];
$level = $_SESSION["level"];
		
 //for discarding the post
      if(isset($_POST['remId']) && !empty($_POST['remId'])) {
        $remresult = mysqli_query($conn,"DELETE FROM modposts WHERE Id=".$_POST['remId']);
        if ($remresult) {
          echo "Post discarded<br>";
        }
        else {
          die("Error discarding post");
        }
      }
      elseif (isset($_POST['allowId'])) {   //for allowing the post
        $insertresult = mysqli_query($conn,"INSERT INTO posts (post,user,time) SELECT post,user,time FROM modposts WHERE Id=".$_POST['allowId']);
        $allowresult = mysqli_query($conn,"DELETE FROM modposts WHERE Id=".$_POST['allowId']);
        if ($allowresult && $insertresult) {
          echo "Post added to bulletin board<br>";
        }
        else {
          die("Error allowing post");
        }
      }
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Panel</title>
<style>
      body 
	  {
        font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
        font-weight: 200;
		background:url(panel.jpg);
		background-repeat:no-repeat;
		background-size: cover;
      }
      th 
	  {
        background-color: #999;
        color:white;
        font-weight: 200;
      }
      th,td 
	  {
        text-align: center;
        font-family: Arial, Helvetica, sans-serif;
        padding: 10px;
        border-bottom: 1px solid darkgray;
      }
      tr:nth-child(even) 
	  {
        background-color: lightgray;
        color : black;
      }
	   #button
			  {
			  	  font-size:16px;
			      background-color: gray;
				  color:white;
				  border:2px solid gray;
				  padding:2px;
			  }
			  #button:hover
			  {
				  background-color:white;
				  color: gray;
			  }
			  
			  #buttondel
			  {
			  	  font-size:16px;
			      background-color: red;
				  color:white;
				  border:2px solid red;
				  padding:2px;
			  }
			  #buttondel:hover
			  {
				  background-color:white;
				  color: red;
			  }
			  
			  #buttonapr
			  {
			  	  font-size:16px;
			      background-color: green;
				  color:white;
				  border:2px solid green;
				  padding:2px;
			  }
			  #buttonapr:hover
			  {
				  background-color:white;
				  color: green;
			  }
    </style>
</head>

<body>

<h1>Welcome to Admin Panel</h1>
        <a href="Bulletin.php" style="font-size: 24px; color: #0F0">Go to bulletin board</a><br/>
        <a href="Logout.php" style="color: #F00; position: absolute; right: 5%; font-size: 24px">Logout</a>
        <br/>
        <form id='editForm' method="post" action="Edit.php">
          <input type="hidden" name="editUser" />
          <input type="hidden" name="editUserLevel" />
        </form>
         <form id="changePost" method="post" action="Display.php">
          <input type="hidden" name="remId" />
          <input type="hidden" name="allowId" />
        </form>
          <center>
        <h2>Registered User Details</h2>
        <table>
          <thead>
            <tr>
              <th>User Name</th><th>Access Level</th><th>Change access level</th>
            </tr>
          </thead>
          <tbody>
<?php

//echo "<button type='button' onclick=\"location.href='Editdetails.php'\">Edit Access Levels</button><br /><br />";
if($username)
{
	if($level == "admin")
	{
		include('conn.php');
		$seeAllQuery = "SELECT * FROM users";
		$resAll = mysqli_query($conn,$seeAllQuery);
if($resAll) 
	{
      /*echo "<table>";
      echo '<tr><th>Name</th><th>Level</th></th>';
      while($tuple = mysqli_fetch_array($resAll,MYSQLI_ASSOC))
	  {
		$name = $tuple['name'];
        echo '<tr><td>';
        echo $tuple['name'];
		//$name = $tuple['name'];
		//$_SESSION["name"] = $namei;
        echo '</td><td>';
        echo $tuple['level'];
		echo "<br />";
		$level = $tuple['level'];
		echo '</td><td>';
		
		if($level != admin)
		{
			echo "<button type='button' onclick='changeLevel(this)'>Edit Access Levels</button><br /><br />";
		}
		else
			echo "Access is denied... Sorry";*?
			/*echo "<input type=hidden name='name' value='{$name}'/>";
			echo "<button type='button' onclick=\"location.href='Edit.php'\">Edit Access Levels</button><br /><br />";*/
			/*echo "<form action='_' method='post'>
			 <input type=hidden name='name' value='{$name}'/>
			<button type='button' value='$name' onclick=\"location.href='Edit.php'\">Edit Access Levels</button><br /><br />
			</form>";*/
			 while($row = mysqli_fetch_array($resAll,MYSQLI_ASSOC)){
			if($row['level'] == "admin") {
              echo '<tr><td>'.$row['username'].'</td><td>'.$row['level'].'</td><td><b>Access Denied</b></td></tr>';
            }
            else {
              echo '<tr><td>'.$row['username'].'</td><td>'.$row['level'].'</td><td><button type="button" id="button" onclick="changeLevel(this)">Edit access level</button></td></tr>';
            }
    }
	  }
    else 
	{
      die("Error extracting from database");
    }
	}
	else
		echo  "<span style='font-size: 30px; position: absolute; left: 30%; top: 10%'>Sorry , You do not have access to this page</span>";
}
else{
echo "<span style='font-size: 30px; position: absolute; left: 30%; top: 10%'>You have to <a href='Login.php'><span style='color: #0F0'>Login</span>  	</a> to view this page</span>";
}
mysqli_close($conn);
?>
</tbody>
</table><br /><br />
<h2>Moderated Posts Section</h2>
        <br/>
        <?php
		include "conn.php";
          $view_mod_posts = "SELECT * FROM modposts";
          $mod_result = mysqli_query($conn,$view_mod_posts);
          if($mod_result) {
            if(mysqli_num_rows($mod_result)==0){
				echo '<div id="posts" align="center" style="background-color: #CF0">';
              echo "<br>There are no moderated posts yet.<br>";
			  echo "</div>";
			}
            else {
              while($row = mysqli_fetch_array($mod_result)) {
               echo '<div id="posts" align="center" style="background-color: #CF0">';
				echo "<h4>$row[post]</h4>";
				echo "<p> by <span style='color: #00F'>$row[user]</span> at <span style='color: #090'>$row[time]</span></p>";
                echo "<button id='buttondel' onclick='discardPost(".$row['id'].")'>Discard post &times;</button>";
                echo "<button id='buttonapr' onclick='allowPost(".$row['id'].")'>Allow post &check;</button><br>";
              }
            }
          }
          else {
            die("Error extracting from database");
          }
		   mysqli_close($conn);
         ?>
    
     <script type="text/javascript">
        function changeLevel(x) {
          var rIndex = x.parentNode.parentNode.rowIndex;
          var name = document.getElementsByTagName('table')[0].rows[rIndex].cells[0].innerHTML;
		  var level = document.getElementsByTagName('table')[0].rows[rIndex].cells[1].innerHTML;
          document.getElementById('editForm').elements[0].value = name;
		   document.getElementById('editForm').elements[1].value = level;
          document.getElementById('editForm').submit();
        }
		 function discardPost(id)  {
          var cnf = window.confirm("Are you sure you want to discard this post?");
          if(cnf) {
            document.getElementById('changePost').elements[0].value = id;
            document.getElementById('changePost').submit();
          }
        }
        //function to pass the id of the post to be allowed
        function allowPost(id)  {
          var cnf = window.confirm("Are you sure you want to allow this post?");
          if(cnf) {
            document.getElementById('changePost').elements[1].value = id;
            document.getElementById('changePost').submit();
          }
        }
      </script>
</body>
</html>