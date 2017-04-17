<script language="javascript">
function showhidepart(idobj) {
	var obj = document.getElementById(idobj);
	var status = "";
	status = obj.style.display;
	if (status == "")
		status = "none";
	else
		status = "";
	obj.style.display = status;
}
</script>
<div class="title_category">FAQs</div>
<div class="td_bodycontent">
<?php
defined ("_ALLOW") or die ('Access denied');
include_once ("class/cfaq.php");
global $objfaq;
?>
<?php
$array = $objfaq->Doc_danh_sach();
if ($array!=null) {
	foreach ($array as $objfaq)
		$objfaq->Out_TheHien_TT();
}
?>
</div>