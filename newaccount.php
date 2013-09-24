<?php

include("init.php");

$breadcrumbs = "";
$search = "";
$currentuser = getAccountFromUserPass($_SESSION['user'], $_SESSION['pass']);

//Get accounts list
mysql_connect($mysql['host'], $mysql['user'], $mysql['pass']);
mysql_select_db($mysql['db']);
$sql = "SELECT id, fname, lname, phone1, email, created FROM accounts ";

//Handle submission
if(isset($_POST['fname']))
{
	//Build Array
	$arr['username'] = $_POST['username'];
	$arr['password'] = $_POST['password'];
	$arr['fname'] = $_POST['fname'];
	$arr['lname'] = $_POST['lname'];
	$arr['phone1'] = $_POST['phone1'];
	$arr['phone2'] = $_POST['phone2'];
	$arr['email'] = $_POST['email'];
	$arr['address'] = $_POST['address'];
	$arr['notes'] = $_POST['notes'];
	
	//Create account
	createAccount($arr);
	
	//Get the id of the new account
	$nsql = "SELECT id FROM accounts WHERE
		username = '".mysql_real_escape_string($arr['username'])."' AND
		password = sha1('".mysql_real_escape_string($arr['password'])."') AND
		fname =	   '".mysql_real_escape_string($arr['fname'])."' AND
		lname =    '".mysql_real_escape_string($arr['lname'])."' AND
		phone1 =   '".mysql_real_escape_string($arr['phone1'])."' AND
		phone2 =   '".mysql_real_escape_string($arr['phone2'])."' AND
		email =    '".mysql_real_escape_string($arr['email'])."' AND
		address =  '".mysql_real_escape_string($arr['address'])."' AND
		notes =    '".mysql_real_escape_string($arr['notes'])."' LIMIT 1 ;";
		
	$r = mysql_query($nsql);
	echo mysql_error();
	if(mysql_num_rows($r) > 0)
	{
		$row = mysql_fetch_assoc($r);
		$id = $row['id'];
		
		?>
<head>
	<meta http-equiv="refresh" content="0;url=/editaccount.php?id=<?php echo $id; ?>">
</head>
		<?
		
		die();
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

    <title><?php echo $title; ?> - Create New Account</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="navbar-static-top.css" rel="stylesheet">
  </head>

  <body>

    <!-- Static navbar -->
    <div class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><?php echo $title; ?></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
		  <li><a href="/index.php">Home</a></li>
            <li class="active"><a href="/accounts.php">Accounts</a></li>
          <li><a href="/jobs.php">Jobs</a></li>
          </ul>
		  
		  <div class="navbar-form navbar-right" role="search">
				<button class="btn btn-primary navbar-right" onClick="document.location='/logout.php'">Log Out</button>
			</div>
		  
		  <div class="navbar-form navbar-right" style="margin-top: 13px; margin-bottom: -13px; margin-right: -12px;">
			<h5><i>Welcome, <?php echo $currentuser->getName(); ?></i></h5>
		  </div>
        </div><!--/.nav-collapse -->
      </div>
    </div>


    <div class="container">
	
	<nav class="navbar" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="/accounts.php">Accounts</a> <a class="navbar-brand" style="margin-left: 5px;"> <a class="navbar-brand">/</a> <a class="navbar-brand" href="/newaccount.php" style="padding-left: 4px;">Create New Account</a>
  </div>
  
  <form method="POST" class="navbar-form navbar-left" style="margin-right: -25px" role="order">
    </form>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">
	<form action="/accounts.php" method="GET" class="navbar-form navbar-right" style="margin-right: -5px" role="search">
      <div class="form-group">
        <input type="text" name="search" class="form-control" placeholder="Search" value="<?php echo $search; ?>">
      </div>
      <button type="submit" class="btn btn-default" style="margin-right: 6px;">Submit</button>
    </form>
  </div><!-- /.navbar-collapse -->
</nav>

      <?php /*<!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Navbar example</h1>
        <p>This example is a quick exercise to illustrate how the default, static navbar and fixed to top navbar work. It includes the responsive CSS and HTML, so it also adapts to your viewport and device.</p>
        <p>
          <a class="btn btn-large btn-primary" href="../../components/#navbar">View navbar docs &raquo;</a>
        </p>
      </div> */?>
	
	<div style="border: 1px solid #DDD; -webkit-border-radius: 7px; border-radius: 7px; padding: 3px; padding-top: 1px; padding-bottom: 0px;">
		<form method="POST">
			<table class="table table-hover">
				<tr>
					<th>First Name:</th>
					<td><input name="fname" type="text" class="form-control" placeholder="First Name"></td>
				</tr>
				
				<tr>
					<th>Last Name:</th>
					<td><input name="lname" type="text" class="form-control" placeholder="Last Name"></td>
				</tr>
				
				<tr>
					<th>Username:</th>
					<td><input name="username" type="text" class="form-control" placeholder="Username"></td>
				</tr>
				
				<tr>
					<th>Password:</th>
					<td><input name="password" type="password" class="form-control" placeholder="Password"></td>
				</tr>
				
				<tr>
					<th>Phone Number #1:</th>
					<td><input name="phone1" type="text" class="form-control" placeholder="Phone Number #1"></td>
				</tr>
				
				<tr>
					<th>Phone Number #2:</th>
					<td><input name="phone2" type="text" class="form-control" placeholder="Phone Number #2"></td>
				</tr>
				
				<tr>
					<th>Email Address:</th>
					<td><div class="input-group"><span class="input-group-addon">@</span><input name="email" type="text" class="form-control" placeholder="Email Address"></div></td>
				</tr>
				
				<tr>
					<th>Address:</th>
					<td><textarea name="address" class="form-control" rows="5" placeholder="Address"></textarea></td>
				</tr>
				
				<tr>
					<th>Notes:</th>
					<td><textarea name="notes" class="form-control" rows="6" placeholder="Notes"></textarea></td>
				</tr>
				
				<tr>
					<td colspan="2"><button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button></td>
				</tr>
			</table>
		</form>
	</div>

    </div> <!-- /container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../../assets/js/jquery.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
  </body>
</html>
