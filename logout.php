<?php
	session_start();
	session_destroy();
	setcookie("PHPSESSID", "", time() - 3600);
?>

<head>
	<meta http-equiv="refresh" content="0;url=/log.php">
</head>