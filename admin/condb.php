<?php
include("../inc/dbconfig.php");

if ($_GET['a'] != "delete") {
  $startdate = strtotime($_POST['startdate']);
  $enddate = strtotime($_POST['enddate']);
}

switch ($_GET['a']) {
  case "add":
    $query = "INSERT INTO conference (
                publish,
                startdate,
                enddate,
                title,
                location,
                description,
                display
              ) VALUES (
                'no',
                '$startdate',
                '$enddate',
                '" . $mysqli->real_escape_string($_POST['title']) . "',
                '" . $mysqli->real_escape_string($_POST['location']) . "',
                '" . $mysqli->real_escape_string($_POST['description']) . "',
                '" . $_POST['display'] . "'
              )";
    break;
  case "edit":
    $query = "UPDATE conference SET 
                startdate = '$startdate',
                enddate = '$enddate',
                title = '" . $mysqli->real_escape_string($_POST['title']) . "',
                location = '" . $mysqli->real_escape_string($_POST['location']) . "',
                description = '" . $mysqli->real_escape_string($_POST['description']) . "',
                display = '" . $_POST['display'] . "' 
              WHERE id = '" . $_POST['id'] . "'";
    break;
  case "delete":
    $query = "DELETE FROM conference WHERE id = '" . $_GET['id'] . "'";
    break;
}

$mysqli->query($query));

header("Location: conindex.php");
?>