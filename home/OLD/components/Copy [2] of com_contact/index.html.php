<?php
defined("_ALLOW") or die ("Access denied");
$task = "";

if (isset($_REQUEST['task'])) $task = $_REQUEST['task'];
global $cfg_mailname;
global $cfg_title_site;
global $cfg_live_site;
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
		$message = "Có một khách liên hệ với bạn qua website $cfg_live_site. Sau đây là thông tin mà khách đã cung cấp:<br>";
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
							<?php if ($lang=="vn") echo "LIÊN HỆ"; else echo "CONTACT"; ?>
						</div>
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
		<td style="padding-top:40px;">
			<div >
<div class="content_view" ><?php echo str_replace("\\\"","\"",$loichao); ?></div>
<table width="314" align="center" cellpadding="0" cellspacing="1" class="table_contact">
<form action="index.php?module=com_contact" method="post" name="frmcontact" id="frmcontact" onsubmit="return CheckContact(this);">
<tr>
  <td width="78" class="lable"><?php echo $hoten; echo $require; ?></td>
  <td width="231"><select name="lstten" id="lstten" class="list_area">
    <option value="Mr." selected="selected">Mr.</option>
    <option value="Ms.">Ms.</option>
    <option value="Mrs.">Mrs.</option>
    </select>
    <input name="txthoten" type="text" id="txthoten" size="19" class="text_area" /></td>
</tr>
<tr>
  <td class="lable"><?php echo $chucdanh; ?></td>
  <td><input name="txtchucdanh" type="text" id="txtchucdanh" size="30" class="text_area" /></td>
</tr>
<tr>
  <td class="lable"><?php echo $congty; ?></td>
  <td><input name="txtcongty" type="text" id="txtcongty" size="30" class="text_area" /></td>
</tr>
<tr>
  <td class="lable"><?php echo $diachi; ?></td>
  <td><input name="txtdiachi" type="text" id="txtdiachi" size="30" class="text_area" /></td>
</tr>
<tr>
  <td class="lable"><?php echo $quocgia; echo $require; ?></td>
  <td><select name="lstquocgia" id="lstquocgia" class="list_area">
    <OPTION value="Afghanistan">Afghanistan</OPTION>
        <OPTION value="Albania">Albania</OPTION>
        <OPTION value="Algeria">Algeria</OPTION>
        <OPTION value="Andorra">Andorra</OPTION>
        <OPTION value="Angola">Angola</OPTION>
        <OPTION value="Argentina">Argentina</OPTION>
        <OPTION value="Armenia">Armenia</OPTION>
        <OPTION value="Australia">Australia</OPTION>
        <OPTION value="Austria">Austria</OPTION>
        <OPTION value="Azerbaijan">Azerbaijan</OPTION>
        <OPTION value="Bahamas">Bahamas</OPTION>
        <OPTION value="Bahrain">Bahrain</OPTION>
        <OPTION value="Bangladesh">Bangladesh</OPTION>
        <OPTION value="Belgium">Belgium</OPTION>
        <OPTION value="Belize">Belize</OPTION>
        <OPTION value="Belorussia">Belorussia</OPTION>
        <OPTION value="Benin">Benin</OPTION>
        <OPTION value="Bermudas">Bermudas</OPTION>
        <OPTION value="Bhutan">Bhutan</OPTION>
        <OPTION value="Bolivia">Bolivia</OPTION>
        <OPTION value="Botswana">Botswana</OPTION>
        <OPTION value="Brazil">Brazil</OPTION>
        <OPTION value="Brunei">Brunei</OPTION>
        <OPTION value="Bulgary">Bulgary</OPTION>
        <OPTION value="Burkina Faso">Burkina   Faso</OPTION>
        <OPTION value="Burundi">Burundi</OPTION>
        <OPTION value="Cambodia">Cambodia</OPTION>
        <OPTION value="Camerun">Camerun</OPTION>
        <OPTION value="Canada">Canada</OPTION>
        <OPTION value="Cape Verde">Cape Verde</OPTION>
        <OPTION value="Colombia">Colombia</OPTION>
        <OPTION value="Congo(Brazzaville)">Congo(Brazzaville)</OPTION>
        <OPTION value="Costa Rica">Costa Rica</OPTION>
        <OPTION value="Côte d’Ivoire">Côte   d’Ivoire</OPTION>
        <OPTION value="Croatia">Croatia</OPTION>
        <OPTION value="Cuba">Cuba</OPTION>
        <OPTION value="Cyprus">Cyprus</OPTION>
        <OPTION value="Czech Republic">Czech Republic</OPTION>
        <OPTION value="Chad">Chad</OPTION>
        <OPTION value="Chile">Chile</OPTION>
        <OPTION value="China">China</OPTION>
        <OPTION value="Denmark">Denmark</OPTION>
        <OPTION value="Djibouti">Djibouti</OPTION>
        <OPTION value="Dominican Republic">Dominican Republic</OPTION>
        <OPTION value="Dubai">Dubai</OPTION>
        <OPTION value="Ecuador">Ecuador</OPTION>
        <OPTION value="Egypt">Egypt</OPTION>
        <OPTION value="El Salvador">El Salvador</OPTION>
        <OPTION value="Equatorial Guinea">Equatorial Guinea</OPTION>
        <OPTION value="Eritrea">Eritrea</OPTION>
        <OPTION value="Estonia">Estonia</OPTION>
        <OPTION value="Ethiopia">Ethiopia</OPTION>
        <OPTION value="Fidji Islands">Fidji   Islands</OPTION>
        <OPTION value="Finland">Finland</OPTION>
        <OPTION value="France">France</OPTION>
        <OPTION value="Gabon">Gabon</OPTION>
        <OPTION value="Gambia">Gambia</OPTION>
        <OPTION value="Georgia">Georgia</OPTION>
        <OPTION value="Germany">Germany</OPTION>
        <OPTION value="Ghana">Ghana</OPTION>
        <OPTION value="Greece">Greece</OPTION>
        <OPTION value="Guatemala">Guatemala</OPTION>
        <OPTION value="Guinea-Bissau">Guinea-Bissau</OPTION>
        <OPTION value="Guyana">Guyana</OPTION>
        <OPTION value="Haiti">Haiti</OPTION>
        <OPTION value="Honduras">Honduras</OPTION>
        <OPTION value="Hungary">Hungary</OPTION>
        <OPTION value="Iceland">Iceland</OPTION>
        <OPTION value="India">India</OPTION>
        <OPTION value="Indonesia">Indonesia</OPTION>
        <OPTION value="Irak">Irak</OPTION>
        <OPTION value="Iran">Iran</OPTION>
        <OPTION value="Ireland">Ireland</OPTION>
        <OPTION value="Israel">Israel</OPTION>
        <OPTION value="Italy">Italy</OPTION>
        <OPTION value="Jamaica">Jamaica</OPTION>
        <OPTION value="Japan">Japan</OPTION>
        <OPTION value="Jordan">Jordan</OPTION>
        <OPTION value="Kazakhstan">Kazakhstan</OPTION>
        <OPTION value="Kenya">Kenya</OPTION>
        <OPTION value="Kuwait">Kuwait</OPTION>
        <OPTION value="Laos">Laos</OPTION>
        <OPTION value="Lebanon">Lebanon</OPTION>
        <OPTION value="Lethonia">Lethonia</OPTION>
        <OPTION value="Libya">Libya</OPTION>
        <OPTION value="Lithuania">Lithuania</OPTION>
        <OPTION value="Luxembourg">Luxembourg</OPTION>
        <OPTION value="Macedonia">Macedonia</OPTION>
        <OPTION value="Madagascar">Madagascar</OPTION>
        <OPTION value="Malaysia">Malaysia</OPTION>
        <OPTION value="Maldives">Maldives</OPTION>
        <OPTION value="Mali">Mali</OPTION>
        <OPTION value="Malta">Malta</OPTION>
        <OPTION value="Marshall Islands">Marshall Islands</OPTION>
        <OPTION value="Martinica">Martinica</OPTION>
        <OPTION value="Mauritania">Mauritania</OPTION>
        <OPTION value="Mauritius">Mauritius</OPTION>
        <OPTION value="Mexico">Mexico</OPTION>
        <OPTION value="Micronesia">Micronesia</OPTION>
        <OPTION value="Moldova">Moldova</OPTION>
        <OPTION value="Monaco">Monaco</OPTION>
        <OPTION value="Mongolia">Mongolia</OPTION>
        <OPTION value="Morocco">Morocco</OPTION>
        <OPTION value="Mozambique">Mozambique</OPTION>
        <OPTION value="Myanmar">Myanmar</OPTION>
        <OPTION value="Namibia">Namibia</OPTION>
        <OPTION value="Nauru">Nauru</OPTION>
        <OPTION value="Nepal">Nepal</OPTION>
        <OPTION value="Netherlands">Netherlands</OPTION>
        <OPTION value="New Zealand">New   Zealand</OPTION>
        <OPTION value="Nicaragua">Nicaragua</OPTION>
        <OPTION value="Niger">Niger</OPTION>
        <OPTION value="Nigeria">Nigeria</OPTION>
        <OPTION value="North Korea">North Korea</OPTION>
        <OPTION value="Norway">Norway</OPTION>
        <OPTION value="Oman">Oman</OPTION>
        <OPTION value="Pakistan">Pakistan</OPTION>
        <OPTION value="Palau">Palau</OPTION>
        <OPTION value="Panama">Panama</OPTION>
        <OPTION value="Papua New Guinea">Papua New Guinea</OPTION>
        <OPTION value="Paraguay">Paraguay</OPTION>
        <OPTION value="Peru">Peru</OPTION>
        <OPTION value="Philippines">Philippines</OPTION>
        <OPTION value="Poland">Poland</OPTION>
        <OPTION value="Portugal">Portugal</OPTION>
        <OPTION value="Qatar">Qatar</OPTION>
        <OPTION value="Reunion">Reunion</OPTION>
        <OPTION value="Romania">Romania</OPTION>
        <OPTION value="Russia">Russia</OPTION>
        <OPTION value="Rwanda">Rwanda</OPTION>
        <OPTION value="Samoa">Samoa</OPTION>
        <OPTION value="San Marino">San   Marino</OPTION>
        <OPTION value="Saudi Arabia">Saudi Arabia</OPTION>
        <OPTION value="Senegal">Senegal</OPTION>
        <OPTION value="Seychelles">Seychelles</OPTION>
        <OPTION value="Sierra Leone">Sierra Leone</OPTION>
        <OPTION value="Singapore">Singapore</OPTION>
        <OPTION value="Slovakia">Slovakia</OPTION>
        <OPTION value="Slovenia">Slovenia</OPTION>
        <OPTION value="Solomon Islands">Solomon   Islands</OPTION>
        <OPTION value="Somalia">Somalia</OPTION>
        <OPTION value="South Africa">South Africa</OPTION>
        <OPTION value="South Korea">South   Korea</OPTION>
        <OPTION value="Spain">Spain</OPTION>
        <OPTION value="Sri Lanka">Sri   Lanka</OPTION>
        <OPTION value="St.Kitts and Nevis">St.Kitts and Nevis</OPTION>
        <OPTION value="St.Lucia">St.Lucia</OPTION>
        <OPTION value="Sudan">Sudan</OPTION>
        <OPTION value="Suriname">Suriname</OPTION>
        <OPTION value="Sweden">Sweden</OPTION>
        <OPTION value="Switzerland">Switzerland</OPTION>
        <OPTION value="Syria">Syria</OPTION>
        <OPTION value="Tahiti">Tahiti</OPTION>
        <OPTION value="Taiwan">Taiwan</OPTION>
        <OPTION value="Tajikistan">Tajikistan</OPTION>
        <OPTION value="Tanzania">Tanzania</OPTION>
        <OPTION value="Thailand">Thailand</OPTION>
        <OPTION value="Togo">Togo</OPTION>
        <OPTION value="Tonga">Tonga</OPTION>
        <OPTION value="Trinidad and Tobago">Trinidad and   Tobago</OPTION>
        <OPTION value="Tunisia">Tunisia</OPTION>
        <OPTION value="Turkey">Turkey</OPTION>
        <OPTION value="Turkmenistan">Turkmenistan</OPTION>
        <OPTION value="Tuvalu">Tuvalu</OPTION>
        <OPTION value="Uganda">Uganda</OPTION>
        <OPTION value="Ukraine">Ukraine</OPTION>
        <OPTION value="United Arab Emirates">United Arab Emirates</OPTION>
        <OPTION value="United Kingdom">United Kingdom</OPTION>
        <OPTION value="United States">United States</OPTION>
        <OPTION value="Uruguay">Uruguay</OPTION>
        <OPTION value="Uzbekistan">Uzbekistan</OPTION>
        <OPTION value="Vanuatu">Vanuatu</OPTION>
        <OPTION value="Vatican City">Vatican   City</OPTION>
        <OPTION value="Venezuela">Venezuela</OPTION>
        <OPTION value="Vietnam" selected>Vietnam</OPTION>
        <OPTION value="Yemen">Yemen</OPTION>
        <OPTION value="Yugoslavia">Yugoslavia</OPTION>
        <OPTION value="Zambia">Zambia</OPTION>
        <OPTION value="Zimbabwue">Zimbabwue</OPTION>
  </select>  </td>
</tr>
<tr>
  <td class="lable"><?php echo $dienthoai; echo $require; ?></td>
  <td><input name="txtdienthoai" type="text" id="txtdienthoai" size="30" class="text_area" /></td>
</tr>
<tr>
  <td class="lable"><?php echo $fax; ?></td>
  <td><input name="txtfax" type="text" id="txtfax" size="30" class="text_area" /></td>
</tr>
<tr>
  <td class="lable"><?php echo $email; echo $require; ?></td>
  <td><input name="txtemail" type="text" id="txtemail" size="30" class="text_area" /></td>
</tr>
<tr>
  <td class="lable"><?php echo $website; ?></td>
  <td><input name="txtwebsite" type="text" id="txtwebsite" size="30" class="text_area" /></td>
</tr>
<tr>
  <td colspan="2" class="lable" style="vertical-align:top; padding-top:3px;"><?php echo $chude; echo $require; ?><br /><input name="txtchude" type="text" id="txtchude" size="46" class="text_area" />
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


