<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>index leb student</title>
<link rel = "stylesheet" type ="text/css" href="style/style.css" media="screen" />
</head>

<body>
<header><div id = "logo"></div></header>
<div class="container">
<?php
include("connection.php");
if(isset($_POST['login']))   //if the button submit clicked
 {   

$email = strtolower($_POST['email']);
$userpass = $_POST['password'];

	 if($email && $userpass)
	 {
	
 	$sql = "SELECT * FROM user WHERE userEmail = '$email'";
	$result = $conn->query($sql);
	$numrows = mysqli_num_rows($result);
	if($numrows!=0)
	   {
		while($row = mysqli_fetch_assoc($result))
		         {
			$dbuserid = $row['userID'];
			$dbemail = $row['userEmail'];
		    $dbuserpass = $row['userPassword'];

				 } 
		  if($email == $dbemail)
		  {
			  
			  
			 $md5userpass = md5($userpass);
			  
		     if($md5userpass == $dbuserpass) 
			 {
				 
				
				          
				           $_SESSION['loguserid'] = $dbuserid;
					       $_SESSION['loguseremail'] = $dbemail;
					       $_SESSION['logpassword'] = $dbuserpass;
				 
						  $newdirectory = "/wamp/www/lebstudent/users/".$_SESSION['loguserid']."";
						   
						   if($newdirectory != 1){
						   
						   $result = mkdir($newdirectory);
						   
						   }else
						   {
							   
						   }
	                       $newdirectoryprofpic = "/wamp/www/lebstudent/users/profpic/".$_SESSION['loguserid']."";
				           if($newdirectoryprofpic != 1){
						   
						   $result = mkdir($newdirectoryprofpic);
						   
						   }else
						   {
							   
						   }
				
						header("Location:profile_one.php");
				 
				
				//echo $_SESSION['loguserid'];
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
<section>
<div class = "login-input">
<form action="index.php" method="POST">

<table>
  <tr>
     <td>
      <b> Email : </b>
     </td>
        <td>
          <input  type="email" name="email" value ="" placeholder="Enter your Email"  onfocus="(!this.reset){this.value = '';this.reset = true}" />  
       </td>
       </tr>
      <tr>
        <td>
         <b> Password : </b>
        </td>
      <td>
        <input type="password" name="password"  value= "" placeholder="Enter your Password" onfocus="(!this.reset){this.value = '';this.reset = true}"/>
    </td>
  </tr>
             <tr>
              <td>
        		  <input id = "login-button" name='login' type='submit' value='Login' />
                </td>
              </tr>
           </table>

</Form>
</div>
</section>



<a  href="forgotyourpassword.php" style = "text-decoration:none"> Forgot your password ?</a>



<a   href="sign_up_one.php" style = "text-decoration:none">Sign up</a> 

<section>
<div class = "container">
<div id ="pfirst">
<p><b>Welcome to Lebstudents.com</b>
<p>Lebstudents is an Online platform for Schools and Universities(Free sign up)</p>
</div>
<div id ="psecond">
<ul>
<li><p>Create your own profile.</p></li>
<li><p>Share Bios with your colleague</p></li>
<li><p>Have informed your courses and sessions</p></li>
<li><p>Have news from administrator and tutors</p></li>
<li><p>Instant message and video confirence with tutors</p></li>
<li><p>Socialize your social profile with pics and comments with your colleague</p></li>
</ul>
</p>
</div>
</div>
</div>
</section>
<footer>Copyright by lebstudent &copy; 2020</footer>
</div>
</body>
</html>