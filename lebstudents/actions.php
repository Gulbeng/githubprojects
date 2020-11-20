<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>action</title>
</head>

<body>
<?php
include('connection.php');
include('functions.php');

$action = $_GET['action'];
$user = $_GET['user'];
$my_id=$_SESSION['loguserid'];




if($action =="add")
{
	
	
	$sqlinst = "INSERT INTO frnd_req VALUES (null,'$my_id','$user')";
	if($conn->query($sqlinst) === TRUE)
	{
		
	}else {
    echo "Error: " . $sqlinst . "<br>" . $conn->error;
}
}

if($action =="cancel")
{
	
	
	$sql1  ="DELETE FROM `frnd_req` WHERE `from` = '$my_id' AND `to` = '$user' ";
	mysqli_query($conn, $sql1);
                      
                 
	
}


if($action =="accept")
{
	$hourDateGMT = date("H");
    $hourDateLebanon = $hourDateGMT+2;
    $date = date("Y.m.d $hourDateLebanon:i:s");
	
	$sql3 = "DELETE FROM `frnd_req` WHERE `from` = '$user' AND `to` = '$my_id' ";
	mysqli_query($conn, $sql3);
	$sql4  = "INSERT INTO frnds VALUES(null,'$my_id','$user','$date')";
	mysqli_query($conn, $sql4);
	
}


if($action == "ignore")
{
	$sql5 = "DELETE FROM `frnd_req` WHERE (`to` = '$user' AND  `from` = '$my_id' ) OR (`to` = '$my_id' AND  `from` = '$user' )";
	mysqli_query($conn, $sql5);
	
}




if($action =="unfrnd")
{
	
	
	$sql6 = "DELETE FROM frnds WHERE (userOne = '$my_id' AND userTwo = '$user') OR (userOne = '$user' AND userTwo = '$my_id') ";
	mysqli_query($conn, $sql6);
	
	
}

//   --------------------- like-----------------------
if($action =="like")
{
	$hourDateGMT = date("H");
    $hourDateLebanon = $hourDateGMT+2;
    $date = date("Y.m.d $hourDateLebanon:i:s");
	
	$sql4  = "INSERT INTO like VALUES(null,'$my_id','$user','$date')";
	mysqli_query($conn, $sql4);
	
}
	
// ------------------------------- unlike ------------------	
	if($action =="unlike")
{
	
	
	$sql6 = "DELETE FROM like WHERE (userOne = '$my_id' AND userTwo = '$user') OR (userOne = '$user' AND userTwo = '$my_id') ";
	mysqli_query($conn, $sql6);
	
	
}

header('Location:profiles_view.php?user='.$user);


?>




</body>
</html>