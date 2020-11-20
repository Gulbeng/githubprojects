<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>sign up two</title>
</head>

<body>
<?php
include('connection.php');
$loguserid = $_SESSION['loguserid'];
if (isset($_POST['submit']))
{
$firstname = $_POST['firstname'];
$middlename = $_POST['middlename'];
$lastname = $_POST['lastname'];
$hometown = $_POST['hometown'];
$schooluniname = $_POST['schooluniname'];
$grade = $_POST['grade'];
$class = $_POST['class'];
	
if($firstname&&$middlename&&$lastname)
{

if(!empty($hometown))
{
if(!empty($schooluniname))
{
if($grade != 'choose')
{
	if($class != 'choose')
{
	
$updatesql = "UPDATE user
SET firstName = '$firstname',middleName = '$middlename',lastName = '$lastname',userHometown = '$hometown',schooluniName = '$schooluniname',userGrade = '$grade',userClass = '$class'
WHERE userID = '$loguserid'";
if ($conn->query($updatesql) === TRUE) {
    header('Location:sign_up_three.php');
} else {
    echo "Error updating record: " . $conn->error;
}	
}else{
	echo "<p><b><font color = 'red'>Please choose number of class</font></b></p>";
	
}
	
	
}else{
	
	 echo "<p><b><font color = 'red'>Please choose number of grade</font></b></p>";
}
}else{
	
	echo "<p><b><font color = 'red'>Enter the school or university Name</font></b></p>";
	
}
}else{
	
	echo "<p><b><font color = 'red'>Enter the hometown</font></b></p>";
	
}
}else{
	
	echo  "<p><b><font color = 'red'>Please Enter firstname Middle and lastname</font></b></p>";
}
}
	
?>

<form action="sign_up_two.php" method ="POST" >
<table>
    <tr>
           <td>
              <b>Firstname :</b> 
           </td>
            <td>
               <input type='text' name='firstname' value="" placeholder="Firstname" />
           </td>
         </tr>
         <td>
              <b>Middle Name :</b> 
           </td>
            <td>
               <input type='text' name='middlename' value="" placeholder="Middle Name" />
           </td>
         </tr>
         <tr>
           <td>
              <b>Lastname :</b> 
           </td>
            <td>
               <input type='text' name='lastname' value="" placeholder="Lastname" />
           </td>
         </tr>
         <tr>
           <td>
              <b>Hometown :</b> 
           </td>
            <td>
               <input type='text' name='hometown' value="" placeholder="Hometown" />
           </td>
         </tr>
     <tr>
        <tr>
           <td>
              <b>School or University Name:</b> 
           </td>
            <td>
               <input type='text' name='schooluniname' value="" placeholder="Firstname" />
           </td>
         </tr>
         <tr>
         <td>
              <b>Grade :</b> 
           </td>
            <td>
               <select name ='grade'>
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
      </tr>
        <tr>
         <td>
              <b>Class :</b> 
           </td>
            <td>
                  <select name ='class'>
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
                    </select>if many number of classes
          </td>
      </tr>
      </tr>
         </tr> 
      <tr>
      <td>
      <input type='submit' name='submit'  value='Next'/>
      </td>
      <td>
      </tr>
</table>
</form>
</body>
</html>