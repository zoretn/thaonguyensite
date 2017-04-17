<?php
defined("_ALLOW") or die ("Access denied");
include_once("class/cstaticcontent.php");
global $objstaticcontent;
global $lang;
//$objstaticcontent = new staticcontent;
$id = $_GET['id'];
$objstaticcontent = $objstaticcontent->Doc($id);
echo $objstaticcontent->Out_TheHien(0);
?>