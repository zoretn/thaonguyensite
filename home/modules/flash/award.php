<?php
	if (!defined('SITEACTIVE')) die("Hacking attempt");

	$pathtemplate = TEMPLATE_DIR. '/award.xml';
	$template->set_filenames(array(	'top' => $pathtemplate));

	$idpost = get_param("id");
	if ($idpost=="") {
		$idpost = SelectValue("idpost", $db_prefix."posts", " AND tag='award' AND idparent<>'0' AND (lang='' OR lang='".$param["lang"]."')");
	}
	$link = $idpost!="" ? MAINFILE."?id=".$idpost : "";

	// ============================================================================================== //
	// THAY THE GIAO DIEN CHUNG ===================================================================== //
	// ============================================================================================== //
	$template->assign_vars(array(
		'theme' => TEMPLATE_DIR.'/',
		'hostname' => urlencode("http://".$DOMAIN_NAME."/"),
		'maxwidth' => (($config["maxwidth"] - 150) / 2),
		'link' => $link,
		'lang' => $param["lang"]
	));

	Header("Content-type: text/xml");
	Header("Content-Disposition: inline; filename=award.xml");
	$template->pparse('top');
	$template->destroy();
?>