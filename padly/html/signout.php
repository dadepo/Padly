<?php
$baseurl = dirname($_SERVER["REQUEST_URI"])."/";
include_once("padly/pd_config.php");

//these constructs the signup fields based on the $PD_SIGNUPFORM Variable


?>

<div id="sulform">
<link rel="stylesheet" type="text/css" href="padly/html/style/bootstrap.css" />

<form method="post" action="<?php echo APP_PATH;?>/auth.php" class="form-stacked" id="pd_signupform">
    
<fieldset>
	  <input type="hidden" value="logout" name="logout" />
    <br/><input type="submit" value="Logout" class="btn primary" /><br/> 
</fieldset>


</form>
    
    
    
        
</div>
