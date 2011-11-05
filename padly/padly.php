<?php

include("pd_config.php");




class Padly
    {
        private $dbc;
        private $db;
        
        
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
echo $dbfields."<br>";
echo $dbvalues."<br>";

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
header("location:".SIGNUP_SUCESS);
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
        print_r($_SESSION);
        
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


    ini_set('SMTP','smtp.wlink.com.np');
    ini_set('smtp_port',25);
    ini_set('auth_username','dadepo04@yahoo.com');
ini_set('auth_password','ojigidiri');
    mail($address,$subj,$message,$headers);
    
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
 `key` VARCHAR(225) NOT NULL, `email` VARCHAR(45) NOT NULL, PRIMARY KEY (`ppeid`)) ENGINE = MyISAM;");
            if(!$r)
            {
                echo mysql_error();
            }
            
            
        }
        //whatever the case the table would have been created
            //udate it
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
                echo $dlink;
                //SendMessage($remail,"Retrieve Your Password",$dlink);
                
            }
        
        
        
        
        
        //$this->SendMessage($remail,'Password retrieval Link','Here is the link');
    }
    
    
}
        
        
public function reset($thepost)
{
    extract($thepost);
    //echo $resetpass;
    $key = substr($key,4);
    $r = mysql_query("SELECT email from pdki_password_email where dkey = '$key'");
    if ($r)
    {
        if (mysql_num_rows($r) == 1)
        {
            //update with new password
            $email = mysql_fetch_row($r,0);
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
        
        
        
        
        
        
        
        
    }
 
?>