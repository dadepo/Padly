<?php
$baseurl = dirname($_SERVER["REQUEST_URI"])."/";
include_once("/padly/pd_config.php");
//include_once("baseurl.php");

?>


<div id="sulform">
<link rel="stylesheet" type="text/css" href="padly/html/style/bootstrap.css" />

<form method="post" action="<?php echo PD_BASE;?>/auth.php" class="form-stacked" style="width:350px;">
    
<fieldset>
          
          <div class="clearfix">
		    
<?php
global $PD_ERROR;
if (isset($_GET['errmsg']))
{
switch($_GET['errmsg'])
{
case 1:
?>
<div class="alert-message block-message error">
        <a href="#" class="close">×</a>
        <p><strong>Please Enter Correct Username and Passwords</strong></p>
      </div>

<?php
break;
}
}

?>
		    
		    
		    
		    
		    
		    <!--make all hidden form input have same name-->
		    <input type="hidden" value="re" name="retrieve" />
		    <input type="hidden" name="sender_url" value="<?php echo $_SERVER['PHP_SELF'];?>" />
            <label for="">Type in your email address</label>
            <div class="input">
              <input type="text" size="20" name="remail" id="email" class="large">
            </div>

			
            <input type="submit" value="Send Link To Retrieve Password" class="btn primary" />
            
            
            
	    </div> <!-- /clearfix -->
</fieldset>


</form>
    

    
        
</div>