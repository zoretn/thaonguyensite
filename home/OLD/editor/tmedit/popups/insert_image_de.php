<?
// $Id: insert_image_en.php, v 1.1 2004/04/16 13:53:30 bpfeifer Exp $
/**
* TMEdit addon - ImageManager
* @ package TMedit
* @ Copyright � 2004 - 2005 Bernhard Pfeifer - www.thinkmambo.com
* @ All rights reserved
* @ Released under ThinkMambo Free Software License: http://www.thinkmambo.com/license/TMEdit_license.txt
* @version $Revision: 1.1 $
**/
define( "_VALID_MOS", 1 );
$base_path = "../../..";

if (!isset($my) || !$my->id) {
	require( "../../../../administrator/includes/auth.php" );
} 

	include 'ImageManager/config.inc.php';
	$no_dir = false;
	if(!is_dir($BASE_DIR.$BASE_ROOT)) {
		$no_dir = true;
	}

	if ($my->id && ($my->gid == 2 || ($my->gid >= 19 && $my->gid <= 25))) {

?>
<html style="width: 750; height: 440;">
<head>
<title>Bilder einf�gen/bearbeiten</title>
<script type="text/javascript" src="popup.js"></script>
<script type="text/javascript" src="../dialog.js"></script>
<script type="text/javascript">
window.resizeTo(750, 440);
var preview_window = null;

function Init() {
  __dlg_init();
  var param = window.dialogArguments;
  if (param) {
      document.getElementById("f_url").value = param["f_url"];
      document.getElementById("f_alt").value = param["f_alt"];
      document.getElementById("f_border").value = param["f_border"];
      document.getElementById("f_align").value = param["f_align"];
      document.getElementById("f_vert").value = param["f_vert"];
      document.getElementById("f_horiz").value = param["f_horiz"];
      document.getElementById("f_width").value = param["f_width"];
      document.getElementById("f_height").value = param["f_height"];
    }
document.getElementById("f_url").focus();
};

function onOK() {
  var required = {
    "f_url": "Bitte geben Sie eine Adresse an oder w�hlen Sie ein Bild aus."
  };
  for (var i in required) {
    var el = document.getElementById(i);
    if (!el.value) {
      alert(required[i]);
      el.focus();
      return false;
    }
  }
  // pass data back to the calling window
  var fields = ["f_url", "f_alt", "f_align", "f_border",
                "f_horiz", "f_vert", "f_height", "f_width"];
  var param = new Object();
  for (var i in fields) {
    var id = fields[i];
    var el = document.getElementById(id);
    param[id] = el.value;
  }
  __dlg_close(param);
  return false;
};

function onCancel() {
  __dlg_close(null);
  return false;
};


</script>
<style type="text/css">
html, body {
  background: ButtonFace;
  color: ButtonText;
  font: 11px Tahoma,Verdana,sans-serif;
  margin: 0px;
  padding: 0px;
}
body { padding: 5px; }
table {
  font: 11px Tahoma,Verdana,sans-serif;
}
form p {
  margin-top: 5px;
  margin-bottom: 5px;
}
.fl { width: 9em; float: left; padding: 2px 5px; text-align: right; }
.fr { width: 6em; float: left; padding: 2px 5px; text-align: right; }
fieldset { padding: 0px 10px 5px 5px; }
select, input, button { font: 11px Tahoma,Verdana,sans-serif; }
button { width: 70px; }
.space { padding: 2px; }

.title { background: none; color: #000; font-weight: bold; font-size: 120%; padding: 3px 10px; margin-bottom: 10px;
border-bottom: 1px solid black; letter-spacing: 2px;
}
form { padding: 0px; margin: 0px; }
</style>
<style type="text/css">
<!--
.buttonHover {
	border: 1px solid;
	border-color: ButtonHighlight ButtonShadow ButtonShadow ButtonHighlight;
	cursor: hand;
}
.buttonOut
{
	border: 1px solid ButtonFace;
}

.separator {
  position: relative;
  margin: 3px;
  border-left: 1px solid ButtonShadow;
  border-right: 1px solid ButtonHighlight;
  width: 0px;
  height: 16px;
  padding: 0px;
}
.manager
{
}
.statusLayer
{
	background:#FFFFFF;
	border: 1px solid #CCCCCC;
}
.statusText {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 15px;
	font-weight: bold;
	color: #6699CC;
	text-decoration: none;
}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
<!--
function pviiClassNew(obj, new_style) { //v2.6 by PVII
  obj.className=new_style;
}
function goUpDir() 
{
	var selection = document.forms[0].dirPath;
	var dir = selection.options[selection.selectedIndex].value;
	if(dir != '/')
	{
		imgManager.goUp();	
		changeLoadingStatus('load');
	}
	
}

function updateDir(selection) 
{
	var newDir = selection.options[selection.selectedIndex].value;
	imgManager.changeDir(newDir);
	changeLoadingStatus('load');
}


function toggleConstrains(constrains) 
{
	if(constrains.checked) 
	{
		document.locked_img.src = "ImageManager/locked.gif";	
		checkConstrains('width') 
	}
	else
	{
		document.locked_img.src = "ImageManager/unlocked.gif";	
	}
}

function checkConstrains(changed) 
{
	//alert(document.form1.constrain_prop);
	var constrained = document.form1.constrain_prop.checked;
	
	if(constrained) 
	{
		var orginal_width = parseInt(document.form1.orginal_width.value);
		var orginal_height = parseInt(document.form1.orginal_height.value);

		var width = parseInt(document.form1.f_width.value);
		var height = parseInt(document.form1.f_height.value);

		if(orginal_width > 0 && orginal_height > 0) 
		{
			if(changed == 'width' && width > 0) {
				document.form1.f_height.value = parseInt((width/orginal_width)*orginal_height);
			}

			if(changed == 'height' && height > 0) {
				document.form1.f_width.value = parseInt((height/orginal_height)*orginal_width);
			}
		}
			
	}

}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function P7_Snap() { //v2.62 by PVII
  var x,y,ox,bx,oy,p,tx,a,b,k,d,da,e,el,args=P7_Snap.arguments;a=parseInt(a);
  for (k=0; k<(args.length-3); k+=4)
   if ((g=MM_findObj(args[k]))!=null) {
    el=eval(MM_findObj(args[k+1]));
    a=parseInt(args[k+2]);b=parseInt(args[k+3]);
    x=0;y=0;ox=0;oy=0;p="";tx=1;da="document.all['"+args[k]+"']";
    if(document.getElementById) {
     d="document.getElementsByName('"+args[k]+"')[0]";
     if(!eval(d)) {d="document.getElementById('"+args[k]+"')";if(!eval(d)) {d=da;}}
    }else if(document.all) {d=da;} 
    if (document.all || document.getElementById) {
     while (tx==1) {p+=".offsetParent";
      if(eval(d+p)) {x+=parseInt(eval(d+p+".offsetLeft"));y+=parseInt(eval(d+p+".offsetTop"));
      }else{tx=0;}}
     ox=parseInt(g.offsetLeft);oy=parseInt(g.offsetTop);var tw=x+ox+y+oy;
     if(tw==0 || (navigator.appVersion.indexOf("MSIE 4")>-1 && navigator.appVersion.indexOf("Mac")>-1)) {
      ox=0;oy=0;if(g.style.left){x=parseInt(g.style.left);y=parseInt(g.style.top);
      }else{var w1=parseInt(el.style.width);bx=(a<0)?-5-w1:-10;
      a=(Math.abs(a)<1000)?0:a;b=(Math.abs(b)<1000)?0:b;
      x=document.body.scrollLeft + event.clientX + bx;
      y=document.body.scrollTop + event.clientY;}}
   }else if (document.layers) {x=g.x;y=g.y;var q0=document.layers,dd="";
    for(var s=0;s<q0.length;s++) {dd='document.'+q0[s].name;
     if(eval(dd+'.document.'+args[k])) {x+=eval(dd+'.left');y+=eval(dd+'.top');break;}}}
   if(el) {e=(document.layers)?el:el.style;
   var xx=parseInt(x+ox+a),yy=parseInt(y+oy+b);
   if(navigator.appName=="Netscape" && parseInt(navigator.appVersion)>4){xx+="px";yy+="px";}
   if(navigator.appVersion.indexOf("MSIE 5")>-1 && navigator.appVersion.indexOf("Mac")>-1){
    xx+=parseInt(document.body.leftMargin);yy+=parseInt(document.body.topMargin);
    xx+="px";yy+="px";}e.left=xx;e.top=yy;}}
}

function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}

function changeLoadingStatus(state) 
{
	var statusText = null;
	if(state == 'load') {
		statusText = 'Lade Bilder...';	
	}
	if(statusText != null) {
		var obj = MM_findObj('loadingStatus');
		if (obj != null && obj.innerHTML != null)
			obj.innerHTML = statusText;
		MM_showHideLayers('loading','','show')		
	}
}

function refresh()
{
	var selection = document.forms[0].dirPath;
	updateDir(selection);
}


//-->
</script>
</head>
<body onload="Init(); P7_Snap('dirPath','loading',120,70);self.focus();">
<div class="title">Bilder einf�gen/bearbeiten</div>
<form action="ImageManager/images.php" name="form1" method="post" target="imgManager" enctype="multipart/form-data">
<div id="loading" style="position:absolute; left:200px; top:130px; width:184px; height:48px; z-index:1" class="statusLayer">
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td><div align="center"><span id="loadingStatus" class="statusText">Lade Bilder</span><img src="ImageManager/dots.gif" width="22" height="12"></div></td>
    </tr>
  </table>
</div>
  <table width="100%" border="0" align="center" cellspacing="2" cellpadding="2">
    <tr>
      <td align="center">	  <fieldset>
	  <legend>Bilder-Browser</legend>
        <table width="99%" align="center" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td><table border="0" cellspacing="1" cellpadding="3">
                <tr> 
                  <td class="dirField">Verzeichnis:</td>
                  <td>
				  <select name="dirPath" id="dirPath" style="width:30em" onChange="updateDir(this)">
				  <option value="/">/</option>
<?


function dirs($dir,$abs_path) 
{
	$d = dir($dir);
		$dirs = array();
		while (false !== ($entry = $d->read())) {
			if(is_dir($dir.'/'.$entry) && substr($entry,0,1) != '.') 
			{
				$path['path'] = $dir.'/'.$entry;
				$path['name'] = $entry;
				$dirs[$entry] = $path;
			}
		}
		$d->close();
	
		ksort($dirs);
		for($i=0; $i<count($dirs); $i++) 
		{
			$name = key($dirs);
			$current_dir = $abs_path.'/'.$dirs[$name]['name'];
			echo "<option value=\"$current_dir\">$current_dir</option>\n";
			dirs($dirs[$name]['path'],$current_dir);
			next($dirs);
		}
}

if($no_dir == false) {
	dirs($BASE_DIR.$BASE_ROOT,'');	
}
?>
				</select>
				  </td>
                  <td class="buttonOut" onMouseOver="pviiClassNew(this,'buttonHover')" onMouseOut="pviiClassNew(this,'buttonOut')">
				  <a href="#" onClick="javascript:goUpDir();"><img src="ImageManager/btnFolderUp.gif" width="15" height="15" border="0" alt="Nach oben"></a></td>
<? if ($SAFE_MODE == false) { ?>
<?php } ?>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="center" bgcolor="white"><div name="manager" class="manager">
        <iframe src="ImageManager/images.php" name="imgManager" id="imgManager" style="width:100%;height=100%;" marginwidth="0" marginheight="0" align="top" scrolling="auto" frameborder="0" hspace="0" vspace="0" background="white"></iframe>
		</div>
			</td>
          </tr>
        </table>
        </fieldset></td>
    </tr>
    <tr>
      <td><table border="0" align="center" cellpadding="2" cellspacing="2">
          <tr> 
            <td nowrap><div align="right">Pfad:</div></td>
            <td><input name="url" id="f_url" type="text" style="width:20em" size="30"></td>
            <td rowspan="3">&nbsp;</td>
            <td><div align="right">Breite:</div></td>
            <td><input name="width" id="f_width" type="text" size="5" style="width:4em" onChange="javascript:checkConstrains('width');"></td>
            <td rowspan="2"><img src="ImageManager/locked.gif" name="locked_img" width="25" height="32" id="locked_img" alt="Locked"></td>
            <td rowspan="3">&nbsp;</td>
            <td><div align="right">Vert. Abstand:</div></td>
            <td><input name="vert" id="f_vert" type="text" size="5" style="width:4em"></td>
          </tr>
          <tr> 
            <td nowrap><div align="right">Alternativer Text:</div></td>
            <td><input type="text" style="width:20em" name="alt" id="f_alt"></td>
            <td><div align="right">H�he:</div></td>
            <td><input name="height" id="f_height" type="text" size="5" style="width:4em" onChange="javascript:checkConstrains('height');"></td>
            <td><div align="right">Horiz. Abstand:</div></td>
            <td><input name="horiz" id="f_horiz" type="text" size="5" style="width:4em"></td>
          </tr>
          <tr><td><div align="right">Datei hochladen:</div></td>
            <td><input type="file" name="upload" id="upload"> 
              <input type="submit" style="width:5em" value="Hochladen" onClick="javascript:changeLoadingStatus('upload');" />
			 </td>
            <td><div align="right">Ausrichtung:</div></td>
            <td colspan="2"><select name="align" ID="f_align">
                <OPTION id="optNotSet" value="" SELECTED>Nicht gesetzt</OPTION>
                <OPTION id="optLeft" value="left">Links</OPTION>
                <OPTION id="optRight" value="right">Rechts</OPTION>
                <OPTION id="optTop" value="top">Oben</OPTION>
                <OPTION id="optTexttop" value="textTop">Textoberkante</OPTION>
                <OPTION id="optMiddle" value="middle">Mitte</OPTION>
                <OPTION id="optAbsMiddle" value="absMiddle">Absolute Mitte</OPTION>
                <OPTION id="optBottom" value="bottom">Unten</OPTION>
                <OPTION id="optBaseline" value="baseline">Grundlinie</OPTION>
                <OPTION id="optAbsBottom" value="absBottom">Unterkante</OPTION>
              </select></td>
            <td><div align="right">Rahmen:</div></td>
            <td><input name="border" id="f_border" type="text" size="5" style="width:4em"></td>
          </tr>
          <tr> 
            <td colspan="3">&nbsp;</td>
            <td><div align="right">
			    <input type="hidden" name="orginal_width" id="orginal_width">
				<input type="hidden" name="orginal_height" id="orginal_height">
                <input type="checkbox" name="constrain_prop" id="constrain_prop" checked onClick="javascript:toggleConstrains(this);">
              </div></td>
            <td colspan="5">Proportionen beibehalten:</td>
          </tr>
        </table>
        
      </td>
    </tr>
    <tr>
      <td>
      	<table width="100%" border="0" cellpadding="0" cellspacing="0">
      		<tr>
      			<td colspan="2"><hr /></td>
      		</tr>
      		<tr>
      			<td><button type="button" name="ok" onclick="return refresh();">Aktualisieren</button></td>
      			<td align="right"><button type="button" name="ok" onclick="return onOK();">OK</button>&nbsp;&nbsp;<button type="button" name="cancel" onclick="return onCancel();">Abbrechen</button></td>
      		</tr>
      	</table>
     </td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
} else {
	echo "Direct access to this location is not allowed!";
}
?>