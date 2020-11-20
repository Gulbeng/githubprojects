<?php
session_start();
?>
<!doctype html>
<html>
<head>
<script>
    if (window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
<meta charset="utf-8">
<title>teacher_sign_up_two</title>
</head>

<body>
<?php
include('connection.php');
	
//fetch the education area from teacher table	
$sql = mysqli_query($conn,"SELECT teachereducationArea FROM teachers WHERE teacherID=".$_SESSION['logteacherid']."");
	                    $numrows3 = mysqli_num_rows($sql);
	                     if($numrows3 != 0)
	                     {					 
							 
							 
							 while($row3 = mysqli_fetch_assoc($sql))
							 {
								 
								$dbteachereducationarea = $row3['teachereducationArea']; 
							 }	
						 }
//---------------------------------------for university----------------------------------	
if($dbteachereducationarea == 'University'){

	?>
	<form action="teacher_sign_up_two.php" method ="POST" >
	<table>
	       <tr>
             <td>
              <b>Course</b> 
           </td>
            <td>
               <select name = "Course">
                    <option value ="choose">choose</option>
                    <?php
                    include("connection.php");
					 
					 $sql1 = "SELECT DISTINCT catName FROM categories ";
		             $result3 = $conn->query($sql1);
					 $numrows= mysqli_num_rows($result3);
					 if($numrows!=0){
					 
					 while($row = mysqli_fetch_assoc($result3))
		                {
			            $dbcatname = $row["catName"];
					    echo"<option>"'.$dbcatname.'"</option>";
			            }
					 }
	?>
                 </select>
          </td></table></form>
   <?php
}else{
	 //------------------------------------- for school ---------------------------------
$logteacherid = $_SESSION['logteacherid'];
if (isset($_POST['submit']))
{
$gradeone = $_POST['gradeone'];
if ($gradeone == 'choose'){$gradeone = empty($gradeone);}else{$gradeone = $_POST['gradeone'];}
$gradetwo = $_POST['gradetwo'];
if ($gradetwo == 'choose'){$gradetwo = empty($gradetwo);}else{$gradetwo = $_POST['gradetwo'];}
$gradethree = $_POST['gradethree'];
if ($gradethree == 'choose'){$gradethree = empty($gradethree);}else{$gradethree = $_POST['gradethree'];}
$gradefour = $_POST['gradefour'];
if ($gradefour == 'choose'){$gradefour = empty($gradefour);}else{$gradefour = $_POST['gradefour'];}
$gradefive = $_POST['gradefive'];
if ($gradefive == 'choose'){$gradefive = empty($gradefive);}else{$gradefive = $_POST['gradefive'];}
$gradesix = $_POST['gradesix'];
if ($gradesix == 'choose'){$gradesix = empty($gradesix);}else{$gradesix = $_POST['gradesix'];}
$classone = $_POST['classone'];
if ($classone == 'choose'){$classone = empty($classone);}else{$classone = $_POST['classone'];}
$classtwo = $_POST['classtwo'];
if ($classtwo == 'choose'){$classtwo = empty($classtwo);}else{$classtwo = $_POST['classtwo'];}
$classthree = $_POST['classthree'];
if ($classthree == 'choose'){$classthree = empty($classthree);}else{$classthree = $_POST['classthree'];}
$classfour = $_POST['classfour'];
if ($classfour == 'choose'){$classfour = empty($classfour);}else{$classfour = $_POST['classfour'];}
$classfive = $_POST['classfive'];
if ($classfive == 'choose'){$classfive = empty($classfive);}else{$classfive = $_POST['classfive'];}
$classsix = $_POST['classsix'];
if ($classsix == 'choose'){$classsix = empty($classsix);}else{$classsix = $_POST['classsix'];}
$hourDateGMT = date("H");
$hourDateLebanon = $hourDateGMT+2;
$date = date("Y.m.d $hourDateLebanon:i:s");

if(($gradeone&&$classone)||($gradetwo&&$classtwo)||($gradethree&&$classthree)||($gradefour&&$classfour)||($gradefive&&$classfive)||($gradesix&&$classsix))	
{
$sql = "INSERT INTO teachergrade (teachergradeID,teacherID,teachergradeOne,teachergradeTwo,teachergradeThree,teachergradeFour,teachergradeFive,teachergradeSix,teachergradeDate) VALUES(null,'$logteacherid','$gradeone','$gradetwo','$gradethree','$gradefour','$gradefive','$gradesix','$date')";  //inserting to the database teachergrade when all the information are True
									
	if ($conn->query($sql) === TRUE) {
	}else{
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	
	$sqlfetchteachergradeid = mysqli_query($conn,"SELECT * FROM teachergrade WHERE teacherID='$logteacherid'");
	                    $numrows = mysqli_num_rows($sqlfetchteachergradeid);
	                     if($numrows != 0)
	                     {					 
                   while($row = mysqli_fetch_assoc($sqlfetchteachergradeid))
							 {
	                  $dbteachergradeid = $row['teachergradeID']; 
							 }
						 }
						 

	//----------------------  insert into database the teacher class table ------------
	
	$sql1 = "INSERT INTO teacherclass (teacherclassID,	teachergradeID,teacherID,teacherclassOne,teacherclassTwo,teacherclassThree,teacherclassFour,teacherclassFive,teacherclassSix,teacherclassDate) VALUES(null,'$dbteachergradeid','$logteacherid','$classone','$classtwo','$classthree','$classfour','$classfive','$classsix','$date')";  //inserting to the database teachergrade when all the information are True
									
	if ($conn->query($sql1) === TRUE) {
		
		
		header("location:teacher_sign_up_four.php");
	}else{
		echo "Error: " . $sql1 . "<br>" . $conn->error;
	}

}else{
	echo "<p><b><font color = 'red'>Please Choose one</font></b></p>";
}
}

?>
<form action="teacher_sign_up_three.php" method ="POST" >
<table>
        <tr>       
             <td>
              <b>Grade : left to right</b> 
           </td>
            <td>
               <select name ='gradeone'>
                     <option value ="choose">choose</option>
                     <option value ="1">1</option>
                     <option value ="2">2</option>
                     <option value ="3">3</option>
                     <option value ="4">4</option>
                     <option value ="5">5</option>
                     <option value ="6">6</option>
                     <option value ="7">7</option>
                     <option value ="8">8</option>
                     <option value ="9">9</option>
                     <option value ="10">10</option>
                     <option value ="11">11</option>
                     <option value ="12">12</option>
                 </select>
          </td>
          <td>
               <select name ='gradetwo'>
                     <option value ="choose">choose</option>
                     <option value ="1">1</option>
                     <option value ="2">2</option>
                     <option value ="3">3</option>
                     <option value ="4">4</option>
                     <option value ="5">5</option>
                     <option value ="6">6</option>
                     <option value ="7">7</option>
                     <option value ="8">8</option>
                     <option value ="9">9</option>
                     <option value ="10">10</option>
                     <option value ="11">11</option>
                     <option value ="12">12</option>
                 </select>
          </td>
          <td>
               <select name ='gradethree'>
                     <option value ="choose">choose</option>
                     <option value ="1">1</option>
                     <option value ="2">2</option>
                     <option value ="3">3</option>
                     <option value ="4">4</option>
                     <option value ="5">5</option>
                     <option value ="6">6</option>
                     <option value ="7">7</option>
                     <option value ="8">8</option>
                     <option value ="9">9</option>
                     <option value ="10">10</option>
                     <option value ="11">11</option>
                     <option value ="12">12</option>
                 </select>
          </td>
          <td>
               <select name ='gradefour'>
                     <option value ="choose">choose</option>
                     <option value ="1">1</option>
                     <option value ="2">2</option>
                     <option value ="3">3</option>
                     <option value ="4">4</option>
                     <option value ="5">5</option>
                     <option value ="6">6</option>
                     <option value ="7">7</option>
                     <option value ="8">8</option>
                     <option value ="9">9</option>
                     <option value ="10">10</option>
                     <option value ="11">11</option>
                     <option value ="12">12</option>
                 </select>
          </td>
          <td>
               <select name ='gradefive'>
                     <option value ="choose">choose</option>
                     <option value ="1">1</option>
                     <option value ="2">2</option>
                     <option value ="3">3</option>
                     <option value ="4">4</option>
                     <option value ="5">5</option>
                     <option value ="6">6</option>
                     <option value ="7">7</option>
                     <option value ="8">8</option>
                     <option value ="9">9</option>
                     <option value ="10">10</option>
                     <option value ="11">11</option>
                     <option value ="12">12</option>
                 </select>
          </td>
          <td>
               <select name ='gradesix'>
                     <option value ="choose">choose</option>
                     <option value ="1">1</option>
                     <option value ="2">2</option>
                     <option value ="3">3</option>
                     <option value ="4">4</option>
                     <option value ="5">5</option>
                     <option value ="6">6</option>
                     <option value ="7">7</option>
                     <option value ="8">8</option>
                     <option value ="9">9</option>
                     <option value ="10">10</option>
                     <option value ="11">11</option>
                     <option value ="12">12</option>
                 </select>
          </td>
          </tr>
          <tr>
         <td>
              <b>The # of Class(room) :</b> 
           </td>
            <td>
                  <select name ='classone'>
                     <option value ="choose">choose</option>
                     <option value ="1">1</option>
                     <option value ="2">2</option>
                     <option value ="3">3</option>
                     <option value ="4">4</option>
                     <option value ="5">5</option>
                     <option value ="6">6</option>
                     <option value ="7">7</option>
                     <option value ="8">8</option>
                     <option value ="9">9</option>
                     <option value ="10">10</option>
                     <option value ="11">11</option>
                     <option value ="12">12</option>
                     <option value ="13">13</option>
                     <option value ="14">14</option>
                     <option value ="15">15</option>
                     <option value ="16">16</option>
                     <option value ="17">17</option>
                     <option value ="18">18</option>
                     <option value ="19">19</option>
                     <option value ="20">20</option>
                    </select>
          </td>
           <td>
                  <select name ='classtwo'>
                     <option value ="choose">choose</option>
                     <option value ="1">1</option>
                     <option value ="2">2</option>
                     <option value ="3">3</option>
                     <option value ="4">4</option>
                     <option value ="5">5</option>
                     <option value ="6">6</option>
                     <option value ="7">7</option>
                     <option value ="8">8</option>
                     <option value ="9">9</option>
                     <option value ="10">10</option>
                     <option value ="11">11</option>
                     <option value ="12">12</option>
                     <option value ="13">13</option>
                     <option value ="14">14</option>
                     <option value ="15">15</option>
                     <option value ="16">16</option>
                     <option value ="17">17</option>
                     <option value ="18">18</option>
                     <option value ="19">19</option>
                     <option value ="20">20</option>
                    </select>
          </td>
           <td>
                  <select name ='classthree'>
                     <option value ="choose">choose</option>
                     <option value ="1">1</option>
                     <option value ="2">2</option>
                     <option value ="3">3</option>
                     <option value ="4">4</option>
                     <option value ="5">5</option>
                     <option value ="6">6</option>
                     <option value ="7">7</option>
                     <option value ="8">8</option>
                     <option value ="9">9</option>
                     <option value ="10">10</option>
                     <option value ="11">11</option>
                     <option value ="12">12</option>
                     <option value ="13">13</option>
                     <option value ="14">14</option>
                     <option value ="15">15</option>
                     <option value ="16">16</option>
                     <option value ="17">17</option>
                     <option value ="18">18</option>
                     <option value ="19">19</option>
                     <option value ="20">20</option>
                    </select>
          </td>
           <td>
                  <select name ='classfour'>
                     <option value ="choose">choose</option>
                     <option value ="1">1</option>
                     <option value ="2">2</option>
                     <option value ="3">3</option>
                     <option value ="4">4</option>
                     <option value ="5">5</option>
                     <option value ="6">6</option>
                     <option value ="7">7</option>
                     <option value ="8">8</option>
                     <option value ="9">9</option>
                     <option value ="10">10</option>
                     <option value ="11">11</option>
                     <option value ="12">12</option>
                     <option value ="13">13</option>
                     <option value ="14">14</option>
                     <option value ="15">15</option>
                     <option value ="16">16</option>
                     <option value ="17">17</option>
                     <option value ="18">18</option>
                     <option value ="19">19</option>
                     <option value ="20">20</option>
                    </select>
          </td>
           <td>
                  <select name ='classfive'>
                     <option value ="choose">choose</option>
                     <option value ="1">1</option>
                     <option value ="2">2</option>
                     <option value ="3">3</option>
                     <option value ="4">4</option>
                     <option value ="5">5</option>
                     <option value ="6">6</option>
                     <option value ="7">7</option>
                     <option value ="8">8</option>
                     <option value ="9">9</option>
                     <option value ="10">10</option>
                     <option value ="11">11</option>
                     <option value ="12">12</option>
                     <option value ="13">13</option>
                     <option value ="14">14</option>
                     <option value ="15">15</option>
                     <option value ="16">16</option>
                     <option value ="17">17</option>
                     <option value ="18">18</option>
                     <option value ="19">19</option>
                     <option value ="20">20</option>
                    </select>
          </td>
           <td>
                  <select name ='classsix'>
                     <option value ="choose">choose</option>
                     <option value ="1">1</option>
                     <option value ="2">2</option>
                     <option value ="3">3</option>
                     <option value ="4">4</option>
                     <option value ="5">5</option>
                     <option value ="6">6</option>
                     <option value ="7">7</option>
                     <option value ="8">8</option>
                     <option value ="9">9</option>
                     <option value ="10">10</option>
                     <option value ="11">11</option>
                     <option value ="12">12</option>
                     <option value ="13">13</option>
                     <option value ="14">14</option>
                     <option value ="15">15</option>
                     <option value ="16">16</option>
                     <option value ="17">17</option>
                     <option value ="18">18</option>
                     <option value ="19">19</option>
                     <option value ="20">20</option>
                    </select>
          </td>
      </tr>
      <tr>
      <td>
      <input type='submit' name='submit'  value='Next Step'/>
      </td>
      <td>
      </tr>
</table>
</form>
<?php  } ?>
</body>
</html>