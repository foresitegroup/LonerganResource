<?php
include("../inc/dbconfig.php");

switch ($_GET['a']) {
  case "add":
    $query = "INSERT INTO press (sort_date, date, source, source_url, title, subtitle, author, text) VALUES ('" . strtotime($_POST['date']) . "', '" . $_POST['date'] . "', '" . $_POST['source'] . "', '" . $_POST['source_url'] . "', '" . htmlspecialchars($_POST['title'], ENT_QUOTES) . "', '" . htmlspecialchars($_POST['subtitle'], ENT_QUOTES) . "', '" . $_POST['author'] . "', '" . htmlspecialchars($_POST['text'], ENT_QUOTES) . "')";
    break;
  case "edit":
    $query = "UPDATE press SET sort_date = '" . strtotime($_POST['date']) . "', date = '" . $_POST['date'] . "', source = '" . $_POST['source'] . "', source_url = '" . $_POST['source_url'] . "', title = '" . htmlspecialchars($_POST['title'], ENT_QUOTES) . "', subtitle = '" . htmlspecialchars($_POST['subtitle'], ENT_QUOTES) . "', author = '" . $_POST['author'] . "', text = '" . htmlspecialchars($_POST['text'], ENT_QUOTES) . "' WHERE id = '" . $_POST['id'] . "'";
    break;
  case "delete":
    $query = "DELETE FROM press WHERE id = '" . $_GET['id'] . "'";
    break;
}

mysql_query($query) or die(mysql_error());

header( "Location: pressindex.php" );
?>