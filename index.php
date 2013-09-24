<?php

ini_set('display_errors',1); 
error_reporting(E_ALL);

include("init.php");

$acc = getAccount(1);
print_r($acc);

?>