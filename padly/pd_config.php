<?php


if(!defined('ACCESS'))
{
die('Direct access not premitted');
}


$PD_SIGNUPFORM = array(
        "Username" => array("type"=>"text","required"=>"yes"),
        "Password" => array("type"=>"password","required"=>"yes"),
        "First Name" => array("type"=>"text"),
        "Second Name" => array("type"=>"text"),
        "Email Address" => array("type"=>"text","required"=>"yes"),
	"Why You Joining" => array("type"=>"textarea"),
	"Phone" => array("type"=>"text"),
        "Sex" => array("type"=>"select","option"=>"Male,Female"),
	"Marital Status" => array("type"=>"radio","option"=>"Married,Single","required"=>"yes"),
        
       );

$dbsettings = array(
'host' => 'localhost',
'user' => 'root',
'password' => '',
);

define("DBNAME", "padly");
define("RETRIEVE", "retrievepass.php");
define("REGISTER_SCRIPT",'register.php');
define("APP_PATH", "padly"); 
define("SITE_DIR",'http://localhost/padlytest');




?>