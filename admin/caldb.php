<?php
include("../inc/dbconfig.php");

if ($_GET['a'] != "delete") {
  $strdate = ($_POST['date'] != "") ? strtotime($_POST['date']) : time();
}

switch ($_GET['a']) {
  case "add":
    $query = "INSERT INTO calendar (date, event, description) VALUES ('$strdate', '" . $_POST['event'] . "', '" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "')";
    break;
  case "edit":
    $query = "UPDATE calendar SET date = '$strdate', event = '" . $_POST['event'] . "', description = '" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "' WHERE id = '" . $_POST['id'] . "'";
    break;
  case "delete":
    $query = "DELETE FROM calendar WHERE id = '" . $_GET['id'] . "'";
    break;
}

mysql_query($query) or die(mysql_error());

if (!empty($_GET['b'])) { $go = "?b=" . $_GET['b']; }

header( "Location: calindex.php$go" );
?>