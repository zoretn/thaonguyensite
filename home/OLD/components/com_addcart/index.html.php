<?php
defined("_ALLOW") or die ("Access denied");
?>
<?php
isset($_REQUEST['task']) or die ("Access denied");
$task = $_REQUEST['task'];
($task == "add") or die ("Access denied");
?>
<?php
$itemnumber = $_REQUEST['productid'];
$itemname = $_REQUEST['productname'];
$itemquanlity = $_REQUEST['productquanlity'];
$itemprice = $_REQUEST['productprice'];
$itemfprice = $_REQUEST['productfprice'];
if (!isset($_SESSION['item'])) {
	$_SESSION['item'][] = $itemnumber;
	$_SESSION['itemname'][] = htmlspecialchars($itemname);
	$_SESSION['itemquanlity'][] = $itemquanlity;
	$_SESSION['itemprice'][] = $itemprice;
	$_SESSION['itemfprice'][] = $itemfprice;
}
else {
	$arrayitem = $_SESSION['item'];
	$length = count($arrayitem);
	$i=0;
	$flag = 0;
	while ($i<$length && $arrayitem[$i] != $itemnumber) {
		$i++;
	}
	if ($i<$length) {
		$_SESSION['itemquanlity'][$i] += $itemquanlity;
		$flag = 1;
		$i = 0;
	}
	if ($flag == 0) {
		while ($i<$length && $arrayitem[$i]!=-1) {
			$i++;
		}
		$_SESSION['item'][$i] = $itemnumber;
		$_SESSION['itemname'][$i] = $itemname;
		$_SESSION['itemquanlity'][$i] = $itemquanlity;
		$_SESSION['itemprice'][$i] = $itemprice;
		$_SESSION['itemfprice'][$i] = $itemfprice;
	}
}
mosRedirect("index.php?module=com_shoppingcart");
?>