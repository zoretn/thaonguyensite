<?php
	if (!defined('SITEACTIVE')) die("Hacking attempt");

	$pathtemplate = TEMPLATE_DIR. '/home.xml';
	$template->set_filenames(array(	'top' => $pathtemplate));
	
	$homelang = get_param("lang");
	if ($homelang=="") $homelang = $param["lang"];

	// ============================================================================================== //
	// LAY DANH SACH HINH ANH ======================================================================= //
	// ============================================================================================== //
	$query = "SELECT * FROM ".$db_prefix."photos"
			." WHERE status='".STAT_ACTIVE."'"
			." AND idparent='0'"
			." AND (lang='' OR lang='".$homelang."')"
			." ORDER BY orders desc, datepost";
	$result = sql_query($query, $dbi);
	if ($result) {
		$i=0;
		while ($obj = sql_fetch_array($result, 1)) {
			$obj["imagepath"] = PATH_UPLOAD."/photo/".$obj["image"];
			if ($obj["image"]!="" && file_exists($obj["imagepath"])) {
				$template->assign_block_vars('row', array(
					'url' => "http://".$DOMAIN_NAME."/".urlencode($obj["imagepath"]),
					'path' => urlencode($obj["imagepath"]),
					'title' => htmlspecialchars($obj["title"]),
					'link' => urlencode($obj["link"])
				));
			}
		}
	}

	// ============================================================================================== //
	// THAY THE GIAO DIEN CHUNG ===================================================================== //
	// ============================================================================================== //
	$template->assign_vars(array(
		'theme' => TEMPLATE_DIR.'/',
		'hostname' => urlencode("http://".$DOMAIN_NAME."/"),
		'maxwidth' => (($config["maxwidth"] - 150) / 2)
	));

	Header("Content-type: text/xml");
	Header("Content-Disposition: inline; filename=rss.xml");
	$template->pparse('top');
	$template->destroy();
?>