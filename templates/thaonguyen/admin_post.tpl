			<div class="title">{title}</div>

			<!-- BEGIN form -->
			<form name="frmNav" action="{form.action}" method="post" enctype="multipart/form-data" onSubmit="CheckPost(frmNav,'{form.text_save}'); return false">
			<input type="hidden" name="m" value="{form.module}">
			<input type="hidden" name="f" value="{form.file}">
			<input type="hidden" name="act" value="send">
			<input type="hidden" name="id" value="{form.idpost}">
			<input type="hidden" name="t" value="{form.type}">
			<input type="hidden" name="p" value="{form.page}">
			<table class="thead" width="100%" border="0" cellspacing="0" cellpadding="2">
			<tr>
				<td nowrap><input class="button" type="button" value="{form.text_return}" onClick="javascript:OpenLink('{form.return}');"></td>
				<td width="99%">{form.trace}</td>
				<td nowrap><input class="button" type="reset" value="{form.text_reset}"></td>
				<td nowrap><input class="submit" type="submit" value="{form.text_submit}"></td>
			</tr>
			</table>

			<table class="tborder" width="100%" border="0" cellspacing="1" cellpadding="2">
			<tr>
				<td nowrap width="300" class="tfirst"><b>{form.text_title}</b></td>
			</tr>
			<tr>
				<td nowrap class="trow"><input class="textbox" type="text" name="title" value="{form.title}" style="width:500px"></td>
			</tr>
			</table>

			<!-- BEGIN post -->
			<table class="tborder" width="100%" border="0" cellspacing="1" cellpadding="2">
			<tr>
				<td nowrap class="tfirst"><b>{form.post.text_intro}</b></td>
            </tr>
            <tr>
				<td class="trow">{form.post.intro}</td>
            </tr>
            <tr>
				<td nowrap class="tfirst"><b>{form.post.text_content}</b></td>
			</tr>
			<tr>
				<td class="trow">{form.post.content}</td>
			</tr>
            </table>
			<!-- END post -->

			<table class="tborder" width="100%" border="0" cellspacing="1" cellpadding="2">
			<tr>
				<td nowrap class="tfirst"><b>{form.text_image}</b></td>
				<td nowrap class="tfirst"><b></b></td>
			</tr>
			<tr>
				<td class="trow"><input class="textbox" type="file" name="image" style="width:500px"></td>
				<td class="trow">
				<!-- BEGIN image -->
				<input type="checkbox" name="chkimage" value="1"> {form.image.text} <a href="{form.image.link}">{form.image.filename}</a>
				<!-- END image -->
				</td>
			</tr>
			</table>

			<table class="tborder" width="100%" border="0" cellspacing="1" cellpadding="2">
			<tr>
				<td nowrap class="tfirst"><b>{form.text_link}</b></td>
			</tr>
			<tr>
				<td nowrap class="trow"><input class="textbox" type="text" name="link" value="{form.link}" style="width:500px"></td>
			</tr>
			</table>

			<table class="tborder" width="100%" border="0" cellspacing="1" cellpadding="2">
			<tr>
				<td nowrap width="100" class="tfirst"><b>{form.text_module}</b></td>
				<td nowrap width="150" class="tfirst"><b>{form.text_date}</b></td>
				<td nowrap width="50" class="tfirst"><b>{form.text_order}</b></td>
				<td nowrap width="99%" class="tfirst"><b></b></td>
			</tr>
			<tr>
				<td nowrap class="trow"><select class="textbox" name="tag" style="width:90px">
	                <!-- BEGIN optionmodule -->
                	<option value="{form.optionmodule.value}"{form.optionmodule.selected}>{form.optionmodule.text}</option>
    	            <!-- END optionmodule -->
                </select></td>
				<td nowrap class="trow">
					<select class="textbox" size="1" name="day">
					<!-- BEGIN dayoption -->
						<option value="{form.dayoption.value}"{form.dayoption.selected}>{form.dayoption.text}</option>
					<!-- END dayoption -->
					</select>
					<select class="textbox" size="1" name="month">
					<!-- BEGIN monthoption -->
						<option value="{form.monthoption.value}"{form.monthoption.selected}>{form.monthoption.text}</option>
					<!-- END monthoption -->
					</select>
					<select class="textbox" size="1" name="year">
					<!-- BEGIN yearoption -->
						<option value="{form.yearoption.value}"{form.yearoption.selected}>{form.yearoption.text}</option>
					<!-- END yearoption -->
					</select>
					<select class="textbox" size="1" name="hour">
					<!-- BEGIN houroption -->
						<option value="{form.houroption.value}"{form.houroption.selected}>{form.houroption.text}</option>
					<!-- END houroption -->
					</select>
					<select class="textbox" size="1" name="minute">
					<!-- BEGIN minuteoption -->
						<option value="{form.minuteoption.value}"{form.minuteoption.selected}>{form.minuteoption.text}</option>
					<!-- END minuteoption -->
					</select>
					<select class="textbox" size="1" name="second">
					<!-- BEGIN secondoption -->
						<option value="{form.secondoption.value}"{form.secondoption.selected}>{form.secondoption.text}</option>
					<!-- END secondoption -->
					</select>
				</td>
				<td nowrap class="trow"><input class="textbox" type="text" name="orders" value="{form.orders}" style="width:50px"></td>
				<td nowrap class="trow"></td>
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
				<td nowrap><input class="button" type="button" value="{navigation.text_return}" onClick="javascript:OpenLink('{navigation.return}');"></td>
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

			<!-- BEGIN postlist -->
			<table width="100%" class="tborder" border="0" cellspacing="1" cellpadding="2">
			<tr>
				<td nowrap width="40" class="tfirst"><b>{postlist.text_stt}</b></td>
				<td nowrap width="15" class="tfirst">&nbsp;</td>
				<td nowrap width="20" class="tfirst">&nbsp;</td>
				<td nowrap width="99%" class="tfirst"><b>{postlist.text_post}</b></td>
				<td nowrap width="50" class="tfirst" align="center"><b>{postlist.text_hit}</b></td>
				<td nowrap width="75" class="tfirst" align="center"><b>{postlist.text_numpost}</b></td>
				<td nowrap width="75" class="tfirst" align="center"><b>{postlist.text_numimage}</b></td>
				<td nowrap width="50" class="tfirst" align="center"><b>{postlist.text_order}</b></td>
				<td nowrap class="tfirst">&nbsp;</td>
			</tr>
			<!-- BEGIN post -->
			<tr>
				<td nowrap class="trow{postlist.post.class}">{postlist.post.stt}</td>
				<td nowrap class="trow{postlist.post.class}"><img src="images/stat_{postlist.post.status}.gif" border="0" width="11" height="11"></td>
				<td nowrap class="trow{postlist.post.class}">
				<!-- BEGIN folder -->
				<img class="pointer" src="images/{postlist.post.folder.icon}.gif" border="0" width="16" height="16" onClick="javascript:{postlist.post.folder.function}" title="{postlist.post.folder.text_title}">
				<!-- END folder -->
				</td>
				<td class="trow{postlist.post.class}"><b class="link">{postlist.post.title}</b><br><span class="date">{postlist.post.datepost}</span><br>{postlist.post.intro}</td>
				<td nowrap class="trow{postlist.post.class}" align="center">{postlist.post.hit}</td>
				<td nowrap class="trow{postlist.post.class}" align="center">{postlist.post.numpost}</td>
				<td nowrap class="trow{postlist.post.class}" align="center">{postlist.post.numimage}</td>
				<td nowrap class="trow{postlist.post.class}" align="center">{postlist.post.orders}</td>
				<td class="trow{postlist.post.class}">
				<!-- BEGIN control -->
				<img class="pointer" src="images/{postlist.post.control.icon}.gif" border="0" width="16" height="16" onClick="javascript:{postlist.post.control.function}" title="{postlist.post.control.text_title}">
				<!-- END control -->
				</td>
			</tr>
			<!-- END post -->
			<!-- BEGIN total -->
			<tr>
				<td nowrap class="ttotal">&nbsp;</td>
				<td nowrap class="ttotal">&nbsp;</td>
				<td nowrap class="ttotal">&nbsp;</td>
				<td nowrap class="ttotal">{postlist.total.text_total}: <b>{postlist.total.total}</b></td>
				<td nowrap class="ttotal">&nbsp;</td>
				<td nowrap class="ttotal">&nbsp;</td>
				<td nowrap class="ttotal">&nbsp;</td>
				<td nowrap class="ttotal">&nbsp;</td>
				<td nowrap class="ttotal">&nbsp;</td>
			</tr>
			<!-- END total -->
			</table>
			<!-- END postlist -->

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
