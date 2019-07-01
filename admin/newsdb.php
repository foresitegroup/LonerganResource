<?php
include("../inc/dbconfig.php");

switch ($_GET['a']) {
  case "add":
    $query = "INSERT INTO news (title, description, display) VALUES ('" . $_POST['title'] . "', '" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "', '" . $_POST['display'] . "')";
    break;
  case "edit":
    $query = "UPDATE news SET title = '" . $_POST['title'] . "', description = '" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "', display = '" . $_POST['display'] . "' WHERE id = '" . $_POST['id'] . "'";
    break;
  case "delete":
    $query = "DELETE FROM news WHERE id = '" . $_GET['id'] . "'";
    break;
}

$mysqli->query($query);

header("Location: newsindex.php");
?>