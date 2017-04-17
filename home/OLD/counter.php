<?php
$textcounter=0;
$handle=fopen("counter.dat","rb");	
$textcounter=fgets($handle);
if (!isset($_SESSION['count'])) {
	$textcounter=$textcounter+1;
	fclose($handle);
	$handle=fopen("counter.dat","wb");	
	fwrite($handle,$textcounter);
	$_SESSION['count'] = $textcounter;
}
fclose($handle);
?>