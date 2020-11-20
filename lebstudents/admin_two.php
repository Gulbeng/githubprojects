<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Admin</title>
</head>

<body>
<?php
include("connection.php"); 
if (isset($_POST['add'])) {   //if the button submit clicked
	
	     

$add = $_POST['add'];
$coursename = $_POST['coursename'];
$coursedescription = $_POST['coursedescription'];
$hourDateGMT = date("H");
$hourDateLebanon = $hourDateGMT+2;
$date = date("Y-m-d $hourDateLebanon:i:s");

if($catname) //check if
{

$coursecheck = "SELECT * FROM course WHERE courseName ='$coursename'";
$result = $conn->query($coursecheck);
							 $count = mysqli_num_rows($result);
							                      if($count==0)
							                        {
							                         
							$coursenamecheck = "SELECT courseName FROM course WHERE courseName='$coursename'";
							$result1 = $conn->query($coursenamecheck);
							$countcourse = mysqli_num_rows($result1);
														                                                   

$sql = "INSERT INTO course VALUES(null,'$coursename','$coursedescription','$date')";
if($conn->query($sql) === TRUE)
						 {
							 echo "<script>alert('Course Added!'); </script>";
						 }else{
							 echo "Error: " . $sql . "<br>" . $conn->error;
						 }
																									   

													}
else{
	echo "<font color='red'>Course already exist</font>";
	}
}
else{
	 echo  "<font color='red'>Please enter a course</font>";
}
$conn->close();        //close the connection
}		
	
	
	
	
	
	
?>
<form action="admin.php" method ="POST" >
<table>
<tr>
         <td>
              <b>Course Name:</b>
          </td>
           <td>
              <input type='text' name='coursename' value="" placeholder='Course Name' size="30"/>
          </td>
          <td>
              <b>Description:</b>
          </td>
           <td>
               <textarea rows="6" cols="60" name="coursedescription" placeholder="Description"></textarea>
          </td>
        </tr>
         <tr>
          <td>
              <input name="add" type="submit" value="Add"  />
           </td>
            <td>
	    </tr>
      <tr>
       <td>
       <label for="file">Photo :</label>
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
</body>
</html>