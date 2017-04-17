<?php
	defined("_ALLOW") or die ("Access denied");
	if (checkadmin()) {
		mosRedirect("index.php");
	}
?>
<?php
	if (isset($_REQUEST['Submit'])) {
		include_once("../class/dbconnect.php");
		include("components/com_login/checkpass.php");
		$username = $_REQUEST['txtusername'];
		$password = $_REQUEST['txtpassword'];
		$resultcheck = kiemtra($username, $password);
		if ($resultcheck==0) {
			?>
			<script language="javascript">
				window.alert("Incorrect Username, Password. Please try again.");
			</script>
			<?php
		}
		else {
			mosRedirect("index.php");
		}
	}
?>
<br />
<br />
<br />
<script language="javascript" type="text/javascript">
	function setFocus() {
		document.ftmlogin.txtusername.select();
		document.ftmlogin.txtusername.focus();
	}
</script>
<body onLoad="setFocus()">
<table width="420" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="189" rowspan="3" valign="top" bgcolor="#F1F3F5" style="font-family:Tahoma; font-size:16px; color:#CC3300; font-weight:bold; padding-bottom:10px; padding-top:15px; padding-left:10px; border-top:1px solid #333333; border-bottom:1px solid #333333; border-left:1px solid #333333;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center"><img src="images/security.png" width="64" height="64" /></td>
      </tr>
      <tr>
        <td style="font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#000000; font-weight:normal; padding-left:5px; padding-right:5px;"><p>Welcome to phannguyen!</p>
          <p>Use a valid username and password to gain access to the administration console. </p></td>
      </tr>
    </table></td>
    <td colspan="2" bgcolor="#F1F3F5" style="font-family:Arial; font-size:24px; color:#CC3300; font-weight:bold; padding-bottom:5px; padding-top:10px; padding-left:10px; border-top:1px solid #333333; border-right:1px solid #333333;">Login</td>
  </tr>
  <tr>
    <td width="204" bgcolor="#F1F3F5" style="padding-bottom:0px; padding-top:10px; border:1px solid #999999;">
      <table width="100%" border="0" cellspacing="0" cellpadding="0"><form action="index.php?module=com_login" method="post" name="ftmlogin" id="ftmlogin">
        <tr>
          <td style="font-weight:bold; font-size:12px; color:#666666; font-family:Arial, Helvetica, sans-serif; padding-left:10px;">Username</td>
        </tr>
        <tr>
          <td style=" padding-left:10px;"><input name="txtusername" type="text" id="txtusername" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; border:1px solid #CCCCCC; width:150px;"></td>
        </tr>
        <tr>
          <td style="font-weight:bold; font-size:12px; color:#666666; font-family:Arial, Helvetica, sans-serif; padding-top:10px; padding-left:10px;">Password</td>
        </tr>
        <tr>
          <td style=" padding-left:10px;"><input name="txtpassword" type="password" id="txtpassword" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; border:1px solid #CCCCCC; width:150px;"></td>
        </tr>
        <tr>
          <td height="38" style="padding-top:5px; padding-left:10px;"><input type="submit" name="Submit" value="Login" style="border:1px solid #999999; background-color:#F5F5F5; font-family:Tahoma; font-weight:bold; font-size:11px; color:#666666; padding-left:5px; padding-right:5px; padding-top:3px; padding-bottom:3px;"></td>
        </tr>
                </form>
      </table>    </td>
    <td width="27" bgcolor="#F1F3F5" style="border-right:1px solid #333333;">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#F1F3F5" style="border-right:1px solid #333333; border-bottom:1px solid #333333;">&nbsp;</td>
  </tr>
</table>
</body>