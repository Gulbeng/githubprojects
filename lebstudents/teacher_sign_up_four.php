<?php
session_start();
?>
<!doctype html>
<html>
<head>
<script>	
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
<meta charset="utf-8">
<title>teacher_sign_up_three</title>
</head>

<body>
<?php
if(isset($_GET['user']) && !empty($_GET['user'])){
	
	$user=$_GET['user'];
}
else
{
	$user = $_SESSION['logteacherid'];
	
}
	
$my_id=$_SESSION['logteacherid'];	
	
?>
<?php
	




//<-------------------------------------- php  default profile pic male female ----------------------------->

         include("connection.php");        
      
                             $check_pic_exist = mysqli_query($conn,"SELECT * FROM teacherprofilepic WHERE teacherID = ".$_SESSION['logteacherid']."");
	                         $numrows = mysqli_num_rows($check_pic_exist);
                              
				             if($numrows == 0)
							 {
								 $genderquery =mysqli_query($conn,"SELECT teachertitleGender FROM teachers WHERE teacherID = ".$_SESSION['logteacherid']."");
	                              $numrows = mysqli_num_rows($genderquery);
				                  if($numrows!=0)
	                                 {
		                               while($row = mysqli_fetch_assoc($genderquery))
		                                 {
			                           $dbusergender = $row['teachertitleGender'];
                                         }
									 
									 if($dbusergender == 'Mr.')
									 {
										 
										echo '<img id = "defaultpic" src="icons/teacher-male.png" alt="genderpic" width="310" height="350">'; 
									 }elseif($dbusergender == 'Dr.'){
										 
										 echo '<img id = "defaultpic" src="icons/doctor-male-female.jpg" alt="genderpic" width="310" height="350">'; 
									 }
									 
									 else
									 {
										 echo '<img id = "defaultpic" src="icons/teacher-female.png" alt="genderpic" width="310" height="350">'; 
									 }
									 }
								 
							 }
	?>
	
	
	
<!-------------------------------------------------  upload bar ----------------------------------------------->	
	
<form id= "uploadpicbar" action="teacher_sign_up_four.php" method="POST" enctype="multipart/form-data" >
<table>
      <tr>
       <td>
       <label for="file">Filename:</label>
      </td>
     </tr>
      <tr>
       <td>
       <input type="file" name="file" id="file" ><br>
      </td>
     </tr>
      <tr>
       <td>
       <input type="submit" name="submitpic" value="Upload">
      </td>
     </tr>
     </table>
</form>
	<?php
// <!------------------------------------------upload proccess of the pic -------------------------------------------	
	
	
	
	if(isset($_POST['submitpic']))

{
//getting data from the file and putting in variables
$profname=$_FILES["file"]["name"];
$proftype=$_FILES["file"]["type"];
$profsize=$_FILES["file"]["size"];
$hourDateGMT = date("H");
$hourDateLebanon = $hourDateGMT+2;
$date = date("Y.m.d $hourDateLebanon:i:s");
	
	
$fatcheanames = mysqli_query($conn,"SELECT * FROM teachers WHERE teacherID = ".$_SESSION['logteacherid']."");
	   $numrows = mysqli_num_rows($fatcheanames);
	    if($numrows!=0)
		{
		     while($row = mysqli_fetch_assoc($fatcheanames))
		         {
				                $dbteacheridsession = $row['teacherID'];
								$dbteachereducationarea = $row['teachereducationArea'];
								$dbteachereducationareaname = $row['teachereducationareaName'];
								$dbteachersection = $row['teacherSection'];
                 }
if($dbteachereducationarea == "School")
{
$directory ="teachers/school/".$dbteachereducationareaname."/".$_SESSION['logteacherid']."/".$dbteachersection."/profpic";
}
else{
	$directory ="teachers/university/".$dbteachereducationareaname."/".$_SESSION['logteacherid']."/".$dbteachersection."/profpic";
}
//count the files in the directory
          $files = scandir($directory);
          $num_files=count($files);

//cheching the file type
if(($_FILES["file"]["type"] == "image/jpeg")||($_FILES["file"]["type"] == "image/jpg" ||($_FILES["file"]["type"] == "image/png")))
  {
     if ($_FILES["file"]["error"] > 0 && $_FILES["file"]["error"] < 15)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
    //to display after upload is completed
	
	if($num_files <= 2)         //if the file in directory 
	    
	{

	  	      if(!file_exists($profname))          //if file doesnot exist
		  {
			
			include("connection.php");	
	  
	   // insert information in an profilepic table

			
			$sql1 ="INSERT INTO teacherprofilepic (teacherprofpicID,teacherID,teacherprofpicName,teacherprofpicType,	teacherprofpicSize,teachepicDate) VALUES(null,'".$_SESSION['logteacherid']."','$profname','$proftype','$profsize','$date')" or die("not inserted pic");
	        mysqli_query($conn, $sql1);
     
      
			
	   $fprofpic = mysqli_query($conn,"SELECT teacherprofpicID FROM teacherprofilepic WHERE teacherID = ".$_SESSION['logteacherid']."");
	   $numrows = mysqli_num_rows($fprofpic);
	    if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($fprofpic))
		         {
			     $dbprofpicid = $row['teacherprofpicID'];
                 }
       
		$fatcheanames2 = mysqli_query($conn,"SELECT * FROM teachers WHERE teacherID = ".$_SESSION['logteacherid']."");
	   $numrows = mysqli_num_rows($fatcheanames2);
	    if($numrows!=0)
		{
		     while($row = mysqli_fetch_assoc($fatcheanames2))
		         {
				                $dbteacheridsession = $row['teacherID'];
								$dbteachereducationarea = $row['teachereducationArea'];
								$dbteachereducationareaname = $row['teachereducationareaName'];
								$dbteachersection = $row['teacherSection'];
                 }
				
				
	   // move the file into the  folder
			
		if($dbteachereducationarea == "School")
{
move_uploaded_file($_FILES["file"]["tmp_name"],"teachers/school/".$dbteachereducationareaname."/".$_SESSION['logteacherid']."/".$dbteachersection."/profpic/". $_FILES["file"]["name"]);
	   
}
else{
	move_uploaded_file($_FILES["file"]["tmp_name"],"teachers/university/".$dbteachereducationareaname."/".$_SESSION['logteacherid']."/".$dbteachersection."/profpic/". $_FILES["file"]["name"]);
}
	    

       echo "<script>alert('Uploaded Successfully!')</script>";
	   
	   header("Location:teacher_profile_one.php");
			}
			}
	   
	   
		  }
		else{
			  
	//--------------------------remove the uploaded profile pic------------------------------------------------
			
			
			$fprofpic = mysqli_query($conn,"SELECT teacherprofpicID,teacherprofpicName FROM profilepic WHERE userID = ".$_SESSION['loguserid']."");
	         $numrows = mysqli_num_rows($fprofpic);
	       if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($fprofpic))
		         {
			     $dbprofpicid = $row['teacherprofpicID'];
				 $profpicname = $row['teacherprofpicName'];
                 }
				
				
		$fatcheanames3 = mysqli_query($conn,"SELECT * FROM teachers WHERE teacherID = ".$_SESSION['logteacherid']."");
	   $numrows = mysqli_num_rows($fatcheanames3);
	    if($numrows!=0)
		{
		     while($row = mysqli_fetch_assoc($fatcheanames3))
		         {
				                $dbteacheridsession = $row['teacherID'];
								$dbteachereducationarea = $row['teachereducationArea'];
								$dbteachereducationareaname = $row['teachereducationareaName'];
								$dbteachersection = $row['teacherSection'];
                 }
	    if($dbteachereducationarea == "School")
		{
		$file_to_delete = "teachers/school/".$dbteachereducationareaname."/".$_SESSION['logteacherid']."/".$dbteachersection."/profpic/".$profpicname; 
		}else{
			$file_to_delete="teachers/university/".$dbteachereducationareaname."/".$_SESSION['logteacherid']."/".$dbteachersection."/profpic/".$profpicname;
		}//file removing
		mysqli_query($conn,"DELETE FROM teacherprofilepic WHERE teacherID = ".$_SESSION['logteacherid']." AND teacherprofpicID = ".$dbprofpicid."") or die("error in delete");
        unlink($file_to_delete);
	
	        header("Location:teacher_profile_one.php");
			}
		  }
		}
		}
  }

  }else{}
}
}

	?>
</body>
</html>