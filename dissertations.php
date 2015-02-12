<?php
include("inc/dbconfig.php");
$PageTitle = "Dissertations";
include "header.php";
?>

<h1><?php echo $PageTitle; ?></h1>

<?php
if ($_SERVER['QUERY_STRING']) { $id = "WHERE id = '" . $_SERVER['QUERY_STRING'] . "'"; }
$result = mysql_query("SELECT * FROM dissertations $id ORDER BY name ASC");
while($row = mysql_fetch_array($result)) {
?>

<?php if ($_SERVER['QUERY_STRING'] == "") { echo "<a href=\"javascript:toggle('" . $row['id'] . "')\">"; } ?>
<?php echo $row['name']; ?>, <em><?php echo $row['title']; ?></em>
<?php if ($_SERVER['QUERY_STRING'] == "") { echo "</a>"; } ?>

<div id="<?php echo $row['id']; ?>" style="<?php if ($_SERVER['QUERY_STRING'] == "") { ?>display: none; <?php } ?>font-size: 90%; padding: 0 0 0 10px;">
  <?php
  echo str_replace("\n", "<br>", $row['description']);
  
  echo "<div style=\"padding-top: 5px;\">\n";
    // Link to PDFs (if any)
    for ($i = 1; $i <= 5; $i++) {
      if (end(explode(".", $row['file' . $i])) == "pdf") {
        $document = file_get_contents("pdf/dissertations/" . $row['file' . $i]);
        $pdfauthor = (preg_match_all("/\/Author\((.*?)\)/",$document,$match)) ? end(end($match)) : "";
        $pdftitle = (preg_match_all("/\/Title\((.*?)\)/",$document,$match)) ? end(end($match)) : $row['file' . $i];
        $pdf = ($pdfauthor != "" && $pdftitle != $row['file' . $i]) ? $pdfauthor . ", <em>" . $pdftitle . "</em>" : "<em>" . $pdftitle . "</em>";
        
        echo "<a href=\"pdf/dissertations/" . $row['file' . $i] . "\"><img src=\"images/pdf.gif\" alt=\"PDF\"> View " . $pdf . "</a><br>\n";
      }
    }
  echo "</div>\n";
  ?>
</div><br>
<?php } ?>

<?php include "footer.php"; ?>