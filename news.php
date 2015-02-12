<?php
$PageTitle = "News & Events";
include "header.php";
?>

<h1><?php echo $PageTitle; ?></h1>

<?php
$result = mysql_query("SELECT * FROM news ORDER BY id DESC");
while($row = mysql_fetch_array($result)) {
  echo "<a name=\"" . $row['id'] . "\"></a>\n";
  
  echo "<h2>" . $row['title'] . "</h2>\n";
  
  echo htmlspecialchars_decode(str_replace("\n", "<br>", $row['description'])) . "<br>\n<br>\n";
}
?>

<?php include "footer.php"; ?>