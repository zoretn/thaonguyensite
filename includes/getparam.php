<?php
	if (!defined('SITEACTIVE')) die("Hacking attempt");

	// ============================================================================================== //
	// KIEM TRA MODULE & FILE ======================================================================= //
	// ============================================================================================== //
	$param["id"]= get_param("id");

	$param["module"]= get_param("m");
	if ($param["module"]=="") $param["module"]= ($param["id"]!="") ? "post" : "main";
	$param["file"]= get_param("f");
	if ($param["file"]=="") $param["file"]=$param["module"];
	if (!file_exists('modules/'.$param["module"].'/'.$param["file"].'.php')) {
		$param["module"]="main";
		$param["file"]="home";
	}
	$param["page"]= get_param("p");
	if ($param["page"]=="" || !is_numeric($param["page"])) $param["page"]=0;

	$param["user"] = get_param("user");
	$param["keyword"]= urldecode(get_param("k"));
	$param["status"]= get_param("st");
	$param["order"]= get_param("or");
	$param["type"]= get_param("t");

?>