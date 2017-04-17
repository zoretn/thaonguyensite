<?php
	if (!defined('SITEACTIVE')) die("Hacking attempt");

	$pathtemplate = TEMPLATE_DIR.'/post.tpl';
	$template->set_filenames(array(	'main' => $pathtemplate));

	$idparent = "";
	$date = date("Y-m-d H:i:s");
	$hasimage = false;

	// ============================================================================================== //
	// HIEN THI THONG TIN CHINH ==================================================================== //
	// ============================================================================================== //
	if ($param["id"]!="") {
		$query = "SELECT * FROM ".$db_prefix."posts"
				." WHERE idpost='".$param["id"]."'"
				." AND status='".STAT_ACTIVE."'"
				." AND (lang='' OR lang='".$param["lang"]."')";
		$result = sql_query($query, $dbi);
		if ($result) {
			if ($obj = sql_fetch_array($result, 1)) {
				$idparent = $obj["idparent"];
				$date = $obj["datepost"];

				$template->assign_block_vars('post', array(
					'title' => $obj["title"],
					'intro' => $obj["intro"],
					'content' => $obj["content"]
				));
				if (strlen($obj["intro"])>4) {
					$template->assign_block_vars('post.intro', array(
						'intro' => $obj["intro"],
					));
				}
				if (strlen($obj["content"])>4) {
					$template->assign_block_vars('post.content', array(
						'content' => $obj["content"],
					));
				}
				
				$obj["imgpath"] = PATH_UPLOAD."/".$obj["image"];
				if ($obj["image"]=="" || !file_exists($obj["imgpath"])) {
					$obj["image"] = SelectValue("image", $db_prefix."posts", " AND idpost='".$obj["idparent"]."' AND (lang='' OR lang='".$param["lang"]."')");
					$obj["imgpath"] = PATH_UPLOAD."/".$obj["image"];
				}
				if ($obj["image"]!="" && file_exists($obj["imgpath"])) {
					$hasimage = true;
					$template->assign_block_vars('image', array(
						'image' => $obj["imgpath"],
						'width' => $config["post_width"]
					));
				}

				// Update Hit
				$cookiepost=get_Cparam("cookiepost");
				if ($cookiepost=="") $cookiepost=0;				
				if ($cookiepost!=$param["id"] && $obj["idparent"]!=0) {
					$cookiepost=$param["id"];
					setcookie('cookiepost',$cookiepost,time()+$config["cookietime"]);
					// Query tren database cap nhat HIT
					$query  = "UPDATE ".$db_prefix."posts SET hits=".($obj["hits"]+1)." WHERE idpost='".$param["id"]."'";
					$result = sql_query($query, $dbi);
				}			
			} else {
				$param["id"]="";
			}
		}
	}

	// ============================================================================================== //
	// HIEN THI HINH ANH ============================================================================ //
	// ============================================================================================== //
	if ($param["id"]!="") {
		$maxcols = $hasimage ? ($config["maxcols"] - 1) : $config["maxcols"];
		$query = "SELECT * FROM ".$db_prefix."photos"
				." WHERE idparent='".$param["id"]."'"
				." AND (lang='' OR lang='".$param["lang"]."')"
				." AND status='".STAT_ACTIVE."'"
				." ORDER BY orders desc, datepost";
		$result = sql_query($query, $dbi);
		if ($result) {
			$i = 0;
			$numimage = sql_num_rows($result);
			if ($numimage>1) {
				while ($obj = sql_fetch_array($result, 1)) {
					$obj["imgpath"] = PATH_UPLOAD."/photo/".$obj["image"];
					$obj["thumbpath"] = PATH_UPLOAD."/thumb/".$obj["image"];
					if ($i==0) {
						$template->assign_block_vars('photo', array(
							'idpost' => $param["id"]
						));
						$template->assign_block_vars('photo.slide', array(
							'idpost' => $param["id"]
						));
					}
					if ($i % $maxcols == 0) {
						$template->assign_block_vars('photo.row', array(
						));
					}
					$template->assign_block_vars('photo.row.col', array(
						'theme' => TEMPLATE_DIR.'/',
						'image' => $obj["imgpath"],
						'thumb' => $obj["thumbpath"],
						'title' => $obj["title"],
						'title_jv' => htmlspecialchars($obj["title"]),
						'cellwidth' => floor(100 / $maxcols) . "%",
						'width' => $config["thumb_width"]
					));
	
					if (strlen($obj["intro"])>4) {
						$template->assign_block_vars('photo.row.col.intro', array(
							'intro' => $obj["intro"],
						));
					}
	
	//				if ($i % $maxcols != 0) {
	//					$template->assign_block_vars('photo.row.col.space', array(
	//					));
	//				}
					$i++;
				}
			}
		}
	}

	// ============================================================================================== //
	// HIEN THI BAI VIET CON ======================================================================== //
	// ============================================================================================== //
	if ($param["id"]!="") {
	
		$QueryParent = " AND (idparent='".$param["id"]."'";
		if ($param["tag"]!="product") {
			$query = "SELECT * FROM ".$db_prefix."posts"
					." WHERE idparent='".$param["id"]."'"
					." AND status='".STAT_ACTIVE."'"
					." AND (lang='' OR lang='".$param["lang"]."')"
					." ORDER BY orders desc, datepost desc";
			$result = sql_query($query, $dbi);
			if ($result) {
				while ($obj = sql_fetch_array($result, 1)) {
					$QueryParent.=" OR idparent='".$obj["idpost"]."'";
				}
			}
		}
		$QueryParent.=")";

		$template->assign_block_vars('postlist', array(
		));

		$maxrows  = $config["maxrows"];
		$maxcols  = $param["tag"]=="news" ? 1 : ($hasimage ? $config["maxcols"] - 1 : $config["maxcols"]);
		$imgwidth = $param["tag"]=="news" ? ($config["thumb_width"] / 2) : $config["thumb_width"];
		$count = $maxcols * $maxrows;
		$start = $param["page"] * $count;
		$query = "SELECT * FROM ".$db_prefix."posts"
				." WHERE (intro<>'' || content<>'')"
				." AND status='".STAT_ACTIVE."'"
				." AND (lang='' OR lang='".$param["lang"]."')"
				.$QueryParent
				." ORDER BY orders desc, datepost desc";
		$result = sql_query_limit($query, $dbi, $start, $count);
		if ($result) {
			$i=0;
			$numOfRows = $NumAllRowOfQuery;
			$numOfLimit = ($numOfRows<$maxcols*$maxrows) ? $numOfRows : $maxcols*$maxrows;
			while ($obj = sql_fetch_array($result, 1)) {
			
				if ($numOfRows==1) {
					Header("Location: ".MAINFILE."?id=".$obj["idpost"]);
					exit();
				}
	
				$link = ($obj["link"]!="") ? $obj["link"] : MAINFILE."?id=".$obj["idpost"];
				if ($i % $maxcols == 0) {
					$template->assign_block_vars('postlist.row', array(
					));
				}
	
				$template->assign_block_vars('postlist.row.col', array(
					'theme' => TEMPLATE_DIR.'/',
					'width' => floor(100 / $maxcols) . "%",
					'title' => $obj["title"],
					'datepost' => formatDate($obj["datepost"], $config["timestamp"]),
					'link' => $link
				));
				if (strlen($obj["intro"])>4) {
					$template->assign_block_vars('postlist.row.col.intro', array(
						'intro' => $obj["intro"]
					));
				}
				
				$obj["image"] = SelectValue("image", $db_prefix."photos",
							 " AND idparent='".$obj["idpost"]."'"
							." AND (lang='' OR lang='".$param["lang"]."')"
							." AND status='".STAT_ACTIVE."'"
							." ORDER BY orders desc, datepost");
				if ($obj["image"]=="") {
					$idchild = SelectValue("idpost", $db_prefix."posts",
							 " AND idparent='".$obj["idpost"]."'"
							." AND status='".STAT_ACTIVE."'"
							." AND (lang='' OR lang='".$param["lang"]."')"
							." ORDER BY orders desc, datepost desc");
					if ($idchild!="") {
						$obj["image"] = SelectValue("image", $db_prefix."photos",
							 " AND idparent='".$idchild."'"
							." AND (lang='' OR lang='".$param["lang"]."')"
							." AND status='".STAT_ACTIVE."'"
							." ORDER BY orders desc");
					}
				}
				$obj["imgpath"] = PATH_UPLOAD."/thumb/".$obj["image"];
				if ($obj["image"]!="" && file_exists($obj["imgpath"])) {
					$template->assign_block_vars('postlist.row.col.imagetop', array(
						'image' => $obj["imgpath"],
						'width' => $imgwidth,
						'title_jv' => htmlspecialchars($obj["title"]),
						'link' => $link
					));
				}
				$numimage = GetCountDB($db_prefix."photos", " AND idparent='".$obj["idpost"]."' AND (lang='' OR lang='".$param["lang"]."') AND status='".STAT_ACTIVE."'");
				if ($param["tag"]!="product" && (strlen($obj["content"])>4 || $numimage>1)) {
					$template->assign_block_vars('postlist.row.col.more', array(
						'link' => $link,
						'text_more' => $lang["more"]
					));
				}
				if ($i % $maxcols != 0) {
					$template->assign_block_vars('postlist.row.col.space', array(
					));
				}	
				$i++;
			}
			// Hien thi Page
			ShowPageNav($param["page"], $count, $numOfRows, 4, "pagenav", getLocation("&id=".$param["id"]."&p={page}"));
		}
	}

	// ============================================================================================== //
	// HIEN THI BAI VIET LIEN QUAN ================================================================== //
	// ============================================================================================== //
	if ($idparent!="" && $idparent!=0) {
	
		$arrType = array();
		$query = "SELECT * FROM ".$db_prefix."posts"
				." WHERE idparent='".$idparent."'"
				." AND datepost<='".$date."'"
				." AND status='".STAT_ACTIVE."'"
				." AND (lang='' OR lang='".$param["lang"]."')"
				." AND idpost<>'".$param["id"]."'"
				." ORDER BY datepost desc";
		$result = sql_query($query, $dbi);
		if ($result) {
			$i = 0;
			while ($obj = sql_fetch_array($result, 1)) {
				$link = ($obj["link"]!="") ? $obj["link"] : MAINFILE."?id=".$obj["idpost"];
				
				if ($i==0) {
					$template->assign_block_vars('otherpost', array(
						'text_other' => $lang["otherpost"]
					));
				}
				$template->assign_block_vars('otherpost.row', array(
					'link' => $link,
					'text' => $obj["title"]
				));
				$i++;
			}
		}
	}
			
	// ============================================================================================== //
	// THAY THE GIAO DIEN CHUNG ===================================================================== //
	// ============================================================================================== //
	$template->assign_vars(array(
		'theme' => TEMPLATE_DIR. '/',
		'maxwidth' => $config["maxwidth"]
	));
	$template->pparse('main');
	$template->destroy();
?>