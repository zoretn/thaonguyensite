<?php
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administrator</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="joomla/css/template_css.css" type="text/css" />
<link rel="stylesheet" href="joomla/css/theme.css" type="text/css" />

<script language="JavaScript" src="joomla/js/JSCookMenu_mini.js" type="text/javascript"></script>
<script language="JavaScript" src="joomla/js/theme.js" type="text/javascript"></script>
<script language="JavaScript" src="joomla/js/joomla.javascript.js" type="text/javascript"></script>
<!-- TinyMCE -->
<script language="javascript" type="text/javascript" src="../editor/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
	tinyMCE.init({
		document_base_url : "/index.php",
//		convert_urls : false,
		mode : "textareas",
		theme : "advanced",
		plugins : "table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,zoom,media,searchreplace,print,contextmenu,paste,directionality,fullscreen",
//		theme_advanced_buttons1_add_before : "save,newdocument,separator",
		theme_advanced_buttons1_add : "fontselect,fontsizeselect,forecolor,backcolor",
		theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,zoom,separator",
		theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
		theme_advanced_buttons3_add_before : "tablecontrols,separator",
		theme_advanced_buttons3_add : "emotions,iespell,media,advhr,separator,print,fullscreen,separator,ltr,rtl",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		content_css : "example_word.css",
	    plugi2n_insertdate_dateFormat : "%Y-%m-%d",
	    plugi2n_insertdate_timeFormat : "%H:%M:%S",
		external_link_list_url : "example_link_list.js",
		external_image_list_url : "example_image_list.js",
		media_external_list_url : "example_media_list.js",
		file_browser_callback : "fileBrowserCallBack",
		paste_use_dialog : false,
		theme_advanced_resizing : true,
		theme_advanced_resize_horizontal : false,
		theme_advanced_link_targets : "_something=My somthing;_something2=My somthing2;_something3=My somthing3;",
		paste_auto_cleanup_on_paste : true,
		paste_convert_headers_to_strong : false,
		paste_strip_class_attributes : "all",
		paste_remove_spans : false,
		paste_remove_styles : false,
		media_use_script: true
	});

	function fileBrowserCallBack(field_name, url, type, win) {
		// This is where you insert your custom filebrowser logic
//		alert("Filebrowser callback: field_name: " + field_name + ", url: " + url + ", type: " + type);
//		win.open ("../../../../../tmedit/popups/insert_image_en.php?txt=" + field_name);
		openBox(750,500,'no','no',0,0,'../../../../../tmedit/popups/insert_image_en.php?txt=' + field_name, win);

		// Insert new URL, this would normaly be done in a popup
//		win.document.forms[0].elements[field_name].value = "someurl.htm";
	}
	function openBox (winWidth, winHeight, scrollbars, toolbar, top, left, fileSrc, parent) {
		var newParameter = "width = " + winWidth + ", height = " + winHeight;
		newParameter += ", scrollbars = " + scrollbars + ",toolbar = " + toolbar + ", top = " + top;
		newParameter += ",left = " + left;
		parent.open (fileSrc,"a",newParameter);
	};
</script>
<!-- /TinyMCE -->
</head>

<body>
<script language="javascript">
//setTypingMode(2);
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="images/banner.jpg" width="1002" height="75" /></td>
  </tr>
  <tr>
    <td>
	<?php
		define("_ALLOW",1);
		include("../config.php");
		include("../configimage.php");
		include("module.php");
		if (isset($_REQUEST['cfg_title_site'])) {
			if ($_REQUEST['task'] == "save") {
				include_once ("components/com_config/config.function.php");
				$objcfg = new mosConfig;
				$objcfg->saveconfig();
			}
			$_REQUEST['module']="";
		}
		include("../configdb.php");
		include("common/security.php");
		if (!checkadmin()) {
			include("components/com_login/index.html.php");
			exit();
		}
		else {
			include("../class/dbconnect.php");
	?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td class="menubackgr">
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		  <td width="11%" style="padding-left:5px;">
		  <div id="myMenuID"></div>
			<script language="JavaScript" type="text/javascript">
			var myMenu =
			[
				[null,'Home','index.php',null,'Control Panel'],
				_cmSplit,
				[null,'Site',null,null,'Site Management',
					['<img src="../includes/js/ThemeOffice/config.png" />','Global Configuration','index.php?module=com_config',null,'Configuration'],
					['<img src="../includes/js/ThemeOffice/media.png" />','Media Manager','../editor/tmedit/popups/insert_image_en2.php','_blank','Manage Media Files'],
					['<img src="../includes/js/ThemeOffice/preview.png" />', 'Preview', '../index.php', '_blank', 'Preview'],
					['<img src="../includes/js/ThemeOffice/users.png" />','User Manager','index.php?module=com_users',null,'Manage users'],
				],
				_cmSplit,
				[null,'Menu',null,null,'Menu Management',
					['<img src="../includes/js/ThemeOffice/menus.png" />','Menu Manager','index.php?module=com_menumanager',null,'Menu Manager'],
					['<img src="../includes/js/ThemeOffice/menus.png" />','Add New Menu','index.php?module=com_menumanager&task=new',null,'Add New Menu']
				],
				_cmSplit,
				[null,'Content',null,null,'Content Management',
	  				['<img src="../includes/js/ThemeOffice/add_section.png" />','Section Manager','index.php?module=com_section',null,'Manage Content Sections'],
					['<img src="../includes/js/ThemeOffice/add_section.png" />','Category Manager','index.php?module=com_category',null,'Manage Content Categories'],
					_cmSplit,
					['<img src="../includes/js/ThemeOffice/edit.png" />','All Content Items','index.php?module=com_content',null,'Manage Content Items'],
					['<img src="../includes/js/ThemeOffice/edit.png" />','Add New Content','index.php?module=com_content&task=new',null,'Add New Content'],
					_cmSplit,
	  				['<img src="../includes/js/ThemeOffice/edit.png" />','Static Content Manager','index.php?module=com_static',null,'Manage Typed Content Items'],
				],
				_cmSplit,
				[null,'Products',null,null,'Product Management',
					['<img src="../includes/js/ThemeOffice/add_section.png" />','Product Section Manager','index.php?module=com_productsection',null,'Manage Product Sections'],
					['<img src="../includes/js/ThemeOffice/add_section.png" />','Product Category Manager','index.php?module=com_productcategory',null,'Manage Product Categories'],
					_cmSplit,
					['<img src="../includes/js/ThemeOffice/edit.png" />','All Product Items','index.php?module=com_product',null,'Manage Content Items'],
					['<img src="../includes/js/ThemeOffice/edit.png" />','Add New Product','index.php?module=com_product&task=new',null,'Add New Content'],
				],
				_cmSplit,
				[null,'Components',null,null,'Component Management',
					['<img src="../includes/js/ThemeOffice/component.png" />','Banners','index.php?module=com_banner',null,'Banner Management'],
					['<img src="../includes/js/ThemeOffice/globe2.png" />','Web Links','index.php?module=com_weblink',null,'Manage Weblinks'],
					['<img src="../includes/js/ThemeOffice/component.png" />','Advertisement','index.php?module=com_adv',null,'Advertisement'],
					['<img src="../includes/js/ThemeOffice/globe2.png" />','FAQs','index.php?module=com_faq',null,'Manage FAQs'],
				]
			];
			cmDraw ('myMenuID', myMenu, 'hbr', cmThemeOffice, 'ThemeOffice');
			//(id, menu, orient, nodeProperties, prefix)
			</script>			</td>
			<td width="56%" align="right">&nbsp;</td>
			<td width="33%" align="right"><?php echo $_SESSION['_username']; ?><a href="index.php?module=com_users&task=edit&showpermission=0&id=<?php echo $_SESSION['_idadmin']; ?>"> My Profile</a> <a href="index.php?module=com_logout" >Logout</a></td>
		  </tr>
			</table>
		  </td>
		  
		</tr>
		<tr>
		<td height="19"valign="top">
		<?php
		$module = "";
		if (isset($_REQUEST['module']))
			$module = $_REQUEST['module'];
		else if (isset($_GET['module']))
			$module = $_GET['module'];
		if ($module != "") {
			$pathfile = "components/" . $module . "/index.html.php";
			include ($pathfile);
		}
		else
			include("frontpage.php");
		mysql_close($csdl->ketnoi);
		?>
		</td>
		</tr>
	  </table>
	<?php
		}
	?>
	</td>
  </tr>
</table>
<div align="center" class="footer">
	<table width="99%" border="0">
	<tr>
		<td align="center">
			<div align="center">Powered by <a href="http://www.phannguyenit.com" target="_blank">Phan Nguyen</a></div>
			<div align="center" class="smallgrey">
			Version 1.0.3 Stable [ Sunfire ] 2 October 2007 10:45 GMT+7				</div>
	  </td>
	</tr>
	</table>
</div>
</body>
</html>