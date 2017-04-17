<?php

$bline="\r\n";
// =============================================================================================
// Escape Chuoi
// =============================================================================================
function php_escape($str){
	$sublen=strlen($str);
	$reString="";
	for ($i=0;$i<$sublen;$i++){
		if(ord($str[$i])>=127){
			$tmpString=bin2hex(iconv("GBK","ucs-2",substr($str,$i,2)));    //??GBK??????????,???????
			if (!eregi("WIN",PHP_OS)) $tmpString=substr($tmpString,2,2).substr($tmpString,0,2);
			$reString.="%u".$tmpString;
			$i++;
		} else {
			$reString.="%".dechex(ord($str[$i]));
		}
	}
	return $reString;
}

function php_unescape($str) { 
	$str = rawurldecode($str); 
	preg_match_all("/%u.{4}|&#x.{4};|&#d+;|.+/U",$str,$r); 
	$ar = $r[0]; 
	foreach($ar as $k=>$v) { 
		if(substr($v,0,2) == "%u") 
			$ar[$k] = iconv("UCS-2","GBK",pack("H4",substr($v,-4))); 
		elseif(substr($v,0,3) == "&#x") 
			$ar[$k] = iconv("UCS-2","GBK",pack("H4",substr($v,3,-1))); 
		elseif(substr($v,0,2) == "&#") { 
			$ar[$k] = iconv("UCS-2","GBK",pack("n",substr($v,2,-1))); 
		} 
	} 
	return join("",$ar); 
}
// =============================================================================================
// Tra ve chu Hoa
// =============================================================================================
function low2Up($chuoi) {
	$temp="";
	for ($i=0;$i<strlen($chuoi);$i++) {
		$char=substr($chuoi,$i,1);
		if ($char>="a" && $char<="z") {
			$char=strtoupper($char);
		}
		$temp.=$char;
	}

	// A
	$temp=str_replace('á','Á',$temp);
	$temp=str_replace('à','À',$temp);
	$temp=str_replace('ả','Ả',$temp);
	$temp=str_replace('ã','Ã',$temp);
	$temp=str_replace('ạ','Ạ',$temp);

	// A8
	$temp=str_replace('ă','Ă',$temp);
	$temp=str_replace('ắ','Ắ',$temp);
	$temp=str_replace('ằ','Ằ',$temp);
	$temp=str_replace('ẳ','Ẳ',$temp);
	$temp=str_replace('ẵ','Ẵ',$temp);
	$temp=str_replace('ặ','Ặ',$temp);

	// A6
	$temp=str_replace('â','Â',$temp);
	$temp=str_replace('ấ','Ấ',$temp);
	$temp=str_replace('ầ','Ầ',$temp);
	$temp=str_replace('ẩ','Ẩ',$temp);
	$temp=str_replace('ẫ','Ẫ',$temp);
	$temp=str_replace('ậ','Ậ',$temp);

	// E
	$temp=str_replace('é','É',$temp);
	$temp=str_replace('è','È',$temp);
	$temp=str_replace('ẻ','Ẻ',$temp);
	$temp=str_replace('ẽ','Ẽ',$temp);
	$temp=str_replace('ẹ','Ẹ',$temp);

	// E6
	$temp=str_replace('ê','Ê',$temp);
	$temp=str_replace('ế','Ế',$temp);
	$temp=str_replace('ề','Ề',$temp);
	$temp=str_replace('ể','Ể',$temp);
	$temp=str_replace('ễ','Ễ',$temp);
	$temp=str_replace('ệ','Ệ',$temp);

	// I
	$temp=str_replace('í','Í',$temp);
	$temp=str_replace('ì','Ì',$temp);
	$temp=str_replace('ỉ','Ỉ',$temp);
	$temp=str_replace('ĩ','Ĩ',$temp);
	$temp=str_replace('ị','Ị',$temp);

	// O
	$temp=str_replace('ó','Ó',$temp);
	$temp=str_replace('ò','Ò',$temp);
	$temp=str_replace('ỏ','Ỏ',$temp);
	$temp=str_replace('õ','Õ',$temp);
	$temp=str_replace('ọ','Ọ',$temp);

	// O6
	$temp=str_replace('ô','Ô',$temp);
	$temp=str_replace('ố','Ố',$temp);
	$temp=str_replace('ồ','Ồ',$temp);
	$temp=str_replace('ổ','Ổ',$temp);
	$temp=str_replace('ỗ','Ỗ',$temp);
	$temp=str_replace('ộ','Ộ',$temp);

	// O7
	$temp=str_replace('ơ','Ơ',$temp);
	$temp=str_replace('ớ','Ớ',$temp);
	$temp=str_replace('ờ','Ờ',$temp);
	$temp=str_replace('ở','Ở',$temp);
	$temp=str_replace('ỡ','Ỡ',$temp);
	$temp=str_replace('ợ','Ợ',$temp);

	// U
	$temp=str_replace('ú','Ú',$temp);
	$temp=str_replace('ù','Ù',$temp);
	$temp=str_replace('ủ','Ủ',$temp);
	$temp=str_replace('ũ','Ũ',$temp);
	$temp=str_replace('ụ','Ụ',$temp);

	// U7
	$temp=str_replace('ư','Ư',$temp);
	$temp=str_replace('ứ','Ứ',$temp);
	$temp=str_replace('ừ','Ừ',$temp);
	$temp=str_replace('ử','Ử',$temp);
	$temp=str_replace('ữ','Ữ',$temp);
	$temp=str_replace('ự','Ự',$temp);

	// Y
	$temp=str_replace('ý','Ý',$temp);
	$temp=str_replace('ỳ','Ỳ',$temp);
	$temp=str_replace('ỷ','Ỷ',$temp);
	$temp=str_replace('ỹ','Ỹ',$temp);
	$temp=str_replace('ỵ','Ỵ',$temp);

	// D9
	$temp=str_replace('đ','Đ',$temp);

	return $temp;
}
// =============================================================================================
// Tao Trang Thong diep
// =============================================================================================
function ShowMessage($title,$intro,$message) {
	global $config;
	global $fReadFile;
	$templates_message = fReadFile('templates/'.$config["framestyle"].'/message.tpl');
	// Thay the TEMPLATES
	$temp=$templates_message;
	$temp=str_replace('{TITLE_PAGE}',$title,$temp);
	$temp=str_replace('{INTRO_PAGE}',$intro,$temp);
	$temp=str_replace('{MESSAGE}',$message,$temp);
	return $temp;
}
// =============================================================================================
// Tra ve Dung luong Size
// =============================================================================================
function GetStringSize($size) {
	$size=round($size/1024,2);
	if ($size>1024) {
		$size=round($size/1024,2).' MB';
	} else {
		$size=$size.' KB';
	}
	return $size;
}
// =============================================================================================
// Lay gia tri ID lon nhat
// =============================================================================================
function getIDMax($Field, $Table, $Cond) {
	global $dbi;
	$QueRy = "select max($Field) from $Table where 1";
	if($Cond != "")
		$QueRy .= $Cond;
	$ReSult =  sql_query($QueRy, $dbi);
	if($ReSult) {
		$Num = sql_num_rows($ReSult);
		if($Num > 0) {
			list($ID) = sql_fetch_row($ReSult, $dbi);
			return $ID;
		}
	}
	return 0;
}
// =============================================================================================
// Kiem tra Dieu kien
// =============================================================================================
function CheckCond($TableName,$strCond)
{
	global $dbi;
	$query="SELECT * FROM ".$TableName." WHERE 1 ".$strCond;
	$result=sql_query($query,$dbi);
	if($result)
	{
		$NumOfRows=sql_num_rows($result);
		if($NumOfRows>0) return true;
		else return false;
	}
	else die("Can not get data, please refresh!");
}
// =============================================================================================
// Lay so luong phan tu trong bang
// =============================================================================================
function getCountDB($Table, $cond) {
	global $dbi;
	$sql = "select count(*) as numrow from $Table where 1 $cond";
	$ret = sql_query($sql, $dbi);
	if($ret) {
		if($obj = sql_fetch_object($ret, 1)) {
			$count = $obj->numrow;
			return ($count=="") ? 0 : $count;
		}
	}
	return 0;
}
// =============================================================================================
// Lay so Tong gia tri mot phan tu trong bang
// =============================================================================================
function getSumDB($Field, $Table, $cond) {
	global $dbi;
	$sql = "select sum($Field) as total from $Table where 1 $cond";
	$ret = sql_query($sql, $dbi);
	if($ret) {
		if($obj = sql_fetch_object($ret, 1))
			$total = $obj->total;
			return ($total=="") ? 0 : $total;
	}
	return 0;
}// =============================================================================================
// Lay so luong phan tu trong bang
// =============================================================================================
function GetIDRoot($Table, $cond, $id) {
	global $dbi;
	$idparent=$id;
	while ($idparent!="0") {
		$id=$idparent;
		$sql = "SELECT * FROM ".$Table." WHERE 1 ".$cond." AND idpost='".$id."'";
		$ret = sql_query($sql, $dbi);
		if($ret) {
			if($obj = sql_fetch_object($ret, 1)) {
				$idparent = $obj->idparent;
			} else {
				$idparent=0;
			}
		}
	}
	return $id;
}
// =============================================================================================
// Doc file Template
// =============================================================================================
function fReadFile($filename) {
	if (file_exists($filename)) {
		$f=fopen($filename,"r");
		$List=fread($f,filesize($filename));
		fclose($f);
		return $List;
	}
	return '';
}
// =============================================================================================
// Kiem tra File da ton tai
// =============================================================================================
function CreateNewFilename($path,$filename) {
	$filename=strtolower(str_replace('"',"'",$filename));
	$path_parts=pathinfo($filename);
	$i=0;
	if (!file_exists($path.'/'.$filename)) return str_replace('"','',$filename);
	do {
		$i++;
		$temp=substr($path_parts["basename"],0,strrpos($path_parts["basename"],'.')).$i.'.'.$path_parts["extension"];
	} while (file_exists($path.'/'.$temp));
	return str_replace('"','',$temp);
}
// =============================================================================================
// Them mot amount Kytu truoc number
// =============================================================================================
function AddZero($number,$amount,$kytu) {
	$temp=$number;
	if (strlen($temp)<$amount) {
		for ($i=strlen($temp)+1;$i<=$amount;$i++) {
			$temp=$kytu.$temp;
		}
	}
	return $temp;
}
// =============================================================================================
// Convert So luong Page
// =============================================================================================
function convertnumpage($Total, $Each ) {
	$numpage = $Total/$Each;
	$CheckPage = $Total%$Each;
	if($CheckPage!=0)
	{
		$numpage = $numpage+1;
	}
	$numpage = intval ($numpage) ;
	
	return $numpage;
}
// =============================================================================================
// Lay ra number ky tu tu 1 Chuoi
// =============================================================================================
function TrimStringX($chuoi,$number) {
	
	$Temp=strip_tags($chuoi); //,'<p><br><b><i><u>');

	if (strlen($Temp)>$number) {
		$Temp=substr($Temp,0,$number);
		$post=strpos($Temp,' ');
		if ($post>0) {
			$i=$number;
			while ($Temp[strlen($Temp)-1]!=' ') {
				$Temp=substr($Temp,0,strlen($Temp)-1);
			}
		}
		$Temp.='...';
	}
	return $Temp;
}
// =============================================================================================
// Gui Email di
// =============================================================================================
function SendMailOut($fromto,$fromemail,$sendto,$subject,$emailintro,$content) {
	global $config;
	global $DOMAIN_NAME;
	global $PATH_UPLOAD;
	global $lang;
	global $param;
	global $email_name;

	$tmp = fReadFile(TEMPLATE_DIR.'/email.tpl');
	$tmp=str_replace("{theme}","http://".$DOMAIN_NAME."/".TEMPLATE_DIR."/",$tmp);
	$tmp=str_replace("{slogan}",$config["slogan"],$tmp);
	$tmp=str_replace("{siteintro}",$config["siteintro"],$tmp);
	$tmp=str_replace("{sitetitle}",$config["sitetitle"],$tmp);
	$tmp=str_replace("{copyright}",$config["copyright"],$tmp);
	$tmp=str_replace("{title}",$subject,$tmp);
	$tmp=str_replace("{text_emailintro}",$emailintro,$tmp);
	$tmp=str_replace("{content}",$content,$tmp);
	$datepost=str_replace("%1",date("H:i:s d/m/Y"),$lang["msg_sendemail"]);
	$tmp=str_replace("{sendemail}",$datepost,$tmp);
	$tmp=str_replace("{link}", "http://".$DOMAIN_NAME."/",$tmp);

	$to			= $sendto;
	$headers	= "From: ".$fromto." <".$fromemail.">\r\n" .
//				 "Cc: ".$fromemail."\r\n" .
				 "Content-type: text/html; charset=utf-8";
	$message=$tmp;
	
//	$result=SendMail($email_name,$to,$subject,$message,$config["sitetitle"]);
	$result=@mail($to, $subject, $message, $headers);
	return $result;
}
// =============================================================================================
// Tao chuoi bat ky
// =============================================================================================
function GetString($kytu,$number) {
	$temp='';
	for ($i=0;$i<=$number;$i++) {
		$temp.=$kytu;
	}
	return $temp;
}
// =============================================================================================
// Hien thi star Rating
// =============================================================================================
function ShowRating($idlink,$rating,$numrate) {
	$temp="";
	$i=1;
	if ($rating>=1) {
		for ($i=1;$i<=floor($rating);$i++) {
			$temp.='<a href="javascript:OpenRate(\''.$idlink.'\',\''.$i.'\')" title="Đạt '.round($rating,2).' điểm / '.$numrate.' lượt bình chọn"><img src="images/star_01.gif" border=0 width=11 height=11 onMouseOver="ChangeImage(this, star_over)" onMouseOut="ChangeImage(this, star_01_normal)"></a>';
		}
	}
	if ($rating - floor($rating) != 0) $temp.='<a href="javascript:OpenRate(\''.$idlink.'\',\''.$i.'\')"  title="Đạt '.round($rating,2).' điểm / '.$numrate.' lượt bình chọn"><img src="images/star_03.gif" border=0 width=11 height=11 onMouseOver="ChangeImage(this, star_over)" onMouseOut="ChangeImage(this, star_03_normal)"></a>';
	if ($rating<=4) {
		for ($i=ceil($rating)+1;$i<=5;$i++) {
			$temp.='<a href="javascript:OpenRate(\''.$idlink.'\',\''.$i.'\')"  title="Đạt '.round($rating,2).' điểm / '.$numrate.' lượt bình chọn"><img src="images/star_02.gif" border=0 width=11 height=11 onMouseOver="ChangeImage(this, star_over)" onMouseOut="ChangeImage(this, star_02_normal)"></a>';
		}
	}
	return $temp;
}
// =============================================================================================
// Chen Rating
// =============================================================================================
function ShowRatingPic($hostname,$rating,$numrate) {
	$temp="";
	$i=1;
	if ($rating>=1) {
		for ($i=1;$i<=floor($rating);$i++) {
			$temp.='<img src="'.$hostname.'images/star_01.gif" border=0 width=11 height=11 title="Đạt '.round($rating,2).' điểm / '.$numrate.' lượt bình chọn">';
		}
	}
	if ($rating - floor($rating) != 0) $temp.='<img src="'.$hostname.'images/star_03.gif" border=0 width=11 height=11 title="Đạt '.round($rating,2).' điểm / '.$numrate.' lượt bình chọn">';
	if ($rating<=4) {
		for ($i=ceil($rating)+1;$i<=5;$i++) {
			$temp.='<img src="'.$hostname.'images/star_02.gif" border=0 width=11 height=11 title="Đạt '.round($rating,2).' điểm / '.$numrate.' lượt bình chọn">';
		}
	}
	return $temp;
	//  onMouseOver="ChangeImage(this, star_over)" onMouseOut="ChangeImage(this, star_01_normal)"
}
// =============================================================================================
// Get Counter
// =============================================================================================
function getCounter($counter, $imgPath) {
	$temp="";
	for ($i=0;$i<strlen($counter);$i++) {
		$temp.='<img src="'.$imgPath.'/'.substr($counter,$i,1).'.gif" border="0">';
	}
	return $temp;
}
// =============================================================================================
// Write Logs
// =============================================================================================
function WriteLog($filename) {
	global $REMOTE_ADDR;
	$ip=$REMOTE_ADDR;
	$hostname=@gethostbyaddr($ip);
	$thoigian=date("d/m/y H:i:s");
	$noidung="[".$thoigian."] ".$ip.'	'.$hostname."\r\n";

	if (file_exists($filename)) {
		if (filesize($filename)>(20*1024)) {
			$path_parts = pathinfo($filename);
			$newfile=$path_parts["dirname"].'/'.substr($path_parts["basename"],0,strrpos($path_parts["basename"],'.')).'_'.date("Ymd").'.'.$path_parts["extension"];
			rename($filename,$newfile);
			$f = fopen ($filename, "w");
		} else {
			$f = fopen ($filename, "a+");
		}
	} else {
		$f = fopen($filename, "w");
	}
	fwrite ($f,$noidung);
	fclose ($f);
}
// =============================================================================================
// Trim Address
// =============================================================================================
function TrimAddress($address, $maxChar) {
	$temp=$address;
	if (strlen($temp)>$maxChar) {
		$temp=substr($temp,0,$maxChar-10).'..'.substr($temp,strlen($temp)-10,10);
	}
	return $temp;
}
// =============================================================================================
// Resize Image
// =============================================================================================
function ResizeRecImage($filename, $desc, $size) {
	global $quality;
	global $CONVERT_IS_GD2;

    if (function_exists("imagecreatetruecolor")) {
		if (!file_exists($filename)) {
			return "Not found ".$filename;
		} else {

			$imagetype=array(0 => "jpeg", 1 => "gif", 2 => "jpeg", 3 => "png");
			$imageinfo=getimagesize($filename);
			$width=$imageinfo[0];
			$height=$imageinfo[1];
			if ($width==0) $width=1;
			if ($height==0) $height=1;
			if ($width>$height) {
				$newheight=$height;
				$newwidth =$height;
			} else {
				$newheight=$width;
				$newwidth =$width;
			}
			// Load
			if ($CONVERT_IS_GD2) {
				$thumb = imagecreatetruecolor($size, $size);
			} else {
				$thumb = imagecreate($size, $size);
			}
			$background = imagecolorallocate($thumb, 255, 255, 255);
			$create_handle = "imagecreatefrom".$imagetype[$imageinfo[2]];
			$image_handle = "image".$imagetype[$imageinfo[2]];
			$source = $create_handle($filename);
			// Resize
			if ($CONVERT_IS_GD2) {
				imagecopyresampled($thumb, $source, 0, 0, round(($width-$newwidth)/2), round(($height-$newheight)/2), $size, $size, $newwidth, $newheight);
			} else {
				imagecopyresized($thumb, $source, 0, 0, round(($width-$newwidth)/2), round(($height-$newheight)/2), $size, $size, $newwidth, $newheight);
			}
			imageinterlace($thumb,1);
			$image_handle($thumb, $desc, $quality);
			imagedestroy ($thumb);
			imagedestroy ($source);
			return true;
		}
	} else {
		return "Not support";
	}
}
function ResizeImage($filename, $desc, $size) {
	global $quality;
	global $CONVERT_IS_GD2;

    if (function_exists("imagecreatefromjpeg") and function_exists("imagecreatetruecolor")) {
		if (!file_exists($filename)) {
			return "Not found ".$filename;
		} else {

			$imagetype=array(0 => "jpeg", 1 => "gif", 2 => "jpeg", 3 => "png");
			$imageinfo=getimagesize($filename);
			$width=$imageinfo[0];
			$height=$imageinfo[1];
			if ($width==0) $width=1;
			if ($height==0) $height=1;
			if ($width>$height) {
				$newheight=round($size*$height/$width);
				$newwidth=$size;
			} else {
				$newwidth=round($size*$width/$height);
				$newheight=$size;
			}
			// Load
			if ($CONVERT_IS_GD2) {
				$thumb = imagecreatetruecolor($newwidth, $newheight);
			} else {
				$thumb = imagecreate($newwidth, $newheight);
			}
			$create_handle = "imagecreatefrom".$imagetype[$imageinfo[2]];
			$image_handle = "image".$imagetype[$imageinfo[2]];
			$source = $create_handle($filename);
			// Resize
			if ($CONVERT_IS_GD2) {
				imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			} else {
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			}
			imageinterlace($thumb,1);
			if (function_exists("imagegif")) {
				$image_handle($thumb, $desc);
			} elseif (function_exists("imagejpeg")) {
				$image_handle($thumb, $desc, $quality);
			} elseif (function_exists("imagepng")) {
				$image_handle($thumb, $desc);
			} elseif (function_exists("imagewbmp")) {
				$image_handle($thumb, $desc);
			} else {
				 die("No image support in this PHP server");
			}
//			$image_handle($thumb, $desc, $quality);
			imagedestroy ($thumb);
			imagedestroy ($source);

			return true;
		}
	} else {
		return "Not support";
	}
}
function urlencodeFlash($url) {
	$url=str_replace("/","%2F",$url);
	$url=str_replace("?","%3F",$url);
	$url=str_replace("&","%26",$url);
	$url=str_replace(" ","%20",$url);
	return $url;
}
// =============================================================================================
// Hien thi Page Navigation
// =============================================================================================
function ShowPageNav($page, $count, $total, $length, $tempname, $stamplink) {
	global $template;
	global $lang;
	if ($total>$count) {
		$template->assign_block_vars($tempname, array(
			'text_gopage' => $lang["gopage"]
		));
		$numpage = ceil($total/$count);
		for ($i=0;$i<$numpage;$i++) {
			$selected="";
			if ($page==$i) $selected=" selected";
			$template->assign_block_vars($tempname.".optionpage", array(
				'value' => str_replace("{page}",$i,$stamplink),
				'text' => ($i+1),
				'selected' => $selected
			));
		}
		// Page
		if ($page > 0) {
			$template->assign_block_vars($tempname.'.page', array(
				'link' => str_replace("{page}",($page-1),$stamplink),
				'text' => $lang["prevpage"]
			));
		}
		if ($page-2 > 0) {
			$template->assign_block_vars($tempname.'.page', array(
				'link' => str_replace("{page}",0,$stamplink),
				'text' => "1 ..."
			));
			$template->assign_block_vars($tempname.'.page.line', array(
			));
		}
		for ($i=$page-$length;$i<=$page+$length;$i++) {
			if ($i>=0 && $i<$numpage) {
				if ($i == $page) {
					$template->assign_block_vars($tempname.'.page', array(
						'link' => str_replace("{page}",$i,$stamplink),
						'text' => '<b class="pagered">'.($i+1).'</b>'
					));
					if ($page > 0 || $i > 0 )
						$template->assign_block_vars($tempname.'.page.line', array(
						));
				} else {
					$template->assign_block_vars($tempname.'.page', array(
						'link' => str_replace("{page}",$i,$stamplink),
						'text' => ($i+1)
					));
					if ($page > 0 || $i > 0) 
						$template->assign_block_vars($tempname.'.page.line', array(
						));
				}
			}
		}
		if ($page+2 < $numpage-1) {
			$template->assign_block_vars($tempname.'.page', array(
				'link' => str_replace("{page}",($numpage-1),$stamplink),
				'text' => "... ".$numpage
			));
			$template->assign_block_vars($tempname.'.page.line', array(
			));
		}
		if ($page < $numpage-1) {
			$template->assign_block_vars($tempname.'.page', array(
				'link' => str_replace("{page}",($page+1),$stamplink),
				'text' => $lang["nextpage"]
			));
			$template->assign_block_vars($tempname.'.page.line', array(
			));
		}
	}
}
function alert($str) {
	echo '<script language="javascript">alert("'.str_replace('"','\"',$str).'");</script>';
}
// =============================================================================================
// Get Parent Step
// =============================================================================================
function getParentStep($idpost) {
	global $dbi;
	global $db_prefix;

	$step = 0;
	$idparent = $idpost;
	while ($idparent!=0) {
		$idparent = SelectValue("idparent", $db_prefix."posts", " AND idpost='".$idparent."'");
		$step++;
	}
	return $step;
}
// =============================================================================================
// Get M2Portal Link
// =============================================================================================
function getLocation($str) {
	global $param;
	$link  = "";
	$link .= ($param["module"]!="" && strpos($str, "&m=")===false) ? "&m=".$param["module"] : "";
	$link .= ($param["file"]!="" && strpos($str, "&f=")===false) ? "&f=".$param["file"] : "";
	$link .= ($param["type"]!="" && strpos($str, "&t=")===false) ? "&t=".$param["type"] : "";
	$link .= ($param["order"]!="" && strpos($str, "&or=")===false) ? "&or=".$param["order"] : "";
	$link .= ($param["status"]!="" && strpos($str, "&st=")===false) ? "&st=".$param["status"] : "";
	$link .= ($param["keyword"]!="" && strpos($str, "&k=")===false) ? "&k=".urlencode($param["keyword"]) : "";
	$link .= ($param["page"]!="" && strpos($str, "&p=")===false) ? "&p=".$param["page"] : "";
	$link .= ($str!="") ? $str : "";
	$link  = MAINFILE.(($link!="") ? "?".substr($link,1,strlen($link)-1) : "");
	return $link;
}
?>