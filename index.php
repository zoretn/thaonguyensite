<?php
	ob_start("ob_gzhandler");
	include ("mainfile.php");

	$timeLimit=@set_time_limit(600);
	error_reporting  (E_ALL | E_ERROR | E_PARSE | E_WARNING | E_NOTICE); // This will NOT report uninitialized variables
	set_magic_quotes_runtime(0);
		
	define("SITEACTIVE",true);

	$template=new Template;
	$param=Array();
	$config=Array();
	$param["id"]= get_param("id");

	// ============================================================================================== //
	// OPEN DATABASE ================================================================================ //
	// ============================================================================================== //
	include("commons/db_open.php");

	// ============================================================================================== //
	// GET PARAMETERS =============================================================================== //
	// ============================================================================================== //
	include("includes/getconfig.php");
	include("includes/getparam.php");
	include("includes/getlang.php");
	include("includes/getsession.php");

	if ($param["module"]=="flash") {
		require("modules/".$param["module"]."/".$param["file"].".php");
	} else {
		require("meta.php");
		require("header.php");
		require("left.php");
		require("modules/".$param["module"]."/".$param["file"].".php");
		require("footer.php");
	}
	// ============================================================================================== //
	// CLOSE DATABASE =============================================================================== //
	// ============================================================================================== //
	include("commons/db_close.php");
?>