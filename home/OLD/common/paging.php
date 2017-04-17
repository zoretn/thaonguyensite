<?php
defined ("_ALLOW") or die ('Access denied');
?>
<?php //Tính tổng số trang
function Paging_GetPaging () {
	global $totalRows;
	global $totalPages;
	global $maxRows;
	global $curPage;
	global $maxPages;
	global $curRow;
	global $lang;
	$strcurpage = "Trang: ";
	$strtotalpage = "Số trang: ";
	$strgoto = "Trang: ";
	$strprevious = "Về trước";
	$strnext ="Tiếp";
	if ($lang=="en") {
		$strcurpage = "Current Page: ";
		$strtotalpage = "Total Page: ";
		$strgoto = "Page: ";
		$strprevious = "Previous ";
		$strnext = "Next";
	}

	$paging = "";
	/////////totalRows
	if ($totalRows % $maxRows ==0)
		$totalPages = (int)($totalRows/$maxRows);
	else
		$totalPages = (int)($totalRows/$maxRows + 1);
	////////curRow
	if (isset($_GET['curPage']))
		$curPage = $_GET['curPage'];
	else if (isset($_REQUEST['curPage']))
		$curPage = $_REQUEST['curPage'];
	
	$curRow = ($curPage-1)*$maxRows + 1;
	
	if ($totalRows>$maxRows) {
		$start = 1;
		$end = 1;
		$paging1 = "";
		for ($i=1; $i<=$totalPages; $i++) {
			if (($i>((int)(($curPage-1)/$maxPages))*$maxPages) && ($i<=((int)(($curPage-1)/$maxPages+1))*$maxPages))
				{
					if ($start==1) $start = $i;
					if ($i==$curPage)
						$paging1 .= "[$i]" . "&nbsp;&nbsp;";
					else {
						$paging1 .= "<a href='javascript:";
						$paging1 .= "GotoPage (".$i.")' >";
						$paging1 .= $i . "</a>&nbsp;&nbsp;";
					}
					$end = $i;
				}
		}
		$paging .= $strgoto;
		if ($curPage>$maxPages) {
			$paging .= "<a href='javascript:";
			$paging .= "GotoPage(".($start-1).")'>";
			$paging .= $strprevious . "</a>&nbsp;&nbsp;";
		}
		$paging .= $paging1;
		if (((int)(($curPage-1)/$maxPages+1)*$maxPages)<$totalPages) {
			$paging .= "<a href='javascript:";
			$paging .= "GotoPage(".($end+1).")'>";
			$paging .= $strnext . "</a>&nbsp;&nbsp;";
		}
	}
	if ($paging != "") $paging = "<div class='paging'>" . $paging . "</div>";
	return $paging;
}
?>
<?php
function Paging_Get_List_Content ($array) {
	global $curRow;
	global $totalRows;
	global $curPage;
	global $maxRows;
	$paging = Paging_GetPaging ();
	$inewarray=0;
	if ($totalRows>0) {
		$low = $curRow;
		for ($i=$curRow; ($i<=$totalRows && $i<=$curPage * $maxRows); $i++) {
			$newarray[] = $array[$i-1];
			$inewarray++;
		}
	}
	if ($inewarray==0) return null;
	return $newarray;
}
?>
<?php
function Paging_List_Content_TT ($array, $colnums=2) {
	global $maxwidthimage;
	$percent = 100/$colnums;
	$percent .= "%";
	echo "<table border='0' cellspacing='0' cellpadding='0' width='100%'>";
	$col=0;
	$tcount = count($array);
	if ($tcount>0) {
		$col = 0;
		$current_td = 0;
		$current_row = 0;
		for ($i=1; $i<=$tcount; $i++) {
			if ($col==0)
				echo "<tr class='row$current_row'>";
			echo "<td class='td$current_td' valign='top' width='$percent' >";
			$array[$i-1]->Out_TheHien_TT($maxwidthimage);
			echo "</td>";
			$col++;
			$current_td++;
			if ($col==$colnums) {
				echo "</tr>";
				$current_row = 1 - $current_row;
				$col=0;
				$current_td = 0;
			}
		}
	}
	if ($col<$colnums) {
		for (; $col < $colnums; $col++) echo "<td width='$percent'></td>";
		echo "</tr>";
	}
	echo "</table>";
}
function Paging_List_Content_TT_All ($array, $colnums=2) {
	global $maxwidthimage;
	$percent = 100/$colnums;
	$percent .= "%";
	$strout = "<table border='0' cellspacing='0' cellpadding='0' width='100%'>";
	$col=0;
	$current_td = 0;
	$current_row = 0;
	foreach ($array as $obj) {
		if ($col==0) {
			$strout .= "<tr class='row$current_row'>";
		}
		$strout .= "<td class='td$current_td'>";
		$strout .= $obj->Out_TheHien_TT($maxwidthimage);
		$strout .= "</td>";
		$col++;
		$current_td++;
		if ($col==$colnums) {
			$strout .= "</tr>";
			$current_row = 1 - $current_row;
			$col=0;
			$current_td = 0;
		}
	}
	if ($col<$colnums) {
		for (; $col < $colnums; $col++) $strout .= "<td width='$percent'></td>";
		$strout .= "</tr>";
	}
	$strout .= "</table>";
	return $strout;
}

function Paging_content_foot ($array, $colnums=2) {
	global $maxwidthimage;	
	$percent = 100/$colnums;
	$percent .= "%";
	$strout = "";
	$close = 1;
	$col = 0;
	$row = 0;
	$current_td = 0;
	echo "<table border='0' cellspacing='0' cellpadding='0' align='center' width='100%' >";
	$count = count($array);
	for ($i=0; $i<$count; $i++) {
		if ($col==0)
			echo "<tr class='row$row'>";
		echo "<td class='td$current_td' width='$percent' valign='top'>";
		$array[$i]->Out_TheHien_TT_Foot($maxwidthimage);
		echo "</td>";
		$col++;
		if ($col==$colnums) {
			echo "</tr>";
			$row = 1 - $row;
			$col=0;
		}
		$current_td++;
		if ($current_td == $colnums) $current_td = 0;
	}
	if ($col<$colnums) {
		for (; $col < $colnums; $col++) echo "<td width='$percent'></td>";
		echo "</tr>";
	}
	echo "</table>";
}
function Paging_output_foot ($array, $colnums=2) {
	$paging = Paging_GetPaging ();
	Paging_content_foot($array, $colnums);
	echo $paging;
}
?>