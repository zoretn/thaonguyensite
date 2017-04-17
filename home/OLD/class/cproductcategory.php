<?php
defined ('_ALLOW') or die ('Access denied');
class productcategory {
	var $id;
	var $sid;
	var $title;
	var $title_en;
	var $title_cn;
	var $describe;
	var $introtext;
	var $introtext_en;
	var $introtext_cn;
	var $image="";
	var $tag;
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
		$strsql = "SELECT * FROM productcategories";
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
		$kq = new productcategory;
		$kq->id = $rowdb['id'];
		$kq->sid = $rowdb['sid'];
		$kq->title=$rowdb['title'];
		$kq->title_en=$rowdb['title_en'];
		$kq->title_cn=$rowdb['title_cn'];
		$kq->describe = $rowdb['describe'];
		$kq->introtext = $rowdb['introtext'];
		$kq->introtext_en = $rowdb['introtext_en'];
		$kq->introtext_cn = $rowdb['introtext_cn'];
		$kq->image = $rowdb['image'];
		$kq->tag = $rowdb['tag'];
		$kq->order = $rowdb['iorder'];
		return $kq;
	}
	function Xoa () {
		checksupper() or die ("Access denied");
		global $csdl;
		$strsql = "SELECT * FROM products WHERE catid=" . $this->id;
		$csdl->Truyvan($strsql);
		$numrows = $csdl->get_sodong();
		if ($numrows > 0) return 0;	
		$csdl->Xoa("productcategories","id=$this->id");
		$catid = $this->id;
		$csdl->Xoa("menuitem","url LIKE '%module=com_product%' AND url LIKE '%task=blogcategory%' AND url LIKE '%id={$catid}%'");
		return 1;
	}
	function DocForm () {
		$this->id = $_REQUEST['id'];
		$this->sid = $_REQUEST['sid'];
		$this->title = $_REQUEST['title'];
		$this->title_en = $_REQUEST['title_en'];
		$this->title_cn = $_REQUEST['title_cn'];
		$this->describe = $_REQUEST['describe'];
		$this->introtext = $_REQUEST['introtext'];
		$this->introtext_en = $_REQUEST['introtext_en'];
		$this->introtext_cn = $_REQUEST['introtext_cn'];
		$this->image = $_REQUEST['image'];
		$this->tag = $_REQUEST['tag'];
	}
	function GetMaxOrder () {
		$strwhere = "iorder>=all";
		$strwhere .= " (SELECT iorder FROM productcategories)";
		$rowarray = $this->Fill ($strwhere);
		if ($rowarray==null) return 0;
		return $rowarray[0]->order;
	}
	function Ghi () {
		checksupper() or die ("Access denied");
		global $csdl;
		if ($this->id > -1) {
			$strsql = "UPDATE `productcategories` SET ";
			$strsql .= "`sid`=$this->sid, ";
			$strsql .= "`title`='$this->title', ";
			$strsql .= "`title_en`='$this->title_en', ";
			$strsql .= "`title_cn`='$this->title_cn', ";
			$strsql .= "`introtext`='$this->introtext', ";
			$strsql .= "`introtext_en`='$this->introtext_en', ";
			$strsql .= "`introtext_cn`='$this->introtext_cn', ";
			$strsql .= "`describe`='$this->describe', ";
			$strsql .= "`image`='$this->image', ";
			$strsql .= "`tag` = '$this->tag' ";
			$strsql .= "WHERE `id`=$this->id";
			$result = $this->id;
		}
		else {
			$neworder = $this->GetMaxOrder() + 1;
			$strsql = "INSERT INTO `productcategories` (`sid`, `title`, `title_en`, `title_cn`, `describe`, `introtext`, `introtext_en`, `introtext_cn`, `image`, `tag`, `iorder`) ";
			$strsql .= "VALUES ($this->sid, '$this->title','$this->title_en','$this->title_cn', '$this->describe', '$this->introtext','$this->introtext_en','$this->introtext_cn', '$this->image', '$this->tag', $neworder)";
		}		
		$csdl->Ghi($strsql);
		if ($this->id == -1) $result = mysql_insert_id($csdl->ketnoi);
		return $result;
	}
	function Out_Image ($maxwidth) {
		global $cfg_image_root;
		$objimage = new image($this->image);
		$sizeimage = $objimage->getsize();
		if (!is_array($sizeimage)) return;
		$fullwidth = $sizeimage[0];
		$scalewidth = $maxwidth;
		if ($fullwidth < $scalewidth)
			$scalewidth = $fullwidth;
		$imgsrc = $cfg_image_root . $this->image;
		?>
		<img src="<?php echo $imgsrc; ?>" width="<?php echo $scalewidth; ?>" align="left" border="0" style="margin-right:15px; margin-bottom:5px;"  />
		<?php
	}
	function ChangeOrder ($neworder) {
		checksupper() or die ("Access denied");
		global $csdl;
		$strsql = "UPDATE `productcategories` SET ";
		$strsql .= "`iorder` = $neworder ";
		$strsql .= "WHERE `id`=$this->id";
		$csdl->Ghi($strsql);
	}
	function Get_Title () {
		global $lang;
		if ($lang=="vn") {
			return $this->title;
		}
		else if ($lang=="en"){
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
		else if($lang=="en"){
			return $this->introtext_en;
		}
		else {
			return $this->introtext_cn;
		}
	}
	function Get_Url () {
		$catid = $this->id;
		$url = "index.php?module=com_product&task=blogcategory&id=$catid";
		global $csdl;
		$strsql = "SELECT * FROM menuitem WHERE url LIKE '%module=com_product%' AND url LIKE '%task=blogcategory%' AND url LIKE '%id={$catid}%'";
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
		$intro=$this->Get_Intro();
		?>
		<div class="title_content"><?php $this->Out_Title_Link(); ?></div>
        <div><?php $this->Out_Image($maxwidth); ?></div>
		<div class="intro_content"><?php echo $intro; ?></div>
		<?php
	}
	function Out_TheHien ($maxwidth="") {
		$intro = $this->Get_Intro();
		$title = $this->Get_Title();
		?>
        <div class="title_productcategory"><?php echo $title; ?></div>
        <div class="intro_content_view"><?php echo $intro; ?></div>
        <?php
	}
};
global $objproductcategory; $objproductcategory = new productcategory;
?>