<?php
include("inc/dbconfig.php");
$result = $mysqli->query("SELECT * FROM books WHERE id = '" . $_SERVER['QUERY_STRING'] . "'");
$row = $result->fetch_array(MYSQLI_ASSOC);

$PageTitle = $row['name'] . ", " . $row['date'] . ", " . $row['title'];
include "header.php";
?>

<h1><?php echo $row['name'] . ", " . $row['date'] . ", <em>" . $row['title'] . "</em>"; ?></h1>

<?php
echo str_replace("\n", "<br>", $row['description']) . "<br>\n";

// Get all PDFs for this book
$results = array();
$handler = opendir("pdf/books/" . $_SERVER['QUERY_STRING']);

while ($file = readdir($handler)) {
  $ext = explode(".", $file);
  if (end($ext) == "pdf") $results[] = $file;
}

closedir($handler);

natsort($results);

foreach ($results as $value) {
  $document = file_get_contents("pdf/books/" . $_SERVER['QUERY_STRING'] . "/" . $value);

  preg_match_all("/\/Title\((.*?)\)/",$document,$tarr);
  $tarr_last = end($tarr);
  $pdftitle = end($tarr_last);
  if ($pdftitle == "") $pdftitle = $value;

  $pdf = "<em>" . $pdftitle . "</em>";

  echo "<br><a href=\"pdf/books/" . $_SERVER['QUERY_STRING'] . "/" . $value . "\"><img src=\"images/pdf.gif\" alt=\"PDF\"> " . $pdf . "</a>\n";
}
?>

<?php include "footer.php"; ?>