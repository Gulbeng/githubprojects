<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>teacher profile</title>
</head>

<body>
<?php 
	
	include('functions.php');
	
	?>
<a href="#" id = "uploadpiclink" style = "text-decoration:none">upload pic</a>

<!-------------------------------- form to upload a profile pic ------------------------------------------------>

<form id= "uploadpicbar" action="teacher_profile_one.php" method="POST" enctype="multipart/form-data" >
<table>
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
include('connection.php');
$my_id = $_SESSION["logteacherid"];

//<!------------------ php  default profile pic male female ----------------------------->		
		
			 	 	       $check_pic_exist = mysqli_query($conn,"SELECT * FROM teacherprofilepic WHERE teacherID = ".$my_id."");
	                         $numrows = mysqli_num_rows($check_pic_exist);
                              
				             if($numrows == 0)
							 {
								 $genderquery =mysqli_query($conn,"SELECT teachertitleGender FROM teachers WHERE teacherID = ".$my_id."");
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
									 }
									 elseif($dbusergender == 'Dr.'){
										 echo '<img id = "defaultpic" src="icons/doctor-male-female.jpg" alt="genderpic" width="310" height="350">';
										 
									 }else
									 {
										 echo '<img id = "defaultpic" src="icons/teacher-female.png" alt="genderpic" width="310" height="350">'; 
									 }
									 }
								 
							 
								 
							 }else{
									 
// ---------------------------------display the pic of profile----------------------------
 $teacherpicname=getteacherpicname($my_id,'teacherprofpicName');
								 
								 
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
	$dir = "teachers/school/".$dbteachereducationareaname."/".$my_id."/".$dbteachersection."/profpic/".$teacherpicname;
	}else{
		$dir = "teachers/university/".$dbteachereducationareaname."/".$my_id."/".$dbteachersection."/profpic/".$teacherpicname;
		
	}
echo '<img id="teacherprofpic" src="'.$dir.'" alt="prof pic" width="120" height="180">'; 
		}
							 }  
	
	
	
	
// <!--------------------------------- php to upload a profile pic -------------------------------->




if(isset($_POST['submitpic']))
{
//getting data from the file and putting in variables
$profname=$_FILES["file"]["name"];
$proftype=$_FILES["file"]["type"];
$profsize=$_FILES["file"]["size"];
$hourDateGMT = date("H");
$hourDateLebanon = $hourDateGMT+2;
$date = date("Y.m.d $hourDateLebanon:i:s");

	
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
								
	
	
	if($dbteachereducationarea == "School")
	{
$directory ="teachers/school/".$dbteachereducationareaname."/".$my_id."/".$dbteachersection."/profpic";
	}else{
$directory ="teachers/university/".$dbteachereducationareaname."/".$my_id."/".$dbteachersection."/profpic";
	}
//count the files in the directory
          $files = scandir($directory);
          $num_files=count($files);

if($profname)
{
//cheching the file type
if(($_FILES["file"]["type"] == "image/jpeg")||($_FILES["file"]["type"] == "image/jpg" ||($_FILES["file"]["type"] == "image/png")))
  {
     if ($_FILES["file"]["error"] > 0 && $_FILES["file"]["error"] < 15)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
    //display after upload is completed

    //count the number of files is minimum 3 files
     if($num_files <= 2)
	    {		
			include("connection.php");	
	  
	   // insert information in an profilepic table

			
			$sql1 ="INSERT INTO teacherprofilepic (teacherprofpicID,teacherID,	teacherprofpicName,teacherprofpicType,teacherprofpicSize,teachepicDate) VALUES(null,'".$my_id."','$profname','$proftype','$profsize','$date')" or die("not inserted pic");
	        mysqli_query($conn, $sql1);
     
      
			
	   $fprofpic = mysqli_query($conn,"SELECT teacherprofpicID FROM teacherprofilepic WHERE teacherID = ".$my_id."");
	   $numrows = mysqli_num_rows($fprofpic);
	    if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($fprofpic))
		         {
			     $dbprofpicid = $row['teacherprofpicID'];
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
						 
						
	   // move the file into the  folder
	    
	   if($dbteachereducationarea == "School")
	{
move_uploaded_file($_FILES["file"]["tmp_name"],"teachers/school/".$dbteachereducationareaname."/".$my_id."/".$dbteachersection."/profpic/". $_FILES["file"]["name"]);
	}else{
move_uploaded_file($_FILES["file"]["tmp_name"],"teachers/university/".$dbteachereducationareaname."/".$my_id."/".$dbteachersection."/profpic/". $_FILES["file"]["name"]);
	}

       echo "<script>alert('Uploaded Successfully!')</script>";
	   
	  
		//		if ( basename($_SERVER['PHP_SELF']) == "profile_one.php"){    
		   
        //   header("Location:profile_one.php");
     
            
         //     }else{
		
		header("Location:teacher_profile_one.php");
		
//	}
			}
			}
	   
	   //count the number of files is minimum 3 files remove the file from directory
		}
		else{
							
      
			
	   $fprofpic = mysqli_query($conn,"SELECT teacherprofpicID FROM teacherprofilepic WHERE teacherID = ".$my_id."");
	   $numrows = mysqli_num_rows($fprofpic);
	    if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($fprofpic))
		         {
			     $dbprofpicid = $row['teacherprofpicID'];
                 }
				
		// ---------------------------------- remove from profilepic table	------------------------------------------			
			
			 $fprofpic = mysqli_query($conn,"SELECT * FROM teacherprofilepic WHERE teacherID = ".$my_id."");
	        $numrows = mysqli_num_rows($fprofpic);
	      if($numrows!=0)
	        {
	     while($row = mysqli_fetch_assoc($fprofpic))
	         {
		     $dbprofpicid = $row['teacherprofpicID'];
			 $profpicname = $row['teacherprofpicName'];
                }
		 $fatcheanames4 = mysqli_query($conn,"SELECT * FROM teachers WHERE teacherID = ".$_SESSION['logteacherid']."");
	   $numrows = mysqli_num_rows($fatcheanames4);
	    if($numrows!=0)
		{
		     while($row = mysqli_fetch_assoc($fatcheanames4))
		         {
				                $dbteacheridsession = $row['teacherID'];
								$dbteachereducationarea = $row['teachereducationArea'];
								$dbteachereducationareaname = $row['teachereducationareaName'];
								$dbteachersection = $row['teacherSection'];
                 }						
						 

	                // file pic directory   
			if($dbteachereducationarea == "School")
	{
$file_to_delete = "teachers/school/".$dbteachereducationareaname."/".$my_id."/".$dbteachersection."/profpic/".$profpicname;
	}else{
$file_to_delete = "teachers/university/".$dbteachereducationareaname."/".$my_id."/".$dbteachersection."/profpic/".$profpicname;
	}
	
				$sql1 = "DELETE FROM teacherprofilepic WHERE teacherID = ".$my_id." AND teacherprofpicID = ".$dbprofpicid."";
				if (mysqli_query($conn, $sql1)) {
               
                 } else {
                 
                }
			}
			}
						 
				
		unlink($file_to_delete);    //file removing from directory		
				
		$sql1 ="INSERT INTO teacherprofilepic (teacherprofpicID,teacherID,teacherprofpicName,teacherprofpicType,teacherprofpicSize,teachepicDate) VALUES(null,'".$my_id."','$profname','$proftype','$profsize','$date')" or die("not inserted pic");
	        mysqli_query($conn, $sql1);
     		
     $fatcheanames5 = mysqli_query($conn,"SELECT * FROM teachers WHERE teacherID = ".$_SESSION['logteacherid']."");
	   $numrows = mysqli_num_rows($fatcheanames5);
	    if($numrows!=0)
		{
		     while($row = mysqli_fetch_assoc($fatcheanames5))
		         {
				                $dbteacheridsession = $row['teacherID'];
								$dbteachereducationarea = $row['teachereducationArea'];
								$dbteachereducationareaname = $row['teachereducationareaName'];
								$dbteachersection = $row['teacherSection'];
                 }	
							
	   
			
			
			if($dbteachereducationarea == "School")
	{
move_uploaded_file($_FILES["file"]["tmp_name"],"teachers/school/".$dbteachereducationareaname."/".$my_id."/".$dbteachersection."/profpic/". $_FILES["file"]["name"]);
	}else{
move_uploaded_file($_FILES["file"]["tmp_name"],"teachers/university/".$dbteachereducationareaname."/".$my_id."/".$dbteachersection."/profpic/". $_FILES["file"]["name"]);
	}
	   // move the file into the audio folder
	    
	   

       echo "<script>alert('Uploaded Successfully!')</script>";
	   
	  
		//		if ( basename($_SERVER['PHP_SELF']) == "profile_one.php"){    
		   
        //   header("Location:profile_one.php");
     
            
         //     }else{
		
		header("Location:teacher_profile_one.php");
			}
//	}
			}
				
			} 
		
		}
		

		}
    
  
	else
  {
  echo "<script>alert('format not allowed or too big')</script>";//Error message  if it's too big or wrong extension

  }
}else{}
		}
  }	

	
 
//---------------------------------------------------- display info ------------------------------------------>

$getinfo = mysqli_query($conn,"SELECT * FROM teachers WHERE teacherID =".$my_id."");
$numrows = mysqli_num_rows($getinfo);
  if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($getinfo))
		         {
				 $dbteacherid = $row['teacherID'];	 
				 $dbteachername = $row['teacherName'];
				 $dbteachermiddlename = $row['teacherMiddlename'];
				 $dbteacherlastname = $row['teacherLastname'];
                 $dbteachertitlegender = $row['teachertitleGender'];
				 $dbteachereducationarea= $row['teachereducationArea'];
				 $dbteachereducationareaname= $row['teachereducationareaName'];
				 $dbteacheremail= $row['teacherEmail'];	
			     $dbteachergradeid = $row['teachergradeID'];
				 $dbteacherclassid = $row['teacherclassID'];
				 $dbteachercourse = $row['teacherCourse'];
				 $dbteachersession = $row['teacherSession'];
				 $dbteacherdate = $row['teacherDate']; 
                 }
		 		
	$getinfoteachgrade = mysqli_query($conn,"SELECT * FROM teachergrade WHERE teacherID =".$my_id."");
    $numrows = mysqli_num_rows($getinfoteachgrade);
    if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($getinfoteachgrade))
		         {
				 $dbteacherid = $row['teacherID'];	 
				 $dbteachergradeone = $row['teachergradeOne'];
				 $dbteachergradetwo = $row['teachergradeTwo'];
				 $dbteachergradethree = $row['teachergradeThree'];
				 $dbteachergradefour = $row['teachergradeFour'];
				 $dbteachergradefive = $row['teachergradeFive'];
				 $dbteachergradesix = $row['teachergradeSix'];
                 }			
				
			}
				
				
				
			$getinfoteachclass = mysqli_query($conn,"SELECT * FROM teacherclass WHERE teacherID =".$my_id."");
    $numrows = mysqli_num_rows($getinfoteachclass);
    if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($getinfoteachclass))
		         {
				 $dbteacherid = $row['teacherID'];	 
				 $dbteacherclassone = $row['teacherclassOne'];
				 $dbteacherclasstwo = $row['teacherclassTwo'];
				 $dbteacherclassthree = $row['teacherclassThree'];
				 $dbteacherclassfour = $row['teacherclassFour'];
				 $dbteacherclassfive = $row['teacherclassFive'];
				 $dbteacherclasssix = $row['teacherclassSix'];
                 }			
				
			}
				
?>
<div>
<p> <?php echo "Teacher " .$dbteachertitlegender." ".ucwords($dbteachername)." ".ucwords($dbteachermiddlename) ." ".ucwords($dbteacherlastname).""; ?></p>
<hr size=1 width=200 align=left>
<p> <?php echo $dbteachereducationarea ." : ";  echo ucwords($dbteachereducationareaname); ?></p>
<p> Teacher ID : <?php echo $dbteacherid; ?></p>
<p> Grade : <?php echo $dbteachergradeone.",".$dbteachergradetwo.",".$dbteachergradethree.",".$dbteachergradefour.",".$dbteachergradefive.",".$dbteachergradesix.""; ?></p>
<p> Class : <?php  echo $dbteacherclassone.",".$dbteacherclasstwo.",".$dbteacherclassthree.",".$dbteacherclassfour.",".$dbteacherclassfive.",".$dbteacherclasssix.""; ?></p>
<p> Registered : <?php echo $dbteacherdate; ?></p>
</div>
<?php
			}

 //-------------------------------------------- report to admin ---------------------------------------------------
echo '<a href = "report_to_admin_between_user.php?user='.$my_id.'">Report</a>';
echo '<a href ="teacherlogout.php" style = "text-decoration:none">Logout</a>';	
?>
</body>
</html>