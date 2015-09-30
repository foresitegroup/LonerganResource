<?php
$PageTitle = "News & Events";
include "header.php";
?>

<h1><?php echo $PageTitle; ?></h1>

<?php
$query = ($_SERVER['QUERY_STRING']) ? "SELECT * FROM news WHERE id = '" . $_SERVER['QUERY_STRING'] . "'" : "SELECT * FROM news WHERE display = '' ORDER BY id DESC";
$result = mysql_query($query);
while($row = mysql_fetch_array($result)) {
  echo "<a name=\"" . $row['id'] . "\"></a>\n";
  
  echo "<h2>" . $row['title'] . "</h2>\n";
  
  echo htmlspecialchars_decode(str_replace("\n", "<br>", $row['description'])) . "<br>\n<br>\n";
}
?>

<?php include "footer.php"; ?>