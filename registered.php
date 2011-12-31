<!DOCTYPE html> 
<html lang="en"> 
<head> 
<meta charset="utf-8">
<title>Registering Successful</title> 

<?php
include("padly/padly.php");
?>

</head>

<body>
<div id="login">
<div id="desc">
<div style="width:700px;margin-left:100px;">

<img src="http://dadeadermi.com/testapp/padly/html/images/padly.gif" />
<h2>You Are Now Registered</h2>
<p><a href="<?php echo LANDING_PAGE?>">Login</a></p>
</div>
</div>
<div id="loginbox"> 

</div>
</div>
</body>


<style type="text/css">
body
{
margin:0px;
}
div#login
{
border-top:40px solid #333;
overflow:auto;

}
div#desc
{
padding-top:20px;
width:70%;
float:left;
background-color:#eee;
-webkit-box-shadow: inset -5px 2px 7px #888;
}

div#loginbox
{
width:20%;
float:left;
}

</style>

</html>


