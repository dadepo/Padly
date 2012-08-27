<?php



?>

<div id="sulform">
<link rel="stylesheet" type="text/css" href="padly/html/style/bootstrap.css" />

<form method="post" action="<?php echo APP_PATH;?>/auth.php" class="form-stacked" id="pd_signupform">
    
<fieldset>
          
          <div class="clearfix">
		    <legend>Signup For Account</legend>
		    
	  <?php
	  
	  //first take care of the database
	  //check if signup db exits
	  $test = mysql_query("select * from sul_signup_profile");//which is faster? this or mysql_list_table function
	  if (!$test)
	  {
		    //then create table
		    //`uname` VARCHAR(45) NOT NULL,
		    $tstring = '';
		    while(current($sform))
		    {
			$tstring = $tstring . "`" . str_replace(" ","_", key($sform))."` VARCHAR (255) ,";
			next($sform);
		    }
		    
		    $r = mysql_query("CREATE TABLE `sul_signup_profile`(
                                `uid` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,".$tstring."`profile` varchar(45), PRIMARY KEY (`uid`))");
		    
		    if(!$r)
		    {
			      die(mysql_error());
		    }
		    else
		    {
			      
			      //now generate the HTML for the signup form
		    include_once("signupform.php");
		    }
		    
	  }
	  else
	  {
		    
		    //check if the number of fields specified in the config file is note same as in table
		    
		    if (mysql_num_fields($test) != (count($sform) + 2))
		    {
			      
			      //backup present table and create another one
			      if (mysql_query("select * from sul_signup_profile_backup"))
			      {
                              
				$r = mysql_query("drop table  sul_signup_profile_backup");
					if(!$r)
					{
					echo mysql_error();
					echo '222';
					exit;
					}
			      }
			      
			      
			      
			      
			      $alter_string = "ALTER TABLE `sul_signup_profile` RENAME TO `sul_signup_profile_backup`;";
                              
			      $r = mysql_query($alter_string);
			      if (!$r)
			      {
					echo mysql_error();
			      }
			      else
			      {
					//recreate table
					$tstring = '';
					while(current($sform))
						  {
							    $tstring = $tstring . "`" . str_replace(" ","_", key($sform))."` VARCHAR (255) ,";
							    next($sform);
						  }
		    
					$r = mysql_query("CREATE TABLE `sul_signup_profile`(
							    `uid` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,".$tstring."PRIMARY KEY (`uid`))");
		    
					if(!$r)
					{
						  die(mysql_error());
					}
					else
					{
					//
					//now generate the HTML for the signup form
					include_once("signupform.php");
						  
						  
					//
					}
					
					
					
					
					
					
					
					
			      }
			      
			
		    }
		    else
		    {
			      include_once("signupform.php");
		    }
	  	 
		    
		    
		    
		    
		    
		    
		    
	  }
	  

?>
		    	    
	    <br/><br/>
            <input type="submit" value="Create An Account" class="btn primary" />

            
            
	    </div> <!-- /clearfix -->
</fieldset>


</form>
    
    
    
        
</div>
