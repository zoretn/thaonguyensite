<?php
defined ('_ALLOW') or die ('Access denied');
class productsection {
	var $id;
	var $title;
	var $title_en;
	var $title_cn;
	var $describe;
	var $order;
	var $nums;
	function Doc_danh_sach () {
		return $this->Fill ();
	}
	function Fill ($strwhere="") {
		global $csdl;
		$strsql = "SELECT * FROM productsections";
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
		$kq = new productsection;
		$kq->id = $rowdb['id'];
		$kq->title = $rowdb['title'];
		$kq->title_en = $rowdb['title_en'];
		$kq->title_cn = $rowdb['title_cn'];
		$kq->describe = $rowdb['describe'];
		$kq->order = $rowdb['iorder'];
		return $kq;
	}
	function Xoa () {
		checksupper() or die ("Access denied");
		global $csdl;
		$strsql = "SELECT * FROM productcategories WHERE sid=" . $this->id;
		$csdl->Truyvan($strsql);
		$numrows=$csdl->get_sodong();
		if ($numrows > 0) return 0;
		$csdl->Xoa("productsections","id=$this->id");
		return 1;
	}
	function DocForm () {
		$this->id = $_REQUEST['id'];
		$this->title = $_REQUEST['title'];
		$this->title_en = $_REQUEST['title_en'];
		$this->title_cn = $_REQUEST['title_cn'];
		$this->describe = $_REQUEST['describe'];
	}
	function GetMaxOrder () {
		$strwhere = "iorder>=all";
		$strwhere .= " (SELECT iorder FROM productsections)";
		$rowarray = $this->Fill ($strwhere);
		if ($rowarray==null) return 0;
		return $rowarray[0]->order;
	}
	function Ghi () {
		checksupper() or die ("Access denied");
		global $csdl;
		if ($this->id > -1) {
			$strsql = "UPDATE `productsections` SET ";
			$strsql .= "`title`='$this->title',";
			$strsql .= "`title_en`='$this->title_en', ";
			$strsql .= "`title_cn`='$this->title_cn', ";
			$strsql .= "`describe`='$this->describe' ";
			$strsql .= "WHERE `id`=$this->id";
		}
		else {
			$neworder = $this->GetMaxOrder() + 1;
			$strsql = "INSERT INTO `productsections` (`title`,`title_en`,`title_cn`, `describe`, `iorder`) ";
			$strsql .= "VALUES ('$this->title','$this->title_en','$this->title_cn', '$this->describe', $neworder)";
		}
		$csdl->Ghi($strsql);
	}
	function ChangeOrder ($neworder) {
		checksupper() or die ("Access denied");
		global $csdl;
		$strsql = "UPDATE `productsections` SET ";
		$strsql .= "`iorder` = $neworder ";
		$strsql .= "WHERE `id`=$this->id";
		$csdl->Ghi($strsql);
	}
	function Get_Title () {
		global $lang;
		if ($lang=="vn") {
			return $this->title;
		}
		else if ($lang=='en') {
			return $this->title_en;
		}
		else {
			return $this->title_cn;
		}
	}
	function Get_Url () {
		$url = "index.php?module=com_product&task=blocsection&id=$this->id";
		if (isset($_GET['Itemid'])) {
			$titemid = $_GET['Itemid'];
			$url .= "&Itemid=" . $titemid;
		}
		return $url;
	}
	function Out_Title_Link () {
		$url = $this->Get_Url();
		$title = $this->Get_Title();
		?>
		<a href="<?php echo $url; ?>">
		<?php echo $title; ?>
		</a>
        <?php
	}
};
global $objproductsection; $objproductsection = new productsection;
?>