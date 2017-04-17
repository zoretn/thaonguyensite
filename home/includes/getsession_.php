<?php
	if (!defined('SITEACTIVE')) die("Hacking attempt");

	// ============================================================================================== //
	// KIEM TRA SESSION ============================================================================= //
	// ============================================================================================== //
	$firsttime=false;
	session_start();
	$REMOTE_ADDR=$_SERVER["REMOTE_ADDR"];
	$url=basename($_SERVER['PHP_SELF'])."?".(isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : "");
	$tempsession= isset($_SESSION[$SESSION_NAME]) ? $_SESSION[$SESSION_NAME] : "";
	$usersession= isset($_SESSION[$SESSION_USER]) ? $_SESSION[$SESSION_USER] : "";
	if ($tempsession!="" && $usersession!="" && CheckCond($db_prefix."sessions"," AND idsession='".$usersession."'")) {
		$QueryUrl="";
		if ($param["module"]!="flash") $QueryUrl=", url='".$url."'";
		$query  = "UPDATE ".$db_prefix."sessions"
				." SET datepost='".date("Y-m-d H:i:s")."'"
				.$QueryUrl
				." WHERE idsession='".$usersession."'";
		$result = sql_query($query, $dbi);
	} else {
		$hostname=@gethostbyaddr($REMOTE_ADDR);
		$tempsession=-1;

		$usersession=MD5(date("Ymdhis"));
		$_SESSION[$SESSION_USER] = $usersession;

		// ==================================== //
		// Kiem tra co qua truy cap trong 2 phut
		// ==================================== //
		$countConnect=getCountDB($db_prefix."sessions", " AND ip='".$REMOTE_ADDR."' AND url='".$url."' AND datepost>='".date("Y-m-d H:i:s",strtotime("-2 minute"))."'");
		if ($countConnect>10) {
			//Close connect database
			include("commons/db_close.php");
			die("Server too busy! Please wait a minute then connect again!");
		}

		// ==================================== //
		// Kiem tra co phai bot cua Google khong
		// ==================================== //
		if (strpos($hostname,"googlebot.com")===false && strpos($hostname,"yahoo.net")===false && strpos($hostname,"live.com")===false) {

			// Query tren database
			$query  = "DELETE FROM ".$db_prefix."sessions"
					." WHERE datepost<'".date("Y-m-d",strtotime("-3 day"))."'";
			$result = sql_query($query, $dbi);

			// Write Logs
//			WriteLog(PATH_UPLOAD.'/counter.txt', $tempsession, "Connect");

			$config["counter"]++;
			$query = "UPDATE ".$db_prefix."config SET config_value='".$config["counter"]."' WHERE config_name='counter'";
			$result = sql_query($query, $dbi);

			$query  = "INSERT INTO ".$db_prefix."sessions"
					." (idsession, iduser, IP, hostname, url, datepost)"
					." VALUES ('".$usersession."', '".$tempsession."', '".$REMOTE_ADDR."', '".$hostname."', '".$url."', '".date("Y-m-d H:i:s")."')";
			$result = sql_query($query, $dbi);

		}
		$firsttime=true;
	}
	$iduser=$tempsession;

	// ==================================== //
	// Kiem tra thong tin User Session dang online
	// ==================================== //
	$query = "SELECT * FROM ".$db_prefix."users"
			." WHERE iduser='".$iduser."'"
			." AND status='".STAT_ACTIVE."'";
	$result = sql_query($query,$dbi);
	if ($result) {
		if ($obj = sql_fetch_object($result, 1)) {
			$ADMINPRIV = $obj->admin;
			$USERNAME  = $obj->username;
			$USEREMAIL = $obj->email;
			$FULLNAME = $obj->fullname;
		} else {
			$iduser=-1;
			$ADMINPRIV = 0;
			$USERNAME = 'Anonymous';
			$USEREMAIL = $config["adminmail"];
		}
	}
	if ($FULLNAME=="") $FULLNAME = $USERNAME;
	$_SESSION[$SESSION_NAME] = $iduser;

//	if ($firsttime) {
//		//Close connect database
//		include("commons/db_close.php");
//		Header("Location: http://".$DOMAIN_NAME.$_SERVER["REQUEST_URI"]);
//		exit();
//	}
?>