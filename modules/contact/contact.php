<?php
	if (!defined('SITEACTIVE')) die("Hacking attempt");

	$pathtemplate = TEMPLATE_DIR.'/contact.tpl';
	$template->set_filenames(array(	'main' => $pathtemplate));

	$user=array();
	$act=get_param("act");

	$user["yourname"]=strip_tags(get_param("yourname"));
	$user["company"]=strip_tags(get_param("company"));
	$user["address"]=strip_tags(get_param("address"));
	$user["telephone"]=strip_tags(get_param("telephone"));
	$user["fax"]=strip_tags(get_param("fax"));
	$user["email"]=strip_tags(get_param("email"));
	$user["content"]=strip_tags(get_param("content"));

	$template->assign_block_vars('maintitle', array(
		'text_title' => $lang["contact"]
	));

	// ================================================================================================= //
	// KIEM TRA THONG TIN LIEN HE ====================================================================== //
	// ================================================================================================= //
	if ($act=="submit") {
		$act="";

		// ==================================== //
		// Kiem tra
		// ==================================== //
		$numberrandom=get_param("numberrandom");
		$imagerandom= isset($_SESSION["imagerandom"]) ? $_SESSION["imagerandom"] : rand(100000,999999);
		if ($numberrandom!=$imagerandom) {
			$template->assign_block_vars('message', array(
				'text' => $lang["error_randomcode"]
			));
		} else {
			$_SESSION["imagerandom"]="";

			$tmp=$lang["msg_emailintro"];
			$tmp=str_replace("%1",$user["yourname"],$tmp);
			$tmp=str_replace("%2",$user["email"],$tmp);
			$tmp=str_replace("%3",$user["company"],$tmp);
			$tmp=str_replace("%4",$user["address"],$tmp);
			$tmp=str_replace("%5",$user["telephone"],$tmp);
			$tmp=str_replace("%6",$user["fax"],$tmp);
			$emailintro=$tmp;
			$content=str_replace("\n","<br>",$user["content"]);
			$result=SendMailOut($user["yourname"],$user["email"],$user["email"],"Contact",$emailintro,$content);
			if ($result) {
				$act="submit";
				$template->assign_block_vars('message', array(
					'text' => $lang["msg_emailok"]
				));
			} else {
				$act="";
				$template->assign_block_vars('message', array(
					'text' => $lang["msg_cantsendemail"]
				));
			}
		}
	}

	// ============================================================================================== //
	// THAY THE TEMPLATE ============================================================================ //
	// ============================================================================================== //
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
		'company_factoryaddr' => $lang["company_factoryaddr"],
		'company_factorytel' => $lang["company_factorytel"],
		'company_factoryfax' => $lang["company_factoryfax"],
		'company_email' => $lang["company_email"],
		'company_website' => $lang["company_web"],
	));

	if ($act=="") {

		$template->assign_block_vars('message', array(
			'text' => $lang["contact_info"]
		));

		$template->assign_block_vars('form', array(
			'theme' => TEMPLATE_DIR. '/',
			'action' => MAINFILE."?m=".$param["module"]."&f=".$param["file"],
			'module' => $param["module"],
			'file' => $param["file"],

			'text_yourname' => $lang["yourname"],
			'text_company' => $lang["company"],
			'text_address' => $lang["address"],
			'text_email' => $lang["email"],
			'text_content' => $lang["content"],
			'text_imagerandom' => $lang["randomcode"],
			'text_reset' => $lang["reset"],
			'text_submit' => $lang["send"],
			'text_save' => $lang["msg_saveform"],

			'yourname' => $user["yourname"],
			'company' => $user["company"],
			'address' => $user["address"],
			'telephone' => $user["telephone"],
			'email' => $user["email"],
			'content' => $user["content"]
		));
	}

	// ============================================================================================== //
	// HIEN THI BAN DO GOOGLE MAP =================================================================== //
	// ============================================================================================== //
	$template->assign_block_vars('map', array(
		'theme' => TEMPLATE_DIR.'/',
		'key' => $config["maps_key"],
		'lat' => $config["maps_lat"],
		'long' => $config["maps_long"],
		'company' => $config["sitetitle"]
	));
	
	if ($config["maps_edit"]==1) {
		$template->assign_block_vars('map.edit', array(
		));
	} else {
		$template->assign_block_vars('map.noedit', array(
		));
	}

	// ============================================================================================== //
	// THAY THE GIAO DIEN CHUNG ===================================================================== //
	// ============================================================================================== //
	$template->assign_vars(array(
		'theme' => TEMPLATE_DIR. '/',
		'maxwidth' => $config["maxwidth"],
		'title' => $lang["contact"]
	));
	$template->pparse('main');
	$template->destroy();
?>