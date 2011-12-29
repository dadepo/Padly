<?php

$PD_SIGNUPFORM = array(
        "Username" => array("type"=>"text","required"=>"yes"),
        "Password" => array("type"=>"password","required"=>"yes"),
        "First Name" => array("type"=>"text"),
        "Second Name" => array("type"=>"text"),
        "Email Address" => array("type"=>"text","required"=>"yes"),
	"Your Feedback" => array("type"=>"textarea","required"=>"yes"),
	"Phone" => array("type"=>"text"),
        //"Sex" => array("type"=>"select","option"=>"Male,Female"),
	"Marital Status" => array("type"=>"radio","option"=>"Married,Single","required"=>"yes"),
        
       );


//$con = mysql_connect("localhost","dadeade1_padly","padly123");
$con = mysql_connect("localhost","root","ojigidiri");


define("DBNAME", "padly");
define("BASEURL", "padly");
define("RETRIEVE", "retrievepass.php");
define("BASE_REGISTER",'register.php');
define("APP_BASE",'http://localhost/testapp');
define("APP",'Indigox');
define("SIGNUP_SUCESS","/cool");
define("SIGNUP_FAIL","/fail");
define("LANDING_PAGE","http://localhost/testapp/home.php");
define("DOMAIN","http://localhost/");
define("PD_BASE","http://localhost/testapp/padly");
define("LOGIN","http://localhost/testapp/index.php");


$PD_ERROR = array(
                    0 => " Please Enter a Valid Username and Password ",
                    1 => " Please Login in Other to Procede "
                    );

//constant pages
//register etc






?>