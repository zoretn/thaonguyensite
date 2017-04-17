<?php
	if (!defined('SITEACTIVE')) die("Hacking attempt");

	// ============================================================================================== //
	// LAY CONFIG =================================================================================== //
	// ============================================================================================== //

	$REMOTE_ADDR=get_param("REMOTE_ADDR");
	// Query tren database
	$query  = "SELECT * FROM ".$db_prefix."config";
	$result = sql_query($query, $dbi);
	if ($result) {
		while ($objs = sql_fetch_object ($result, 1)) {
			$config_name=$objs->config_name;
			$config_value=$objs->config_value;
			$config[$config_name]=$config_value;
		}
		ksort($config);
	} else {
		die("Can not connect to database! Please contact Administrator!");
	}

?>