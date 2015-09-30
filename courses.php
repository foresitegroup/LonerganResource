<?php
include("inc/dbconfig.php");

$PageTitle = "Courses";
include "header.php";
?>

<h1><?php echo $PageTitle ?></h1>

<?php
$result = mysql_query("SELECT * FROM courses WHERE display = '' ORDER BY name,date,title");
while($row = mysql_fetch_array($result)) {
  echo "<a href=\"course.php?" . $row['id'] . "\">" . $row['name'] . ", " . $row['date'] . ", <em>" . $row['title'] . "</em></a><br>\n";
}
?>

<?php include "footer.php"; ?>