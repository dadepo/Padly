<?php
//include the necessary javascript
include('script/validator.js');
//set the PD_APP constant in an invinsible field for JAvascript

echo "<span id='pd_base' style='display:none'>".PD_BASE."</span>";
reset($PD_SIGNUPFORM);
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
						  <select class="medium" name="<?php echo $key; ?>">
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
			      
			      <input type="hidden" value="<?php echo $this->db?>" name="sul_dbname" />
			      <input type="hidden" value="signup" name="signup" />
			      <label for=""><?php echo $key; ?><?php if($req == 1) echo '*'; ?></label>
			      <div class="input">
			      <input type="<?php echo $type;?>" size="20" name="<?php echo $key; ?>" id="<?php echo $key; ?>" class="large <?php if($req == 1) echo 'req'; ?>"><span id="msg_<?php echo str_replace(" ", "_",$key); ?>" style="margin-left:10px;display:none"><img src="<?php echo PD_BASE; ?>/html/images/loading.gif" /></span>
			      </div>
			      <?php	
			      	
			      }
			      next($PD_SIGNUPFORM);
		    }

?>
