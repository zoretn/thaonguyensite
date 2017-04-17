<?php
checksupper() or die ("Access denied");
?>
<?php
switch ($task) {
	case "new":
	case "edit":
?>
		<table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td class="menudottedline" width="40%">
	<div class="pathway"><a href="index.php"><strong>Phan Nguyen</strong></a> / <a href="index.php?module=com_productsection">com_product_sections</a>/new</div>
	</td>
	<td class="menudottedline" align="right">
				<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
		<tr valign="middle" align="center">
						<td>
				<a class="toolbar" href="javascript:submitbutton('save')">
					<img src="images/save_f2.png"  alt="Order" name="reorder" align="middle" border="0" />					<br />
		  Save</a>			</td>
						<td>&nbsp;</td>
					<td>
			<a class="toolbar" href="javascript: submitbutton('cancel');"><img src="images/cancel_f2.png"  alt="Delete" name="remove" align="middle" border="0" /><br />
		  Cancel</a>		</td>
				</tr>
		</table>
	</td>
</tr>
</table>
<?php
		break;
	default:
?>
		<table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td class="menudottedline" width="40%">
	<div class="pathway"><a href="index.php"><strong>Phan Nguyen</strong></a> / com_product_sections</div>
	</td>
	<td class="menudottedline" align="right">
				<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
		<tr valign="middle" align="center">
						<td>
				<a class="toolbar" href="javascript:submitbutton('order')">
					<img src="images/copy_f2.png"  alt="Order" name="reorder" align="middle" border="0" />					<br />Reorder</a>			</td>
						<td>&nbsp;</td>
					<td>
			<a class="toolbar" href="javascript:if (document.adminForm.boxchecked.value == 0){ alert('Please make a selection from the list to delete'); } else if (confirm('Are you sure you want to delete selected items? ')){ submitbutton('remove');}"><img src="images/delete_f2.png"  alt="Delete" name="remove" align="middle" border="0" /><br />
			Delete</a>		</td>
					<td>&nbsp;</td>
					<td>
			<a class="toolbar" href="javascript:submitbutton('new');">
		  <img src="images/new_f2.png"  alt="New" name="new" align="middle" border="0" />				<br />New</a>		</td>
				</tr>
		</table>
	</td>
</tr>
</table>
<?php
		break;
}
?>