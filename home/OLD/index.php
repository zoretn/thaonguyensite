<?php
session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="hatdieu, dieu, thaonguyen, thaonguyen, thaonguyen.com, thaonguyen.com.vn, nguyenthao, hat, dieuhat, thao" />
<meta name="Description" content="Được phát triển bởi Công ty TNHH Tin Học Phan Nguyễn - Phan Nguyen Informatics Co., Ltd. - phannguyenit.com" />
<?php
if (!isset($_SESSION['lang']))
	$_SESSION['lang'] = "vn";
if (isset($_GET['lang']))
	$_SESSION['lang'] = $_GET['lang'];
$lang=$_SESSION['lang'];
?>
<?php
define("_ALLOW",1);
include("config.php");
?>
<title><?php echo $cfg_title_site; ?></title>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/stylemenu.css" rel="stylesheet" type="text/css">
<link href="css/stylemenu2.css" rel="stylesheet" type="text/css">
<link href="css/stylecontent.css" rel="stylesheet" type="text/css">
<link href="css/styleproduct.css" rel="stylesheet" type="text/css">
<link href="css/styleother.css" rel="stylesheet" type="text/css">
<link href="css/styleout.css" rel="stylesheet" type="text/css">
<link href="joomla/css/template_css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="editor/tinymce/jscripts/tiny_mce/plugins/media/jscripts/embed.js"></script>
<script language="javascript" src="common/js/ufo.js"></script>
<style type="text/css">
<!--
body {
	background-image: url(images/nen.jpg);
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>
<center>
<body id="body_index">
<script>
       
       document.getElementById('body_index').style.background = 'url(images/nen.jpg) no-repeat fixed top center';
       
</script>
<script language="javascript">
var widthscreen = screen.width;
var heightscreen = screen.height;
var detailwin;
function openBox (winWidth, winHeight, scrollbars, toolbar, top, left, fileSrc, parent) {
	var newParameter = "width = " + winWidth + ", resizable = yes" + ", height = " + winHeight;
	newParameter += ", scrollbars = " + scrollbars + ",toolbar = " + toolbar + ", top = " + (heightscreen - winHeight)/2;
	newParameter += ",left = " + (widthscreen - winWidth)/2;
	detailwin = parent.open (fileSrc,"subWind",newParameter);
	detailwin.focus();
	return false;
};
</script>
<script language="javascript">
function checksearch (form) {
var strSearch, keyword;
	strSearch = form.keyword.value;
	strSearch = UnicodeGet(strSearch);
	keyword = UnicodeSet(strSearch);
	
	while (strSearch.length > 0 && strSearch.charAt(0) <= ' ')
	{
		strSearch = strSearch.substr(1);
	}

	while ((i=strSearch.length) > 0 && strSearch.charAt(i - 1) <= ' ')
	{
		strSearch = strSearch.substr(0, i - 1);
	}
	if (strSearch != "") {
		return true;
	}
	alert("Input keyword, please.");
	return false;
}
function CheckSubmitCart (form) {
	var quanlity = form.productquanlity;
	if (!checkunsignedInt(quanlity)) {
		alert("<?php if ($lang=="vn") echo "Vui lòng nhập số lượng"; else echo "Please input quantity"; ?>");
		return false;
	}
	return true;
}
function UFO_OutFlash (divid, urlfile, width, height) {
	var sdivid = "" + divid + "";
	var surlfile = "" + urlfile + "";
	var swidth = "" + width + "";
	var sheight = "" + height + "";
	var FO = {movie:surlfile, width:swidth, height:sheight, majorversion:"7", build:"0", bgcolor:"#ffffff", wmode:"transparent"};
	UFO.create(FO, sdivid);
}
</script>
<?php
include("configimage.php");
?>
<?php
include("configdb.php");
include("class/dbconnect.php");
include("module.php");
include("class/cimage.php");
include("global.php");
if (isset($_GET['Itemid'])) $glb_Itemid = $_GET['Itemid'];
?>
<script language="javascript" src="common/js/checknumber.js"></script>
<script language="javascript" src="common/js/unicode.js"></script>
<!------------------------------JOOMLA-------------------------------//-->
<script language="javascript" src="joomla/js/joomla.javascript.js"></script>
<script language="javascript" src="joomla/js/JSCookMenu_mini.js"></script>
<script language="javascript" src="joomla/js/theme.js"></script>
<!------------------------------JOOMLA-------------------------------//-->
<!--<div id="divbannerflash">
		</div>
		<script type="text/javascript">
var FO = {
        movie: "flash/Banner.swf"
        ,width:"584"
        ,height:"234"
        ,majorversion:"7",build:"0"
        ,bgcolor:"#999999", wmode:"transparent"
        };
        UFO.create(FO, "divbannerflash");
        </script>-->
<table width="801" border="0" align="center" cellpadding="0" cellspacing="0">
 
  <tr>
    <td>
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td>
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="193" style="background-image:url(images/logo_03.jpg); background-repeat:no-repeat;" height="104"></td>
							<td>
								<table width="100%" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td style="background-image:url(images/<?php echo ($lang=='vn')?"menutop_02.jpg":"menutop_en.jpg";?>); background-repeat:no-repeat;" height="64">
										</td>
									</tr>
									<tr>
										<td style="background-image:url(images/menutop_04.jpg); background-repeat:no-repeat;" height="41">
											
											<?php
												loadmenu2("top",1,"cmthememenutop","thememenutop");
											?>
											
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td valign="top"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="800" height="235">
                  <param name="movie" value="flash/banner.swf">
                  <param name="quality" value="high">
                  <embed src="flash/banner.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="800" height="235"></embed>
			    </object></td>
			</tr>
			<tr>
				<td style="background-image:url(images/gio_03.jpg); background-repeat:no-repeat;" height="38">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="7%" style="padding-left:20px;s"><img src="images/dh.jpg"></td>
							<td width="52%" style="font-family:tahoma; font-size:11px; font-weight:bold; color:#000000;">
								<?php
				$str = "";
				$ttime = time();
				$ddate = getdate($ttime);
				$week_day = $ddate['wday'];
				$dday =$ddate['weekday'];
				$ddtime = $ddate['hours'];
				if($lang=='vn')
				{
					switch ($week_day)
					{
						case 0: $dday="Chủ nhật";
						break;
						case 1: $dday="Thứ hai";
						break;
						case 2: $dday="Thứ ba";
						break;
						case 3: $dday="Thứ tư";
						break;
						case 4: $dday="Thứ năm";
						break;
						case 5: $dday="Thứ sáu";
						break;
						case 6: $dday="Thứ bảy";
						break;
					}
				}
				$phut=$ddate['minutes'];
				if($phut<10)
				$phut="0".$phut;
				$str = $ddtime.":".$phut." | ".$dday.", ".$ddate['mday']."/".$ddate['mon']."/".$ddate['year'];
				
				echo $str;
		?>							</td>
							<td width="4%"><img src="images/co_06.jpg"></td>
							<td width="10%"><a href="index.php?lang=vn" class="ngonngu">Tiếng Việt</a></td>
							<td width="5%"><img src="images/co_08.jpg"></td>
							<td width="9%"><a href="index.php?lang=en" class="ngonngu">English</a></td>
							<td width="4%"><img src="images/co_10.jpg"></td>
							<td width="9%"><a href="index.php?lang=cn" class="ngonngu">China</a></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</td>
  </tr>
  <tr>
  	<td>
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="228" valign="top">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<!-------MENULEFT-------------->
						<tr>
							<td>
								<table width="100%" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td style="background-image:url(images/bangsp_03.jpg); background-repeat:no-repeat; font-family:tahoma; font-size:12px; font-weight:bold; color:#FFFFFF; text-transform:uppercase; padding-left:60px;" height="42">
											
											<?php if ($lang=="vn") echo "sản phẩm"; else if($lang=="en") echo "products"; else echo "產品"; ?>
										</td>
									</tr>
									<tr>
										<td style="background-image:url(images/bangsp_06.jpg); background-repeat:repeat-y; padding-left:10px;">
											<?php
												loadmenu2("left",1,"cmthememenuleft","thememenuleft");
											?>
										</td>
									</tr>
									<tr>
										<td style="background-image:url(images/bangsp_08.jpg); background-repeat:no-repeat;" height="19">
										</td>
									</tr>
								</table>	
							</td>
						</tr>
						<!-------TINTUC-------------->
						<tr>
							<td>
								<table width="100%" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td style="background-image:url(images/bangtt_03.jpg); background-repeat:no-repeat; font-family:tahoma; font-size:12px; font-weight:bold; color:#FFFFFF; text-transform:uppercase; padding-left:60px;" height="46">
										<?php
												if($lang=="vn")echo"tin tức & sự kiện";else if($lang=='en') echo "news & events";else echo "通訊-資料";
											?>
										</td>
									</tr>
									<tr>
										<td style="background-image:url(images/bangtt_06.jpg); background-repeat:repeat-y; padding-left:5px; padding-right:5px;">
											<?php
												loadmodule("mod_news","","","");
											?>
										</td>
									</tr>
									<tr>
										<td style="background-image:url(images/bangtt_12.jpg); background-repeat:no-repeat;" height="19">
										</td>
									</tr>
								</table>	
							</td>
						</tr>
						<!-------HOTRO-------------->
						<tr>
							<td>
								<table width="100%" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td style="background-image:url(images/banght_03.jpg); background-repeat:no-repeat; font-family:tahoma; font-size:12px; font-weight:bold; color:#FFFFFF; text-transform:uppercase; padding-left:60px;" height="45">
										<?php
												if($lang=="vn")echo"hỗ trợ trực tuyến";else if($lang=='en') echo "support online"; else echo "在线支持";
										?>
										</td>
									</tr>
									<tr>
										<td style="background-image:url(images/banght_06.jpg); background-repeat:repeat-y;">
											<?php
												loadmodule("mod_support","","","");
											?>
										</td>
									</tr>
									<tr>
										<td style="background-image:url(images/banght_08.jpg); background-repeat:no-repeat;" height="15">
										</td>
									</tr>
								</table>	
							</td>
						</tr>
						<!-------LIENKET-------------->
						<tr>
							<td>
								<table width="100%" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td style="background-image:url(images/banght_03.jpg); background-repeat:no-repeat; font-family:tahoma; font-size:12px; font-weight:bold; color:#FFFFFF; text-transform:uppercase; padding-left:60px;" height="45">
										<?php
												if($lang=="vn")echo"liên kết website";else if($lang=='en') echo "web link";else echo "链接";
										?>
										</td>
									</tr>
									<tr>
										<td style="background-image:url(images/banght_06.jpg); background-repeat:repeat-y;">
											<?php
												loadmodule("mod_link","","","");
											?>
										</td>
									</tr>
									<tr>
										<td style="background-image:url(images/banght_08.jpg); background-repeat:no-repeat;" height="15">
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
			  </td>
				<td valign="top" id="mainbody" style="padding-right:5px;">
					<?php
						loadmainbody();
					?>
				</td>
			</tr>
		</table>
	</td>
  </tr>
  <tr>
  	<td style="background-image:url(images/copy_03.jpg); background-repeat:no-repeat;" height="95">
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td valign="top">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td style="padding-top:5px;">
					<?php
						loadmodule("mod_counter","","","");
					?>
				</td>
			</tr>
			<tr>
				<td class="pn" style="padding-top:5px; padding-left:20px;">Developed by<a href="http://www.phannguyenit.com" target="_blank">phannguyenit.com</a></td>
			</tr>
		</table>
			  </td>
				<td valign="top" class="pn" align="right" style="padding-right:20px;">
					<?php
						if($lang=='vn')echo "Copyright © 2008 THAO NGUYEN Co., LTD.<br> 
 Địa chỉ: Ấp Thị Vải, xã Mỹ Xuân, huyện Tân Thành, Bà Rịa - Vũng Tàu, Việt Nam<br>
 Điện thoại: (84-8)  39300785 - 08. 39330792 * Fax:(84-8) 39330361<br>
website: www.thaonguyen.com.vn<br>
Email: thaonguyen.co.ltd@hcm.fpt.vn<br>";else  echo "Copyright © 2008 THAO NGUYEN Co., LTD.<br> 
 Address: Thi Vai Hamlet, My Xuan ward, Tan Thanh district, Ba Ria - Vung Tau Province, Viet Nam<br>
 Tell: (84-8)  39300785 - 08. 39330792 * Fax:(84-8) 39330361<br>
Website: www.thaonguyen.com.vn<br>
Email: thaonguyen.co.ltd@hcm.fpt.vn<br>";
					?>
					


			  </td>
			</tr>
		</table>
	</td>
  </tr>
</table>
<?php mysql_close($csdl->ketnoi); ?>
</body>
</center>
</html>
