<?php

?>


<div id="sulform">
<link rel="stylesheet" type="text/css" href="padly/html/style/bootstrap.css" />

<form method="post" action="<?php echo APP_PATH;?>/auth.php" class="form-stacked" style="width:350px;">
    
<fieldset>
          
          <div class="clearfix">
		    
<?php

if (isset($_GET['errmsg']))
{
switch($_GET['errmsg'])
{
case 1:
?>
<div class="alert-message block-message error">
        <a href="#" class="close">×</a>
        <p><strong><?php echo "Please Enter a Valid Username and Password "?></strong></p>
      </div>

<?php
break;
case 2:
?>
<div class="alert-message block-message error">
        <a href="#" class="close">×</a>
        <p><strong><?php echo "Please Login in Other to Procede"?></strong></p>
      </div>

<?php
}
}

?>
		    
		    
		    
		    
		    
		    
		    <input type="hidden" value="login" name="login" />
		    <input type="hidden" name="sender_url" value="<?php echo $_SERVER['PHP_SELF'];?>" />
            <label for="">Username</label>
            <div class="input">
              <input type="text" size="20" name="uname" id="uname" class="large">
            </div>
            
            <label for="">Password</label>
            <div class="input">
              <input type="password" size="20" name="password" id="uname" class="large">
            </div>
            <br/>
			<input type="hidden" value="login" class="btn primary" />
            <input type="submit" value="Login" class="btn primary" />
            <a href="<?php echo APP_PATH."/../".REGISTER_SCRIPT;?>" class="btn">Or Create Account</a>
            <br/><br/>
            <p>Forgot Your Password? <a href="<?php echo SITE_DIR.'/retrievepass.php';?>">Retrieve Password</a></p>
            
            
	    </div> <!-- /clearfix -->
</fieldset>


</form>
    

    
        
</div>
