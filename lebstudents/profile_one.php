<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>profile one</title>
</head>

<body>
<?php 
	
	include('functions.php');
	
	?>
<a href="#" id = "uploadpiclink" style = "text-decoration:none">upload pic</a>

<!-------------------------------- form to upload a profile pic ------------------------------------------------>

<form id= "uploadpicbar" action="profile_one.php" method="POST" enctype="multipart/form-data" >
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
$my_id = $_SESSION["loguserid"];

//<!------------------ php  default profile pic male female ----------------------------->		
		
			 	 	$check_pic_exist = mysqli_query($conn,"SELECT * FROM profilepic WHERE userID = ".$my_id."");
	                         $numrows = mysqli_num_rows($check_pic_exist);
                              
				             if($numrows == 0)
							 {
								 $genderquery =mysqli_query($conn,"SELECT userGender FROM user WHERE userID = ".$my_id."");
	                              $numrows = mysqli_num_rows($genderquery);
				                  if($numrows!=0)
	                                 {
		                               while($row = mysqli_fetch_assoc($genderquery))
		                                 {
			                           $dbusergender = $row['userGender'];
                                         }
									 
									 if($dbusergender == 'Male')
									 {
										 
										echo '<img id = "defaultpic" src="icons/male.jpg" alt="genderpic" width="120" height="180">'; 
									 }
									 else
									 {
										 echo '<img id = "defaultpic" src="icons/female.jpg" alt="genderpic" width="120" height="180">'; 
									 }
									 }
								 
							 }else{
									 
// ---------------------------------display the pic of profile----------------------------
 $picname=getpicname($my_id,'profpicName');
	
	$dir = "users/".$my_id."/profpic/".$picname; 
  
    
echo '<img id="profpic" src="'.$dir.'" alt="prof pic" width="120" height="180">'; 
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

$directory ="users/".$_SESSION['loguserid']."/profpic";

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
	   
	    $sql2 ="INSERT INTO uploadedprofpic (uploadedprofID,userID,profpicID) VALUES(null,'".$_SESSION['loguserid']."','$dbprofpicid')" or die("not inserted  uploaded pic");
		mysqli_query($conn, $sql2);
     
							
	  
	   // move the file into the audio folder
	    move_uploaded_file($_FILES["file"]["tmp_name"],"users/".$_SESSION['loguserid']."/profpic/". $_FILES["file"]["name"]);
	   

       echo "<script>alert('Uploaded Successfully!')</script>";
	   
	  
		//		if ( basename($_SERVER['PHP_SELF']) == "profile_one.php"){    
		   
        //   header("Location:profile_one.php");
     
            
         //     }else{
		
		header("Location:profile_one.php");
		
//	}
			}
	   
	   //count the number of files is minimum 3 files remove the file from directory
		}
		else{
							
      
			
	   $fprofpic = mysqli_query($conn,"SELECT profpicID FROM profilepic WHERE userID = ".$_SESSION['loguserid']."");
	   $numrows = mysqli_num_rows($fprofpic);
	    if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($fprofpic))
		         {
			     $dbprofpicid = $row['profpicID'];
                 }
				
		// ---------------------------------- remove from profilepic table	------------------------------------------			
			
			 $fprofpic = mysqli_query($conn,"SELECT * FROM profilepic WHERE userID = ".$_SESSION['loguserid']."");
	        $numrows = mysqli_num_rows($fprofpic);
	      if($numrows!=0)
	        {
	     while($row = mysqli_fetch_assoc($fprofpic))
	         {
		     $dbprofpicid = $row['profpicID'];
			 $profpicname = $row['profpicName'];
                }
		

	           $file_to_delete = "users/".$_SESSION['loguserid']."/profpic/".$profpicname;        // file pic directory    
	
				$sql1 = "DELETE FROM profilepic WHERE userID = ".$_SESSION['loguserid']." AND profpicID = ".$dbprofpicid."";
				if (mysqli_query($conn, $sql1)) {
               
                 } else {
                 
                }
			}
						 
	// ---------------------------------- remove from uploadedprofpic table	------------------------------------------
	  
	      $upprofpic = mysqli_query($conn,"SELECT * FROM uploadedprofpic WHERE userID = ".$_SESSION['loguserid']."");
	        $numrows = mysqli_num_rows($upprofpic);
	      if($numrows!=0)
	        {
	     while($row = mysqli_fetch_assoc($upprofpic))
	         {
		     $dbprofpicidup = $row['profpicID'];
			 
                }
				
				$sql2 = "DELETE FROM uploadedprofpic WHERE userID = ".$_SESSION['loguserid']." AND profpicID = ".$dbprofpicidup."";
				if (mysqli_query($conn, $sql2)) {
              
             } else {
           
                     }
				
	
    	
			}
				
		unlink($file_to_delete);    //file removing from directory		
				
		$sql1 ="INSERT INTO profilepic (profpicID,userID,profpicName,profpicType,profpicSize,profpicDate) VALUES(null,'".$_SESSION['loguserid']."','$profname','$proftype','$profsize','$date')" or die("not inserted pic");
	        mysqli_query($conn, $sql1);
     		
	   
	   // insert information in uploaded table
	   
	    $sql2 ="INSERT INTO uploadedprofpic (uploadedprofID,userID,profpicID) VALUES(null,'".$_SESSION['loguserid']."','$dbprofpicid')" or die("not inserted  uploaded pic");
		mysqli_query($conn, $sql2);
     
							
	  
	   // move the file into the audio folder
	    move_uploaded_file($_FILES["file"]["tmp_name"],"users/".$_SESSION['loguserid']."/profpic/". $_FILES["file"]["name"]);
	   

       echo "<script>alert('Uploaded Successfully!')</script>";
	   
	  
		//		if ( basename($_SERVER['PHP_SELF']) == "profile_one.php"){    
		   
        //   header("Location:profile_one.php");
     
            
         //     }else{
		
		header("Location:profile_one.php");
		
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

	
 
//<!---------------------------------------------------- display info ------------------------------------------>

$getinfo = mysqli_query($conn,"SELECT * FROM user WHERE userID =".$my_id."");
$numrows = mysqli_num_rows($getinfo);
  if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($getinfo))
		         {
				 $dbuserfirstname = $row['firstName'];
				 $dbusermiddlename = $row['middleName'];
				 $dbuserlastname = $row['lastName'];
				 $dbuserhometown = $row['userHometown'];
				 $dbusergender = $row['userGender'];
			     $dbuserrelationship = $row['userRelationship'];
				 $dbuserday = $row['birthDay'];
				 $dbusermonth = $row['birthMonth'];
				 $dbuseryear = $row['birthYear'];
				 $dbeducationalarea = $row['educationalArea'];
				 $dbschooluniname = $row['schooluniName'];
				 $dbusergrade = $row['userGrade'];
				 $dbuserclass = $row['userClass'];
				 $dbuserdate = $row['userDate'];	 
                 }
?>
<div>
<p> <?php echo ucwords($dbuserfirstname)." ".ucwords($dbusermiddlename) ." ".ucwords($dbuserlastname).""; ?></p>
<hr size=1 width=200 align=left>
<p> Gender : <?php echo $dbusergender; ?></p>
<p> Age : <?php $age = date("Y") - $dbuseryear; echo $age?></p>
<p> <?php echo $dbeducationalarea ." : ";  echo ucwords($dbschooluniname); ?></p>
<p> Grade : <?php echo $dbusergrade; ?></p>
<p> Class : <?php echo $dbuserclass; ?></p>
<p> Relationship : <?php if(empty($dbuserrelationship)){echo 'Non';}else {echo $dbuserrelationship;} ?></p>
<p> Birthday : <?php echo $dbuserday." / ".$dbusermonth." / ".$dbuseryear; ?></p>
<p> Registered : <?php echo $dbuserdate; ?></p>
</div>
<?php
			}

//-------------------------------------------- report to admin ---------------------------------------------------
echo '<a href = "report_to_admin_between_user.php?user='.$my_id.'">Report</a>';
echo '<a href ="logout.php" style = "text-decoration:none">Logout</a>';	
?>
</body>
</html>