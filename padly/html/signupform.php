
<?php
//include the necessary javascript
include('script/validator.js');
//set the PD_APP constant in an invinsible field for JAvascript



echo "<span id='pd_base' style='display:none'>".SITE_DIR."</span>";
reset($sform);
		    while ($fe = current($sform))
		    {
			      $req = 0;
			      $key = key($sform);
			      $type = $sform[$key]['type'];
			      if (isset($sform[$key]['required']))
			      {
				$req = 1;	
			      }
			      if ($type != 'text' && $type != 'password')
			      {
					switch($type)
					{
						case 'select':
						$this->displaySelect($sform,$key);
						break;
						case 'radio':
						 $this->displayRadio($sform,$key,$type,$req);
						  break;
						  case 'checkbox':
						  $this->displayCheckbox($sform,$key,$type,$req);
						  break;
					          case "textarea":
						  $this->displayTextarea($sform,$key,$type,$req);

					}
					//generate code for them multiple options
			      }
			      else
			      {
			      ?>
			      
			      <input type="hidden" value="<?php echo $this->databasename?>" name="sul_dbname" />
			      <input type="hidden" value="signup" name="signup" />
			      <label for=""><?php echo $key; ?><?php if($req == 1) echo '*'; ?></label>
			      <div class="input">
			      <input type="<?php echo $type;?>" size="20" name="<?php echo $key; ?>" id="<?php echo $key; ?>" class="large <?php if($req == 1) echo 'req'; ?>"><span id="msg_<?php echo str_replace(" ", "_",$key); ?>" style="margin-left:10px;display:none"><img src="./padly/html/images/loading.gif" /></span>
			      
			      </div>
			      <?php	
			      	
			      }
			      next($sform);
		    }

?>
