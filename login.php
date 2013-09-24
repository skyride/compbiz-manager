<?php

session_start();

function loginredirect()
{
	?>
<head>
	<meta http-equiv="refresh" content="0;url=/log.php">
</head>
	<?

die();
}

mysql_connect($mysql['host'], $mysql['user'], $mysql['pass']);
mysql_select_db($mysql['db']);

//Check if our session details exist
if(isset($_SESSION['user']))
{
	if(isset($_SESSION['pass']))
	{
		//It is set, check they are correct
		$sql = "SELECT * FROM accounts WHERE username = '".mysql_real_escape_string($_SESSION['user'])."' AND password = '".mysql_real_escape_string($_SESSION['pass'])."' ";
		$r = mysql_query($sql);
		if(mysql_num_rows($r) < 1)
		{
			loginredirect();
		}
		
		//Check the account has the right permissions
		$row = mysql_fetch_assoc($r);
		$sql = "SELECT * FROM permissions WHERE account = '".$row['id']."' ";
		$r = mysql_query($sql);
		$test = false;
		
		for($i = 0; $i < mysql_num_rows($r); $i++)
		{
			$line = mysql_fetch_assoc($r);
			if($line['flag'] == "admin")
			{
				$test = true;
			}
		}
		
		if($test == false)
		{
			loginredirect();
		}
		
	} else
	{
		loginredirect();
	}
} else
{
	loginredirect();
}

?>