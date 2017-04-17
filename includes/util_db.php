<?php
function DropDownBoxDB($SelectedValue ,$AllowAll,$TableName,$ColumnValue,$ColumnLabel,$strwhere )
{
	global $dbi;
	$ret="";
	if($AllowAll==1) $ret ="<option value=\"0\"> All </option>";
	$query = "select * from $TableName where 1 ";
	if(strlen($strwhere)>0)
	$query .= $strwhere ;
	$result =  sql_query($query, $dbi);
	if ($result)
	{
		$NumOfRows = sql_num_rows($result);
		if($NumOfRows>0)
		{
			while ($row = sql_fetch_object ($result,1)) 
			{
				$Column1 	= $row->$ColumnValue;
				$Column2 	= $row->$ColumnLabel;
				if($Column1==$SelectedValue) $ret .="<option value=\"$Column1\" selected> $Column2 </option>";
				else $ret .="<option value=\"$Column1\"> $Column2 </option>";
			}
		}
	}
	return $ret;
}
function SelectValue($NameObject,$TableName,$strCond)
{
	global $dbi;
	$ret = "";
	$query = "select * from $TableName where 1 ";
	if(strlen($strCond)>0)
	$query .= $strCond;
	$result = sql_query($query, $dbi);
	if ($result)
	{
		$NumOfRows = sql_num_rows($result);
		if($NumOfRows>0)
		{
			$row = sql_fetch_object($result,1);
			$ret = $row->$NameObject;
		}
	}
	return $ret;
}
function creatCodeInt($tablename,$colname)
{
	global $dbi;
	$query="select MAX($colname) as max from $tablename ";
	$result=sql_query($query,$dbi);
	if($result)
	{
		$NumOfRows=sql_num_rows($result);
		if($NumOfRows>0)
		{
			$row = sql_fetch_object ($result,1);
			$ret = $row->max;
		}
	}
	$ret++;
	return $ret;
}
function getFirstID($idname,$tablename,$strcond)
{
	global $dbi;
	$query="select * from $tablename where 1 ";
	$query.=$strcond;
	$result=sql_query($query,$dbi);
	if($result)
	{
		$NumOfRows=sql_num_rows($result);
		if($NumOfRows>0)
		{
			$row = sql_fetch_object ($result,1);
			$ret = $row->$idname;
		}
	}
	return $ret;
}
function check_exit_name($valuename,$fieldname,$table)
{
	global $dbi;
	$query = "select  *  from $table where $fieldname= '$valuename'";
	$result =  sql_query($query,$dbi);
	if ($result)
	{
		$numrow=sql_num_rows($result, $dbi);
		if($numrow>0) return true;
		else return false;
	}
	else return false;
}
function check_empty($TableName,$strcond)
{
	global $dbi;
	$query = "select * from $TableName where 1 ";
	$query.=$strcond;
	$result =  sql_query($query,$dbi);
	if ($result)
	{
		$numrow=sql_num_rows($result, $dbi);
		if($numrow>0) return true;
		else return false;
	}
	else return false;
}
function Check_Limit($collumn,$table,$where,$limit)
{
	global $dbi;
	$query = " SELECT $collumn FROM $table ";
	$query .= " where 1 ";
	$query .=  $where;
	$result = sql_query($query, $dbi);
	if ($result)
	{
		$numrow=sql_num_rows($result, $dbi);
		if($numrow >= $limit) return false;
		else return true;
	}
	else return false;
}
?>