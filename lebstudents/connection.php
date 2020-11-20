<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>connection</title>
</head>

<body>


<?php
$servername = "localhost";
$serverusername = "root";
$serverpassword = "";
$serverdbname = "lebstudentdatabase";

// Create connection
$conn = new mysqli($servername, $serverusername,$serverpassword, $serverdbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


?>

</body>
</html>