<?php 
define( "_VALID_MOS", 1 );
define ('_ALLOW',1);
$base_path = "../../../../..";
	include_once("../../../../configimage.php");
	global $cfg_rootpath;
	include_once 'config.inc.php';
	
	if(isset($_GET['dir'])) {
		$dirParam = $_GET['dir'];
	
		if(strlen($dirParam) > 0) 
		{
			if(substr($dirParam,0,1)=='/') 
				$IMG_ROOT .= $dirParam;		
			else
				$IMG_ROOT = $dirParam;			
		}	
	
	}
	function do_upload($file, $dest_dir) 
	{
		global $clearUploads;
	
		if(is_file($file['tmp_name'])) 
		{
			//var_dump($file); echo "DIR:$dest_dir";
			move_uploaded_file($file['tmp_name'], $dest_dir.$file['name']);	
			chmod($dest_dir.$file['name'], 0666);
		}
		?>
		<script language="javascript">
		parent.document.form1.dirCreate.value="";
		parent.document.form1.upload.value="";
		</script>
		<?php
//		$clearUploads = true;
	}
	function createFolder ($dir, $dest_dir) {
		global $refresh_dirs;
		global $clearUploads;
		if (!is_dir($dest_dir.$dir)) {
			mkdir($dest_dir.$dir);
			chmod($dest_dir.$dir,0755);
//			chmod($dest_dir.$dir,0700);
		}
		$dirPathPost = $_POST['dirPath'];
		if (strlen($dirPathPost)==1)
			$newselect = $dirPathPost.$dir;
		else
			$newselect = $dirPathPost."/".$dir;
	?>
		<script language="javascript">
			var lengthselect = parent.document.form1.dirPath.length;
			parent.document.form1.dirPath[lengthselect] = new Option("<?php echo $newselect; ?>","<?php echo $newselect; ?>");
			parent.document.form1.dirCreate.value="";
			parent.document.form1.upload.value="";
		</script>
	<?php
		$clearUploads=true;
//		$refresh_dirs = true;
	}
	
	function delete_file($file) 
	{
		global $BASE_DIR;
		
		$del_image = dir_name($BASE_DIR).$file;
	
		$del_thumb = dir_name($del_image).'.'.basename($del_image);
	
		if(is_file($del_image)) {
			unlink($del_image);	
		}
	
		if(is_file($del_thumb)) {
			unlink($del_thumb);	
		}
	}

	$refresh_dirs = false;
	$clearUploads = false;
	
	if(strrpos($IMG_ROOT, '/')!= strlen($IMG_ROOT)-1) 
		$IMG_ROOT .= '/';
	
	if(isset($_GET['delFile']) && isset($_GET['dir'])) 
	{
		delete_file($_GET['delFile']);	
	}
	$backupIMG_ROOT = $IMG_ROOT;
	if(isset($_FILES['upload']) && is_array($_FILES['upload']) && isset($_POST['dirPath'])) 
	{
	
		$dirPathPost = $_POST['dirPath'];
	
		if(strlen($dirPathPost) > 0) 
		{
			if(substr($dirPathPost,0,1)=='/') 
				$IMG_ROOT .= $dirPathPost;		
			else
				$IMG_ROOT = $dirPathPost;			
		}
	
		if(strrpos($IMG_ROOT, '/')!= strlen($IMG_ROOT)-1) 
			$IMG_ROOT .= '/';
	
		do_upload($_FILES['upload'], $BASE_DIR.$BASE_ROOT.$dirPathPost.'/');
	}
	// Tao Folder
	if(isset($_POST['dirCreate']) && isset($_POST['dirPath'])) 
	{
	
		$dirPathPost = $_POST['dirPath'];
		$dirCreate = $_POST['dirCreate'];
		
		$IMG_ROOT = $backupIMG_ROOT;
		if(strlen($dirPathPost) > 0) 
		{		
			if(substr($dirPathPost,0,1)=='/') 
				$IMG_ROOT .= $dirPathPost;		
			else			
				$IMG_ROOT = $dirPathPost;			
		}
	
		if(strrpos($IMG_ROOT, '/')!= strlen($IMG_ROOT)-1) 
			$IMG_ROOT .= '/';
	
		createFolder($dirCreate, $BASE_DIR.$BASE_ROOT.$dirPathPost.'/');
	}
	
	function num_files($dir) 
	{
		$total = 0;
	
		if(is_dir($dir)) 
		{
			$d = @dir($dir);
	
			while (false !== ($entry = $d->read())) 
			{
				//echo $entry."<br>";
				if(substr($entry,0,1) != '.') {
					$total++;
				}
			}
			$d->close();
		}
		return $total;
	}
	
	function dirs($dir,$abs_path) 
	{
		$d = dir($dir);
			//echo "Handle: ".$d->handle."<br>\n";
			//echo "Path: ".$d->path."<br>\n";
			$dirs = array();
			while (false !== ($entry = $d->read())) {
				if(is_dir($dir.'/'.$entry) && substr($entry,0,1) != '.') 
				{
					//dirs($dir.'/'.$entry, $prefix.$prefix);
					//echo $prefix.$entry."<br>\n";
					$path['path'] = $dir.'/'.$entry;
					$path['name'] = $entry;
					$dirs[$entry] = $path;
				}
			}
			$d->close();
		
			ksort($dirs);
			for($i=0; $i<count($dirs); $i++) 
			{
				$name = key($dirs);
				$current_dir = $abs_path.'/'.$dirs[$name]['name'];
				echo ", \"$current_dir\"\n";
				dirs($dirs[$name]['path'],$current_dir);
				next($dirs);
			}
	}
	
	function parse_size($size) 
	{
		if($size < 1024) 
			return $size.' Bytes';	
		else if($size >= 1024 && $size < 1024*1024) 
		{
			return sprintf('%01.2f',$size/1024.0).' KB';	
		}
		else
		{
			return sprintf('%01.2f',$size/(1024.0*1024)).' MB';	
		}
	}
	
	function show_image($img, $file, $info, $size, $ext) 
	{
		global $BASE_DIR, $BASE_URL, $newPath;
	
		$img_path = dir_name($img);
		$img_file = basename($img);
	
		$img_url = $BASE_URL.$img_path.'/'.$img_file;
	
		$filesize = parse_size($size);
		$imgext = array("DOC"=>"doc_16.png","XLS"=>"xls_16.png","RAR"=>"rar_small.gif","PDF"=>"pdf_16.png","PPT"=>"ppt_small.gif","ZIP"=>"rar_small.gif","SWF"=>"swf_16.png","MOV"=>"mov_small.gif","WMA"=>"wmedia_small.jpg","WMV"=>"wmedia_small.jpg");
		$flag = 0;
		foreach ($imgext as $key=>$value) {
			if ($key == $ext) {
				$flag = 1;
				break;
			}
		}
		if ($flag == 0)
			$imgext[$ext] = "other_small.jpg";
	
	?>
	<td valign="top" bgcolor="#CCCCCC">
	<table width="102" border="0" cellpadding="0" cellspacing="2">
	  <tr> 
	    <td align="center" class="imgBorder" onMouseOver="pviiClassNew(this,'imgBorderHover')" onMouseOut="pviiClassNew(this,'imgBorder')">
		<a href="javascript:;" onClick="javascript:imageSelected('<?php echo $img_url; ?>', <?php echo $info[0];?>, <?php echo $info[1]; ?>,'<?php echo $file; ?>');">
		<img src="<?php if ($info[0] > 0) echo $img_url; else echo $imgext[$ext]; ?>" <?php if ($info[0] > $info[1]) echo " width='90'"; else echo " height='90'"; ?> alt="<?php echo $file; ?> - <?php echo $filesize; ?>" border="0">
		</a></td>
	  </tr>
	  <tr>
	  <td align="center" style="font-size:11px;"><?php echo $info[0] . " x " . $info[1];  ?></td>
	  </tr>
	  <tr> 
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
	        <tr>
	          <td width="1%" valign="top"><a href="images.php?delFile=<?php echo $img_url; ?>&dir=<?php echo $newPath; ?>" onClick="return deleteImage('<?php echo $file; ?>');"><img src="edit_trash.gif" width="15" height="15" border="0"></a></td>
	          <td width="98%" class="info" style="font-size:11px;"><?php echo $file; ?></td>
	        </tr>
	      </table></td>
	  </tr>
	</table>
	</td>
	<?php
	}
	
	function show_dir($path, $dir) 
	{
		global $newPath, $BASE_DIR, $BASE_URL;
	
		$num_files = num_files($BASE_DIR.$path);
	?>
	<td>
	<table width="102" border="0" cellpadding="0" cellspacing="2">
	  <tr> 
	    <td align="center" class="imgBorder" onMouseOver="pviiClassNew(this,'imgBorderHover')" onMouseOut="pviiClassNew(this,'imgBorder')">
		<?php
			$path = str_replace("//","/",$path);
		?>
		  <a href="images.php?dir=<?php echo $path; ?>" onClick="changeLoadingStatus('load')">
		  <?php
			  	if ($dir != 'banner')
			  	{
		  ?>
			<img src="folder.gif" width="75" height="75" border=0 alt="<?php echo $dir; ?>">
		<?php
				} else {
		?>
			<img src="bannerfolder.gif" width="75" height="75" border=0 alt="<?php echo $dir; ?>">
		<?php
			}
		?>
		  </a>
		</td>
	  </tr>
	  <tr> 
	    <td><table width="100%" border="0" cellspacing="1" cellpadding="2">
	        <tr> 
	          <td width="99%" class="info"><?php echo $dir; ?></td>
	        </tr>
	      </table></td>
	  </tr>
	</table>
	</td>
	<?php	
	}
	
	function draw_no_results() 
	{
	?>
	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
	    <td><div align="center" style="font-size:large;font-weight:bold;color:#CCCCCC;font-family: Helvetica, sans-serif;">No files</div></td>
	  </tr>
	</table>
	<?php	
	}
	
	function draw_no_dir() 
	{
		global $BASE_DIR, $BASE_ROOT;
	?>
	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
	    <td><div align="center" style="font-size:small;font-weight:bold;color:#CC0000;font-family: Helvetica, sans-serif;">Configuration problem: &quot;<?php echo $BASE_DIR.$BASE_ROOT; ?>&quot; does not exist.</div></td>
	  </tr>
	</table>
	<?php	
	}
	
	
	function draw_table_header() 
	{
		echo '<table border="0" cellpadding="0" cellspacing="2">';
		echo '<tr>';
	}
	
	function draw_table_footer() 
	{
		echo '</tr>';
		echo '</table>';
	}
	
	?>
	<html>
	<head>
	<title>Image Browser</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<style type="text/css">
	<!--
	.imgBorder {
		height: 96px;
		border: 1px solid threedface;
		vertical-align: middle;
	}
	.imgBorderHover {
		height: 96px;
		border: 1px solid threedshadow;
		vertical-align: middle;
		background: #EEE;
		cursor: hand;
	}
	
	.buttonHover {
		border: 1px solid;
		border-color: ButtonHighlight ButtonShadow ButtonShadow ButtonHighlight;
		cursor: hand;
		background: #EEE;
	}
	.buttonOut
	{
	 border: 1px solid;
	 border-color: white;
	}
	
	.imgCaption {
		font-size: 10pt;
		font-family: Arial, Helvetica, sans-serif;
		text-align: center;
	}
	.dirField {
		font-size: 10pt;
		font-family: Arial, Helvetica, sans-serif;
		width:110px;
	}
	
	.info {
		font-size: 8.5pt;
		font-family: Arial, Helvetica, sans-serif;
		text-align: center;
	}
		
	
	-->
	</style>
	<?php
		$dirPath = eregi_replace($BASE_ROOT,'',$IMG_ROOT);
	
		$paths = explode('/', $dirPath);
		$upDirPath = '/';
		for($i=0; $i<count($paths)-2; $i++) 
		{
			$path = $paths[$i];
			if(strlen($path) > 0) 
			{
				$upDirPath .= $path.'/';
			}
		}
	
		$slashIndex = strlen($dirPath);
		$newPath = $dirPath;
		if($slashIndex > 1 && substr($dirPath, $slashIndex-1, $slashIndex) == '/')
		{
			$newPath = substr($dirPath, 0,$slashIndex-1);
		}
	?>
	<script type="text/javascript" src="../popup.js"></script>
	<script type="text/javascript" src="../../dialog.js"></script>
	<script language="JavaScript" type="text/JavaScript">
	<!--
	function pviiClassNew(obj, new_style) { //v2.6 by PVII
	  obj.className=new_style;
	}
	
	function goUp() 
	{
		location.href = "ImageManager/images.php?dir=<?php echo $upDirPath; ?>";
	}
	
	function changeDir(newDir) 
	{
		location.href = "ImageManager/images.php?dir="+newDir;
	}
	
	function updateDir() 
	{
		var newPath = "<?php echo $newPath; ?>";
		if(window.top.document.forms[0] != null) {
			
		var allPaths = window.top.document.forms[0].dirPath.options;
		for(i=0; i<allPaths.length; i++) 
		{
			//alert(allPaths.item(i).value);
			allPaths.item(i).selected = false;
			if((allPaths.item(i).value)==newPath) 
			{
				allPaths.item(i).selected = true;
			}
		}
	
		}
	
	}
	
	<?php if ($clearUploads) { ?>
	parent.document.form1.upload.value="";
	<?php } ?>
	
	<?php if ($refresh_dirs) { ?>
	function refreshDirs() 
	{
		var allPaths = window.top.document.forms[0].dirPath.options;
		var fields = ["/" <?php dirs($BASE_DIR.$BASE_ROOT,'');?>];
	

		var newPath = "<?php echo $dirPathPost; ?>";
	
		while(allPaths.length > 0) 
		{
			for(i=0; i<allPaths.length; i++) 
			{
				allPaths[i]=null;
			}		
		}
	
		for(i=0; i<fields.length; i++) 
		{
			var newElem =	document.createElement("OPTION");
			var newValue = fields[i];
			newElem.text = newValue;
			newElem.value = newValue;
	
			if(newValue == newPath) 
				newElem.selected = true;
			else
				newElem.selected = false;
	
			allPaths.add(newElem);
		}
	}
	refreshDirs();
	<?php } ?>
	
	function imageSelected(filename, width, height, alt) 
	{
		var topDoc = window.top.document.forms[0];
		topDoc.f_url.value = filename;
	}
	
	function deleteImage(file) 
	{
		if(confirm("Delete image \""+file+"\"?")) 
			return true;
	
		return false;
	}
	
	function deleteFolder(folder, numFiles) 
	{
		if(numFiles > 0) {
			alert("There are "+numFiles+" files/folders in \""+folder+"\".\n\nPlease delete all files/folder in \""+folder+"\" first.");
			return false;
		}
	
		if(confirm("Delete folder \""+folder+"\"?")) 
			return true;
	
		return false;
	}
	
	function MM_findObj(n, d) { //v4.01
	  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
	    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
	  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
	  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
	  if(!x && d.getElementById) x=d.getElementById(n); return x;
	}
	
	function MM_showHideLayers() { //v6.0
	  var i,p,v,obj,args=MM_showHideLayers.arguments;
	  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i],window.top.document))!=null) { v=args[i+2];
	    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
	    obj.visibility=v; }
	}
	
	function changeLoadingStatus(state) 
	{
		var statusText = null;
		if(state == 'load') {
			statusText = 'Loading images...';	
		}
		else if(state == 'upload') {
			statusText = 'Uploading images...';
		}
		if(statusText != null) {
			var obj = MM_findObj('loadingStatus', window.top.document);
			//alert(obj.innerHTML);
			if (obj != null && obj.innerHTML != null)
				obj.innerHTML = statusText;
			MM_showHideLayers('loading','','show')		
		}
	}
	
	//-->
	</script>
	</head>
	<body onLoad="updateDir();" bgcolor="#FFFFFF">
	
	<?php
	//var_dump($_GET);
	//echo $dirParam.':'.$upDirPath;
	//echo '<br>';
	$d = @dir($BASE_DIR.$IMG_ROOT);
	
	if($d) 
	{
		//var_dump($d);
		$images = array();
		$folders = array();
		while (false !== ($entry = $d->read())) 
		{
			$img_file = $IMG_ROOT.$entry; 
	
			if(is_file($BASE_DIR.$img_file) && substr($entry,0,1) != '.') 
			{
				$file_details['file'] = $img_file;
				$file_details['size'] = filesize($BASE_DIR.$img_file);
				$file_details['img_info'] = array(0,0);
				$ext = substr($img_file,-3,3);
				$file_details['ext'] = strtoupper($ext);
				$image_info = @getimagesize($BASE_DIR.$img_file);
				if(is_array($image_info)) 
				{
//					$file_details['file'] = $img_file;
					$file_details['img_info'] = $image_info;
//					$file_details['size'] = filesize($BASE_DIR.$img_file);
//					$images[$entry] = $file_details;
					//show_image($img_file, $entry, $image_info);
				}
				$images[$entry] = $file_details;
			}
			else if(is_dir($BASE_DIR.$img_file) && substr($entry,0,1) != '.') 
			{
				$folders[$entry] = $img_file;
				//show_dir($img_file, $entry);	
			}
		}
		$d->close();	
		
		if(count($images) > 0 || count($folders) > 0) 
		{	
			//now sort the folders and images by name.
			ksort($images);
			ksort($folders);
	
			draw_table_header();
	
			for($i=0; $i<count($folders); $i++) 
			{
				$folder_name = key($folders);		
				show_dir($folders[$folder_name], $folder_name);
				next($folders);
			}
			for($i=0; $i<count($images); $i++) 
			{
				$image_name = key($images);
				show_image($images[$image_name]['file'], $image_name, $images[$image_name]['img_info'], $images[$image_name]['size'], $images[$image_name]['ext']);
				next($images);
			}
			draw_table_footer();
		}
		else
		{
			draw_no_results();
		}
	}
	else
		draw_no_dir();
	?>
	<script language="JavaScript" type="text/JavaScript">
	MM_showHideLayers('loading','','hide');
	</script>
	</body>
	</html>