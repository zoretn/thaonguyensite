<?php
defined ('_ALLOW') or die ('Access denied');
class adv {
	var $id;
	var $name;
	var $name_en;
	var $describe;
	var $tag;
	var $website;
	var $img="";
	var $order;
	var $nums;
	
	function Doc_danh_sach ($catid="") {
		$strwhere = "";
		return $this->Fill($strwhere);
	}
	function Fill ($strwhere="") {
		global $csdl;
		$strsql = "SELECT * FROM adv";
		if ($strwhere!="") {
			$strsql .= " WHERE " . $strwhere;
		}
		$strsql .= " ORDER BY iorder, id DESC";
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
		$kq = new adv;
		$kq->id = $rowdb['id'];
		$kq->name = $rowdb['name'];
		$kq->name_en = $rowdb['name_en'];
		$kq->describe = $rowdb['describe'];
		$kq->tag = $rowdb['tag'];
		$kq->website = $rowdb['website'];
		$kq->img = $rowdb['img'];
		$kq->order = $rowdb['iorder'];
		return $kq;
	}
	function Xoa () {
		global $csdl;
		checkpermission("grantadv",1) or die ('Access denied');
		$csdl->Xoa("adv","id=$this->id");
	}
	function DocForm () {
		$this->id = $_REQUEST['id'];
		$this->name = $_REQUEST['name'];
		$this->name_en = $_REQUEST['name_en'];
		$this->describe = $_REQUEST['describe'];
		$this->tag = $_REQUEST['tag'];
		$this->website = $_REQUEST['website'];
		$this->img = $_REQUEST['img'];
	}
	function GetMaxOrder () {
		$strwhere = "iorder>=all";
		$strwhere .= " (SELECT iorder FROM adv)";
		$rowarray = $this->Fill ($strwhere);
		if ($rowarray==null) return 0;
		return $rowarray[0]->order;
	}
	function Ghi () {
		checkpermission("grantadv",1) or die ('Access denied');
		global $csdl;
		if ($this->id > -1) {
			$strsql = "UPDATE `adv` SET ";
			$strsql .= "`name`='$this->name',";
			$strsql .= "`name_en`='$this->name_en',";
			$strsql .= "`describe`='$this->describe', ";
			$strsql .= "`tag`='$this->tag',";
			$strsql .= "`website`='$this->website',";
			$strsql .= "`img`='$this->img' ";
			$strsql .= "WHERE `id`=$this->id";
		}
		else {
			$neworder = $this->GetMaxOrder() + 1;
			$strsql = "INSERT INTO `adv` (`name`, `name_en`, `describe`, `tag`, `website`, `img`, `iorder`) ";
			$strsql .= "VALUES ('$this->name', '$this->name_en', '$this->describe', '$this->tag', '$this->website', '$this->img', $neworder)";
		}
		$csdl->Ghi($strsql);
	}
	function ChangeOrder ($neworder) {
		checkpermission("grantadv",1) or die ('Access denied');
		global $csdl;
		$strsql = "UPDATE `adv` SET ";
		$strsql .= "`iorder` = $neworder ";
		$strsql .= "WHERE `id`=$this->id";
		$csdl->Ghi($strsql);
	}
	function Get_Url () {
		$url = "#";
		if ($this->website != "") {
			$position = strpos(strtoupper($this->website),"HTTP://");
			if ($position===false)
				$url = "http://";
			else
				$url = "";
			$url .= $this->website;
		}
		return $url;
	}
	function CheckImage () {
		$BASE_DIR = $_SERVER['DOCUMENT_ROOT'] ;
		global $cfg_rootpath;
		$BASE_ROOT = $cfg_rootpath . "images/stories"; 
		$timgsrc = $BASE_DIR."/".$BASE_ROOT."/".$this->img;
		if (!file_exists("$timgsrc")) return false;
		return true;
	}
	function Out_Image ($maxwidth) {
		global $cfg_image_root;
		$objimage = new image($this->img);
		$sizeimage = $objimage->getsize();
		if (!is_array($sizeimage)) return;
		$fullwidth = $sizeimage[0];
		$fullheight = $sizeimage[1];
		$scalewidth = $maxwidth;
		if ($fullwidth < $scalewidth)
			$scalewidth = $fullwidth;
		$imgsrc = $cfg_image_root . $this->img;	
		$ext = substr($imgsrc,-3);
		$strout = "";
		if (strtoupper($ext) != "SWF")
			$strout .= "<img src='$imgsrc' width='$scalewidth' border='0' />";
		else {
			$divadv = "adv" . $this->id;
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
	function Get_Title () {
		global $lang;
		$title = $this->name;
		if ($lang=="en") $title=$this->name_en;
		return $title;
	}
	function Out_Title_Link ($leadding="") {
		$title = $this->Get_Title ();
		$url = $this->Get_Url ();
		?>
		<a href="<?php echo $url; ?>"><?php echo $title; ?></a>
		<?php
	}
	function Out_TheHien ($maxwidth) {
		$url = $this->Get_Url();
		$name = $this->Get_Title ();
		if ($url != "#") {
		?>
		<a href="<?php echo $url; ?>" target="_blank" title="<?php echo $name; ?>">
		<?php
		}
		$this->Out_Image($maxwidth);
		if ($url != "#") {
		?>
		</a>
		<?php
		}
	}
	
	function Out_Marquee ($maxwidth) {
		$url = $this->Get_Url();
		$strout  = "";
		$strout .= "<table width='100%' cellspacing='0' cellpadding='0' border='0'>";
		$strout .= "<tr><td align='center'>" . $this->Out_Image($maxwidth) . "</td></tr>";
		$strout .= "<tr><td align='center' style='font-family:Tahoma; font-size:12px; font-weight:bold; color: #FFFFFF; text-align:center; padding-top:5px;' ><a href='$url' target='_blank'>" . $this->Out_Title() . "</a></td></tr>";
		$strout .= "<tr><td align='center' style='font-family:Tahoma; font-size:11px; color: #FFFFFF; text-align:center; padding-bottom:15px;'>" . $url . "</td></tr>";
		$strout .= "</table>";
		return $strout;
	}
};
global $objadv; $objadv = new adv;
?>