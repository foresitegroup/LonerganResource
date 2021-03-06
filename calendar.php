<?php
$PageTitle = "Calendar";
if ($_SERVER['QUERY_STRING']) {
  include_once "inc/dbconfig.php";
  $result = $mysqli->query("SELECT * FROM calendar WHERE id = '" . $_SERVER['QUERY_STRING'] . "'");
  $row = $result->fetch_array(MYSQLI_ASSOC);
  $PageTitle .= " - " . date("F d, Y", $row['date']);
}
include "header.php";
?>

<h1><?php echo $PageTitle; ?></h1>

<?php
if (!$_SERVER['QUERY_STRING']) {
  $result = $mysqli->query("SELECT * FROM calendar ORDER BY date ASC");
  while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    echo "<h2>" . date("M d", $row['date']) . ": " . $row['event'] . "</h2>\n";
    if (!empty($row['description'])) echo htmlspecialchars_decode(str_replace("\n", "<br>", $row['description'])) . "<br>\n";
    echo "<br>\n";
  }
} else {
  echo "<h2>" . $row['event'] . "</h2>\n";
  if (!empty($row['description'])) echo htmlspecialchars_decode(str_replace("\n", "<br>", $row['description']));
}
?>

<?php include "footer.php"; ?>