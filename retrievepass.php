<!DOCTYPE html> 
<html lang="en"> 
<head> 
<meta charset="utf-8"> 
<title>Example of Retrieve Password Page</title> 
</head>

<body>
<?php
include("padly/padly.php");
$sul = new Padly($con);

if (!isset($_GET['key']))
{
$sul->display('retrive');
}
else
{
//display link
$sul->display('resetpassword');
}
?>
</body>

</html>

<?php



?>
