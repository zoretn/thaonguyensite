		<!-- BEGIN form -->
		<form name="frmlogin" action="{form.action}" method="post">
		<input type="hidden" name="act" value="send">
		<input type="hidden" name="m" value="{form.module}">
		<input type="hidden" name="f" value="{form.file}">
		<input type="hidden" name="redirect" value="{form.redirect}">
		<table class="thead" border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td nowrap><input class="button" type="button" value="{form.text_return}" onClick="javascript:OpenLink('{form.return}');"></td>
			<td nowrap><input class="button" type="reset" value="{form.text_reset}"></td>
			<td nowrap><input class="button" type="submit" value="{form.text_submit}"></td>
			<td width="99%" align="right">{form.intro}</td>
		</tr>
		</table>
		<table class="tborder" width="100%" border="0" cellspacing="1" cellpadding="2">
		<tr>
			<td nowrap class="tfirst"><b>{form.text_username}</b></td>
			<td nowrap class="tfirst"><b>{form.text_password}</b></td>
			<td nowrap width="99%" class="tfirst">&nbsp;</td>
		</tr>
		<tr>
			<td class="trow"><input class="textbox" type="text" name="username" size="50" value="{form.username}" style="width:170px"></td>
			<td class="trow"><input class="textbox" type="password" name="password" size="50" value="{form.password}" style="width:170px"></td>
			<td nowrap class="trow">&nbsp;</td>
		</tr>
		</table>
		</form>
		<!-- END form -->