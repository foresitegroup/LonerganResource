<?php
include("../inc/dbconfig.php");

switch ($_GET['a']) {
  case "edit":
    $query = "UPDATE newsletter SET email = '" . $_POST['email'] . "' WHERE id = '" . $_POST['id'] . "'";
    break;
  case "delete":
    $query = "DELETE FROM newsletter WHERE id = '" . $_GET['id'] . "'";
    break;
}

$mysqli->query($query);

header("Location: nlindex.php");
?>