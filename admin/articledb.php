<?php
include("../inc/dbconfig.php");

switch ($_GET['a']) {
  case "add":
    $query = "INSERT INTO articles (name, title, description, file1, display) VALUES ('" . $_POST['name'] . "', '" . $_POST['title'] . "', '" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "', '" . $_POST['file1'] . "', '" . $_POST['display'] . "')";
    break;
  case "edit":
    $query = "UPDATE articles SET name = '" . $_POST['name'] . "', title = '" . $_POST['title'] . "', description = '" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "', file1 = '" . $_POST['file1'] . "', display = '" . $_POST['display'] . "' WHERE id = '" . $_POST['id'] . "'";
    break;
  case "delete":
    $query = "DELETE FROM articles WHERE id = '" . $_GET['id'] . "'";
    break;
}

$mysqli->query($query);

header("Location: articleindex.php");
?>