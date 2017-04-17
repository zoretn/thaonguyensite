<?php
global $expirtime;
$expirtime = 10*60;
class session {
	var $id;
	var $begin;
	function getsession () {
//		$this->id = SID;
		$this->id = session_id();
		return $this->id;
	}
	function writesession () {
		$this->getsession();
		global $expirtime;
		global $csdl;
		$strsql = "select * from `sessions` where `id`='$this->id'";
		$rowsdb = $csdl->Truyvan($strsql);
		$i=0;
		$time = time();
		if ($rowsdb != false) {
			//// Ghi session hien tai
			while ($row = mysql_fetch_array($rowsdb,MYSQL_ASSOC)) {
				$i=1;
				$strsql  = "UPDATE `sessions` SET ";
				$strsql .= "`begin`=$time ";
				$strsql .= "WHERE `id`='$this->id'";
			}
		}
		if ($i==0) {
			$strsql  = "INSERT INTO `sessions` (`id`, `begin`) ";
			$strsql .= "VALUES('$this->id',$time)";
		}
		$csdl->Ghi($strsql);
		/////Xoa session cu
		$csdl->Xoa("`sessions`", "(`begin` + $expirtime < $time)");
	}
	function counter () {
		global $expirtime;
		global $csdl;
		$count = 0;
		$timenow = time();
		$tmp = $timenow - $expirtime;
		$strsql  = "SELECT * FROM `sessions` ";
		$strsql .= "WHERE `begin` >= $tmp";
		$rowsdb = $csdl->Truyvan($strsql);
		return $csdl->get_sodong();
	}
};
global $objsession; $objsession = new session;
?>