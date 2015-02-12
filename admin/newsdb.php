<?php
include("../inc/dbconfig.php");

switch ($_GET['a']) {
  case "add":
    $query = "INSERT INTO news (title, description) VALUES ('" . $_POST['title'] . "', '" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "')";
    break;
  case "edit":
    $query = "UPDATE news SET title = '" . $_POST['title'] . "', description = '" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "' WHERE id = '" . $_POST['id'] . "'";
    break;
  case "delete":
    $query = "DELETE FROM news WHERE id = '" . $_GET['id'] . "'";
    break;
}

mysql_query($query) or die(mysql_error());

header( "Location: newsindex.php" );
?>