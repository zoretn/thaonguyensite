<?php
defined ('_ALLOW') or die ('Access denied');
class staticcontent {
	var $id;
	var $title;
	var $title_en;
	var $title_cn;
	var $describe;
	var $tag;
	var $introtext;
	var $introtext_en;
	var $introtext_cn;
	var $nums;
	function Doc_danh_sach () {
		$where = "";
		return $this->Fill($where);
	}
	function Fill ($strwhere="") {
		global $csdl;
		$strsql = "SELECT * FROM staticcontents";
		if ($strwhere!="") {
			$strsql .= " WHERE " . $strwhere;
		}
		$strsql .= " ORDER BY id";
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
		$kq = new staticcontent;
		$kq->id = $rowdb['id'];
		$kq->title = $rowdb['title'];
		$kq->title_en = $rowdb['title_en'];
		$kq->title_cn = $rowdb['title_cn'];
		$kq->describe = $rowdb['describe'];
		$kq->tag = $rowdb['tag'];
		$kq->introtext = $rowdb['introtext'];
		$kq->introtext_en = $rowdb['introtext_en'];
		$kq->introtext_cn = $rowdb['introtext_cn'];
		return $kq;
	}
	function Xoa () {
		checkpermission("grantstatic",1) or die ('Access denied');
		global $csdl;
		$csdl->Xoa("staticcontents","id=$this->id");
	}
	function DocForm () {
		global $cfg_live_site;
		$this->id = $_REQUEST['id'];
		$this->title = $_REQUEST['title'];
		$this->title_en = $_REQUEST['title_en'];
		$this->title_cn = $_REQUEST['title_cn'];
		$this->describe = $_REQUEST['describe'];
		$this->tag = $_REQUEST['tag'];
		$this->introtext = $_REQUEST['introtext'];
		$this->introtext_en = $_REQUEST['introtext_en'];
		$this->introtext_cn = $_REQUEST['introtext_cn'];
		/*
		$this->introtext = str_replace("../","$cfg_live_site",$this->introtext);
		$this->introtext_en = str_replace("../","$cfg_live_site",$this->introtext_en);
		*/
	}
	function Ghi () {
		global $csdl;
		checkpermission("grantstatic",1) or die ('Access denied');
		if ($this->id > -1) {
			$strsql = "UPDATE staticcontents SET ";
			$strsql .= "title='$this->title', ";
			$strsql .= "title_en='$this->title_en', ";
			$strsql .= "title_cn='$this->title_cn', ";
			$strsql .= "`describe`='$this->describe', ";
			$strsql .= "tag = '$this->tag', ";
			$strsql .= "introtext='$this->introtext', ";
			$strsql .= "introtext_en='$this->introtext_en', ";
			$strsql .= "introtext_cn='$this->introtext_cn' ";
			$strsql .= "WHERE id=$this->id";
			$result = $this->id;
		}
		else {
			$strsql = "INSERT INTO staticcontents (title, title_en, title_cn, `describe`, tag, introtext, introtext_en, introtext_cn) ";
			$strsql .= "VALUES ('$this->title','$this->title_en','$this->title_cn', '$this->describe', '$this->tag','$this->introtext','$this->introtext_en','$this->introtext_cn')";
		//	echo $strsql;
		}
				//echo $strsql;
		$csdl->Ghi($strsql);
//		if ($this->id == -1) $result = mysql_insert_id($csdl->ketnoi);
		return $result;
		
	}
	function Get_Url () {
		$url = "index.php?module=com_static&id=$this->id";
		return $url;
	}
	function Out_TheHien () {
		$str="";
		$title=$this->Get_Title();
		$fulltext = $this->introtext;
		$lang=$_SESSION['lang'];
		if ($lang=="en") {
			$title = $this->title_en;
		}
		else if($lang=='cn') $title = $this->title_cn;
		else $title = $this->title;
		if ($lang=="en") {
			$fulltext = $this->introtext_en;
		}
		else if($lang=='cn') $fulltext = $this->introtext_cn;
		else $fulltext = $this->introtext;
		?>
		<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-image:url(images/banggt_07.jpg); background-repeat:repeat-y;">
	<tr>
		<td style="background-image:url(images/banggt_03.jpg); background-repeat:no-repeat;" height="30">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td style="font-family:tahoma; font-size:12px; font-weight:bold; color:#FF0000; padding-left:160px; padding-top:10px;">
						<?php
							echo $title;
						?>
					</td>
				</tr>
				<tr>
					<td class="content_view1">
						<?php
							echo $fulltext;
						?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="background-image:url(images/banggt_10.jpg); background-repeat:no-repeat;" height="21">
		</td>
	</tr>
</table>
		<?php
	}
	function Get_Title()
	{
		$lang=$_SESSION['lang'];
		$title=$this->title;
		if ($lang=="en") {
			$title=$this->title_en;
		}
		return $title;
	}
};
global $objstaticcontent; $objstaticcontent = new staticcontent;
?>
