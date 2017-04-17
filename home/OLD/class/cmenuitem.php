<?php
defined("_ALLOW") or die ("Access denied");
?>
<?php
class menuitem {
	var $id;
	var $parenid;
	var $menu;
	var $title;
	var $title_en;
	var $title_cn;
	var $describe;
	var $url;
	var $sublevel;
	var $type;
	var $param;
	var $order;
	function Doc ($id) {
		$rowarray = $this->Fill ("id=$id");
		if ($rowarray==null)
			return null;
		else
			return $rowarray[0];
	}
	function Doc_danh_sach ($menuid="") {
		$strwhere = "";
		if ($menuid != "") $strwhere = "menu=$menuid";
		return $this->Fill ($strwhere);
	}
	function Fill ($strwhere) {
		global $csdl;
		$strsql = "SELECT * FROM menuitem";
		if ($strwhere!="") {
			$strsql .= " WHERE " . $strwhere;
		}
		$strsql .= " ORDER BY parentid, iorder, id";
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
	function Get_ArrayMenuItem (&$array, $menu, $prex="") {
		$strwhere = "menu = $menu";
		if ($prex == "")
			$strwhere .= " AND parentid = 0";
		else {
			if ($this->parentid == 0) {
				$array[]['title'] = $this->title . " (" . $this->describe . ")";
				$count = count($array);
				$array[$count-1]['prex'] = "";
				$prex = "";
			}
			else {
				$array[]['title'] = $this->title . " (" . $this->describe . ")";
				$count = count($array);
				$array[$count-1]['prex'] = $prex . "∟ ";
			}
			$array[$count-1]['linkmenuitem'] = "index.php?module=com_menu&task=edit&id=" . $this->id . "&menu_menuitem=" . $this->menu . "&type=" . $this->type;
			$array[$count-1]['order'] = $this->order;
			$array[$count-1]['id'] = $this->id;
			$array[$count-1]['url'] = $this->url;
			$strwhere .= " AND parentid = $this->id";
		}
		$arraysubitem = $this->Fill($strwhere);
		if (is_array($arraysubitem)) {
			$prex .= "&nbsp;&nbsp;&nbsp;&nbsp;";
			foreach ($arraysubitem as $subitem)
				$subitem->Get_ArrayMenuItem ($array, $menu, $prex);
		}
	}
	function Get_ArraySubItem (&$array, $currentid, $prex="") {
		if ($prex == "")
			$strwhere = "menu = $this->menu AND parentid = 0";
		else {
			$array[]['title'] = $prex . "∟ " . $this->title . "(" . $this->describe . ")";
			$count = count($array);
			$array[$count-1]['value'] = $this->id . "#" . $this->sublevel;
			$strwhere = "parentid = $this->id";
		}
		if ($currentid > 0)
			$strwhere .= " AND id <> $currentid";
		$arraysubitem = $this->Fill($strwhere);
		if (is_array($arraysubitem)) {
			$prex .= "&nbsp;&nbsp;";
			foreach ($arraysubitem as $subitem)
				$subitem->Get_ArraySubItem ($array, $currentid, $prex);
		}
	}
	function Khoi_tao ($rowdb) {
		$kq = new menuitem;
		$kq->id = $rowdb['id'];
		$kq->parentid = $rowdb['parentid'];
		$kq->menu = $rowdb['menu'];
		$kq->title=$rowdb['title'];
		$kq->title_en=$rowdb['title_en'];
		$kq->title_cn=$rowdb['title_cn'];
		$kq->describe = $rowdb['describe'];
		$kq->url = $rowdb['url'];
		$kq->sublevel = $rowdb['sublevel'];
		$kq->order = $rowdb['iorder'];
		$kq->type = $rowdb['type'];
		return $kq;
	}
	function Xoa () {
		checksupper() or die ("Access denied");
		global $csdl;
		$csdl->Xoa("menuitem","id=$this->id OR parentid=$this->id");
		return 1;
	}
	function DocForm () {
		$this->id = $_REQUEST['id_menuitem'];
		$this->parentid = $_REQUEST['parentid_menuitem'];
		$this->menu = $_REQUEST['menu_menuitem'];
		$this->title = $_REQUEST['title_menuitem'];
		$this->title_en = $_REQUEST['title_en_menuitem'];
		$this->title_cn = $_REQUEST['title_cn_menuitem'];
		$this->describe = $_REQUEST['describe_menuitem'];
		$this->url = $_REQUEST['url_menuitem'];
		$this->sublevel = $_REQUEST['sublevel_menuitem'];
		$this->type = $_REQUEST['type_menuitem'];
		$this->param = "";
		if (isset($_REQUEST['param_menuitem']))
		$this->param = $_REQUEST['param_menuitem'];
	}
	function Copy ($menu) {
		checksupper() or die ("Access denied");
		global $csdl;
		$neworder = $this->GetMaxOrder() + 1;
		$strsql = "INSERT INTO `menuitem` (`parentid`, `menu`, `title`, `title_en`, `title_cn`, `url`, `sublevel`, `iorder`, `type`, `param`) ";
		$strsql .= "VALUES (0, $menu, '$this->title','$this->title_en','$this->title_cn','$this->url', 0, $neworder, '$this->type', '$this->param')";
		$csdl->Ghi($strsql);
	}
	function GetMaxOrder () {
		$strwhere = "iorder>=all";
		$strwhere .= " (SELECT iorder FROM menuitem)";
		$rowarray = $this->Fill ($strwhere);
		if ($rowarray==null) return 0;
		return $rowarray[0]->order;
	}
	function Ghi () {
		checksupper() or die ("Access denied");
		global $csdl;
		if ($this->id > -1) {
			$strsql = "UPDATE `menuitem` SET ";
			$strsql .= "`parentid`=$this->parentid, ";
			$strsql .= "`title`='$this->title', ";
			$strsql .= "`title_en`='$this->title_en', ";
			$strsql .= "`title_cn`='$this->title_cn', ";
			$strsql .= "`describe`='$this->describe', ";
			$strsql .= "`url`='$this->url', ";
			$strsql .= "`sublevel` = $this->sublevel, ";
			$strsql .= "`param` = '$this->param' ";
			$strsql .= "WHERE `id`=$this->id";
		}
		else {
			$neworder = $this->GetMaxOrder() + 1;
			$strsql = "INSERT INTO `menuitem` (`parentid`, `menu`, `title`, `title_en`, `title_cn`, `describe`, `url`, `sublevel`, `iorder`, `type`, `param`) ";
			$strsql .= "VALUES ($this->parentid, $this->menu, '$this->title', '$this->title_en', '$this->title_cn','$this->describe','$this->url', $this->sublevel, $neworder, '$this->type', '$this->param')";
		}
//		echo $strsql;
		$csdl->Ghi($strsql);
	}
	function ChangeOrder ($neworder) {
		checksupper() or die ("Access denied");
		global $csdl;
		$strsql = "UPDATE `menuitem` SET ";
		$strsql .= "`iorder` = $neworder ";
		$strsql .= "WHERE `id`=$this->id";
		$csdl->Ghi($strsql);
	}
	function Get_Title () {
		global $lang;
		
		if ($lang=="en") $title = $this->title_en;
		else if ($lang=="cn") $title = $this->title_cn;
		else $title = $this->title;
		return $title;
	}
	function Get_Url () {
		$url = $this->url;
		if ($url != "null") {
			if (strpos($url,"?") > 0)
				$url .= "&Itemid=" . $this->id;
			else
				$url .= "?Itemid=" . $this->id;
		}
		return $url;
	}
	function Get_Url2 () {
		return $this->url;
	}
	function Out_TheHien ($urlbullet="") {
		$title = $this->Get_Title();
		$active = "";
		$url = $this->Get_Url();
		if ($url == null) $url = "javascript:;";
		if (isset($_GET['Itemid'])) {
			if ($this->id == $_GET['Itemid']) $active = "id='active'";
		}
		if ($urlbullet != "") {
		?>
		<img src="<?php echo $urlbullet; ?>" border="0" align="absmiddle" />
		<?php
		}
		?>
		<a href="<?php echo $url; ?>" class="a_menu_item" <?php echo $active; ?> ><?php echo $title; ?></a>
		<?php
	}
	function Check_ActiveMain() {
		$result = false;
		global $glb_Itemid;
		if ($this->id == $glb_Itemid) {
			return true;
		}
		$strwhere = "(parentid=" . $this->id . ")";
		$arraysub = $this->Fill($strwhere);
		if (is_array($arraysub)) {
			foreach ($arraysub as $objmenuitem) {
				if ($objmenuitem->Check_ActiveMain()) {
					return true;
				}
			}
		}
		return $result;
	}
	function Out_TheHien2 ($isactive = false) {
		$strout  = "";
		$stractive = "null";
		if ($isactive) $stractive = "'1'";
		$url = $this->Get_Url();
		$title = $this->Get_Title();
		if ($url != "null")
			$strout .= "[null, '$title', '$url', $stractive, '$title'";
		else
			$strout .= "[null, '$title', null, $stractive, '$title'";
		$arraysubmenuitem = $this->Fill("parentid = $this->id");
		if (is_array($arraysubmenuitem)) {
			$strout .= ", ";
			foreach ($arraysubmenuitem as $objmenuitem) {
				$myactive = $objmenuitem->Check_ActiveMain();
				$strout .= $objmenuitem->Out_TheHien2($myactive);
			}
		}
		$strout .= "],";
		return $strout;
	}
};
global $objmenuitem; $objmenuitem = new menuitem;
?>