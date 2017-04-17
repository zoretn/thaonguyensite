<?php
checksupper() or die ("Access denied");
?>
<?php
switch ($task) {
	case "new":
?>
		<table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td class="menudottedline" width="40%">
	<div class="pathway"><a href="index.php"><strong>Phan Nguyen</strong></a> / com_menus/new</div>
	</td>
	<td class="menudottedline" align="right">
				<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
		<tr valign="middle" align="center">
		                <td>
				<a class="toolbar" href="javascript:if (document.adminForm.boxchecked.value == 0){ alert('Please make a selection from the list to Next');}else{submitbutton('edit')}">
					<img src="images/next_f2.png"  alt="Next" name="next" align="middle" border="0" />					<br />
		  Next</a>			</td>
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
	case "edit":
?>
<table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td class="menudottedline" width="40%">
	<div class="pathway"><a href="index.php"><strong>Phan Nguyen</strong></a> / com_menus/edit</div>
	</td>
	<td class="menudottedline" align="right">
				<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
		<tr valign="middle" align="center">
		<?php if (!isset($_GET['id'])) { ?>
		<td>
				<a class="toolbar" href="index.php?module=com_menu&menutype=<?php echo $menutype; ?>&task=new">
					<img src="images/back_f2.png"  alt="Next" name="next" align="middle" border="0" />					<br />
		  Back</a>			</td>
						<td>&nbsp;</td>
		<?php } ?>
		                <td>
				<a class="toolbar" href="javascript:submitbutton('save');">
					<img src="images/save_f2.png"  alt="Save" name="save" align="middle" border="0" />					<br />
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
	<div class="pathway"><a href="index.php"><strong>Phan Nguyen</strong></a> / com_menus</div>
	</td>
	<td class="menudottedline" align="right">
				<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
		<tr valign="middle" align="center">
						<td>
				<a class="toolbar" href="javascript:if (document.adminForm.boxchecked.value == 0){ alert('Please make a selection from the list to copy'); } else{ submitbutton('<?php if ($task=="copy") echo "copymenusave"; else echo "copy"; ?>');}">
					<img src="images/copy_f2.png"  alt="Copy" name="copy" align="middle" border="0" />					<br /><?php if ($task=="copy") echo "Save copy"; else echo "Copy"; ?></a>			</td>
						<td>&nbsp;</td>
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