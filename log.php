<?php

session_start();

function check($user, $pass)
{
	include("config.php");
	
	mysql_connect($mysql['host'], $mysql['user'], $mysql['pass']);
	mysql_select_db($mysql['db']);

	$sql = "SELECT * FROM accounts WHERE username = '".mysql_real_escape_string($user)."' AND password = '".mysql_real_escape_string($pass)."' ";

	$r = mysql_query($sql);
	
	if(mysql_num_rows($r) < 1)
	{
		return false;
	} else
	{
		return true;
	}
}

function redirect()
{
	?>
<head>
	<meta http-equiv="refresh" content="0;url=/accounts.php">
</head>
	<?
	
	die();
}
include("config.php");
$message = "";
$default_username = "";

//Check if a correct session already exists
if(isset($_SESSION['user']) && isset($_SESSION['pass']))
{
	//Check if the details are correct
	if(check($_SESSION['user'], $_SESSION['pass']))
	{
		//Check the account has the right permissions
		$sql = "SELECT * FROM accounts WHERE username = '".mysql_real_escape_string($_SESSION['user'])."' AND password = '".mysql_real_escape_string($_SESSION['pass'])."' ";
		$r = mysql_query($sql);
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
		
		if($test == true)
		{
			redirect();
		} else
		{
			//$message = "<div class=\"alert alert-danger\">You do not have sufficient permissions to access this resource.</div>";
		}
	} else
	{
		$message = "<div class=\"alert alert-danger\">Your login details are no longer valid.</div>";
	}
}

//Check if login details have been sent from the client
if(isset($_POST['user']) && isset($_POST['pass']))
{
	//Check if the login details are correct
	if(check($_POST['user'], sha1($_POST['pass'])))
	{
		//Check the account has the right permissions
		$sql = "SELECT * FROM accounts WHERE username = '".mysql_real_escape_string($_POST['user'])."' AND password = '".mysql_real_escape_string(sha1($_POST['pass']))."' ";
		$r = mysql_query($sql);
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
		
		if($test == true)
		{
			//Write login details to session
			$_SESSION['user'] = $_POST['user'];
			$_SESSION['pass'] = sha1($_POST['pass']);
			
			//Redirect to admin page
			redirect();
		} else
		{
			$message = "<div class=\"alert alert-danger\">You do not have sufficient permissions to access this resource.</div>";
			$default_username = $_POST['user'];
		}
	} else
	{
		//Provide incorrect login details error
		$message = "<div class=\"alert alert-danger\">Incorrect details provided!</div>";
		$default_username = $_POST['user'];
	}
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
  </head>

  <body>

    <div class="container">

      <form class="form-signin" method="POST">
        <h2 class="form-signin-heading">Login</h2>
		<?php echo $message; ?>
        <input type="text" name="user" class="form-control" placeholder="Username" value="<?php echo $default_username; ?>" autofocus>
        <input type="password" name="pass" class="form-control" placeholder="Password">		
        <button class="btn btn-large btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div> <!-- /container -->

  </body>
</html>