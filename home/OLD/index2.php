<?php
session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 5px;
	margin-right: 3px;
	margin-bottom: 0px;
	font-family:Tahoma;
	font-size:11px;
	color:#4F4F4F;
}
-->
</style>
<?php
define("_ALLOW",1);
include("config.php");
?>
<title><?php echo $cfg_title_site; ?></title>
<link rel="shortcut icon" href="images/logowebphannguyen.ico" />
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/styleproduct.css" rel="stylesheet" type="text/css">
<link href="css/styleother.css" rel="stylesheet" type="text/css">
<link href="css/styleout.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
if (!isset($_SESSION['lang']))
	$_SESSION['lang'] = "vn";
if (isset($_GET['lang']))
	$_SESSION['lang'] = $_GET['lang'];
$lang=$_SESSION['lang'];
?>
<SCRIPT language=JavaScript1.2>

function disableselect(e){
return false;
}

function reEnable(){
return true;
}

//if IE4+
document.onselectstart=new Function ("return false");

//if NS6
if (window.sidebar){
document.onmousedown=disableselect;
document.onclick=reEnable;
}
</SCRIPT>
<script language="javascript">
function click() {
if (event.button==2) {
alert('Xin loi, chuot phai khong co tac dung!')
}
}
document.onmousedown=click;

function CheckSubmitCart (form) {
	var quanlity = form.productquanlity;
	if (!checkunsignedInt(quanlity)) {
		alert("<?php if ($lang=="vn") echo "Vui lòng nhập số lượng"; else echo "Please input quanlity"; ?>");
		return false;
	}
	return true;
}
function SubmitCart (form) {
	if (!CheckSubmitCart(form)) {
		return;
	}
	form.submit();
}
</script>
<?php
include("configdb.php");
include("configimage.php");
include("class/dbconnect.php");
include("class/cimage.php");
include("global.php");
?>

<div id="mainbody" style="padding:0 0 10 5; border:none;">
<?php
include_once("components/com_product/index.html.php");
?>
</div>
<div style="text-align:center;">
<a href="javascript:;" onClick="window.print(); return false;" style="font-weight:bold; color:#FF0000; font-size:12px;" onMouseOver="javascript:window.defaultStatus = 'Print'; return true;">< Print (In) ></a>
<a href="javascript:;" onClick="window.close(); return false;" style="font-weight:bold; color:#FF0000; font-size:12px;" onMouseOver="javascript:window.defaultStatus = 'Close window'; return true;">< Close (Đóng) ></a>
</div>
</body>
</html>
