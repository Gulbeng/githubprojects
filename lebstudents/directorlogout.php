<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>director logout</title>
</head>

<body>
<?php 
session_start();
session_destroy();

header("Location:director.php");

?>
</body>
</html>