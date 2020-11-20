<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>

<?php 
include("connection.php");
if(isset($_POST['submit']))   //if the button submit clicked
 {   

$username = strtolower($_POST['username']);
$userpass = $_POST['password'];

	 if($username && $userpass)
	 {
	
 	$sql = "SELECT * FROM admin WHERE adminUsername = '$username'";
	$result = $conn->query($sql);
	$numrows = mysqli_num_rows($result);
	if($numrows!=0)
	   {
		while($row = mysqli_fetch_assoc($result))
		         {
			$dbadminid = $row['adminID'];
			$dbadminusername = $row['adminUsername'];
		    $dbadminpass = $row['adminPassword'];

				 } 
		   
		   
		  
		  if($username == $dbadminusername)
		  {
			  
			  
			// $md5userpass = md5($userpass);
			  
		     if($userpass == $dbadminpass) 
			 {
				 
				
				           $_SESSION['logadminrid'] = $dbadminid;
					       $_SESSION['logadminemail'] = $dbadminusername;
					       $_SESSION['logadminpassword'] = $dbadminpass;
				 
				
					header("Location:admin_two.php");
				 
			 }else{
		   
		   echo "<p><b><font color = 'red'>Password is wrong</font></b></p>";
	   }
			  
		    }else{
		   
		   echo "<p><b><font color = 'red'>Username is wrong</font></b></p>";
	   }
				       
	   }else{
		   
		   echo "<p><b><font color = 'red'>Username does not exist</font></b></p>";
	   }
 
 
	 }else{
		 echo "<p><b><font color = 'red'>Enter all fields</font></b></p>";
	 }
 }	
	
	
	?>
<form action="admin.php" method="POST" >
<table>
<tr>
        <td>
              <b>Username:</b>
          </td>
           <td>
              <input type='text' name='username' value=""  size="30"  placeholder="Username"/>
          </td>
        </tr>
       <tr>
         <td>
              <b>Password:</b>
           </td>
             <td>
               <input type='password' name='password' value="" placeholder="Password" size="30"/>
          </td>
      </tr>
       <tr>
      <td>
      <input type='submit' name='submit'  value='Log in' id="sign-up-button"/>
	</td>
      </tr>
      </table>
</form>
</body>
</html>