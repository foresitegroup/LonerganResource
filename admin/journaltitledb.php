<?php
include("../inc/dbconfig.php");

switch ($_GET['a']) {
  case "add":
    $query = "INSERT INTO journaltitles (title) VALUES ('" . $_POST['title'] . "')";
    break;
  case "edit":
    $query = "UPDATE journaltitles SET title = '" . $_POST['title'] . "' WHERE id = '" . $_POST['id'] . "'";
    break;
  case "delete":
    $query = "DELETE FROM journaltitles WHERE id = '" . $_GET['id'] . "'";
    break;
}

$mysqli->query($query);

header("Location: journaltitleindex.php");
?>