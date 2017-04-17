<?php
defined("_ALLOW") or die ("Access denied");
?>
<?php
isset($_REQUEST['task']) or die ("Access denied");
$task = $_REQUEST['task'];
($task == "submitordercart" || $task == "ordercart") or die ("Access denied");
isset($_REQUEST['totalcart']) or die ("Access denied");
$sum = $_REQUEST['totalcart'];
($sum >0) or die ("Access denied");
?>
<script language="javascript">
/*
function SubmitCart (pressbutton) {
	form = document.formshoppingcart;
	if (pressbutton == "ordercart") {
		if (form.totalcart.value == 0)
			return;
	}
	form.task.value = pressbutton;
	form.submit();
}
*/
</script>
<?php
switch ($task) {
	case "submitordercart":
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
		$message = "Có một khách đặt hàng với bạn qua website. Sau đây là thông tin mà khách đã cung cấp:<br>";
		$message .= "Tên: " . $lstten . " " . $hoten . "<br>";
		$message .= "Chức danh: " . $chucdanh . "<br>";
		$message .= "Công ty: " . $congty . "<br>";
		$message .= "Địa chỉ: " . $diachi . "<br>";
		$message .= "Quốc gia: " . $quocgia . "<br>";
		$message .= "Điện thoại: " . $dienthoai . "<br>";
		$message .= "Fax: " . $fax . "<br>";
		$message .= "Email: " . $email . "<br>";
		$message .= "Website: " . $website . "<br><br>";
		
		$message .= "<html><body>";
		$message .= "<table width='100%' border='1' cellspacing='0' cellpadding='3'>";
		$message .= "<tr>";
		$message .= "<td width='50%'><strong>Tên sản phẩm</strong></td>";
		$message .= "<td width='20%'><strong>Số lượng</strong></td>";
		$message .= "<td width='30%'><strong>Đơn giá</strong></td>";
		$message .= "</tr>";
		$count = count($_SESSION['item']);
		$sum = $_REQUEST['totalcart'];
		for ($i=0; $i<$count; $i++) {
			if ($_SESSION['item'][$i] > -1) {
				$itemname = $_SESSION['itemname'][$i];
				$itemquanlity = $_SESSION['itemquanlity'][$i];
				$itemprice = $_SESSION['itemfprice'][$i];
				$message .= "<tr><td>$itemname</td><td>$itemquanlity</td><td>$itemprice</td></tr>";
			}
		}
		$message .= "<tr><td colspan='3' style='font-weight:bold;' align='right'>Tổng: " . $sum . "</td></tr>";
		$message .= "</table>";
		$message .= "</body></html>";
		
		/*
		$count = count($_SESSION['item']);
		for ($i=0; $i<$count; $i++) {
			if ($_SESSION['item'][$i] > -1) {
				$itemname = $_SESSION['itemname'][$i];
				$itemquanlity = $_SESSION['itemquanlity'][$i];
				$itemprice = $_SESSION['itemfprice'][$i];
				$message .= "Tên sản phẩm: " . $itemname . "<br>";
				$message .= "Số lượng: " . $itemquanlity . "<br>";
				$message .= "Đơn giá: " . $itemprice . "<br><br>";
			}
		}
		*/
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n";
		$headers .= "From: " . $lstten . " " . $hoten . "<" . $email . ">\r\n";
		if ($lang=="vn")
		echo "Nội dung góp ý (yêu cầu) của quý khách đang được gửi đến chúng tôi, vui lòng chờ trong giây lát...";
		else
		echo "Your message is sending to us, please wait some seconds...";
		global $cfg_mail;
		mail($cfg_mail,"Shopping Cart Email",$message,$headers);
		
		unset($_SESSION['item']);
		unset($_SESSION['itemname']);
		unset($_SESSION['itemprice']);
		unset($_SESSION['itemfprice']);
		unset($_SESSION['itemquanlity']);
		mosRedirect("index.php");
		break;
	default:
		global $lang;
		$require = "<span class=\"style1\">*</span>";
		$submit = "Gửi";
		$hoten = "Tên:";
		$chucdanh = "Chức danh:";
		$congty = "Công ty:";
		$diachi = "Địa chỉ:";
		$quocgia = "Quốc gia:";
		$dienthoai = "Điện thoại:";
		$fax = "Fax:";
		$email = "E-mail: ";
		if ($lang=="en") {
			$hoten = "Name:";
			$chucdanh = "Job status:";
			$congty = "Company:";
			$diachi = "Address:";
			$quocgia = "Nation:";
			$dienthoai = "Phone:";
			$submit = "Send";
		}
	?>
		<script language="javascript" src="common/js/checkcontactcart.js"></script>
		<script language="javascript">
		function SubmitContact (pressbutton) {
			var form = document.frmcontact;
			if (CheckContactCart(form)) {
				form.task.value = pressbutton;
				form.submit();
			}
		}
		</script>
		<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
	  <td class="title_category"><?php if ($lang=="vn") echo "THÔNG TIN CỦA BẠN"; else echo "YOUR DETAIL CONTACT"; ?></td>
	  </tr>
	<tr><td style="padding-top:20px;">
	<form action="index.php?module=com_ordercart" method="post" name="frmcontact" id="contact" onsubmit="return CheckContactCart(this);">
<table width="387" align="center" cellpadding="0" cellspacing="0">
<tr>
  <td width="95" class="contact_left"><?php echo $hoten; echo $require; ?></td>
  <td width="290"><select name="lstten" id="lstten" style="width:40px;">
    <option value="Mr." selected="selected">Mr.</option>
    <option value="Ms.">Ms.</option>
    <option value="Mrs.">Mrs.</option>
    </select>
    <input name="txthoten" type="text" id="txthoten" size="23" /></td>
</tr>
<tr>
  <td class="contact_left"><?php echo $chucdanh; ?></td>
  <td><input name="txtchucdanh" type="text" id="txtchucdanh" size="30" /></td>
</tr>
<tr>
  <td class="contact_left"><?php echo $congty; ?></td>
  <td><input name="txtcongty" type="text" id="txtcongty" size="30" /></td>
</tr>
<tr>
  <td class="contact_left"><?php echo $diachi; ?></td>
  <td><input name="txtdiachi" type="text" id="txtdiachi" size="30" /></td>
</tr>
<tr>
  <td class="contact_left"><?php echo $quocgia; echo $require; ?></td>
  <td><select name="lstquocgia" id="lstquocgia">
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
  <td class="contact_left"><?php echo $dienthoai; echo $require; ?></td>
  <td><input name="txtdienthoai" type="text" id="txtdienthoai" size="30" /></td>
</tr>
<tr>
  <td class="contact_left"><?php echo $fax; ?></td>
  <td><input name="txtfax" type="text" id="txtfax" size="30" /></td>
</tr>
<tr>
  <td class="contact_left"><?php echo $email; echo $require; ?></td>
  <td><input name="txtemail" type="text" id="txtemail" size="30" /></td>
</tr>
<tr>
  <td colspan="2" align="center" class="contact_left"><input name="submitordercart" type="submit" id="submitordercart" onclick="javascript:SubmitContact('submitordercart');" value="<?php echo $submit; ?>" style="width:80px; height:30px; font-family:Tahoma; font-weight:bold; color:#59515C;"/>
    <input name="task" type="hidden" id="task" value="submitordercart" />
    <input type="hidden" name="totalcart" id="totalcart" value="<?php echo $sum; ?>"  /></td>
  </tr>
  </table>
  </form>
	</td></tr>
	</table>
	<?php
}
?>