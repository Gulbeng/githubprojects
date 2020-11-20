<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>functions</title>
</head>

<body>
<?php
//       -------------------------------------------------------------- functions -----------------------------------

	
function Loggedin() {

if(isset($_SESSION['loguserid']) && !empty($_SESSION['loguserid'])){
	
	return true;
	
}
else
{
	return false;
}
}
	
	
//getusername function
function getuser($id,$field)
{
	include("connection.php");
	$query = mysqli_query($conn,"SELECT $field FROM user where userID ='$id'");
	$run= mysqli_fetch_array($query);
	return $run[$field];

	
}
	
	

//get the pic name
function getpicname($id,$name)
{
	include("connection.php");
	$querypic = mysqli_query($conn,"SELECT $name FROM profilepic where userID ='$id'");
	$run=mysqli_fetch_array($querypic);
	return $run[$name];
	
}

	
//get the pic name of teacher
function getteacherpicname($id,$name)
{
	include("connection.php");
	$querypic = mysqli_query($conn,"SELECT $name FROM teacherprofilepic where teacherID ='$id'");
	$run=mysqli_fetch_array($querypic);
	return $run[$name];
	
}	
	
function getdirectorpicname($id,$name)
{
	include("connection.php");
	$querypicdirct = mysqli_query($conn,"SELECT $name FROM directorprofilepic where directorID ='$id'");
	$run=mysqli_fetch_array($querypicdirct);
	return $run[$name];
	
}		

// get user id
function getuserid($name,$id)
{
	include("connection.php");
	$queryid = mysqli_query($conn,"SELECT $id FROM user where userName ='$name'");
	$runid= mysqli_fetch_array($queryid);
	return $runid[$id];

	
}


// get user name
function getusername($id,$name)
{
	include("connection.php");
	$queryname = mysqli_query($conn,"SELECT $name FROM user where userID ='$id'");
	$runname= mysqli_fetch_array($queryname);
	return $runname[$name];

	
}	
// get nickname	
function getnickname($id,$name)
{
	include("connection.php");
	$queryname = mysqli_query($conn,"SELECT $name FROM user where userID ='$id'");
	$runname= mysqli_fetch_array($queryname);
	return $runname[$name];

	
}
	
	
	

	
	function fetch_name($name)
{
	include("connection.php");
	$sql1 = mysqli_query($conn,"SELECT * FROM user WHERE userName = '$name' ");
	                              $numrows = mysqli_num_rows($sql1);
				                  if($numrows!=0)
	                                 {
		                               while($row = mysqli_fetch_assoc($sql1))
		                                 {
			                           
			                          $fdbusername = $row['userName'];
		                               
                                         }
	
	                 return($fdbusername);
									 }
}
	
	
	
	
	
	function fetch_pass($pass)
{
	include("connection.php");
	
	$sql2 = mysqli_query($conn,"SELECT * FROM user WHERE passWord = '$pass' ");
	                              $numrows = mysqli_num_rows($sql2);
				                  if($numrows!=0)
	                                 {
		                               while($row = mysqli_fetch_assoc($sql2))
		                                 {
			                           
			                          $fdbuserpass = $row['passWord'];
		                               
                                         }
	
	                 return($fdbuserpass);
									 }
}

// function to delete 	all folders and files from user account by admin
function rrmdir($dir) {
    $structure = glob(rtrim($dir, "/").'/*');

    $rm_dir_flag = true;

    if (is_array($structure))
    {
        foreach($structure as $file) 
        {
            if (is_dir($file))
            {
                rrmdir($file);
            }
            else if(is_file($file))
            {
                $ext = substr($file, -4);
                
                unlink($file);
                  
            }   
        }
    }

    if($rm_dir_flag)
    {
        rmdir($dir);
    }   
}
	
?>


</body>
</html>