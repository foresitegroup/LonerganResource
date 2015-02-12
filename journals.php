<?php
include("inc/dbconfig.php");
$PageTitle = "Journals";
include "header.php";
?>

<h1><?php echo $PageTitle; ?></h1>

We are proud to make available the back issues of two major Lonergan journals: <em>Method: Journal of Lonergan Studies</em> and <em>Lonergan Workshop</em>. The journals are available in the form of entire issues, but at some point we will make available downloadable single articles as well.<br>
<br>
A Table of Contents is provided with each issue. Click on the issue you are interested in, and the Table of Contents for that issue will appear.<br>
<br>
We are grateful to Mark Morelli and Fred Lawrence for allowing us to upload these back issues.<br>
<br>

<?php
function Journals($result) {
  while($row = mysql_fetch_array($result)) {
  ?>
  
  <a href="javascript:toggle('<?php echo $row['id']; ?>')">
  <em><?php echo $row['title']; ?></em>
  <?php
  if ($row['volume'] != "" || $row['number'] != "") {
    echo ",";
    if ($row['volume'] != "") echo " Vol. " . $row['volume'];
    if ($row['volume'] != "" && $row['number'] != "") echo ",";
    if ($row['number'] != "") echo " No. " . $row['number'];
  }
  ?>
  </a>
  
  <div id="<?php echo $row['id']; ?>" style="display: none; font-size: 90%; padding: 0 0 0 10px;">
    <?php
    echo str_replace("\n", "<br>", $row['description']);
    
    echo "<div style=\"padding-top: 5px;\">\n";
      // Link to PDFs (if any)
      for ($i = 1; $i <= 5; $i++) {
        if (end(explode(".", $row['file' . $i])) == "pdf") {
          $document = file_get_contents("pdf/journals/" . $row['file' . $i]);
          $pdfauthor = (preg_match_all("/\/Author\((.*?)\)/",$document,$match)) ? end(end($match)) : "";
          $pdftitle = (preg_match_all("/\/Title\((.*?)\)/",$document,$match)) ? end(end($match)) : $row['file' . $i];
          $pdf = ($pdfauthor != "" && $pdftitle != $row['file' . $i]) ? $pdfauthor . ", <em>" . $pdftitle . "</em>" : "<em>" . $pdftitle . "</em>";
          
          echo "<a href=\"pdf/journals/" . $row['file' . $i] . "\"><img src=\"images/pdf.gif\" alt=\"PDF\"> View " . $pdf . "</a><br>\n";
        }
      }
    echo "</div>\n";
    ?>
  </div><br>
  <?php
  }
}

$result = mysql_query("SELECT * FROM journaltitles,journals WHERE journals.titleid = '1' AND journaltitles.id = journals.titleid ORDER BY title, volume+0, number+0 ASC");
Journals($result); // Method

echo "<br>\n";

$result = mysql_query("SELECT * FROM journaltitles,journals WHERE journals.titleid = '2' AND journaltitles.id = journals.titleid ORDER BY title, volume+0, number+0 ASC");
Journals($result); // Lonergan Workshop
?>

<?php include "footer.php"; ?>