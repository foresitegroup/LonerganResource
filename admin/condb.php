<?php
include("../inc/dbconfig.php");

if ($_GET['a'] != "delete") {
  $startdate = strtotime($_POST['startdate']);
  $enddate = strtotime($_POST['enddate']);
}

switch ($_GET['a']) {
  case "add":
    $query = "INSERT INTO conference (publish, startdate, enddate, title, location, description) VALUES ('no', '$startdate', '$enddate', '" . $_POST['title'] . "', '" . $_POST['location'] . "', '" . $_POST['description'] . "')";
    break;
  case "edit":
    $query = "UPDATE conference SET startdate = '$startdate', enddate = '$enddate', title = '" . $_POST['title'] . "', location = '" . $_POST['location'] . "', description = '" . $_POST['description'] . "' WHERE id = '" . $_POST['id'] . "'";
    break;
  case "delete":
    $query = "DELETE FROM conference WHERE id = '" . $_GET['id'] . "'";
    break;
}

mysql_query($query) or die(mysql_error());

header( "Location: conindex.php" );
?>