<?php
defined("_ALLOW") or die ("Access denied");
?>
<?php
function loadmodule ($module, $title, $title_en, $strwhere="") {
	global $moduletitle, $moduletitle_en;
	$moduletitle = $title;
	$moduletitle_en = $title_en;
	$file = "modules/" . $module . "/index.mod.php";
	include ($file);
}
function loadmenu ($position,$style) {
	include_once ("modules/mod_menu/index.mod.php");
	showmenu($position, $style);
}
function loadmenu2 ($position,$style, $cmThemeOffice, $ThemeOffice) {
	include_once ("modules/mod_menu2/index.mod.php");
	showmenu2($position, $style, $cmThemeOffice, $ThemeOffice);
}
function loadmainbody () {
	$module = "com_frontpage";
	if (isset($_GET['module'])) $module = $_GET['module'];
	$file = "components/$module/index.html.php";
	include_once ($file);
}
function mosRedirect( $url, $msg="" ) {

	if (trim( $msg )) {
	 	if (strpos( $url, '?' )) {
			$url .= '&mosmsg=' . urlencode( $msg );
		} else {
			$url .= '?mosmsg=' . urlencode( $msg );
		}
	}

	if (headers_sent()) {
		echo "<script>document.location.href='$url';</script>\n";
	} else {
		@ob_end_clean(); // clear output buffer
		header( 'HTTP/1.1 301 Moved Permanently' );
		header( "Location: ". $url );
	}
	exit();
}
?>