<?php
	if (!defined('SITEACTIVE')) die("Hacking attempt");

	if ($iduser==-1) {
		Header("Location: ".MAINFILE."?m=main&f=login&redirect=".urlencode($_SERVER["REQUEST_URI"]));
		exit();
	} else if (!in_array($ADMINPRIV,array(PRIV_MOD, PRIV_ADMIN))) {
		Header('Location: '.MAINFILE.'?m=main&f=home');
		exit();
	}

	$pathtemplate = TEMPLATE_DIR.'/admin_post.tpl';
	$template->set_filenames(array(	'body' => $pathtemplate));

	$intro = "";

	if ($param["type"]=="" || !is_numeric($param["type"])) $param["type"] = 0;

	$post=array();
	$post["idpost"] = $param["id"];
	$post["title"]  = "";
	$post["intro"]  = "";
	$post["content"]  = "";
	$post["link"] = "";
	$post["tag"] = "";
	$post["datepost"] = date("Y-m-d H:i:s");
	$post["idparent"] = $param["type"];
	if ($post["idparent"]=="" || !is_numeric($post["idparent"])) $post["idparent"] = 0;
	$post["orders"] = 0;
	$post["image"] = "";
	$post["imageold"] = "";
	$post["w"] = 0;
	$post["h"] = 0;
	$post["day"]   = date("d");
	$post["month"] = date("m");
	$post["year"]  = date("Y");
	$post["hour"]   = date("H");
	$post["minute"] = date("i");
	$post["second"] = date("s");
	$act=get_param("act");

	$idparent = SelectValue("idparent", $db_prefix."posts", " AND idpost='".$post["idparent"]."'");

	// ============================================================================================== //
	// LAY THONG TIN POST =========================================================================== //
	// ============================================================================================== //
	if ($param["id"]!="") {
		$query = "SELECT * FROM ".$db_prefix."posts "
				."WHERE idpost='".$param["id"]."' "
				."AND (lang='' OR lang='".$param["lang"]."')";
		$result = sql_query($query, $dbi);
		if ($result) {
			if ($obj = sql_fetch_array($result, 1)) {
				$post = $obj;
				$post["imageold"] = $obj["image"];
				if ($post["datepost"]!="") {
					$tmp = explode(" ",$post["datepost"]);
					$day = explode("-", $tmp[0]);
					$post["year"] = $day[0];
					$post["month"] = $day[1];
					$post["day"] = $day[2];
					$time = explode(":", $tmp[1]);
					$post["hour"] = $time[0];
					$post["minute"] = $time[1];
					$post["second"] = $time[2];
				}
			} else {
				$post["idpost"] = "";
			}
		}
	}

	// ============================================================================================== //
	// LAY TRACE LINK =============================================================================== //
	// ============================================================================================== //
	$idp = $post["idparent"];
	$trace = "";
	while ($idp!="0") {
		$query = "SELECT * FROM ".$db_prefix."posts WHERE idpost='".$idp."'";
		$result = sql_query($query, $dbi);
		if ($result) {
			if ($objs = sql_fetch_array($result, 1)) {
				$trace =' » <a class="trace" href="'.getLocation("&p=&t=".$idp).'">'.$objs["title"].'</a>'.$trace;
				$idp = $objs["idparent"];
			} else {
				$idp = 0;
			}
		}
	}
	$trace = '<a class="trace" href="'.getLocation("&p=&t=0").'">'.$lang["home"].'</a>'.$trace;

	// ============================================================================================== //
	// XOA THONG TIN ================================================================================ //
	// ============================================================================================== //
	if ($act=="delete") {
		if ($post["idpost"]=="") {
			$intro = $lang["post_notfound"];
		} else if (!in_array($ADMINPRIV,array(PRIV_MOD, PRIV_ADMIN))) {
			$intro = $lang["msg_nopriv"];
		} else {
			$numpost   = getCountDB($db_prefix."posts"," AND idparent='".$post["idpost"]."'");
			$numimage  = getCountDB($db_prefix."photos"," AND idparent='".$post["idpost"]."'");
			$numattach = getCountDB($db_prefix."attachment"," AND idparent='".$post["idpost"]."'");
			if ($numpost>0 || $numimage>0 || $numattach>0) {
				$intro=$lang["msg_cantdelete"];
			} else {
				$post["imagepath"] = PATH_UPLOAD."/".$post["imageold"];
				if ($post["imageold"]!="" && file_exists($post["imagepath"])) unlink($post["imagepath"]);
				$query = "DELETE FROM ".$db_prefix."posts WHERE idpost='".$post["idpost"]."'";
				$result = sql_query($query, $dbi);
				if ($result) {
					Header("Location: ".getLocation(""));
					exit();
				} else {
					$intro = $lang["msg_cantdeletedatabase"];
				}
			}
		}
	// ============================================================================================== //
	// THAY DOI TRANG THAI ========================================================================== //
	// ============================================================================================== //
	} else if ($act=="status") {
		if ($post["idpost"]=="") {
			$intro = $lang["post_notfound"];
		} else if (!in_array($ADMINPRIV,array(PRIV_MOD, PRIV_ADMIN))) {
			$intro = $lang["msg_nopriv"];
		} else {
			$stat   = get_param("stat");
			$status = SelectValue("status", $db_prefix."posts", " AND idpost='".$post["idpost"]."'");
			if ($stat!="" && $stat!=$status && in_array($stat,array(STAT_ACTIVE, STAT_STOP))) {
				$query = "UPDATE ".$db_prefix."posts SET status='".$stat."' WHERE idpost='".$post["idpost"]."'";
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
		$post["title"]	= strip_tags(get_param("title"));
		$post["intro"]	= (get_param("intro"));
		$post["content"]= (get_param("content"));
		$post["tag"]	= strip_tags(get_param("tag"));
		$post["orders"]	= strip_tags(get_param("orders"));
		$post["day"]    = strip_tags(get_param("day"));
		$post["month"]  = strip_tags(get_param("month"));
		$post["year"]   = strip_tags(get_param("year"));
		$post["hour"]   = strip_tags(get_param("hour"));
		$post["minute"] = strip_tags(get_param("minute"));
		$post["second"] = strip_tags(get_param("second"));
		$post["datepost"] = $post["year"]."-".$post["month"]."-".$post["day"]." ".$post["hour"].":".$post["minute"].":".$post["second"];
		$post["idparent"] = $param["type"];
		$post["link"] = strip_tags(get_param("link"));
		if ($post["idparent"]=="" || !is_numeric($post["idparent"])) $post["idparent"] = 0;
		if ($post["orders"]=="" || !is_numeric($post["orders"])) $post["orders"] = 0;
		if ($post["datepost"]=="") $post["datepost"] = date("Y-m-d H:i:s");
		$imageupload= get_Fparam("image");
		$chkimage = get_param("chkimage");
		$kiemtraImage=false;
		$post["image"] = "";

		if ($imageupload["name"]!="") {
			if (file_exists($imageupload["tmp_name"]) && filesize($imageupload["tmp_name"])>0) {
				$temp=GetImageSize($imageupload["tmp_name"]);
				if ($temp[2]=='1' || $temp[2]=='2' || $temp[2]=='3') {
					$post["image"]= CreateNewFilename(PATH_UPLOAD,$imageupload["name"]);
					$post["imagepath"] = PATH_UPLOAD.'/'.$post["image"];
					copy($imageupload["tmp_name"],$post["imagepath"]);
					if ($temp[0]>$config["post_width"]) {
						ResizeImage($post["imagepath"],$post["imagepath"],$config["post_width"]);
					}
					$kiemtraImage=true;
				} else {
					$intro=$lang["msg_cantupload"];
				}
			}
		}

		if ($post["idpost"]!="") {
			$urlimage="";
			if ($chkimage || $kiemtraImage) {
				$post["imagepath"] =  PATH_UPLOAD.'/'.$post["imageold"];
				if ($post["imageold"]!="" && file_exists($post["imagepath"])) unlink($post["imagepath"]);
				if (!$kiemtraImage) $post["image"]="";
				$urlimage='image="'.$post["image"].'", ';
			}

			$query = "UPDATE ".$db_prefix."posts SET "
					."idparent='".$param["type"]."', "
					."tag='".$post["tag"]."', "
					."title='".$post["title"]."', "
					."intro='".$post["intro"]."', "
					."content='".$post["content"]."', "
					."datepost='".$post["datepost"]."', "
					."link='".$post["link"]."', "
					.$urlimage
					."orders='".$post["orders"]."' "
					."WHERE idpost='".$post["idpost"]."'";
			$result = sql_query($query, $dbi);
			if ($result) {
				Header("Location: ".getLocation(""));
				exit();
			} else {
				$intro = $lang["msg_cantsavedatabase"];
				echo $query;
			}
		} else {
			$post["idpost"] = getIDMax("idpost", $db_prefix."posts",'')+1;
			$post["lang"]   = $param["lang"];
			$post["status"] = STAT_NEW;

			$query = "INSERT INTO ".$db_prefix."posts (idpost, idparent, title, intro, content, tag, link, image, status, datepost, orders, lang) VALUES ("
				."'".$post["idpost"]."', "
				."'".$post["idparent"]."', "
				."'".$post["title"]."', "
				."'".$post["intro"]."', "
				."'".$post["content"]."', "
				."'".$post["tag"]."', "
				."'".$post["link"]."', "
				.'"'.$post["image"].'", '
				."'".$post["status"]."', "
				."'".$post["datepost"]."', "
				."'".$post["orders"]."', "
				."'".$post["lang"]."')";
			$result = sql_query($query, $dbi);
			if ($result) {
				Header("Location: ".getLocation(""));
				exit();
			} else {
				$intro = $lang["msg_cantsavedatabase"];
				echo $query;
			}
		}
	// ============================================================================================== //
	// EDIT THONG TIN =============================================================================== //
	// ============================================================================================== //
	} else if ($act=="edit") {

		$oFCKeditor = new FCKeditor('intro');
		$oFCKeditor->BasePath = $COOKIE_NAME.'/FCKeditor/';
		$oFCKeditor->Config['AutoDetectLanguage'] = true;
		$oFCKeditor->Config['DefaultLanguage'] = "vi";
		$oFCKeditor->Config['SkinPath'] = $oFCKeditor->BasePath . 'editor/skins/' . 'silver' . '/';
		$oFCKeditor->Height = '200';
		$oFCKeditor->Value = $post["intro"];
		$output_intro = $oFCKeditor->CreateHtml() ;

		$oFCKeditor = new FCKeditor('content');
		$oFCKeditor->BasePath = $COOKIE_NAME.'/FCKeditor/';
		$oFCKeditor->Config['AutoDetectLanguage'] = true;
		$oFCKeditor->Config['DefaultLanguage'] = "vi";
		$oFCKeditor->Config['SkinPath'] = $oFCKeditor->BasePath . 'editor/skins/' . 'silver' . '/';
		$oFCKeditor->Height = '500';
		$oFCKeditor->Value = $post["content"];
		$output_content = $oFCKeditor->CreateHtml() ;

		$template->assign_block_vars('form', array(
			'action' => MAINFILE."?m=".$param["module"]."&f=".$param["file"],
			'module' => $param["module"],
			'file' => $param["file"],
			'return' => getLocation(""),
			'idparent' => $post["idparent"],
			'idpost' => $post["idpost"],
			'page' => $param["page"],
			'type' => $param["type"],

			'text_title' => $lang["title"],
			'title' => htmlspecialchars($post["title"]),

			'text_order' => $lang["order"],
			'orders' => $post["orders"],
			'text_date' => $lang["date"],
			'datepost' => $post["datepost"],
			'text_link' => $lang["link"],
			'link' => $post["link"],
			'text_type' => $lang["type"],
			'text_image' => $lang["photo"],

			'text_module' => $lang["module"],
			'txtmodule' => $post["tag"],

			'text_return' => $lang["return"],
			'text_reset' => $lang["reset"],
			'text_submit' => $lang["save"],
			'text_save' => $lang["msg_saveform"],
			'trace' => $trace
		));

		if ($post["image"]!="" && file_exists(PATH_UPLOAD.'/'.$post["image"])) {
			$template->assign_block_vars('form.image', array(
				'link' => PATH_UPLOAD.'/'.$post["image"],
				'filename' => $post["image"],
				'text' => $lang["msg_deletephoto"]
			));
		}

//		$step = getParentStep($post["idparent"]);

//		if ($step>0) {
			$template->assign_block_vars('form.post', array(
				'text_intro' => $lang["intro"],
				'intro' => $output_intro,
				'text_content' => $lang["content"],
				'content' => $output_content
			));
//		}

		// =================== //
		// Hien thi Type //
		// =================== //
		$template->assign_block_vars('form.optiontype', array(
			'value' => "0",
			'text' => $lang["home"],
			'selected' => ""
		));		
		$query = "SELECT * FROM ".$db_prefix."posts "
				."WHERE lang='".$param["lang"]."' "
				."AND idparent='0' "
				."ORDER BY orders desc";
		$result = sql_query($query, $dbi);
		if ($result) {	
			while ($obj = sql_fetch_array($result, 1)) {
				$selected= $obj["idpost"]==$post["idparent"] ? " selected" : "";
				$template->assign_block_vars('form.optiontype', array(
					'value' => $obj["idpost"],
					'text' => "-- ".$obj["title"],
					'selected' => $selected
				));		
			}
		}

		// =================== //
		// Hien thi Module     //
		// =================== //
		$arrModule = explode(",", $config["modulelist"]);
		$template->assign_block_vars('form.optionmodule', array(
			'value' => "",
			'text' => $lang["all"],
			'selected' => ""
		));
		for ($i=0; $i<count($arrModule); $i++) {
			$selected= ($post["tag"]!="" && $arrModule[$i]==$post["tag"]) ? " selected" : "";
			$template->assign_block_vars('form.optionmodule', array(
				'value' => $arrModule[$i],
				'text' => $arrModule[$i],
				'selected' => $selected
			));
		}

		// ==================================== //
		// Day
		// ==================================== //
		for ($i=1;$i<=31;$i++) {
			$selected = ($post["day"]==$i) ? " selected" : "";
			$template->assign_block_vars('form.dayoption', array(
				'value' => $i,
				'selected' => $selected,
				'text' => $i
			));
		}

		// ==================================== //
		// Month
		// ==================================== //
		for ($i=1;$i<=12;$i++) {
			$selected= ($post["month"]==$i) ? " selected" : "";
			$template->assign_block_vars('form.monthoption', array(
				'value' => $i,
				'selected' => $selected,
				'text' => $i
			));
		}

		// ==================================== //
		// Year
		// ==================================== //
		for ($i=(date("Y")-1);$i<=(date("Y")+1);$i++) {
			$selected= ($post["year"]==$i) ? " selected" : "";
			$template->assign_block_vars('form.yearoption', array(
				'value' => $i,
				'selected' => $selected,
				'text' => $i
			));
		}
		// ==================================== //
		// Hour
		// ==================================== //
		for ($i=0;$i<=23;$i++) {
			$selected= ($post["hour"]==$i) ? " selected" : "";
			$template->assign_block_vars('form.houroption', array(
				'value' => $i,
				'selected' => $selected,
				'text' => $i
			));
		}

		// ==================================== //
		// Minute
		// ==================================== //
		for ($i=0;$i<=59;$i++) {
			$selected= ($post["minute"]==$i) ? " selected" : "";
			$template->assign_block_vars('form.minuteoption', array(
				'value' => $i,
				'selected' => $selected,
				'text' => $i
			));
		}

		// ==================================== //
		// Second
		// ==================================== //
		for ($i=0;$i<=59;$i++) {
			$selected= ($post["second"]==$i) ? " selected" : "";
			$template->assign_block_vars('form.secondoption', array(
				'value' => $i,
				'selected' => $selected,
				'text' => $i
			));
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
			'type' => $param["type"],
			'page' => $param["page"],
			'text_type' => $lang["type"],
			'text_status' => $lang["status"],
			'text_order' => $lang["order"],
			'text_refresh' => $lang["refresh"],
			'text_return' => $lang["return"],
			'return' => getLocation("&t=".$idparent),
			'keyword' => htmlspecialchars($param["keyword"]),
			'trace' => $trace
		));

		// =================== //
		// Hien thi Button //
		// =================== //
		$template->assign_block_vars('navigation.button', array(
			'link' => getLocation("&act=edit&t=".$param["type"]),
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

		// ============================================================================================== //
		// HIEN THI TASKS =============================================================================== //
		// ============================================================================================== //

		$template->assign_block_vars('postlist', array(
			'text_stt' => $lang["stt"],
			'text_post' => $lang["post"],
			'text_type' => $lang["type"],
			'text_hit' => $lang["hit"],
			'text_numpost' => $lang["numpost"],
			'text_numimage' => $lang["numimage"],
			'text_numattach' => $lang["attach"],
			'text_status' => $lang["status"],
			'text_order' => $lang["order"]
		));

		$QueryStatus="";
		if ($param["status"]!="") $QueryStatus = " AND status='".$param["status"]."'";

		$QueryKeyword="";
		if ($param["keyword"]!="") {
			$QueryKeyword = " AND (title LIKE '%".$param["keyword"]."%'"
							." OR intro LIKE '%".$param["keyword"]."%'"
							." OR content LIKE '%".$param["keyword"]."%')";
		}

		$QueryType = " AND idparent='".$param["type"]."'";

		$i=0;
		$class = 2;
		$count= $config["adminrow"];
		$start= $param["page"]*$count;
		$query = "SELECT * FROM ".$db_prefix."posts"
				." WHERE 1"
				." AND lang='".$param["lang"]."'"
				.$QueryType
				.$QueryStatus
				.$QueryKeyword
				." ORDER BY orders desc, datepost desc";
		$result = sql_query_limit($query, $dbi, $start, $count);
		if ($result) {	
			$numOfRows = $NumAllRowOfQuery;
			while ($obj = sql_fetch_array($result, 1)) {

				$numpost   = getCountDB($db_prefix."posts", " AND idparent='".$obj["idpost"]."'");
				$numimage  = getCountDB($db_prefix."photos", " AND idparent='".$obj["idpost"]."' AND (lang='' OR lang='".$param["lang"]."')");

				$class = 3 - $class;
				$template->assign_block_vars('postlist.post', array(
					'class' => $class,
					'stt' => ($start + $i + 1),
					'idpost' => $obj["idpost"],
					'title' => $obj["title"],
					'intro' => TrimStringX($obj["intro"], $config["intro_length"]),
					'hit' => $obj["hits"],
					'numpost' => $numpost,
					'numimage' => $numimage,
					'datepost' => formatDate($obj["datepost"], $config["timestamp"]),
					'orders' => $obj["orders"],
					'status' => $obj["status"]
				));

				$step = getParentStep($obj["idparent"]);
				if ($step<2) {
					$link = getLocation("&t=".$obj["idpost"]);
					$template->assign_block_vars('postlist.post.folder', array(
						'icon' => "folder",
						'function' => "OpenLink('".$link."');",
						'text_title' => $lang["open"]
					));
				}

				if (in_array($ADMINPRIV,array(PRIV_MOD, PRIV_ADMIN))) {
					$stat=STAT_ACTIVE;
					if ($obj["status"]==STAT_ACTIVE) $stat=STAT_STOP;
					$link = getLocation("&act=status&stat=".$stat."&id=".$obj["idpost"]);
					$template->assign_block_vars('postlist.post.control', array(
						'icon' => "status",
						'function' => "OpenConfirm('".$link."', '".$lang["msg_changestatus"]."');",
						'text_title' => $lang["status"]
					));
				}

				$link = getLocation("&act=edit&id=".$obj["idpost"]);
				$template->assign_block_vars('postlist.post.control', array(
					'icon' => "edit",
					'function' => "OpenLink('".$link."');",
					'text_title' => $lang["edit"]
				));

				if ($step>0) {
					$link = getLocation("&f=photo&t=".$obj["idpost"]);
					$template->assign_block_vars('postlist.post.control', array(
						'icon' => "photo",
						'function' => "OpenLink('".$link."');",
						'text_title' => $lang["photo"]
					));
				}

				if ($numpost==0 && $numimage==0 && in_array($ADMINPRIV,array(PRIV_MOD, PRIV_ADMIN))) {
					$link = getLocation("&act=delete&id=".$obj["idpost"]);
					$template->assign_block_vars('postlist.post.control', array(
						'icon' => "delete",
						'function' => "OpenConfirm('".$link."', '".$lang["msg_delete"]."');",
						'text_title' => $lang["delete"]
					));
				}

				$i++;
			}
			if ($i==0) $intro = $lang["post_notfound"];

			$template->assign_block_vars('postlist.total', array(
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
		'title' => $lang["adminpost"]
	));

	$template->pparse('body');
	$template->destroy();
?>