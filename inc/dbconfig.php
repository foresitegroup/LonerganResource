<?php
$dbHost = "localhost";
$dbUser = "resource";
$dbPass = "Foresite4474";
$dbName = "resource";

$db = mysql_connect($dbHost, $dbUser, $dbPass);
mysql_select_db($dbName, $db);

putenv("TZ=US/Central");
?>