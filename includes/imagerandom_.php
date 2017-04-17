<?php
	session_start();
	$numchar=6;
	$font=5; //imageloadfont("hootie.gdf");
	$x=8;
	$y=2;

	$imagewidth  = imagefontwidth($font)*$numchar  + 2*$x;
	$imageheight = imagefontheight($font) + 2*$y;
	
	$im = imagecreate($imagewidth, $imageheight);

	$background_color = imagecolorallocate($im, 255, 255, 255);
	$text_color = imagecolorallocate($im, 0, 0, 0);
	$line_color = imagecolorallocate($im, 192, 192, 192);

	for ($i=0;$i<ceil(($imagewidth+$imageheight)/5);$i++) {
		imageline($im, $i*5-$imageheight, 0, $i*5, $imageheight, $line_color);
		imageline($im, $i*5-$imageheight, $imageheight, $i*5, 0, $line_color);
	}

	$strtext="ABCDEFGHIJKLMNOPQRSTUVWXYZ"; //."abcdefghijklmnopqrstuvwxyz0123456789";
	$text="";
	for ($i=0;$i<$numchar;$i++) $text.=substr($strtext, rand(0,strlen($strtext)-1), 1);
//	$text=rand(pow(10, $numchar-1),pow(10, $numchar)-1);
	$_SESSION["imagerandom"]=$text;

	imagestring($im, $font, $x, $y, $text, $text_color);	
	Header("Content-type: image/jpeg");
	Header("Content-Disposition: inline; filename=imagerandom.gif");
	imagejpeg($im);
	imagedestroy($im);
?>
