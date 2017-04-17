<?php
	if (!defined('SITEACTIVE')) die("Hacking attempt");

	if ($iduser==-1) {
		Header("Location: ".MAINFILE."?m=main&f=login&redirect=".urlencode($_SERVER["REQUEST_URI"]));
		exit();
	} else if (!in_array($ADMINPRIV,array(PRIV_MOD, PRIV_ADMIN))) {
		Header('Location: '.MAINFILE.'?m=main&f=home');
		exit();
	}

	$pathtemplate = TEMPLATE_DIR.'/admin_photo.tpl';
	$template->set_filenames(array(	'body' => $pathtemplate));

	$intro = "";

	$photo=array();
	$act=get_param("act");
	$photo["idphoto"]  = get_param("id");
	$photo["idparent"] = $param["type"];
	if ($photo["idparent"]=="" || !is_numeric($photo["idparent"])) $photo["idparent"] = 0;
	$photo["title"]  = "";
	$photo["intro"]  = "";
	$photo["image"]  = "";
	$photo["lang"]   = "";
	$photo["link"]   = "";
	$photo["orders"] = 0;
	$photo["tag"]    = "";
	$photo["status"] = 0;


	// ============================================================================================== //
	// LAY TRACE LINK =============================================================================== //
	// ============================================================================================== //
	$idp = $photo["idparent"];
	$trace = ' »  <a class="trace" href="'.getLocation("&f=photo&p=&t=".$photo["idparent"]).'">'.$lang["photo"].'</a>';
	while ($idp!="0") {
		$query = "SELECT * FROM ".$db_prefix."posts WHERE idpost='".$idp."'";
		$result = sql_query($query, $dbi);
		if ($result) {
			if ($objs = sql_fetch_array($result, 1)) {
				$trace =' »  <a class="trace" href="'.getLocation("&f=post&p=&t=".$idp).'">'.$objs["title"].'</a>'.$trace;
				$idp = $objs["idparent"];
			} else {
				$idp = 0;
			}
		}
	}
	$trace = '<a class="trace" href="'.getLocation("&f=post&p=&t=0").'">'.$lang["home"].'</a>'.$trace;

	// ============================================================================================== //
	// LAY THONG TIN PHOTO ========================================================================= //
	// ============================================================================================== //
	if ($photo["idphoto"]!="" && $photo["idparent"]!="") {
		$query = "SELECT * FROM ".$db_prefix."photos"
				." WHERE idphoto='".$photo["idphoto"]."'"
				." AND idparent='".$photo["idparent"]."'"
				." AND (lang='' OR lang='".$param["lang"]."')";
		$result = sql_query($query, $dbi);
		if ($result) {
			if ($obj = sql_fetch_array($result, 1)) {
				$photo = $obj;
				$photo["imageold"] = $obj["image"];
			} else {
				$photo["idphoto"]  = "";
			}
		}
	}

	// ============================================================================================== //
	// XOA THONG TIN ================================================================================ //
	// ============================================================================================== //
	if ($act=="delete") {
		if ($photo["idphoto"]=="") {
			$intro = $lang["photo_notfound"];
		} else {
			$query = "DELETE FROM ".$db_prefix."photos"
					." WHERE idphoto='".$photo["idphoto"]."'"
					." AND idparent='".$photo["idparent"]."'"
					." AND (lang='' OR lang='".$param["lang"]."')";
			$result = sql_query($query, $dbi);
			if ($result) {

				$photo["imagepath"] = PATH_UPLOAD.'/photo/'.$photo["imageold"];
				if ($photo["imageold"]!="" && file_exists($photo["imagepath"])) unlink($photo["imagepath"]);
				$photo["thumbpath"] = PATH_UPLOAD.'/thumb/'.$photo["imageold"];
				if ($photo["imageold"]!="" && file_exists($photo["thumbpath"])) unlink($photo["thumbpath"]);

				Header("Location: ".getLocation(""));
				exit();
			} else {
				$intro = $lang["msg_cantdeletedatabase"];
			}
		}
	// ============================================================================================== //
	// CHUYEN TRANG THAI ============================================================================ //
	// ============================================================================================== //
	} else if ($act=="status") {
		if ($photo["idphoto"]=="") {
			$intro = $lang["photo_notfound"];
		} else {
			$stat   = get_param("stat");
			$status = SelectValue("status", $db_prefix."photos", " AND idphoto='".$photo["idphoto"]."' AND idparent='".$photo["idparent"]."'");
			if ($stat!="" && $stat!=$status && in_array($stat,array(STAT_ACTIVE, STAT_STOP))) {
				$query = "UPDATE ".$db_prefix."photos SET status='".$stat."'"
						." WHERE idphoto='".$photo["idphoto"]."'"
						." AND idparent='".$photo["idparent"]."'"
						." AND (lang='' OR lang='".$param["lang"]."')";
				$result = sql_query($query, $dbi);
				if ($result) {
					Header("Location: ".getLocation(""));
					exit();
				} else {
					$intro = $lang["msg_cantsavedatabase"];
				}
			}
		}

	// ============================================================================================== //
	// SAVE THONG TIN =============================================================================== //
	// ============================================================================================== //
	} else if ($act=="send") {
		$photo["title"]   = strip_tags(get_param("title"));
		$photo["intro"]   = get_param("intro");
		$photo["orders"]  = strip_tags(get_param("orders"));
		$photo["tag"]     = strip_tags(get_param("tag"));
		$photo["link"]    = strip_tags(get_param("link"));
		$imageupload	  = get_Fparam("image");
		$kiemtraImage=false;

		if ($photo["orders"]=="" || !is_numeric($photo["orders"])) $photo["orders"] = 0;

		if ($imageupload["name"]!="") {
			if (file_exists($imageupload["tmp_name"]) && filesize($imageupload["tmp_name"])>0) {
				$temp=GetImageSize($imageupload["tmp_name"]);
				if ($temp[2]=='1' || $temp[2]=='2' || $temp[2]=='3') {
					$photo["image"]     = CreateNewFilename(PATH_UPLOAD.'/photo',$imageupload["name"]);
					$photo["imagepath"] = PATH_UPLOAD.'/photo/'.$photo["image"];
					@copy($imageupload["tmp_name"],$photo["imagepath"]);
					$photo["thumbpath"] = PATH_UPLOAD.'/thumb/'.$photo["image"];
					@copy($imageupload["tmp_name"],$photo["thumbpath"]);
					if ($temp[0]>$config["thumb_width"]) {
						ResizeImage($photo["thumbpath"],$photo["thumbpath"],$config["thumb_width"]);
					}
					$kiemtraImage=true;
				} else {
					$intro=$lang["msg_cantupload"];
				}
			}
		}

		if ($photo["idphoto"]!="") {
			$urlimage="";
			if ($kiemtraImage) {
				$photo["imagepath"] =  PATH_UPLOAD.'/photo/'.$photo["imageold"];
				if ($photo["imageold"]!="" && file_exists($photo["imagepath"])) unlink($photo["imagepath"]);
				$photo["thumbpath"] =  PATH_UPLOAD.'/thumb/'.$photo["imageold"];
				if ($photo["imageold"]!="" && file_exists($photo["thumbpath"])) unlink($photo["thumbpath"]);
				$urlimage='image="'.$photo["image"].'", ';
			}
			$query = "UPDATE ".$db_prefix."photos SET "
					."title='".$photo["title"]."', "
					."intro='".$photo["intro"]."', "
					.$urlimage
					."tag='".$photo["tag"]."', "
					."link='".$photo["link"]."', "
					."orders='".$photo["orders"]."' "
					."WHERE idphoto='".$photo["idphoto"]."' "
					."AND idparent='".$photo["idparent"]."'";
			$result = sql_query($query, $dbi);
			if ($result) {
				Header("Location: ".getLocation(""));
				exit();
			} else {
				$intro = $lang["msg_cantsavedatabase"];
				echo $query;
			}
		} else {
			$photo["idphoto"]=getIDMax("idphoto", $db_prefix."photos"," AND idparent='".$photo["idparent"]."'")+1;
			$photo["status"] = STAT_ACTIVE;
			$photo["datepost"] = date("Y/m/d H:i:s");
			$photo["lang"] = $param["lang"];

			$query = "INSERT INTO ".$db_prefix."photos (idphoto, idparent, lang, title, intro, image, tag, link, datepost, orders, status) VALUES ("
				."'".$photo["idphoto"]."', "
				."'".$photo["idparent"]."', "
				."'".$photo["lang"]."', "
				."'".$photo["title"]."', "
				."'".$photo["intro"]."', "
				.'"'.$photo["image"].'", '
				."'".$photo["tag"]."', "
				."'".$photo["link"]."', "
				."'".$photo["datepost"]."', "
				."'".$photo["orders"]."', "
				."'".$photo["status"]."')";
			$result = sql_query($query, $dbi);
			if ($result) {
				Header("Location: ".getLocation(""));
				exit();
			} else {
				$intro = $lang["msg_cantsavedatabase"];
			}
		}
	// ============================================================================================== //
	// EDIT THONG TIN =============================================================================== //
	// ============================================================================================== //
	} else if ($act=="edit") {

		$imagelink = "";
		if ($photo["image"]!="" && file_exists(PATH_UPLOAD."/thumb/".$photo["image"])) {
			$imagelink = '<a href="'.PATH_UPLOAD."/thumb/".$photo["image"].'">'.$photo["image"].'</a>';
		}

		$template->assign_block_vars('form', array(
			'action' => MAINFILE."?m=".$param["module"]."&f=".$param["file"],
			'module' => $param["module"],
			'file' => $param["file"],
			'return' => getLocation(""),
			'idphoto' => $photo["idphoto"],
			'text_name' => $lang["name"],
			'text_intro' => $lang["intro"],
			'text_photo' => $lang["photo"],
			'text_order' => $lang["order"],
			'text_tag' => $lang["tag"],
			'text_link' => $lang["link"],
			'text_reset' => $lang["reset"],
			'text_submit' => $lang["save"],
			'text_return' => $lang["return"],
			'text_save' => $lang["msg_saveform"],
			'name' => htmlspecialchars($photo["title"]),
			'intro' => htmlspecialchars($photo["intro"]),
			'orders' => $photo["orders"],
			'tag' => $photo["tag"],
			'link' => $photo["link"],
			'type' => $param["type"],
			'page' => $param["page"],
			'or' => $param["order"],
			'st' => $param["status"],
			'imagelink' => $imagelink,
			'trace' => $trace
		));

	} else {

	// ============================================================================================== //
	// HIEN THI DANH SACH TYPE ====================================================================== //
	// ============================================================================================== //

		$template->assign_block_vars('navigation', array(
			'theme' => TEMPLATE_DIR.'/',
			'action' => MAINFILE."?m=".$param["module"]."&f=".$param["file"],
			'module' => $param["module"],
			'file' => $param["file"],
			'type' => $param["type"],
			'page' => $param["page"],
			'return' => getLocation("&f=post"),
			'text_refresh' => $lang["refresh"],
			'text_status' => $lang["status"],
			'text_search' => $lang["search"],
			'text_return' => $lang["return"],
			'keyword' => htmlspecialchars($param["keyword"]),
			'trace' => $trace
		));

		// =================== //
		// Hien thi Button //
		// =================== //
		$template->assign_block_vars('navigation.button', array(
			'link' => getLocation("&act=edit"),
			'text' => $lang["create"]
		));

		// =================== //
		// Hien thi Trang thai //
		// =================== //
		$arrStatus = array(STAT_NEW => $lang["status_new"], STAT_ACTIVE => $lang["status_active"], STAT_STOP => $lang["status_stop"]);
		$template->assign_block_vars('navigation.optionstatus', array(
			'value' => "",
			'text' => $lang["all"],
			'selected' => ""
		));
		while (list($key, $val) = each($arrStatus)) {
			$selected="";
			if ($param["status"]!="" && $key==$param["status"]) $selected=" selected";
			$template->assign_block_vars('navigation.optionstatus', array(
				'value' => $key,
				'text' => $val,
				'selected' => $selected
			));
		}

		$template->assign_block_vars('photolist', array(
			'text_stt' => $lang["stt"],
			'text_photo' => $lang["photo"],
			'text_name' => $lang["name"],
			'text_order' => $lang["order"]
		));

		$QueryStatus="";
		if ($param["status"]!="") $QueryStatus = " AND status='".$param["status"]."'";

		$QueryKeyword="";
		if ($param["keyword"]!="") {
			$QueryKeyword = " AND title LIKE '%".$param["keyword"]."%'";
		}

		$class = 2;
		$count= $config["adminrow"];
		$start= $param["page"]*$count;
		$query = "SELECT * FROM ".$db_prefix."photos"
				." WHERE idparent='".$photo["idparent"]."' "
				." AND (lang='' OR lang='".$param["lang"]."')"
				.$QueryStatus
				.$QueryKeyword
				." ORDER BY orders desc, datepost";
		$result = sql_query_limit($query, $dbi, $start, $count);
		if ($result) {	
			$i = 0;
			$numOfRows = $NumAllRowOfQuery;
			while ($obj = sql_fetch_array($result, 1)) {

				$thumbpath = PATH_UPLOAD."/thumb/".$obj["image"];
				if ($obj["image"]=="" || !file_exists($thumbpath)) $thumbpath = TEMPLATE_DIR.'/images/thumb.gif';
				$imagepath = PATH_UPLOAD."/photo/".$obj["image"];
				if ($obj["image"]=="" || !file_exists($imagepath)) $imagepath = TEMPLATE_DIR.'/images/photo.gif';
				$class = 3 - $class;
				$template->assign_block_vars('photolist.photo', array(
					'class' => $class,
					'stt' => ($start + $i + 1),
					'idphoto' => $obj["idphoto"],
					'name' => $obj["title"],
					'text_tag' => $lang["tag"],
					'tag' => $obj["tag"],
					'intro' => $obj["intro"],
					'link' => $obj["link"],
					'order' => $obj["orders"],
					'image' => $thumbpath,
					'width' => round($config["thumb_width"] / 2),
					'status' => $obj["status"]
				));

				$stat= ($obj["status"]==STAT_ACTIVE) ? STAT_STOP : STAT_ACTIVE;
				$link = getLocation("&t=".$photo["idparent"]."&act=status&stat=".$stat."&id=".$obj["idphoto"]);
				$template->assign_block_vars('photolist.photo.control', array(
					'icon' => "status",
					'function' => "OpenConfirm('".$link."', '".$lang["msg_changestatus"]."');",
					'text_title' => $lang["status"]
				));

				$link = getLocation("&t=".$photo["idparent"]."&act=edit&id=".$obj["idphoto"]);
				$template->assign_block_vars('photolist.photo.control', array(
					'icon' => "edit",
					'function' => "OpenLink('".$link."');",
					'text_title' => $lang["edit"]
				));
				$link = getLocation("&t=".$photo["idparent"]."&act=delete&id=".$obj["idphoto"]);
				$template->assign_block_vars('photolist.photo.control', array(
					'icon' => "delete",
					'function' => "OpenConfirm('".$link."', '".$lang["msg_delete"]."');",
					'text_title' => $lang["delete"]
				));
				$i++;
			}
			if ($i==0) $intro = $lang["photo_notfound"];

			$template->assign_block_vars('photolist.total', array(
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
	// THAY THE GIAO DIEN CHUNG ===================================================================== //
	// ============================================================================================== //

	$template->assign_vars(array(
		'theme' => TEMPLATE_DIR.'/',
		'maxwidth' => $config["maxwidth"],
		'title' => $lang["photo"]
	));

	$template->pparse('body');
	$template->destroy();
?>