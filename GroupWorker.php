<?php
include 'newpop.php';
$conn = new mysqli($hostname, $username, $password, $databasename);
if ($conn->connect_error) die($conn->connect_error);

if(isset($_POST['upload'])){

  $user = $_POST['user'];
  $image = $_FILES['image'];
  $filename = $image['name'];
  $fileerror = $image['error'];
  $filetmp = $image['tmp_name'];

  $fileext = explode('.',$filename);
  $filecheck = strtolower(end($fileext));

  $fileextstored = array('png','jpg','jpeg');
  $accom_name = $_POST['accom_name'];
  $phonenumber = $_POST['phonenumber'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $email = $_POST['email'];
  $folder = 'picture/'.$filename;

     move_uploaded_file($filetmp,$folder);
     if($user == "Vendor"){
	 $query  = "INSERT INTO unreg_student VALUES('$accom_name','$phonenumber', '$username', '$password', '$email','$filename')"; 
     $result = $conn->query($query);
     if (!$result) die ("Database access failed: " . $conn->error);
	 }
	 else {
     $query  = "INSERT INTO reg_vendor VALUES('$accom_name','$phonenumber', '$username', '$password', '$email','$filename')"; 
     $result = $conn->query($query);
     if (!$result) die ("Database access failed: " . $conn->error);
	 }
    
}

?>


<html>
<head></head>
<body>

<div class="page_lgn">

<div class="logo_top">
<img src="top.png" width="100%" height="100%"/>
</div>

<form action="GroupWorker.php" method="POST">
<p><input type="text" name="username" id="username" hint="USERNAME"/></p>
<input type="password" name="pass" id="pass" hint="PASSWORD"/>
<button name="submit" id="submit">Log in</button>
</form>

<a id="forgotten" href="">Forgotten your username or password?</a>
</div>

</body>
</html>


<?php 
   include 'newpop.php';
   $conn = new mysqli($hostname, $username, $password, $databasename);
 if(isset($_POST['submit'])){
	 
	 if (isset($_POST['username'])){
	 $user = $_POST['username'];
	 $pass = $_POST['pass'];
    if ($user == "" || $pass == "")        
		echo "<span class='error'>Not all fields were entered</span><br><br>"; 
	 else {      
	 
	  $query  = " SELECT username, password FROM unreg_student WHERE username='$user' AND password='$pass' ";  
      $result = $conn->query($query); 
	 
	  if ($result->num_rows == 0){        
	    get_accomodation($user,$pass);
	  }      
	  else      
	  {        
      $_SESSION['username'] = $user;        
	  $_SESSION['pass'] = $pass;   
      
      $url = "vendor_frontEnd.php?username=" . $user;
	  header('Location: ' . $url);
	  exit();		  
	  die();     
	  } 
	}
 }
 }
 
 function get_accomodation($user,$pass){
	 include 'newpop.php';
   $conn = new mysqli($hostname, $username, $password, $databasename);
	  if ($user == "" || $pass == "")        
		echo "<span class='error'>Not all fields were entered</span><br><br>"; 
	 else {      
	 
	  $query  = " SELECT username, password FROM reg_vendor WHERE username='$user' AND password='$pass' ";  
      $result = $conn->query($query); 
	 
	  if ($result->num_rows == 0){        
	  echo "<span class='error'>Incorrect password/Username</span><br><br>";
	  }      
	  else      
	  {        
      $_SESSION['username'] = $user;        
	  $_SESSION['pass'] = $pass;        
	  $url = "Profile.php?username=" . $user;
	  header('Location: ' . $url);
	  exit();		  
	  die();
	  } 
	}
 }
 
?>
<style>
#forgotten{
	position: absolute;
	top: 90%;
	left: 10%;
	color: rgb(0,0,50);
	text-decoration: none;
}
.error{
	color:red;
	position: absolute;
	left: 420px;
	top: 60%;
}
#submit{
	width: 20%;
	height: 7%;
	position: absolute;
	top: 69%;
	left: 37%;
}
#pass{
	width: 80%;
	height: 8%;
	position: absolute;
	left: 10%;
	top: 50%;
}
#username{
	width: 80%;
	height: 8%;
	position: absolute;
	left: 10%;
	top: 37%;
}
body{
	background: rgb(0,0,50);
}
.page_lgn{
	width: 30%;
	height: 90%;
	background: white;
	position: absolute;
	left: 34%;
	top: 5%;
}
.logo_top{
	background: url(top.png)
	position: absolute;
	top: 0%;
	width: 100%;
	height: 30%;
	border-bottom: 1px solid gray;
}
</style>