<?php
include("../inc/dbconfig.php");

switch ($_GET['a']) {
  case "add":
    $query = "INSERT INTO books (date, name, title, description) VALUES ('" . $_POST['date'] . "', '" . $_POST['name'] . "', '" . $_POST['title'] . "', '" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "')";
    break;
  case "edit":
    $query = "UPDATE books SET date = '" . $_POST['date'] . "', name = '" . $_POST['name'] . "', title = '" . $_POST['title'] . "', description = '" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "' WHERE id = '" . $_POST['id'] . "'";
    break;
  case "delete":
    $query = "DELETE FROM books WHERE id = '" . $_GET['id'] . "'";
    break;
}

mysql_query($query) or die(mysql_error());

header( "Location: bookindex.php" );
?>