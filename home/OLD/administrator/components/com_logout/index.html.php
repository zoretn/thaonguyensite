<?php
defined("_ALLOW") or die ("Access denied");
?>
<?php
checkadmin() or die ("Access denied");
?>
<?php
unset($_SESSION['_idadmin']);
unset($_SESSION['_username']);
unset($_SESSION['supper']);
unset($_SESSION['grantfaq']);
unset($_SESSION['grantstatic']);
unset($_SESSION['grantadv']);
unset($_SESSION['grantbanner']);
unset($_SESSION['grantlink']);
unset($_SESSION['grantcat']);
unset($_SESSION['grantproductcat']);
session_unset();
?>
<?php
/*echo "<script language='javascript'>location.href=\"../index.php\";</script>";*/
mosRedirect("../index.php");
?>