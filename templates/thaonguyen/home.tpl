	<table width="100%" height="450" border="0" cellpadding="0" cellspacing="0">
    <tr valign="top">
    	<td align="right"><div id="divHome"></div></td>
    </tr>
    </table>
	<script language="javascript">
        var so = new SWFObject("{theme}home.swf", "Home", "770", "450", "9", "");
        so.addParam("quality", "hight");
        so.addParam("wmode", "transparent");
        so.addParam("menu", "false");
        so.addParam("allowScriptAccess", "always");
        so.addParam("allowFullscreen", "true");
        so.addVariable("datafile", escape("index.php?m=flash&f=home&lang={lang}"));
        so.write("divHome");
    </script>
