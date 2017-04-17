<?php
	if (!defined('SITEACTIVE')) die("Hacking attempt");

	if ($iduser==-1) {
		Header("Location: ".MAINFILE."?m=main&f=login&redirect=".urlencode($_SERVER["REQUEST_URI"]));
		exit();
	}

	$usersession= isset($_SESSION[$SESSION_USER]) ? $_SESSION[$SESSION_USER] : "";
	$query  = "DELETE FROM ".$db_prefix."sessions"
			." WHERE idsession='".$usersession."'";
	$result = sql_query($query, $dbi);

	delete_session($SESSION_NAME);

	Header("Location: ".MAINFILE."?m=main&f=login");
	exit();
?>