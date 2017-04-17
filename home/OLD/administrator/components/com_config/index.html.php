<?php
// no direct access
defined( '_ALLOW' ) or die( 'Access denied' );
checksupper() or die ("Access denied");
?>
<script language="javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
				submitform( pressbutton );
		}
		//-->
</script>
<?php
include("components/com_config/toolbar.html.php");

?>
<div align="center" class="centermain">
<div class="main">
		<form action="index.php" method="post" name="adminForm">
		<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
		<table cellpadding="1" cellspacing="1" border="0" width="100%">
		<tr>
			<td width="250"><table class="adminheading"><tr><th nowrap="nowrap" class="config">Global Configuration</th></tr></table></td>
			
		</tr>
		</table>
			<table class="adminform">
			<tr>
				<td width="10%">Site Name:</td>
				<td><input class="text_area" type="text" name="cfg_title_site" size="50" value="<?php echo $cfg_title_site; ?>"/></td>
			</tr>
			</table>
<table class="adminform">
			<tr>
			  <td>Y!M</td>
			  <td><input name="cfg_yahoo" type="text" class="text_area" id="cfg_yahoo" value="<?php echo $cfg_yahoo; ?>" size="50"/></td>
	    </tr>
			<tr>
				<td width="10%">Mail From:</td>
			  <td width="380"><input class="text_area" type="text" name="cfg_mail" size="50" value="<?php echo $cfg_mail; ?>"/></td>
			</tr>
			<tr>
				<td>From Name:</td>
				<td><input class="text_area" type="text" name="cfg_mailname" size="50" value="<?php echo $cfg_mailname; ?>"/></td>
			</tr>
			<tr>
			  <td valign="top">Intro Contact: </td>
			  <td><textarea name="cfg_introcontact" style="width: 100%" ><?php echo str_replace("\\\"","\"",$cfg_introcontact); ?></textarea></td>
    </tr>
		<tr>
			  <td valign="top">Intro Contact (English): </td>
			  <td><textarea name="cfg_introcontact_en" style="width: 100%" ><?php echo str_replace("\\\"","\"",$cfg_introcontact_en); ?></textarea></td>
    </tr>
	<tr>
			  <td valign="top">Intro Contact (English): </td>
			  <td><textarea name="cfg_introcontact_cn" style="width: 100%" ><?php echo str_replace("\\\"","\"",$cfg_introcontact_cn); ?></textarea></td>
    </tr>
			<tr>
			  <td>Auto Response: </td>
			  <td><input name="cfg_autoresponse" type="checkbox" id="cfg_autoresponse" value="checkbox" <?php if ($cfg_autoresponse == 1) echo "checked"; ?> ></td>
    </tr>
			<tr>
			  <td valign="top">Text Response: </td>
			  <td><textarea name="cfg_textresponse" style="width: 100%" ><?php echo str_replace("\\\"","\"",$cfg_textresponse); ?></textarea></td>
    </tr>
		<tr>
			  <td valign="top">Text Response (English): </td>
			  <td><textarea name="cfg_textresponse_en" style="width: 100%" ><?php echo str_replace("\\\"","\"",$cfg_textresponse_en); ?></textarea></td>
    </tr>
	<tr>
			  <td valign="top">Text Response (English): </td>
			  <td><textarea name="cfg_textresponse_cn" style="width: 100%" ><?php echo str_replace("\\\"","\"",$cfg_textresponse_cn); ?></textarea></td>
    </tr>
		  </table>
<input name="module" type="hidden" id="module" value="<?php echo $module ?>"/>
	  	<input type="hidden" name="task" value=""/>
		</form>
</div></div>
<?php
include("components/com_config/toolbar.html.php");
?>