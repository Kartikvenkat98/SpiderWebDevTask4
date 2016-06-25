<?php
    session_start();
    $username = $_SESSION["username"];
    $level = $_SESSION["level"];
    if(isset($_POST['editUser'])) {
      $_SESSION['editUser'] = $_POST['editUser'];
	  $_SESSION['editUserLevel'] = $_POST['editUserLevel'];
    }
    if(!$username) {
    echo "<span style='font-size: 30px; position: absolute; left: 30%; top: 10%'>You have to <a href='Login.php' style='color: #0F0'>Login </a> to view this page</span>";
    }
	 elseif($level != "admin"){
      echo "You don't have the required access to this page. Sorry. :(";
    }
   
    else {
        include('conn.php');
        if(isset($_POST['submit']) && !empty($_POST['access'])) {
          $access = $_POST['access'];
          $user = $_SESSION['editUser'];
            /*$updateLevel = $conn->prepare("UPDATE users SET level=? WHERE username=?");
            if($updateLevel)  {
              $updateLevel->bind_param("ss",$access,$user);
            }
            else {
              die("Error preparing statement");
            }
            $result = $updateLevel->execute();
            if($result) {
              echo "Access Level Modified";
            }
            else {
              die("Error updating database");
            }
		  
        }*/
		if($level == "editor"){
		$mod = $_POST['mod'];
		if($mod)  {
			//echo "hello";
            $updateLevel = $conn->prepare("UPDATE users SET level=?, mod=? WHERE username=?");
            if($updateLevel)  {
			  echo "hi";
              $updateLevel->bind_param("sss",$access,$mod,$user);
            }
            else {
              die("Error preparing statement");
            }
          }
          /*else {
            $updateLevel = $conn->prepare("UPDATE users SET level=? WHERE username=?");
            if($updateLevel)  {
              $updateLevel->bind_param("ss",$access,$user);
            }
            else {
              die("Error preparing statement");
            }
		  }*/
		}
		  else{
		  	 $updateLevel = $conn->prepare("UPDATE users SET level=? WHERE username=?");
            if($updateLevel)  {
              $updateLevel->bind_param("ss",$access,$user);
            }
            else {
              die("Error preparing statement");
            }
		  }
            $result = $updateLevel->execute();
            if($result) {
              echo "Changes Saved";
            }
            else {
              die("Error updating database");
            }
        }
		mysqli_close($conn);
?>

    <html>
      <head>
        <title>Edit Access Page</title>
        <meta charset="utf-8">
        <style>
          body {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
			text-align: center;
			background:url(bgimage.jpg);
          }
          h1,h2,h3 {
            font-weight: 400;
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
        <h1>Edit Access Level</h1>
        <a href="Display.php" style="font-size: 24px; color: #0F0; position: absolute;left: 2%">Go to Admin Panel</a><br/>
        <a href="Logout.php" style="color: #F00; position: absolute; right: 5%; font-size: 24px">Logout</a>
        <form action="Edit.php" method="post">
          <h3>Username</h3>
          <input type="text" name="username" value="<?php echo $_SESSION['editUser']; ?>" size="50" readonly/>
          <h3>Access Level</h3>
          <input list="level" name="access" size="50" value="<?php global $access; echo $access;?>" placeholder="admin" required><br />
          <datalist id="level">
          <option value="viewer">
          <option value="editor">
          <option value="admin">
          </datalist><br /><br />
           <?php
		   	include "conn.php";
            if($_SESSION['editUserLevel'] == "editor")  {
          ?>
          <h3>Mark as Moderated?</h3>
            <input type="radio" name="mod" value="Yes" />Yes<br />
            <input type="radio" name="mod" value="No" checked />No<br/><br/>
            
          <?php
            }
          ?>
          <input type="submit" id="button" name="submit" value="Save Changes"/>
        </form>
      </body>
    </html>

<?php
	mysqli_close($conn);
  }
?>