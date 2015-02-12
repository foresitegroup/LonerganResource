<?php
include("inc/dbconfig.php");

$PageTitle = "Conferences";
include "header.php";
?>

<h1><?php echo $PageTitle ?></h1>

<?php
$result = mysql_query("SELECT * FROM conference ORDER BY startdate + 0");
while($row = mysql_fetch_array($result)) {
  $datestr = date("M d", $row['startdate']);
  if (($row['enddate'] == "") || ($row['enddate'] == $row['startdate'])) {
    $datestr .= ", " . date("Y", $row['startdate']);
  } else {
    if (date("Y", $row['startdate']) != date("Y", $row['enddate'])) { $datestr .= ", " . date("Y", $row['startdate']); }
    $datestr .= (date("M", $row['startdate']) == date("M", $row['enddate'])) ? "-" . date("d, Y", $row['enddate']) : "-" . date("M d, Y", $row['enddate']);
  }
  
  echo "<a href=\"conference.php?" . $row['id'] . "\">" . $datestr . " - " . $row['title'] . "</a><br>\n";
}
?>

<?php include "footer.php"; ?>