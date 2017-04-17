<?php
	if (!defined('SITEACTIVE')) die("Hacking attempt");

	if ($iduser!=-1) {
		Header("Location: ".MAINFILE."?m=main&f=home");
		exit();
	}

	$pathtemplate = TEMPLATE_DIR.'/login.tpl';
	$template->set_filenames(array(	'body' => $pathtemplate));

	$user=array();
	$act=get_param("act");
	$user["username"]=strip_tags(get_param("username"));
	$user["password"]=strip_tags(get_Pparam("password"));
	$redirect=urldecode(get_param("redirect"));

	$intro= $lang["msg_login"];

	// ================================================================================================= //
	// KIEM TRA MAT KHAU =============================================================================== //
	// ================================================================================================= //
	if ($act=='send') {
		if ($user["username"]!='') {
			$query = "SELECT * FROM ".$db_prefix."users "
					."WHERE username='".$user["username"]."' "
					."AND password='".md5($user["password"])."' "
					."AND status='".STAT_ACTIVE."' ";
			$result = sql_query_limit($query, $dbi, 0, 1);
			if ($result) {
				if ($obj = sql_fetch_object($result, 1)) {
					$user["iduser"] = $obj->iduser;
					$user["admin"] = $obj->admin;
					$user["fullname"] = $obj->fullname;

					$ip=$REMOTE_ADDR;
					session_start();
					$_SESSION[$SESSION_NAME] = $user["iduser"];
					$usersession= isset($_SESSION[$SESSION_USER]) ? $_SESSION[$SESSION_USER] : "";
					if ($usersession!="") {
						$query  = "UPDATE ".$db_prefix."sessions SET iduser='".$user["iduser"]."' WHERE idsession='".$usersession."'";
						$result = sql_query($query, $dbi);
					}
					if ($redirect=="") $redirect = MAINFILE."?m=admin&f=admin";
					Header("Location: ".$redirect);
					exit();
				} else {
					$intro=$lang["msg_loginerror"];
				}
			}
		}
	}

	// Hien thi Form
	$template->assign_block_vars('form', array(
		'theme' => TEMPLATE_DIR.'/',
		'action' => MAINFILE."?=".$param["module"]."&f=".$param["file"],
		'module' => $param["module"],
		'file' => $param["file"],
		'return' => MAINFILE."?m=main&f=home",
		'redirect' => urlencode($redirect),
		'username' => $user["username"],
		'password' => $user["password"],
		'text_username' => $lang["username"],
		'text_password' => $lang["password"],
		'text_reset' => $lang["reset"],
		'text_return' => $lang["return"],
		'text_submit' => $lang["login"],
		'intro' => $intro
	));

	// ============================================================================================== //
	// THAY THE TRANG LOGIN ========================================================================= //
	// ============================================================================================== //

	$template->assign_vars(array(
		'theme' => TEMPLATE_DIR.'/',
		'maxwidth' => $config["maxwidth"]
	));

	$template->pparse('body');
	$template->destroy();
?>