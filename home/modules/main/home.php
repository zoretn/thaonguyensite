<?php
	if (!defined('SITEACTIVE')) die("Hacking attempt");

	$pathtemplate = TEMPLATE_DIR.'/home.tpl';
	$template->set_filenames(array(	'body' => $pathtemplate));


	// ============================================================================================== //
	// THAY THE TRANG LOGIN ========================================================================= //
	// ============================================================================================== //

	$template->assign_vars(array(
		'theme' => TEMPLATE_DIR.'/',
		'maxwidth' => $config["maxwidth"],
		'lang' => $param["lang"]
	));

	$template->pparse('body');
	$template->destroy();
?>