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
	$strcurpage = "Trang: ";
	$strtotalpage = "Số trang: ";
	$strgoto = "Trang: ";
	$strprevious = "Về trước";
	$strnext ="Tiếp";
	$paging = "";
	/////////totalRows
	if ($totalRows % $maxRows ==0)
		$totalPages = (int)($totalRows/$maxRows);
	else
		$totalPages = (int)($totalRows/$maxRows + 1);
	////////curRow
	if (isset($_REQUEST['curPage'])) $curPage = $_REQUEST['curPage'];
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
						$paging1 .= "GotoPage (".$i.")'>";
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