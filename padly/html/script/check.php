<?php

include("../../padly.php");
$sul = new Padly();


    
if(isset($_GET['dtype']) && $_GET['dtype'] == 'duplicate')
{
    $tocheck = $_GET['tocheck'];
    $db_field = $_GET['db_field'];
    
    $r = mysql_query("select * from sul_signup_profile where $db_field = '$tocheck'");
    if (!$r)
    {
        echo mysql_error();
        
    }
    if (mysql_num_rows($r) > 0)
    {
        //username already exist
        echo false;
    }
    else
    {
        //username free
        echo true;
    }
}



?>