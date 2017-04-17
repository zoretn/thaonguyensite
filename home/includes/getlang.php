<?php
	if (!defined('SITEACTIVE')) die("Hacking attempt");

	// ============================================================================================== //
	// KIEM TRA NGON NGU SU DUNG ==================================================================== //
	// ============================================================================================== //
	$param["id"]  = get_param("id");
	$param["lang"]= get_param("lang");
	if ($param["lang"]=="" && $param["id"]!="") {
		if ($param["module"]=="post") {
			$param["lang"] = SelectValue("lang", $db_prefix."posts", " AND idpost='".$param["id"]."' AND status='".STAT_ACTIVE."'");
		}
	}
	if ($param["lang"]=="") $param["lang"]=get_Cparam("lang");
	if ($param["lang"]=="") $param["lang"]="vn";
	setcookie('lang',$param["lang"],time()+60*60*24*365);

	$param["idroot"] = 0;
	$param["tag"] = ($param["module"]!="main" && $param["module"]!="admin") ? $param["module"] : $param["file"];
	if ($param["id"]!='' && $param["module"]=="post") {
			$param["idroot"] = GetIDRoot($db_prefix."posts", "AND status='".STAT_ACTIVE."'", $param["id"]);
			$param["tag"] = SelectValue("tag", $db_prefix."posts", " AND idpost='".$param["idroot"]."'");
	} else if ($param["tag"]!="") {
		$param["idroot"] = SelectValue("idpost", $db_prefix."posts", "AND tag='".$param["module"]."'");
	}
	
	// ============================================================================================== //
	// LAY DATABASE ================================================================================= //
	// ============================================================================================== //

	// Query tren database
	$lang = array();
	$query  = "SELECT * FROM ".$db_prefix."language WHERE lang='".$param["lang"]."'";
	$result = sql_query($query, $dbi);
	if ($result) {
		while ($objs = sql_fetch_object($result, 1)) {
			$lang_name=$objs->lang_name;
			$lang_value=$objs->lang_value;
			$lang[$lang_name]=$lang_value;
		}
		ksort($lang);
	} else {
		die("Can not connect to database! Please contact Administrator!");
	}
?>