<?php

/**
Copyright (c) 2011, Dadepo Aderemi.  This file is
licensed under the GNU GENERAL PUBLIC LICENSE.  See
the COPYRIGHT file
*/

//this must be coming from register.php
//right script to check this

include("padly.php");

$sul = new Padly();

if (isset($_POST['logout']))
{
    //code to minimal..dont think it is necessary to create a method of the Padly class out of this.
    session_start();
    session_destroy();
    //redirect to logout page
    header("location:".SITE_DIR);
}


if (isset($_POST['signup']))
{
    $r = $sul->signup($_POST);
	
}

if (isset($_POST['login']))
{

    $r = $sul->login($_POST);
    

}
   
if (isset($_POST['retrieve']))
{

   $r = $sul->send_email_retrieve_link($_POST);
    

}


if (isset($_POST['reset']))
{
    //now reste the password
   $r = $sul->reset($_POST);

}

?>
