<?php
include("inc/dbconfig.php");
require_once("inc/getid3/getid3/getid3.php");
$PageTitle = "Lectures";
include "header.php";
?>

<h1><?php echo $PageTitle; ?></h1>

<?php
if ($_SERVER['QUERY_STRING']) { $id = "WHERE id = '" . $_SERVER['QUERY_STRING'] . "'"; }
$result = mysql_query("SELECT * FROM lectures $id ORDER BY name+0 ASC");
while($row = mysql_fetch_array($result)) {
?>

<?php if ($_SERVER['QUERY_STRING'] == "") { echo "<a href=\"javascript:toggle('" . $row['id'] . "')\">"; } ?>
<?php echo $row['name']; ?>, <em><?php echo $row['title']; ?></em>
<?php if ($_SERVER['QUERY_STRING'] == "") { echo "</a>"; } ?>

<div id="<?php echo $row['id']; ?>" style="<?php if ($_SERVER['QUERY_STRING'] == "") { ?>display: none; <?php } ?>font-size: 90%; padding: 0 0 0 10px;">
  <?php
  echo str_replace("\n", "<br>", $row['description']);
  
  // Count MP3s and adjust playlist height accordingly
  $playlistheight = 0;
  $mp3 = "";
  for ($i = 1; $i <= 5; $i++) {
    if (end(explode(".", $row['file' . $i])) == "mp3") {
      $playlistheight = $playlistheight + 24;
      
      // Create download links while we're at it.  We'll display them after the playlist
      $getID3 = new getID3;
      $ThisFileInfo = $getID3->analyze("audio/lectures/" . $row['file' . $i]);
      $title = (@$ThisFileInfo['tags']['id3v2']['title'][0] != "") ? @$ThisFileInfo['tags']['id3v2']['title'][0] : $row['file' . $i];
      $mp3 .= "<a href=\"audio/lectures/" . $row['file' . $i] . "\"><img src=\"images/mp3.gif\" alt=\"MP3\"> Download <em>" . $title . "</em></a><br>\n";
    }
  }
  
  if (file_exists("audio/lectures/lect" .  $row['id'] . ".xml")) {
  ?>
  <div id="audio<?php echo $row['id']; ?>" style="padding-top: 10px;">You don't have Flash installed or your version is too old.  Please <a href="http://get.adobe.com/flashplayer/">download</a> a newer version.</div>
  <script type="text/javascript">
    var so = new SWFObject("inc/player.swf", "player", "590", "<?php echo 32 + $playlistheight; ?>", "9");
    so.addVariable("skin", "inc/playerskin.swf");
    so.addVariable("backcolor", "#4F4D4D");
    so.addVariable("playlist", "bottom");
    so.addVariable("playlistsize", "<?php echo $playlistheight; ?>");
    so.addVariable("playlistfile", "audio/lectures/lect<?php echo $row['id']; ?>.xml");
    so.write("audio<?php echo $row['id']; ?>");
  </script>
  <?php
  }
  
  echo "<div style=\"padding-top: 5px;\">\n";
    echo $mp3;
    if ($mp3 != "") { echo "<br>\n"; }
    
    // Link to PDFs (if any)
    for ($i = 1; $i <= 5; $i++) {
      if (end(explode(".", $row['file' . $i])) == "pdf") {
        $document = file_get_contents("pdf/lectures/" . $row['file' . $i]);
        $pdfauthor = (preg_match_all("/\/Author\((.*?)\)/",$document,$match)) ? end(end($match)) : "";
        $pdftitle = (preg_match_all("/\/Title\((.*?)\)/",$document,$match)) ? end(end($match)) : $row['file' . $i];
        $pdf = ($pdfauthor != "" && $pdftitle != $row['file' . $i]) ? $pdfauthor . ", <em>" . $pdftitle . "</em>" : "<em>" . $pdftitle . "</em>";
        
        echo "<a href=\"pdf/lectures/" . $row['file' . $i] . "\"><img src=\"images/pdf.gif\" alt=\"PDF\"> View " . $pdf . "</a><br>\n";
      }
    }
  echo "</div>\n";
  ?>
</div><br>
<?php } ?>

<?php include "footer.php"; ?>