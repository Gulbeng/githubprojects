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
<title>director sign up two</title>
<script src="jquery/jquery-3.5.1.js" type="text/javascript"></script>
<script src="jquery/jquery-3.5.1.slim.js" type="text/javascript"></script>
</head>

<body>
<?php
include('connection.php');
$teacherid = $_SESSION['logteacherid'];
if (isset($_POST['submit'])) {
$section = $_POST['section'];
$hourDateGMT = date("H");
$hourDateLebanon = $hourDateGMT+2;
$date = date("Y.m.d $hourDateLebanon:i:s");
if($section == 'Choose' )
{
echo "<p><b><font color = 'red'>Please select a Section</font></b></p>";

}else{
                //  ------- section exist ----------                    
			
			$sqldirectoryid = mysqli_query($conn,"SELECT * FROM teachers WHERE teacherID='$teacherid'");
	        $numrows = mysqli_num_rows($sqldirectoryid);
	         if($numrows != 0)           
	                     {	
	
	
$sql = "UPDATE teachers SET teacherSection = '$section' WHERE teacherID = '$teacherid'";	
if ($conn->query($sql) === TRUE) {
	
//------------------------------ fetch a data from database-----------	
	
$sqlfetchdirectory = mysqli_query($conn,"SELECT * FROM teachers WHERE teacherID='$teacherid'");
	                    $numrows3 = mysqli_num_rows($sqlfetchdirectory);
	                     if($numrows3 != 0)
	                     {					 
							 
							 
							 while($row3 = mysqli_fetch_assoc($sqlfetchdirectory))
							 {
								 
								$dbteacheridsession = $row3['teacherID'];
								$dbteachereducationarea = $row3['teachereducationArea'];
								$dbteachereducationareaname = $row3['teachereducationareaName'];
								$dbteachersection = $row3['teacherSection'];
							 }
							 
							 
							 
							 if($dbteachereducationarea == "School")
							    
							 {
								 
					
			 //--------------------------- directory add to school folder------------------------
								 
							      $newdirectoryname = "teachers/school/".$dbteachereducationareaname;
		                          $mkdirid = mkdir($newdirectoryname);
						    
								  $newdirectoryid = "teachers/school/".$dbteachereducationareaname."/".$dbteacheridsession;
		                          $mkdirid = mkdir($newdirectoryid);
								  
								 $newdirectorsection = "teachers/school/".$dbteachereducationareaname."/".$dbteacheridsession."/".$dbteachersection;
							      $mkdirprofpic = mkdir($newdirectorsection);
							 
							      $newdirectoryprofpic = "teachers/school/".$dbteachereducationareaname."/".$dbteacheridsession."/".$dbteachersection."/profpic";
							      $mkdirprofpic = mkdir($newdirectoryprofpic);
							 
							       $newdirectorychat = "teachers/school/".$dbteachereducationareaname."/".$dbteacheridsession."/".$dbteachersection."/chat";
		                           $mkdirphotos = mkdir($newdirectorychat);
								 
								   $newdirectoryphoto = "teachers/school/".$dbteachereducationareaname."/".$dbteacheridsession."/".$dbteachersection."/photo";
		                           $mkdirphotos = mkdir($newdirectoryphoto);
						 }else{
								 
			//--------------------------- directory add to university folder ------------------------
								 
								 
						 
							      $newdirectoryname = "teachers/university/".$dbteachereducationareaname;
		                          $mkdirid = mkdir($newdirectoryname);
						    
								  $newdirectoryid = "teachers/university/".$dbteachereducationareaname."/".$dbteacheridsession;
		                          $mkdirid = mkdir($newdirectoryid);
								  
								 $newdirectorsection = "teachers/university/".$dbteachereducationareaname."/".$dbteacheridsession."/".$dbteachersection;
							      $mkdirprofpic = mkdir($newdirectorsection);
							 
							      $newdirectoryprofpic = "teachers/university/".$dbteachereducationareaname."/".$dbteacheridsession."/".$dbteachersection."/profpic";
							      $mkdirprofpic = mkdir($newdirectoryprofpic);
							 
							       $newdirectorychat = "teachers/university/".$dbteachereducationareaname."/".$dbteacheridsession."/".$dbteachersection."/chat";
		                           $mkdirphotos = mkdir($newdirectorychat);
								 
								   $newdirectoryphoto = "teachers/university/".$dbteachereducationareaname."/".$dbteacheridsession."/".$dbteachersection."/photo";
		                           $mkdirphotos = mkdir($newdirectoryphoto); 
							 }
					
								 
      header("Location:teacher_sign_up_three.php");
	                     
						 }	
}else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
						 }else{
							 echo "<p><b><font color = 'red'>director's section exist</font></b></p>";
						 }
}
}
?>

<form action ="teacher_sign_up_two.php" method="post">
      <table>
          <tr>
           <td>
              <b>School Section :</b> 
           </td>
           <td>
               <select name ='section'>
                     <option value ="Choose">Choose</option>
                     <option value ="Primary One">Primary One</option>
                     <option value ="Primary Two">Primary Two</option>
                     <option value ="Complementary">Complementary</option>
                     <option value ="Secondary">Secondary</option>
               </select>
          </td>
           <tr>
      <td>
      <input type='submit' name='submit'  value='Next'/>
      </td>
      </tr>
</table>
</form>


</body>
</html>