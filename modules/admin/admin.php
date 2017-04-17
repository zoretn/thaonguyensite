<?php
	if (!defined('SITEACTIVE')) die("Hacking attempt");

	if ($iduser==-1) {
		Header("Location: ".MAINFILE."?m=main&f=login&redirect=".urlencode($_SERVER["REQUEST_URI"]));
		exit();
	}

	$pathtemplate = TEMPLATE_DIR.'/admin_home.tpl';
	$template->set_filenames(array(	'body' => $pathtemplate));

	// ============================================================================================== //
	// THONG KE TRUY CAP ============================================================================ //
	// ============================================================================================== //
	$template->assign_block_vars('stat', array(
		'title' => $lang["statics"],
		'text_stt' => $lang["stt"],
		'text_ip' => $lang["hostname"],
		'text_username' => $lang["user"],
		'text_datepost' => $lang["date"],
		'text_country' => $lang["country"]
	));

	include("includes/geoip.php");
	$gi = geoip_open("includes/GeoIP.dat",GEOIP_STANDARD);

	$class = 1;
	$count = $config["adminrow"];
	$start= $param["page"]*$count;
	$query = "SELECT * FROM ".$db_prefix."sessions WHERE 1 ORDER BY datepost desc";
	$result = sql_query_limit($query, $dbi, $start, $count);
	if ($result) {
		$i=0;
		$numOfRows = $NumAllRowOfQuery;
		while ($obj = sql_fetch_array($result, 1)) {
			$stat = ($obj["datepost"]>=date("Y-m-d H:i:s",strtotime("-5 minute"))) ? "1" : "2";
			$obj["username"]=SelectValue("username", $db_prefix."users"," AND iduser='".$obj["iduser"]."'");

			$class = 3 - $class;
			$template->assign_block_vars('stat.session', array(
				'class' => $class,
				'stt' => ($start + $i + 1),
				'status' => $stat,
				'ip' => $obj["IP"],
				'username' => $obj["username"],
				'datepost' => formatDate($obj["datepost"],$config["timestamp"]),
				'country'  => @geoip_country_code_by_addr($gi, $obj["IP"])."-".@geoip_country_name_by_addr($gi, $obj["IP"]),
				'hostname' => $obj["hostname"]
			));
			$template->assign_block_vars('stat.session.control', array(
				'icon' => "view",
				'function' => "OpenLink('".$obj["url"]."');",
				'text_title' => $lang["view"]." ".htmlspecialchars($obj["url"])
			));
			$i++;
		}
		$template->assign_block_vars('stat.total', array(
			'total' => $numOfRows,
			'text_total' => $lang["total"]
		));

		// Hien thi Page
		ShowPageNav($param["page"], $count, $numOfRows, 2, "pagenav", getLocation("&p={page}"));
	}

	// ============================================================================================== //
	// THONG KE BAI VIET ============================================================================ //
	// ============================================================================================== //
	$template->assign_block_vars('post', array(
		'title' => $lang["most_popular"],
		'text_stt' => $lang["stt"],
		'text_post' => $lang["post"],
		'text_hit' => $lang["hit"]
	));

	$class = 1;
	$count = $config["maxrows"];
	$start = 0;
	$query = "SELECT * FROM ".$db_prefix."posts"
			." WHERE idparent<>'0'"
			." AND lang='".$param["lang"]."'"
			." AND hits<>'0'"
			." ORDER BY hits desc, datepost desc";
	$result = sql_query_limit($query, $dbi, $start, $count);
	if ($result) {
		$i = 0;
		$numOfRows = $NumAllRowOfQuery;
		while ($obj = sql_fetch_array($result, 1)) {
			$idroot = GetIDRoot($db_prefix."posts", "", $obj["idparent"]);
			$tag    = SelectValue("tag", $db_prefix."posts", " AND idpost='".$idroot."'");
			$link   = ($obj["link"]!="") ? $obj["link"] : MAINFILE."?m=".$tag."&f=view&id=".$obj["idpost"];
			$class = 3 - $class;
			$template->assign_block_vars('post.row', array(
				'class' => $class,
				'stt' => ($start + $i + 1),
				'status' => $obj["status"],
				'title' => $obj["title"],
				'hit' => $obj["hits"],
				'link' => $link
			));
			$template->assign_block_vars('post.row.control', array(
				'icon' => "view",
				'function' => "OpenLink('".$link."');",
				'text_title' => $lang["view"]." ".htmlspecialchars($link)
			));
			$i++;
		}
	}

	// ============================================================================================== //
	// THAY THE GIAO DIEN CHUNG ===================================================================== //
	// ============================================================================================== //
	$template->assign_vars(array(
		'theme' => TEMPLATE_DIR.'/',
	));

	$template->pparse('body');
	$template->destroy();
?>