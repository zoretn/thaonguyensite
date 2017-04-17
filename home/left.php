<?php
	if (!defined('SITEACTIVE')) die("Hacking attempt");

	$pathtemplate = TEMPLATE_DIR. '/left.tpl';
	$template->set_filenames(array(	'left' => $pathtemplate));

	// ============================================================================================== //
	// HIEN THI TIEU DE ============================================================================= //
	// ============================================================================================== //
	$title = (isset($lang[$param["tag"]])) ? $lang[$param["tag"]] : "";
	$trace = "";
	if ($param["id"]!=0) {
		$title = SelectValue("title", $db_prefix."posts", " AND idpost='".$param["id"]."' AND status='".STAT_ACTIVE."' AND (lang='' OR lang='".$param["lang"]."')");

	// ============================================================================================== //
	// LAY TRACE LINK =============================================================================== //
	// ============================================================================================== //
		if ($param["module"]=="post") {
			$idp = SelectValue("idparent", $db_prefix."posts", " AND idpost='".$param["id"]."'");
			while ($idp!="0") {
				$query = "SELECT * FROM ".$db_prefix."posts WHERE idpost='".$idp."'";
				$result = sql_query($query, $dbi);
				if ($result) {
					if ($objs = sql_fetch_array($result, 1)) {
						$link = ($objs["link"]!="") ? $objs["link"] : MAINFILE."?id=".$objs["idpost"];
						$trace =' »  <a class="tracelink" href="'.$link.'">'.low2Up($objs["title"]).'</a>'.$trace;
						$idp = $objs["idparent"];
					} else {
						$idp = 0;
					}
				}
			}
			if ($trace!="") $trace = '<a class="tracelink" href="'.MAINFILE.'">'.low2Up($lang["home"]).'</a>'.$trace;
		}
	}

	// ============================================================================================== //
	// HIEN THI LEFT MENU =========================================================================== //
	// ============================================================================================== //
	if ($param["module"]!="admin") {
		$query = "SELECT * FROM ".$db_prefix."posts"
				." WHERE idparent='0'"
				." AND status='".STAT_ACTIVE."'"
				." AND (lang='' OR lang='".$param["lang"]."')"
				." ORDER BY orders desc, datepost desc";
		$result = sql_query($query, $dbi);
		if ($result) {
			$i = 0;
			while ($obj = sql_fetch_array($result, 1)) {
				$link = ($obj["link"]!="") ? $obj["link"] : MAINFILE."?id=".$obj["idpost"];
				$template->assign_block_vars('menu', array(
					'theme' => TEMPLATE_DIR.'/',
					'class' => $i==0 ? "first" : "",
					'text' => $obj["title"],
					'link' => $link
				));
				
				if ($param["idroot"]==$obj["idpost"]) {
					$query2 = "SELECT * FROM ".$db_prefix."posts"
							." WHERE idparent='".$obj["idpost"]."'"
							." AND status='".STAT_ACTIVE."'"
							." AND (lang='' OR lang='".$param["lang"]."')"
							." ORDER BY orders desc, datepost desc";
					$result2 = sql_query($query2, $dbi);
					if ($result2) {
						while ($obj2 = sql_fetch_array($result2, 1)) {
							$link = $obj2["link"];
							if ($link=="") $link = MAINFILE."?id=".$obj2["idpost"];
							$template->assign_block_vars('menu.sub', array(
								'theme' => TEMPLATE_DIR.'/',
								'text' => $obj2["title"],
								'link' => $link
							));
						}
					}
	
				}
				$i++;
			}
		}
		
		if ($config["yahooid"]!="") {
			$template->assign_block_vars('yahoo', array());
			$tmp = explode(";", $config["yahooid"]);
			for ($i=0; $i<count($tmp); $i++) {
				$template->assign_block_vars('yahoo.row', array(
					'theme' => TEMPLATE_DIR.'/',
					'yahooid' => $tmp[$i]
				));
			}
		}
	} else {
		$template->assign_block_vars('menu', array(
			'theme' => TEMPLATE_DIR.'/',
			'class' => "first",
			'text' => $lang["home"],
			'link' => MAINFILE."?m=main&f=home"
		));
		$template->assign_block_vars('menu', array(
			'theme' => TEMPLATE_DIR.'/',
			'class' => "",
			'text' => $lang["admin"],
			'link' => MAINFILE."?m=admin&f=admin"
		));
		$template->assign_block_vars('menu.sub', array(
			'theme' => TEMPLATE_DIR.'/',
			'text' => $lang["homeimage"],
			'link' => MAINFILE."?m=admin&f=photo"
		));
		$template->assign_block_vars('menu.sub', array(
			'theme' => TEMPLATE_DIR.'/',
			'text' => $lang["post"],
			'link' => MAINFILE."?m=admin&f=post"
		));
		$template->assign_block_vars('menu.sub', array(
			'theme' => TEMPLATE_DIR.'/',
			'text' => $lang["config"],
			'link' => MAINFILE."?m=admin&f=config"
		));
		$template->assign_block_vars('menu.sub', array(
			'theme' => TEMPLATE_DIR.'/',
			'text' => $lang["lang"],
			'link' => MAINFILE."?m=admin&f=lang"
		));
		$template->assign_block_vars('menu.sub', array(
			'theme' => TEMPLATE_DIR.'/',
			'text' => $lang["user"],
			'link' => MAINFILE."?m=admin&f=user"
		));
//		$template->assign_block_vars('menu.sub', array(
//			'theme' => TEMPLATE_DIR.'/',
//			'text' => $lang["banner"],
//			'link' => MAINFILE."?m=admin&f=banner"
//		));
		$template->assign_block_vars('menu', array(
			'theme' => TEMPLATE_DIR.'/',
			'class' => "",
			'text' => $lang["logout"]." (".$USERNAME.")",
			'link' => MAINFILE."?m=main&f=logout"
		));
	}

	// ============================================================================================== //
	// HIEN THITRANG HOME =========================================================================== //
	// ============================================================================================== //
	if ($param["module"]=="main" && $param["file"]=="home") {
		$template->assign_block_vars('home', array(
			'theme' => TEMPLATE_DIR.'/'
		));
	} else {
		$template->assign_block_vars('nohome', array(
			'theme' => TEMPLATE_DIR.'/',
			'trace' => $trace
		));
	}

	$template->assign_vars(array(
		'theme' => TEMPLATE_DIR.'/',
		'maxwidth' => $config["maxwidth"],
		'title' => $title
	));

	$template->pparse('left');
	$template->destroy();
?>