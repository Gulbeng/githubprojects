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
<title>director_sign_up_three</title>
</head>

<body>
<?php
include('connection.php');
$directorid = $_SESSION['logdirectorid'];
	
	
	

if(isset($_POST['submitpic']))

{
//getting data from the file and putting in variables
$profname=$_FILES["file"]["name"];
$proftype=$_FILES["file"]["type"];
$profsize=$_FILES["file"]["size"];
$hourDateGMT = date("H");
$hourDateLebanon = $hourDateGMT+2;
$date = date("Y.m.d $hourDateLebanon:i:s");
	
	
 $fatcheanames = mysqli_query($conn,"SELECT * FROM directors WHERE directorID = ".$directorid."");
	   $numrows = mysqli_num_rows($fatcheanames);
	    if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($fatcheanames))
		         {
			     $dbdirectoreducationarea = $row['directoreducationArea'];
				 $dbdirectoreducationareaname = $row['directoreducationareaName'];
                 }
				
				
				$fatcheanames2 = mysqli_query($conn,"SELECT * FROM directorsection WHERE directorID = ".$directorid."");
	   $numrows = mysqli_num_rows($fatcheanames2);
	    if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($fatcheanames2))
		         {
				
			     $dbdirectorsectionname = $row['directorsectionName'];
                 }	
	
	if($dbdirectoreducationarea == "School")
	{
$directory ="directors/school/".$dbdirectoreducationareaname."/".$_SESSION['logdirectorid']."/".$dbdirectorsectionname."/profpic";
	}
	else{
$directory ="directors/university/".$dbdirectoreducationareaname."/".$_SESSION['logdirectorid']."/".$dbdirectorsectionname."/profpic";				
					
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

			
			$sql1 ="INSERT INTO directorprofilepic (directorprofpicID,directorID,directorprofpicName,directorprofpicType,directorprofpicSize,directorprofpicDate) VALUES(null,'".$_SESSION['logdirectorid']."','$profname','$proftype','$profsize','$date')" or die("not inserted pic");
	        mysqli_query($conn, $sql1);
     
      
			
	   $fprofpic = mysqli_query($conn,"SELECT directorprofpicID FROM directorprofilepic WHERE directorID = ".$_SESSION['logdirectorid']."");
	   $numrows = mysqli_num_rows($fprofpic);
	    if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($fprofpic))
		         {
			     $dbdirectorprofpicid = $row['directorprofpicID'];
                 }
		
	  $fareanames = mysqli_query($conn,"SELECT * FROM directors WHERE directorID = ".$_SESSION['logdirectorid']."");
	   $numrows = mysqli_num_rows($fareanames);
	    if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($fareanames))
		         {
				 $dbdirectoreducationareaname = $row['directoreducationareaName'];
                 }
				
				
				$fareanames = mysqli_query($conn,"SELECT * FROM directorsection WHERE directorID = ".$_SESSION['logdirectorid']."");
	   $numrows = mysqli_num_rows($fareanames);
	    if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($fareanames))
		         {
			     $dbdirectorsectionname = $row['directorsectionName'];
                 }
  
				
				
				if($dbdirectoreducationareaname == "School")
				{
	   // move the file into the audio folder
	    move_uploaded_file($_FILES["file"]["tmp_name"],"directors/school/".$dbdirectoreducationareaname."/".$_SESSION['logdirectorid']."/".$dbdirectorsectionname."/profpic/". $_FILES["file"]["name"]);
				}else{
					move_uploaded_file($_FILES["file"]["tmp_name"],"directors/university/".$dbdirectoreducationareaname."/".$_SESSION['logdirectorid']."/".$dbdirectorsectionname."/profpic/". $_FILES["file"]["name"]);
				}

       echo "<script>alert('Uploaded Successfully!')</script>";
	   
	   header("Location:director_profile_one.php");
				
			}
			}
	   
			}
		  
	
		  }
		else{
			  
	//--------------------------remove the uploaded profile pic------------------------------------------------
			
			
			$fprofpic = mysqli_query($conn,"SELECT directorprofpicID,directorprofpicName FROM directorprofilepic WHERE directorID = ".$_SESSION['logdirectorid']."");
	         $numrows = mysqli_num_rows($fprofpic);
	       if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($fprofpic))
		         {
			     $dbprofpicid = $row['profpicID'];
				 $profpicname = $row['profpicName'];
                 }
	
				
				
				$fareanames = mysqli_query($conn,"SELECT * FROM directors WHERE directorID = ".$_SESSION['logdirectorid']."");
	   $numrows = mysqli_num_rows($fareanames);
	    if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($fareanames))
		         {
				 $dbdirectoreducationareaname = $row['directoreducationareaName'];
                 }
				
				
				$fareanames = mysqli_query($conn,"SELECT * FROM directorsection WHERE directorID = ".$_SESSION['logdirectorid']."");
	   $numrows = mysqli_num_rows($fareanames);
	    if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($fareanames))
		         {
			     $dbdirectorsectionname = $row['directorsectionName'];
                 }
				if($dbdirectoreducationareaname == "School")
				{
		$file_to_delete = "directors/school/".$dbdirectoreducationareaname."/".$_SESSION['logdirectorid']."/".$dbdirectorsectionname."/profpic/".$profpicname;      //file removing
				}else{
					$file_to_delete = "directors/university/".$dbdirectoreducationareaname."/".$_SESSION['logdirectorid']."/".$dbdirectorsectionname."/profpic/".$profpicname;      //file removing
				}
		mysqli_query($conn,"DELETE FROM directorprofilepic WHERE directorID = ".$_SESSION['logdirectorid']." AND directorprofpicID = ".$dbprofpicid."") or die("error in delete");
        unlink($file_to_delete);
	
	           header("Location:director_profile_one.php");
			}
			}
			}
		  }
	
		}
  }

  }else{}
}	
			}
}
	

//<-------------------------------------- php  default  pic male female ----------------------------->

             
      
                             $check_pic_exist = mysqli_query($conn,"SELECT * FROM directors WHERE directorID = ".$_SESSION['logdirectorid']."");
	                         $numrows = mysqli_num_rows($check_pic_exist);
                              
				             if($numrows != 0)
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
	?>
<form action ="director_sign_up_three.php" method="post" enctype="multipart/form-data">
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

</body>
</html>