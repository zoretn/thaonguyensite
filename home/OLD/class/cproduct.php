<?php
defined ('_ALLOW') or die ('Access denied');
class product {
	var $id;
	var $sid;
	var $catid;
	var $code;
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
	var $order;
	var $price;
	var $fprice;
	var $nums;
	function Doc_danh_sach ($catid, $count, $begin=0) {
		$where = "";
		if ($catid != "") {
			$where = "catid = $catid";
		}
		return $this->Fill($where, $count, $begin);
	}
	function CountFill ($strwhere) {
		global $csdl;
		$strsql = "SELECT COUNT(*) as count FROM products";
		if ($strwhere != "")
			$strsql .= " WHERE " . $strwhere;
		$rowsdb = $csdl->Truyvan($strsql);
		$rowdb = mysql_fetch_array($rowsdb,MYSQL_ASSOC);
		$count = $rowdb['count'];
		return $count;
	}
	function Fill ($strwhere, $count, $begin=0) {
		global $csdl;
		$strsql = "SELECT *, format(price,0) as fprice FROM products";
		if ($strwhere!="") {
			$strsql .= " WHERE " . $strwhere;
		}
		$strsql .= " ORDER BY iorder, id";
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
	function Doc ($id) {
		$rowarray = $this->Fill ("id=$id", 1, 0);
		if ($rowarray==null)
			return null;
		else
			return $rowarray[0];
	}
	function Khoi_tao ($rowdb) {
		$kq = new product;
		$kq->id = $rowdb['id'];
		$kq->sid = $rowdb['sid'];
		$kq->catid = $rowdb['catid'];
		$kq->code = $rowdb['code'];
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
		$kq->order = $rowdb['iorder'];
		$kq->price = $rowdb['price'];
		$kq->fprice = $rowdb['fprice'];
		return $kq;
	}
	function Xoa () {
		checkpermission("grantproductcat",$this->catid) or die ('Access denied');
		global $csdl;
		$csdl->Xoa("products","id=$this->id");
	}
	function DocForm () {
		global $cfg_live_site;
		$this->id = $_REQUEST['id'];
		$this->sid = $_REQUEST['sid'];
		$this->catid = $_REQUEST['catid'];
		$this->code = $_REQUEST['code'];
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
		$this->price = 0;
		if ($_REQUEST['price'] != "") {
			$this->price = $_REQUEST['price'];
			$this->price = str_replace(",","",$this->price);
		}
		/*
		$this->introtext = str_replace("../","$cfg_live_site",$this->introtext);
		$this->introtext_en = str_replace("../","$cfg_live_site",$this->introtext_en);
		$this->full_text = str_replace("../","$cfg_live_site",$this->full_text);
		$this->full_text_en = str_replace("../","$cfg_live_site",$this->full_text_en);
		*/
	}
	function GetMaxOrder () {
		$strwhere = "iorder>=all";
		$strwhere .= " (SELECT iorder FROM products)";
		$rowarray = $this->Fill ($strwhere, 1, 0);
		if ($rowarray==null) return 0;
		return $rowarray[0]->order;
	}
	function ChangeOrder ($neworder) {
		checkpermission("grantproductcat",$this->catid) or die ('Access denied');
		global $csdl;
		$strsql = "UPDATE `products` SET ";
		$strsql .= "`iorder` = $neworder ";
		$strsql .= "WHERE `id`=$this->id";
		$csdl->Ghi($strsql);
	}
	function Ghi () {
		global $csdl;
		checkpermission("grantproductcat",$this->catid) or die ('Access denied');
		if ($this->id > -1) {
			$strsql = "UPDATE `products` SET ";
			$strsql .= "`sid`=$this->sid, ";
			$strsql .= "`catid`=$this->catid, ";
			$strsql .= "`code` = '$this->code', ";
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
			$strsql .= "`price`=$this->price ";
			$strsql .= "WHERE `id`=$this->id";
		}
		else {
			$neworder = $this->GetMaxOrder() + 1;
			$strsql = "INSERT INTO `products` (`sid`, `catid`, `code`, `title`, `title_en`, `title_cn`, `describe`, `tag`, `introtext`, `introtext_en`, `introtext_cn`, `full_text`, `full_text_en`, `full_text_cn`, `image`, `price`, `iorder`) ";
			$strsql .= "VALUES ($this->sid, $this->catid, '$this->code', '$this->title','$this->title_en','$this->title_cn', '$this->describe', '$this->tag', '$this->introtext','$this->introtext_en', '$this->introtext_cn','$this->full_text','$this->full_text_en','$this->full_text_cn','$this->image', $this->price, $neworder)";
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

		?>
		<img align="left" src="<?php echo $imgsrc; ?>" width="<?php echo $scalewidth; ?>" border="0" />
		<?php
	}
	function Get_Url () {
		$url = "index.php?module=com_product&task=view&id=$this->id";
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
		$url = "index.php?module=com_product&task=view&id=$this->id";
		if (isset($_GET['curPage'])) {
			$tcurPage = $_GET['curPage'];
			$url .= "&curPage=" . $tcurPage;
		}
		return $url;
	}
	function Get_Url3 () {
		$url = "index.php?module=com_product&task=view&id=$this->id";
		if (isset($_GET['Itemid'])) {
			$titemid = $_GET['Itemid'];
			$url .= "&Itemid=" . $titemid;
		}
		return $url;
	}
	
	function Out_Title_Link ($leadding="") {
		$title = $this->Get_Title();
		$url = $this->Get_Url();
		$size = 400;
		$objimage = new image($this->image);
		$sizeimage = $objimage->getsize();
		if ($size < $sizeimage[0])
			$size = $sizeimage[0];
		?>
		<a href="<?php echo $url; ?>"><?php echo $title; ?></a>
		<?php
	}
	function Get_Title () {
		global $lang;
		$title = $this->title;
		if ($lang=="en") $title = $this->title_en;
		else if ($lang=="cn") $title = $this->title_cn;
		return $title;
	}
	function Get_Intro () {
		global $lang;
		$intro = $this->introtext;
		if ($lang == "en") $intro = $this->introtext_en;
		if ($lang == "cn") $intro = $this->introtext_cn;
		return $intro;
	}
	function Get_Url4 () {
		$url = "index2.php?module=com_product&task=view&id=$this->id";
		return $url;
	}
	function Out_TheHien_TT ($maxwidth) {
		global $lang;
		global $currency;
		$readmore="Chi tiết";
		$intro=$this->Get_Intro();
		$title=$this->Get_Title();
		if ($lang=="en") {
			$readmore = "... More";
		}
		else if($lang=='cn'){
			$readmore = "...详情";
		}
		$url = $this->Get_Url();
		$size = 400;
		$objimage = new image($this->image);
		$sizeimage = $objimage->getsize();
		if ($size < $sizeimage[0])
			$size = $sizeimage[0];
		?>
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td>
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td style="padding-left:20px;">
								<a href="<?php echo $url; ?>">
            <?php $this->Out_Image($maxwidth); ?>
        </a>
							</td>
							<td>
								<table width="100%" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td height="30">&nbsp;
										</td>
									</tr>
									<tr>
										<td width="70" height="27" valign="top" style="background-image:url(images/chitiet.jpg); background-repeat:no-repeat; padding-top:5px; padding-left:5px;">
							<a href="<?php echo $this->Get_Url(); ?>" class="readmore1"><?php echo $readmore; ?></a>							</td>
									</tr>
							  </table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td class="title_product">
					<?php $this->Out_Title_Link(); ?>
				</td>
			</tr>
			<tr>
				<td class="intro_product">
					<?php
						echo $intro;
					?>
				</td>
			</tr>
		</table>
		<?php
	}
	
	function Out_PartForm () {
		$strquality = "Số lượng";
		global $lang;
		$productid = $this->id;
		$productname = $this->Get_Title();
		if ($lang=="en") {
			$strquality = "Quantity";
		}
		$productprice = $this->price;
		$productfprice = $this->fprice;
		$formname = "formproduct".$this->id;
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_formproduct">
		<form name="<?php echo $formname; ?>" id="<?php echo $formname; ?>" action="index.php" method="GET" onsubmit="return CheckSubmitCart(this)" >
		<tr>
		<td class="lable" width="60"><img src="images/icon.gif" /> <?php echo $strquality; ?></td>
		<td width="60"><input type="text" name="productquanlity" class="text_area" size="5" style="text-align:right;" /></td>
		<td><input type="image" src="images/img_cart.jpg" /></td>
		</tr>
		<input type="hidden" name="productid" value="<?php echo $productid; ?>" />
		<input type="hidden" name="productname" value="<?php echo $productname; ?>" />
		<input type="hidden" name="productprice" value="<?php echo $productprice; ?>" />
		<input type="hidden" name="productfprice" value="<?php echo $productfprice; ?>" />
		<input type="hidden" name="task" value="add" />
        <input type="hidden" name="module" value="com_shoppingcart" />
		</form>
		</table>
		<?php
	}
	
	function Out_TheHien ($maxwidth) {
		$title=$this->Get_Title();
		$intro = $this->Get_Intro();
		$fulltext = $this->full_text;
		global $lang;
		global $currency;
		if ($lang=="en") {
			$fulltext = $this->full_text_en;
		}
		if ($lang=="cn") {
			$fulltext = $this->full_text_cn;
		}
		
		

		?>
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="title_product_view">
					<?php echo $title; ?>
				</td>
			</tr>
			<tr>
				<td class="product_view">
					<?php $this->Out_Image($maxwidth); ?>
					<?php echo $fulltext; ?>
				</td>
			</tr>
		</table>
		<?php
	}
	function Out_TheHien_Marquee () {
		$title = $this->Out_Title();
		$intro = $this->Out_Intro();
		$url = $this->Get_Url4();
		?>
		<a href="<?php echo $url; ?>" class="title_product" title="$intro"><?php echo $title; ?></a>
		<?php
	}
	function Out_TheHien_TT_Foot ($maxwidth) {
		$this->Out_TheHien_TT($maxwidth);
	}
};
global $objproduct; $objproduct = new product;
?>