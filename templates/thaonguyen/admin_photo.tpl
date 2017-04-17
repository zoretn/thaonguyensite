		<div class="title">{title}</div>

		<!-- BEGIN form -->
		<form name="frmNav" action="{form.action}" method="post" enctype="multipart/form-data" onSubmit="CheckPhoto(frmNav, '{form.text_save}'); return false">
		<input type="hidden" name="m" value="{form.module}">
		<input type="hidden" name="f" value="{form.file}">
		<input type="hidden" name="act" value="send">
		<input type="hidden" name="or" value="{form.or}">
		<input type="hidden" name="st" value="{form.st}">
		<input type="hidden" name="t" value="{form.type}">
		<input type="hidden" name="p" value="{form.page}">
		<input type="hidden" name="id" value="{form.idphoto}">
		<table class="thead" width="100%" border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td nowrap><input class="button" type="button" value="{form.text_return}" onClick="javascript:OpenLink('{form.return}');"></td>
			<td width="99%">{form.imagelink}</td>
			<td nowrap><input class="button" type="reset" value="{form.text_reset}"></td>
			<td nowrap><input class="submit" type="submit" value="{form.text_submit}"></td>
		</tr>
		</table>
		<table class="tborder" width="100%" border="0" cellspacing="1" cellpadding="2">
		<tr>
			<td nowrap class="tfirst"><b>{form.text_name}</b></td>
			<td nowrap class="tfirst"><b>{form.text_order}</b></td>
			<td nowrap class="tfirst" width="99%"><b>{form.text_photo}</b></td>
		</tr>
		<tr>
			<td nowrap class="trow"><input class="textbox" type="text" name="title" value="{form.name}" style="width:250px" maxlength="128"></td>
			<td nowrap class="trow"><input class="textbox" type="text" name="orders" value="{form.orders}" style="width:50px" maxlength="4"></td>
			<td nowrap class="trow"><input class="textbox" type="file" name="image" style="width:220px"></td>
		</tr>
		</table>
		<table class="tborder" width="100%" border="0" cellspacing="1" cellpadding="2">
		<tr>
			<td nowrap class="tfirst"><b>{form.text_intro}</b></td>
		</tr>
		<tr>
			<td nowrap class="trow"><input class="textbox" type="text" name="intro" value="{form.intro}" style="width:530px" maxlength="255"></td>
		</tr>
		<tr>
			<td nowrap class="tfirst"><b>{form.text_tag}</b></td>
		</tr>
		<tr>
			<td nowrap class="trow"><input class="textbox" type="text" name="tag" value="{form.tag}" style="width:530px" maxlength="255"></td>
		</tr>
		<tr>
			<td nowrap class="tfirst"><b>{form.text_link}</b></td>
		</tr>
		<tr>
			<td nowrap class="trow"><input class="textbox" type="text" name="link" value="{form.link}" style="width:530px" maxlength="255"></td>
		</tr>
		</table>
		</form>
		<!-- END form -->

		<!-- BEGIN navigation -->
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr><td>{navigation.trace}</td></tr>
        </table>
        
		<table class="thead" width="100%" border="0" cellspacing="0" cellpadding="2">
		<form name="frmNav" action="{navigation.action}" method="get">
		<input type="hidden" name="m" value="{navigation.module}">
		<input type="hidden" name="f" value="{navigation.file}">
		<input type="hidden" name="t" value="{navigation.type}">
		<input type="hidden" name="p" value="{navigation.page}">
		<tr>
			<td nowrap><input class="textbox" type="text" name="k" value="{navigation.keyword}"></td>
			<td nowrap>{navigation.text_status}:</td>
			<td nowrap><select class="textbox" name="st" size=1 style="width:100px" onChange="javascript:submit(frmNav);">
			<!-- BEGIN optionstatus -->
				<option value="{navigation.optionstatus.value}"{navigation.optionstatus.selected}>{navigation.optionstatus.text}</option>
			<!-- END optionstatus -->
			</select></td>
			<td nowrap><input class="button" type="button" value="{navigation.text_refresh}" onClick="javascript:frmNav.submit()"></td>
			<td nowrap align="right" width="99%">
			<!-- BEGIN button -->
			<input class="submit" type="button" value="{navigation.button.text}" onClick="javascript:OpenLink('{navigation.button.link}');">
			<!-- END button -->
			</td>
		</tr>
		</form>
		</table>
		<!-- END navigation -->
		<!-- BEGIN photolist -->
		<form name="frmSlc" action="{photolist.action}" method="get">
		<input type="hidden" name="m" value="{photolist.module}">
		<input type="hidden" name="f" value="{photolist.file}">
		<input type="hidden" name="t" value="{photolist.type}">
		<input type="hidden" name="st" value="{photolist.status}">
		<input type="hidden" name="p" value="{photolist.page}">
		<table width="100%" class="tborder" border="0" cellspacing="1" cellpadding="2">
		<tr>
			<td nowrap width="30" class="tfirst"><b>{photolist.text_stt}</b></td>
			<td nowrap width="15" class="tfirst" align="center">&nbsp;</td>
			<td nowrap class="tfirst"><b>{photolist.text_photo}</b></td>
			<td nowrap width="250" class="tfirst"><b>{photolist.text_name}</b></td>
			<td nowrap width="50" class="tfirst" align="center"><b>{photolist.text_order}</b></td>
			<td nowrap class="tfirst" width="99%">&nbsp;</td>
		</tr>
		<!-- BEGIN photo -->
		<tr valign="top">
			<td nowrap class="trow{photolist.photo.class}">{photolist.photo.stt}</td>
			<td nowrap class="trow{photolist.photo.class}"><img src="images/stat_{photolist.photo.status}.gif" border="0" width="11" height="11"></td>
			<td nowrap class="trow{photolist.photo.class}"><img class="thumb" src="{photolist.photo.image}" border="0" width="{photolist.photo.width}" height="{photolist.photo.height}"></td>
			<td class="trow{photolist.photo.class}"><b>{photolist.photo.name}</b><br>{photolist.photo.intro}<br><span class="grey">{photolist.photo.link}</span><br><span class="grey">{photolist.photo.text_tag}:{photolist.photo.tag}</span></td>
			<td nowrap class="trow{photolist.photo.class}" align="center">{photolist.photo.order}</td>
			<td nowrap class="trow{photolist.photo.class}">
			<!-- BEGIN control -->
			<img class="pointer" src="images/{photolist.photo.control.icon}.gif" border="0" width="16" height="16" onClick="javascript:{photolist.photo.control.function}" title="{photolist.photo.control.text_title}">
			<!-- END control -->
			</td>
		</tr>
		<!-- END photo -->
		<!-- BEGIN total -->
		<tr>
			<td nowrap class="ttotal">&nbsp;</td>
			<td nowrap class="ttotal">&nbsp;</td>
			<td nowrap class="ttotal">&nbsp;</td>
			<td nowrap class="ttotal">{photolist.total.text_total}: <b>{photolist.total.total}</b></td>
			<td nowrap class="ttotal">&nbsp;</td>
			<td nowrap class="ttotal">&nbsp;</td>
		</tr>
		<!-- END total -->
		</table>
		</form>
		<!-- END photolist -->

		<!-- BEGIN message -->
		<p align="left" style="margin:20px 0px">{message.text}
		<!-- END message -->

		<!-- BEGIN pagenav -->
		<table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin: 0 -2">
			<tr>
				<form action="{pagenav.action}" method="get">
				<td width="99%" nowrap>
				<!-- BEGIN page -->
				<a class="page" href="{pagenav.page.link}">{pagenav.page.text}</a>
				<!-- END page -->
				</td>
				<td nowrap><span class="page">{pagenav.text_gopage}:</span></td>
				<td><select class="page" name="p" size="1" onChange="javascript:window.location.href=this.options[this.selectedIndex].value">
				<!-- BEGIN optionpage -->
					<option value="{pagenav.optionpage.value}"{pagenav.optionpage.selected}>{pagenav.optionpage.text}</option>
				<!-- END optionpage -->
				</select></td>
				</form>
			</tr>
		</table>
		<!-- END pagenav -->
