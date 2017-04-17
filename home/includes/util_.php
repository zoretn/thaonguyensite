<?php
function get_param($param_name)
{
	global $_POST;
	global $_GET;
	global $_ENV;
	global $_SERVER;

	$param_value = "";
	if(isset($_SERVER[$param_name])) $param_value = $_SERVER[$param_name];
	else if(isset($_ENV[$param_name])) $param_value = $_ENV[$param_name];
	else if(isset($_POST[$param_name])) $param_value = $_POST[$param_name];
	else if(isset($_GET[$param_name])) $param_value = $_GET[$param_name];
	$param_value=str_replace("'","&#39",$param_value);
	$param_value=str_replace('"','"',$param_value);
	return $param_value;
}
function get_Aparam($param_name){
	global $_POST;
	global $_GET;

	$param_value = "";
	if(isset($_POST[$param_name])) $param_value = $_POST[$param_name];
	else if(isset($_GET[$param_name])) $param_value = $_GET[$param_name];
	return $param_value;
}
function get_Pparam($param_name)
{
	global $_POST;

	$param_value = "";
	if(isset($_POST[$param_name])) $param_value = $_POST[$param_name];
	$param_value=str_replace("'","&#39",$param_value);
	return $param_value;
}
function get_Fparam($param_name)
{
	global $_FILES;

	$param_value = "";
	if(isset($_FILES[$param_name])) $param_value = $_FILES[$param_name];
	return $param_value;
}
function get_Cparam($param_name)
{
	global $_COOKIE;

	$param_value = "";
	if(isset($_COOKIE[$param_name])) $param_value = $_COOKIE[$param_name];
	return $param_value;
}
function get_session($param_name) {
	global $_SESSION;
	$param_value = "";
	if(isset($_SESSION[$param_name]) && session_is_registered($param_name)) 
		$param_value = $_SESSION[$param_name];
	return $param_value;
}

function set_session($param_name, $param_value) {
	global ${$param_name};
	if(session_is_registered($param_name)) 
		session_unregister($param_name);
	${$param_name} = $param_value;
	session_register($param_name);
}
function save_session($array2save)
{
	global $sid;
	$temporary_directory=session_save_path();
	$content = ~serialize($array2save);

	if(!is_writable($temporary_directory)) die("<h3>The folder \"$temporary_directory\" do not exists or the webserver don't have permissions to write</h3>");

	$sessiondir = $temporary_directory;
	if(!file_exists($sessiondir)) mkdir($sessiondir,0777);
	$f = fopen("$sessiondir/$sid.usf","wb+") or die("<h3>Could not open session file</h3>");
	fwrite($f,$content);
	fclose($f);

	return 1;
}
function load_session()
{
	global $sid;
	$temporary_directory=session_save_path();
	$sessionfile = $temporary_directory."/$sid.usf";
	$result      = Array();
	if(file_exists($sessionfile))
	{
		$result = file($sessionfile);
		$result = join("",$result);
		$result = unserialize(~$result);
	}
	return $result;
}
function delete_session_saved()
{
	global $sid;
	$temporary_directory=session_save_path();
	$sessionfile = $temporary_directory."/$sid.usf";
	return @unlink($sessionfile);
}
function delete_session($param_name)
{
	session_start();
	session_unregister($param_name);
}
function destroy_session()
{
	session_start();
	session_destroy();
}
function html_output($Html)
{
//	echo stripslashes($Html) ; 
	echo $Html; 
}
?>