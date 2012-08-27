<!DOCTYPE html> 
<html lang="en"> 
<head> 
<meta charset="utf-8"> 
<title>Example of Retrieve Password Page</title> 
<link rel='stylesheet' type='text/css' href='./padly/html/style/main.css' />
</head>

<body>
<div id="login">
<div id="desc">
<div style="width:700px;margin-left:100px;">
<?php
include("padly/padly.php");
$sul = new Padly();

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
</div>
</div>
</div>
</body>

</html>


