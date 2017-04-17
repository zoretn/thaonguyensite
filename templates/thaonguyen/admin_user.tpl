			<div class="title">{title}</div>

			<!-- BEGIN form -->
			<form name="frmNav" action="{form.action}" method="post" onSubmit="CheckUser(frmNav, '{form.text_save}'); return false">
			<input type="hidden" name="m" value="{form.module}">
			<input type="hidden" name="f" value="{form.file}">
			<input type="hidden" name="act" value="send">
			<input type="hidden" name="id" value="{form.iduser}">
			<input type="hidden" name="p" value="{form.page}">
			<table class="thead" width="100%" border="0" cellspacing="0" cellpadding="2">
			<tr>
				<td nowrap width="99%"><input class="button" type="button" value="{form.text_return}" onClick="javascript:OpenLink('{form.return}');"></td>
				<td nowrap><input class="button" type="reset" value="{form.text_reset}"></td>
				<td nowrap><input class="submit" type="submit" value="{form.text_submit}"></td>
			</tr>
			</table>
			<table class="tborder" width="100%" border="0" cellspacing="1" cellpadding="2">
			<tr>
				<td nowrap width="150" class="tfirst"><b>{form.text_username}</b></td>
				<td nowrap width="150" class="tfirst"><b>{form.text_fullname}</b></td>
				<td nowrap width="150" class="tfirst"><b>{form.text_email}</b></td>
			</tr>
			<tr>
				<td nowrap class="trow"><input class="textbox" type="text" name="username" value="{form.username}" style="width:160px"{form.disabled_user}></td>
				<td nowrap class="trow"><input class="textbox" type="text" name="fullname" value="{form.fullname}" style="width:160px"></td>
				<td nowrap class="trow"><input class="textbox" type="text" name="email" value="{form.email}" style="width:200px"></td>
			</tr>
			<tr>
				<td nowrap width="100" class="tfirst"><b>{form.text_password}</b></td>
				<td nowrap width="100" class="tfirst"><b>{form.text_repassword}</b></td>
				<td nowrap width="99%" class="tfirst"><b>{form.text_priv}</b></td>
			</tr>
			<tr>
				<td nowrap class="trow"><input class="textbox" type="password" name="password" value="{form.password}" style="width:160px"></td>
				<td nowrap class="trow"><input class="textbox" type="password" name="repassword" value="{form.repassword}" style="width:160px"></td>
				<td nowrap class="trow"><select class=textbox name="admin" size=1 style="width:200px">
				<!-- BEGIN optionpriv -->
					<option value="{form.optionpriv.value}"{form.optionpriv.selected}>{form.optionpriv.text}</option>
				<!-- END optionpriv -->
				</select></td>
			</tr>
			</table>
			</form>
			<!-- END form -->

			<!-- BEGIN navigation -->
			<table class="thead" width="100%" border="0" cellspacing="0" cellpadding="2">
			<form name="frmNav" action="{navigation.action}" method="get">
			<input type="hidden" name="m" value="{navigation.module}">
			<input type="hidden" name="f" value="{navigation.file}">
			<tr>
				<td nowrap><input class="textbox" type="text" name="k" value="{navigation.keyword}"></td>
				<td nowrap>{navigation.text_status}:</td>
				<td nowrap><select class="textbox" name="st" size=1 style="width:100px" onChange="javascript:submit(frmNav);">
				<!-- BEGIN optionstatus -->
					<option value="{navigation.optionstatus.value}"{navigation.optionstatus.selected}>{navigation.optionstatus.text}</option>
				<!-- END optionstatus -->
				</select></td>
				<td nowrap><input class="button" type="button" value="{navigation.text_refresh}" onClick="javascript:submit(frmNav)"></td>
				<td nowrap align="right" width="99%">
				<!-- BEGIN button -->
				<input class="submit" type="button" value="{navigation.button.text}" onClick="javascript:OpenLink('{navigation.button.link}');">
				<!-- END button -->
				</td>
			</tr>
			</form>
			</table>
			<!-- END navigation -->
			<!-- BEGIN userlist -->
			<table width="100%" class="tborder" border="0" cellspacing="1" cellpadding="2">
			<tr>
				<td nowrap width="30" class="tfirst"><b>{userlist.text_stt}</b></td>
				<td nowrap width="15" class="tfirst">&nbsp;</td>
				<td nowrap width="300" class="tfirst"><b>{userlist.text_username}</b></td>
				<td nowrap class="tfirst" align="center"><b>{userlist.text_priv}</b></td>
				<td nowrap class="tfirst">&nbsp;</td>
			</tr>
			<!-- BEGIN user -->
			<tr>
				<td nowrap class="trow{userlist.user.class}">{userlist.user.stt}</td>
				<td nowrap class="trow{userlist.user.class}"><img src="images/stat_{userlist.user.status}.gif" border="0" width="11" height="11"></td>
				<td nowrap class="trow{userlist.user.class}"><b class="link">{userlist.user.username}</b><br><span class="grey">{userlist.user.fullname} - {userlist.user.text_email}: {userlist.user.email}</a></td>
				<td nowrap class="trow{userlist.user.class}" align="center">{userlist.user.priv}</td>
				<td nowrap class="trow{userlist.user.class}">
				<!-- BEGIN control -->
				<img class="pointer" src="images/{userlist.user.control.icon}.gif" border="0" width="16" height="16" onClick="javascript:{userlist.user.control.function}" title="{userlist.user.control.text_title}">
				<!-- END control -->
				</td>
			</tr>
			<!-- END user -->
			<!-- BEGIN total -->
			<tr>
				<td nowrap class="ttotal">&nbsp;</td>
				<td nowrap class="ttotal">&nbsp;</td>
				<td nowrap class="ttotal">{userlist.total.text_total}: <b>{userlist.total.total}</b></td>
				<td nowrap class="ttotal">&nbsp;</td>
				<td nowrap class="ttotal">&nbsp;</td>
			</tr>
			<!-- END total -->
			</table>
			<!-- END userlist -->

			<!-- BEGIN pagenav -->
			<p style="margin-top:6px"><table width="100%" border="0" cellpadding="2" cellspacing="0">
			<tr>
				<form action="{pagenav.action}" method="get">
				<td width="99%" nowrap>
				<!-- BEGIN page -->
				<a class="page" href="{pagenav.page.link}">{pagenav.page.text}</a>
				<!-- END page -->
				</td>
				<td nowrap>{pagenav.text_gopage}:</td>
				<td><select class="textbox" name="p" size="1" onChange="javascript:window.location.href=this.options[this.selectedIndex].value">
				<!-- BEGIN optionpage -->
					<option value="{pagenav.optionpage.value}"{pagenav.optionpage.selected}>{pagenav.optionpage.text}</option>
				<!-- END optionpage -->
				</select></td>
				</form>
			</tr>
			</table>
			<!-- END pagenav -->

			<!-- BEGIN message -->
			<p align="left" style="margin:20px 0px">{message.text}
			<!-- END message -->
		