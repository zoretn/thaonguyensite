<?php
	if (!defined('SITEACTIVE')) die("Hacking attempt");

	if ($iduser==-1) {
		Header("Location: ".MAINFILE."?m=main&f=login&redirect=".urlencode($_SERVER["REQUEST_URI"]));
		exit();
	} else if (!in_array($ADMINPRIV,array(PRIV_MOD, PRIV_ADMIN))) {
		Header("Location: ".MAINFILE."?m=main&f=home");
		exit();
	}

	$pathtemplate = TEMPLATE_DIR.'/admin_config.tpl';
	$template->set_filenames(array(	'body' => $pathtemplate));

	$intro = "";

	$cfg=array();
	$cfg["config_name"]  = "";
	$cfg["config_value"] = "";
	$act=get_param("act");

	// ============================================================================================== //
	// LAY THONG TIN CONFIG ========================================================================= //
	// ============================================================================================== //
	if ($param["id"]!="") {
		$query = "SELECT * FROM ".$db_prefix."config "
				."WHERE config_name='".$param["id"]."'";
		$result = sql_query($query, $dbi);
		if ($result) {
			if ($cfg = sql_fetch_array($result, 1)) {
			} else {
				$param["id"] = "";
			}
		}
	} else {
		$param["id"] = "";
	}

	// ============================================================================================== //
	// XOA THONG TIN ================================================================================ //
	// ============================================================================================== //
	if ($act=="delete") {
		if ($param["id"]=="") {
			$intro = $lang["config_notfound"];
		} else {
			$query = "DELETE FROM ".$db_prefix."config WHERE config_name='".$param["id"]."'";
			$result = sql_query($query, $dbi);
			if ($result) {
				Header("Location: ./?m=".$param["module"]."&f=".$param["file"]);
				exit();
			} else {
				$intro = $lang["msg_cantdeletedatabase"];
			}
		}
	// ============================================================================================== //
	// SAVE THONG TIN =============================================================================== //
	// ============================================================================================== //
	} else if ($act=="send") {

		$cfg["config_name"]  = get_param("config_name");
		$cfg["config_value"] = strip_tags(get_param("config_value"),"<p><br><b><i><u><sup><sub><font><li><ul><ol><span><a><img>");

		if ($param["id"]=="") {
			if ($cfg["config_name"]=="") {
				$intro = $lang["config_notfound"];
			} else {
				$query = "INSERT INTO ".$db_prefix."config (config_name, config_value) VALUES ("
					."'".$cfg["config_name"]."', "
					."'".$cfg["config_value"]."')";
				$result = sql_query($query, $dbi);
				if ($result) {
					Header("Location: ".MAINFILE."?m=".$param["module"]."&f=".$param["file"]."&p=".$param["page"]);
					exit();
				} else {
					$intro = $lang["msg_cantsavedatabase"];
				}
			}
		} else {
			$query = "UPDATE ".$db_prefix."config SET "
					."config_value='".$cfg["config_value"]."', "
					."config_name='".$cfg["config_name"]."' "
					."WHERE config_name='".$param["id"]."'";
			$result = sql_query($query, $dbi);
			if ($result) {
				Header("Location: ".MAINFILE."?m=".$param["module"]."&f=".$param["file"]."&p=".$param["page"]);
				exit();
			} else {
				$intro = $lang["msg_cantsavedatabase"];
			}
		}

	// ============================================================================================== //
	// EDIT THONG TIN =============================================================================== //
	// ============================================================================================== //
	} else if ($act=="edit") {

		$template->assign_block_vars('form', array(
			'action' => MAINFILE."?m=".$param["module"]."&f=".$param["file"],
			'module' => $param["module"],
			'file' => $param["file"],
			'return' => MAINFILE."?m=".$param["module"]."&f=".$param["file"]."&p=".$param["page"],
			'text_name' => $lang["name"],
			'text_value' => $lang["value"],
			'text_reset' => $lang["reset"],
			'text_submit' => $lang["save"],
			'text_return' => $lang["return"],
			'text_save' => $lang["msg_saveform"],
			'id' => $param["id"],
			'config_name' => htmlspecialchars($cfg["config_name"]),
			'config_value' => htmlspecialchars($cfg["config_value"]),
			'page' => $param["page"]
		));

	// ============================================================================================== //
	// HIEN THI FORM ================================================================================ //
	// ============================================================================================== //
	} else {
		$template->assign_block_vars('navigation', array(
			'action' => MAINFILE."?m=".$param["module"]."&f=".$param["file"],
			'module' => $param["module"],
			'file' => $param["file"],
			'theme' => TEMPLATE_DIR.'/',
			'mainfile' => MAINFILE,
			'keyword' => htmlspecialchars($param["keyword"]),
			'text_refresh' => $lang["refresh"]
		));

		// =================== //
		// Hien thi Button //
		// =================== //
		$template->assign_block_vars('navigation.button', array(
			'link' => MAINFILE."?m=".$param["module"]."&f=".$param["file"]."&act=edit",
			'text' => $lang["create"]
		));

		// ============================================================================================== //
		// HIEN THI CONFIG ============================================================================== //
		// ============================================================================================== //

		$template->assign_block_vars('configlist', array(
			'text_stt' => $lang["stt"],
			'text_name' => $lang["name"],
			'text_value' => $lang["value"],
		));

		$QueryKeyword="";
		if ($param["keyword"]!="") {
			$QueryKeyword = " AND (config_name LIKE '%".$param["keyword"]."%'"
							." OR config_value LIKE '%".$param["keyword"]."%')";
		}

		$i = 0;
		$class = 2;
		$count= $config["adminrow"];
		$start= $param["page"]*$count;
		$query = "SELECT * FROM ".$db_prefix."config"
				." WHERE 1"
				.$QueryKeyword
				." ORDER BY config_name";
		$result = sql_query_limit($query, $dbi, $start, $count);
		if ($result) {	
			$numOfRows = $NumAllRowOfQuery;
			while ($obj = sql_fetch_array($result, 1)) {

				$class = 3 - $class;
				$val   = TrimStringX($obj["config_value"], 64);
				$template->assign_block_vars('configlist.config', array(
					'class' => $class,
					'stt' => ($start + $i + 1),
					'name' => $obj["config_name"],
					'value' => $val
				));

				$link = getLocation("&act=edit&id=".$obj["config_name"]);
				$template->assign_block_vars('configlist.config.control', array(
					'icon' => "edit",
					'function' => "OpenLink('".$link."');",
					'text_title' => $lang["edit"]
				));

				$link = getLocation("&act=delete&id=".$obj["config_name"]);
				$template->assign_block_vars('configlist.config.control', array(
					'icon' => "delete",
					'function' => "OpenConfirm('".$link."', '".$lang["msg_delete"]."');",
					'text_title' => $lang["delete"]
				));
				$i++;
			}
			if ($i==0) $intro = $lang["config_notfound"];

			$template->assign_block_vars('configlist.total', array(
				'total' => $numOfRows,
				'text_total' => $lang["total"]
			));

			// Hien thi Page
			ShowPageNav($param["page"], $count, $numOfRows, 2, "pagenav", getLocation("&p={page}"));
		}
	}

	// =================== //
	// Hien thi thong diep //
	// =================== //
	if ($intro!="") {
		$template->assign_block_vars('message', array(
			'text' => $intro
		));
	}

	// ============================================================================================== //
	// THAY THE TRANG LOGIN ========================================================================= //
	// ============================================================================================== //

	$template->assign_vars(array(
		'theme' => TEMPLATE_DIR.'/',
		'maxwidth' => $config["maxwidth"],
		'title' => $lang["config"]
	));

	$template->pparse('body');
	$template->destroy();
?>