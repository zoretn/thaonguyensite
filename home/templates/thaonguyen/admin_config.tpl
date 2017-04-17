			<div class="title">{title}</div>

			<!-- BEGIN form -->
			<form name="frmNav" action="{form.action}" method="post" onSubmit="CheckConfig(frmNav, '{form.text_save}'); return false">
			<input type="hidden" name="m" value="{form.module}">
			<input type="hidden" name="f" value="{form.file}">
			<input type="hidden" name="act" value="send">
			<input type="hidden" name="p" value="{form.page}">
			<input type="hidden" name="id" value="{form.id}">
			<table class="thead" width="100%" border="0" cellspacing="0" cellpadding="2">
			<tr>
				<td nowrap width="99%"><input class="button" type="button" value="{form.text_return}" onClick="javascript:OpenLink('{form.return}');"></td>
				<td nowrap><input class="button" type="reset" value="{form.text_reset}"></td>
				<td nowrap><input class="submit" type="submit" value="{form.text_submit}"></td>
			</tr>
			</table>
			<table class="tborder" width="100%" border="0" cellspacing="1" cellpadding="2">
			<tr>
				<td nowrap class="tfirst"><b>{form.text_name}</b></td>
				<td nowrap width="99%" class="tfirst"><b>{form.text_value}</b></td>
			</tr>
			<tr>
				<td nowrap class="trow"><input class="textbox" type="text" name="config_name" value="{form.config_name}" style="width:200px" maxlength="32"></td>
				<td nowrap class="trow"><input class="textbox" type="text" name="config_value" value="{form.config_value}" style="width:500px" maxlength="255"></td>
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
				<td nowrap><input class="button" type="button" value="{navigation.text_refresh}" onClick="javascript:submit(frmNav)"></td>
				<td nowrap width="99%" align="right">
				<!-- BEGIN button -->
				<input class="submit" type="button" value="{navigation.button.text}" onClick="javascript:OpenLink('{navigation.button.link}');">
				<!-- END button -->
				</td>
			</tr>
			</form>
			</table>
			<!-- END navigation -->

			<!-- BEGIN configlist -->
			<table width="100%" class="tborder" border="0" cellspacing="1" cellpadding="2">
			<tr>
				<td nowrap width="30" class="tfirst"><b>{configlist.text_stt}</b></td>
				<td nowrap width="100" class="tfirst"><b>{configlist.text_name}</b></td>
				<td nowrap class="tfirst"><b>{configlist.text_value}</b></td>
				<td nowrap class="tfirst">&nbsp;</td>
			</tr>
			<!-- BEGIN config -->
			<tr>
				<td nowrap class="trow{configlist.config.class}">{configlist.config.stt}</td>
				<td nowrap class="trow{configlist.config.class}"><b class="link">{configlist.config.name}</b></td>
				<td class="trow{configlist.config.class}">{configlist.config.value}</td>
				<td nowrap class="trow{configlist.config.class}">
				<!-- BEGIN control -->
				<img class="pointer" src="images/{configlist.config.control.icon}.gif" border="0" width="16" height="16" onClick="javascript:{configlist.config.control.function}" title="{configlist.config.control.text_title}">
				<!-- END control -->
				</td>
			</tr>
			<!-- END config -->
			<!-- BEGIN total -->
			<tr>
				<td nowrap class="ttotal">&nbsp;</td>
				<td nowrap class="ttotal">{configlist.total.text_total}: <b>{configlist.total.total}</b></td>
				<td nowrap class="ttotal">&nbsp;</td>
				<td nowrap class="ttotal">&nbsp;</td>
			</tr>
			<!-- END total -->
			</table>
			<!-- END configlist -->

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
