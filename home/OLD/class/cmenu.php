<?php
defined("_ALLOW") or die ("Access denied");
?>
<?php
class menu {
	var $id;
	var $title;
	var $title_en;
	var $title_cn;
	var $describe;
	var $bulletitem;
	var $position;
	var $style;
	var $hidetitle;
	var $showin;
	var $iorder;
	function Doc ($id) {
		$rowarray = $this->Fill ("id=$id");
		if ($rowarray==null)
			return null;
		else
			return $rowarray[0];
	}
	function Doc_danh_sach () {
		$strwhere = "";
		return $this->Fill ($strwhere);
	}
	function Fill ($strwhere) {
		global $csdl;
		$strsql = "SELECT * FROM menu";
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
	function Khoi_tao ($rowdb) {
		$kq = new menu;
		$kq->id = $rowdb['id'];
		$kq->title=$rowdb['title'];
		$kq->title_en=$rowdb['title_en'];
		$kq->title_cn=$rowdb['title_cn'];
		$kq->describe = $rowdb['describe'];
		$kq->bulletitem = $rowdb['bulletitem'];
		$kq->style = $rowdb['style'];
		$kq->position = $rowdb['position'];
		$kq->hidetitle = $rowdb['hidetitle'];
		$kq->showin = $rowdb['showin'];
		$kq->order = $rowdb['iorder'];
		return $kq;
	}
	function Xoa () {
		checksupper() or die ("Access denied");
		global $csdl;
		$strsql = "SELECT * FROM menuitem WHERE menu=" . $this->id;
		$csdl->Truyvan($strsql);
		$numrows = $csdl->get_sodong();
		if ($numrows > 0) return 0;
		$csdl->Xoa("menu","id=$this->id");
		return 1;
	}
	function DocForm () {
		$this->id = $_REQUEST['id'];
		$this->title = $_REQUEST['title'];
		$this->title_en = $_REQUEST['title_en'];
		$this->title_cn = $_REQUEST['title_cn'];
		$this->describe = $_REQUEST['describe'];
		$this->bulletitem = $_REQUEST['bulletitem'];
		$this->style = $_REQUEST['style'];
		$this->position = $_REQUEST['position'];
		$this->hidetitle = 0;
		if (isset($_REQUEST['hidetitle']))
		$this->hidetitle = 1;
		if (isset($_REQUEST['showin'])) {
			$this->showin = "#";
			$arrayshowin = $_REQUEST['showin'];
			foreach ($arrayshowin as $ishowin)
				$this->showin .= $ishowin . "#";
			if ($this->showin == "##") $this->showin = "";
		}
	}
	function GetMaxOrder () {
		$strwhere = "iorder>=all";
		$strwhere .= " (SELECT iorder FROM menu)";
		$rowarray = $this->Fill ($strwhere);
		if ($rowarray==null) return 0;
		return $rowarray[0]->order;
	}
	function ChangeOrder ($neworder) {
		checksupper() or die ("Access denied");
		global $csdl;
		$strsql = "UPDATE `menu` SET ";
		$strsql .= "`iorder` = $neworder ";
		$strsql .= "WHERE `id` = $this->id";
		$csdl->Ghi($strsql);
	}
	function Ghi () {
		checksupper() or die ("Access denied");
		global $csdl;
		if ($this->id > -1) {
			$strsql = "UPDATE `menu` SET ";
			$strsql .= "`title`='$this->title', ";
			$strsql .= "`title_en`='$this->title_en', ";
			$strsql .= "`title_cn`='$this->title_cn', ";
			$strsql .= "`describe`='$this->describe', ";
			$strsql .= "`bulletitem`='$this->bulletitem', ";
			$strsql .= "`style`=$this->style, ";
			$strsql .= "`position`='$this->position', ";
			$strsql .= "`hidetitle`=$this->hidetitle, ";
			$strsql .= "`showin`='$this->showin' ";
			$strsql .= "WHERE `id`=$this->id";
		}
		else {
			$neworder = $this->GetMaxOrder() + 1;
			$strsql = "INSERT INTO `menu` (`title`, `title_en`, `title_cn`, `describe`, `bulletitem`, `style`, `position`, `hidetitle`, `showin`, `iorder`) ";
			$strsql .= "VALUES ('$this->title','$this->title_en','$this->title_cn', '$this->describe','$this->bulletitem', $this->style, '$this->position', $this->hidetitle, '$this->showin', $neworder)";
		}
//		echo $strsql;
		$csdl->Ghi($strsql);
	}
	function Get_Title () {
		global $lang;
		
		if ($lang=="en") $title = $this->title_en;
		else if ($lang=="cn") $title = $this->title_cn;
		else $title = $this->title;
		return $title;
	}
	function Out_TheHien () {
		global $cfg_image_root;
		global $objmenuitem;
		$title = $this->Get_Title();
		$arraymenuitem = $objmenuitem->Doc_danh_sach($this->id);
		$urlbullet = "";
		if ($this->bulletitem != "") $urlbullet = "$cfg_image_root" . "$this->bulletitem";
		switch ($this->style) {
			case 1://vertical
	?>
			<table class="table_menu" border="0" cellspacing="0" cellpadding="0">
			<?php
			if ($this->hidetitle==0) {
			?>
				<tr><td class="title_menu"><?php echo $title; ?></td></tr>
			<?php
			}
			if (is_array($arraymenuitem)) {
				$count = count($arraymenuitem);
				for ($i=0; $i<$count; $i++) {
					$objmenuitem = $arraymenuitem[$i];
			?>
					<tr><td class="menu_item"><?php $objmenuitem->Out_TheHien($urlbullet); ?></td></tr>
			<?php
				}
			}
			?>
			</table>
	<?php
			break;
			case 0://horizonal
	?>
			<table class="table_menu" border="0" cellspacing="0" cellpadding="0"><tr>
			<?php
			if ($this->hidetitle==0) {
			?>
			<td class="title_menu"><?php echo $title; ?></td>
			<?php
			}
			if (is_array($arraymenuitem)) {
				$count = count($arraymenuitem);
				for ($i=0; $i<$count; $i++) {
					$objmenuitem = $arraymenuitem[$i];
			?>
			<td class="menu_item"><?php $objmenuitem->Out_TheHien($urlbullet);  ?></td>
			<?php
				}
			}
			?>
			</tr></table>
	<?php
			break;
			default:
	?>
			<ul class="table_menu">
			<?php
			if ($this->hidetitle==0) {
			?>
				<li class="title_menu"><?php echo $title; ?></li>
			<?php
			}
			if (is_array($arraymenuitem)) {
				$count = count($arraymenuitem);
				for ($i=0; $i<$count; $i++) {
					$objmenuitem = $arraymenuitem[$i];
			?>
					<li class="menu_item"><?php $objmenuitem->Out_TheHien($urlbullet); ?></li>
			<?php
				}
			}
			?>
			</ul>
	<?php
		}
	}
	
	function Out_TheHien2 ($cmThemeOffice, $ThemeOffice) {
		$title = $this->Get_Title();
		$strout  = "";
		$menuid = $this->id;
		global $objmenuitem;
		$arraymenuitem = $objmenuitem->Fill("menu = $menuid AND parentid = 0");
		$strout .= "<script language=\"javascript\">";
		$strout .= "var myMenu$menuid = [";
		if (is_array($arraymenuitem)) {
			$isactive = false;
			foreach ($arraymenuitem as $objmenuitem) {
				$isactive = $objmenuitem->Check_ActiveMain();
				$strout .= $objmenuitem->Out_TheHien2($isactive);
			}
		}
		$strout .= "];";
		if ($this->style == 1)
			$strout .= "cmDraw ('myMenuID$menuid', myMenu$menuid, 'vbr', $cmThemeOffice, '$ThemeOffice');";
		else
			$strout .= "cmDraw ('myMenuID$menuid', myMenu$menuid, 'hbr', $cmThemeOffice, '$ThemeOffice');";
		$strout .= "</script>";
		echo $strout;
	}
};
global $objmenu; $objmenu = new menu;
?>