<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>


<?php
include('connection.php');
$directorid = $_SESSION['logdirectorid'];
//-------------------------------- add button --------------------------	
if (isset($_POST['add'])) {	
	
$coursename = $_POST['coursename'];
$coursedecription= $_POST['coursedescription'];
//getting data from the file and putting in variables
$picname=$_FILES["file"]["name"];
$pictype=$_FILES["file"]["type"];
$picsize=$_FILES["file"]["size"];
$hourDateGMT = date("H");
$hourDateLebanon = $hourDateGMT+2;
$date = date("Y.m.d $hourDateLebanon:i:s");
	
	
$fsection = mysqli_query($conn,"SELECT directorsectionID FROM directorsection WHERE directorID = ".$directorid."");
	         $numrows = mysqli_num_rows($fsection);
	       if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($fsection))
		         {
			     $dbdirectorsectionid = $row['directorsectionID'];
                 }	
			

$newdirectoryname = "courses/".$directorid."/".$dbdirectorsectionid."/".$coursename."";
$mkdirsectionname = mkdir($newdirectoryname);	


$directory ="courses/".$directorid."/".$dbdirectorsectionid."/".$coursename;	


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

	  	      if(!file_exists($picname))          //if file doesnot exist
		  {
			
			include("connection.php");	
	  
	   // insert information in an course table

			
			$sql1 ="INSERT INTO course (courseID,directorID,courseName,courseDescription,coursepicName,coursepicType,coursepicSize,courseDate) VALUES(null,'$directorid','$coursename','$coursedecription','$picname','$pictype','$picsize','$date')";
            if($conn->query($sql1) === TRUE)
						 {
							//echo "<script>alert('item Added!'); </script>";
						 }else{
							 echo "Error: " . $sql1 . "<br>" . $conn->error;
						 }
      
	   // move the file into the audio folder
	    move_uploaded_file($_FILES["file"]["tmp_name"],"courses/".$directorid."/".$dbdirectorsectionid."/".$coursename."/".$_FILES["file"]["name"]);
	   

       echo "<script>alert('Added course Successfully!')</script>";
	   
	 //  header("Location:director_sign_up_two.php");
			
	   
	   
		  }
		else{
			  
	//--------------------------remove the uploaded  pic------------------------------------------------
			
			
			$fcoursepic = mysqli_query($conn,"SELECT courseID,coursepicName FROM course WHERE directorID = ".$directorid."");
	         $numrows = mysqli_num_rows($fcoursepic);
	       if($numrows!=0)
	        {
		     while($row = mysqli_fetch_assoc($fcoursepic))
		         {
			     $dbcourseid = $row['courseID'];
				 $dbcoursedirectorid = $row['directorID'];
				 $dbcoursepicname = $row['coursepicName'];
                 }
	
		$file_to_delete = "courses/".$directorid."/".$dbdirectorsectionid."/".$dbcoursepicname;      //file removing
		mysqli_query($conn,"DELETE FROM course WHERE courseID = ".$dbcourseid." AND directorID = ".$dbcoursedirectorid."") or die("error in delete");
        unlink($file_to_delete);
	
	       //     header("Location:director_sign_up_two.php");
			}
		  }
	
		}
  }

  }else{}	
			}
}	
	
	
?>

<form action ="director_sign_up_two.php" method="post" enctype="multipart/form-data">
      <table>
     <tr>
           <td>
              Course Name:
           </td>
            <td>
               <input type='text' name='coursename' value="" placeholder="Enter a course name" />
          </td>
          </tr>
           <tr>
         <td>
         <label>Enter The Description</label>
        </td>
        <td>
       <textarea rows="4" cols="45" name="coursedescription" placeholder="Type course description"></textarea> (optional)
       </td>
        </tr>
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
              <input name="add" type="submit" value="Add"  />
           </td>
            <td>
        </tr>
</table>
</form>

</body>
</html>