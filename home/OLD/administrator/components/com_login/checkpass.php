<?php
defined('_ALLOW') or die ('Access denied');
function mahoa ($strpassword) {
	$ma = $strpassword;
	return $ma;
}
function giaima ($strpassword) {
	$giai = md5($strpassword);
	return $giai;
}

function kiemtra ($strusername, $strpassword) {
	global $csdl;
//	$strpassword = mahoa ($strpassword);
	$strsql = "SELECT * from admin where username='$strusername' and password=md5('$strpassword')";
	$rows = $csdl->Truyvan($strsql);
	if ($rows!=false) {
		while ($row = mysql_fetch_array($rows,MYSQL_ASSOC)) {
			$_SESSION['_idadmin'] = $row['id'];
			$_SESSION['_username'] = $row['username'];
			$_SESSION['supper'] = $row['supper'];
			$_SESSION['grantfaq'] = $row['grantfaq'];
			$_SESSION['grantstatic'] = $row['grantstatic'];
			$_SESSION['grantadv'] = $row['grantadv'];
			$_SESSION['grantbanner'] = $row['grantbanner'];
			$_SESSION['grantlink'] = $row['grantlink'];
			
			$_SESSION['grantcat'] = array();
			$strgrantcat = $row['grantcat'];
			$arraygrant = explode("#",$strgrantcat);
			if (is_array($arraygrant)) {
				$count = count($arraygrant);
				for ($i=0; $i<$count; $i++)
					$_SESSION['grantcat'][$i] = $arraygrant[$i];
			}
			
			$_SESSION['grantproductcat'] = array();
			$strgrantcat = $row['grantproductcat'];
			$arraygrant = explode("#",$strgrantcat);
			if (is_array($arraygrant)) {
				$count = count($arraygrant);
				for ($i=0; $i<$count; $i++)
					$_SESSION['grantproductcat'][$i] = $arraygrant[$i];
			}
			break;
		}
	}
	$ketqua = $csdl->get_sodong();
	return $ketqua;
}
function changepass ($username, $newpassword) {
	global $csdl;
	$password = mahoa ($newpassword);
	$strsql .= "UPDATE admin ";
	$strsql .= "SET password='$password' ";
	$strsql .= "WHERE username='$username'";
	$csdl->Ghi($strsql);
}
?>