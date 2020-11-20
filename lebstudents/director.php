<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Directors</title>
</head>

<body>
<?php 
include("connection.php");
if(isset($_POST['submit']))   //if the button submit clicked
 {   

$email = strtolower($_POST['email']);
$userpass = $_POST['password'];

	 if($email && $userpass)
	 {
	
 	$sql = "SELECT * FROM directors WHERE directorEmail = '$email'";
	$result = $conn->query($sql);
	$numrows = mysqli_num_rows($result);
	if($numrows!=0)
	   {
		while($row = mysqli_fetch_assoc($result))
		         {
			$dbdirectorid = $row['directorID'];
			$dbdirectoremail = $row['directorEmail'];
		    $dbdirectorpass = $row['directorPassword'];

				 } 
		   
		   
		  
		  if($email == $dbdirectoremail)
		  {
			  
			  
			 $md5userpass = md5($userpass);
			  
		     if($md5userpass == $dbdirectorpass) 
			 {
				 
				           $_SESSION['logdirectorid'] = $dbdirectorid;
					       $_SESSION['logdirectoremail'] = $dbdirectoremail;
					       $_SESSION['logdirectorpassword'] = $dbdirectorpass;
				 
						  $newdirectory = "/wamp/www/lebstudent/directors/".$_SESSION['logdirectorid']."";
						   
						   if($newdirectory != 1){
						   
						   $result = mkdir($newdirectory);
						   
						   }else
						   {
							   
						   }
	                       $newdirectoryprofpic = "/wamp/www/lebstudent/directors/profpic/".$_SESSION['logdirectorid']."";
				           if($newdirectoryprofpic != 1){
						   
						   $result = mkdir($newdirectoryprofpic);
						   
						   }else
						   {
							   
						   }
				
					header("Location:director_profile_one.php");
				 
			 }else{
		   
		   echo "<p><b><font color = 'red'>Password is wrong</font></b></p>";
	   }
			  
		    }else{
		   
		   echo "<p><b><font color = 'red'>Email is wrong</font></b></p>";
	   }
				       
	   }else{
		   
		   echo "<p><b><font color = 'red'>Email does not exist</font></b></p>";
	   }
 
 
	 }else{
		 echo "<p><b><font color = 'red'>Enter all fields</font></b></p>";
	 }
 }	
	
	
	?>



<h1>Director please LOGIN</h1>
<form action="director.php" method="POST" >
<table>
<tr>
        <td>
              <b>Email:</b>
          </td>
           <td>
              <input type='email' name='email' value="" placeholder='someone@something.com' size="30" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" />
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
<a id = "forgotindex" href="forgotyourpassword.php" style = "text-decoration:none"> Forgot your password ?</a>

<a  id = "Registration" href="director_sign_up.php" style = "text-decoration:none">Register</a>
</body>
</html>