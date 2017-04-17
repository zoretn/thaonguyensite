<?php
// $Id: config.inc.php, v 1.1 2005/01/11 16:02:24 bpfeifer Exp $
/**
* TMedit InsertFile
* @ package TMedit
* @ Copyright © 2004, 2005 Bernhard Pfeifer - www.thinkmambo.com
* @ All rights reserved
* @ Released under ThinkMambo Free Software License: http://www.thinkmambo.com/license/TMEdit_license.txt
* @ version $Revision: 1.1 $
**/


require_once( "../../../../../includes/mambo.php" );
global $database,$mosConfig_live_site;

$database = new database( $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix );
$database->setQuery( "SELECT id FROM #__mambots WHERE element = 'tmedit' AND folder = 'editors'" );
$id = $database->loadResult();
$mambot = new mosMambot( $database );
$mambot->load( $id );
$params =& new mosParameters( $mambot->params );

$MY_DOCUMENT_ROOT 		= $_SERVER['DOCUMENT_ROOT']."/images/stories";	// if you are using Docman change this to '/dmdocuments';
$MY_BASE_URL 			= '/images/stories';	// if you are using Docman change this to '/dmdocuments';
$MY_ALLOW_EXTENSIONS	= array('html', 'doc', 'xls', 'txt', 'gif', 'pdf', 'gz', 'tar', 'zip', 'rar', 'bzip', 'sql', 'swf', 'mov', 'jpeg', 'jpg', 'png'); //add file types here, e. g. 'gif', 'jpeg', 'jpg', 'png', 'pdf'
$MY_DENY_EXTENSIONS		= array('php', 'php3', 'php4', 'phtml', 'shtml', 'cgi', 'pl'); //add file types here
$MY_LIST_EXTENSIONS		= array('html', 'doc', 'xls', 'txt', 'pdf', 'gz', 'tar', 'zip', 'rar', 'sql', 'swf', 'mov', 'gif', 'jpeg', 'jpg', 'png');	//add file types here
$MY_ALLOW_DELETE_FILE 	= true;	// set to false if file deleting should be disabled
$MY_ALLOW_UPLOAD_FILE 	= true;	// set to false if file uploads should be disabled
$MY_ALLOW_DELETE_FOLDER = true;	// set to false if directory deleting should be disabled
$MY_ALLOW_CREATE_FOLDER = true;	// set to false if directory creation should be disabled
$MY_MAX_FILE_SIZE 		= 2*1024*1024;
$MY_LANG 				= 'en';	// change this to 'de'; for german language
$MY_DATETIME_FORMAT		= "d.m.Y H:i";	// set your date and time format
$MY_LANG 				= $params->get( 'language', 'en' );

// DO NOT EDIT BELOW
$MY_NAME = 'insertfiledialog';

$lang_file = 'lang/lang-'.$MY_LANG.'.php';
if (is_file('lang/lang-'.$MY_LANG.'.php')) {
	require($lang_file);
} else {
	require('lang/lang-en.php');
}
$MY_PATH = '/';
$MY_UP_PATH = '/';