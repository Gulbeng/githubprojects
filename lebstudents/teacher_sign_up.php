<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Teachers</title>
</head>

<body>
<?php
include('connection.php');
if (isset($_POST['submit'])) {
$firstname = $_POST['firstname'];
$middlename = $_POST['middlename'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$password = $_POST['password'];
$repeatpassword = $_POST['repeatpassword'];
$educationareaname = $_POST['educationareaname'];
$section = $_POST['section'];	
$grade = $_POST['grade'];
$class = $_POST['class'];
$course = $_POST['course'];
$session = $_POST['session'];
$hourDateGMT = date("H");
$hourDateLebanon = $hourDateGMT+2;
$date = date("Y.m.d $hourDateLebanon:i:s");

if($firstname&&$middlename&&$lastname&&$email&&$password&&$educationareaname)	
{
	if(empty($_POST['educationarea']))
{
	echo "<p><b><font color = 'red'>Please choose an educational area</font></b></p>";	
}
else{
	
	if(empty($_POST['titlegender']))
	
	{
	
	echo 	"<p><b><font color = 'red'>Choose The Title of the Gender</font></b></p>";
		
	}else{
	$titlegender = $_POST['titlegender'];	
	$educationarea = $_POST['educationarea'];
	if(strlen($password)>=6 && strlen($password)<=25) 
											  {
												   $passwordmd5 = md5($password);
                                                   $repeatpasswordmd5 = md5($repeatpassword);
													
													if($passwordmd5 == $repeatpasswordmd5) //check the equality
						                                                        
														 { 
														 }else
				{ 
																					 
				echo "<p><b><font color = 'red'>Your Passwords did not match,Please Type again</font></b></p>";	 
				 }//else  if($password == $repeatpassword)
											  
											  
											  }else
					            {
						 echo "<p><b><font color = 'red'>Password must be at least 6 characters</font></b></p>";
									 }
	
	
		
	            //  ------- user exist ----------                    
			
						$sqlsessionid = mysqli_query($conn,"SELECT * FROM teachers WHERE teacherEmail='$email'");
	                    $numrows3 = mysqli_num_rows($sqlsessionid);
	                     if($numrows3 == 0)           
	                     {
							 
							 
			$sql = "INSERT INTO teachers (teacherID,teacherName,teacherMiddlename,teacherLastname,teachertitleGender,teacherEmail,teacherPassword,teachereducationArea,teachereducationareaName,teacherSection,teachergradeID,teacherclassID,teacherCourse,teacherSession,teacherDate) VALUES(null,'$firstname','$middlename','$lastname','$titlegender','$email','$passwordmd5','$educationarea','$educationareaname','$section','$grade','$class','$course','$session','$date')";  //inserting to the database user when all the information are True
									
	if ($conn->query($sql) === TRUE) {				 
	
	//<! ---------------------------------------------------session retrieving --------------------------------------------

$sqlsession = mysqli_query($conn,"SELECT * FROM teachers WHERE teacherEmail='$email' AND teacherPassword='$passwordmd5'");
	$numrows = mysqli_num_rows($sqlsession);
	if($numrows!=0)
	   {
		while($row = mysqli_fetch_assoc($sqlsession))
		         {
			$dbteacherid = $row['teacherID'];
			$dbteacheremail = $row['teacherEmail'];
		    $dbteacherpass = $row['teacherPassword'];
       
				 }
	   
						   $_SESSION['logteacherid'] = $dbteacherid;
					       $_SESSION['logteacheremail'] = $dbteacheremail;
					       $_SESSION['logteacherpassword'] = $dbteacherpass;
                      
		                   header("Location:teacher_sign_up_two.php");
	   }								 
						 			}else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}	
						 }else{
							 echo "<p><b><font color = 'red'>Teacher email exist</font></b></p>";
						 }
}
}
}else{
	echo  "<p><b><font color = 'red'>Please fill all fields</font></b></p>";
}
}
?>
<form  action ="teacher_sign_up.php" method="post">
<table>
<tr>
         <td>
              <b>School or University:</b> 
           </td>
            <td>
               <input  type='radio' style="text-transform: capitalize;" name='educationarea' value="School"/>School 
              <font color = 'red'> OR </font>
               <input  type='radio' name='educationarea' value="University"/> University
          </td>
      </tr>
      <tr>
           <td>
              <b>Name of School or University :</b>
          </td>
           <td>
              <input type='text' name='educationareaname' value="" placeholder='School or University Name' size="30" />
          </td>
        </tr>
       <tr>
           <td>
              <b>First Name:</b>
          </td>
           <td>
              <input type='text' name='firstname' value="" placeholder='First name' size="30" />
          </td>
        </tr>
        <tr>
           <td>
              <b>Middle Name:</b>
          </td>
           <td>
              <input type='text' name='middlename' value="" placeholder='Middle name' size="30"  />
          </td>
        </tr>
        <tr>
           <td>
              <b>Last Name:</b>
          </td>
           <td>
              <input type='text' name='lastname' value="" placeholder='Last name' size="30"  />
          </td>
        </tr>
        <td>
              <b>Title:</b> 
           </td>
            <td>
               <input  type='radio' style="text-transform: capitalize;" name='titlegender' value="Mr."/>Mr. 
              <font color = 'red'> OR </font>
               <input  type='radio'  style="text-transform: capitalize;" name='titlegender' value="Ms."/>Ms.
               <input  type='radio'  style="text-transform: capitalize;" name='titlegender' value="Mrs."/>Mrs.
               <font color = 'red'> OR </font>
               <input  type='radio' style="text-transform: capitalize;" name='titlegender' value="Dr."/>Dr.
          </td>
      </tr>
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
               <input type='password' name='password' value="" placeholder="Password" size="30" /><font color="#999999"> "Hint:Between 6 to 25 characters" </font>
          </td>
          </tr>
          <tr>
           <td>
              <b>Repeat Password:</b> 
           </td>
            <td>
               <input type='password' name='repeatpassword' value="" placeholder="Repeat Password" size="30"/>
          </td>
      </tr>
         <input type='hidden' name='section' value='' />
         <input type='hidden' name='grade' value='' />
         <input type='hidden' name='class' value='' />
         <input type='hidden' name='course' value='' />
         <input type='hidden' name='session' value='' />
      <tr>
      <td>
      <input type='submit' name='submit'  value='Sign Up'/>
      </td>
      </tr>
      </table>
</form>
<a href ="teacher.php" style = "text-decoration:none">Back to login</a>
</body>
</html>