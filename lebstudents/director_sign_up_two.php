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
$directorid = $_SESSION['logdirectorid'];
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
			
			$sqldirectoryid = mysqli_query($conn,"SELECT * FROM directorsection WHERE directorID='$directorid'");
	        $numrows = mysqli_num_rows($sqldirectoryid);
	         if($numrows == 0)           
	                     {	
	
	
$sql = "INSERT INTO directorsection(directorsectionID,directorID,directorsectionName,	directorsectionDate)VALUES(null,'$directorid','$section','$date')";	
if ($conn->query($sql) === TRUE) {
	
//------------------------------ fetch a data from database-----------	
	
$sqlfetchdirectory = mysqli_query($conn,"SELECT * FROM directors WHERE directorID='$directorid'");
	                    $numrows3 = mysqli_num_rows($sqlfetchdirectory);
	                     if($numrows3 != 0)
	                     {					 
							 
							 
							 while($row3 = mysqli_fetch_assoc($sqlfetchdirectory))
							 {
								 
								$dbdirectorsidsession = $row3['directorID'];
								$dbdirectoreducationarea = $row3['directoreducationArea'];
								$dbdirectoreducationareaname = $row3['directoreducationareaName'];	
							 }
							 
							 
							 $sqlfetchdirectorysection = mysqli_query($conn,"SELECT * FROM directorsection WHERE directorID='$directorid'");
	                    $numrows3 = mysqli_num_rows($sqlfetchdirectorysection);
	                     if($numrows3 != 0)
	                     {					 
	 
							 while($row3 = mysqli_fetch_assoc($sqlfetchdirectorysection))
							 {
								 
								$dbdirectorsectionname = $row3['directorsectionName'];
		
							 }
							 if($dbdirectoreducationarea == "School")
							    
							 {
								 
					
			 //--------------------------- directory add to school folder------------------------
								 
							      $newdirectoryname = "directors/school/".$dbdirectoreducationareaname;
		                          $mkdirid = mkdir($newdirectoryname);
						    
								  $newdirectoryid = "directors/school/".$dbdirectoreducationareaname."/".$dbdirectorsidsession;
		                          $mkdirid = mkdir($newdirectoryid);
								  
								 $newdirectorsection = "directors/school/".$dbdirectoreducationareaname."/".$dbdirectorsidsession."/".$dbdirectorsectionname;
							      $mkdirprofpic = mkdir($newdirectorsection);
							 
							      $newdirectoryprofpic = "directors/school/".$dbdirectoreducationareaname."/".$dbdirectorsidsession."/".$dbdirectorsectionname."/profpic";
							      $mkdirprofpic = mkdir($newdirectoryprofpic);
							 
							       $newdirectorychat = "directors/school/".$dbdirectoreducationareaname."/".$dbdirectorsidsession."/".$dbdirectorsectionname."/chat";
		                           $mkdirphotos = mkdir($newdirectorychat);
								 
								   $newdirectoryphoto = "directors/school/".$dbdirectoreducationareaname."/".$dbdirectorsidsession."/".$dbdirectorsectionname."/photo";
		                           $mkdirphotos = mkdir($newdirectoryphoto);
						 }else{
								 
			//--------------------------- directory add to university folder ------------------------
								 
								 
						 
							      $newdirectoryname = "directors/university/".$dbdirectoreducationareaname;
		                          $mkdirid = mkdir($newdirectoryname);
						    
								  $newdirectoryid = "directors/university/".$dbdirectoreducationareaname."/".$dbdirectorsidsession;
		                          $mkdirid = mkdir($newdirectoryid);
								  
								 $newdirectorsection = "directors/university/".$dbdirectoreducationareaname."/".$dbdirectorsidsession."/".$dbdirectorsectionname;
							      $mkdirprofpic = mkdir($newdirectorsection);
							 
							      $newdirectoryprofpic = "directors/university/".$dbdirectoreducationareaname."/".$dbdirectorsidsession."/".$dbdirectorsectionname."/profpic";
							      $mkdirprofpic = mkdir($newdirectoryprofpic);
							 
							       $newdirectorychat = "directors/university/".$dbdirectoreducationareaname."/".$dbdirectorsidsession."/".$dbdirectorsectionname."/chat";
		                           $mkdirphotos = mkdir($newdirectorychat);
								 
								 
								 $newdirectoryphoto = "directors/university/".$dbdirectoreducationareaname."/".$dbdirectorsidsession."/".$dbdirectorsectionname."/photo";
		                           $mkdirphotos = mkdir($newdirectoryphoto); 
							 }
					

	
//----------------------------- make directory courses -------------------------
	
                   $newdirectorycourses = "courses/school/".$dbdirectoreducationareaname;
		           $mkdirid = mkdir($newdirectorycourses);
							 
				   $newdirectorycourses = "courses/school/".$dbdirectoreducationareaname."/".$directorid;
		           $mkdirid = mkdir($newdirectorycourses);		 
							 
				   $newdirectorysection = "courses/school/".$dbdirectoreducationareaname."/".$directorid."/".$section."";
				   $mkdirsection = mkdir($newdirectorysection);
								 
      header("Location:director_sign_up_three.php");
	                     }
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

<form action ="director_sign_up_two.php" method="post">
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