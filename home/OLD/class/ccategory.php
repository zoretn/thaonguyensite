<?php
defined ('_ALLOW') or die ('Access denied');
class category {
	var $id;
	var $sid;
	var $title;
	var $title_en;
	var $title_cn;
	var $describe;
	var $tag;
	var $introtext;
	var $introtext_en;
	var $introtext_cn;
	var $order;
	var $nums;
	function Doc_danh_sach ($sid="") {
		$strwhere = "";
		if ($sid!="")
			$strwhere .= "sid=$sid";
		return $this->Fill ($strwhere);
	}
	function Fill ($strwhere="") {
		global $csdl;
		$strsql = "SELECT * FROM categories";
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
		$rowarray = $this->Fill ("id=$id");
		if ($rowarray==null)
			return null;
		else
			return $rowarray[0];
	}
	function Khoi_tao ($rowdb) {
		$kq = new category;
		$kq->id = $rowdb['id'];
		$kq->sid = $rowdb['sid'];
		$kq->title=$rowdb['title'];
		$kq->title_en=$rowdb['title_en'];
		$kq->title_cn=$rowdb['title_cn'];
		$kq->describe = $rowdb['describe'];
		$kq->tag = $rowdb['tag'];
		$kq->introtext = $rowdb['introtext'];
		$kq->introtext_en = $rowdb['introtext_en'];
		$kq->introtext_cn = $rowdb['introtext_cn'];
		$kq->order = $rowdb['iorder'];
		return $kq;
	}
	function Xoa () {
		checksupper() or die ("Access denied");
		global $csdl;
		$catid = $this->id;
		$strsql = "SELECT * FROM contents WHERE catid=" . $catid;
		$csdl->Truyvan($strsql);
		$numrows = $csdl->get_sodong();
		if ($numrows > 0) return 0;
		
		$strsql = "SELECT * FROM menuitem WHERE url LIKE '%module=com_content%' AND url LIKE '%task=blogcategory%' AND url LIKE '%id={$catid}%'";
		$csdl->Truyvan($strsql);
		$numrows = $csdl->get_sodong();
		if ($numrows > 0) return 0;
		
		$csdl->Xoa("categories","id=$catid");
		return 1;
	}
	function DocForm () {
		global $cfg_live_site;
		$this->id = $_REQUEST['id'];
		$this->sid = $_REQUEST['sid'];
		$this->title = $_REQUEST['title'];
		$this->describe = $_REQUEST['describe'];
		$this->tag = $_REQUEST['tag'];
		$this->title_en = $_REQUEST['title_en'];
		$this->title_cn = $_REQUEST['title_cn'];
		$this->introtext = $_REQUEST['introtext'];
		$this->introtext_en = $_REQUEST['introtext_en'];
		$this->introtext_cn = $_REQUEST['introtext_cn'];
		/*
		$this->introtext = str_replace("../","$cfg_live_site",$this->introtext);
		$this->introtext_en = str_replace("../","$cfg_live_site",$this->introtext_en);
		*/
	}
	function GetMaxOrder () {
		$strwhere = "iorder>=all";
		$strwhere .= " (SELECT iorder FROM categories)";
		$rowarray = $this->Fill ($strwhere);
		if ($rowarray==null) return 0;
		return $rowarray[0]->order;
	}
	function Ghi () {
		checksupper() or die ("Access denied");
		global $csdl;
		if ($this->id > -1) {
			$strsql = "UPDATE `categories` SET ";
			$strsql .= "`sid`=$this->sid, ";
			$strsql .= "`title`='$this->title', ";
			$strsql .= "`title_en`='$this->title_en', ";
			$strsql .= "`title_cn`='$this->title_cn', ";
			$strsql .= "`describe`='$this->describe', ";
			$strsql .= "`tag` = '$this->tag', ";
			$strsql .= "`introtext`='$this->introtext', ";
			$strsql .= "`introtext_en`='$this->introtext_en', ";
			$strsql .= "`introtext_cn`='$this->introtext_cn' ";
			$strsql .= "WHERE `id`=$this->id";
			$result = $this->id;
		}
		else {
			$neworder = $this->GetMaxOrder() + 1;
			$strsql = "INSERT INTO `categories` (`sid`, `title`, `title_en`, `title_cn`, `describe`, `tag`, `introtext`, `introtext_en`,`introtext_cn`, `iorder`) ";
			$strsql .= "VALUES ($this->sid, '$this->title','$this->title_en','$this->title_cn', '$this->describe', '$this->tag','$this->introtext','$this->introtext_en','$this->introtext_cn', $neworder)";
		}
		$csdl->Ghi($strsql);
		if ($this->id == -1) $result = mysql_insert_id($csdl->ketnoi);
		return $result;

	}
	function ChangeOrder ($neworder) {
		checksupper() or die ("Access denied");
		global $csdl;
		$strsql = "UPDATE categories SET ";
		$strsql .= "iorder = $neworder ";
		$strsql .= "WHERE id=$this->id";
		$csdl->Ghi($strsql);
	}
	function Get_Title () {
		global $lang;
		if ($lang=="vn") {
			return $this->title;
		}
		else if($lang=="en") {
			return $this->title_en;
		}
		else {
			return $this->title_cn;
		}
	}
	function Get_Intro () {
		global $lang;
		if ($lang=="vn") {
			return $this->introtext;
		}
		else if ($lang=="en"){
			return $this->introtext_en;
		}
		else {
			return $this->introtext_cn;
		}
	}
	function Get_Url () {
		$catid = $this->id;
		$url = "index.php?module=com_content&task=blogcategory&id=$catid";
		global $csdl;
		$strsql = "SELECT * FROM menuitem WHERE url LIKE '%module=com_content%' AND url LIKE '%task=blogcategory%' AND url LIKE '%id={$catid}%'";
		$rowsdb = $csdl->Truyvan($strsql);
		if ($rowsdb != null)
			while ($rowdb = mysql_fetch_array($rowsdb,MYSQL_ASSOC)) {
				$menuitemid = $rowdb['id'];
				$url .= "&Itemid=" . $menuitemid;
				break;
			}
		return $url;
	}
	function Out_Title_Link ($leadding="") {
		$title = $this->Get_Title();
		$url = $this->Get_Url ();
		?>
		<a href="<?php echo $url; ?>"><?php echo $title; ?></a>
		<?php
	}
	function Out_TheHien_TT ($maxwidth="") {
		global $lang;
		$intro=$this->Get_Intro();
		$title=$this->Get_Title();
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_content_tt">
		<tr><td class="title_content"><?php $this->Out_Title_Link(); ?></td></tr>
		<tr><td class="intro_content"><?php echo $intro; ?></td></tr>
		</table>
		<?php
	}
};
global $objcategory; $objcategory = new category;
?>