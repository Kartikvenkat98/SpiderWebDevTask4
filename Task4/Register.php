<?php
  if(isset($_POST['submit']))
  {
     include('conn.php');    //includes the script which connects to mysql database
	 global $name, $user, $password, $repass;
     global $passErr, $nameErr, $captchaErr;
	 $passErr = $nameErr = $captchaErr = "";
     $name = $user = $password = $repass = "";
	 $flag=1;
     if(!preg_match("/^[a-zA-Z ]*$/",$_POST['name'])) 
	 {
        $nameErr = 'Name can contain only letters and whitespaces';
        $flag=0;
     }
     else
        $name=$_POST['name'];
	$user=$_POST['user'];
	$password=$_POST['password'];
	if($password != $_POST['repass'])
	{
		$passErr = 'The passwords do not match';
		$flag=0;
	}
	else
		$repass=$_POST['repass'];
	 $url = "https://www.google.com/recaptcha/api/siteverify";
    $privatekey = "Your-private-key";
    $response = file_get_contents($url."?secret=".$privatekey."&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']);
    $data = json_decode($response);
    if (!(isset($data->success) && $data->success==true)) {
      $captchaErr = "Captcha Error!!Try again.";
      $flag = 0;
    }
	 if ($flag==1) 
	 {
	   $sqlinsert=$conn->prepare('INSERT INTO users VALUES(NULL,?,?,?,"viewer","no")');
       if($sqlinsert) 
	   {
         $sqlinsert->bind_param("sss",$name,$user,$password);
       }
       else 
	   {
         die("Error preparing statements");
       }
       $result = $sqlinsert->execute();
       if($result) 
	   {
         echo '<span style="font-size: 24px">Registration successful.</span><br><br />';
         echo '<span style="font-size: 24px"><a href="Login.php" style="color:#0F0;">Click Here</a> to Login</span>';
      }
      else 
	  {
         echo 'Error Type : ',mysqli_error($conn),'<br>';
         die('Error inserting into database');
      }
    }
    mysqli_close($conn);
  }
?>
<html>
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Member Registration</title>
        <style>
              body 
              {
                font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
                color:#000;
				background: url(bgimage.jpg);
              }
              h1,h3 
              {
                font-weight: 200;
              }
              .error 
              {
                color: red;
              }
			  #register
			  {
				  position:absolute;
				  left: 35%;
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
        <script src='https://www.google.com/recaptcha/api.js'></script>
	</head>

	<body>
    	<div id="register" align="center">
        <h1>Member Registration Details</h1>
    	<form name="student" method="post" action="register.php">
      	<h3>Name</h3>
      	<input type="text" name="name" size="30" value="<?php global $name; echo $name;?>" placeholder="Enter your name" required><br />
        <span class="error"><?php global $nameErr; echo $nameErr;?></span><br/>
        <h3>Username</h3>
        <input type="text" name="user" size="30" value="<?php global $user; echo $user;?>" placeholder="Enter your username" required>
        <h3>Password</h3>
        <input type="password" name="password" size="30" value="<?php global $password; echo $password;?>" placeholder="Enter your password" required>
        <h3>Re-enter Password</h3>
        <input type="password" name="repass" size="30" value="<?php global $repass; echo $repass;?>" placeholder="Re-enter your password" required><br />
        <span class="error"><?php global $passErr; echo $passErr;?></span><br/>
        <br/><br/>
         <div class="g-recaptcha" data-sitekey="Your-public-key"></div>
          <span class="error"><?php global $captchaErr; echo $captchaErr; ?></span><br /><br />
        <input type="submit" id="button" name="submit" value="Register">
        </form>
        </div>
	</body>
</html>