<!DOCTYPE html> 
<html lang="en"> 
<head> 
<meta charset="utf-8">
<title>Example of A Basic Sign Up Page Using Padly</title> 

<link rel='stylesheet' type='text/css' href='./padly/html/style/main.css' />



</head>

<body>
<div id="login">
<div id="desc">
<div style="width:700px;margin-left:100px;">

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

<strong>Instructions.</strong>
<pre>
You would find below the steps on how to use Padly in your application.

++++++++++++++++++++++++++++++++++++++++++++
<h2>--Getting Padly</h2>
Padly is hosted on Github. You can grab the development branch here: https://github.com/dadepo/Padly/zipball/dev. Extract the Zip file and rename it to padly. Next thing you need to do is to copy the padly folder into the root directory of your application. That is, if your application resides at http://localhost/yourapp, Padly should be in http://localhost/yourapp/padly

<h2>--Create the Database</h2>
Create a database and name it what you will. Let us assume the name of the database is padly
++++++++++++++++++++++++++++++++++++++++++++
<h2>--Configuring Padly</h2>
For Padly to work, you need to set up configurations. You find the configuration file in the Padly folder. It is named pd_config.php. Open up the file and proceed to setting up the necessary configurations

<h2>--Configuring Fields</h2>
<strong>$PD_SIGNUPFORM </strong>
This variable holds the array that is used to generate the table that would be needed for Padly. Specify the fields you want created for the signup form. Padly takes care of turning this into a sign up up and the creation of needed tables.
You can add or remove fields from this configuration later on and Padly would automatically back up the recent table for you as sul_signup_profile_backup .

A sample of this configuration exist in the pd_config.php file. Just edit to your needs but take note that The Username, Password, Email Address field should always be given using the specified key and that renaming keys in the array after an intial table has been generated would break your application. But you can add and remove fields even after initial table has been generated

<h2>--Database access</h2>

<strong>$dbettings</strong>
Specify your Database settings.


<h2>--Configuring Padly Constants</h2>
You have a list of constants that needs to be set for Padly to work properly. This would change as the project is updated but as at now, the following constants needs to be set

define("DBNAME", "padly"); 
//the database Padly would use. Leave this as it is or change to a database of your choice. If the database does not exist padly would generate it

define("RETRIEVE", "retrievepass.php"); 
//The name of the file that activates the password retrieval functionality. This file would be found in your app directory and would instantiate the Padly class and call the display method passing in 'retrieve' as parameter. Consult the included retrievepass.php file to see how this looks.
  
define("REGISTER_SCRIPT",'register.php');
//The name of the file that handles the registration form for a user to create an account in your app. This file would be found in your yourapp directory and would instantiate the Padly class and call the necessary method. Consult the included register.php file to see how this looks.

define("APP_PATH", "padly"); 
//defines the folder in which padly files are located. The default is padly and it is advised to have it this way


define("SITE_DIR",'http://localhost/padlytest');
//defines the web accessible location for the directory in which padly is used

+++++++++++++++++++++++++++++++++++++++++++++
<h2>--Retrieve password</h2>
Note that the retrieve password functionality wont work if you are testing Padly on a local machine.

+++++++++++++++++++++++++++++++++++++++++++++

<h2>--Accessing Information of Logged in User across your application</h2>

You can now create files in your application and have Padly take care if the user is logged in or not. Padly also takes care of accessing the profile information of the user. You would have to include the Padly class in each file you want to use it in your application.

include("padly/padly.php");
$sul = new Padly();

The init() method return in an array containing the information of the logged in user. 

$session = $sul->init();

You can do a var_dump on the array to see the contents. It maps to the fields of the table created and used by Padly
</pre>


</div>
</div>
<div id="loginbox"> 
<?php
include("padly/padly.php");
$sul = new Padly();
$sul->display('basic');
?>
</div>
</div>
</body>


</html>
