<?php
//{{{ Padly
/**
Copyright (c) 2011, Dadepo Aderemi. 
The Padly Single Class that takes care of the function of creating signup forms and databse access
*/
class Padly
    {
    
	//set private properties that would be assigned by the settings in the pd_config fie
	private $signupform;
	private $databaseconnection;
	private $databasename;
	
	
 
public function __construct() //variable: DB connect resource
{
            //load constant
	define('ACCESS',true); //ensure that the config file is only loaded from within the class
	include("pd_config.php");
	//get needed variables from inlcuded file and make them properties of class
	$con = mysql_connect($dbsettings['host'],$dbsettings['user'],$dbsettings['password']);
	$this->databaseconnection = $con;
	$this->signupform = $PD_SIGNUPFORM;
	$this->databasename = DBNAME;
	
            //check if databse connection is a resource
            if (!is_resource($this->databaseconnection))
            {
                echo "Not Connected to A database. Check the database settings in pd_config.php and ensure it is set properley";
            }
            else
            {
                //check if Database given exist
                $selectdb = mysql_select_db(DBNAME);
		
                if (!$selectdb)
                {
		
                    if (mysql_errno() == 1049)
                        {
				//create database
				$r = mysql_query("CREATE DATABASE $this->databasename");
				if(!$r)
				{
				echo mysql_error();
				}
                        }
                    else
                    {
                        die("Strange things do happen...an unknown Error Just occured. Check the Error Code". mysql_errno()." for more info");
                    }
                }
                
                else
                {
                    
                    $test = mysql_query("select * from sul_login");//which is faster? this or mysql_list_table function
                    if (!$test)
                    {
                        //create table
                        $r = mysql_query("CREATE TABLE `sul_login` (
                                `uid` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
                                `uname` VARCHAR(45) NOT NULL,
                                `password` VARCHAR(45) NOT NULL,
                                `lastlogin` VARCHAR(45) NOT NULL,
                                 PRIMARY KEY (`uid`)
                                    )");
                        
                        if(!$r)
                        {
                            die(mysql_error());
                        }
                        
                    }
                    else
                    {
                        //"Good To Go";
                    } 
                    
                }
                
            }
            
}
        
        
	/**
	*displays the necessary input field. The displayed type is dependent on the type passed as argument
	*The Inpout that is displayed are html snippets that exist in the padly/html/ folder
	*/
public function display($type)
{
        
        
        switch($type)
            {
                case 'basic':
                include('html/basic.php');
                break;
                
                case 'signup':
		//make  class variables available for the included file
		$sform = $this->signupform;
		$dbc = $this->databaseconnection;
                include('html/signup.php');
                break;
            
                case 'retrive':
                include('html/retrieve.php');
                break;
            
                case 'resetpassword':
                include('html/reset.php');
                break;
            }
}
        
        


/**
* Creates new user in the database.
*/
public function signup($thepost)
        {
//Array ( [sul_dbname] => test [signup] => signup [Username] => [Password] => [First_Name] => [Second_Name] => [Email_Address] => [Phone] => )
//why do i have database name being stored in the html, it should be retrieved from config file			 
		extract($thepost); //make variables available in the current symbol table
		$dbname = $thepost['sul_dbname']; //get the dbname
		$darray = array_slice($thepost,2); //remove db name and...;
		$dbfields = implode(',',array_keys($darray));
		$dbtablevalues = array();
		reset($darray);
		while (list($k,$v) = each($darray))
		{
		    if($k == 'Password')
		    {
			//hash password
			$dbtablevalues[] = md5(mysql_real_escape_string($v));
		    }
		    else
		    {
		    $dbtablevalues[] = mysql_real_escape_string($v);
		    }
		}

		$dbvalues = "'".implode("','",$dbtablevalues)."'";
		//$dbvalues = mysql_real_escape_string($dbvalues);
		//mysql_select_db("$dbname");
		$q = mysql_query("INSERT into sul_signup_profile($dbfields) values($dbvalues)");
		if (!$q)
		{
		    $error = mysql_error();
		    header("location:"."../".REGISTER_SCRIPT."?login=fail&error=$error");
		}
		else
		{
		 //add to sul_profile db  
		//created successfully
		header("location:"."../".REGISTER_SCRIPT."?login=success");
		}
            
}



/**
* Takes care of checking if the user credentials is correct
*/
public function login($thepost)
{
    extract($thepost);
    $password = md5(mysql_real_escape_string($password));
    //check if present in sul_signup_profile
    $r = mysql_query("SELECT * from sul_signup_profile where Username = '$uname' AND Password = '$password'");
    if (mysql_num_rows($r))// user exist
    {
        //create session
        session_start();
        $r = mysql_fetch_assoc($r);
        foreach($r as $k=>$v)
        {
            $_SESSION[$k] = $v;
        }
        header("location:".SITE_DIR."/home.php");
        //signin
    }
    else
    {
        
        header("location:$sender_url?errmsg=1");
        //wrong credentials
    }
}





/**
* Makes the information of the logged in user available
* this method is used in the page directed to afer the login method runs
* if this Metod is called and no login of a user establised, it would redirect to homepage with an error message
*/

public function init()
{
    session_start();
    
    if (count($_SESSION) > 0 )
    {
        //know the variables available to you
        return $_SESSION;
        
    }
    else
    {
        header("location:".SITE_DIR."?errmsg=2");
    }
}


/**
* Logs out and destroys session created at login
*/

public function logout()
{
    
    //show only if session exist
    if (count($_SESSION) > 0 )
    {
    include('html/signout.php');
    }
}


/** 
*takes care of the process of sending email messages
*/

private function SendMessage($address,$subj,$message)
{
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From: sender@sender.com" . "\r\n";
    if(mail($address,$subj,$message,$headers))
    {
    echo "sent";
    }
    else
    {
    echo "notsent";
    }
    
}
        
	
/**
* Sends mail that generates he link that can be used to retrieve the password
*/
public function send_email_retrieve_link($thepost)
{
    
    extract($thepost);
    //check if there is a user with thi email address
    $r = mysql_query("SELECT * from sul_signup_profile where Email_Address = '$remail'");
    if (mysql_num_rows($r))// user exist
    {
        
        
        //generate the link
        $dkey = mysql_real_escape_string(md5($remail.time()));
	$remail = mysql_real_escape_string($remail);
        //check if the link table exist.
        $r = mysql_query("SELECT * from pdki_password_email");
        if (!$r) //does not exist
        {
            //create it
            $r = mysql_query("CREATE TABLE `pdki_password_email` (`ppeid` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
 `dkey` VARCHAR(225) NOT NULL, `email` VARCHAR(45) NOT NULL, PRIMARY KEY (`ppeid`)) ENGINE = MyISAM;");
            if(!$r)
            {
                echo mysql_error();
            }
        }
        //whatever the case the table would have been created
            //update it
            $r = mysql_query("INSERT into pdki_password_email (dkey,email) values('$dkey','$remail')");
            if (!$r)
            {
                echo mysql_error();
                die("Strange things do happen :p");
            }
            else
            {
                //now send the link
                //also add an additional 4 digits to the begining to begin the string
                $dlink = APP_BASE.'/retrievepass.php?key='.rand(1000,2999).$dkey;
                //echo $dlink;
                $this->SendMessage($remail,"Retrieve Your Password",$dlink);
                
            }
        
        
    }
    
    
}
        
  
 /**
* Restes the new password
*/
public function reset($thepost)
{
    extract($thepost);
    //echo $resetpass;
    $resetpass = md5($resetpass);
    $key = substr($key,4);
    $r = mysql_query("SELECT email from pdki_password_email where dkey = '$key'");
    if ($r)
    {
        if (mysql_num_rows($r) == 1)
        {
            //update with new password
            $email = mysql_fetch_row($r);
            $email = $email[0];
            
            $r = mysql_query("UPDATE sul_signup_profile SET Password = '$resetpass' where Email_Address = '$email'");
            if(!$r)
            {
                echo mysql_error();
                exit;
            }
        }
    }
    else
    {
        echo mysql_error();
    }
}
        
        
public function displayText($options = "")
{
	echo "am Text";
}


//the HTML generating methods follows

/**
* Generates the HTML Select based on value set in pd_config.php
*/

public function displaySelect($PD_SIGNUPFORM,$key)
{
	echo "<label for=''>$key</label>
	<select class='medium' name='$key'>" ;
	$optionarray = split(',',$PD_SIGNUPFORM[$key]['option']);
	foreach($optionarray as $option)
	{
		echo "<option>$option</option>";
	}
	echo "</select>";

	
}
	
/**
* Generates the HTML radio based on value set in pd_config.php
*/
	
public function displayRadio($PD_SIGNUPFORM,$key,$type,$req)
{
	echo "<label for=''>$key";if($req == 1) echo '*'; echo "</label>";
	$optionarray = explode(',',$PD_SIGNUPFORM[$key]['option']);
	foreach($optionarray as $option)
	{
		echo "<span>$option</span><input type='$type' value='$option' name='$key' id='$key' class=";
		if($req == 1) echo 'req';
		echo ">";
		$nkey = str_replace(" ", "_",$key);
		echo "<span id='msg_$nkey' style='margin-left:10px;display:none'><img src=".SITE_DIR."'/html/images/loading.gif' /></span>";
	}	
	
}
	
	
	
	
	
/**
* Generates the HTML checkbox based on value set in pd_config.php
*/
	
public function displayCheckbox($PD_SIGNUPFORM,$key,$type,$req)
{
	
	
	echo "<label for=''>$key";if($req == 1) echo '*'; echo "</label>";
	$optionarray = split(',',$PD_SIGNUPFORM[$key]['option']);
	foreach($optionarray as $option)
	{
		echo "<span>$option</span><input type='$type' value='$option' name='$key' id='$key' class=";
		if($req == 1) echo 'req';
		echo ">";
		$nkey = str_replace(" ", "_",$key);
		$PD_BASE = PD_BASE;
		echo "<span id='msg_$nkey' style='margin-left:10px;display:none'><img src='$PD_BASE/html/images/loading.gif' /></span>";
	}
	
	
}



/**
* Generates the HTML Textarea based on value set in pd_config.php
*/


public function displayTextarea($PD_SIGNUPFORM,$key,$type,$req)
{
	    echo "<label for=''>$key";if($req == 1) echo '*'; echo "</label>";
	    $star = '';
	    if($req == 1) 
	    {
	    $star = 'req';
	    }
	    $nkey = str_replace(" ", "_",$key);
	    $PD_BASE = APP_PATH;
	    $msg = str_replace(' ', '_',$key);
	    echo "<textarea name='$key' id='$key' class='large $star'></textarea><span id='$nkey' style='margin-left:10px;display:none'><img src='$PD_BASE/html/images/loading.gif' /></span><span id='msg_$msg' style='margin-left:10px;display:none'><img src='./padly/html/images/loading.gif' /></span>";
	    
}
	


/**
* Updates the login user's information in the databsee
*/

public function updateProfile($field,$value,$uid)
{
	//you get the UID from the session $_SESSION['uid']
	$f = str_replace(" ", "_", mysql_real_escape_string($field));
	$v = mysql_real_escape_string($value);
	$uid = mysql_real_escape_string($uid);
	
	$r = mysql_query("UPDATE sul_signup_profile SET $f = '$v' WHERE uid = $uid");
	if(!$r)
	{
	echo mysql_error();
	}
	else
	{
	//Should update session abi?
	$_SESSION[$f] = $v;
	}
}
          
    }
//}}}
 
?>
