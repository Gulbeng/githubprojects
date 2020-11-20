<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>sign up profile pic</title>


<script>
    if (window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</head>

<body>
<?php
if(isset($_GET['user']) && !empty($_GET['user'])){
	
	$user=$_GET['user'];
}
else
{
	$user = $_SESSION['loguserid'];
	
}
	
$my_id=$_SESSION['loguserid'];	
	
?>
<?php
	




//<-------------------------------------- php  default profile pic male female ----------------------------->

         include("connection.php");        
      
                             $check_pic_exist = mysqli_query($conn,"SELECT * FROM profilepic WHERE userID = ".$_SESSION['loguserid']."");
	                         $numrows = mysqli_num_rows($check_pic_exist);
                              
				             if($numrows == 0)
							 {
								 $genderquery =mysqli_query($conn,"SELECT userGender FROM user WHERE userID = ".$_SESSION['loguserid']."");
	                              $numrows = mysqli_num_rows($genderquery);
				                  if($numrows!=0)
	                                 {
		                               while($row = mysqli_fetch_assoc($genderquery))
		                                 {
			                           $dbusergender = $row['userGender'];
                                         }
									 
									 if($dbusergender == 'Male')
									 {
										 
										echo '<img id = "defaultpic" src="icons/male.jpg" alt="genderpic" width="310" height="350">'; 
									 }
									else
									 {
										 echo '<img id = "defaultpic" src="icons/teacher-female.png" alt="genderpic" width="310" height="350">'; 
									 }
									 }
								 
							 }
	?>
	
	
	
<!-------------------------------------------------  upload bar ----------------------------------------------->	
	
<form id= "uploadpicbar" action="sign_up_three.php" method="POST" enctype="multipart/form-data" >
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

$directory ="users/".$_SESSION['loguserid']."/profpic";

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

			
			$sql1 ="INSERT INTO profilepic (profpicID,userID,profpicName,profpicType,profpicSize,profpicDate) VALUES(null,'".$_SESSION['loguserid']."','$profname','$proftype','$profsize','$date')" or die("not inserted pic");
	        mysqli_query($conn, $sql1);
     
      
			
	   $fprofpic = mysqli_query($conn,"SELECT profpicID FROM profilepic WHERE userID = ".$_SESSION['loguserid']."");
	   $numrows = mysqli_num_rows($fprofpic);
	    if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($fprofpic))
		         {
			     $dbprofpicid = $row['profpicID'];
                 }
	   
	   // insert information in uploaded table
	   
	    $sql2 =("INSERT INTO uploadedprofpic (uploadedprofID,userID,profpicID) VALUES(null,'".$_SESSION['loguserid']."','$dbprofpicid')") or die("not inserted  uploaded pic");
		mysqli_query($conn, $sql2);
  
	   // move the file into the audio folder
	    move_uploaded_file($_FILES["file"]["tmp_name"],"users/".$_SESSION['loguserid']."/profpic/". $_FILES["file"]["name"]);
	   

       echo "<script>alert('Uploaded Successfully!')</script>";
	   
	   header("Location:profile_one.php");
			}
	   
	   
		  }
		else{
			  
	//--------------------------remove the uploaded profile pic------------------------------------------------
			
			
			$fprofpic = mysqli_query($conn,"SELECT profpicID,profpicName FROM profilepic WHERE userID = ".$_SESSION['loguserid']."");
	         $numrows = mysqli_num_rows($fprofpic);
	       if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($fprofpic))
		         {
			     $dbprofpicid = $row['profpicID'];
				 $profpicname = $row['profpicName'];
                 }
	
		$file_to_delete = "users/".$_SESSION['loguserid']."/profpic/".$profpicname;      //file removing
	    mysqli_query($conn,"DELETE FROM uploadedprofpic WHERE userID = ".$_SESSION['loguserid']." AND profpicID = ".$dbprofpicid."") or die("error in delete");
		mysqli_query($conn,"DELETE FROM profilepic WHERE userID = ".$_SESSION['loguserid']." AND profpicID = ".$dbprofpicid."") or die("error in delete");
        unlink($file_to_delete);
	
	          //  header("Location:signedinpageuser.php");
			}
		  }
	
		}
  }

  }else{}
}

	// --------------------------------display profile pic----------------------------------


$getpicname = mysqli_query($conn,"SELECT * FROM profilepic WHERE userID =".$_SESSION['loguserid']."");
$numrows = mysqli_num_rows($getpicname);
  if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($getpicname))
		         {
				 $dbprofpicname = $row['profpicName'];
				 $dbprofpicdate = $row['profpicDate'];
				 }


echo '<div id  ="prof_pic_border"><img id="profpic" src="users/'.$_SESSION['loguserid'].'/profpic/'.$dbprofpicname.'" alt="prof pic" width="310" height="350"> </div>';

			}
	
	?>

<a href="profile_one.php" id = "skipuploadpic" style = "text-decoration:none"> Skip </a>
</body>
</html>