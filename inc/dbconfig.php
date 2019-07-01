<?php
$dbHost = "localhost";
$dbUser = "resource";
$dbPass = "Foresite4474";
$dbName = "resource";

$mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

putenv("TZ=US/Central");
?>