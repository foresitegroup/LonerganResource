<?php
include("../inc/dbconfig.php");

if ($_GET['a'] != "delete") {
  $startdate = strtotime($_POST['startdate']);
  $enddate = strtotime($_POST['enddate']);
}

switch ($_GET['a']) {
  case "add":
    $query = "INSERT INTO conference (publish, startdate, enddate, title, location, description, display) VALUES ('no', '$startdate', '$enddate', '" . mysql_real_escape_string($_POST['title']) . "', '" . mysql_real_escape_string($_POST['location']) . "', '" . $_POST['description'] . "', '" . $_POST['display'] . "')";
    break;
  case "edit":
    $query = "UPDATE conference SET startdate = '$startdate', enddate = '$enddate', title = '" . mysql_real_escape_string($_POST['title']) . "', location = '" . mysql_real_escape_string($_POST['location']) . "', description = '" . $_POST['description'] . "', display = '" . $_POST['display'] . "' WHERE id = '" . $_POST['id'] . "'";
    break;
  case "delete":
    $query = "DELETE FROM conference WHERE id = '" . $_GET['id'] . "'";
    break;
}

mysql_query($query) or die(mysql_error());

header( "Location: conindex.php" );
?>