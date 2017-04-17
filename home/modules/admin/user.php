<?php
	if (!defined('SITEACTIVE')) die("Hacking attempt");

	if ($iduser==-1) {
		Header("Location: ".MAINFILE."?m=main&f=login&redirect=".urlencode($_SERVER["REQUEST_URI"]));
		exit();
	}

	$pathtemplate = TEMPLATE_DIR.'/admin_user.tpl';
	$template->set_filenames(array(	'body' => $pathtemplate));

	$intro = "";

	$user=array();
	$act=get_param("act");
	$user["iduser"]    = get_param("id");
	$user["username"]  = "";
	$user["fullname"]  = "";
	$user["password"]  = "";
	$user["repassword"]= "";
	$user["email"]     = "";
	$user["admin"]     = 0;

	// ============================================================================================== //
	// LAY THONG TIN USER =========================================================================== //
	// ============================================================================================== //
	if ($param["id"]!="" && ($iduser==$param["id"] || in_array($ADMINPRIV, array(PRIV_ADMIN)))) {
		$query = "SELECT * FROM ".$db_prefix."users "
				."WHERE iduser='".$param["id"]."'";
		$result = sql_query($query, $dbi);
		if ($result) {
			if ($obj = sql_fetch_array($result, 1)) {
				$user = $obj;
			} else {
				$user["iduser"] = "";
			}
		}
	} else {
		$user["iduser"] = "";
	}

	// ============================================================================================== //
	// XOA THONG TIN ================================================================================ //
	// ============================================================================================== //
	if ($act=="delete") {
		if ($user["iduser"]=="") {
			$intro = $lang["user_notfound"];
		} else if ($iduser==$user["iduser"] || !in_array($ADMINPRIV,array(PRIV_ADMIN))) {
			$intro=$lang["msg_nopriv"];
		} else {
			$query = "DELETE FROM ".$db_prefix."users WHERE iduser='".$user["iduser"]."'";
			$result = sql_query($query, $dbi);
			if ($result) {
				Header("Location: ./?m=".$param["module"]."&f=".$param["file"]."&p=".$param["page"]);
				exit();
			} else {
				$intro = $lang["msg_cantdeletedatabase"];
			}
		}

	// ============================================================================================== //
	// CHUYEN TRANG THAI ============================================================================ //
	// ============================================================================================== //
	} else if ($act=="status") {
		$stat = get_param("status");
		if ($user["iduser"]=="") {
			$intro = $lang["user_notfound"];
		} else if ($iduser==$user["iduser"] || !in_array($ADMINPRIV,array(PRIV_ADMIN))) {
			$intro=$lang["msg_nopriv"];
		} else if ($stat!="" && in_array($stat,array(STAT_ACTIVE, STAT_STOP))) {
			$query = "UPDATE ".$db_prefix."users SET status='".$stat."' WHERE iduser='".$user["iduser"]."'";
			$result = sql_query($query, $dbi);
			if ($result) {
				Header("Location: ./?m=".$param["module"]."&f=".$param["file"]."&p=".$param["page"]);
				exit();
			} else {
				$intro = $lang["msg_cantsavedatabase"];
			}
		}

	// ============================================================================================== //
	// SAVE THONG TIN =============================================================================== //
	// ============================================================================================== //
	} else if ($act=="send") {
		$user["username"]  = strip_tags(get_param("username"));
		$user["fullname"]  = strip_tags(get_param("fullname"));
		$user["password"]  = strip_tags(get_param("password"));
		$user["repassword"]= strip_tags(get_param("repassword"));
		$user["email"]     = strip_tags(get_param("email"));
		$user["admin"]     = strip_tags(get_param("admin"));
		if ($user["admin"]=="" || !is_numeric($user["admin"])) $user["admin"] = 0;

		if ($user["username"]=="") {
			$intro = $lang["msg_nousername"];
		} else if ($user["iduser"]!="" && CheckCond($db_prefix."users"," AND iduser='".$user["iduser"]."'")) {
			if ($iduser!=$user["iduser"] && !in_array($ADMINPRIV,array(PRIV_ADMIN))) {
				$intro=$lang["msg_nopriv"];
			} else if ($user["password"]!="" && $user["password"]!=$user["repassword"]) {
				$intro = $lang["msg_retypepassword"];
			} else if ($user["iduser"]==-1) {
				$intro=$lang["msg_cantchangeanon"];
			} else {
				$query = "UPDATE ".$db_prefix."users SET ";
				if ($user["password"]!="") $query.="password='".md5($user["password"])."', ";
				if ($iduser!=$user["iduser"] && in_array($ADMINPRIV,array(PRIV_ADMIN))) {
					$query.="admin='".$user["admin"]."', ";
				}
				$query.= "fullname='".$user["fullname"]."', "
						."email='".$user["email"]."' "
						."WHERE iduser='".$user["iduser"]."'";
				$result = sql_query($query, $dbi);
				if ($result) {
					Header("Location: ./?m=".$param["module"]."&f=".$param["file"]."&p=".$param["page"]);
					exit();
				} else {
					$intro = $lang["msg_cantsavedatabase"];
				}
			}
		} else {
			if (CheckCond($db_prefix."users"," AND username='".$user["username"]."'")) {
				$intro = $lang["msg_usernameexists"];
			} else if (!in_array($ADMINPRIV,array(PRIV_ADMIN))) {
				$intro=$lang["msg_nopriv"];
			} else {
				$user["iduser"]=getIDMax("iduser", $db_prefix."users",'')+1;
				$user["status"]= STAT_NEW;
				$query = "INSERT INTO ".$db_prefix."users (iduser, admin, username, password, fullname, email, status) VALUES ("
					."'".$user["iduser"]."', "
					."'".$user["admin"]."', "
					."'".$user["username"]."', "
					."'".MD5($user["password"])."', "
					."'".$user["fullname"]."', "
					."'".$user["email"]."', "
					."'".$user["status"]."')";
				$result = sql_query($query, $dbi);
				if ($result) {
					Header("Location: ./?m=".$param["module"]."&f=".$param["file"]."&p=".$param["page"]);
					exit();
				} else {
					$intro = $lang["msg_cantsavedatabase"];
				}
			}
		}
	// ============================================================================================== //
	// EDIT THONG TIN =============================================================================== //
	// ============================================================================================== //
	} else if ($act=="edit") {

		if ($user["iduser"]!="" || in_array($ADMINPRIV,array(PRIV_ADMIN))) {

			$disabled_user="";
			if ($user["iduser"]!="") $disabled_user=" readonly";

			$template->assign_block_vars('form', array(
				'action' => MAINFILE."?m=".$param["module"]."&f=".$param["file"],
				'module' => $param["module"],
				'file' => $param["file"],
				'return' => MAINFILE."?m=".$param["module"]."&f=".$param["file"]."&p=".$param["page"],
				'text_username' => $lang["username"],
				'disabled_user' => $disabled_user,
				'text_fullname' => $lang["fullname"],
				'text_email' => $lang["email"],
				'text_password' => $lang["password"],
				'text_repassword' => $lang["repassword"],
				'text_priv' => $lang["priv"],
				'text_reset' => $lang["reset"],
				'text_submit' => $lang["save"],
				'text_return' => $lang["return"],
				'text_save' => $lang["msg_saveform"],
				'fullname' => $user["fullname"],
				'username' => $user["username"],
				'email' => $user["email"],
				'page' => $param["page"],
				'iduser' => $user["iduser"]
			));

			// =================== //
			// Hien thi Phan quyen //
			// =================== //
			$arrPriv=array(PRIV_USER => $lang["priv_user"], PRIV_MOD => $lang["priv_mod"], PRIV_ADMIN => $lang["priv_admin"]);
			if ($user["iduser"]!=-1 && $user["iduser"]!=$iduser && in_array($ADMINPRIV, array(PRIV_ADMIN))) {
				while (list($key, $val) = each($arrPriv)) {
					$selected="";
					if ($key==$user["admin"]) $selected=" selected";
					$template->assign_block_vars('form.optionpriv', array(
						'value' => $key,
						'text' => $val,
						'selected' => $selected
					));
				}
			} else {
				$template->assign_block_vars('form.optionpriv', array(
					'value' => $user["admin"],
					'text' => $arrPriv[$user["admin"]],
					'selected' => ""
				));
			}
		}
	} else {

	// ============================================================================================== //
	// HIEN THI FORM ================================================================================ //
	// ============================================================================================== //
		$template->assign_block_vars('navigation', array(
			'theme' => TEMPLATE_DIR.'/',
			'action' => MAINFILE."?m=".$param["module"]."&f=".$param["file"],
			'module' => $param["module"],
			'file' => $param["file"],
			'page' => $param["page"],
			'text_status' => $lang["status"],
			'text_refresh' => $lang["refresh"],
			'text_return' => $lang["return"],
			'keyword' => htmlspecialchars($param["keyword"]),
			'return' => getLocation("")
		));

		// =================== //
		// Hien thi Button //
		// =================== //
		$template->assign_block_vars('navigation.button', array(
			'link' => MAINFILE."?m=".$param["module"]."&f=".$param["file"]."&act=edit",
			'text' => $lang["create"]
		));

		// =================== //
		// Hien thi Trang thai //
		// =================== //
		$arrStatus=array(STAT_NEW => $lang["status_new"], STAT_ACTIVE => $lang["status_active"], STAT_STOP => $lang["status_stop"]);
		$template->assign_block_vars('navigation.optionstatus', array(
			'value' => "",
			'text' => $lang["all"],
			'selected' => ""
		));
		while (list($key, $val) = each($arrStatus)) {
			$selected="";
			if ($param["status"]!="" && $key==$param["status"]) {
				$selected=" selected";
			}
			$template->assign_block_vars('navigation.optionstatus', array(
				'value' => $key,
				'text' => $val,
				'selected' => $selected
			));
		}

		$template->assign_block_vars('userlist', array(
			'text_stt' => $lang["stt"],
			'text_fullname' => $lang["fullname"],
			'text_username' => $lang["username"],
			'text_email' => $lang["email"],
			'text_priv' => $lang["priv"]
		));

		$QueryStatus="";
		if ($param["status"]!="") $QueryStatus = "AND status='".$param["status"]."' ";

		$QueryKeyword="";
		if ($param["keyword"]!="") {
			$QueryKeyword = " AND (username LIKE '%".$param["keyword"]."%'"
							." OR fullname LIKE '%".$param["keyword"]."%'"
							." OR email LIKE '%".$param["keyword"]."%')";
		}

		$arrPriv = array(PRIV_USER => $lang["priv_user"], PRIV_MOD => $lang["priv_mod"], PRIV_ADMIN => $lang["priv_admin"]);

		$class = 2;
		$count= $config["adminrow"];
		$start= $param["page"]*$count;
		$query = "SELECT * FROM ".$db_prefix."users "
				."WHERE iduser<>'-1' "
				.$QueryStatus
				.$QueryKeyword
				."ORDER BY iduser";
		$result = sql_query($query, $dbi);
		if ($result) {	
			$i = 0;
			$numOfRows = $NumAllRowOfQuery;
			while ($obj = sql_fetch_array($result, 1)) {

				$online = "offline";
				if (CheckCond($db_prefix."sessions", " AND datepost>='".date("Y-m-d H:i:s",strtotime("-5 minute"))."' AND iduser='".$obj["iduser"]."'")) $online = "online";

				$class = 3 - $class;
				$template->assign_block_vars('userlist.user', array(
					'class' => $class,
					'stt' => ($start + $i + 1),
					'iduser' => $obj["iduser"],
					'fullname' => $obj["fullname"],
					'username' => $obj["username"],
					'text_email' => $lang["email"],
					'email' => $obj["email"],
					'status' => $obj["status"],
					'online' => $online,
					'priv' => $arrPriv[$obj["admin"]]
				));

				if ($obj["iduser"]!=$iduser && in_array($ADMINPRIV, array(PRIV_ADMIN))) {
					$status = ($obj["status"]==STAT_ACTIVE) ? STAT_STOP : STAT_ACTIVE;
					$link = MAINFILE."?m=".$param["module"]."&f=".$param["file"]."&p=".$param["page"]."&act=status&status=".$status."&id=".$obj["iduser"];
					$template->assign_block_vars('userlist.user.control', array(
						'icon' => "status",
						'function' => "OpenConfirm('".$link."', '".$lang["msg_changestatus"]."');",
						'text_title' => $lang["status"]
					));
				}

				if ($obj["iduser"]==$iduser || in_array($ADMINPRIV, array(PRIV_ADMIN))) {
					$link = MAINFILE."?m=".$param["module"]."&f=".$param["file"]."&p=".$param["page"]."&act=edit&id=".$obj["iduser"];
					$template->assign_block_vars('userlist.user.control', array(
						'icon' => "edit",
						'function' => "OpenLink('".$link."');",
						'text_title' => $lang["edit"]
					));
				}

				if ($obj["iduser"]!=$iduser && in_array($ADMINPRIV, array(PRIV_ADMIN))) {
					$link = MAINFILE."?m=".$param["module"]."&f=".$param["file"]."&p=".$param["page"]."&act=delete&id=".$obj["iduser"];
					$template->assign_block_vars('userlist.user.control', array(
						'icon' => "delete",
						'function' => "OpenConfirm('".$link."', '".$lang["msg_delete"]."');",
						'text_title' => $lang["delete"]
					));
				}

				$i++;
			}
			if ($i==0) $intro = $lang["user_notfound"];

			$template->assign_block_vars('userlist.total', array(
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
		'title' => $lang["user"]
	));

	$template->pparse('body');
	$template->destroy();
?>