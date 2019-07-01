<?php
include("inc/dbconfig.php");
$PageTitle = "Dissertations";
include "header.php";
?>

<h1><?php echo $PageTitle; ?></h1>

<?php
$query = ($_SERVER['QUERY_STRING']) ? "SELECT * FROM dissertations WHERE id = '" . $_SERVER['QUERY_STRING'] . "'" : "SELECT * FROM dissertations WHERE display = '' ORDER BY name ASC";
$result = $mysqli->query($query);
while($row = $result->fetch_array(MYSQLI_ASSOC)) {
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
      if (isset($row['file' . $i])) {
        $pext = explode(".", $row['file' . $i]);
        if (end($pext) == "pdf") {
          $document = file_get_contents("pdf/dissertations/" . $row['file' . $i]);

          preg_match_all("/\/Author\((.*?)\)/",$document,$aarr);
          $aarr_last = end($aarr);
          $pdfauthor = end($aarr_last);

          preg_match_all("/\/Title\((.*?)\)/",$document,$tarr);
          $tarr_last = end($tarr);
          $pdftitle = end($tarr_last);
          if ($pdftitle == "") $pdftitle = $row['file' . $i];

          $pdf = ($pdfauthor != "" && $pdftitle != $row['file' . $i]) ? $pdfauthor . ", <em>" . $pdftitle . "</em>" : "<em>" . $pdftitle . "</em>";
          
          echo "<a href=\"pdf/dissertations/" . $row['file' . $i] . "\"><img src=\"images/pdf.gif\" alt=\"PDF\"> View " . $pdf . "</a><br>\n";
        }
      }
    }
  echo "</div>\n";
  ?>
</div><br>
<?php } ?>

<?php include "footer.php"; ?>