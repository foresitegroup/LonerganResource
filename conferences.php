<?php
include("inc/dbconfig.php");

$PageTitle = "Conferences";
include "header.php";
?>

<h1><?php echo $PageTitle ?></h1>

<?php
$result = $mysqli->query("SELECT * FROM conference WHERE display = '' ORDER BY startdate + 0");
while($row = $result->fetch_array(MYSQLI_ASSOC)) {
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