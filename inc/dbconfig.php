<?php
$dbHost = "localhost";
$dbUser = "remediho_lradm";
$dbPass = "remedi";
$dbName = "remediho_lonerganresource";

$db = mysql_connect($dbHost, $dbUser, $dbPass);
mysql_select_db($dbName, $db);

putenv("TZ=US/Central");
?>