<?php
	if (!defined('SITEACTIVE')) die("Hacking attempt");

	if ($iduser==-1) {
		Header("Location: ".MAINFILE."?m=main&f=login&redirect=".urlencode($_SERVER["REQUEST_URI"]));
		exit();
	} else if (!in_array($ADMINPRIV,array(PRIV_MOD, PRIV_ADMIN))) {
		Header('Location: '.MAINFILE.'?m=main&f=home');
		exit();
	}

	$id = 53;
	$idparent = 30;
	$lang = "cn";
	$query = "SELECT * FROM ".$db_prefix."posts "
			."WHERE idpost='".$id."' ";
	$result = sql_query($query, $dbi);
	if ($result) {
		if ($obj = sql_fetch_array($result, 1)) {
		
			$idpost = getIDMax("idpost", $db_prefix."posts",'')+1;

			$image = "";
			if ($obj["image"]!="") {
				$obj["imgpath"] = PATH_UPLOAD.'/'.$obj["image"];
				if (file_exists($obj["imgpath"])) {
					$image = CreateNewFilename(PATH_UPLOAD,$obj["image"]);
					@copy($obj["imgpath"], PATH_UPLOAD.'/'.$image);
				}
			}

			$query2 = "INSERT INTO ".$db_prefix."posts (idpost, idparent, title, intro, content, tag, link, image, status, datepost, orders, lang) VALUES ("
				."'".$idpost."', "
				."'".$idparent."', "
				."'".$obj["title"]."', "
				."'".$obj["intro"]."', "
				."'".$obj["content"]."', "
				."'".$obj["tag"]."', "
				."'".$obj["link"]."', "
				.'"'.$image.'", '
				."'".$obj["status"]."', "
				."'".date("Y-m-d H:i:s")."', "
				."'".$obj["orders"]."', "
				."'".$lang."')";
			$result2 = sql_query($query2, $dbi);
			echo '<p>'.$query2;
		}
	}

	$query = "SELECT * FROM ".$db_prefix."photos "
			."WHERE idparent='".$id."' ";
	$result = sql_query($query, $dbi);
	if ($result) {
		while ($obj = sql_fetch_array($result, 1)) {
		
			$idphoto = getIDMax("idphoto", $db_prefix."photos"," AND idparent='".$idpost."'")+1;

			$image = "";
			if ($obj["image"]!="") {
				$obj["imgpath"] = PATH_UPLOAD.'/photo/'.$obj["image"];
				if (file_exists($obj["imgpath"])) {
					$image = CreateNewFilename(PATH_UPLOAD.'/photo',$obj["image"]);
					@copy($obj["imgpath"], PATH_UPLOAD.'/photo/'.$image);
				}
				$obj["thmpath"] = PATH_UPLOAD.'/thumb/'.$obj["image"];
				if (file_exists($obj["thmpath"])) {
					$thumb = CreateNewFilename(PATH_UPLOAD.'/thumb',$obj["image"]);
					@copy($obj["thmpath"], PATH_UPLOAD.'/thumb/'.$thumb);
				}
			}

			$query2 = "INSERT INTO ".$db_prefix."photos (idphoto, idparent, lang, title, intro, image, tag, link, datepost, orders, status) VALUES ("
				."'".$idphoto."', "
				."'".$idpost."', "
				."'".$lang."', "
				."'".$obj["title"]."', "
				."'".$obj["intro"]."', "
				.'"'.$image.'", '
				."'".$obj["tag"]."', "
				."'".$obj["link"]."', "
				."'".date("Y-m-d H:i:s")."', "
				."'".$obj["orders"]."', "
				."'".$obj["status"]."')";
			$result2 = sql_query($query2, $dbi);
			echo '<p>'.$query2;
		}
	}

?>