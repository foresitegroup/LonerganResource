<?php
include("inc/dbconfig.php");
$result = mysql_query("SELECT * FROM books WHERE id = '" . $_SERVER['QUERY_STRING'] . "'");
$row = mysql_fetch_array($result);

$PageTitle = $row['name'] . ", " . $row['date'] . ", " . $row['title'];
include "header.php";
?>

<h1><?php echo $row['name'] . ", " . $row['date'] . ", <em>" . $row['title'] . "</em>"; ?></h1>

<?php
echo str_replace("\n", "<br>", $row['description']) . "<br>\n";

// Get all PDFs for this course
$results = array();
$handler = opendir("pdf/books/" . $_SERVER['QUERY_STRING']);

while ($file = readdir($handler)) {
  if (end(explode(".", $file)) == "pdf")
    $results[] = $file;
}

closedir($handler);

natsort($results);

foreach ($results as $value) {
  $document = file_get_contents("pdf/books/" . $_SERVER['QUERY_STRING'] . "/" . $value);
  $pdfauthor = (preg_match_all("/\/Author\((.*?)\)/",$document,$match)) ? end(end($match)) : "";
  $pdftitle = (preg_match_all("/\/Title\((.*?)\)/",$document,$match)) ? end(end($match)) : $value;
  //$pdf = ($pdfauthor != "" && $pdftitle != $value) ? $pdfauthor . ", <em>" . $pdftitle . "</em>" : "<em>" . $pdftitle . "</em>";
  $pdf = "<em>" . $pdftitle . "</em>";
  
  //echo "<br><a href=\"pdf/books/" . $_SERVER['QUERY_STRING'] . "/" . $value . "\"><img src=\"images/pdf.gif\" alt=\"PDF\"> View " . $pdf . "</a>\n";
  echo "<br><a href=\"pdf/books/" . $_SERVER['QUERY_STRING'] . "/" . $value . "\"><img src=\"images/pdf.gif\" alt=\"PDF\"> " . $pdf . "</a>\n";
}
?>

<?php include "footer.php"; ?>