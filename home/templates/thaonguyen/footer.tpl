		</td>
    </tr>
    </table>
</td>
</tr>
</table>
<table width="{maxwidth}" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td align="center"><img src="{theme}images/shadow.png" border="0" width="980" height="10" /></td>
</tr>
</table>
<table width="{maxwidth}" border="0" cellpadding="0" cellspacing="0">
<tr valign="top">
	<td class="address" style="padding-top:10px">
		<b>{copyright}</b>
		<!-- BEGIN address -->
        <!-- <br>{address.company_name}</b> -->
        <br>{address.text_address}: {address.company_address}
		<br>{address.text_telephone}: {address.company_telephone}
        - {address.text_fax}: {address.company_fax}
        <br>{address.text_email}: <a href="mailto:{address.company_email}">{address.company_email}</a>
        - <a href="mailto:{address.company_officemail}">{address.company_officemail}</a>
		<br>{address.text_factory}: {address.company_factoryaddr}
		<br>{address.text_telephone}: {address.company_factorytel}
        - {address.text_fax}: {address.company_factoryfax}
        <!-- - {address.text_website}: <a href="http://{address.company_website}">{address.company_website}</a> -->
        <!-- END address -->
    </td>
	<!-- BEGIN award -->
	<td width="500" align="right"><div id="divAward"></div></td>
	<script language="javascript">
        var so = new SWFObject("{award.theme}award.swf", "Award", "600", "90", "9", "");
        so.addParam("quality", "hight");
        so.addParam("wmode", "transparent");
        so.addParam("menu", "false");
        so.addParam("allowScriptAccess", "always");
        so.addParam("allowFullscreen", "true");
        so.addVariable("datafile", escape("index.php?m=flash&f=award&id={award.idpost}&t={award.random}"));
        so.write("divAward");
    </script>
    <!-- END award -->
</tr>
</table>
<!-- BEGIN analytics -->
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
	document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
	try {
		var pageTracker = _gat._getTracker("{analytics.analytics_code}");
		pageTracker._trackPageview();
	} catch(err) {
	};
</script>
<!-- END analytics -->
</center>
</body>
</html>