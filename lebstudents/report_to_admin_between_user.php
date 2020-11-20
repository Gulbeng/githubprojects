<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Report a feedback for admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</head>

<body>
<?php
include("connection.php");
// ----------------------------------------------------   send process -------------------------------------------	
if(isset($_POST['send']))
{
$getuser = $_GET['user'];
$text = $_POST['text'];
$hourDateGMT = date("H");
$hourDateLebanon = $hourDateGMT+2;
$date = date("Y.m.d $hourDateLebanon:i:s");

	if($text)
	{

$sql = "INSERT INTO report_to_user (report_ID,report_Fromuser,report_Touser,	report_Text,report_Date)VALUES(null,'".$_SESSION['loguserid']."','$getuser','$text','$date')";
	if($conn->query($sql) === TRUE){
		
		echo "<b>Report Sent<b>";
		$to = "shahinianvako@hotmail.com";
		$subject = "a report from kdhub to a user";
		$headers = "From: ".$_SESSION['loguserid'];
		mail($to,$subject,$text,$headers);
		
	}else {
    echo "Error: " . $sql . "<br>" . $conn->error;
	}
	}else{
		
		echo "<b>Enter your Feedback </b>";
		
	}
}


$getuserid = mysqli_query($conn , "SELECT * FROM user WHERE userID ='".$_GET['user']."'");
$numrows = mysqli_num_rows($getuserid);
if($numrows !=0)
{
	while($row = mysqli_fetch_assoc($getuserid))
	{
	 
	 $dbfirstName = $row['firstName'];
	 $dblastName = $row['lastName'];
		    
	}
      
}	
	

echo '<form action = "report_to_admin_between_user.php?user='.$_GET['user'].'" method = "POST" accept-charset="ISO-8859-1" >
<table><tr>
           <td>
            <b> Report us about: '.$dbfirstName.' '.$dblastName.'</b> 
           </td>
        <td>
        </tr>
        <tr>
           <td>
             <input type = "hidden" value="<?php echo $dbusername; ?>" name= "username">
           </td>
        <td>
        </tr>
       <tr>
           <td>
              <b>Text Report:</b> 
           </td>
        <td>
         <textarea  type = "text" value="" placeholder ="Enter a report about '.$dbfirstName.' '.$dblastName.'" rows="15" cols="50" name= "text"></textarea>
       </td>
    </tr>
    <tr>
     <td>
      <input type= "submit" name= "send" value = "Send">
    </td>
   </tr>
</table>
</form>';
	
	
echo '<a href = "profile_one.php">Back To Profile</a>';
	?>

</body>
</html>