<?php
include("../inc/dbconfig.php");

switch ($_GET['a']) {
  case "add":
    $query = "INSERT INTO courses (date, name, title, location, description, display) VALUES ('" . $_POST['date'] . "', '" . $_POST['name'] . "', '" . $_POST['title'] . "', '" . $_POST['location'] . "', '" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "', '" . $_POST['display'] . "')";
    break;
  case "edit":
    $query = "UPDATE courses SET date = '" . $_POST['date'] . "', name = '" . $_POST['name'] . "', title = '" . $_POST['title'] . "', location = '" . $_POST['location'] . "', description = '" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "', display = '" . $_POST['display'] . "' WHERE id = '" . $_POST['id'] . "'";
    break;
  case "delete":
    $query = "DELETE FROM courses WHERE id = '" . $_GET['id'] . "'";
    break;
}

$mysqli->query($query);

header("Location: courseindex.php");
?>