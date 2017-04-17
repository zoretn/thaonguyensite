<?php
defined ('_ALLOW') or die ('Access denied');
class content {
	var $id;
	var $sid;
	var $catid;
	var $title;
	var $title_en;
	var $title_cn;
	var $describe;
	var $tag;
	var $introtext;
	var $introtext_en;
	var $introtext_cn;
	var $full_text;
	var $full_text_en;
	var $full_text_cn;
	var $image="";
	var $imageposition;
	var $order;
	var $ttime;
	var $fttime;
	var $lastupdate;
	var $flastupdate;
	var $createby;
	var $hints;
	var $nums;
	var $lang;
	function Doc_danh_sach ($catid, $count, $begin=0) {
		$where = "";
		if ($catid != "") {
			$where = "catid = $catid";
		}
		return $this->Fill($where, $count, $begin);
	}
	function CountFill ($strwhere) {
		global $csdl;
		$strsql = "SELECT COUNT(*) as count FROM contents";
		if ($strwhere != "")
			$strsql .= " WHERE " . $strwhere;
		$rowsdb = $csdl->Truyvan($strsql);
		$rowdb = mysql_fetch_array($rowsdb,MYSQL_ASSOC);
		$count = $rowdb['count'];
		return $count;
	}
	function Fill ($strwhere, $count, $begin=0) {
		global $csdl;
		global $lang;
		$strformatdate = "%H:%i %d/%m/%Y";
		if ($lang=="en") $strformatdate = "%H:%i %m/%d/%Y";
		$strsql = "SELECT *, DATE_FORMAT(time,'$strformatdate') as ftime, DATE_FORMAT(lastupdate,'$strformatdate') as flastupdate FROM contents";
		if ($strwhere!="") {
			$strsql .= " WHERE " . $strwhere;
		}
		$strsql .= " ORDER BY iorder , id";
		$strsql .= " LIMIT $begin, $count";
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
		$rowarray = $this->Fill ("id=$id", 1, 0);
		if ($rowarray==null)
			return null;
		else
			return $rowarray[0];
	}
	function CheckSearch ($keyword) {
		if ($keyword=="") return false;
		$strwhere = "";
		$strwhere .= "(";
		$strwhere .= "lower(title) LIKE lower('%" . $keyword . "%') ";
		$strwhere .= "OR lower(title_en) LIKE lower('%" . $keyword . "%') ";
		$strwhere .= "OR lower(introtext) LIKE lower('%" . $keyword . "%') ";
		$strwhere .= "OR lower(introtext_en) LIKE lower('%" . $keyword . "%') ";
		$strwhere .= "OR lower(full_text) LIKE lower('%" . $keyword . "%') ";
		$strwhere .= "OR lower(full_text_en) LIKE lower('%" . $keyword . "%')";
		$strwhere .= ")";
		return $this->Fill($strwhere);
	}
	function Doc_danh_sach_s ($sid="", $count, $begin=0) {
		$where = "";
		if ($sid != "") {
			$where = "sid = $sid";
		}
		return $this->Fill($where, $count, $begin);
	}
	function Khoi_tao ($rowdb) {
		$kq = new content;
		$kq->id = $rowdb['id'];
		$kq->sid = $rowdb['sid'];
		$kq->catid = $rowdb['catid'];
		$kq->title = $rowdb['title'];
		$kq->title_en = $rowdb['title_en'];
		$kq->title_cn = $rowdb['title_cn'];
		$kq->describe = $rowdb['describe'];
		$kq->tag = $rowdb['tag'];
		$kq->introtext = $rowdb['introtext'];
		$kq->introtext_en = $rowdb['introtext_en'];
		$kq->introtext_cn = $rowdb['introtext_cn'];
		$kq->full_text = $rowdb['full_text'];
		$kq->full_text_en = $rowdb['full_text_en'];
		$kq->full_text_cn = $rowdb['full_text_cn'];
		$kq->image = $rowdb['image'];
		$kq->imageposition = $rowdb['imageposition'];
		$kq->order = $rowdb['iorder'];
		$kq->ttime = $rowdb['time'];
		$kq->lastupdate = $rowdb['lastupdate'];
		$kq->fttime = $rowdb['ftime'];
		$kq->flastupdate = $rowdb['flastupdate'];
		$kq->createby = $rowdb['createby'];
		
		$kq->ttime = substr($kq->ttime,0,16);
		$kq->lastupdate = substr($kq->lastupdate,0,16);
		return $kq;
	}
	function Xoa () {
		checkpermission("grantcat",$this->catid) or die ('Access denied');
		global $csdl;
		$csdl->Xoa("contents","id=$this->id");
	}
	function DocForm () {
		$this->id = $_REQUEST['id'];
		$this->sid = $_REQUEST['sid'];
		$this->catid = $_REQUEST['catid'];
		$this->title = $_REQUEST['title'];
		$this->title_en = $_REQUEST['title_en'];
		$this->title_cn = $_REQUEST['title_cn'];
		$this->describe = $_REQUEST['describe'];
		$this->tag = $_REQUEST['tag'];
		$this->introtext = $_REQUEST['introtext'];
		$this->introtext_en = $_REQUEST['introtext_en'];
		$this->introtext_cn = $_REQUEST['introtext_cn'];
		$this->full_text = $_REQUEST['full_text'];
		$this->full_text_en = $_REQUEST['full_text_en'];
		$this->full_text_cn = $_REQUEST['full_text_cn'];
		$this->image = $_REQUEST['image'];
		$this->imageposition = $_REQUEST['imageposition'];
		$this->ttime = $_REQUEST['time'];
		$this->ttime = substr($this->ttime,0,10);
		$tnow = getdate();
		$hour = $tnow['hours'];
		$minute = $tnow['minutes'];
		$second = $tnow['seconds'];
		$this->ttime .= " $hour" . ":" . $minute . ":" . $second;
		$this->lastupdate = $this->ttime;
		/*
		$this->introtext = str_replace("../","$cfg_live_site",$this->introtext);
		$this->introtext_en = str_replace("../","$cfg_live_site",$this->introtext_en);
		$this->full_text = str_replace("../","$cfg_live_site",$this->full_text);
		$this->full_text_en = str_replace("../","$cfg_live_site",$this->full_text_en);
		*/
	}
	function GetMaxOrder () {
		$strwhere = "iorder>=all";
		$strwhere .= " (SELECT iorder FROM contents)";
		$rowarray = $this->Fill ($strwhere, 1, 0);
		if ($rowarray==null) return 0;
		return $rowarray[0]->order;
	}
	function ChangeOrder ($neworder) {
		checkpermission("grantcat",$this->catid) or die ('Access denied');
		global $csdl;
		$strsql = "UPDATE `contents` SET ";
		$strsql .= "`iorder` = $neworder ";
		$strsql .= "WHERE `id`=$this->id";
		$csdl->Ghi($strsql);
	}
	function Ghi () {
		checkpermission("grantcat",$this->catid) or die ('Access denied');
		global $csdl;
		if ($this->id > -1) {
			$strsql = "UPDATE `contents` SET ";
			$strsql .= "`sid`=$this->sid, ";
			$strsql .= "`catid`=$this->catid, ";
			$strsql .= "`title`='$this->title', ";
			$strsql .= "`title_en`='$this->title_en', ";
			$strsql .= "`title_cn`='$this->title_cn', ";
			$strsql .= "`describe`='$this->describe', ";
			$strsql .= "`tag` = '$this->tag', ";
			$strsql .= "`introtext`='$this->introtext', ";
			$strsql .= "`introtext_en`='$this->introtext_en', ";
			$strsql .= "`introtext_cn`='$this->introtext_cn', ";
			$strsql .= "`full_text`='$this->full_text', ";
			$strsql .= "`full_text_en`='$this->full_text_en', ";
			$strsql .= "`full_text_cn`='$this->full_text_cn', ";
			$strsql .= "`image`='$this->image', ";
			$strsql .= "`imageposition` = '$this->imageposition', ";
			$strsql .= "`lastupdate` = '$this->lastupdate' ";
			global $updatehints;
			if ($updatehints==1) $strsql .= ", `hints`=$this->hints ";
			$strsql .= "WHERE `id`=$this->id";
		}
		else {
			$neworder = $this->GetMaxOrder() + 1;
			$idadmin = $_SESSION['_idadmin'];
			$strsql = "INSERT INTO contents (`sid`, `catid`, `title`, `title_en`, `title_cn`, `describe`, `tag`, `introtext`, `introtext_en`, `introtext_cn`, `full_text`, `full_text_en`, `full_text_cn`, `image`, `imageposition`, `iorder`, `time`, `lastupdate`, `createby`) ";
			$strsql .= "VALUES ($this->sid, $this->catid, '$this->title','$this->title_en','$this->title_cn', '$this->describe', '$this->tag','$this->introtext','$this->introtext_en','$this->introtext_cn','$this->full_text','$this->full_text_en','$this->full_text_cn','$this->image', '$this->imageposition', $neworder, '$this->ttime', '$this->lastupdate', $idadmin)";
		}
		$csdl->Ghi($strsql);
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
		$positionimg = $this->imageposition;
		?>
		<img src="<?php echo $imgsrc; ?>" width="<?php echo $scalewidth; ?>" align="<?php echo $positionimg; ?>" class="<?php echo ($positionimg=="right")?"right":"left"; ?>"  />
		<?php
	}
	function Out_Image2 ($maxwidth) {
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
		<img src="<?php echo $imgsrc; ?>" width="<?php echo $scalewidth; ?>" border="0" />
		<?php
	}
	function Get_Url () {
		$url = "index.php?module=com_content&task=view&id=$this->id";
		if (isset($_GET['curPage'])) {
			$tcurPage = $_GET['curPage'];
			$url .= "&curPage=" . $tcurPage;
		}
		if (isset($_GET['Itemid'])) {
			$titemid = $_GET['Itemid'];
			$url .= "&Itemid=" . $titemid;
		}
		return $url;
	}
	function Get_Url2 () {
		$url = "index.php?module=com_content&task=view&id=$this->id";
		if (isset($_GET['curPage'])) {
			$tcurPage = $_GET['curPage'];
			$url .= "&curPage=" . $tcurPage;
		}
		return $url;
	}
	function Get_Url3 () {
		$url = "index.php?module=com_content&task=view&id=$this->id";
		if (isset($_GET['Itemid'])) {
			$titemid = $_GET['Itemid'];
			$url .= "&Itemid=" . $titemid;
		}
		return $url;
	}
	function Get_Url4 () {
		$url = "index.php?module=com_content&task=view&id=$this->id";
		return $url;
	}
	function Get_Title () {
		global $lang;
		if ($lang=="en") $title=$this->title_en;
		else if ($lang=="cn") $title=$this->title_cn;
		else $title=$this->title;
		return $title;
	}
	function Get_Intro () {
		global $lang;
		
		if ($lang=="en") $intro = $this->introtext_en;
		else if ($lang=="cn") $intro = $this->introtext_cn;
		else $intro = $this->introtext;
		return $intro;
	}
	function Out_Title_Link ($leadding="") {
		$url = $this->Get_Url();
		$title = $this->Get_Title();
		?>
		<a href="<?php echo $url; ?>" ><?php echo $title; ?></a>
		<?php
	}
	function Out_TheHien_TT ($maxwidth) {
		global $lang;

		$intro=$this->Get_Intro();
		$title=$this->Get_Title();
		if ($lang=="en") $readmore = "...Read more";
		else if ($lang=="cn") $readmore = "詳閱";
		else $readmore="...Chi tiết";
		}
		?>
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="title_content" >
					<?php $this->Out_Title_Link(); ?>
				</td>
			</tr>
			<tr>
				
				<td valign="top" class="intro_content">
					<?php $this->Out_Image($maxwidth); ?>
					<?php echo $intro; ?>
				</td>
			</tr>
			<tr>
				<td align="right" style="padding-right:10px;" >
					<a href="<?php echo $this->Get_Url(); ?>" class="readmore"><?php echo $readmore; ?></a>
				</td>
			</tr>
			<tr>
				<td align="center" style="padding-bottom:5px; padding-top:5px; padding-left:30px;">
					<img src="images/spth_07.jpg" />
				</td>
			</tr>
		</table>
		<?php
	}
	function Inc_Hint () {
		global $csdl;
		$strsql = "UPDATE contents SET hints = hints + 1 WHERE id = " . $this->id;
		$csdl->Ghi($strsql);
		$this->hints++;
	}
	
	function Out_TheHien ($maxwidth) {
		$title=$this->Get_Title();
		$intro = $this->Get_Intro();
		
		global $lang;
		if ($lang=="en") $fulltext = $this->full_text_en;
		else if ($lang=="cn") $fulltext = $this->full_text_cn;
		else $fulltext = $this->full_text;
		$this->Inc_Hint();
		?>
       <table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="title_content_view">
					<?php echo $title; ?>
				</td>
			</tr>
			<tr>
				<td class="content_view">
					<?php $this->Out_Image($maxwidth); ?>
					<?php echo $fulltext; ?>
				</td>
			</tr>
		</table>
		<?php
	}
	function Out_TheHien_Marquee () {
		$title = $this->Get_Title();
		$intro = $this->Get_Intro();
		$url = $this->Get_Url4();
		?>
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="title_content">
					<a href="<?php echo $url; ?>" ><?php echo $title; ?></a>
				</td>
			</tr>
			<tr>
				<td class="intro_content">
					<a href="<?php echo $url; ?>" ><?php echo $intro; ?></a>
				</td>
			</tr>
			<tr>
				<td align="center" style="padding-top:10px;">
					<img src="images/bangtt_09.jpg" />
				</td>
			</tr>
		</table>
		<?php
	}
	function Out_TheHien_TT_Foot () {
		$title = $this->Get_Title();
		$url = $this->Get_Url ();
		$intro = $this->Get_Intro();
		?>
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
			<td style="padding-left:30px; padding-top:5px;">
				<img src="images/icon.jpg">
				<a href="<?php echo $url; ?>" class="td_listcontent_foot1">
		<?php echo $title; ?>
		</a></td>
			</tr>
		</table>
		<?php
	}
};
global $objcontent; $objcontent = new content;
?>