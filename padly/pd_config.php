<?php

$PD_SIGNUPFORM = array(
        "Username" => array("type"=>"text","required"=>"yes"),
        "Password" => array("type"=>"password","required"=>"yes"),
        "First Name" => array("type"=>"text"),
        "Second Name" => array("type"=>"text"),
        "Email Address" => array("type"=>"text","required"=>"yes"),
	"Your Feedback" => array("type"=>"textarea","required"=>"yes"),
	"Phone" => array("type"=>"text"),
        "Sex" => array("type"=>"select","option"=>"Male,Female"),
	"Marital Status" => array("type"=>"radio","option"=>"Married,Single","required"=>"yes"),
        
       );






define("DBNAME", "padly");
define("BASEURL", "padly");
define("RETRIEVE", "retrievepass.php");
define("BASE_REGISTER",'register.php');
define("APP_BASE",'http://localhost/p');
define("APP",'Indigox');
define("SIGNUP_SUCESS","registered.php");
define("SIGNUP_FAIL","error.php");
define("LANDING_PAGE","http://localhost/p/home.php");
define("DOMAIN","http://localhost/");
define("PD_BASE","http://localhost/p/padly");
define("LOGIN","http://localhost/p/index.php");


$PD_ERROR = array(
                    0 => " Please Enter a Valid Username and Password ",
                    1 => " Please Login in Other to Procede "
                    );








?>