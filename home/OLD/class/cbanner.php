<?php
defined ('_ALLOW') or die ('Access denied');
class banner {
	var $id;
	var $title;
	var $title_en;
	var $describe;
	var $tag;
	var $image="";
	var $active;
	var $nums;
	
	function Doc_danh_sach ($catid="") {
		$strwhere = "";
		return $this->Fill($strwhere);
	}
	function Fill ($strwhere="") {
		global $csdl;
		$strsql = "SELECT * FROM banner";
		if ($strwhere!="") {
			$strsql .= " WHERE " . $strwhere;
		}
		$rowsdb = $csdl->Truyvan ($strsql);
		$i=0;
		$this->nums=0;
		if ($rowsdb==false) return null;
		while ($rowdb = mysql_fetch_array($rowsdb,MYSQL_ASSOC)) {
			$rowarray[$i] = $this->Khoi_tao($rowdb);
			$i++;
		}
		if ($i==0) return null;
		$this->nums = $i;
		return $rowarray;
	}
	function Doc ($id) {
		$strwhere = "id=$id";
		$rowarray = $this->Fill($strwhere);
		if ($rowarray==null)
			return null;
		else
			return $rowarray[0];
	}
	function Khoi_tao ($rowdb) {
		$kq = new banner;
		$kq->id = $rowdb['id'];
		$kq->title = $rowdb['title'];
		$kq->title_en = $rowdb['title_en'];
		$kq->describe = $rowdb['describe'];
		$kq->tag = $rowdb['tag'];
		$kq->image = $rowdb['image'];
		$kq->active = $rowdb['active'];
		return $kq;
	}
	function Xoa () {
		global $csdl;
		checkpermission("grantbanner",1) or die ('Access denied');
		$csdl->Xoa("banner","id=$this->id");
	}
	function DocForm () {
		$this->id = $_REQUEST['id'];
		$this->title = $_REQUEST['title'];
		$this->title_en = $_REQUEST['title_en'];
		$this->describe = $_REQUEST['describe'];
		$this->tag = $_REQUEST['tag'];
		$this->image = $_REQUEST['image'];
		$this->active=0;
		if (isset($_REQUEST['active'])) $this->active = 1;
	}
	function Ghi () {
		checkpermission("grantbanner",1) or die ('Access denied');
		global $csdl;
		if ($this->id > -1) {
			$strsql = "UPDATE `banner` SET ";
			$strsql .= "`title`='$this->title',";
			$strsql .= "`title_en`='$this->title_en',";
			$strsql .= "`describe`='$this->describe', ";
			$strsql .= "`tag`='$this->tag',";
			$strsql .= "`image`='$this->image', ";
			$strsql .= "`active`=$this->active ";
			$strsql .= "WHERE `id`=$this->id";
		}
		else {
			$strsql = "INSERT INTO `banner` (`title`, `title_en`, `describe`, `tag`, `image`, `active`) ";
			$strsql .= "VALUES ('$this->title', '$this->title_en', '$this->describe', '$this->tag', '$this->image', $this->active)";
		}
		$csdl->Ghi($strsql);
	}
	function Out_Image ($maxwidth) {
		global $cfg_image_root;
		$strout = "";
		$objimage = new image($this->image);
		$sizeimage = $objimage->getsize();
		if (!is_array($sizeimage)) return "";
		$fullwidth = $sizeimage[0];
		$fullheight = $sizeimage[1];
		$scalewidth = $maxwidth;
		if ($fullwidth < $scalewidth)
			$scalewidth = $fullwidth;			
		$imgsrc = $cfg_image_root . $this->image;
		$ext = substr($imgsrc,-3);
		if (strtoupper($ext) != "SWF")
			$strout .= "<img src='$imgsrc' width='$scalewidth' border='0' />";
		else {
			$divadv = "banner" . $this->id;
			$strout .= "<div id=\"$divadv\">";
			$strout .= "</div>";
			$strout .= "<script type=\"text/javascript\">";
			$strout .= "UFO_OutFlash(\"$divadv\", \"$imgsrc\", \"$fullwidth\", \"$fullheight\")";
			$strout .= "</script>";
			/*
			$strout .= "<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0\" width=\"$fullwidth\" height=\"$fullheight\">";
			$strout .= "<param name=\"movie\" value=\"$imgsrc\" />";
			$strout .= "<param name=\"quality\" value=\"high\" />";
			$strout .= "<embed src=\"$imgsrc\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"$fullwidth\" height=\"$fullheight\"></embed>";
			$strout .= "</object>";
			*/
		}
		echo $strout;
	}
	function Out_TheHien ($maxwidth) {
		$this->Out_Image($maxwidth);
	}
};
global $objbanner; $objbanner = new banner;
?>