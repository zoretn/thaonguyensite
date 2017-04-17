<?php
defined("_ALLOW") or die ("Access denied");
$task = "";
if (isset($_REQUEST['task'])) $task = $_REQUEST['task'];
switch ($task) {
	case "sendcontact":
		$lstten = $_REQUEST['lstten'];
		$hoten = $_REQUEST['txthoten'];
		$chucdanh = $_REQUEST['txtchucdanh'];
		$congty = $_REQUEST['txtcongty'];
		$diachi = $_REQUEST['txtdiachi'];
		$quocgia = $_REQUEST['lstquocgia'];
		$dienthoai = $_REQUEST['txtdienthoai'];
		$fax = $_REQUEST['txtfax'];
		$email = $_REQUEST['txtemail'];
		$website = $_REQUEST['txtwebsite'];
		$chude = $_REQUEST['txtchude'];
		$noidung = $_REQUEST['txtnoidung'];
		$message = "Có một khách liên hệ với bạn qua website. Sau đây là thông tin mà khách đã cung cấp:<br>";
		$message .= "Tên: " . $lstten . " " . $hoten . "<br>";
		$message .= "Chức danh: " . $chucdanh . "<br>";
		$message .= "Công ty: " . $congty . "<br>";
		$message .= "Địa chỉ: " . $diachi . "<br>";
		$message .= "Quốc gia: " . $quocgia . "<br>";
		$message .= "Điện thoại: " . $dienthoai . "<br>";
		$message .= "Fax: " . $fax . "<br>";
		$message .= "Email: " . $email . "<br>";
		$message .= "Website: " . $website . "<br>";
		$message .= "Chủ đề: " . $chude . "<br>";
		$message .= "Nội dung: " . "<p>";
		$message .= $noidung . "</p>";
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n";
		$headers .= "From: " . $lstten . " " . $hoten . "<" . $email . ">\r\n";
		if ($lang=="vn")
		echo "Nội dung góp ý (yêu cầu) của quý khách đang được gửi đến chúng tôi, vui lòng chờ trong giây lát...";
		else
		echo "Your message is sending to us, please wait some seconds...";
		global $cfg_mail;
		mail($cfg_mail,"Contact Email",$message,$headers);
		global $cfg_autoresponse;
		if ($cfg_autoresponse == 1) {
			global $cfg_textresponse;
			global $cfg_textresponse_en;
			global $cfg_mailname;
			$textresponse = $cfg_textresponse;
			if ($lang=="en") $textresponse = $cfg_textresponse_en;
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=utf-8\r\n";
			$headers .= "From: $cfg_mailname <" . $cfg_mail . ">" . "\r\n";
			mail ($email, "Auto Response Mail - $cfg_title_site", $textresponse, $headers);
		}
		mosRedirect("index.php");
		break;
?>
<?php
	default:
		global $cfg_introcontact;
		global $cfg_introcontact_en;
		global $cfg_introcontact_cn;
		global $lang;
		$loichao = $cfg_introcontact;
		$require = "<span style='color:#FF0000;'>*</span>";
		$submit = "Gửi";
		$hoten = "Tên:";
		$chucdanh = "Chức danh:";
		$congty = "Công ty:";
		$diachi = "Địa chỉ:";
		$quocgia = "Quốc gia:";
		$dienthoai = "Điện thoại:";
		$fax = "Fax:";
		$email = "E-mail: ";
		$website = "Website:";
		$chude = "Chủ đề:";
		$noidung = "Nội dung: ";
		if ($lang=="en") {
			$loichao = $cfg_introcontact_en;
			$hoten = "Name:";
			$chucdanh = "Job status:";
			$congty = "Company:";
			$diachi = "Address:";
			$quocgia = "Nation:";
			$dienthoai = "Phone:";
			$chude = "Subject:";
			$noidung = "Content:";
			$submit = "Send";
		}
		if ($lang=="cn") {
			$loichao = $cfg_introcontact_cn;
			$hoten = "姓名:";
			$chucdanh = "職務:";
			$congty = "公司:";
			$diachi = "地址:";
			$quocgia = "國家:";
			$dienthoai = "電話:";
			$fax = "傳真:";
			$email = "電郵:";
			$website = "網址:";
			$chude = "主題:";
			$noidung = "內容:";
			$submit = "发送";
		}
?>
<script language="javascript" src="common/js/checkcontact.js"></script>
<script language="javascript">
function SubmitContact (pressbutton) {
	var form = document.frmcontact;
	if (CheckContact(form)) {
		form.task.value = pressbutton;
//		form.submit();
	}
}
</script>
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-image:url(images/banggt_07.jpg); background-repeat:repeat-y;">
	<tr>
		<td>
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td style="background-image:url(images/banggt_03.jpg); background-repeat:no-repeat; font-family:tahoma; font-size:12px; font-weight:bold; color:#FF0000; text-align:center;  padding-top:10px;">
						<div style="padding-right:190px;">
							<?php if ($lang=="vn") echo "Liên hệ"; else if($lang=="en") echo "Contact us"; else echo "接洽"; ?>
						</div>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
		<td style="padding-top:40px;">
			<div class="td_bodycontent">
<div class="<?php echo ($lang=='cn')?"content_view_contact":"content_view"; ?>" ><?php echo str_replace("\\\"","\"",$loichao); ?></div>
<table width="314" align="center" cellpadding="0" cellspacing="1" class="table_contact">
<form action="index.php?module=com_contact" method="post" name="frmcontact" id="frmcontact" onsubmit="return CheckContact(this);">
<tr>
  <td width="78" class="<?php echo ($lang=='cn')?"lable_contact":"lable";?>"><?php echo $hoten; echo $require; ?></td>
  <td width="231"><select name="lstten" id="lstten" class="list_area">
    <option value="Mr." selected="selected">Mr.</option>
    <option value="Ms.">Ms.</option>
    <option value="Mrs.">Mrs.</option>
    </select>
    <input name="txthoten" type="text" id="txthoten" size="19" class="text_area" /></td>
</tr>
<tr>
  <td class="<?php echo ($lang=='cn')?"lable_contact":"lable";?>"><?php echo $chucdanh; ?></td>
  <td><input name="txtchucdanh" type="text" id="txtchucdanh" size="30" class="text_area" /></td>
</tr>
<tr>
  <td class="<?php echo ($lang=='cn')?"lable_contact":"lable";?>"><?php echo $congty; ?></td>
  <td><input name="txtcongty" type="text" id="txtcongty" size="30" class="text_area" /></td>
</tr>
<tr>
  <td class="<?php echo ($lang=='cn')?"lable_contact":"lable";?>"><?php echo $diachi; ?></td>
  <td><input name="txtdiachi" type="text" id="txtdiachi" size="30" class="text_area" /></td>
</tr>
<tr>
  <td class="<?php echo ($lang=='cn')?"lable_contact":"lable";?>"><?php echo $quocgia; echo $require; ?></td>
  <td><select name="lstquocgia" id="lstquocgia" class="list_area">
    <OPTION value="<?php echo ($lang=="cn")?"阿富汗":"Afghanistan";?>"><?php echo ($lang=="cn")?"阿富汗":"Afghanistan";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"阿爾巴尼亞":"Albania";?>"><?php echo ($lang=="cn")?"阿爾巴尼亞":"Albania";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"阿爾及利亞 ":"Algeria";?>"><?php echo ($lang=="cn")?"阿爾及利亞 ":"Algeria";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"安道爾共和國":"Andorra";?>"><?php echo ($lang=="cn")?"安道爾共和國":"Andorra";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"安哥拉":"Angola";?>"><?php echo ($lang=="cn")?"安哥拉":"Angola";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"阿根廷":"Argentina";?>"><?php echo ($lang=="cn")?"阿根廷":"Argentina";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"亞美尼亞 ":"Armenia";?>"><?php echo ($lang=="cn")?"亞美尼亞 ":"Armenia";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"澳大利亞 ":"Australia";?>"><?php echo ($lang=="cn")?"澳大利亞 ":"Australia";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"澳大利亞 ":"Australia";?>"><?php echo ($lang=="cn")?"澳大利亞 ":"Australia";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"阿塞拜疆 ":"Azerbaijan";?>"><?php echo ($lang=="cn")?"阿塞拜疆 ":"Azerbaijan";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"巴哈馬 ":"Bahamas";?>"><?php echo ($lang=="cn")?"巴哈馬 ":"Bahamas";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"巴林 ":"Bahrain";?>"><?php echo ($lang=="cn")?"巴林 ":"Bahrain";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"孟加拉共和國 ":"Bangladesh";?>"><?php echo ($lang=="cn")?"孟加拉共和國 ":"Bangladesh";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"比利時 ":"Belgium";?>"><?php echo ($lang=="cn")?"比利時 ":"Belgium";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"伯利兹 ":"Belize";?>"><?php echo ($lang=="cn")?"伯利兹 ":"Belize";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"白俄羅斯  ":"Belorussia";?>"><?php echo ($lang=="cn")?"白俄羅斯  ":"Belorussia";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"貝寧   ":"Benin";?>"><?php echo ($lang=="cn")?"貝寧   ":"Benin";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"百慕大群島    ":"Bermudas";?>"><?php echo ($lang=="cn")?"百慕大群島    ":"Bermudas";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"不丹    ":"Bhutan";?>"><?php echo ($lang=="cn")?"不丹    ":"Bhutan";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"玻利維亞    ":"Bolivia";?>"><?php echo ($lang=="cn")?"玻利維亞    ":"Bolivia";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"博茨瓦那      ":"Botswana";?>"><?php echo ($lang=="cn")?"博茨瓦那      ":"Botswana";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"巴西     ":"Brazil";?>"><?php echo ($lang=="cn")?"巴西     ":"Brazil";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"文萊      ":"Brunei";?>"><?php echo ($lang=="cn")?"文萊      ":"Brunei";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"保加利亞      ":"Bulgary";?>"><?php echo ($lang=="cn")?"保加利亞      ":"Bulgary";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"布基納法索國      ":"Burkina Faso";?>"><?php echo ($lang=="cn")?"布基納法索國      ":"Burkina Faso";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"蒲隆地      ":"Burundi";?>"><?php echo ($lang=="cn")?"蒲隆地      ":"Burundi";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"柬埔寨      ":"Cambodia";?>"><?php echo ($lang=="cn")?"柬埔寨      ":"Cambodia";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"卡梅倫      ":"Camerun";?>"><?php echo ($lang=="cn")?"卡梅倫      ":"Camerun";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"加拿大      ":"Canada";?>"><?php echo ($lang=="cn")?"加拿大      ":"Canada";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"佛得角      ":"Cape Verde";?>"><?php echo ($lang=="cn")?"佛得角      ":"Cape Verde";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"哥倫比亞      ":"Colombia";?>"><?php echo ($lang=="cn")?"哥倫比亞      ":"Colombia";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"剛果      ":"Congo(Brazzaville)";?>"><?php echo ($lang=="cn")?"剛果      ":"Congo(Brazzaville)";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"哥斯達黎加      ":"Costa Rica";?>"><?php echo ($lang=="cn")?"哥斯達黎加      ":"Costa Rica";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"象牙海岸      ":"Côte   d’Ivoire";?>"><?php echo ($lang=="cn")?"象牙海岸      ":"Côte   d’Ivoire";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"克羅地亞      ":"Croatia";?>"><?php echo ($lang=="cn")?"克羅地亞      ":"Croatia";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"古巴      ":"Cuba";?>"><?php echo ($lang=="cn")?"古巴      ":"Cuba";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"塞浦路斯      ":"Cyprus";?>"><?php echo ($lang=="cn")?"塞浦路斯      ":"Cyprus";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"捷克共和國      ":"Czech Republic";?>"><?php echo ($lang=="cn")?"捷克共和國      ":"Czech Republic";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"乍得      ":"Chad";?>"><?php echo ($lang=="cn")?"乍得      ":"Chad";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"乍得      ":"Chile";?>"><?php echo ($lang=="cn")?"乍得      ":"Chile";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"中國      ":"China";?>"><?php echo ($lang=="cn")?"中國      ":"China";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"丹麥      ":"Denmark";?>"><?php echo ($lang=="cn")?"丹麥      ":"Denmark";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"吉布提      ":"Djibouti";?>"><?php echo ($lang=="cn")?"吉布提      ":"Djibouti";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"多米尼加共和國      ":"Dominican Republic";?>"><?php echo ($lang=="cn")?"多米尼加共和國      ":"Dominican Republic";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"杜拜      ":"Dubai";?>"><?php echo ($lang=="cn")?"杜拜      ":"Dubai";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"厄瓜多爾      ":"Ecuador";?>"><?php echo ($lang=="cn")?"厄瓜多爾      ":"Ecuador";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"埃及      ":"Egypt";?>"><?php echo ($lang=="cn")?"埃及      ":"Egypt";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"薩爾瓦多      ":"El Salvador";?>"><?php echo ($lang=="cn")?"薩爾瓦多      ":"El Salvador";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"赤道幾內亞      ":"Equatorial Guinea";?>"><?php echo ($lang=="cn")?"赤道幾內亞      ":"Equatorial Guinea";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"厄立特里亞      ":"Eritrea";?>"><?php echo ($lang=="cn")?"厄立特里亞      ":"Eritrea";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"愛沙尼亞      ":"Estonia";?>"><?php echo ($lang=="cn")?"愛沙尼亞      ":"Estonia";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"埃塞俄比亞      ":"Ethiopia";?>"><?php echo ($lang=="cn")?"埃塞俄比亞      ":"Ethiopia";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"Fidji群島      ":"Fidji   Islands";?>"><?php echo ($lang=="cn")?"Fidji群島      ":"Fidji   Islands";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"Fidji群島      ":"Fidji   Islands";?>"><?php echo ($lang=="cn")?"Fidji群島      ":"Fidji   Islands";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"法國      ":"France";?>"><?php echo ($lang=="cn")?"法國      ":"France";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"加蓬      ":"Gabon";?>"><?php echo ($lang=="cn")?"加蓬      ":"Gabon";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"岡比亞      ":"Gambia";?>"><?php echo ($lang=="cn")?"岡比亞      ":"Gambia";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"格魯吉亞      ":"Georgia";?>"><?php echo ($lang=="cn")?"格魯吉亞      ":"Georgia";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"德國      ":"Germany";?>"><?php echo ($lang=="cn")?"德國      ":"Germany";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"加納      ":"Ghana";?>"><?php echo ($lang=="cn")?"加納      ":"Ghana";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"希臘      ":"Greece";?>"><?php echo ($lang=="cn")?"希臘      ":"Greece";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"危地馬拉      ":"Guatemala";?>"><?php echo ($lang=="cn")?"危地馬拉      ":"Guatemala";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"幾內亞比桑      ":"Guinea-Bissau";?>"><?php echo ($lang=="cn")?"幾內亞比桑      ":"Guinea-Bissau";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"圭亞那      ":"Guyana";?>"><?php echo ($lang=="cn")?"圭亞那      ":"Guyana";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"海地      ":"Haiti";?>"><?php echo ($lang=="cn")?"海地      ":"Haiti";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"洪都拉斯      ":"Honduras";?>"><?php echo ($lang=="cn")?"洪都拉斯      ":"Honduras";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"匈牙利      ":"Hungary";?>"><?php echo ($lang=="cn")?"匈牙利      ":"Hungary";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"冰島      ":"Iceland";?>"><?php echo ($lang=="cn")?"冰島      ":"Iceland";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"印度      ":"India";?>"><?php echo ($lang=="cn")?"印度      ":"India";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"印尼      ":"Indonesia";?>"><?php echo ($lang=="cn")?"印尼      ":"Indonesia";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"伊拉克      ":"Irak";?>"><?php echo ($lang=="cn")?"伊拉克      ":"Irak";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"伊朗      ":"Iran";?>"><?php echo ($lang=="cn")?"伊朗      ":"Iran";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"愛爾蘭      ":"Ireland";?>"><?php echo ($lang=="cn")?"愛爾蘭      ":"Ireland";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"以色列      ":"Israel";?>"><?php echo ($lang=="cn")?"以色列      ":"Israel";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"意大利      ":"Italy";?>"><?php echo ($lang=="cn")?"意大利      ":"Italy";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"牙買加      ":"Jamaica";?>"><?php echo ($lang=="cn")?"牙買加      ":"Jamaica";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"日本      ":"Japan";?>"><?php echo ($lang=="cn")?"日本      ":"Japan";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"約旦      ":"Jordan";?>"><?php echo ($lang=="cn")?"約旦      ":"Jordan";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"哈薩克斯坦      ":"Kazakhstan";?>"><?php echo ($lang=="cn")?"哈薩克斯坦      ":"Kazakhstan";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"肯尼亞      ":"Kenya";?>"><?php echo ($lang=="cn")?"肯尼亞      ":"Kenya";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"科威特      ":"Kuwait";?>"><?php echo ($lang=="cn")?"科威特      ":"Kuwait";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"老撾      ":"Laos";?>"><?php echo ($lang=="cn")?"老撾      ":"Laos";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"黎巴嫩      ":"Lebanon";?>"><?php echo ($lang=="cn")?"黎巴嫩      ":"Lebanon";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"維多尼亞      ":"Lethonia";?>"><?php echo ($lang=="cn")?"維多尼亞      ":"Lethonia";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"利比亞      ":"Libya";?>"><?php echo ($lang=="cn")?"利比亞      ":"Libya";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"立陶宛      ":"Lithuania";?>"><?php echo ($lang=="cn")?"立陶宛      ":"Lithuania";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"盧森堡      ":"Luxembourg";?>"><?php echo ($lang=="cn")?"盧森堡      ":"Luxembourg";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"馬其頓      ":"Macedonia";?>"><?php echo ($lang=="cn")?"馬其頓      ":"Macedonia";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"馬達加斯加      ":"Madagascar";?>"><?php echo ($lang=="cn")?"馬達加斯加      ":"Madagascar";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"馬來西亞      ":"Malaysia";?>"><?php echo ($lang=="cn")?"馬來西亞      ":"Malaysia";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"馬爾代夫      ":"Maldives";?>"><?php echo ($lang=="cn")?"馬爾代夫      ":"Maldives";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"馬里      ":"Mali";?>"><?php echo ($lang=="cn")?"馬里      ":"Mali";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"馬耳他      ":"Malta";?>"><?php echo ($lang=="cn")?"馬耳他      ":"Malta";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"馬紹爾群島      ":"Marshall Islands";?>"><?php echo ($lang=="cn")?"馬紹爾群島      ":"Marshall Islands";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"毛里塔尼亞      ":"Martinica";?>"><?php echo ($lang=="cn")?"毛里塔尼亞      ":"Martinica";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"毛里求斯      ":"Mauritania";?>"><?php echo ($lang=="cn")?"毛里求斯      ":"Mauritania";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"毛里求斯      ":"Mauritania";?>"><?php echo ($lang=="cn")?"毛里求斯      ":"Mauritania";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"墨西哥      ":"Mexico";?>"><?php echo ($lang=="cn")?"墨西哥      ":"Mexico";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"密克羅尼西亞      ":"Micronesia";?>"><?php echo ($lang=="cn")?"密克羅尼西亞      ":"Micronesia";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"摩爾多瓦      ":"Moldova";?>"><?php echo ($lang=="cn")?"摩爾多瓦      ":"Moldova";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"摩納哥      ":"Moldova";?>"><?php echo ($lang=="cn")?"摩納哥      ":"Moldova";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"蒙古      ":"Mongolia";?>"><?php echo ($lang=="cn")?"蒙古      ":"Mongolia";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"摩洛哥      ":"Morocco";?>"><?php echo ($lang=="cn")?"摩洛哥      ":"Morocco";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"莫桑比克      ":"Mozambique";?>"><?php echo ($lang=="cn")?"莫桑比克      ":"Mozambique";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"緬甸      ":"Myanmar";?>"><?php echo ($lang=="cn")?"緬甸      ":"Myanmar";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"納米比亞      ":"Namibia";?>"><?php echo ($lang=="cn")?"納米比亞      ":"Namibia";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"瑙魯      ":"Nauru";?>"><?php echo ($lang=="cn")?"瑙魯      ":"Nauru";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"瑙魯      ":"Nauru";?>"><?php echo ($lang=="cn")?"瑙魯      ":"Nauru";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"荷蘭      ":"Netherlands";?>"><?php echo ($lang=="cn")?"荷蘭      ":"Netherlands";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"新西蘭      ":"New   Zealand";?>"><?php echo ($lang=="cn")?"新西蘭      ":"New   Zealand";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"尼加拉瓜      ":"Nicaragua";?>"><?php echo ($lang=="cn")?"尼加拉瓜      ":"Nicaragua";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"尼日爾      ":"Niger";?>"><?php echo ($lang=="cn")?"尼日爾      ":"Niger";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"尼日利亞      ":"Nigeria";?>"><?php echo ($lang=="cn")?"尼日利亞      ":"Nigeria";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"尼日利亞      ":"Nigeria";?>"><?php echo ($lang=="cn")?"尼日利亞      ":"Nigeria";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"北韓      ":"Norway";?>">"<?php echo ($lang=="cn")?"北韓      ":"Norway";?>"</OPTION>
        <OPTION value=""<?php echo ($lang=="cn")?"阿曼      ":"Oman";?>""><?php echo ($lang=="cn")?"阿曼      ":"Oman";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"巴基斯坦      ":"Pakistan";?>"><?php echo ($lang=="cn")?"巴基斯坦      ":"Pakistan";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"帕勞      ":"Palau";?>"><?php echo ($lang=="cn")?"帕勞      ":"Palau";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"巴拿馬      ":"Panama";?>"><?php echo ($lang=="cn")?"巴拿馬      ":"Panama";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"巴布亞新幾內亞      ":"Papua New Guinea";?>"><?php echo ($lang=="cn")?"巴布亞新幾內亞      ":"Papua New Guinea";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"巴拉圭      ":"Paraguay";?>"><?php echo ($lang=="cn")?"巴拉圭      ":"Paraguay";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"秘魯      ":"Peru";?>"><?php echo ($lang=="cn")?"秘魯      ":"Peru";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"菲律賓      ":"Philippines";?>"><?php echo ($lang=="cn")?"菲律賓      ":"Philippines";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"波蘭      ":"Poland";?>"><?php echo ($lang=="cn")?"波蘭      ":"Poland";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"葡萄牙      ":"Portugal";?>"><?php echo ($lang=="cn")?"葡萄牙      ":"Portugal";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"卡塔爾      ":"Qatar";?>"><?php echo ($lang=="cn")?"卡塔爾      ":"Qatar";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"留尼旺島      ":"Reunion";?>"><?php echo ($lang=="cn")?"留尼旺島      ":"Reunion";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"羅馬尼亞      ":"Romania";?>"><?php echo ($lang=="cn")?"羅馬尼亞      ":"Romania";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"俄羅斯      ":"Russia";?>"><?php echo ($lang=="cn")?"俄羅斯      ":"Russia";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"盧旺達      ":"Rwanda";?>"><?php echo ($lang=="cn")?"盧旺達      ":"Rwanda";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"薩摩亞      ":"Samoa";?>"><?php echo ($lang=="cn")?"薩摩亞      ":"Samoa";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"聖馬力諾      ":"San   Marino";?>"><?php echo ($lang=="cn")?"聖馬力諾      ":"San   Marino";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"沙特阿拉伯      ":"Saudi Arabia";?>"><?php echo ($lang=="cn")?"沙特阿拉伯      ":"Saudi Arabia";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"塞內加爾      ":"Senegal";?>"><?php echo ($lang=="cn")?"塞內加爾      ":"Senegal";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"塞舌爾      ":"Seychelles";?>"><?php echo ($lang=="cn")?"塞舌爾      ":"Seychelles";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"塞拉利昂      ":"Sierra Leone";?>"><?php echo ($lang=="cn")?"塞拉利昂      ":"Sierra Leone";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"新加坡      ":"Singapore";?>"><?php echo ($lang=="cn")?"新加坡      ":"Singapore";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"斯洛伐克      ":"Slovakia";?>"><?php echo ($lang=="cn")?"斯洛伐克      ":"Slovakia";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"斯洛文尼亞      ":"Slovenia";?>"><?php echo ($lang=="cn")?"斯洛文尼亞      ":"Slovenia";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"所羅門群島      ":"Solomon   Islands";?>"><?php echo ($lang=="cn")?"所羅門群島      ":"Solomon   Islands";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"索馬里      ":"Somalia";?>"><?php echo ($lang=="cn")?"索馬里      ":"Somalia";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"南非      ":"South Africa";?>"><?php echo ($lang=="cn")?"南非      ":"South Africa";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"韓國      ":"South   Korea";?>"><?php echo ($lang=="cn")?"韓國      ":"South   Korea";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"西班牙      ":"Spain";?>"><?php echo ($lang=="cn")?"西班牙      ":"Spain";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"斯里蘭卡      ":"Sri   Lanka";?>"><?php echo ($lang=="cn")?"斯里蘭卡      ":"Sri   Lanka";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"聖盧西亞      ":"St.Lucia";?>"><?php echo ($lang=="cn")?"聖盧西亞      ":"St.Lucia";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"蘇丹      ":"Sudan";?>"><?php echo ($lang=="cn")?"蘇丹      ":"Sudan";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"蘇里南      ":"Suriname";?>"><?php echo ($lang=="cn")?"蘇里南      ":"Suriname";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"瑞典      ":"Sweden";?>"><?php echo ($lang=="cn")?"瑞典      ":"Sweden";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"瑞士      ":"Switzerland";?>"><?php echo ($lang=="cn")?"瑞士      ":"Switzerland";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"敘利亞      ":"Syria";?>"><?php echo ($lang=="cn")?"敘利亞      ":"Syria";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"塔希提島      ":"Tahiti";?>"><?php echo ($lang=="cn")?"塔希提島      ":"Tahiti";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"台灣      ":"Taiwan";?>"><?php echo ($lang=="cn")?"台灣      ":"Taiwan";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"塔吉克斯坦      ":"Tajikistan";?>"><?php echo ($lang=="cn")?"塔吉克斯坦      ":"Tajikistan";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"坦桑尼亞      ":"Tanzania";?>"><?php echo ($lang=="cn")?"坦桑尼亞      ":"Tanzania";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"泰國      ":"Thailand";?>"><?php echo ($lang=="cn")?"泰國      ":"Thailand";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"多哥      ":"Togo";?>"><?php echo ($lang=="cn")?"多哥      ":"Togo";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"東加      ":"Tonga";?>"><?php echo ($lang=="cn")?"東加      ":"Tonga";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"特立尼達和多巴哥      ":"Trinidad and   Tobago";?>"><?php echo ($lang=="cn")?"特立尼達和多巴哥      ":"Trinidad and   Tobago";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"突尼斯      ":"Tunisia";?>"><?php echo ($lang=="cn")?"突尼斯      ":"Tunisia";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"土耳其      ":"Turkey";?>"><?php echo ($lang=="cn")?"土耳其      ":"Turkey";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"土庫曼斯坦      ":"Turkmenistan";?>"><?php echo ($lang=="cn")?"土庫曼斯坦      ":"Turkmenistan";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"圖瓦盧      ":"Tuvalu";?>"><?php echo ($lang=="cn")?"圖瓦盧      ":"Tuvalu";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"烏干達      ":"Uganda";?>"><?php echo ($lang=="cn")?"烏干達      ":"Uganda";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"烏克蘭      ":"Ukraine";?>"><?php echo ($lang=="cn")?"烏克蘭      ":"Ukraine";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"阿拉伯聯合酋長國      ":"United Arab Emirates";?>"><?php echo ($lang=="cn")?"阿拉伯聯合酋長國      ":"United Arab Emirates";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"聯合王國      ":"United Kingdom";?>"><?php echo ($lang=="cn")?"聯合王國      ":"United Kingdom";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"美國      ":"United States";?>"><?php echo ($lang=="cn")?"美國      ":"United States";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"烏拉圭      ":"Uruguay";?>"><?php echo ($lang=="cn")?"烏拉圭      ":"Uruguay";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"烏茲別克斯坦      ":"Uzbekistan";?>"><?php echo ($lang=="cn")?"烏茲別克斯坦      ":"Uzbekistan";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"萬那杜      ":"Vanuatu";?>"><?php echo ($lang=="cn")?"萬那杜      ":"Vanuatu";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"梵蒂岡城      ":"Vatican   City";?>"><?php echo ($lang=="cn")?"梵蒂岡城      ":"Vatican   City";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"委內瑞拉      ":"Venezuela";?>"><?php echo ($lang=="cn")?"委內瑞拉      ":"Venezuela";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"越南      ":"Vietnam";?>" selected><?php echo ($lang=="cn")?"越南      ":"Vietnam";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"也門      ":"Yemen";?>"><?php echo ($lang=="cn")?"也門      ":"Yemen";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"南斯拉夫      ":"Yugoslavia";?>"><?php echo ($lang=="cn")?"南斯拉夫      ":"Yugoslavia";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"贊比亞      ":"Zambia";?>"><?php echo ($lang=="cn")?"贊比亞      ":"Zambia";?></OPTION>
        <OPTION value="<?php echo ($lang=="cn")?"津巴布韋      ":"Zimbabwue";?>"><?php echo ($lang=="cn")?"津巴布韋      ":"Zimbabwue";?></OPTION>
  </select>  </td>
</tr>
<tr>
  <td class="<?php echo ($lang=='cn')?"lable_contact":"lable";?>"><?php echo $dienthoai; echo $require; ?></td>
  <td><input name="txtdienthoai" type="text" id="txtdienthoai" size="30" class="text_area" /></td>
</tr>
<tr>
  <td class="<?php echo ($lang=='cn')?"lable_contact":"lable";?>"><?php echo $fax; ?></td>
  <td><input name="txtfax" type="text" id="txtfax" size="30" class="text_area" /></td>
</tr>
<tr>
  <td class="<?php echo ($lang=='cn')?"lable_contact":"lable";?>"><?php echo $email; echo $require; ?></td>
  <td><input name="txtemail" type="text" id="txtemail" size="30" class="text_area" /></td>
</tr>
<tr>
  <td class="<?php echo ($lang=='cn')?"lable_contact":"lable";?>"><?php echo $website; ?></td>
  <td><input name="txtwebsite" type="text" id="txtwebsite" size="30" class="text_area" /></td>
</tr>
<tr>
  <td colspan="2" class="<?php echo ($lang=='cn')?"lable_contact":"lable";?>" style="vertical-align:top; padding-top:3px;"><?php echo $chude; echo $require; ?><br /><input name="txtchude" type="text" id="txtchude" size="46" class="text_area" />
    <br />
    <br />
    <?php echo $noidung; echo $require; ?><br />
    <textarea name="txtnoidung" cols="47" rows="8" id="txtnoidung" class="text_area"></textarea></td>
  </tr>
<tr>
  <td align="center" >&nbsp;</td>
  <td ><input name="Submit" type="submit" id="submit" value="<?php echo $submit; ?>" style="width:80px; height:30px; font-family:Tahoma; font-weight:bold; color:#59515C;" onclick="javascript:SubmitContact('sendcontact');" />
    <input name="task" type="hidden" id="task" value="sendcontact" /></td>
</tr>
  </form>
  </table>
  </div>
		</td>
	</tr>
						</table>
						
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="background-image:url(images/banggt_10.jpg); background-repeat:no-repeat;" height="21">
		</td>
	</tr>
</table>
	<?php
}
?>


