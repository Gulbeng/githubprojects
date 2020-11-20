<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>director profile one</title>
</head>

<body>
<?php
include('connection.php');
$my_id = $_SESSION['logdirectorid'];
include('functions.php');	
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

 $fatcheanames2 = mysqli_query($conn,"SELECT * FROM directors WHERE directorID = ".$my_id."");
	   $numrows = mysqli_num_rows($fatcheanames2);
	    if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($fatcheanames2))
		         {
			     $dbdirectoreducationarea = $row['directoreducationArea'];
				 $dbdirectoreducationareaname = $row['directoreducationareaName'];
                 }							  
	
	   $fatcheanames2 = mysqli_query($conn,"SELECT * FROM directorsection WHERE directorID = ".$my_id."");
	   $numrows = mysqli_num_rows($fatcheanames2);
	    if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($fatcheanames2))
		         {
 			      $dbdirectorsectionname = $row['directorsectionName'];
                 }		
	
	
if($dbdirectoreducationarea == "School")
{
$directory ="directors/school/".$dbdirectoreducationareaname."/".$my_id."/".$dbdirectorsectionname."/profpic";	
}else{
	
$directory ="directors/university/".$dbdirectoreducationareaname."/".$my_id."/".$dbdirectorsectionname."/profpic";	
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

			
			$sql1 ="INSERT INTO directorprofilepic (directorprofpicID,directorID,	directorprofpicName,directorprofpicType,directorprofpicSize,directorprofpicDate) VALUES(null,'".$my_id."','$profname','$proftype','$profsize','$date')" or die("not inserted pic");
	        mysqli_query($conn, $sql1);
     
      
			
	   $fprofpic = mysqli_query($conn,"SELECT directorprofpicID FROM directorprofilepic WHERE directorID = ".$my_id."");
	   $numrows = mysqli_num_rows($fprofpic);
	    if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($fprofpic))
		         {
			     $dbprofpicid = $row['directorprofpicID'];
				 }
     
							
	  
	   // move the file into the audio folder
	    move_uploaded_file($_FILES["file"]["tmp_name"],"directors/school/".$my_id."/profpic/". $_FILES["file"]["name"]);
	   

       echo "<script>alert('Uploaded Successfully!')</script>";
	   
	  
		//		if ( basename($_SERVER['PHP_SELF']) == "profile_one.php"){    
		   
        //   header("Location:profile_one.php");
     
            
         //     }else{
		
		header("Location:director_profile_one.php");
		
//	}
			}
	   
	   //count the number of files is minimum 3 files remove the file from directory
		}
		else{
							
      
			
	   $fprofpic = mysqli_query($conn,"SELECT directorprofpicID FROM directorprofilepic WHERE directorID = ".$my_id."");
	   $numrows = mysqli_num_rows($fprofpic);
	    if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($fprofpic))
		         {
			     $dbprofpicid = $row['directorprofpicID'];
                 }
				
		// ---------------------------------- remove from profilepic table	------------------------------------------			
			
			 $fprofpic = mysqli_query($conn,"SELECT * FROM directorprofilepic WHERE directorID = ".$my_id."");
	        $numrows = mysqli_num_rows($fprofpic);
	      if($numrows!=0)
	        {
	     while($row = mysqli_fetch_assoc($fprofpic))
	         {
		     $dbprofpicid = $row['directorprofpicID'];
			 $profpicname = $row['directorprofpicName'];
                }
		
            $fatcheanames3 = mysqli_query($conn,"SELECT * FROM directors WHERE directorID = ".$my_id."");
	         $numrows = mysqli_num_rows($fatcheanames3);
	    if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($fatcheanames3))
		         {
			     $dbdirectoreducationarea = $row['directoreducationArea'];
				 $dbdirectoreducationareaname = $row['directoreducationareaName'];
                 }							  
	
	   $fatcheanames3 = mysqli_query($conn,"SELECT * FROM directorsection WHERE directorID = ".$my_id."");
	   $numrows = mysqli_num_rows($fatcheanames3);
	    if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($fatcheanames3))
		         {
 			      $dbdirectorsectionname = $row['directorsectionName'];
                 }	
				if($dbdirectoreducationarea == "School")
				{
	$file_to_delete = "directors/school/".$dbdirectoreducationareaname."/".$my_id."/".$dbdirectorsectionname."/profpic/".$profpicname;        // file pic directory    
				}else{
   $file_to_delete = "directors/university/".$dbdirectoreducationareaname."/".$my_id."/".$dbdirectorsectionname."/profpic/".$profpicname;        // file pic directory
				}
				
				$sql1 = "DELETE FROM directorprofilepic WHERE directorID = ".$my_id." AND directorprofpicID = ".$dbprofpicid."";
				if (mysqli_query($conn, $sql1)) {
               
                 } else {
                 
                }
			}
			}
			}
						 
				
		unlink($file_to_delete);    //file removing from directory		
				
		$sql1 ="INSERT INTO directorprofilepic (directorprofpicID,directorID,	directorprofpicName,directorprofpicType,directorprofpicSize,directorprofpicDate) VALUES(null,'".$my_id."','$profname','$proftype','$profsize','$date')" or die("not inserted pic");
	        mysqli_query($conn, $sql1);
     	
				
				
		 $fatcheanames4 = mysqli_query($conn,"SELECT * FROM directors WHERE directorID = ".$my_id."");
	         $numrows = mysqli_num_rows($fatcheanames4);
	    if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($fatcheanames4))
		         {
			     $dbdirectoreducationarea = $row['directoreducationArea'];
				 $dbdirectoreducationareaname = $row['directoreducationareaName'];
                 }							  
	
	   $fatcheanames4 = mysqli_query($conn,"SELECT * FROM directorsection WHERE directorID = ".$my_id."");
	   $numrows = mysqli_num_rows($fatcheanames4);
	    if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($fatcheanames4))
		         {
 			      $dbdirectorsectionname = $row['directorsectionName'];
                 }	
         if($dbdirectoreducationarea == "School")
		 {
	   // move the file into the profilepic folder
	    move_uploaded_file($_FILES["file"]["tmp_name"],"directors/school/".$dbdirectoreducationareaname."/".$my_id."/".$dbdirectorsectionname."/profpic/". $_FILES["file"]["name"]);
		 }else{
			move_uploaded_file($_FILES["file"]["tmp_name"],"directors/university/".$dbdirectoreducationareaname."/".$my_id."/".$dbdirectorsectionname."/profpic/". $_FILES["file"]["name"]); 
		 }

       echo "<script>alert('Uploaded Successfully!')</script>";
	   
	  
		//		if ( basename($_SERVER['PHP_SELF']) == "profile_one.php"){    
		   
        //   header("Location:profile_one.php");
     
            
         //     }else{
		
		header("Location:director_profile_one.php");
		//	}
			}
			}

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
  }	
	
	

//<-------------------------------------- php  default  pic male female ----------------------------->

             
      
                             $check_pic_exist = mysqli_query($conn,"SELECT * FROM directors WHERE directorID = ".$_SESSION['logdirectorid']."");
	                         $numrows = mysqli_num_rows($check_pic_exist);
                              
				             if($numrows == 0)
							 {
								
								 $areaquery =mysqli_query($conn,"SELECT directoreducationArea FROM directors WHERE directorID = ".$_SESSION['logdirectorid']."");
	                              $numrows = mysqli_num_rows($areaquery);
				                  if($numrows!=0)
	                                 {
		                               while($row = mysqli_fetch_assoc($areaquery))
		                                 {
			                        $dbdirectoreducationarea = $row['directoreducationArea'];
                                         }
									 
									 if($dbdirectoreducationarea == 'School')
									 {
										 
										echo '<img id = "defaultpic" src="icons/director-male-female-school.jpg" alt="areapic" width="310" height="350">'; 
									 }
									 
									 else
									 {
										 echo '<img id = "defaultpic" src="icons/director-male-female-university.jpg" alt="areapic" width="310" height="350">'; 
									 }
									 }
								 
							 }
	                          else{
									 
// ---------------------------------display the pic of profile----------------------------
 $picname=getdirectorpicname($my_id,'directorprofpicName');

								  
	   $fatcheanames = mysqli_query($conn,"SELECT * FROM directors WHERE directorID = ".$my_id."");
	   $numrows = mysqli_num_rows($fatcheanames);
	    if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($fatcheanames))
		         {
			     $dbdirectoreducationarea = $row['directoreducationArea'];
				 $dbdirectoreducationareaname = $row['directoreducationareaName'];
                 }							  
	
	   $fatcheanames2 = mysqli_query($conn,"SELECT * FROM directorsection WHERE directorID = ".$my_id."");
	   $numrows = mysqli_num_rows($fatcheanames2);
	    if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($fatcheanames2))
		         {
 			      $dbdirectorsectionname = $row['directorsectionName'];
                 }	
			if($dbdirectoreducationarea == "School")					  
			{					  
	$dir = "directors/school/".$dbdirectoreducationareaname."/".$my_id."/".$dbdirectorsectionname."/profpic/".$picname; 
			}else{
	$dir = "directors/university/".$dbdirectoreducationareaname."/".$my_id."/".$dbdirectorsectionname."/profpic/".$picname;
			}
    
echo '<img id="profpic" src="'.$dir.'" alt="prof pic" width="120" height="180">'; 
							 } 
							  }
	}
	?>
<form action ="director_profile_one.php" method="post" enctype="multipart/form-data">
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
              <input name="submitpic" type="submit" value="Upload"  />
           </td>
            <td>
        </tr>
</table>
</form>	
	
	
<?php	

//<!---------------------------------------------------- display info ------------------------------------------>

$getinfo = mysqli_query($conn,"SELECT * FROM directors WHERE directorID =".$my_id."");
$numrows = mysqli_num_rows($getinfo);
  if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($getinfo))
		         {
				 $dbdirectorfirstname = $row['directorName'];
				 $dbdirectormiddlename = $row['directorMiddlename'];
				 $dbdirectorlastname = $row['directorLastname'];
				 $dbdirectortitlegender = $row['directortitleGender'];
				 $dbdirectoreducationalarea = $row['directoreducationArea'];
				 $dbdirectorschooluniname = $row['directoreducationareaName'];
				 $dbdirectordate = $row['directorDate'];	 
                 }
				
				
$getinfo = mysqli_query($conn,"SELECT directorsectionName FROM directorsection WHERE directorID =".$my_id."");
$numrows = mysqli_num_rows($getinfo);
  if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($getinfo))
		         {
				 $dbdirectorsectionname = $row['directorsectionName'];
			 
                 }				
				
				
				
?>
<div>
<p> <?php echo "Director ".$dbdirectortitlegender." ".ucwords($dbdirectorfirstname)." ".ucwords($dbdirectormiddlename) ." ".ucwords($dbdirectorlastname).""; ?></p>
<hr size=1 width=200 align=left>
<p> <?php echo $dbdirectoreducationalarea ." : ";  echo ucwords($dbdirectorschooluniname); ?></p>
<p> School Section : <?php echo $dbdirectorsectionname; ?></p>
<p> Registered : <?php echo $dbdirectordate; ?></p>
</div>
<?php
			}
			}

//-------------------------------------------- report to admin ---------------------------------------------------
echo '<a href = "report_to_admin_between_user.php?user='.$my_id.'">Report</a>';
echo '<a href ="directorlogout.php" style = "text-decoration:none">Logout</a>';	
?>
</body>
</html>