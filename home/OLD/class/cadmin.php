<?php
defined("_ALLOW") or die ("Access denied");
?>
<?php
class admin {
	var $id;
	var $username;
	var $password;
	var $fullname;
	var $email;
	var $ym;
	var $supper = 0;
	var $grantcat = "";
	var $grantproductcat = "";
	var $grantfaq = 0;
	var $grantstatic = 0;
	var $grantadv = 0;
	var $grantbanner = 0;
	var $grantlink = 0;
	
	function Fill ($strwhere="") {
		global $csdl;
		$strsql = "SELECT * FROM admin";
		if ($strwhere!="") {
			$strsql .= " WHERE " . $strwhere;
		}
		$strsql .= " ORDER BY username";
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
	function Doc ($id) {
		$rowarray = $this->Fill ("id=$id");
		if ($rowarray==null)
			return null;
		else
			return $rowarray[0];
	}
	function Xoa () {
		checksupper() or die ("Access denied");
		global $csdl;
		$csdl->Xoa("admin","id=$this->id");
		return 1;
	}
	function DocForm () {
		$this->id = $_REQUEST['id'];
		$this->username = $_REQUEST['username'];
		$this->password = $_REQUEST['password'];
		$this->fullname = $_REQUEST['fullname'];
		$this->email = $_REQUEST['email'];
		$this->ym = $_REQUEST['ym'];
		$this->supper = "0";
		$this->grantcat = "";
		$this->grantproductcat = "";
		$this->grantfaq = "0";
		$this->grantstatic = "0";
		$this->grantadv = "0";
		$this->grantbanner = "0";
		$this->grantlink = "0";
		if (isset($_REQUEST['grantpermission'])) {
			if (isset($_REQUEST['chksupper'])) $this->supper = "1";
			if (isset($_REQUEST['grantcat']))
				$this->grantcat .= $this->Set_StrGrantCat($_REQUEST['grantcat']);
			if (isset($_REQUEST['grantproductcat']))
				$this->grantproductcat .= $this->Set_StrGrantCat($_REQUEST['grantproductcat']);
			if (isset($_REQUEST['grantfaq'])) $this->grantfaq = "1";
			if (isset($_REQUEST['grantstatic'])) $this->grantstatic = "1";
			if (isset($_REQUEST['grantadv'])) $this->grantadv = "1";
			if (isset($_REQUEST['grantbanner'])) $this->grantbanner = "1";
			if (isset($_REQUEST['grantlink'])) $this->grantlink = "1";
		}
	}
	function DocForm2() {
		$this->id = $_REQUEST['id'];
		$this->username = $_REQUEST['username'];
		$this->password = $_REQUEST['password'];
		$this->fullname = $_REQUEST['fullname'];
		$this->email = $_REQUEST['email'];
		$this->ym = $_REQUEST['ym'];
	}
	function Khoi_tao ($rowdb) {
		$kq = new admin;
		$kq->id = $rowdb['id'];
		$kq->username = $rowdb['username'];
		$kq->password = $rowdb['password'];
		$kq->fullname = $rowdb['fullname'];
		$kq->email = $rowdb['email'];
		$kq->ym = $rowdb['ym'];
		$kq->supper = $rowdb['supper'];
		$kq->grantcat = $rowdb['grantcat'];
		$kq->grantproductcat = $rowdb['grantproductcat'];
		$kq->grantfaq = $rowdb['grantfaq'];
		$kq->grantstatic = $rowdb['grantstatic'];
		$kq->grantbanner = $rowdb['grantbanner'];
		$kq->grantadv = $rowdb['grantadv'];
		$kq->grantlink = $rowdb['grantlink'];
		return $kq;
	}
	function Ghi () {
		checkadmin() or die ("Access denied");
		global $csdl;
		if ($this->id > -1) {
			(checksupper() or $_SESSION['_idadmin']==$this->id) or die ("Access denied");
			$strsql  = "UPDATE `admin` SET ";
			$strsql .= "`username` = '$this->username', ";
			if ($this->password != "")
				$strsql .= "`password` = md5('$this->password'), ";
			$strsql .= "`fullname` = '$this->fullname', ";
			$strsql .= "`email` = '$this->email', ";
			$strsql .= "`ym` = '$this->ym' ";
			if (isset($_REQUEST['grantpermission'])) {
				$strsql .= ", `supper` = $this->supper";
				$strsql .= ", `grantcat` = '$this->grantcat'";
				$strsql .= ", `grantproductcat` = '$this->grantproductcat'";
				$strsql .= ", `grantfaq` = $this->grantfaq";
				$strsql .= ", `grantstatic` = $this->grantstatic";
				$strsql .= ", `grantbanner` = $this->grantbanner";
				$strsql .= ", `grantadv` = $this->grantadv";
				$strsql .= ", `grantlink` = $this->grantlink ";
			}
			$strsql .= "WHERE id=$this->id";
		}
		else {
			checksupper() or die ("Access denied");
			$strsql  = "INSERT INTO `admin`(`username`, `password`, `fullname`, `email`, `ym`, `supper`, `grantcat`, `grantproductcat`, `grantfaq`, `grantstatic`, `grantbanner`, `grantadv`, `grantlink`) ";
			$strsql .= "VALUES ('$this->username', md5('$this->password'), '$this->fullname', '$this->email', '$this->ym', $this->supper, '$this->grantcat', '$this->grantproductcat', $this->grantfaq, $this->grantstatic, $this->grantbanner, $this->grantadv, $this->grantlink)";
		}
		$csdl->Ghi($strsql);
	}
	function Get_ArrayGrantCat($stylecat) {
		$strarray = "";
		switch ($stylecat) {
			case "cat":
				$strarray = $this->grantcat;
				break;
			case "productcat":
				$strarray = $this->grantproductcat;
				break;
		}
		$resultarray = array();
		$flag = false;
		$tarray = explode("#",$strarray);
		if (is_array($tarray)) {
			$count = count($tarray);
			for ($i=0; $i<$count; $i++) {
				if ($tarray[$i]!="") {
					$resultarray[$i] = $tarray[$i];
					$flag = true;
				}
			}
		}
		if ($flag)
			return $resultarray;
		else
			return null;
	}
	function Set_StrGrantCat($arraygrant) {
		$strresult = "";
		if (is_array($arraygrant)) {
			foreach ($arraygrant as $grant) {
				if ($strresult != "") $strresult .= "#";
				$strresult .= $grant;
			}
		}
		return $strresult;
	}
};
global $objadmin; $objadmin = new admin;
?>