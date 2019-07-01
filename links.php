<?php
$PageTitle = "Links";
include "header.php";
?>

<h1><?php echo $PageTitle; ?></h1>

The following links are to other reliable Bernard Lonergan resources.<br>
<br>

<?php
include_once("inc/dbconfig.php");

$result = $mysqli->query("SELECT * FROM links ORDER BY sort+0 ASC");

while($row = $result->fetch_array(MYSQLI_ASSOC)) {
  echo "<a href=\"" . $row['link'] . "\">" . $row['title'] . "</a><br>\n";
  
  if ($row['description'] != "") echo $row['description'] . "<br>\n";
  
  echo "<br>\n";
}
?>

<?php include "footer.php"; ?>