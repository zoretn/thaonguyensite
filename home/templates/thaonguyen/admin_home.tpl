			<!-- BEGIN stat -->
			<div class="title">{stat.title}</div>

			<p style="margin-top:6px"><table width="100%" class="tborder" border="0" cellspacing="1" cellpadding="2">
			<tr>
				<td nowrap width="40" class="tfirst"><b>{stat.text_stt}</b></td>
				<td nowrap width="15" class="tfirst" align="center">&nbsp;</td>
				<td nowrap width="99%" class="tfirst"><b>{stat.text_ip}</b></td>
				<td nowrap class="tfirst"><b>{stat.text_username}</b></td>
				<td nowrap class="tfirst"><b>{stat.text_datepost}</b></td>
				<td nowrap class="tfirst"><b>{stat.text_country}</b></td>
				<td nowrap class="tfirst">&nbsp;</td>
			</tr>
			<!-- BEGIN session -->
			<tr>
				<td nowrap class="trow{stat.session.class}">{stat.session.stt}</td>
				<td nowrap class="trow{stat.session.class}"><img src="images/stat_{stat.session.status}.gif" border="0" width="11" height="11"></td>
				<td nowrap class="trow{stat.session.class}"><b class="link" title="{stat.session.hostname}">{stat.session.ip}</b></td>
				<td class="trow{stat.session.class}">{stat.session.username}</td>
				<td nowrap class="trow{stat.session.class}">{stat.session.datepost}</td>
				<td class="trow{stat.session.class}">{stat.session.country}</td>
				<td nowrap class="trow{stat.session.class}">
				<!-- BEGIN control -->
				<img class="pointer" src="images/{stat.session.control.icon}.gif" border="0" width="16" height="16" onClick="javascript:{stat.session.control.function}" title="{stat.session.control.text_title}">
				<!-- END control -->
				</td>
			</tr>
			<!-- END session -->
			<!-- BEGIN total -->
			<tr>
				<td nowrap class="ttotal">&nbsp;</td>
				<td nowrap class="ttotal">&nbsp;</td>
				<td nowrap class="ttotal">{stat.total.text_total}: <b>{stat.total.total}</b></td>
				<td nowrap class="ttotal">&nbsp;</td>
				<td nowrap class="ttotal">&nbsp;</td>
				<td nowrap class="ttotal">&nbsp;</td>
				<td nowrap class="ttotal">&nbsp;</td>
			</tr>
			<!-- END total -->
			</table>
			<!-- END stat -->

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

			<!-- BEGIN post -->
			<div class="title">{post.title}</div>

			<p style="margin-top:6px"><table width="100%" class="tborder" border="0" cellspacing="1" cellpadding="2">
			<tr>
				<td nowrap width="40" class="tfirst"><b>{post.text_stt}</b></td>
				<td nowrap width="15" class="tfirst" align="center">&nbsp;</td>
				<td nowrap width="99%" class="tfirst"><b>{post.text_post}</b></td>
				<td nowrap class="tfirst"><b>{post.text_hit}</b></td>
				<td nowrap class="tfirst">&nbsp;</td>
			</tr>
			<!-- BEGIN row -->
			<tr>
				<td nowrap class="trow{post.row.class}">{post.row.stt}</td>
				<td nowrap class="trow{post.row.class}"><img src="images/stat_{post.row.status}.gif" border="0" width="11" height="11"></td>
				<td class="trow{post.row.class}">{post.row.title}</td>
				<td nowrap class="trow{post.row.class}">{post.row.hit}</td>
				<td nowrap class="trow{stat.session.class}">
				<!-- BEGIN control -->
				<img class="pointer" src="images/{post.row.control.icon}.gif" border="0" width="16" height="16" onClick="javascript:{post.row.control.function}" title="{post.row.control.text_title}">
				<!-- END control -->
				</td>
			</tr>
			<!-- END row -->
			</table>
			<!-- END post -->
