<?php

function getPermissions($accountid)
{
	$return = array();
	
	//Build connection
	global $mysql;
	mysql_connect($mysql['host'], $mysql['user'], $mysql['pass']);
	mysql_select_db($mysql['db']);
	
	//Get permissions from DB
	$sql = "SELECT * FROM permissions WHERE account = '".mysql_real_escape_string($accountid)."'";
	$r = mysql_query($sql);
	
	//Iterate into array
	for($i = 0; $i < mysql_num_rows($r); $i++)
	{
		$row = mysql_fetch_assoc($r);
		$return[] = $row['flag'];
	}
	
	return $return;
}

function checkPermission($accountid, $flag)
{
	$arr = getPermissions($accountid);
	
	for($i = 0; $i < count($arr); $i++)
	{
		if(strtoupper($arr[$i]) == strtoupper($flag))
		{
			return true;
		}
	}
	
	return false;
}

function addPermission($accountid, $flag)
{
	//Check if the permission already exists
	if(checkPermission($accountid, $flag))
	{
		//It already does, so just return
		return;
	}
	
	//Build connection
	global $mysql;
	mysql_connect($mysql['host'], $mysql['user'], $mysql['pass']);
	mysql_select_db($mysql['db']);
	
	//Add permission
	$sql = "INSERT INTO permissions (`account`, `flag`) VALUES ('".mysql_real_escape_string($accountid)."', '".mysql_real_escape_string($flag)."'); ";
	mysql_query($sql);
}

function removePermission($accountid, $flag)
{
	//Check if the account has this permission
	if(checkPermission($accountid, $flag))
	{
		//Build connection
		global $mysql;
		mysql_connect($mysql['host'], $mysql['user'], $mysql['pass']);
		mysql_select_db($mysql['db']);
		
		//Remove permission
		$sql = "DELETE FROM permissions WHERE account = '".mysql_real_escape_string($accountid)."' AND flag = '".mysql_real_escape_string($flag)."'";
		mysql_query($sql);
	}
}

?>