<?php
include("padly/padly.php");
$sul = new Padly($con);

$sul->init();

echo $_SESSION['uid'];

echo ($sul->updateProfile('First_Name','Oma',$_SESSION['uid']));

$sul->logout();
/*echo "We are in business";
session_start();
echo $_SESSION['uname'];*/

?>