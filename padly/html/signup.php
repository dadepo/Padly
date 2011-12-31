<?php
$baseurl = dirname($_SERVER["REQUEST_URI"])."/";
include_once("padly/padly.php");

GLOBAL $PD_SIGNUPFORM;

//your database deatils
$con = mysql_connect('localhost','root','ojigidiri');


$p = new Padly($con);



//these constructs the signup fields based on the $PD_SIGNUPFORM Variable


?>

<div id="sulform">
<link rel="stylesheet" type="text/css" href="padly/html/style/bootstrap.css" />

<form method="post" action="<?php echo PD_BASE;?>/auth.php" class="form-stacked" id="pd_signupform">
    
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
		    while(current($PD_SIGNUPFORM))
		    {
			$tstring = $tstring . "`" . str_replace(" ","_", key($PD_SIGNUPFORM))."` VARCHAR (255) ,";
			next($PD_SIGNUPFORM);
		    }
		    
		    $r = mysql_query("CREATE TABLE `sul_signup_profile`(
                                `uid` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,".$tstring."`profile` varchar(45), PRIMARY KEY (`uid`))");
		    
		    if(!$r)
		    {
			      die(mysql_error());
		    }
		    else
		    {
			      //output HTML
			      //now generate the HTML for the signup form
		    include_once("signupform.php");
		    }
		    
	  }
	  else
	  {
		    
		    //check if the number of fields specified in the config file is note same as in table
		    
		    if (mysql_num_fields($test) != (count($PD_SIGNUPFORM) + 2))
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
					while(current($PD_SIGNUPFORM))
						  {
							    $tstring = $tstring . "`" . str_replace(" ","_", key($PD_SIGNUPFORM))."` VARCHAR (255) ,";
							    next($PD_SIGNUPFORM);
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
	  	  //now generate the HTML for the signup form
	  /*
		    while ($fe = current($PD_SIGNUPFORM))
		    {
			      $req = 0;
			      $key = key($PD_SIGNUPFORM);
			      $type = $PD_SIGNUPFORM[$key]['type'];
			      if (isset($PD_SIGNUPFORM[$key]['required']))
			      {
				$req = 1;	
			      }
			      if ($type != 'text' && $type != 'password')
			      {
					switch($type)
					{
						  case 'select':
					?>	  
					<div class="clearfix">
						  <label for=""><?php echo $key; ?></label>
						  <div class="input">
						  <select class="medium">
						  <?php
						  $optionarray = split(',',$PD_SIGNUPFORM[$key]['option']);
						  foreach($optionarray as $option)
						  {
							    echo "<option>$option</option>";
						  }
						 
						  ?>
						  </select>
						</div>
					      </div>
										
					  
						  
					<?php	  
						  break;
					}
					//generate code for them multiple options
			      }
			      else
			      {
			      ?>
			      <label for=""><?php echo $key; ?><?php if($req == 1) echo '*'; ?></label>
			      <div class="input">
			      <input type="<?php echo $type;?>" size="20" name="<?php echo $key; ?>" id="<?php echo $key; ?>" class="large">
			      </div>
			      <?php	
			      	
			      }
			      next($PD_SIGNUPFORM);
		    }
	  
	  */
	  
		    
		    
		    
		    
		    
		    
		    
	  }
	  

?>
		    
            
            
            <!--<label for="">Password</label>
            <div class="input">
              <input type="password" size="20" name="uname" id="uname" class="large">
            </div>
            <br/>-->
	    
	    
	    <br/><br/>
            <input type="submit" value="Create An Account" class="btn primary" />

            
            
	    </div> <!-- /clearfix -->
</fieldset>


</form>
    
    
    
        
</div>
