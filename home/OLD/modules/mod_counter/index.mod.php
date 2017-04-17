<?php
defined("_ALLOW") or die ("Access denied");
?>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td style="font-family:tahoma; font-size:12px; color:#FFFFFF; padding-right:10px;" align="right">Online: 
			<?php
	include_once("class/csession.php");
	global $objsession;
	$objsession->writesession();
	echo $objsession->counter();
?>
		</td>
		<td style="font-family:tahoma; font-size:12px; color:#FFFFFF;">| Total: 
			<?php
	include("counter.php");
	echo $textcounter ;
?>
		</td>
	</tr>
</table>

