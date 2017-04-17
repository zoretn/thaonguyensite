<?php
	if (!defined('SITEACTIVE')) die("Hacking attempt");

	$pathtemplate = TEMPLATE_DIR. '/header.tpl';
	$template->set_filenames(array(	'top' => $pathtemplate));

	$textsearch = $param["keyword"];
	if ($textsearch=="") $textsearch = $lang["search"];

	// ============================================================================================== //
	// HIEN THI LANGUAGE ============================================================================ //
	// ============================================================================================== //
	if ($config["showlang"]==1) {
		$arrLang = array("vn" => $lang["vietnamese"], "en" => $lang["english"], "cn" => $lang["chinese"], "jp" => $lang["japanese"]);
		while (list($key, $val) = each($arrLang)) {
			if ($key!=$param["lang"]) {
				$template->assign_block_vars('language', array(
					'link' => ($param["module"]=="post") ? GetLocation("&m=main&f=home&lang=".$key) : GetLocation("&lang=".$key),
					'text' => $val,
					'lang' => $key
				));
			}
		}
	}

	// ============================================================================================== //
	// HIEN THI MENU ================================================================================ //
	// ============================================================================================== //
	if ($param["module"]!="admin") {
		
		$query = "SELECT * FROM ".$db_prefix."posts"
				." WHERE idparent='0'"
				." AND status='".STAT_ACTIVE."'"
				." AND (lang='' OR lang='".$param["lang"]."')"
				." ORDER BY orders desc, datepost desc";
		$result = sql_query($query, $dbi);
		if ($result) {
			while ($obj = sql_fetch_array($result, 1)) {
				$link = ($obj["link"]!="") ? $obj["link"] : MAINFILE."?id=".$obj["idpost"];
				$template->assign_block_vars('menu', array(
					'theme' => TEMPLATE_DIR.'/',
					'text' => $obj["title"],
					'over' => ($obj["idpost"]==$param["idroot"]) ? "over" : "",
					'link' => $link
				));
			}
		}

	// ============================================================================================== //
	// THANH MENU ADMIN ============================================================================= //
	// ============================================================================================== //
	} else {
		if (in_array($ADMINPRIV, array(PRIV_MOD, PRIV_ADMIN))) {
			$template->assign_block_vars('menu', array(
				'theme' => TEMPLATE_DIR.'/',
				'text' => $lang["banner"],
				'over' => ($param["file"]=="photo") ? "over" : "",
				'link' => MAINFILE."?m=admin&f=photo"
			));
			$template->assign_block_vars('menu', array(
				'theme' => TEMPLATE_DIR.'/',
				'text' => $lang["post"],
				'over' => ($param["file"]=="post") ? "over" : "",
				'link' => MAINFILE."?m=admin&f=post"
			));
		}
		if (in_array($ADMINPRIV, array(PRIV_ADMIN))) {
			$template->assign_block_vars('menu', array(
				'theme' => TEMPLATE_DIR.'/',
				'text' => $lang["lang"],
				'over' => ($param["file"]=="lang") ? "over" : "",
				'link' => MAINFILE."?m=admin&f=lang"
			));
			$template->assign_block_vars('menu', array(
				'theme' => TEMPLATE_DIR.'/',
				'text' => $lang["config"],
				'over' => ($param["file"]=="config") ? "over" : "",
				'link' => MAINFILE."?m=admin&f=config"
			));
		}

		$template->assign_block_vars('menu', array(
			'theme' => TEMPLATE_DIR.'/',
			'text' => $lang["user"],
			'over' => ($param["file"]=="user") ? "over" : "",
			'link' => MAINFILE."?m=admin&f=user"
		));
	}

	// ============================================================================================== //
	// HIEN THI SLOGAN ============================================================================== //
	// ============================================================================================== //
	$template->assign_block_vars('slogan', array(
		'theme' => TEMPLATE_DIR.'/',
		'slogan' => urlencode($lang["slogan"])
	));

	// ============================================================================================== //
	// HIEN THITRANG HOME =========================================================================== //
	// ============================================================================================== //
	if ($param["module"]=="main" && $param["file"]=="home") {
		$template->assign_block_vars('home', array(
			'theme' => TEMPLATE_DIR.'/'
		));
	} else {
		$template->assign_block_vars('nohome', array(
			'theme' => TEMPLATE_DIR.'/'
		));
	}


	$template->assign_vars(array(
		'theme' => TEMPLATE_DIR.'/',
		'maxwidth' => $config["maxwidth"],
		'homepage' => MAINFILE,
		'username' => $FULLNAME,
		'lang' => $param["lang"]
	));

	$template->pparse('top');
	$template->destroy();
?>