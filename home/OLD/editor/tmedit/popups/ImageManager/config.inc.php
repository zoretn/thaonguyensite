<?php
global $cfg_rootpath;
$BASE_DIR = $_SERVER['DOCUMENT_ROOT'] ;
$BASE_URL = "/";
if ($cfg_rootpath == "") $BASE_ROOT = "images/stories";
else $BASE_ROOT = $cfg_rootpath . "/images/stories"; 
$SAFE_MODE = false;
$IMG_ROOT = $BASE_ROOT;

if(strrpos($BASE_DIR, '/')!= strlen($BASE_DIR)-1) 
	$BASE_DIR .= '/';

if(strrpos($BASE_URL, '/')!= strlen($BASE_URL)-1) 
	$BASE_URL .= '/';

function dir_name($dir) //Tra ve ten thu muc
{
	$lastSlash = intval(strrpos($dir, '/'));
	if($lastSlash == strlen($dir)-1){
		return substr($dir, 0, $lastSlash);
	}
	else
		return dirname($dir);
}
?>