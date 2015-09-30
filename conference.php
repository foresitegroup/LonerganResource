<?php
include("inc/dbconfig.php");
require_once("inc/getid3/getid3/getid3.php");
$result = mysql_query("SELECT * FROM conference WHERE id = '" . $_SERVER['QUERY_STRING'] . "'");
$row = mysql_fetch_array($result);

$datestr = date("M d", $row['startdate']);
if (($row['enddate'] == "") || ($row['enddate'] == $row['startdate'])) {
  $datestr .= ", " . date("Y", $row['startdate']);
} else {
  if (date("Y", $row['startdate']) != date("Y", $row['enddate'])) { $datestr .= ", " . date("Y", $row['startdate']); }
  $datestr .= (date("M", $row['startdate']) == date("M", $row['enddate'])) ? "-" . date("d, Y", $row['enddate']) : "-" . date("M d, Y", $row['enddate']);
}

$PageTitle = $datestr . " - " . $row['title'];
include "header.php";
?>

<h1><?php echo $datestr . "<br>" . $row['title'] . "<br>" . $row['location']; ?></h1>

<?php
echo str_replace("\n", "<br>", $row['description']);

$result = mysql_query("SELECT * FROM contributors WHERE display = '' AND conference = '" . $_SERVER['QUERY_STRING'] . "' ORDER BY datetime ASC");
if (mysql_num_rows($result) > 0) {
  echo "<br><br>Available contributions from this conference:\n<ol>\n";

  mysql_data_seek($result, 0);

  while($row = mysql_fetch_array($result)) {
?>
    <li>
      <a href="javascript:toggle('<?php echo $row['id']; ?>')"><?php echo $row['name']; ?>, <em><?php echo $row['title']; ?></em></a>
      <div id="<?php echo $row['id']; ?>" style="display: none; font-size: 90%; padding: 0 0 15px 10px;">
        <?php
        echo str_replace("\n", "<br>", $row['abstract']);

        // Count MP3s and adjust playlist height accordingly
        $playlistheight = 0;
        $mp3 = "";
        for ($i = 1; $i <= 6; $i++) {
          if (end(explode(".", $row['file' . $i])) == "mp3") {
            $playlistheight = $playlistheight + 24;

            // Create download links while we're at it.  We'll display them after the playlist
            $getID3 = new getID3;
            $ThisFileInfo = $getID3->analyze("audio/contributors/" . $row['file' . $i]);
            $title = (@$ThisFileInfo['tags']['id3v2']['title'][0] != "") ? @$ThisFileInfo['tags']['id3v2']['title'][0] : $row['file' . $i];
            $mp3 .= "<a href=\"audio/contributors/" . $row['file' . $i] . "\"><img src=\"images/mp3.gif\" alt=\"MP3\"> Download <em>" . $title . "</em></a><br>\n";
          }
        }

        if (file_exists("audio/contributors/cont" .  $row['id'] . ".xml")) {
        ?>
        <div id="audio<?php echo $row['id']; ?>" style="padding-top: 10px;">You don't have Flash installed or your version is too old.  Please <a href="http://get.adobe.com/flashplayer/">download</a> a newer version.</div>
        <script type="text/javascript">
          var so = new SWFObject("inc/player.swf", "player", "560", "<?php echo 32 + $playlistheight; ?>", "9");
          so.addVariable("skin", "inc/playerskin.swf");
          so.addVariable("backcolor", "#4F4D4D");
          so.addVariable("playlist", "bottom");
          so.addVariable("playlistsize", "<?php echo $playlistheight; ?>");
          so.addVariable("playlistfile", "audio/contributors/cont<?php echo $row['id']; ?>.xml");
          so.write("audio<?php echo $row['id']; ?>");
        </script>
        <?php
        }

        echo "<div style=\"padding-top: 5px;\">\n";
          echo $mp3;

          // Link to PDFs (if any)
          for ($i = 1; $i <= 6; $i++) {
            if (end(explode(".", $row['file' . $i])) == "pdf") {
              $document = file_get_contents("pdf/contributors/" . $row['file' . $i]);
              $pdfauthor = (preg_match_all("/\/Author\((.*?)\)/",$document,$match)) ? end(end($match)) : "";
              $pdftitle = (preg_match_all("/\/Title\((.*?)\)/",$document,$match)) ? end(end($match)) : $row['file' . $i];
              $pdf = ($pdfauthor != "" && $pdftitle != $row['file' . $i]) ? $pdfauthor . ", <em>" . $pdftitle . "</em>" : "<em>" . $pdftitle . "</em>";

              echo "<br><a href=\"pdf/contributors/" . $row['file' . $i] . "\"><img src=\"images/pdf.gif\" alt=\"PDF\"> View " . $pdf . "</a>\n";
            }
          }
        echo "</div>\n";
        ?>
      </div>
    </li>
<?php
  }

  echo "</ol>\n";
}
?>

<?php include "footer.php"; ?>