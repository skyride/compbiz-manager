<?php

include("init.php");

function printTable($r)
{
	for($i = 0; $i < mysql_num_rows($r); $i++)
	{
		$row = mysql_fetch_assoc($r);
?><tr style="cursor: pointer;" onClick="document.location='/editaccount.php?id=<?php echo $row['id']; ?>'">
					<td><?php echo htmlspecialchars($row['fname']); ?></td>
					<td><?php echo htmlspecialchars($row['lname']); ?></td>
					<td><?php echo htmlspecialchars($row['phone1']); ?></td>
					<td><?php echo htmlspecialchars($row['email']); ?></td>
					<td><?php echo date("H:i - d/m/y", $row['created']); ?></td>
					<td width="50px"><button type="button" class="btn btn-default btn-sm" style="margin-top: -2px; margin-bottom: -1px;">Edit</button></td>
				</tr>
				<?
	}
}

$breadcrumbs = "";
$search = "";
$currentuser = getAccountFromUserPass($_SESSION['user'], $_SESSION['pass']);

//Get accounts list
mysql_connect($mysql['host'], $mysql['user'], $mysql['pass']);
mysql_select_db($mysql['db']);
$sql = "SELECT id, fname, lname, phone1, email, created FROM accounts ";

//Work out ordering
if(isset($_POST['order']))
{
	$orderby = mysql_real_escape_string($_POST['order']);
	$_SESSION['orderby'] = $orderby;
	$orderoption[$orderby] = 'selected="selected"';
} else
{
	if(isset($_SESSION['orderby']))
	{
		$orderby = $_SESSION['orderby'];
	} else
	{
		$orderby = "lname";
		$_SESSION['orderby'] = $orderby;
	}
	$orderoption[$orderby] = 'selected="selected"';
}

//Check if any search was specified
if(isset($_GET['search']) && strlen($_GET['search']) > 0)
{
	$term = mysql_real_escape_string($_GET['search']);
	$sql .= "WHERE fname LIKE '%".$term."%' OR lname LIKE '%".$term."%' OR email LIKE '%".$term."%' OR phone1 LIKE '%".$term."%' OR phone2 LIKE '%".$term."%' OR address LIKE '%".$term."%' ORDER BY ".$orderby." ASC";
	$r = mysql_query($sql);
	
	//Build breadcrumbs
	if(mysql_num_rows($r) == 1)
	{
		$breadcrumbs = " / Search: 1 Result";
	} else
	{
		$breadcrumbs = " / Search: ".mysql_num_rows($r)." Results";
	}
	
	//Search preset
	$search = $_GET['search'];
} else
{
	$sql = "SELECT id, fname, lname, phone1, email, created FROM accounts ORDER BY ".$orderby." ASC";
	$r = mysql_query($sql);
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $title; ?> - Accounts</title>

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
			<h5><i>Welcome, <?php echo htmlspecialchars($currentuser->getName()); ?></i></h5>
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
    <a class="navbar-brand" href="/accounts.php">Accounts</a> <a class="navbar-brand" style="margin-left: 5px;"><?php echo $breadcrumbs; ?></a>
  </div>
  
  <form method="POST" class="navbar-form navbar-left" style="margin-right: -25px" role="order">
	  <label style="color: #5E5E5E;">Sort By:</label>
      <div class="form-group">
		<select name="order" class="form-control" onChange="this.form.submit();">
			<option value="id" <?php echo $orderoption['id']; ?>>ID</option>
			<option value="fname" <?php echo $orderoption['fname']; ?>>First Name</option>
			<option value="lname" <?php echo $orderoption['lname']; ?>>Last Name</option>
			<option value="created" <?php echo $orderoption['created']; ?>>Creation Date</option>
		</select>
      </div>
    </form>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <div class="navbar-form navbar-right" role="search">
	  <button class="btn btn-success navbar-right" onClick="document.location='/newaccount.php'">Create Account</button>
    </div>
	<form action="/accounts.php" method="GET" class="navbar-form navbar-right" style="margin-right: -25px" role="search">
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
	
	<div style="border: 1px solid #DDD; -webkit-border-radius: 7px; border-radius: 7px; padding: 3px; padding-top: 1px;">
		<table class="table table-hover">
			<thead>
				<tr>
					<th>First Name:</th>
					<th>Last Name:</th>
					<th>Primary Phone No:</th>
					<th>Email:</th>
					<th>Created:</th>
					<th></th>
				</tr>
			</thead>
			
			<tbody>
				<?php printTable($r); ?>
			</tbody>
		</table>
	</div>

    </div> <!-- /container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../../assets/js/jquery.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
  </body>
</html>
