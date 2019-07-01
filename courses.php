<?php
include("inc/dbconfig.php");

$PageTitle = "Courses";
include "header.php";
?>

<h1><?php echo $PageTitle ?></h1>

<?php
$result = $mysqli->query("SELECT * FROM courses WHERE display = '' ORDER BY name,date,title");
while($row = $result->fetch_array(MYSQLI_ASSOC)) {
  echo "<a href=\"course.php?" . $row['id'] . "\">" . $row['name'] . ", " . $row['date'] . ", <em>" . $row['title'] . "</em></a><br>\n";
}
?>

<?php include "footer.php"; ?>