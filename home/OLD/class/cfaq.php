<?php
defined ('_ALLOW') or die ('Access denied');
class faq {
	var $id;
	var $ask;
	var $ask_en;
	var $full_text;
	var $full_text_en;
	var $order;
	var $nums;
	function Doc_danh_sach ($catid="") {
		$where = "";
		if ($catid != "") {
			$where = "catid = $catid";
		}
		return $this->Fill($where);
	}
	function Fill ($strwhere="") {
		global $csdl;
		$strsql = "SELECT * FROM faqs";
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
		$kq = new faq;
		$kq->id = $rowdb['id'];
		$kq->ask = $rowdb['ask'];
		$kq->ask_en = $rowdb['ask_en'];
		$kq->full_text = $rowdb['full_text'];
		$kq->full_text_en = $rowdb['full_text_en'];
		$kq->order = $rowdb['iorder'];
		return $kq;
	}
	function Xoa () {
		checkpermission("grantfaq",1) or die ('Access denied');
		global $csdl;
		$csdl->Xoa("faqs","id=".$this->id);
	}
	function DocForm () {
		global $cfg_live_site;
		$this->id = $_REQUEST['id'];
		$this->ask = $_REQUEST['ask'];
		$this->ask_en = $_REQUEST['ask_en'];
		$this->full_text = $_REQUEST['full_text'];
		$this->full_text_en = $_REQUEST['full_text_en'];
		$this->full_text = str_replace("../","$cfg_live_site",$this->full_text);
		$this->full_text_en = str_replace("../","$cfg_live_site",$this->full_text_en);
	}
	function GetMaxOrder () {
		$strwhere = "iorder>=all";
		$strwhere .= " (SELECT iorder FROM faqs)";
		$rowarray = $this->Fill ($strwhere);
		if ($rowarray==null) return 0;
		return $rowarray[0]->order;
	}
	function Ghi () {
		checkpermission("grantfaq",1) or die ('Access denied');
		global $csdl;
		if ($this->id > -1) {
			$strsql = "UPDATE `faqs` SET ";
			$strsql .= "`ask` = '$this->ask', ";
			$strsql .= "`ask_en` = '$this->ask_en', ";
			$strsql .= "`full_text`='$this->full_text',";
			$strsql .= "`full_text_en`='$this->full_text_en'";
			$strsql .= " WHERE `id`=$this->id";
		}
		else {
			$neworder = $this->GetMaxOrder() + 1;
			$strsql = "INSERT INTO `faqs` (`ask`, `ask_en`, `full_text`, `full_text_en`, `iorder`) ";
			$strsql .= "VALUES ('$this->ask', '$this->ask_en', '$this->full_text','$this->full_text_en', $neworder)";
		}
		$csdl->Ghi($strsql);
	}
	function ChangeOrder ($neworder) {
		checkpermission("grantfaq",1) or die ('Access denied');
		global $csdl;
		$strsql = "UPDATE `faqs` SET ";
		$strsql .= "`iorder` = $neworder ";
		$strsql .= "WHERE `id`=$this->id";
		$csdl->Ghi($strsql);
	}
	function Out_TheHien_TT () {
		global $lang;
		$ask = $this->ask;
		$fulltext = $this->full_text;
		if ($lang=="en") {
			$ask = $this->ask_en;
			$fulltext = $this->full_text_en;
		}
		$dividfaq = "faq" . $this->id;
		?>
		<div class="faq_ask">
		<a href="javascript:void(0);" onclick="showhidepart('<?php echo $dividfaq; ?>')">
		<?php echo $ask; ?>
		</a>
		</div>
		<div class="faq_ans" id="<?php echo $dividfaq; ?>" style="display:none;">
		<?php echo $fulltext; ?>
		</div>
		<?php
	}
};
global $objfaq; $objfaq = new faq;
?>