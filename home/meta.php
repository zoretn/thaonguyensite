<?php
	if (!defined('SITEACTIVE')) die("Hacking attempt");

	$pathtemplate = TEMPLATE_DIR.'/meta.tpl';
	$template->set_filenames(array(	'meta' => $pathtemplate));

	// ============================================================================================== //
	// THAY THE GIAO DIEN CHUNG ===================================================================== //
	// ============================================================================================== //
	$template->assign_vars(array(
		'theme' => TEMPLATE_DIR.'/',
		'sitetitle' => $config["sitetitle"],
		'hostname' => "http://".$DOMAIN_NAME.'/',
		'siteintro' => $config["siteintro"],
		'maxwidth' => $config["maxwidth"],
		'username' => $FULLNAME
	));

	$template->pparse('meta');
	$template->destroy();
?>