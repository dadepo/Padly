<!DOCTYPE html> 
<html lang="en"> 
<head> 
<meta charset="utf-8">
<title>Example of A Basic Sign Up Page Using Padly</title> 



</head>

<body>
<div id="login">
<div id="desc">
<div style="width:700px;margin-left:100px;">

<img src="http://dadeadermi.com/testapp/padly/html/images/padly.gif" />
<p>Padly is a User Management System build with PHP</p>

<p>Padly takes care of the common User management tasks like creating accounts, validating input fields, auntenication and password retrieval</p>
<p>With Padly you won't need to worry about these basic user management tasks.</p>

<h3>Features</h3>
<ul>
<li>Easily Integratable</li>
<li>Password Retrieval System</li>
<li>Fields Validation</li>
<li>Easily Configurable</li>
</ul>

<h3>How To Use Padly</h3>
<p>Integrating Padly into a project is extremely easy.</p>

</div>
</div>
<div id="loginbox"> 
<?php
include("padly/padly.php");
$sul = new Padly($con);
$sul->display('basic');
?>
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

<?php



?>
