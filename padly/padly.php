<?php
/**
Copyright (c) 2011, Dadepo Aderemi.  This file is
licensed under the GNU GENERAL PUBLIC LICENSE.  See
the COPYRIGHT file
*/
?>
<?php



include("pd_config.php");




class Padly
    {
        private $dbc;
        private $db;
	public $test = "Dade";
        
        
        public function __construct($dbc) //variable: DB connect resource
        {
            //load constants
            
            
            
            
            
            
            
            //check if databse connection is a resource
            if (!is_resource($dbc))
            {
                //do something
                echo "Not Connected to A database";
            }
            else
            {
                
                
                
                //check if Database given exist
                $dbt = mysql_select_db(DBNAME);
                if (!$dbt)
                {
                    if (mysql_errno() == 1049)
                        {
                            die("Database Not Valid");
                        }
                    else
                    {
                        die("Strange things do happen...an unknown Error Just occured. Check the Error Code". mysql_errno()." for more info");
                    }
                }
                
                else
                {
                    //set private variable
                    $this->dbc = $dbc;
                    $this->db = DBNAME;
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
                        //echo "Good To Go";
                    }
                //check if this is the first time of instatiating the Class
                //if so then you need to run the necesseary scrip to create the DB table
                    
                    
                }
                
                
                
                
            }
            
        }
        
        
        
        
        public function display($type)
        {
        
        
        switch($type)
            {
                case 'basic':
                include('html/basic.php');
                break;
                
                case 'signup':
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
        
        
        
        public function signup($thepost)
        {
             //Array ( [sul_dbname] => test [signup] => signup [Username] => [Password] => [First_Name] => [Second_Name] => [Email_Address] => [Phone] => )
//why do i have database name being stored in the html, it should be retrieved from config file
			 
extract($thepost);
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
        $dbtablevalues[] = md5(mysql_escape_string($v));
    }
    else
    {
    $dbtablevalues[] = mysql_escape_string($v);
    }
}

$dbvalues = "'".implode("','",$dbtablevalues)."'";
//echo $dbfields."<br>";
//echo $dbvalues."<br>";

mysql_select_db("$dbname");
$q = mysql_query("INSERT into sul_signup_profile($dbfields) values($dbvalues)");
if (!$q)
{
    echo mysql_error();
    
	header("location:".SIGNUP_FAIL);
}
else
{
 //add to sul_profile db
 
    
    
//created successfully
header("location:".APP_BASE.'/'.SIGNUP_SUCESS);
}
            
}


public function login($thepost)
{
    extract($thepost);
    $uname = mysql_escape_string($uname);
    $password = md5(mysql_escape_string($password));
    //check if present in sul_login
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
        header("location:".LANDING_PAGE);
        //signin
    }
    else
    {
        
        header("location:$sender_url?errmsg=1");
        //wrong credentials
    }
}
        
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
        header("location:".LOGIN."?errmsg=2");
    }
}


public function logout()
{
    
    //show only if session exist
    if (count($_SESSION) > 0 )
    {
    include('html/signout.php');
    }
}

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
        
public function send_email_retrieve_link($thepost)
{
    
    extract($thepost);
    //check if there is a user with thi email address
    $r = mysql_query("SELECT * from sul_signup_profile where Email_Address = '$remail'");
    if (mysql_num_rows($r))// user exist
    {
        
        
        //generate the link
        $dkey = md5($remail.time());
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
                die("Strange things do happen");
            }
            else
            {
                //now send the link
                //also add an additional 4 digits to the begining to begin the string
                $dlink = APP_BASE.'/retrievepass.php?key='.rand(1000,2999).$dkey;
                //echo $dlink;
                $this->SendMessage($remail,"Retrieve Your Password",$dlink);
                
            }
        
        
        
        
        
        //$this->SendMessage($remail,'Password retrieval Link','Here is the link');
    }
    
    
}
        
        
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
		$PD_BASE = PD_BASE;
		echo "<span id='msg_$nkey' style='margin-left:10px;display:none'><img src='$PD_BASE/html/images/loading.gif' /></span>";
	}
	
	
	}
	
	
	
	
	
	
	
	
	
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
	
	public function displayTextarea($PD_SIGNUPFORM,$key,$type,$req)
	{
	    echo "<label for=''>$key";if($req == 1) echo '*'; echo "</label>";
	    $star = '';
	    if($req == 1) 
	    {
	    $star = 'req';
	    }
	    $nkey = str_replace(" ", "_",$key);
	    $PD_BASE = PD_BASE;
	    echo "<textarea name='$key' id='$key' class='large $star'></textarea><span id='$nkey' style='margin-left:10px;display:none'><img src='$PD_BASE/html/images/loading.gif' /></span>";
	    
	}
	
	
	public function updateProfile($field,$value,$uid)
	{
	//you get the UID from the session $_SESSION['uid']
	$f = str_replace(" ", "_", mysql_escape_string($field));
	$v = mysql_escape_string($value);
	$uid = mysql_escape_string($uid);
	
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
 
?>
