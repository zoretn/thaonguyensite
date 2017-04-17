<?php
defined('_ALLOW') or die ('Access denied');
?>
<?php
class CSDL {
	var $ketnoi;
	var $dulieu;

	var $sql;
	var $ketqua;
	var $sodong=0;
	
	function Init () {
		global $cfg_dbhost;
		global $cfg_dbadmin;
		global $cfg_dbpass;
		global $cfg_dbname;
		$this->ketnoi = mysql_connect ($cfg_dbhost,$cfg_dbadmin,$cfg_dbpass)
		or die ('Cannot connect to Database');
		$this->dulieu = mysql_select_db ($cfg_dbname,$this->ketnoi)
		or die ('Cannot select Database');
	}
	
	function set_sql ($strsql) {
		$this->sql = $strsql;
	}
	function get_sql () {
		return $this->sql;
	}
	
	function Truyvan ($strsql="") {
		$str=$strsql;
		if ($str=="")
			$str=$this->sql;
		$rows=mysql_query($str,$this->ketnoi);
		$this->ketqua = $rows;
		if ($this->ketqua!=false)
			$this->sodong=mysql_num_rows($rows);
		else
			$this->sodong = 0;
		return $rows;
	}
	function Ghi ($strsql) {
		mysql_query($strsql,$this->ketnoi) or die ('Cannot write to database');
	}
	
	function Xoa ($strtable, $strwhere="") {
		$strquery = "DELETE FROM ".$strtable;
		if ($strwhere!="")
			$strquery .= " WHERE ". $strwhere;
		mysql_query($strquery,$this->ketnoi);
	}
	function get_sodong () {
		return $this->sodong;
	}
};
global $csdl; $csdl = new CSDL;
$csdl->Init();
?>