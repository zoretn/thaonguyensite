<?php
class mosConfig {
	var $cfg_title_site = "Source Code";

	var $cfg_yahoo = "";
	var $cfg_mail = "";
	var $cfg_mailname = "";
	var $cfg_introcontact = "";
	var $cfg_introcontact_en = "";
	var $cfg_introcontact_cn = "";
	var $cfg_autoresponse = 0;
	var $cfg_textresponse = "";
	var $cfg_textresponse_en = "";
	var $cfg_textresponse_cn = "";
	
	function saveconfig () {
		$this->cfg_title_site = $_REQUEST['cfg_title_site'];
		$this->cfg_yahoo = $_REQUEST['cfg_yahoo'];
		$this->cfg_mail = $_REQUEST['cfg_mail'];
		$this->cfg_mailname = $_REQUEST['cfg_mailname'];
		$this->cfg_introcontact = $_REQUEST['cfg_introcontact'];
		$this->cfg_introcontact_en = $_REQUEST['cfg_introcontact_en'];
		$this->cfg_introcontact_cn = $_REQUEST['cfg_introcontact_cn'];
		if (isset($_REQUEST['cfg_autoresponse']))
		$this->cfg_autoresponse = 1;
		$this->cfg_textresponse = $_REQUEST['cfg_textresponse'];
		$this->cfg_textresponse_en = $_REQUEST['cfg_textresponse_en'];
		$this->cfg_textresponse_cn = $_REQUEST['cfg_textresponse_cn'];
		
		$config = "<?php \n";
		$config .= "defined(\"_ALLOW\") or die (\"Access denied\"); \n";
		$config .= "\$cfg_title_site = '$this->cfg_title_site'; \n";
		$config .= "\$cfg_yahoo = '$this->cfg_yahoo'; \n";
		$config .= "\$cfg_mail = '$this->cfg_mail'; \n";
		$config .= "\$cfg_mailname = '$this->cfg_mailname'; \n";
		$config .= "\$cfg_introcontact = '$this->cfg_introcontact'; \n";
		$config .= "\$cfg_introcontact_en = '$this->cfg_introcontact_en'; \n";
		$config .= "\$cfg_introcontact_cn = '$this->cfg_introcontact_cn'; \n";
		$config .= "\$cfg_autoresponse = $this->cfg_autoresponse; \n";
		$config .= "\$cfg_textresponse = \"$this->cfg_textresponse\"; \n";
		$config .= "\$cfg_textresponse_en = \"$this->cfg_textresponse_en\"; \n";
		$config .= "\$cfg_textresponse_cn = \"$this->cfg_textresponse_cn\"; \n";
		$config .= "?>";
	
		$BASE_DIR = $_SERVER['DOCUMENT_ROOT'] ;
		$fname = $BASE_DIR;
		global $cfg_rootpath;
		if ($cfg_rootpath != "") $fname .= "/".$cfg_rootpath;
		$fname .= '/config.php';
	
		if ( $fp = fopen($fname, 'w') ) {
			fputs($fp, $config, strlen($config));
			fclose($fp);
		}
	}
};
?>