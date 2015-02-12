<?php
include("../inc/dbconfig.php");

switch ($_GET['a']) {
  case "add":
    $query = "INSERT INTO links (title, link, description) VALUES ('" . $_POST['title'] . "', '" . $_POST['link'] . "', '" . $_POST['description'] . "')";
    break;
  case "edit":
    $query = "UPDATE links SET title = '" . $_POST['title'] . "', link = '" . $_POST['link'] . "', description = '" . $_POST['description'] . "' WHERE id = '" . $_POST['id'] . "'";
    break;
  case "delete":
    $query = "DELETE FROM links WHERE id = '" . $_GET['id'] . "'";
    break;
  
  case "sort":
    // Get page and sort number we are changing
    $result = mysql_query("SELECT * FROM links WHERE id = '" . $_GET['id'] . "'");
    $row = mysql_fetch_array($result);
    
    // Moving up or down?
    $sort = ($_GET['d'] == "u") ? $row['sort'] - 1 : $row['sort'] + 1;
    
    // Change sort number of neighboring record
    mysql_query("UPDATE links SET sort = '" . $row['sort'] . "' WHERE sort = '" . $sort . "'");
    
    // Change sort number of current record
    $query = "UPDATE links SET sort = '" . $sort . "' WHERE id = '" . $_GET['id'] . "'";
    
    break;
}

mysql_query($query) or die(mysql_error());

header( "Location: linksindex.php" );
?>