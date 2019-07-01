<?php
include("inc/dbconfig.php");
require_once("inc/getid3/getid3/getid3.php");
$PageTitle = "Lectures";
include "header.php";
?>

<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link type="text/css" href="inc/jplayer/jplayer.lonergan.css" rel="stylesheet">
<script type="text/javascript" src="inc/jplayer/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="inc/jplayer/jplayer.playlist.min.js"></script>

<h1><?php echo $PageTitle; ?></h1>

<?php
if ($_SERVER['QUERY_STRING']) {
  $id = "WHERE id = '" . $_SERVER['QUERY_STRING'] . "'";
} else {
  $id = "WHERE display = ''";
}

$result = $mysqli->query("SELECT * FROM lectures $id ORDER BY name+0 ASC");
while($row = $result->fetch_array(MYSQLI_ASSOC)) {
?>

<?php if ($_SERVER['QUERY_STRING'] == "") { echo "<a href=\"javascript:toggle('" . $row['id'] . "')\">"; } ?>
<?php echo $row['name']; ?>, <em><?php echo $row['title']; ?></em>
<?php if ($_SERVER['QUERY_STRING'] == "") { echo "</a>"; } ?>

<div id="<?php echo $row['id']; ?>" style="<?php if ($_SERVER['QUERY_STRING'] == "") { ?>display: none; <?php } ?>font-size: 90%; padding: 0 0 0 10px;">
  <?php
  echo str_replace("\n", "<br>", $row['description']);
  
  // Create playlist and download links
  $playlist = "";
  $tracks = 0;
  $mp3 = "";
  for ($i = 1; $i <= 5; $i++) {
    $mext = explode(".", $row['file' . $i]);
    if (end($mext) == "mp3") {
      $getID3 = new getID3;
      $ThisFileInfo = $getID3->analyze("audio/lectures/" . $row['file' . $i]);

      $title = (@$ThisFileInfo['tags']['id3v2']['title'][0] != "") ? @$ThisFileInfo['tags']['id3v2']['title'][0] : $row['file' . $i];

      $length = gmdate("G:i:s", @$ThisFileInfo['playtime_seconds']);

      $playlist .= "{ title: \"" . htmlspecialchars($title) . "\", mp3: \"audio/lectures/" . $row['file' . $i] . "\", artist: \"" . $length . "\", free: true },\n";

      $tracks++;

      $mp3 .= "<a href=\"audio/lectures/" . $row['file' . $i] . "\"><img src=\"images/mp3.gif\" alt=\"MP3\"> Download <em>" . $title . "</em></a><br>\n";
    }
  }

  if ($playlist != "") {
  ?>
    
    <div id="jquery_jplayer_<?php echo $row['id']; ?>" class="jp-jplayer"></div>
    <div id="jp_container_<?php echo $row['id']; ?>" class="jp-audio" role="application">
      <div class="jp-controls-holder<?php if ($tracks == 1) echo " single"; ?>">
        <div class="jp-controls">
          <button class="jp-play" role="button"></button>
          <button class="jp-previous" role="button"></button>
          <button class="jp-next" role="button"></button>
        </div>
        <div class="jp-progress">
          <div class="jp-current-time" role="timer"></div>
          <div class="jp-seek-bar">
            <div class="jp-play-bar"></div>
          </div>
          <div class="jp-duration" role="timer"></div>
        </div>
        <div class="jp-volume-controls">
          <button class="jp-mute" role="button"></button>
          <div class="jp-volume-bar">
            <div class="jp-volume-bar-value"></div>
          </div>
        </div>
      </div>
      <div class="jp-playlist"><ul></ul></div>
    </div>

    <script type="text/javascript">
      $(document).ready(function(){
        new jPlayerPlaylist({ jPlayer: "#jquery_jplayer_<?php echo $row['id']; ?>", cssSelectorAncestor: "#jp_container_<?php echo $row['id']; ?>" },
          [ <?php echo $playlist; ?> ], {
          swfPath: "inc/jplayer", useStateClassSkin: true, autoBlur: false,
          smoothPlayBar: true, keyEnabled: true, remainingDuration: true
        });
        $.jPlayer.timeFormat.showHour = true;
      });
    </script>

  <?php
  }

  echo "<div style=\"padding-top: 5px;\">\n";
    // echo $mp3;
    if ($mp3 != "") { echo "<br>\n"; }
    
    // Link to PDFs (if any)
    for ($i = 1; $i <= 5; $i++) {
      $pext = explode(".", $row['file' . $i]);
      if (end($pext) == "pdf") {
        $document = file_get_contents("pdf/lectures/" . $row['file' . $i]);

        preg_match_all("/\/Author\((.*?)\)/",$document,$aarr);
        $aarr_last = end($aarr);
        $pdfauthor = end($aarr_last);

        preg_match_all("/\/Title\((.*?)\)/",$document,$tarr);
        $tarr_last = end($tarr);
        $pdftitle = end($tarr_last);
        if ($pdftitle == "") $pdftitle = $row['file' . $i];

        $pdf = ($pdfauthor != "" && $pdftitle != $row['file' . $i]) ? $pdfauthor . ", <em>" . $pdftitle . "</em>" : "<em>" . $pdftitle . "</em>";
        
        echo "<a href=\"pdf/lectures/" . $row['file' . $i] . "\"><img src=\"images/pdf.gif\" alt=\"PDF\"> View " . $pdf . "</a><br>\n";
      }
    }
  echo "</div>\n";
  ?>
</div><br>
<?php } ?>

<?php include "footer.php"; ?>