<?php
include("../inc/dbconfig.php");

switch ($_GET['a']) {
  case "add":
    $query = "INSERT INTO journals (titleid, volume, number, description, file1, display) VALUES ('" . $_POST['titleid'] . "', '" . $_POST['volume'] . "', '" . $_POST['number'] . "', '" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "', '" . $_POST['file1'] . "', '" . $_POST['display'] . "')";
    break;
  case "edit":
    $query = "UPDATE journals SET titleid = '" . $_POST['titleid'] . "', volume = '" . $_POST['volume'] . "', number = '" . $_POST['number'] . "', description = '" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "', file1 = '" . $_POST['file1'] . "', display = '" . $_POST['display'] . "' WHERE id = '" . $_POST['id'] . "'";
    break;
  case "delete":
    $query = "DELETE FROM journals WHERE id = '" . $_GET['id'] . "'";
    break;
}

$mysqli->query($query);

header("Location: journalindex.php");
?>