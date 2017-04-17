<?php 
if (eregi("sql_layer.php",get_param("PHP_SELF")))
{
	Header("Location: ../index.php");
	die();
} 
/* $dbtype = "MySQL"; */ 
/* $dbtype = "mSQL"; */
/* $dbtype = "PostgreSQL"; */ 
/* $dbtype = "PostgreSQL_local";// When postmaster start without "-i" option. */ /* $dbtype = "ODBC"; */
/* $dbtype = "ODBC_Adabas"; */
/* $dbtype = "Interbase"; */
/* $dbtype = "Sybase"; */
/*
contents : 

1. function sql_connect($host,$user,$password,$db);
2. function sql_logout($id);
3. function sql_query($query,$id);
4. function sql_num_rows($res);
5. function sql_fetch_row($res,$nr);
6. function sql_fetch_array($res,$nr);
7. function SQL_fetch_object($res, $nr);
8. function sql_free_result($result);
9. function sql_query_limit($query,$idConnect,$idStart,$NumRow);
*/
//1. function sql_connect($host,$user,$password,$db);
function sql_connect($host,$user,$password,$db)
{
	global $dbtype;
	switch ($dbtype)
	{
		case "MySQL":
			$dbi=@mysql_connect($host, $user, $password);
			mysql_select_db($db);
			return $dbi;
			break;;
		case "mSQL":
			$dbi=msql_connect($host);
			msql_select_db($db);
			return $dbi;
			break;;
		case "PostgreSQL":
			$dbi=@pg_connect("host=$host user=$user password=$password port=5432 dbname=$db");
			return $dbi;
			break;;
		case "PostgreSQL_local":
			$dbi=@pg_connect("user=$user password=$password dbname=$db");
			return $dbi;
			break;;
		case "ODBC":
			$dbi=@odbc_connect($db,$user,$password);
			return $dbi;
			break;;
		case "ODBC_Adabas":
			$dbi=@odbc_connect($host.":".$db,$user,$password);
			return $dbi;
			break;;
		case "Interbase":
			$dbi=@ibase_connect($host.":".$db,$user,$password);
			return $dbi;
			break;;
		case "Sybase":
			$dbi=@sybase_connect($host, $user, $password);
			sybase_select_db($db,$dbi);
			return $dbi;
			break;;
		default:
			break;;
	}

}
//2. function sql_logout($id);
function sql_logout($id)
{
	global $dbtype;
	switch ($dbtype)
	{
		case "MySQL":
			$dbi=@mysql_close($id);
			return $dbi;
			break;;
		case "mSQL":
			$dbi=@msql_close($id);
			return $dbi;
			break;;
		case "PostgreSQL":
		case "PostgreSQL_local":
			$dbi=@pg_close($id);
			return $dbi;
			break;;
		case "ODBC":
		case "ODBC_Adabas":
			 $dbi=@odbc_close($id);
			 return $dbi;
		break;;
		case "Interbase":
			$dbi=@ibase_close($id);
			return $dbi;
			break;;
		case "Sybase":
			$dbi=@sybase_close($id);
			return $dbi;
			break;;
		default:
			break;;
	}
}
//3. function sql_query($query,$id);
function sql_query($query,$id)
{
	global $dbtype;
	global $sql_debug;
	if($sql_debug) echo "SQL query: ".str_replace(",",", ",$query)."<BR>";
	switch ($dbtype)
	{
		case "MySQL":
			$res=@mysql_query($query,$id);
			return $res;
			break;;
		case "mSQL":
			$res=@msql_query($query,$id);
			return $res; 
			break;;
		case "PostgreSQL":
		case "PostgreSQL_local":
			$res=@pg_exec($id,$query);
			return $res;
			break;;
		case "ODBC":
		case "ODBC_Adabas":
			$res=@odbc_exec($id,$query);
			return $res;
			break;;
		case "Interbase":
			$res=@ibase_query($id,$query);
			return $res;
			break;;
		case "Sybase":
			$res=@sybase_query($query, $id);
			return $res;
			break;;
		default:
			break;;
	} 
} 
//4. function sql_num_rows($res);
function sql_num_rows($res)
{
	global $dbtype;
	switch ($dbtype)
	{
		case "MySQL":
			$rows=mysql_num_rows($res);
			return $rows;
			break;;
		case "mSQL":
			$rows=msql_num_rows($res);
			return $rows;
			break;;
		case "PostgreSQL":
		case "PostgreSQL_local":
			$rows=pg_numrows($res);
			return $rows;
			break;;
		case "ODBC":
		case "ODBC_Adabas":
			$rows=odbc_num_rows($res);
			return $rows; 
			break;;
		case "Interbase":
			echo "<BR>Error! PHP dosen't support ibase_numrows!<BR>";
			return $rows; 
			break;;
		case "Sybase":
			$rows=sybase_num_rows($res);
			return $rows; 
			break;;
		default:
			break;;
	}
}
//5. function sql_fetch_row($res,$nr);
function sql_fetch_row($res,$nr)
{
	global $dbtype;
	switch ($dbtype)
	{ 
		case "MySQL":
			$row = mysql_fetch_row($res);
			return $row;
			break;;
		case "mSQL": 
			$row = msql_fetch_row($res); 
			return $row; 
			break;;
		case "PostgreSQL": 
		case "PostgreSQL_local":
			$row = pg_fetch_row($res,$nr);
			return $row;
			break;;
		case "ODBC": 
		case "ODBC_Adabas":
			$row = array();
			$cols = odbc_fetch_into($res, $nr, $row); 
			return $row; 
			break;;
		case "Interbase":
			$row = ibase_fetch_row($res);
			return $row; 
			break;;
		case "Sybase":
			$row = sybase_fetch_row($res);
			return $row; 
			break;;
		default:
			break;;
	}
}
//6. function sql_fetch_array($res,$nr);
function sql_fetch_array($res,$nr)
{
	global $dbtype;
	switch ($dbtype)
	{
		case "MySQL":
			$row = array();
			$row = mysql_fetch_array($res);
			return $row; 
			break;;
		case "mSQL": 
			$row = array();
			$row = msql_fetch_array($res);
			return $row; 
			break;;
		case "PostgreSQL": 
		case "PostgreSQL_local":
			$row = array();
			$row = pg_fetch_array($res,$nr);
			return $row; 
			break;;
		/* 
		* ODBC doesn't have a native _fetch_array(), so we have to
		* use a trick. Beware: this might cause HUGE loads! 
		*/
		case "ODBC": 
			$row = array();
			$result = array(); 
			$result = odbc_fetch_row($res, $nr); 
			$nf = odbc_num_fields($res); /* Field numbering starts at 1 */
			for($count=1; $count < $nf+1; $count++)
			{
				$field_name = odbc_field_name($res, $count);
				$field_value = odbc_result($res, $field_name);
				$row[$field_name] = $field_value;
			}
			return $row; 
			break;;
		 case "ODBC_Adabas": 
			$row = array();
			$result = array(); 
			$result = odbc_fetch_row($res, $nr); 
			$nf = count($result)+2; /* Field numbering starts at 1 */
			for($count=1; $count < $nf; $count++)
			{
				$field_name = odbc_field_name($res, $count);
				$field_value = odbc_result($res, $field_name);
				$row[$field_name] = $field_value;
			}
			return $row; 
			break;;
		case "Interbase":
			$orow=ibase_fetch_object($res);
			$row=get_object_vars($orow);
			return $row;
			break;;
		case "Sybase":
			$row = sybase_fetch_array($res);
			return $row; 
		break;;
	}
} 
//7. function SQL_fetch_object($res,$nr);
function sql_fetch_object($res,$nr)
{
	global $dbtype;
	switch ($dbtype)
	{ 
		case "MySQL":
			$row = mysql_fetch_object($res);
			if($row) return $row;
			else return false;
			break;;
		case "mSQL": 
			$row = msql_fetch_object($res);
			if($row) return $row;
			else return false;
			break;;
		case "PostgreSQL":
		case "PostgreSQL_local":
			$row = pg_fetch_object($res,$nr);
			if($row) return $row;
			else return false;
			break;;
		case "ODBC": 
			$result = odbc_fetch_row($res, $nr);
			if(!$result) return false;
			$nf = odbc_num_fields($res); /* Field numbering starts at 1 */
			for($count=1; $count < $nf+1; $count++)
			{
				$field_name = odbc_field_name($res, $count);
				$field_value = odbc_result($res, $field_name); 
				$row->$field_name = $field_value;
			}
			return $row; 
			break;;
		case "ODBC_Adabas": 
			$result = odbc_fetch_row($res, $nr); 
			if(!$result) return false;
			$nf = count($result)+2; /* Field numbering starts at 1 */
			for($count=1; $count < $nf; $count++)
			{
				$field_name = odbc_field_name($res, $count);
				$field_value = odbc_result($res, $field_name);
				$row->$field_name = $field_value;
			}
			return $row; 
			break;;
		case "Interbase":
			$orow = ibase_fetch_object($res);
			if($orow)
			{
				$arow=get_object_vars($orow);
				while(list($name,$key)=each($arow))
				{
					$name=strtolower($name);
					$row->$name=$key;
				}
				return $row;
			}
			else return false;
			break;;
		case "Sybase":
			$row = sybase_fetch_object($res);
			return $row;
			break;;
	} 
}
//8. function sql_free_result($result);
function sql_free_result ($result)
{
	global $dbtype;
	switch ($dbtype)
	{ 
										 
		case "MySQL":
			mysql_free_result ($result);
			break;;
		case "mSQL": 
			msql_free_result ($result);
			break;;
		case "PostgreSQL": 
		case "PostgreSQL_local":
			pg_freeresult ($result);
			break;;
		case "ODBC": 
		case "ODBC_Adabas":
			odbc_free_result ($result);
			break;;
		case "Interbase":
			ibase_free_result($result);
			break;;
		case "Sybase":
			sybase_free_result($result);
			break;;
		default:
			break;;
	}
}
//9. function sql_query_limit($query,$idConnect,$idStart,$NumRow);
$NumAllRowOfQuery = 0 ; 
function sql_query_limit($query,$idConnect,$idStart,$NumRow)
{
	global $NumAllRowOfQuery; 
	$result = sql_query($query, $idConnect);
	$NumAllRowOfQuery = sql_num_rows($result);// So luong record re tra ve doi voi cau query nay 

	$query .=" LIMIT ". $idStart . ", ".$NumRow ." ";// chi lay du so luong record ($NumRow) ma cac lay thoi
	$result = sql_query($query, $idConnect );

	return $result;
} 
?>