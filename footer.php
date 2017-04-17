<?php
	if (!defined('SITEACTIVE')) die("Hacking attempt");

	$pathtemplate = TEMPLATE_DIR. '/footer.tpl';
	$template->set_filenames(array(	'bottom' => $pathtemplate));
	$act = get_param("act");

	// ============================================================================================== //
	// CHIA KHUNG ADMIN ============================================================================= //
	// ============================================================================================== //
	if ($param["module"]=="admin" && $param["file"]=="post" && $act=="edit") {
		$template->assign_block_vars('admin', array(
			'theme' => TEMPLATE_DIR.'/',
		));
	}

	// ============================================================================================== //
	// HIEN THI FOOTER ============================================================================== //
	// ============================================================================================== //
	$idpost = SelectValue("idpost", $db_prefix."posts", " AND tag='award' AND idparent<>'0' AND (lang='' OR lang='".$param["lang"]."')");
	$template->assign_block_vars('award', array(
		'theme' => TEMPLATE_DIR.'/',
		'idpost' => $idpost,
		'random' => date("YmdHis")
	));

	$counterGuest= getCountDB($db_prefix."sessions", " AND datepost>='".date("Y-m-d H:i:s",strtotime("-5 minute"))."'");

	$template->assign_block_vars('address', array(
		'theme' => TEMPLATE_DIR.'/',
		'text_address' => $lang["address"],
		'text_office' => $lang["office"],
		'text_factory' => $lang["factory"],
		'text_telephone' => $lang["telephone"],
		'text_fax' => $lang["fax"],
		'text_email' => $lang["email"],
		'text_website' => $lang["website"],
		'company_name' => low2Up($lang["company_name"]),
		'company_address' => $lang["company_address"],
		'company_telephone' => $lang["company_tel"],
		'company_fax' => $lang["company_fax"],
		'company_officeaddr' => $lang["company_officeaddr"],
		'company_officetel' => $lang["company_officetel"],
		'company_officefax' => $lang["company_officefax"],
		'company_officemail' => $lang["company_officemail"],
		'company_factoryaddr' => $lang["company_factoryaddr"],
		'company_factorytel' => $lang["company_factorytel"],
		'company_factoryfax' => $lang["company_factoryfax"],
		'company_email' => $lang["company_email"],
		'company_website' => $lang["company_web"],
	));

	if ($config["analytics_code"]!="") {
		$template->assign_block_vars('analytics', array(
			'analytics_code'=> $config["analytics_code"],
		));
	}

	// ============================================================================================== //
	// THAY THE GIAO DIEN CHUNG ===================================================================== //
	// ============================================================================================== //
	$footergif = ($param["module"]=="main" && $param["file"]=="home") ? "" : "a";
	$template->assign_vars(array(
		'theme' => TEMPLATE_DIR.'/',
		'maxwidth' => $config["maxwidth"],
		'copyright' => $config["copyright"],
		'text_counter' => str_replace("%1", $counterGuest, $lang["useronline"])." / ".str_replace("%1", $config["counter"], $lang["counter"])
	));

	$template->pparse('bottom');
	$template->destroy();
?>