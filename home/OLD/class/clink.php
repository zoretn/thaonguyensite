<?php
defined ('_ALLOW') or die ('Access denied');
class link {
	var $id;
	var $title;
	var $title_en;
	var $title_cn;
	var $address;
	var $nums;
	function Doc_danh_sach () {
		$where = "";
		return $this->Fill($where);
	}
	function Fill ($strwhere="") {
		global $csdl;
		$strsql = "SELECT * FROM links";
		if ($strwhere!="") {
			$strsql .= " WHERE " . $strwhere;
		}
		$strsql .= " ORDER BY title, title_en";
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
		$rowarray = $this->Fill ("id=$id");
		if ($rowarray==null)
			return null;
		else
			return $rowarray[0];
	}
	function Khoi_tao ($rowdb) {
		$kq = new link;
		$kq->id = $rowdb['id'];
		$kq->title = $rowdb['title'];
		$kq->title_en = $rowdb['title_en'];
		$kq->title_cn = $rowdb['title_cn'];
		$kq->address = $rowdb['address'];
		return $kq;
	}
	function Xoa () {
		checkpermission("grantlink",1) or die ('Access denied');
		global $csdl;
		$csdl->Xoa("links","id=".$this->id);
	}
	function DocForm () {
		$this->id = $_REQUEST['id'];
		$this->title = $_REQUEST['title'];
		$this->title_en = $_REQUEST['title_en'];
		$this->title_cn = $_REQUEST['title_cn'];
		$this->address = $_REQUEST['address'];
	}
	function Ghi () {
		checkpermission("grantlink",1) or die ('Access denied');
		global $csdl;
		if ($this->id > -1) {
			$strsql = "UPDATE `links` SET ";
			$strsql .= "`title`='$this->title',";
			$strsql .= "`title_en`='$this->title_en',";
			$strsql .= "`title_cn`='$this->title_cn',";
			$strsql .= "`address`='$this->address' ";
			$strsql .= "WHERE `id`=$this->id";
		}
		else {
			$strsql = "INSERT INTO `links` (`title`, `title_en`, `title_cn`, `address`) ";
			$strsql .= "VALUES ('$this->title','$this->title_en','$this->title_cn','$this->address')";
		}
		$csdl->Ghi($strsql);
	}
	function Get_Url () {
		$position = strpos(strtoupper($this->address),"HTTP://");
		if ($position===false)
			$url = "http://";
		else
			$url = "";
		$url .= $this->address;
		return $url;
	}
	function Get_Title () {
		global $lang;
		$title = $this->title;
		if ($lang=="en") $title = $this->title_en;
		else if($lang=='cn') $title =$this->title_cn;
		return $title;
	}
};
global $objlink; $objlink = new link;
?>