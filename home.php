<?php
include("padly/padly.php");
$sul = new Padly($con);

$sul->init();

$sul->logout();
/*echo "We are in business";
session_start();
echo $_SESSION['uname'];*/

?>