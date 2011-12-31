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
<h2>You Are Logged In</h2>
<p>After login, the user's information is available to you. This information
is returned as an array when the init() method is called
<pre>
//include the padly class
include("padly/padly.php");
//create an object
$sul = new Padly($con)</pre>
</p>
<p>Below is an example of what the method returns.</p>
<?php
include("padly/padly.php");
$sul = new Padly($con);

$session = $sul->init();
echo "<pre>";
print_r($session);
echo "</pre>";



/*echo "We are in business";
session_start();
echo $_SESSION['uname'];*/

?>

<h3>Updating Fields</h3>
<p>Padly allows not only allows you to access fields, you can update or modify fields.</p>
<p>You do this via the <strong>updateProfile</strong> method. You pass 3 fields into this method: <em>fields name</em><em>Value to add</em><em>Session ID identifying the User.</em></p>

<p>For example</p>

<?php
echo "<pre>";
echo '$sul->updateProfile("First_Name","Oma",$_SESSION["uid"])';
echo "</pre>";

?>
<h3>Log Out</h3>
<p>Finally to log out is easy. To log out, call the logout method.</p>
<pre>
$sul->logout();
</pre>
<?php
$sul->logout();
?>
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

<?php



?>
