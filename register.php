<!DOCTYPE html> 
<html lang="en"> 
<head> 
<meta charset="utf-8"> 
<title>Example of A Signup Page Using Padly</title> 
<link rel='stylesheet' type='text/css' href='./padly/html/style/bootstrap.css' />
<link rel='stylesheet' type='text/css' href='./padly/html/style/main.css' />
</head>

<body>
<div id="login">
<div id="desc">

<?php
include("padly/padly.php");
if (isset($_GET['login']) && $_GET['login'] == 'success')
{
echo "<h3>Your Account Has Been Created</h3><a class='btn primary' href='index.php'>You Can Now Login</a><br/><br/>";
}
elseif (isset($_GET['login']) && $_GET['login'] == 'fail')
{
echo "<h3>Account Creation Unsuccessful</h3><a class='btn primary' href='register.php'>Try Again</a><br/><br/>";
}
else
{
$sul = new Padly();
$sul->display('signup');
}
?>
</div>
</div>

</body>

</html>

