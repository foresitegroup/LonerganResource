<?php
include("../inc/dbconfig.php");

switch ($_GET['a']) {
  case "add":
    $query = "INSERT INTO articles (name, title, description, file1) VALUES ('" . $_POST['name'] . "', '" . $_POST['title'] . "', '" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "', '" . $_POST['file1'] . "')";
    break;
  case "edit":
    $query = "UPDATE articles SET name = '" . $_POST['name'] . "', title = '" . $_POST['title'] . "', description = '" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "', file1 = '" . $_POST['file1'] . "' WHERE id = '" . $_POST['id'] . "'";
    break;
  case "delete":
    $query = "DELETE FROM articles WHERE id = '" . $_GET['id'] . "'";
    break;
}

mysql_query($query) or die(mysql_error());

header( "Location: articleindex.php" );
?>