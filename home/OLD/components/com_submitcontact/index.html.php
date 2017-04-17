<?php
defined("_ALLOW") or die ("Access denied");

		global $cfg_autoresponse;
		global $cfg_textresponse;
		global $cfg_textresponse_en;
		global $cfg_mailname;
		global $lang;
		$textresponse = $cfg_textresponse;
		if ($lang=="en") $textresponse = $cfg_textresponse_en;
?>
<span style="font-family:Tahoma; font-size:12px; font-weight:bold; color:#FF0000; text-align:center;">
<?php
		echo $textresponse;

?>
</span>