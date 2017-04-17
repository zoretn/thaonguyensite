<?php
defined ('_ALLOW') or die ('Access denied');
class image {
	var $path="";
	var $info=array();
	function image ($fullpath) {
		$this->path = $fullpath;
	}
	function getsize () {
		$image_file = $_SERVER['DOCUMENT_ROOT'] ;
		global $cfg_rootpath;
		if ($cfg_rootpath != "") $image_file .= "/" . $cfg_rootpath;
		$image_file .= "/images/stories/" .$this->path;
		$img_info = @getimagesize($image_file); //La mot mang info
		$this->info = $img_info;
		return $img_info;
	}
}
?>