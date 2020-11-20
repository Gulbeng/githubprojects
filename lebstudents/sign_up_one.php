<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>sign up</title>
</head>

<body>
<?php include('connection.php'); ?>
<?php
if (isset($_POST['submit'])) {
$email = $_POST['email'];
$password = $_POST['password'];
$repeatpassword = $_POST['repeatpassword'];
$firstname = $_POST['firstname'];
$middlename = $_POST['middlename'];
$lastname = $_POST['lastname'];
$hometown = $_POST['hometown'];
$relationship = $_POST['relationship'];
$schooluniname = $_POST['schooluniname'];
$selectday=$_POST['selectday'];
$selectmonth=$_POST['selectmonth'];
$selectyear=$_POST['selectyear'];
$grade = $_POST['grade'];
$class = $_POST['class'];
$userteacher = $_POST['userteacher'];
$usercourse = $_POST['usercourse'];
$usersession = $_POST['usersession'];
$hourDateGMT = date("H");
$hourDateLebanon = $hourDateGMT+2;
$date = date("Y.m.d $hourDateLebanon:i:s");
	
	
if($email&&$password&&$repeatpassword&&$selectday&&$selectmonth&&$selectyear&&$selectyear) //check if all true
                
		        {	
	if(empty($_POST['gender']))
{
	echo "<p><b><font color = 'red'>Please choose the gender</font></b></p>";	
}
else{

$gender = $_POST['gender'];
	
	
	
if(empty($_POST['educationarea']))
{
	echo "<p><b><font color = 'red'>Please choose the educationla area</font></b></p>";	
}
else{

$educationarea = $_POST['educationarea'];
if($email)
{
if($selectday != 'Day' && $selectmonth != 'Month' && $selectyear != 'Year')
						{
							
					                if(strlen($password)>=6 && strlen($password)<=25) 
											  {
												   $passwordmd5 = md5($password);
                                                   $repeatpasswordmd5 = md5($repeatpassword);
													
													if($passwordmd5 == $repeatpasswordmd5) //check the equality
						                                                        
														 { 
															 
	
														$sqlreg = mysqli_query($conn,"SELECT * FROM user WHERE userEmail='$email'");
	                     $numrows1 = mysqli_num_rows($sqlreg);
	                     if($numrows1==0)                        //  ------- user exist ----------
	                     {
		                  
							 
						
						 }
							 
							 
				//  ------- user exist ----------			 
							$sqlsessionid = mysqli_query($conn,"SELECT * FROM user WHERE userEmail='$email'");
	                    $numrows3 = mysqli_num_rows($sqlsessionid);
	                     if($numrows3 == 0)                        
	                     { 						 
						 
			$sql = "INSERT INTO user (userID,userEmail,userPassword,firstName,middleName,lastName,userHometown,userGender,userRelationship,birthDay,birthMonth,birthYear,educationalArea,	schooluniName,userGrade,userClass,userTeacher,userCourse,userSession,userDate) VALUES(null,'$email','$passwordmd5','$firstname','$middlename','$lastname','$hometown','$gender','$relationship','$selectday','$selectmonth','$selectyear','$educationarea','$schooluniname','$grade','$class','$userteacher','$usercourse','$usersession','$date')";  //inserting to the database user when all the information are True
									
							if ($conn->query($sql) === TRUE) {	
								
		//  ------------------- ------------------------------make a directories -------------------------------
								
						$sqlfetchsessionid = mysqli_query($conn,"SELECT * FROM user WHERE userEmail='$email'");
	                    $numrows3 = mysqli_num_rows($sqlfetchsessionid);
	                     if($numrows3 != 0)                        
	                     {
							 while($row3 = mysqli_fetch_assoc($sqlfetchsessionid))
							 {
								 
								$dbuseridsession = $row3['userID']; 
							 }
							    
						    
								   $newdirectoryid = "users/".$dbuseridsession;
		                           $mkdirid = mkdir($newdirectoryid);
							 
							       $newdirectoryprofpic = "users/".$dbuseridsession."/profpic";
							       $mkdirprofpic = mkdir($newdirectoryprofpic);
							 
							       $newdirectoryphotos = "users/".$dbuseridsession."/photos";
		                           $mkdirphotos = mkdir($newdirectoryphotos);
							 
							       $newdirectorycoverphoto = "users/".$dbuseridsession."/covers";
		                           $mkdirphotos = mkdir($newdirectorycoverphoto);
							 							
								
	
	//<! ---------------------------------------------------session retrieving --------------------------------------------

$sqlsession = mysqli_query($conn,"SELECT * FROM user WHERE userEmail='$email' AND userPassword='$passwordmd5'");
	$numrows = mysqli_num_rows($sqlsession);
	if($numrows!=0)
	   {
		while($row = mysqli_fetch_assoc($sqlsession))
		         {
			$dbuserid = $row['userID'];
			$dbuseremail = $row['userEmail'];
		    $dbuserpass = $row['userPassword'];
       
				 }
	   
						   $_SESSION['loguserid'] = $dbuserid;
					       $_SESSION['loguseremail'] = $dbuseremail;
					       $_SESSION['logpassword'] = $dbuserpass;
                       
		                   header("Location:sign_up_two.php");
	   }								 
								
						 
						 }
								
							}else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
						 
							 
						 }
						 else{
															 
		echo "<p><b><font color = 'red'>Student email Exist</font></b></p>";
														 }
																					 
																					 
																					 
																					
	
																				 
																				 }else
				{ 
																					 
				echo "<p><b><font color = 'red'>Your Passwords did not match,Please Type again</font></b></p>";	 
				 }//else  if($password == $repeatpassword)
											  }else
					 {
						 echo "<p><b><font color = 'red'>Password must be at least 6 characters</font></b></p>";
											  }
											  
	
	
	
						}else
						{
							
							echo "<p><b><font color = 'red'>Please specify the Birth</font></b></p>";
							}
	
	}else{
	echo "<p><b><font color = 'red'>Please enter your Email</font></b></p>";
}
}
	}
				
				
				}
else{

echo  "<p><b><font color = 'red'>Please fill all fields</font></b></p>";	
	
}
	
	
}
?>
<form action="sign_up_one.php" method ="POST" >


<table class = "table-signup">
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
              <b>Password:</b><font color="#999999"> "Hint:Between 6 to 25 characters" </font>
           </td>
             <td>
               <input type='password' name='password' value="" placeholder="Password" />
          </td>
      </tr>
            <input type='hidden' name='firstname' value='' />
            <input type='hidden' name='middlename' value='' />
             <input type='hidden' name='lastname' value='' />
            <tr>
         <td>
              <b>Repeat Password:</b> 
           </td>
            <td>
               <input type='password' name='repeatpassword' value="" placeholder="Repeat Password"/>
          </td>
      </tr>
      <tr>
         <td>
              <b>Gender :</b> 
           </td>
            <td>
               <input  type='radio' name='gender' value="Male"/>Male
               <input  type='radio' name='gender' value="Female"/>Female
          </td>
          <input type='hidden' name='hometown' value='' />
          <input type='hidden' name='relationship' value='' />
          <tr>
         <td>
              <b>Educational Area :</b> 
           </td>
            <td>
               <input  type='radio' style="text-transform: capitalize;" name='educationarea' value="School"/>School
               <input  type='radio' name='educationarea' value="University"/>University
          </td>
      </tr>
       <input type='hidden' name='schooluniname' value='' />
      </tr>
      <tr>
         <td>
              <b>Birthday:</b> 
           </td>
            <td>
               <select name ='selectday'>
                     <option value ="Day">Day</option>
                     <option value ="1">1</option>
                     <option value ="2">2</option>
                     <option value ="3">3</option>
                     <option value ="4">4</option>
                     <option value ="5">5</option>
                     <option value ="6">6</option>
                     <option value ="7">7</option>
                     <option value ="8">8</option>
                     <option value ="9">9</option>
                     <option value ="10">10</option>
                     <option value ="11">11</option>
                     <option value ="12">12</option>
                     <option value ="13">13</option>
                     <option value ="14">14</option>
                     <option value ="15">15</option>
                     <option value ="16">16</option>
                     <option value ="17">17</option>
                     <option value ="18">18</option>
                     <option value ="19">19</option>
                     <option value ="20">20</option>
                     <option value ="21">21</option>
                     <option value ="22">22</option>
                     <option value ="23">23</option>
                     <option value ="24">24</option>
                     <option value ="25">25</option>
                     <option value ="26">26</option>
                     <option value ="27">27</option>
                     <option value ="28">28</option>
                     <option value ="29">29</option>
                     <option value ="30">30</option>
                     <option value ="31">31</option>
                    </select>
                    <select name ='selectmonth'>
                     <option value ="Month">Month</option>
                     <option value ="January">January</option>
                     <option value ="February">February</option>
                     <option value ="March">March</option>
                     <option value ="April">April</option>
                     <option value ="May">May</option>
                     <option value ="June">June</option>
                     <option value ="July">July</option>
                     <option value ="August">August</option>
                     <option value ="September">September</option>
                     <option value ="October">October</option>
                     <option value ="November">November</option>
                     <option value ="December">December</option>
                    </select>
                    
                    
                    <select name ='selectyear'>
                    <option value ="Year">Year</option>
                    <?php
						$year = date('Y');
						$min = $year - 80;
						$max = $year;
						for($i=$max;$i >= $min ; $i--)
						{
							
							echo "<option value".$i.">".$i."</option>";
						}
						
						
						?>
                    </select>
          </td>    
          </tr>
         </tr>
         <input type='hidden' name='grade' value='' />
         <input type='hidden' name='class' value='' />
         <input type='hidden' name='userteacher' value='' />
         <input type='hidden' name='usercourse' value='' />
         <input type='hidden' name='usersession' value='' />
      <tr>
      <td>
      <input type='submit' name='submit'  value='Register' id="sign-up-button"/>
	</td>
      </tr>
</table>


</form>

<a href ="index.php" style = "text-decoration:none">Back to login</a>
</body>
</html>